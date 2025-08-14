<?php
// Retrieve settings
$Settings = SQL_Select("Settings", "SettingsID = 1", "", true);

$FromDate = $_POST["FromDate"];
$ToDate = $_POST["ToDate"];
$CategoryID = $_POST["CategoryID"];





if (!empty($FromDate) && !empty($ToDate)) {


    if (!empty($CategoryID)) {
        $Projects = SQL_Select("category","CategoryID={$CategoryID}");
    }else{
        $Projects = SQL_Select("category");
    }

    $projectHtml = ''; // Initialize outside the loop
    $totalDrAmount = 0;
    $totalCrAmount = 0;

    foreach ($Projects as $Project) {
        // Get all transactions for the current project
        $transactions = SQL_Select("transaction","voucherType != 'JV' and ProjectID = {$Project["CategoryID"]} and Date BETWEEN '{$FromDate}' AND '{$ToDate}'");
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
                $UniqueTransactionHeadOfAccaunts = SQL_Select("transaction WHERE voucherType != 'JV' and HeadOfAccountID = {$uniqueHeadOfAccountId} AND ProjectID = {$Project["CategoryID"]}  and Date BETWEEN '{$FromDate}' AND '{$ToDate}'" );

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
                    $balanceCr += $UniqueTransactionHeadOfAccaunt["cr"];
                }

                // Accumulate DR/CR into the parent totals
                $groupedTransactions[$HeadOfTypeName]['drTotal'] += $balanceDr;
                $groupedTransactions[$HeadOfTypeName]['crTotal'] += $balanceCr;

                // Add child record (HeadOfAccount) under the parent
                $groupedTransactions[$HeadOfTypeName]['children'][] = [
                    'HeadOfAccountName' => $UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountName"],
                    'HeadOfAccountID' => $UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountID"],
                    'balanceDr' => $balanceDr,
                    'balanceCr' => $balanceCr,
                    'GLCode' => SQL_Select("expensehead", "ExpenseHeadID = '{$UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountID"]}'")[0]["GLCode"] //ADDED THIS LINE
                ];
            }

            // Generate HTML for the grouped transactions
            $trHtml = '';
            $trHtml2 = '';





            $sl = 2;
            $childsl = 1;

            //Bank And Cash
            $BankCashes=SQL_Select("bankcash","1=1","GLCode ASC"); //ADDED ASC
            $bankCashName="";
            $totalBankCashBalance=0;
            $bankCashData = []; //ADDED THIS LINE

            foreach ($BankCashes as $BankCash){

                $TransactionInfos=SQL_Select("transaction WHERE voucherType != 'JV' and BankCashID = {$BankCash["BankCashID"]}  and ProjectID = {$Project["CategoryID"]} and Date BETWEEN '{$FromDate}' AND '{$ToDate}'");

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

//                if ($crAmount > $drAmount) {
                $balance = $crAmount - $drAmount;
//                } elseif ($drAmount > $crAmount) {
//                    $balance = $drAmount - $crAmount;
//                } else {
//                    $balance = 0;
//                }
                //$totalBankCashBalance +=$balance;
//                $subDrTotal += $drAmount;
                $subDrTotal += $balance;
//                $subCrTotal += $balance;
                if($balance){
                    $bankCashData[] = [
                        'GLCode' => $BankCash["GLCode"],
                        'AccountTitle' => $bankCashName,
                        'crAmount' => $crAmount,
                        'drAmount' => $drAmount,
                        'Balance' => $balance,
                        'bid' => $BankCash["BankCashID"]
                    ];
                }
            }





            $totalBankCashBalancex = 0; // Initialize total balance

            foreach ($bankCashData as $datax) {
                $totalBankCashBalancex += $datax["Balance"]; // Accumulate the balance
            }
            $trHtml2 .= '
    <tr class="parent-head">
         <th class="text-center" scope="row">1</th>

         <th colspan="2" class="text-left" style="background-color: #f1f1f1; font-weight: bold;">1000 - Current Assets</th>
        <th class="text-right" style="background-color: #f1f1f1; font-weight: bold;">' . BangladeshiCurencyFormat($totalBankCashBalancex) . '</th>
        <th class="text-right" style="background-color: #f1f1f1; font-weight: bold;">0</th>
    </tr>';




            foreach($bankCashData as $data){  //ADDED THIS LOOP
                $trHtml2 .= '
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>'.$data["GLCode"].'-'.$data["AccountTitle"].'</td>
                                    <td class="text-right">'.BangladeshiCurencyFormat($data["Balance"]).'</td>
                                                                        <td class="text-right">0</td>
                                </tr>';
            }
// end Bank And Cash









            foreach ($groupedTransactions as $HeadOfTypeName => $data) {
                // Fetch the GLCode for the HeadOfTypeName
                $HeadOfTypeGlCode = SQL_Select("incomeexpensetype", "GLCode = '{$HeadOfTypeName}'", "", true);
                $HeadOfTypeNameValue = isset($HeadOfTypeGlCode["Name"]) ? $HeadOfTypeGlCode["Name"] : '';

                // if ($data['drTotal'] > 0 && $data['crTotal'] > 0) {
                //     $diff = $data['crTotal'] - $data['drTotal'];

                //     if ($diff > 0) {
                //         $data['crTotal'] = $diff;
                //         $data['drTotal'] = 0;
                //     } elseif ($diff < 0) {
                //         $data['drTotal'] = abs($diff);
                //         $data['crTotal'] = 0;
                //     } else {
                //         $data['drTotal'] = 0;
                //         $data['crTotal'] = 0;
                //     }
                // }


                // Sort the children array by GLCode in ascending order.
                if(isset($data['children']) && is_array($data['children'])){
                    usort($data['children'], function ($a, $b) {
                        return strcmp($a['GLCode'], $b['GLCode']);
                    });
                }

                $trHtml .= '
                    <tr class="parent-head">
                        <th class="text-center" scope="row">' . $sl++ . '</th>
                        <th colspan="2" rowspan="' . $childsl . '" class="text-left" style="background-color: #f1f1f1; font-weight: bold;">' . $HeadOfTypeName . ' - ' . $HeadOfTypeGlCode["Name"] . '</th>
                        <th class="text-right" style="background-color: #f1f1f1; font-weight: bold;">' . BangladeshiCurencyFormat($data['drTotal']) . '</th>
                        <th class="text-right" style="background-color: #f1f1f1; font-weight: bold;">' . BangladeshiCurencyFormat($data['crTotal']) . '</th>
                    </tr>';

                foreach ($data['children'] as $child) {
                    // Fetch the HeadOfAccount name
                    $HeadACName = SQL_Select("expensehead", "ExpenseHeadID = '{$child["HeadOfAccountID"]}'");
                    $HeadOfAccountNameValue = isset($HeadACName[0]["HeadOfAccountName"]) ? $HeadACName[0]["HeadOfAccountName"] : '';

                    if ($child['balanceDr'] > 0 && $child['balanceCr'] > 0) {
                        if ($child['balanceDr'] > $child['balanceCr']) {
                            $child['balanceDr'] -= $child['balanceCr'];
                            $child['balanceCr'] = 0;
                        } elseif ($child['balanceCr'] > $child['balanceDr']) {
                            $child['balanceCr'] -= $child['balanceDr'];
                            $child['balanceDr'] = 0;
                        } else {
                            $child['balanceDr'] = 0;
                            $child['balanceCr'] = 0;
                        }
                    }



                    $trHtml .= '
                        <tr>
                            <td></td>
                            <td></td>
                            <td>' . $HeadACName[0]['GLCode'] . '-' . GetExpenseHeadName($child["HeadOfAccountID"]) . '</td>
                            <td class="text-right">' . BangladeshiCurencyFormat($child["balanceDr"]) . '</td>
                            <td class="text-right">' . BangladeshiCurencyFormat($child["balanceCr"]) . '</td>
                        </tr>';
                }

                $subDrTotal += $data['drTotal'];
                $subCrTotal += $data['crTotal'];


            }

            // Optionally, if you need to accumulate totals for the entire project

//            foreach ($groupedTransactions as $data) {
//                $subDrTotal += $data['drTotal'];
//                $subCrTotal += $data['crTotal'];
//            }

            // Optionally, add a row for the overall total (if required)
            $trHtml .= '
                <tr class="grand-total">
                    <th colspan="3" class="text-left" style="background-color: #e1e1e1; font-weight: bold;">Total</th>
                    <th class="text-right" style="background-color: #e1e1e1; font-weight: bold;">' . BangladeshiCurencyFormat($subDrTotal) . '</th>
                    <th class="text-right" style="background-color: #e1e1e1; font-weight: bold;">' . BangladeshiCurencyFormat($subCrTotal) . '</th>
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
                            <th class="text-center" width="20px">Serial No.</th>
                            <th class="text-center">Head Of Type</th>
                            <th class="text-center">Head Of Account</th>
                            <th colspan="2" class="text-center">Dr. / Cr. (From ' . $FromDate . ' to ' . $ToDate . ')</th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-right" width="200px">Dr. Tk</th>
                            <th class="text-right" width="200px">Cr. Tk</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $trHtml2 . $trHtml . '
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
            <h4 style="font-weight: bold">Trial Balance</h4>
        </div>
        ' . $projectHtml . '
        <table class="table table-bordered table-hover table-fixed table-sm">
            <thead>
                <tr>
                    <th class="text-right" scope="col">Total Amount=</th>
                    <th class="text-right" width="200px" scope="col">' . BangladeshiCurencyFormat($totalDrAmount) . '</th>
                    <th class="text-right" width="200px" scope="col">' . BangladeshiCurencyFormat($totalCrAmount) . '</th>
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