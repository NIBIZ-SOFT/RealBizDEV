<?php
//$_POST["ToDate"] = '2030-01-01';
//$_POST["FromDate"] = '2000-01-01';
//
//$_POST["secondToDate"] = '2030-01-01';
//$_POST["secondFromDate"] = '2000-01-01';
//$_POST["CategoryID"] = 119;
$Settings = SQL_Select("Settings", "SettingsID=1", "", true);
$Trx_start = mysql_query("SELECT MIN(`Date`) AS StartDate FROM `tbltransaction`");
if (
    !empty($_POST["FromDate"]) &&
    !empty($_POST["ToDate"]) &&
    !empty($_POST["secondFromDate"]) &&
    !empty($_POST["secondToDate"])
) {
    $from1 = $_POST["FromDate"];
    $to1 = $_POST["ToDate"];
    $from2 = $_POST["secondFromDate"];
    $to2 = $_POST["secondToDate"];

    if ($from1 > $from2 || $to1 > $to2) {
        echo "<script>
                alert('Please make sure the first date range is before the second date range.');
                window.history.back();
              </script>";
        exit;
    }
}


if (empty($_POST["FromDate"])) {
    $_POST["FromDate"] = '2025-03-01';
}
//if ($_POST["FromDate"] < '2025-03-01') {
//    echo "<script>
//            alert('তারিখ ২০২৫-০৩-০১ এর চেয়ে বড় হতে হবে');
//            window.history.back(); // ইউজারকে আগের পেজে ফেরত পাঠাবে
//        </script>";
//    exit;
//}


$CategoryID = $_POST["CategoryID"];
$FromDate = $_POST["FromDate"];
$ToDate = $_POST["ToDate"];
$secondFromDate = $_POST["secondFromDate"];
$secondToDate = $_POST["secondToDate"];

// Get start date from DB if available
$row = @mysql_fetch_array($Trx_start, MYSQL_ASSOC);
$startD = isset($row['StartDate']) ? $row['StartDate'] : $FromDate;

// Step 0: Calculate opening balance before FromDate
$OpeningCR = 0;
$OpeningDR = 0;

// Use transactions before $FromDate (not including FromDate itself)
$OCR = SQL_Select("transaction", "ProjectID='{$CategoryID}' AND VoucherType='CV' AND Date < '{$FromDate}'", "");
$ODR = SQL_Select("transaction", "ProjectID='{$CategoryID}' AND VoucherType='DV' AND Date < '{$FromDate}'", "");

if (is_array($OCR)) {
    foreach ($OCR as $ThisOCR) {
        $OpeningCR += $ThisOCR["cr"];
    }
}
if (is_array($ODR)) {
    foreach ($ODR as $ThisODR) {
        $OpeningDR += $ThisODR["dr"];
    }
}

$OpeningBalance = $OpeningCR - $OpeningDR;

// Clean previous records
SQL_Delete("OpeningBalance");

// Loop from FromDate to secondToDate
$currentDate = $FromDate;

while (strtotime($currentDate) <= strtotime($secondToDate)) {
    $RangeCR = 0;
    $RangeDR = 0;

    // Step 1: Calculate today's Credit and Debit
    $CR = SQL_Select("transaction", "ProjectID='{$CategoryID}' AND VoucherType='CV' AND Date = '{$currentDate}'", "");
    $DR = SQL_Select("transaction", "ProjectID='{$CategoryID}' AND VoucherType='DV' AND Date = '{$currentDate}'", "");



    if (is_array($CR)) {
        foreach ($CR as $ThisCR) {
            $RangeCR += $ThisCR["cr"];
        }
    }

    if (is_array($DR)) {
        foreach ($DR as $ThisDR) {
            $RangeDR += $ThisDR["dr"];
        }
    }

    // Step 2: Calculate Closing Balance
    $ClosingBalance = $OpeningBalance + $RangeCR - $RangeDR;
//print_r($OpeningBalance.'-'.$RangeDR.'-'.$RangeCR.'-'.$currentDate);
//echo "<br>";
    // Step 3: Insert into OpeningBalance Table
    SQL_InsertUpdate("OpeningBalance", array(
        "Date" => $currentDate,
        "FromDate" => $currentDate,
        "ToDate" => $currentDate,
        "ProjectID" => $CategoryID,
        "OpeningBalance" => $OpeningBalance,
        "ClosingBalance" => $ClosingBalance
    ), "");

    // Step 4: Prepare for next day
    $OpeningBalance = $ClosingBalance;
    $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
}


$opt = SQL_Select("OpeningBalance");
$op = SQL_Select("OpeningBalance", "FromDate = '{$FromDate}'");
$op2 = SQL_Select("OpeningBalance", "FromDate = '{$secondFromDate}'");

$CB = SQL_Select("OpeningBalance", "date = '{$ToDate}'");
$CB2 = SQL_Select("OpeningBalance", "date = '{$secondToDate}'");


if ($op2[0]['OpeningBalance']==0 && !$FromDate==$secondFromDate) {
    $op2[0]['OpeningBalance'] = $op[0]['ClosingBalance'];
}




// if (!empty($opt)) {
//     echo "<table border='1' cellpadding='6' cellspacing='0'>";

//     // হেডার অংশ (keys from first row)
//     echo "<tr>";
//     foreach (array_keys($opt[0]) as $column) {
//         echo "<th>" . htmlspecialchars($column) . "</th>";
//     }
//     echo "</tr>";

//     // ডেটা রো গুলো
//     foreach ($opt as $row) {
//         echo "<tr>";
//         foreach ($row as $cell) {
//             echo "<td>" . htmlspecialchars($cell) . "</td>";
//         }
//         echo "</tr>";
//     }

//     echo "</table>";
// } else {
//     echo "⚠️ কোনো ডেটা পাওয়া যায়নি।";
// }
 //End Opening Balance



$displayFromDate = ($FromDate == '2025-03-01') ? 'UpTo' : $FromDate;

$projectHtmldr = '';
$projectHtmlcr = '';

$closingdr = '';
$closingcr = '';
$BankAndCashOtherCR = '';

if (!empty($_POST["CategoryID"]) && !empty($FromDate) && !empty($ToDate)) {
    $transactions = SQL_Select("transaction where ProjectID={$_POST["CategoryID"]} and Date BETWEEN '{$FromDate}' AND '{$ToDate}'");
    $secondtransactions = SQL_Select("transaction where ProjectID={$_POST["CategoryID"]} and Date BETWEEN '{$secondFromDate}' AND '{$secondToDate}'");
//    print_r($secondtransactions);

    $secondtotalDrAmount = 0;
    $secondtotalCrAmount = 0;
    $secondsubDrTotal = 0;
    $secondsubCrTotal = 0;
    $secondTotalsubDrTotal = 0;

    $seconduniqueHeadOfAccountIds = array();
    if (!empty($secondtransactions)) {
        foreach ($secondtransactions as $secondtransaction) {
            $seconduniqueHeadOfAccountIds[$secondtransaction["HeadOfAccountID"]] = $secondtransaction["HeadOfAccountID"];
        }
    }

    $secondAmountList = array();
    $secondHeadIDList = array();
    foreach ($seconduniqueHeadOfAccountIds as $seconduniqueHeadOfAccountId) {
        if (empty($seconduniqueHeadOfAccountId)) continue;

        $secondUniqueTransactionHeadOfAccounts = SQL_Select("transaction where HeadOfAccountID={$seconduniqueHeadOfAccountId} and ProjectID={$_POST["CategoryID"]} and Date BETWEEN '{$secondFromDate}' AND '{$secondToDate}'");

        if (empty($secondUniqueTransactionHeadOfAccounts)) continue;

        $HeadTypeData = SQL_Select("expensehead", "ExpenseHeadID='{$seconduniqueHeadOfAccountId}'");
        $HeadType = $HeadTypeData[0]["ExpenseHeadIsType"];

        $secondbalance = 0;

        if ($seconduniqueHeadOfAccountId == 2450) continue;

        if ($HeadType == 1) {
            foreach ($secondUniqueTransactionHeadOfAccounts as $row) {
                $secondbalance += $row["dr"] - $row["cr"];
            }
            if ($secondbalance <= 0) continue;
            $secondsubDrTotal += $secondbalance;
            $secondTotalsubDrTotal += $secondbalance;
        } else {
            foreach ($secondUniqueTransactionHeadOfAccounts as $row) {
                $secondbalance += $row["cr"] - $row["dr"];
            }
            if ($secondbalance <= 0) continue;
            $secondsubCrTotal += $secondbalance;
        }

        $secondAmountList[$seconduniqueHeadOfAccountId] = $secondbalance;
        $secondHeadIDList[$seconduniqueHeadOfAccountId] = $row["HeadOfAccountName"];
    }

    // Main table
    $subDrTotal = 0;
    $subCrTotal = 0;
    $TotalsubDrTotal = 0;


    $uniqueHeadOfAccountIds = array();
    foreach ($transactions as $transaction) {
        $uniqueHeadOfAccountIds[$transaction["HeadOfAccountID"]] = $transaction["HeadOfAccountID"];
    }

    $trHtmldr = '';
    $trHtmlcr = '';
    $sl = 1;
    $sldr = 1;
    $uniqueHeadOfAccountIds = $uniqueHeadOfAccountIds + $seconduniqueHeadOfAccountIds;
    foreach ($uniqueHeadOfAccountIds as $uniqueHeadOfAccountId) {
        if (empty($uniqueHeadOfAccountId)) continue;

        $UniqueTransactionHeadOfAccounts = SQL_Select("transaction where HeadOfAccountID={$uniqueHeadOfAccountId} and ProjectID={$_POST["CategoryID"]} and Date BETWEEN '{$FromDate}' AND '{$ToDate}'");
        $ProjectName=$UniqueTransactionHeadOfAccounts[0]["ProjectName"];

        // Even if this is empty, still allow second date's value to show
        $HeadOfAccountID = $uniqueHeadOfAccountId;

        // Skip ID 2450
        if ($HeadOfAccountID == 2450) continue;

        // Still try to get expense head data
        $HeadTypeData = SQL_Select("expensehead", "ExpenseHeadID='{$HeadOfAccountID}'");
        $HeadType = $HeadTypeData[0]["ExpenseHeadIsType"];

        $balance = 0;

        $HeadOfAccountName = '';
        if (!empty($UniqueTransactionHeadOfAccounts)) {
            $HeadOfAccountName = $UniqueTransactionHeadOfAccounts[0]["HeadOfAccountName"];

            if ($HeadType == 1) {
                foreach ($UniqueTransactionHeadOfAccounts as $row) {
                    $balance += $row["dr"] - $row["cr"];
                }
                if ($balance > 0) {
                    $subDrTotal += $balance;
                    $TotalsubDrTotal += $balance;
                }
            } else {
                foreach ($UniqueTransactionHeadOfAccounts as $row) {
                    $balance += $row["cr"] - $row["dr"];
                }
                if ($balance > 0) {
                    $subCrTotal += $balance;
                }
            }
        }

        // ✅ Always check and show second amount even if first is empty
        $secondVal = isset($secondAmountList[$HeadOfAccountID]) ? BangladeshiCurencyFormat($secondAmountList[$HeadOfAccountID]) : "0";
        $HeadOfAccountName = $HeadOfAccountName ?: (isset($secondHeadIDList[$HeadOfAccountID]) ? $secondHeadIDList[$HeadOfAccountID] : '');

        if ($HeadType == 1 && ($balance > 0 || $secondVal != "0")) {
            $trHtmldr .= '
            <tr>
                <th class="text-center" scope="row" style=" width: 47px; ">' . $sldr . '</th>                      
                <td class="" >' . $HeadOfAccountName . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($balance) . '</td>
                <td class="text-right">' . $secondVal . '</td>
            </tr>
        ';
            $sldr++;
        } elseif ($balance > 0 || $secondVal != "0") {
            $trHtmlcr .= '
            <tr>
                <th class="text-center" scope="row" style=" width: 47px; ">' . $sl . '</th>                      
                <td class="" >' . $HeadOfAccountName . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($balance) . '</td>
                <td class="text-right">' . $secondVal . '</td>
            </tr>
        ';
            $sl++;

        }


    }



    $serviceHead = SQL_Select("transaction WHERE HeadOfAccountID = 2450 AND ProjectID = {$_POST["CategoryID"]} and Date BETWEEN '{$FromDate}' AND '{$ToDate}'");

// Second date range (assume posted as SecondFromDate and SecondToDate)
    $secondserviceHead = SQL_Select("transaction WHERE HeadOfAccountID = 2450 AND ProjectID = {$_POST["CategoryID"]} and Date BETWEEN '{$secondFromDate}' AND '{$secondToDate}'");

// Group second data by HeadOfAccountName for quick access
    $secondDataMap = array();
    foreach ($secondserviceHead as $row) {
        $name = $row['HeadOfAccountName'];
        if (!isset($secondDataMap[$name])) {
            $secondDataMap[$name] = array('dr' => 0, 'cr' => 0);
        }
        $secondDataMap[$name]['dr'] += $row['dr'];
        $secondDataMap[$name]['cr'] += $row['cr'];
    }

// Render table rows
    $serviceHeadbalance = 0;
    $trHtmldrs = '';
    $sl = $sldr;
    $servicedr = 0;
    $secondservicedr = 0;

    foreach ($serviceHead as $serviceHeads) {
        $accountName = $serviceHeads['HeadOfAccountName'];
        $dr_cr_first = $serviceHeads["dr"] - $serviceHeads["cr"];

        $serviceHeadbalance += $dr_cr_first;
        $TotalsubDrTotal += $dr_cr_first;

        $second_dr = isset($secondDataMap[$accountName]) ? $secondDataMap[$accountName]['dr'] : 0;
        $second_cr = isset($secondDataMap[$accountName]) ? $secondDataMap[$accountName]['cr'] : 0;
        $dr_cr_second = $second_dr - $second_cr;
        $TotalsubSecondTotal += $dr_cr_second;

        $servicedr += $serviceHeads["dr"];
        $secondservicedr += $second_dr;



        $trHtmldrs .= '
        <tr>
            <th class="text-center" style=" width: 47px; ">' . $sl . '</th>                      
            <td>' . htmlspecialchars($accountName) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($dr_cr_first) . '</td>
            
            <td class="text-right">' . BangladeshiCurencyFormat($dr_cr_second) . '</td>
            
        </tr>
    ';
        $sl++;
    }
    $BankCashes = SQL_Select("bankcash");
    $bankCashHtml = '';
    $sl = 1;
    $totalBankCashBalance = 0;
    $totalSecondBankCashBalance = 0;
    $first_drAmount_TotalBank = 0;
    $first_crAmount_TotalBank = 0;
    $second_drAmount_TotalBank = 0;
    $second_crAmount_TotalBank = 0;

    foreach ($BankCashes as $BankCash) {
        $bankCashName = $BankCash["AccountTitle"];
        $bankCashID = $BankCash["BankCashID"];

        // First Date Range Transactions
        $TransactionInfos = SQL_Select("transaction WHERE BankCashID={$bankCashID} AND ProjectID={$_POST["CategoryID"]} AND Date BETWEEN '{$secondFromDate}' AND '{$secondToDate}'");
        $drAmount = 0;
        $crAmount = 0;

        foreach ($TransactionInfos as $TransactionInfo) {
            $drAmount += $TransactionInfo["dr"];
            $crAmount += $TransactionInfo["cr"];
        }

        $balance = $crAmount - $drAmount;
        $totalBankCashBalance += $balance;
        $first_drAmount_TotalBank += $drAmount;
        $first_crAmount_TotalBank += $crAmount;


        // Second Date Range Transactions
        $SecondTransactionInfos = SQL_Select("transaction WHERE BankCashID={$bankCashID} AND ProjectID={$_POST["CategoryID"]} AND Date BETWEEN '{$startD}' AND '{$secondToDate}'");
        $secondDr = 0;
        $secondCr = 0;

        foreach ($SecondTransactionInfos as $SecondTransactionInfo) {
            $secondDr += $SecondTransactionInfo["dr"];
            $secondCr += $SecondTransactionInfo["cr"];
        }

        $secondBalance = $secondCr - $secondDr;
        $totalSecondBankCashBalance += $secondBalance;
        $second_drAmount_TotalBank += $secondDr;
        $second_crAmount_TotalBank += $secondCr;
        // Skip if both balances are zero or negative
//        if ($balance <= 0 && $secondBalance <= 0) {
//            continue;
//        }
        // Render HTML row
        $bankCashHtml .= '
        <tr>
            <th  class="text-center" scope="row" style=" width: 47px; ">' . $sl . '</th>
            <td>' . htmlspecialchars($BankCash["GLCode"]) . '</td>
            <td>' . htmlspecialchars($bankCashName) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($balance) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($secondBalance) . '</td>
        </tr>';





        $sl++;
    }

    $closingcr .='
                <tr>
                    <td colspan="2">Cash at Bank & Others</td>
                    <td class="text-right">' . $op[0]['OpeningBalance'] . '</td>
                    <td class="text-right">' . $op2[0]['OpeningBalance'] . '</td>

                </tr>
        ';

    $closingdr .='
                <tr>
                    <td colspan="2">Cash at Bank & Others</td>
                    <td class="text-right">' . $CB[0]['ClosingBalance'] . '</td>
                    <td class="text-right">' . $CB2[0]['ClosingBalance'] . '</td>
                </tr>
        ';


//    $closingdr .='
//                <tr>
//                    <td colspan="2">Cash at Bank & Others</td>
//                    <td class="text-right">' . $result = (float)$subCrTotal - (float)$subDrTotal. '</td>
//                    <td class="text-right">' . $result = (float)$secondsubCrTotal-(float)$secondsubDrTotal. '</td>
//                </tr>
//        ';

    $BankAndCashOtherCR .= '
                <tr>
                    <th colspan="2" class="text-right">Sub Total =</th>
                    <th width="200px" class="text-right">' . BangladeshiCurencyFormat($op[0]['OpeningBalance']) . '</th>
                    <th width="200px" class="text-right">' . BangladeshiCurencyFormat($op2[0]['OpeningBalance']) . '</th>
                </tr>';


// Optionally calculate grand total
    $grandTotalDr = $totalBankCashBalance + $subDrTotal;
    $grandTotalCr = $subCrTotal;


    $BankCashes = SQL_Select("bankcash");
    $bankCashHtml = '';
    $sl = 1;
    $totalBankCashBalance = 0;
    $totalSecondBankCashBalance = 0;

    foreach ($BankCashes as $BankCash) {
        $bankCashName = $BankCash["AccountTitle"];
        $bankCashID = $BankCash["BankCashID"];

        // First Date Range Transactions
        $TransactionInfos = SQL_Select("transaction WHERE BankCashID={$bankCashID} AND ProjectID={$_POST["CategoryID"]} AND Date BETWEEN '{$startD}' AND '{$ToDate}'");
        $drAmount = 0;
        $crAmount = 0;

        foreach ($TransactionInfos as $TransactionInfo) {
            $drAmount += $TransactionInfo["dr"];
            $crAmount += $TransactionInfo["cr"];
        }

        $balance = $crAmount - $drAmount;
        $totalBankCashBalance += $balance;

        // Second Date Range Transactions
        $SecondTransactionInfos = SQL_Select("transaction WHERE BankCashID={$bankCashID} AND ProjectID={$_POST["CategoryID"]} AND Date BETWEEN '{$startD}' AND '{$secondToDate}'");
        $secondDr = 0;
        $secondCr = 0;

        foreach ($SecondTransactionInfos as $SecondTransactionInfo) {
            $secondDr += $SecondTransactionInfo["dr"];
            $secondCr += $SecondTransactionInfo["cr"];
        }

        $secondBalance = $secondCr - $secondDr;
        $totalSecondBankCashBalance += $secondBalance;

        // Skip if both balances are zero
        if ($balance <= 0 && $secondBalance <= 0) continue;

        // Render table row
        $bankCashHtml .= '
    <tr>
        <th class="text-center" scope="row" style=" width: 47px; ">' . $sl . '</th>
        <td>' . htmlspecialchars($BankCash["GLCode"]) . '</td>
        <td>' . htmlspecialchars($bankCashName) . '</td>
        <td colspan="" class="text-right">' . BangladeshiCurencyFormat($balance) . '</td>
        <td colspan="" class="text-right">' . BangladeshiCurencyFormat($secondBalance) . '</td>
    </tr>';
        $sl++;
    }
//    print_r($SecondTransactionInfos);

// Optionally calculate grand total
    $grandTotalDr = $totalBankCashBalance + $subDrTotal + $servicedr;
    $grandTotalCr = $subCrTotal;
    $secondgrandTotalDr = $totalSecondBankCashBalance + $secondsubDrTotal+$secondservicedr;
    $secondgrandTotalCr = $secondsubCrTotal;




    $GR = $grandTotalCr-$grandTotalDr;
    $GR2 = $secondgrandTotalCr-$secondgrandTotalDr;


    // CR Table
    $projectHtmlcr .= '                    
        <table class="table table-bordered table-hover table-fixed table-sm">
            <thead>
                <!-- Row 1: SL and Head of Account merged with this row using rowspan -->
                <tr>
                    <th rowspan="2" class="text-center" style="width: 47px; vertical-align: middle;">SL</th>
                    <th rowspan="2" scope="col" style="text-align: center; vertical-align: middle;">Head of Account</th>                    <th colspan="1" style="text-align: right; font-size: 13px" class="text-center">
                        ' . date("d-m-Y", strtotime($FromDate)) . ' <br> To <br> ' . date("d-m-Y", strtotime($ToDate)) . '
                    </th>
                    <th colspan="1" style="text-align: right; font-size: 13px" class="text-center">
                        ' . date("d-m-Y", strtotime($secondFromDate)) . ' <br> To <br> ' . date("d-m-Y", strtotime($secondToDate)) . '
                    </th>
                </tr>
            
                <!-- Row 2: Taka columns -->
                <tr>
                    <th width="200px" class="text-right">Taka</th>
                    <th width="200px" class="text-right">Taka</th>
                </tr>
            
                <!-- Row 3: Opening Balance -->
                <tr>
                    <th colspan="4">Opening Balance</th>
                </tr>
            </thead>

            <tbody>
            
                
                   '.$closingcr.'
                   
            </tbody>
            <tfoot>
            
                    '.$BankAndCashOtherCR.'
                    
            </tfoot>
        </table>
        <table class="table table-bordered table-hover table-fixed table-sm">
            <tbody>
        
                ' . $trHtmlcr . '
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" class="text-right">Total =</th>
                    <th width="200px" class="text-right" style="text-decoration: underline; text-decoration-style: double;">' . BangladeshiCurencyFormat($subCrTotal+$op[0]['OpeningBalance']) . '</th>
                    <th width="200px" class="text-right" style="text-decoration: underline; text-decoration-style: double;">' . BangladeshiCurencyFormat($secondsubCrTotal+$op2[0]['OpeningBalance']) . '</th>
                </tr>
            </tfoot>
        </table>';




    // DR Table
    $projectHtmldr .= '
        <table class="table table-bordered table-hover table-fixed table-sm">
            <thead>

            </thead>
            <tbody>' . $trHtmldr . '
                        <tr>
                            <th class="text-right" scope="col" colspan="2">Costruction Cost =</th>
                            <th scope="col" class="text-right">'.BangladeshiCurencyFormat($subDrTotal).'</th>
                            <th scope="col" class="text-right">'.BangladeshiCurencyFormat($secondsubDrTotal).'</th>
                        </tr>
                         '.$trHtmldrs.' 
            
            
            
                <tr>
                    <th colspan="2" class="text-right">Total Constraction Cost =</th>
                    <th width="200px" class="text-right">' . BangladeshiCurencyFormat($subDrTotal+$servicedr) . '</th>
                    <th width="200px" class="text-right">' . BangladeshiCurencyFormat($secondsubDrTotal+$secondservicedr) . '</th>
                </tr>
                <tr>
                    <th colspan="4" class="text-left">Closing Balance</th>
                </tr> 
                <tr>
                   '.$closingdr.'
                </tr>
                <tr>
                    <th colspan="2" class="text-right">Total=</th>
                    <th colspan="" class="text-right" style="text-decoration: underline; text-decoration-style: double;">'.BangladeshiCurencyFormat($CB[0]['ClosingBalance']+$subDrTotal+$servicedr).'</th>
                    <th colspan="" class="text-right" style="text-decoration: underline; text-decoration-style: double;">'.BangladeshiCurencyFormat($CB2[0]['ClosingBalance']+$secondsubDrTotal+$secondservicedr).'</th>
                </tr>
            </tbody>
        </table>';




}


$Project = SQL_Select("category where CategoryID =$CategoryID");
$ProjectName = $Project[0]['Name'];


$MainContent .= '

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Statement of Receipt & Payment</title>

    <style>
        .m-b-30{
            margin-bottom: 30px;
        }
        .m-t-30{
            margin-top: 30px;
        }
        
         .table-bordered th, .table-bordered td {
                border: 1px solid rgba(0,0,0,.3) !important;
          }
          
          .company-name{
            border-bottom: 1px solid rgba(0,0,0,.3);
          }

    </style>
</head>
<body>


<div style="width: 95%; margin: auto">
    <p style="font-size: 16px">Printing Date & Time: '.date('F j-y, h:i:sa').'</p>
</div>

<div style="width: 95%; margin: auto">

<div style="padding: 10px 0px;"  class="text-center company-name">
    <!-- Logo Centered -->

           <img style="width: 127px;position: relative;float: left;" src="./upload/' . $Settings["logo"] . '" alt="">


    <!-- Company Info -->

            <h3 style="font-weight: bold";margin-right: 344px;>'.$Settings["CompanyName"].'</h3>
            <p style="font-size: 18px;">'.$Settings["Address"].'</p>
            <p style="font-size: 18px; ">Project Name - '.$ProjectName.'</p>

</div>
<div class="projectName text-center m-b-30 m-t-30">
    <h4 style="font-weight: bold;">Statement of Receipt & Payment</h4>
</div>
        <div class="clo-md-6"><h4 style="font-weight: bold">Receipt</h4></div>

            


    ' . $projectHtmlcr . '
            <h4 style="font-weight: bold">Payment</h4>

    ' . $projectHtmldr . '

    
    <table class="table table-bordered table-hover table-fixed table-sm">
    <thead>
    
    </thead>
    
    </table>
    
    
    
   <!----  BankCash --->
    
<table class="table table-bordered table-hover table-fixed table-sm">
    <thead>
        <tr>
            <th rowspan="2" class="text-center" style="width: 47px; vertical-align: middle;">SL</th>
            <th rowspan="2" style="text-align: center; vertical-align: middle;"><h5>GL Code</h5></th> 
            <th rowspan="2" colspan="1" style="text-align: center; vertical-align: middle;"><h5>Closing Bank & Cash Balance</h5></th> 
            <th colspan="" style="text-align: right;font-size: 13px" class="text-center">' . date("d-m-Y", strtotime($FromDate)) . ' <br> To <br> ' . date("d-m-Y", strtotime($ToDate)) . '</th>
            <th colspan="" style="text-align: right;font-size: 13px" class="text-center">' . date("d-m-Y", strtotime($secondFromDate)) . ' <br> To <br> ' . date("d-m-Y", strtotime($secondToDate)) . '</th>
        </tr>
        <tr>
            <th style="text-align: center" colspan="" width="200px" class="">Balance</th>
            <th style="text-align: center" colspan="" width="200px" class="">Balance</th> 
        </tr>
    </thead>
    <tbody>
        ' . $bankCashHtml . '
    </tbody>
    <thead>
        <tr>
            <th class="text-right" colspan="3">
              Total =
            </th>
            <th colspan="" class="text-right" style="text-decoration: underline; text-decoration-style: double;">' . BangladeshiCurencyFormat($totalBankCashBalance) . '</th>
            <th colspan="" class="text-right" style="text-decoration: underline; text-decoration-style: double;">' . BangladeshiCurencyFormat($totalSecondBankCashBalance) . '</th>
        </tr>
    </thead>
</table>
        
    
    

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>


';


?>