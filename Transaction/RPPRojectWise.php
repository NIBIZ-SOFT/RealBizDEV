<?php
if (empty($_POST['FromDate']) || empty($_POST['ToDate'])) {
    header("Location: index.php?Theme=default&Base=Transaction&Script=LedgerManage");
    exit;
}


$Settings = SQL_Select("Settings", "SettingsID=1", "", true);
$CategoryID = $_POST["CategoryID"];
if (!empty($CategoryID)) {
    $Projects = SQL_Select("category", "CategoryID={$CategoryID}");
} else {
    $Projects = SQL_Select("category");
}

$FromDate = $_POST['FromDate'];
$ToDate   = $_POST['ToDate'];
$prevDate = date('Y-m-d', strtotime($FromDate . ' -1 day'));

// Helper function for balance till date per project + bank
function getAccountBalanceTill($bankCashID, $projectID, $tillDate) {
    $sql = "
        SELECT IFNULL(SUM(cr), 0) - IFNULL(SUM(dr), 0) AS Balance
        FROM tbltransaction
        WHERE BankCashID = '{$bankCashID}'
          AND ProjectID = '{$projectID}'
          AND Date <= '{$tillDate}'
    ";
    $res = mysql_query($sql) or die(mysql_error());
    $row = mysql_fetch_assoc($res);
    return floatval($row['Balance']);
}

ob_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Daily Received & Payment Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>

    <div style="width: 95%; margin: auto;">
        <p style="font-size: 16px">Printing Date & Time: <?= date('F j, Y - h:i A'); ?></p>
    </div>

    <div style="width: 95%; margin: auto;">
        <div class="row align-items-center mb-3">
            <div class="col-md-2 text-center">
                <img src="./upload/<?= $Settings["logo"] ?>" height="70px" alt="Company Logo">
            </div>
            <div class="col-md-9 text-center">
                <h4 class="bold"><?= $Settings["CompanyName"] ?></h4>
                <p style="font-size: 18px;"><?= $Settings["Address"] ?></p>
            </div>
        </div>
        <style>
        .bg-primary {
            background-color: #3F51B5 !important;
        }

        .table-bordered th,
        .table-bordered td {
            border: 2px solid rgba(0, 0, 0, .3) !important;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .table thead th {
            background: rgba(63, 81, 181, 0.56);
            color: #000000 text-align: center;
            border: 2px solid black
        }
        </style>
        <h4 class="text-center my-3">Received & Payment Project Wise Report</h4>

        <?php foreach ($Projects as $Project): ?>
        <div class="projectName text-center m-b-30 m-t-30" style=" background: #8BC34A; padding: 21px; ">
            <h4><?= $Project['Name'] ?></h4>
        </div>


        <?php
            // Get all banks for this project
            $AllBankCashes = SQL_Select("BankCash");
            foreach ($AllBankCashes as $BankAndCash):

                // Opening balance for this bank in this project
                $openingBalance = getAccountBalanceTill($BankAndCash['BankCashID'], $Project['CategoryID'], $prevDate);

                // Transactions for this bank in this project
                $sqlTrans = "
                SELECT *
                FROM tbltransaction
                WHERE Date BETWEEN '{$FromDate}' AND '{$ToDate}'
                  AND BankCashID = '{$BankAndCash['BankCashID']}'
                  AND ProjectID = '{$Project['CategoryID']}'
                ORDER BY Date ASC, TransactionID ASC
            ";
                $resTrans = mysql_query($sqlTrans) or die(mysql_error());

                // Totals
                $sqlPeriod = "
                SELECT IFNULL(SUM(dr), 0) AS TotalDr, IFNULL(SUM(cr), 0) AS TotalCr
                FROM tbltransaction
                WHERE Date BETWEEN '{$FromDate}' AND '{$ToDate}'
                  AND BankCashID = '{$BankAndCash['BankCashID']}'
                  AND ProjectID = '{$Project['CategoryID']}'
            ";
                $resPeriod = mysql_query($sqlPeriod) or die(mysql_error());
                $rowPeriod = mysql_fetch_assoc($resPeriod);
                $totalDr = floatval($rowPeriod['TotalDr']);
                $totalCr = floatval($rowPeriod['TotalCr']);
                $balance = $totalCr - $totalDr;
                $closingBalance = $openingBalance + $balance;
                ?>
        <h5 class="mt-4 mb-3 text-center">Bank/Cash: <?= $BankAndCash['AccountTitle'] ?></h5>

        <table class="table table-bordered table-hover table-sm">
            <thead>
                <tr class="bold bg-primary text-white" style="">
                    <td colspan="5" class="text-right">
                        <strong>From:</strong> <?= HumanReadAbleDateFormat($FromDate) ?> <strong>
                    </td>
                    <td colspan="2" class="text-right">
                        <?= $BankAndCash['AccountTitle'] ?> Opening Balance:
                    </td>
                    <td colspan="2" class="text-center">
                        <?= BangladeshiCurencyFormat($openingBalance) ?>
                    </td>
                </tr>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Head of Account</th>
                    <th>Particulars</th>
                    <th>Cheque No</th>
                    <th>Voucher No</th>
                    <th>Type of Voucher</th>
                    <th>Dr. Amount</th>
                    <th>Cr. Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php $sl = 1; while ($row = mysql_fetch_assoc($resTrans)): ?>
                <tr>
                    <td><?= $sl++ ?></td>
                    <td><?= HumanReadAbleDateFormat($row['Date']) ?></td>
                    <td><?= $row['HeadOfAccountName'] ?></td>
                    <td><?= $row['Description'] ?></td>
                    <td><?= $row['ChequeNumber'] ?></td>
                    <td><?= $row['VoucherNo'] ?></td>
                    <td><?= $row['VoucherType'] ?></td>
                    <td class="text-right"><?= BangladeshiCurencyFormat($row['dr']) ?></td>
                    <td class="text-right"><?= BangladeshiCurencyFormat($row['cr']) ?></td>
                </tr>
                <?php endwhile; ?>

                <tr class="bold bg-light">
                    <td colspan="7" class="text-right">Total:</td>
                    <td class="text-right"><?= BangladeshiCurencyFormat($totalDr) ?></td>
                    <td class="text-right"><?= BangladeshiCurencyFormat($totalCr) ?></td>
                </tr>
                <tr class="bold">
                    <td colspan="7" class="text-right">Balance (Cr - Dr):</td>
                    <td colspan="2" class="text-center"><?= BangladeshiCurencyFormat($balance) ?></td>
                </tr>
                <tr class="bold bg-primary text-white">
                    <td colspan="5" class="text-right">
                        <strong>To:</strong> <?= HumanReadAbleDateFormat($ToDate) ?>
                    </td>
                    <td colspan="2" class="text-right"><?= $BankAndCash['AccountTitle'] ?> Closing Balance:</td>
                    <td colspan="2" class="text-center"><?= BangladeshiCurencyFormat($closingBalance) ?></td>
                </tr>
            </tbody>
        </table>

        <?php endforeach; ?>
        <?php endforeach; ?>
    </div>
</body>

</html>
<?php
$MainContent = ob_get_clean();