<?php
$Settings = SQL_Select("Settings", "SettingsID=1", "", true);
$Balancesheet = SQL_Select("balancesheet", "BalanceSheetIsActive=1");
$FromDate   = isset($_REQUEST["FromDate"])   ? $_REQUEST["FromDate"]   : '0000-00-00';
$ToDate     = isset($_REQUEST["ToDate"])     ? $_REQUEST["ToDate"]     : '0000-00-00';
// Currency format function
function format_currency($amount) {
    return number_format((float)$amount, 2);
}

$capitalLiabilitiesTotal = 0;
$equity = 0;
$assetsTotal = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Statement of Financial Position</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f9f9f9; }
        .container { max-width: 1100px; margin: auto; background: #fff; padding: 20px; box-shadow: 0 0 10px #ccc; }
        h1 { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; }
        th { background-color: #f2f2f2; }
        .section-header { background: #00CC00; color: #fff; font-weight: bold; }
        .group-header { background: #e9f9e9; font-weight: bold; }
        .sub-header { background: #f5f5f5; font-weight: bold; }
        .indent { padding-left: 30px; }
        .amount { text-align: right; }
        .total-row { background: #e0e0e0; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <h1>Statement of Financial Position</h1>
    <button class="btn btn-info" onclick="exportToCSV()">Export to CSV</button>
    <button class="btn btn-success" onclick="exportToExcel()">Export to Excel</button>
    <table id="myTable" class="mt-4">
        <tr>
            <th>Particulars</th>
            <th style="text-align:center;">From: <?php echo $FromDate.' To:  '.$ToDate.?></th>
            
        </tr>

        <!-- ===== Equity FIRST ===== -->
        <tr class="section-header">
            <td>Equity</td>
            <td></td>
        </tr>

        <?php
            foreach ($Balancesheet as $balanceSheetRow) {
                if ($balanceSheetRow['Category'] == "Equity") {
                    echo '<tr class="group-header"><td style="padding-left: 20px;">' . htmlspecialchars($balanceSheetRow['Name']) . '</td><td></td></tr>';

                    $ParentHeads = SQL_Select("incomeexpensetype", "FinancialPositionList=" . (int)$balanceSheetRow['BalanceSheetID']);

                    foreach ($ParentHeads as $TypeHead) {
                        echo '<tr class="sub-header"><td style="padding-left: 40px;">' . htmlspecialchars($TypeHead['Name']) . '</td><td></td></tr>';

                        $Heads = SQL_Select("expensehead where IncomeExpenseTypeID=" . (int)$TypeHead['IncomeExpenseTypeID']);
                        $ids = array();
                        foreach ($Heads as $h) {
                            $ids[] = $h['ExpenseHeadID'];
                        }

                        if (!empty($ids)) {
                            $idList = implode(',', $ids);

                            $ResultDr = mysql_query("SELECT SUM(dr) AS total_dr FROM tbltransaction WHERE HeadOfAccountID IN ($idList) AND Date BETWEEN '$FromDate' AND '$ToDate'");
                            $ResultCr = mysql_query("SELECT SUM(cr) AS total_cr FROM tbltransaction WHERE HeadOfAccountID IN ($idList) AND Date BETWEEN '$FromDate' AND '$ToDate'");

                            $DR = mysql_fetch_array($ResultDr);
                            $CR = mysql_fetch_array($ResultCr);
                            $groupTotal = $CR['total_cr'] - $DR['total_dr'];
                            $Equity += $groupTotal;

                            foreach ($Heads as $Head) {
                                $ResultDr = mysql_query("SELECT SUM(dr) AS total_dr FROM tbltransaction WHERE HeadOfAccountID = {$Head['ExpenseHeadID']} AND Date BETWEEN '$FromDate' AND '$ToDate'");
                                $ResultCr = mysql_query("SELECT SUM(cr) AS total_cr FROM tbltransaction WHERE HeadOfAccountID = {$Head['ExpenseHeadID']} AND Date BETWEEN '$FromDate' AND '$ToDate'");
                                $DR = mysql_fetch_array($ResultDr);
                                $CR = mysql_fetch_array($ResultCr);
                                $net = $CR['total_cr'] - $DR['total_dr'];

                                echo '<tr>
                                                <td class="indent" style="padding-left: 60px">' . htmlspecialchars($Head['ExpenseHeadName']) . '</td>
                                                <td class="amount">' . format_currency($net) . '</td>
                                            </tr>';
                            }
                        }
                    }
                }

            }
        ?>
        <tr class="total-row">
            <td>Total Equity</td>
            <td class="amount"><?php echo format_currency($Equity); ?></td>
        </tr>
        <!-- ===== LIABILITIES Second ===== -->
        <tr class="section-header">
            <td>Liabilities</td>
            <td></td>
        </tr>
        <?php
        foreach ($Balancesheet as $balanceSheetRow) {
            if ($balanceSheetRow['Category'] == "Liabilities") {
                echo '<tr class="group-header"><td style="padding-left: 20px;">' . htmlspecialchars($balanceSheetRow['Name']) . '</td><td></td></tr>';

                $ParentHeads = SQL_Select("incomeexpensetype", "FinancialPositionList=" . (int)$balanceSheetRow['BalanceSheetID']);

                foreach ($ParentHeads as $TypeHead) {
                    echo '<tr class="sub-header"><td style="padding-left: 40px;">' . htmlspecialchars($TypeHead['Name']) . '</td><td></td></tr>';

                    $Heads = SQL_Select("expensehead where IncomeExpenseTypeID=" . (int)$TypeHead['IncomeExpenseTypeID']);
                    $ids = array();
                    foreach ($Heads as $h) {
                        $ids[] = $h['ExpenseHeadID'];
                    }

                    if (!empty($ids)) {
                        $idList = implode(',', $ids);

                        $ResultDr = mysql_query("SELECT SUM(dr) AS total_dr FROM tbltransaction WHERE HeadOfAccountID IN ($idList) AND Date BETWEEN '$FromDate' AND '$ToDate'");
                        $ResultCr = mysql_query("SELECT SUM(cr) AS total_cr FROM tbltransaction WHERE HeadOfAccountID IN ($idList) AND Date BETWEEN '$FromDate' AND '$ToDate'");

                        $DR = mysql_fetch_array($ResultDr);
                        $CR = mysql_fetch_array($ResultCr);
                        $groupTotal = $CR['total_cr'] - $DR['total_dr'];
                        $capitalLiabilitiesTotal += $groupTotal;

                        foreach ($Heads as $Head) {
                            $ResultDr = mysql_query("SELECT SUM(dr) AS total_dr FROM tbltransaction WHERE HeadOfAccountID = {$Head['ExpenseHeadID']} AND Date BETWEEN '$FromDate' AND '$ToDate'");
                            $ResultCr = mysql_query("SELECT SUM(cr) AS total_cr FROM tbltransaction WHERE HeadOfAccountID = {$Head['ExpenseHeadID']} AND Date BETWEEN '$FromDate' AND '$ToDate'");
                            $DR = mysql_fetch_array($ResultDr);
                            $CR = mysql_fetch_array($ResultCr);
                            $net = $CR['total_cr'] - $DR['total_dr'];

                            echo '<tr>
                                <td class="indent" style="padding-left: 60px">' . htmlspecialchars($Head['ExpenseHeadName']) . '</td>
                                <td class="amount">' . format_currency($net) . '</td>
                            </tr>';
                        }
                    }
                }
            }
        }
        ?>
        <tr class="total-row">
            <td>Total Capital & Liabilities</td>
            <td class="amount"><?php echo format_currency($capitalLiabilitiesTotal); ?></td>
        </tr>

        <!-- ===== ASSETS SECOND ===== -->
        <tr class="section-header">
            <td>Assets</td>
            <td></td>
        </tr>
        <?php
        foreach ($Balancesheet as $balanceSheetRow) {
            if ($balanceSheetRow['Category'] == "ASSETS") {
                echo '<tr class="group-header"><td style="padding-left: 20px">' . htmlspecialchars($balanceSheetRow['Name']) . '</td><td></td></tr>';

                $ParentHeads = SQL_Select("incomeexpensetype", "FinancialPositionList=" . (int)$balanceSheetRow['BalanceSheetID']);

                foreach ($ParentHeads as $TypeHead) {
                    echo '<tr class="sub-header"><td style="padding-left: 40px">' . htmlspecialchars($TypeHead['Name']) . '</td><td></td></tr>';

                    $Heads = SQL_Select("expensehead where IncomeExpenseTypeID=" . (int)$TypeHead['IncomeExpenseTypeID']);
                    $ids = array();
                    foreach ($Heads as $h) {
                        $ids[] = $h['ExpenseHeadID'];
                    }

                    if (!empty($ids)) {
                        $idList = implode(',', $ids);

                        $ResultDr = mysql_query("SELECT SUM(dr) AS total_dr FROM tbltransaction WHERE HeadOfAccountID IN ($idList) AND Date BETWEEN '$FromDate' AND '$ToDate'");
                        $ResultCr = mysql_query("SELECT SUM(cr) AS total_cr FROM tbltransaction WHERE HeadOfAccountID IN ($idList) AND Date BETWEEN '$FromDate' AND '$ToDate'");

                        $DR = mysql_fetch_array($ResultDr);
                        $CR = mysql_fetch_array($ResultCr);
                        $groupTotal = $DR['total_dr'] - $CR['total_cr'];
                        $assetsTotal += $groupTotal;

                        foreach ($Heads as $Head) {
                            $ResultDr = mysql_query("SELECT SUM(dr) AS total_dr FROM tbltransaction WHERE HeadOfAccountID = {$Head['ExpenseHeadID']} AND Date BETWEEN '$FromDate' AND '$ToDate'");
                            $ResultCr = mysql_query("SELECT SUM(cr) AS total_cr FROM tbltransaction WHERE HeadOfAccountID = {$Head['ExpenseHeadID']} AND Date BETWEEN '$FromDate' AND '$ToDate'");
                            $DR = mysql_fetch_array($ResultDr);
                            $CR = mysql_fetch_array($ResultCr);
                            $net = $DR['total_dr'] - $CR['total_cr'];

                            echo '<tr>
                                <td class="indent" style="padding-left: 60px">' . htmlspecialchars($Head['ExpenseHeadName']) . '</td>
                                <td class="amount">' . format_currency($net) . '</td>
                            </tr>';
                        }
                    }
                }
            }
        }
        ?>
        <tr class="total-row">
            <td>Total Assets</td>
            <td class="amount"><?php echo format_currency($assetsTotal); ?></td>
        </tr>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script>
        function exportToCSV() {
            let table = document.getElementById("myTable");
            let wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
            XLSX.writeFile(wb, "table_data.csv", { bookType: "csv" });
        }

        function exportToExcel() {
            let table = document.getElementById("myTable");
            let wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
            XLSX.writeFile(wb, "table_data.xlsx");
        }
    </script>
</div>
</body>
</html>
