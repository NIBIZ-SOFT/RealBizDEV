<?php
if (empty($_POST['FromDate']) || empty($_POST['ToDate'])) {
    header("Location: index.php?Theme=default&Base=Transaction&Script=LedgerManage");
    exit;
}
$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

$FromDate = $_POST['FromDate'];
$ToDate   = $_POST['ToDate'];

$CategoryID = $_POST["CategoryID"];
$PostBankCashID = $_POST["BankCashID"];


// ---------------- Opening Balance ----------------
$prevDate = date('Y-m-d', strtotime($FromDate . ' -1 day'));
if(!empty($CategoryID)){
    if(!empty($PostBankCashID)){
        
        $sqlOpening = "
            SELECT IFNULL(SUM(cr), 0) - IFNULL(SUM(dr), 0) AS OpeningBalance
            FROM tbltransaction
            WHERE Date <= '{$prevDate}' AND ProjectID = '{$CategoryID}' AND BankCashID = '{$PostBankCashID}'
        ";
        $resOpening = mysql_query($sqlOpening) or die(mysql_error());
        $rowOpening = mysql_fetch_assoc($resOpening);
        $openingBalance = floatval($rowOpening['OpeningBalance']);

        // ---------------- Period Totals ----------------
        $sqlPeriod = "
            SELECT IFNULL(SUM(dr), 0) AS TotalDr,
                IFNULL(SUM(cr), 0) AS TotalCr
            FROM tbltransaction
            WHERE Date BETWEEN '{$FromDate}' AND '{$ToDate}' AND ProjectID = '{$CategoryID}' AND BankCashID = '{$PostBankCashID}'
        ";
        
        $resPeriod = mysql_query($sqlPeriod) or die(mysql_error());
        $rowPeriod = mysql_fetch_assoc($resPeriod);
        $totalDr = floatval($rowPeriod['TotalDr']);
        $totalCr = floatval($rowPeriod['TotalCr']);

        $balance = $totalCr - $totalDr;
        $closingBalance = $openingBalance + $balance;

        // ---------------- Fetch Transactions ----------------
        $sqlTrans = "
            SELECT *
            FROM tbltransaction
            WHERE Date BETWEEN '{$FromDate}' AND '{$ToDate}' AND ProjectID = '{$CategoryID}' AND BankCashID = '{$PostBankCashID}'
            ORDER BY Date ASC, TransactionID ASC
        ";
        $resTrans = mysql_query($sqlTrans) or die(mysql_error());
        // ---------------- Fetch Bank/Cash Accounts ----------------
        $AllBankCashes = SQL_Select("BankCash", "BankCashID='{$PostBankCashID}'"); // Returns an array of bank/cash accounts
        
        // Function to get account balance till a date
        if(empty($AllBankCashes)){
            $AllBankCashes = SQL_Select("BankCash"); // If no specific bank/cash is selected, fetch all
        }
        function getAccountBalanceTill($bankCashID, $tillDate, $CategoryID = null) {
            $sql = "
                SELECT IFNULL(SUM(cr), 0) - IFNULL(SUM(dr), 0) AS Balance
                FROM tbltransaction
                WHERE BankCashID = '{$bankCashID}' AND Date <= '{$tillDate}'" . 
                ($CategoryID ? " AND ProjectID = '{$CategoryID}'" : "") . "
            ";
            $res = mysql_query($sql) or die(mysql_error());
            $row = mysql_fetch_assoc($res);
            return floatval($row['Balance']);
        }
        
        // ---------------- Fetch Categories ----------------
        $AllCategories = SQL_Select("category");
        // Function to get category name by ID
        function getCategoryNameByID($categoryID) {
            $category = SQL_Select("category", "CategoryID='{$categoryID}'", "", true);
            return $category ? $category['Name'] : 'Unknown Category';
        }

        // Function to get category balance till a date
        // function getCategoryBalanceTill($categoryID, $tillDate) {
        //     $sql = "
        //         SELECT IFNULL(SUM(cr), 0) - IFNULL(SUM(dr), 0) AS Balance
        //         FROM tbltransaction
        //         WHERE ProjectID = '{$categoryID}' AND Date <= '{$tillDate}'
        //     ";
        //     $res = mysql_query($sql) or die(mysql_error());
        //     $row = mysql_fetch_assoc($res);
        //     return floatval($row['Balance']);
        // }


    }else{
            $CategoryData = SQL_Select("category", "CategoryID='{$CategoryID}'", "", true);
            $sqlOpening = "
                SELECT IFNULL(SUM(cr), 0) - IFNULL(SUM(dr), 0) AS OpeningBalance
                FROM tbltransaction
                WHERE Date <= '{$prevDate}' AND ProjectID = '{$CategoryID}'
            ";
            $resOpening = mysql_query($sqlOpening) or die(mysql_error());
            $rowOpening = mysql_fetch_assoc($resOpening);
            $openingBalance = floatval($rowOpening['OpeningBalance']);

            // ---------------- Period Totals ----------------
            $sqlPeriod = "
                SELECT IFNULL(SUM(dr), 0) AS TotalDr,
                    IFNULL(SUM(cr), 0) AS TotalCr
                FROM tbltransaction
                WHERE Date BETWEEN '{$FromDate}' AND '{$ToDate}' AND ProjectID = '{$CategoryID}'
            ";
            
            $resPeriod = mysql_query($sqlPeriod) or die(mysql_error());
            $rowPeriod = mysql_fetch_assoc($resPeriod);
            $totalDr = floatval($rowPeriod['TotalDr']);
            $totalCr = floatval($rowPeriod['TotalCr']);

            $balance = $totalCr - $totalDr;
            $closingBalance = $openingBalance + $balance;

            // ---------------- Fetch Transactions ----------------
            $sqlTrans = "
                SELECT *
                FROM tbltransaction
                WHERE Date BETWEEN '{$FromDate}' AND '{$ToDate}' AND ProjectID = '{$CategoryID}'
                ORDER BY Date ASC, TransactionID ASC
            ";
            $resTrans = mysql_query($sqlTrans) or die(mysql_error());

            // ---------------- Fetch Bank/Cash Accounts ----------------
            $AllBankCashes = SQL_Select("BankCash"); // Returns an array of bank/cash accounts

            // Function to get account balance till a date
            function getAccountBalanceTill($bankCashID, $tillDate, $CategoryID) {
                $sql = "
                    SELECT IFNULL(SUM(cr), 0) - IFNULL(SUM(dr), 0) AS Balance
                    FROM tbltransaction
                    WHERE BankCashID = '{$bankCashID}' AND Date <= '{$tillDate}' AND ProjectID = '{$CategoryID}'
                ";
                $res = mysql_query($sql) or die(mysql_error());
                $row = mysql_fetch_assoc($res);
                return floatval($row['Balance']);
            }
    }  
}else{

    if(empty($PostBankCashID)){
        $sqlOpening = "
                SELECT IFNULL(SUM(cr), 0) - IFNULL(SUM(dr), 0) AS OpeningBalance
                FROM tbltransaction
                WHERE Date <= '{$prevDate}'
            ";
            $resOpening = mysql_query($sqlOpening) or die(mysql_error());
            $rowOpening = mysql_fetch_assoc($resOpening);
            $openingBalance = floatval($rowOpening['OpeningBalance']);

            // ---------------- Period Totals ----------------
            $sqlPeriod = "
                SELECT IFNULL(SUM(dr), 0) AS TotalDr,
                    IFNULL(SUM(cr), 0) AS TotalCr
                FROM tbltransaction
                WHERE Date BETWEEN '{$FromDate}' AND '{$ToDate}'
            ";
            $resPeriod = mysql_query($sqlPeriod) or die(mysql_error());
            $rowPeriod = mysql_fetch_assoc($resPeriod);
            $totalDr = floatval($rowPeriod['TotalDr']);
            $totalCr = floatval($rowPeriod['TotalCr']);

            $balance = $totalCr - $totalDr;
            $closingBalance = $openingBalance + $balance;

            // ---------------- Fetch Transactions ----------------
            $sqlTrans = "
                SELECT *
                FROM tbltransaction
                WHERE Date BETWEEN '{$FromDate}' AND '{$ToDate}'
                ORDER BY Date ASC, TransactionID ASC
            ";
            $resTrans = mysql_query($sqlTrans) or die(mysql_error());

            // ---------------- Fetch Bank/Cash Accounts ----------------
            $AllBankCashes = SQL_Select("BankCash"); // Returns an array of bank/cash accounts

            // Function to get account balance till a date
            function getAccountBalanceTill($bankCashID, $tillDate) {
                $sql = "
                    SELECT IFNULL(SUM(cr), 0) - IFNULL(SUM(dr), 0) AS Balance
                    FROM tbltransaction
                    WHERE BankCashID = '{$bankCashID}' AND Date <= '{$tillDate}'
                ";
                $res = mysql_query($sql) or die(mysql_error());
                $row = mysql_fetch_assoc($res);
                return floatval($row['Balance']);
            }
    }
    else{
        $sqlOpening = "
                SELECT IFNULL(SUM(cr), 0) - IFNULL(SUM(dr), 0) AS OpeningBalance
                FROM tbltransaction
                WHERE Date <= '{$prevDate}' AND BankCashID = '{$PostBankCashID}'
            ";
            $resOpening = mysql_query($sqlOpening) or die(mysql_error());
            $rowOpening = mysql_fetch_assoc($resOpening);
            $openingBalance = floatval($rowOpening['OpeningBalance']);

            // ---------------- Period Totals ----------------
            $sqlPeriod = "
                SELECT IFNULL(SUM(dr), 0) AS TotalDr,
                    IFNULL(SUM(cr), 0) AS TotalCr
                FROM tbltransaction
                WHERE Date BETWEEN '{$FromDate}' AND '{$ToDate}' AND BankCashID = '{$PostBankCashID}'
            ";
            $resPeriod = mysql_query($sqlPeriod) or die(mysql_error());
            $rowPeriod = mysql_fetch_assoc($resPeriod);
            $totalDr = floatval($rowPeriod['TotalDr']);
            $totalCr = floatval($rowPeriod['TotalCr']);

            $balance = $totalCr - $totalDr;
            $closingBalance = $openingBalance + $balance;
            // ---------------- Fetch Transactions ----------------
            $sqlTrans = "
                SELECT *
                FROM tbltransaction
                WHERE Date BETWEEN '{$FromDate}' AND '{$ToDate}' AND BankCashID = '{$PostBankCashID}'
                ORDER BY Date ASC, TransactionID ASC
            ";
            $resTrans = mysql_query($sqlTrans) or die(mysql_error());
            // ---------------- Fetch Bank/Cash Accounts ----------------
            $AllBankCashes = SQL_Select("BankCash", "BankCashID='{$PostBankCashID}'"); // Returns an array of bank/cash accounts
            // Function to get account balance till a date
            function getAccountBalanceTill($bankCashID, $tillDate) {
                $sql = "
                    SELECT IFNULL(SUM(cr), 0) - IFNULL(SUM(dr), 0) AS Balance
                    FROM tbltransaction
                    WHERE BankCashID = '{$bankCashID}' AND Date <= '{$tillDate}'
                ";
                $res = mysql_query($sql) or die(mysql_error());
                $row = mysql_fetch_assoc($res);
                return floatval($row['Balance']);
            }
            
        
    }
}


// ---------------- Start Output Buffer ----------------
ob_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Daily Received & Payment Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
    .table th,
    .table td {
        vertical-align: middle;
    }

    .table thead th {
        background: rgba(63, 81, 181, 0.56);
        color: #000000 text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .bold {
        font-weight: bold;
    }

    .bg-light-gray {
        background-color: #f0f0f0;
    }
    </style>
    <style>
    .m-b-30 {
        margin-bottom: 30px;
    }

    .m-t-30 {
        margin-top: 30px;
    }

    .table-bordered th,
    .table-bordered td {
        border: 2px solid rgba(0, 0, 0, .3) !important;
    }

    .company-name {
        border-bottom: 1px solid rgba(0, 0, 0, .3);
    }
    </style>
</head>

<body>
<body>

    <div style="width: 95%; margin: auto;">
        <p style="font-size: 16px">Printing Date & Time: <?= date('F j, Y - h:i A'); ?></p>
    </div>

    <div style="width: 95%; margin: auto;">
        <div class="row align-items-center mb-3">
            <div class="m-auto text-center" style="position: absolute; width: 100px;">
                <img src="./upload/<?= $Settings["logo"] ?>" height="70px" alt="Company Logo">
            </div>
            <div class="col-md-12 text-center">
                <h4 class="bold"><?= $Settings["CompanyName"] ?></h4>
                <p style="font-size: 18px;"><?= $Settings["Address"] ?></p>
            </div>
        </div>
    <div class="projectName text-center m-b-30 m-t-30" style=" background: #8BC34A; padding: 21px; " bis_skin_checked="1">
                <h4 class="text-center my-3">Date Wise Bank Statement Report <?php if($CategoryData != null){ echo " - ".$CategoryData['Name']; }else{ echo "All Project"; }?></h4>
    </div>
        <p class="text-center"><strong>From:</strong> <?= HumanReadAbleDateFormat($FromDate) ?> <strong>To:</strong>
            <?= HumanReadAbleDateFormat($ToDate) ?></p>

        <table class="table table-bordered table-hover table-sm">
            <thead>
                <!-- Bank/Cash Opening Balances -->
                <?php foreach ($AllBankCashes as $BankAndCash): ?>
                <tr class="bold" style="">
                    <td colspan="9" class="text-right">
                        <?= $BankAndCash['AccountTitle'] ?> Opening Balance:
                    </td>
                    <td colspan="2" class="text-center">
                        <?= BangladeshiCurencyFormat(getAccountBalanceTill($BankAndCash['BankCashID'], $prevDate, $CategoryID)) ?>
                    </td>
                </tr>
                <?php endforeach; ?>

                <!-- Overall Opening -->
                <tr class="bg-light-green bold">
                    <td colspan="9" class="text-right">Opening Balance:</td>
                    <td colspan="2" class="text-center"><?= BangladeshiCurencyFormat($openingBalance) ?></td>
                </tr>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Head of Account</th>
                    <th>Particulars</th>
                    <th>Cheque No</th>
                    <th>Voucher No</th>
                    <th>Type of Voucher</th>
                    <th>Bank/Cash</th>
                    <th>Project Name</th>
                    <th>Dr. Amount</th>
                    <th>Cr. Amount</th>
                </tr>
            </thead>
            <tbody>


                <!-- Transactions -->
                <?php $sl = 1; while ($row = mysql_fetch_assoc($resTrans)):
                $PName = SQL_Select("category","CategoryID='{$row['ProjectID']}'","",true);
                $BankName = SQL_Select("BankCash","{$row['BankCashID']}");
                foreach ($AllBankCashes as $BankAndCash) {
                    if ($BankAndCash['BankCashID'] == $row['BankCashID']) {
                        $BankName = $BankAndCash;
                        break;
                    }
                }

                ?>
                <tr>
                    <td class="text-center"><?= $sl++ ?></td>
                    <td class="text-center"><?= HumanReadAbleDateFormat($row['Date']) ?></td>
                    <td style=" width: 100px;"><?= $row['HeadOfAccountName'] ?></td>
                    <td style=" width: 226px;"><?= $row['Description'] ?></td>
                    <td class="text-center"><?= $row['ChequeNumber'] ?></td>
                    <td class="text-center"><?= $row['VoucherNo'] ?></td>
                    <td class="text-center"><?= $row['VoucherType'] ?></td>
                    <td class="text-center"><?= $BankName['AccountTitle'] ?></td>
                    <td class="text-center"><?= $PName['Name'] ?></td>
                    <td class="text-right"><?= BangladeshiCurencyFormat($row['dr']) ?></td>
                    <td class="text-right"><?= BangladeshiCurencyFormat($row['cr']) ?></td>
                </tr>
                <?php endwhile; ?>

                <!-- Totals -->
                <tr class="bold" style="background: rgba(63,81,181,0.56);color: #000000">
                    <td colspan="9" class="text-right">Total:</td>
                    <td class="text-right"><?= BangladeshiCurencyFormat($totalDr) ?></td>
                    <td class="text-right"><?= BangladeshiCurencyFormat($totalCr) ?></td>
                </tr>
                <tr class="bg-light-gray bold">
                    <td colspan="9" class="text-right">Balance (Cr - Dr):</td>
                    <td colspan="2" class="text-center"><?= BangladeshiCurencyFormat($balance) ?></td>
                </tr>

                <!-- Bank/Cash Closing Balances -->
                <?php foreach ($AllBankCashes as $BankAndCash): ?>
                <tr class="bold">
                    <td colspan="9" class="text-right">
                        <?= $BankAndCash['AccountTitle'] ?> Closing Balance:
                    </td>
                    <td colspan="2" class="text-center">
                        <?= BangladeshiCurencyFormat(getAccountBalanceTill($BankAndCash['BankCashID'], $ToDate, $CategoryID)) ?>
                    </td>
                </tr>
                <?php endforeach; ?>

                <!-- Overall Closing -->
                <tr class="bold" style="background: #3F51B5;color: white">
                    <td colspan="9" class="text-right">Closing Balance:</td>
                    <td colspan="2" class="text-center"><?= BangladeshiCurencyFormat($closingBalance) ?></td>
                </tr>

            </tbody>
        </table>
    </div>

</body>

</html>

<?php
// Capture all the output above into $MainContent
$MainContent = ob_get_clean();
?>