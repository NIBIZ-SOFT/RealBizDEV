<?php
// Retrieve settings
$Settings = SQL_Select("Settings", "SettingsID = 1", "", true);
$_POST["FromDate"] = 20-11-2024;
$_POST["ToDate"] = date('Y-m-d') ;
$FromDate = $_POST["FromDate"];
$ToDate = $_POST["ToDate"];






if (!empty($FromDate) && !empty($ToDate)) {
    $Projects = SQL_Select("category");

    foreach ($Projects as $Project) {
        // Get all transactions for the current project
        $transactions = SQL_Select("transaction WHERE ProjectID = {$Project["CategoryID"]} and Date BETWEEN '{$FromDate}' AND '{$ToDate}'");
        //$transactions = SQL_Select("transaction WHERE ProjectID = {$Project["CategoryID"]} ");

        $subDrTotal = 0;
        $subCrTotal = 0;

        if (!empty($transactions)) {
            $uniqueHeadOfAccountIds = [];
            $groupedTransactions = [];

            // Group transactions by HeadOfAccountID
            foreach ($transactions as $transaction) {
                $uniqueHeadOfAccountIds[$transaction["HeadOfAccountID"]] = $transaction["HeadOfAccountID"];
            }

            // Loop through each unique HeadOfAccountID and group transactions by their parent (IncomeExpenseType)
            foreach ($uniqueHeadOfAccountIds as $uniqueHeadOfAccountId) {
                if (empty($uniqueHeadOfAccountId)) continue;

                // Get transactions for each unique HeadOfAccount
                $UniqueTransactionHeadOfAccaunts = SQL_Select("transaction WHERE HeadOfAccountID = {$uniqueHeadOfAccountId} AND ProjectID = {$Project["CategoryID"]}  and Date BETWEEN '{$FromDate}' AND '{$ToDate}'" );

                // Get HeadOfType and HeadOfAccount details
                $HeadOfAccountID = $UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountID"];
                $HeadOfTypefind = SQL_Select("expensehead", "ExpenseHeadID = '{$HeadOfAccountID}'");
                $HeadOfTypeId = $HeadOfTypefind[0]["IncomeExpenseTypeID"];
                $HeadOfTypeName = SQL_Select("incomeexpensetype", "IncomeExpenseTypeID = '{$HeadOfTypeId}'")[0]["GLCode"];

                // Initialize the parent group if not set
                if (!isset($groupedTransactions[$HeadOfTypeName])) {
                    $groupedTransactions[$HeadOfTypeName] = [
                        'drTotal' => 0,
                        'crTotal' => 0,
                        'children' => []
                    ];
                }

                // Calculate DR/CR amounts for the current HeadOfAccount
                $balanceDr = 0;
                $balanceCr = 0;
                foreach ($UniqueTransactionHeadOfAccaunts as $UniqueTransactionHeadOfAccaunt) {
                    $balanceDr += $UniqueTransactionHeadOfAccaunt["dr"];
                }

                // Accumulate DR/CR into the parent totals
                $groupedTransactions[$HeadOfTypeName]['drTotal'] += $balanceDr;

                // Add child record (HeadOfAccount) under the parent
                $groupedTransactions[$HeadOfTypeName]['children'][] = [
                    'HeadOfAccountName' => $UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountName"],
                    'HeadOfAccountID' => $UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountID"],
                    'balanceDr' => $balanceDr,
                ];
            }

            // Generate HTML for the grouped transactions
            $trHtml = '';
            $trHtml2 = '';

            $trHtml2 .= '
                    <tr class="parent-head">
                    <th>1000</th>
                        <th colspan="" rowspan="' . $childsl . '" class="text-left" style="background-color: #f1f1f1; font-weight: bold;">Current Assets</th>
                        <th class="text-right" style="background-color: #f1f1f1; font-weight: bold;">0</th>
                    </tr>';

            $sl = 1;
            $childsl = 1;

            //Bank And Cash
            $BankCashes=SQL_Select("bankcash");
            $bankCashName="";
            $totalBankCashBalance=0;
            foreach ($BankCashes as $BankCash){

                $TransactionInfos=SQL_Select("transaction WHERE BankCashID = {$BankCash["BankCashID"]} and Date BETWEEN '{$FromDate}' AND '{$ToDate}'");

                $drAmount=0;
                $crAmount=0;

                $bankCashName=$BankCash["AccountTitle"];

                foreach ($TransactionInfos as $TransactionInfo){

                    if ($TransactionInfo["dr"] > 0 ){
                        $drAmount +=$TransactionInfo["dr"];
                    }else{
                        $crAmount +=$TransactionInfo["cr"];

                    }

                }

                $balance = $crAmount - $drAmount;
                //$totalBankCashBalance +=$balance;
//                $subDrTotal += $drAmount;
                $subDrTotal += $balance;
//                $subCrTotal += $crAmount;
                if($balance>0)
                    $trHtml2 .= '
                            <tr>
                                <td>'.$BankCash["GLCode"].'</td>
                                <td>'.$bankCashName.'</td>
                                <td class="text-right">'.BangladeshiCurencyFormat($balance).'</td>
                            </tr>';


            }
// end Bank And Cash









            foreach ($groupedTransactions as $HeadOfTypeName => $data) {
                // Fetch the GLCode for the HeadOfTypeName
                $HeadOfTypeGlCode = SQL_Select("incomeexpensetype", "GLCode = '{$HeadOfTypeName}'", "", true);

                if($data['drTotal']>0 and $data['crTotal']>0){
                    $data['crTotal'] = $data['crTotal'] - $data['drTotal'];
                }

                $trHtml .= '
                    <tr class="parent-head">
                        <th colspan="1" rowspan="' . $childsl . '" class="text-left" style="background-color: #f1f1f1; font-weight: bold;">' . $HeadOfTypeName . '</th>
                        <th>'.$HeadOfTypeGlCode["Name"].'</th>
                        <th class="text-right" style="background-color: #f1f1f1; font-weight: bold;">' . BangladeshiCurencyFormat($data['drTotal']) . '</th>
                    </tr>';

                foreach ($data['children'] as $child) {
                    // Fetch the HeadOfAccount name
                    $HeadACName = SQL_Select("expensehead", "ExpenseHeadID = '{$child["HeadOfAccountID"]}'");

                    if($child['balanceDr']>0 and $child['balanceCr']>0) {
                        $child['balanceCr'] = $child['balanceCr'] - $child['balanceDr'];
                    }

                    $trHtml .= '
                        <tr>
                            <td>'.$HeadACName[0]['GLCode'].'</td>
                            <td>'. $child["HeadOfAccountName"] . '</td>
                            <td class="text-right">' . BangladeshiCurencyFormat($child["balanceDr"]) . '</td>
                        </tr>';
                }

                $subDrTotal += $data['drTotal'];


            }

            // Optionally, if you need to accumulate totals for the entire project

//            foreach ($groupedTransactions as $data) {
//                $subDrTotal += $data['drTotal'];
//                $subCrTotal += $data['crTotal'];
//            }

            // Optionally, add a row for the overall total (if required)
            $trHtml .= '
                <tr class="grand-total">
                    <th colspan="2" class="text-left" style="background-color: #e1e1e1; font-weight: bold;">Total</th>
                    <th class="text-right" style="background-color: #e1e1e1; font-weight: bold;">' . BangladeshiCurencyFormat($subDrTotal) . '</th>
                </tr>';

            // Append the project table HTML
            $projectHtml .= '
                <table class="table table-bordered table-hover table-sm">
                    <thead>
                        <tr>
                            <th class="text-center" colspan="6">' . $Project["Name"] . '</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th class="text-center" width="20px">GL Code</th>
                            <th class="text-center">Head Of Type And Account</th>
                            <th colspan="2" class="text-center">Dr. / Cr. (From ' . $FromDate . ' to ' . $ToDate . ')</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th class="text-right" width="200px">Dr. Tk</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' .$trHtml2. $trHtml . '
                    </tbody>
                </table>';

            // Accumulate total amounts
            $totalDrAmount += $subDrTotal;
            $totalCrAmount += $subCrTotal;
        }
    }
}

$MainContent .= '
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Trial Balance</title>
    <style>
        .m-b-30{ margin-bottom: 30px; }
        .m-t-30{ margin-top: 30px; }
        .table-bordered th, .table-bordered td { border: 1px solid rgba(0,0,0,.3) !important; }
        .company-name{ border-bottom: 1px solid rgba(0,0,0,.3); }
    </style>
</head>
<body>
    <div style="width: 95%; margin: auto">
        <p style="font-size: 16px">Printing Date & Time: ' . date('F j-y, h:i:sa') . '</p>
    </div>
    <div style="width: 95%; margin: auto">
        <div style="padding: 10px 0px" class="company-name row">
            <div class="col-md-2 text-center">
                <img style="width: 70px;" src="./upload/' . $Settings["logo"] . '" alt="">
            </div>
            <div class="col-md-9 text-center">
                <h3 style="font-weight: bold">' . $Settings["CompanyName"] . '</h3>
                <p style="font-size: 18px;">' . $Settings["Address"] . '</p>
            </div>
        </div>
        <div class="projectName text-center m-b-30 m-t-30">
            <h4 style="font-weight: bold">Statement of Affairs</h4>
        </div>  
        ' . $projectHtml . '
        <table class="table table-bordered table-hover table-fixed table-sm">
            <thead>
                <tr>
                    <th class="text-right" scope="col">Total Amount=</th>
                    <th class="text-right" width="200px" scope="col">' . BangladeshiCurencyFormat($totalDrAmount) . '</th>
                </tr>
            </thead>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
';

?>
