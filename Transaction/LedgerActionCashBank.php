<?php
/**
 * Ledger Report Bank Wise
 * PHP 5.6 Compatible
 */

if (empty($_POST['FromDate']) && empty($_POST['ToDate'])) {
    header("Location: index.php?Theme=default&Base=Transaction&Script=LedgerManage");
    exit;
}

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);
$Trx_start = mysql_query("SELECT MIN(`Date`) AS StartDate FROM `tbltransaction`");
$AllBankCashes = SQL_Select("BankCash");

$CategoryID = isset($_POST["CategoryID"]) ? $_POST["CategoryID"] : "";
$FromDate   = isset($_POST["FromDate"]) ? $_POST["FromDate"] : date("Y-m-d");
$ToDate     = isset($_POST["ToDate"]) ? $_POST["ToDate"] : date("Y-m-d");
$BankCashID = isset($_POST["BankCashID"]) ? $_POST["BankCashID"] : "";

// Get earliest transaction date (if needed)
$row = @mysql_fetch_array($Trx_start, MYSQL_ASSOC);
$startD = isset($row['StartDate']) ? $row['StartDate'] : $FromDate;

$headOfAccountArea = "";

// Prepare categories
$Categories = array();
if (!empty($CategoryID)) {
    $catRow = SQL_Select("Category", "CategoryID='{$CategoryID}'", "", true);
    if (!empty($catRow)) {
        $Categories[] = $catRow;
    }
} else {
    $cats = SQL_Select("Category");
    if (is_array($cats)) $Categories = $cats;
}

// Prepare banks
$banksToProcessDefault = array();
if (!empty($BankCashID)) {
    $found = false;
    if (is_array($AllBankCashes)) {
        foreach ($AllBankCashes as $bk) {
            if ($bk["BankCashID"] == $BankCashID) {
                $banksToProcessDefault[] = $bk;
                $found = true;
                break;
            }
        }
    }
    if (!$found) {
        $b = SQL_Select("BankCash", "BankCashID='{$BankCashID}'", "", true);
        if (!empty($b)) $banksToProcessDefault[] = $b;
    }
} else {
    if (is_array($AllBankCashes)) $banksToProcessDefault = $AllBankCashes;
}

// No category found
if (empty($Categories)) {
    echo "⚠️ কোনো ক্যাটেগরি পাওয়া যায়নি।";
    exit;
}

// Loop category-wise
foreach ($Categories as $Category) {

    $catID = isset($Category["CategoryID"]) ? $Category["CategoryID"] : "";
    $projectName = !empty($Category["CategoryName"]) ? $Category["CategoryName"] : (!empty($catID) ? GetCategoryName($catID) : "All Categories");

    $headOfAccountArea .= '
    <div class="projectName text-center m-b-30 m-t-30" style=" background: #8BC34A; padding: 21px; ">
        <h4>' . $projectName . '</h4>
    </div>
    ';

    $banksToProcess = $banksToProcessDefault;

    foreach ($banksToProcess as $BankCash) {

        $bankId = isset($BankCash["BankCashID"]) ? $BankCash["BankCashID"] : "";
        if ($bankId == "") continue;

        // Per-bank escaped values
        $BankCashID_esc = mysql_real_escape_string($bankId);
        $CategoryID_esc = mysql_real_escape_string($catID);
        $startD_esc = mysql_real_escape_string($startD);
        $ToDate_esc = mysql_real_escape_string($ToDate);

        // ---- Opening Balance ----
        $sqlOpening = "
            SELECT 
                IFNULL(SUM(cr), 0) - IFNULL(SUM(dr), 0) AS OpeningBalance
            FROM tbltransaction
            WHERE BankCashID = '$BankCashID_esc'
              AND ProjectID = '$CategoryID_esc'
              AND Date < '$startD_esc'
        ";
        $resOpening = mysql_query($sqlOpening) or die("Opening Query Error: " . mysql_error());
        $rowOpening = @mysql_fetch_array($resOpening, MYSQL_ASSOC);
        $OpeningBalanceB = isset($rowOpening['OpeningBalance']) ? $rowOpening['OpeningBalance'] : 0;

        // ---- Closing Balance ----
        $sqlClosing = "
            SELECT 
                IFNULL(SUM(cr), 0) - IFNULL(SUM(dr), 0) AS ClosingBalance
            FROM tbltransaction
            WHERE BankCashID = '$BankCashID_esc'
              AND ProjectID = '$CategoryID_esc'
              AND Date <= '$ToDate_esc'
        ";
        $resClosing = mysql_query($sqlClosing) or die("Closing Query Error: " . mysql_error());
        $rowClosing = @mysql_fetch_array($resClosing, MYSQL_ASSOC);
        $ClosingBalanceB = isset($rowClosing['ClosingBalance']) ? $rowClosing['ClosingBalance'] : 0;

        // Use correct balances
        $opBalance = $OpeningBalanceB;
        $cbBalance = $ClosingBalanceB;

        // Fetch journal entries
        $JournalDetails = SQL_Select("Transaction", "ProjectID='{$catID}' AND BankCashID='{$bankId}' AND Date BETWEEN '{$FromDate}' AND '{$ToDate}' ORDER BY Date ASC");

        $headDetails = '';
        $sl = 1;
        $dr = 0;
        $cr = 0;

        if (is_array($JournalDetails) && !empty($JournalDetails)) {
            foreach ($JournalDetails as $JournalDetail) {

                $dr += floatval($JournalDetail["dr"]);
                $cr += floatval($JournalDetail["cr"]);

                // Handle contra
                if (isset($JournalDetail["VoucherType"]) && $JournalDetail["VoucherType"] == "Contra") {
                    $JournalDetails1 = SQL_Select("Transaction", "VoucherNo='{$JournalDetail["VoucherNo"]}' and VoucherType='{$JournalDetail["VoucherType"]}'");
                    $JournalName = "";
                    if (is_array($JournalDetails1)) {
                        foreach ($JournalDetails1 as $ThisJournalDetails1) {
                            if ($JournalDetail["HeadOfAccountName"] != $ThisJournalDetails1["HeadOfAccountName"]) {
                                $JournalName = $ThisJournalDetails1["HeadOfAccountName"];
                            }
                        }
                    }
                    $JournalDetail["HeadOfAccountName"] = $JournalName;
                }

                $headDetails .= '
                    <tr>
                        <th class="text-center" scope="row">' . $sl . '</th>
                        <td>' . HumanReadAbleDateFormat($JournalDetail["Date"]) . '</td>
                        <td>' . $JournalDetail["HeadOfAccountName"] . '</td>
                        <td>' . $JournalDetail["Description"] . '</td>
                        <td>' . $JournalDetail["ChequeNumber"] . '</td>
                        <td class="text-center">' . BangladeshiCurencyFormat($JournalDetail["VoucherNo"]) . '</td>
                        <td class="text-center">' . $JournalDetail["VoucherType"] . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($JournalDetail["dr"]) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($JournalDetail["cr"]) . '</td>
                    </tr>
                ';
                $sl++;
            }
        }

        $bankDisplayName = isset($BankCash["AccountTitle"]) ? $BankCash["AccountTitle"] : ("Bank ID: " . $bankId);

        $headOfAccountArea .= '
            <div class="headOfAccountArea m-b-30">
                <div class="text-center">
                    <h3>' . htmlspecialchars($bankDisplayName) . '</h3>
                </div>
                <h6 style="display: none" class="text-center">Opening Balance: ' . BangladeshiCurencyFormat($opBalance) . ' | Closing Balance: ' . BangladeshiCurencyFormat($cbBalance) . '</h6>
                <table class="table table-hover table-sm table-bordered">
                    <thead>
                    <tr style=" display: none; background: #3F51B5; color: #ffffff; font-weight: bold; font-size: 20px; ">
                        <th colspan="7" class="text-right">Opening Balance =</th>
                        <td colspan="2"><b>' . BangladeshiCurencyFormat($opBalance) . '</b></td>
                    </tr>
                    <tr>
                        <th class="text-center">S.L No</th>
                        <th>Date</th>
                        <th>Head Of Account</th>
                        <th>Particulars</th>
                        <th>Cheque Number</th>
                        <th class="text-center">Voucher No</th>
                        <th class="text-center">Type Of Voucher</th>
                        <th class="text-right">Dr.</th>
                        <th class="text-right">Cr.</th>
                    </tr>
                    </thead>
                    <tbody>
                    ' . $headDetails . '
                    <tr>
                        <th colspan="7" class="text-right">Total =</th>
                        <td class="text-right"><b>' . BangladeshiCurencyFormat($dr) . '</b></td>
                        <td class="text-right"><b>' . BangladeshiCurencyFormat($cr) . '</b></td>
                    </tr>
                    <tr>
                        <th colspan="7" class="text-right">Balance =</th>
                        <td colspan="2"><b>' . BangladeshiCurencyFormat($cr - $dr) . '</b></td>
                    </tr>
                    <tr style="display: none; background: #3F51B5; color: #ffffff; font-weight: bold; font-size: 20px; ">
                        <th colspan="7" class="text-right">Closing Balance =</th>
                        <td colspan="2"><b>' . BangladeshiCurencyFormat($cbBalance) . '</b></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        ';
    } // end bank loop
} // end category loop

// Final output

// Final HTML (keeps your original header/footer style)
$MainContent = '
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Ledger of: Bank Cash</title>


</head>

<body>
    <style>
    .m-b-30 {
        margin-bottom: 30px;
    }

    .m-t-30 {
        margin-top: 30px;
    }

    .table-bordered th,
    .table-bordered td {
        border: 2px solid Black !important;
    }

    .company-name {
        border-bottom: 1px solid rgba(0, 0, 0, .3);
    }
    </style>
    <div style="width: 95%; margin: auto">
        <p style="font-size: 16px">Printing Date & Time: '.date('F j-y, h:i:sa').'</p>
    </div>

    <div style="width: 95%; margin: auto">

        <div style="padding: 10px 0px;" class="company-name row">
            <div class="col-md-2 text-center">
                <img height="70px" src="./upload/' . $Settings[" logo"] . '" alt="">
        </div>
        <div  class="col-md-9 text-center">
            <h4 style="font-weight: bold">' . $Settings["CompanyName"] .'</h4>
                <p style="font-size: 18px;">'. $Settings["Address"] .'</p>

            </div>

        </div>

        ' . $headOfAccountArea . '

    </div>


    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
';