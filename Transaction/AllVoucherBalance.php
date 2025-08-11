<?php
$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

$FromDate = isset($_POST["FromDate"]) ? $_POST["FromDate"] : null;
$ToDate = isset($_POST["ToDate"]) ? $_POST["ToDate"] : null;
$CategoryID = isset($_POST["CategoryID"]) ? $_POST["CategoryID"] : null;

if (empty($CategoryID)) {
    die("CategoryID must be provided.");
}

$where = "ProjectID = " . intval($CategoryID);

if (!empty($FromDate) && !empty($ToDate)) {
    $where .= " AND Date BETWEEN '" . $FromDate . "' AND '" . $ToDate . "'";
}

$CrData      = SQL_Select("transaction WHERE VoucherType = 'CV' AND " . $where);
$DrData      = SQL_Select("transaction WHERE VoucherType = 'DV' AND " . $where);
$ContraData  = SQL_Select("transaction WHERE VoucherType = 'Contra' AND " . $where);
$JournalData = SQL_Select("transaction WHERE VoucherType = 'JV' AND " . $where);

// Start building $MainContent
$MainContent = '
<!DOCTYPE html>
<html>
<head>
    <title>Transaction Reports</title>
    <!-- Bootstrap 4 CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .table-striped tbody tr:nth-of-type(odd)
        Specificity: (0,2,2)
        {
            background-color: rgba(255, 255, 255, 0.05)
        }
    </style>
</head>
<body>

<div class="mt-4 mb-5" style="width: 90%; margin: 0 auto;">

<h1 class="text-center mb-4">Transaction Reports</h1>

<div class="row">

    <!-- Credit Voucher -->
    <div class="col-md-6 mb-4">
        <h4 class="mb-3">Credit Voucher</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>TransactionID</th>
                        <th>Customer</th>
                        <th>Bank/Cash Name</th>
                        <th>Head of Account Name</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th class="text-right">Debit (dr)</th>
                        <th class="text-right">Credit (cr)</th>
                    </tr>
                </thead>
                <tbody>
';

if (!empty($CrData)) {
    $totalDr = 0;
    $totalCr = 0;
    foreach ($CrData as $row) {
        $dr = floatval($row['dr']);
        $cr = floatval($row['cr']);
        $totalDr += $dr;
        $totalCr += $cr;

        $MainContent .= '
            <tr>
                <td>' . $row['TransactionID'] . '</td>
                <td>' . htmlspecialchars($row['CustomerName']) . '</td>
                <td>' . htmlspecialchars($row['BankCashName']) . '</td>
                <td>' . htmlspecialchars($row['HeadOfAccountName']) . '</td>
                <td>' . $row['Date'] . '</td>
                <td>' . $row['VoucherType'] . '</td>
                <td class="text-right">' . number_format($dr, 2) . '</td>
                <td class="text-right">' . number_format($cr, 2) . '</td>
            </tr>
        ';
    }
    $MainContent .= '
            <tr class="font-weight-bold bg-success text-white">
                <td colspan="6" class="text-right">TOTAL</td>
                <td class="text-right">' . number_format($totalDr, 2) . '</td>
                <td class="text-right">' . number_format($totalCr, 2) . '</td>
            </tr>
    ';
} else {
    $MainContent .= '
        <tr><td colspan="8" class="text-center">No data found</td></tr>
    ';
}

$MainContent .= '
                </tbody>
            </table>
        </div>
    </div>

    <!-- Debit Voucher -->
    <div class="col-md-6 mb-4">
        <h4 class="mb-3">Debit Voucher</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>TransactionID</th>
                        <th>Vendor / Contractor Name</th>
                        <th>Bank/Cash Name</th>
                        <th>Head of Account Name</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th class="text-right">Debit (dr)</th>
                        <th class="text-right">Credit (cr)</th>
                    </tr>
                </thead>
                <tbody>
';

if (!empty($DrData)) {
    $totalDr = 0;
    $totalCr = 0;
    foreach ($DrData as $row) {
        $dr = floatval($row['dr']);
        $cr = floatval($row['cr']);
        $totalDr += $dr;
        $totalCr += $cr;

        $MainContent .= '
            <tr>
                <td>' . $row['TransactionID'] . '</td>
        ';
        if (!empty($row['VendorName'])) {
            $MainContent .= '<td>' . htmlspecialchars($row['VendorName']) . '</td>';
        } elseif (!empty($row['ContructorName'])) {
            $MainContent .= '<td>' . htmlspecialchars($row['ContructorName']) . '</td>';
        } else {
            $MainContent .= '<td>-</td>';
        }
        $MainContent .= '
                <td>' . $row['BankCashName'] . '</td>
                <td>' . htmlspecialchars($row['HeadOfAccountName']) . '</td>
                <td>' . $row['Date'] . '</td>
                <td>' . $row['VoucherType'] . '</td>
                <td class="text-right">' . number_format($dr, 2) . '</td>
                <td class="text-right">' . number_format($cr, 2) . '</td>
            </tr>
        ';
    }
    $MainContent .= '
            <tr class="font-weight-bold bg-success text-white">
                <td colspan="6" class="text-right">TOTAL</td>
                <td class="text-right">' . number_format($totalDr, 2) . '</td>
                <td class="text-right">' . number_format($totalCr, 2) . '</td>
            </tr>
    ';
} else {
    $MainContent .= '
        <tr><td colspan="8" class="text-center">No data found</td></tr>
    ';
}

$MainContent .= '
                </tbody>
            </table>
        </div>
    </div>

</div> <!-- end first row -->

<div class="row">

    <!-- Contra Voucher -->
    <div class="col-md-6 mb-4">
        <h4 class="mb-3">Contra Voucher</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>TransactionID</th>
                        <th>Bank/Cash Name</th>
                        <th>Head of Account Name</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th class="text-right">Debit (dr)</th>
                        <th class="text-right">Credit (cr)</th>
                    </tr>
                </thead>
                <tbody>
';

if (!empty($ContraData)) {
    $totalDr = 0;
    $totalCr = 0;
    foreach ($ContraData as $row) {
        $dr = floatval($row['dr']);
        $cr = floatval($row['cr']);
        $totalDr += $dr;
        $totalCr += $cr;

        $MainContent .= '
            <tr>
                <td>' . $row['TransactionID'] . '</td>
                <td>' . $row['BankCashName'] . '</td>
                <td>' . htmlspecialchars($row['HeadOfAccountName']) . '</td>
                <td>' . $row['Date'] . '</td>
                <td>' . $row['VoucherType'] . '</td>
                <td class="text-right">' . number_format($dr, 2) . '</td>
                <td class="text-right">' . number_format($cr, 2) . '</td>
            </tr>
        ';
    }
    $MainContent .= '
            <tr class="font-weight-bold bg-success text-white">
                <td colspan="5" class="text-right">TOTAL</td>
                <td class="text-right">' . number_format($totalDr, 2) . '</td>
                <td class="text-right">' . number_format($totalCr, 2) . '</td>
            </tr>
    ';
} else {
    $MainContent .= '
        <tr><td colspan="7" class="text-center">No data found</td></tr>
    ';
}

$MainContent .= '
                </tbody>
            </table>
        </div>
    </div>

    <!-- Journal Voucher -->
    <div class="col-md-6 mb-4">
        <h4 class="mb-3">Journal Voucher</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>TransactionID</th>
                        <th>Bank/Cash Name</th>
                        <th>Head of Account Name</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th class="text-right">Debit (dr)</th>
                        <th class="text-right">Credit (cr)</th>
                    </tr>
                </thead>
                <tbody>
';

if (!empty($JournalData)) {
    $totalDr = 0;
    $totalCr = 0;
    foreach ($JournalData as $row) {
        $dr = floatval($row['dr']);
        $cr = floatval($row['cr']);
        $totalDr += $dr;
        $totalCr += $cr;

        $MainContent .= '
            <tr>
                <td>' . $row['TransactionID'] . '</td>
                <td>' . $row['BankCashName'] . '</td>
                <td>' . htmlspecialchars($row['HeadOfAccountName']) . '</td>
                <td>' . $row['Date'] . '</td>
                <td>' . $row['VoucherType'] . '</td>
                <td class="text-right">' . number_format($dr, 2) . '</td>
                <td class="text-right">' . number_format($cr, 2) . '</td>
            </tr>
        ';
    }
    $MainContent .= '
            <tr class="font-weight-bold bg-success text-white">
                <td colspan="5" class="text-right">TOTAL</td>
                <td class="text-right">' . number_format($totalDr, 2) . '</td>
                <td class="text-right">' . number_format($totalCr, 2) . '</td>
            </tr>
    ';
} else {
    $MainContent .= '
        <tr><td colspan="7" class="text-center">No data found</td></tr>
    ';
}


$totalStockValue=0;
$totalUsedStockValue=0;

$stocks= SQL_Select("stock where ProjectID={$CategoryID} and StockIsActive=1 and  Date BETWEEN '{$FromDate}' AND  '{$ToDate}'");
$UsedStocks= SQL_Select("usedstock where ProjectID={$CategoryID}  and UsedStockIsActive=1  and  Date BETWEEN '{$FromDate}' AND  '{$ToDate}'");

$PurchaseOrder = SQL_Select("purchase where CategoryID={$CategoryID} and Confirm='Confirm' and IssuingDate BETWEEN '{$FromDate}' AND '{$ToDate}'");


foreach ($stocks as $stock){
    $totalStockValue +=$stock["Value"];
}

foreach ($UsedStocks as $UsedStock){
    $totalUsedStockValue +=$UsedStock["Value"];
}

foreach ($PurchaseOrder as $Order){
    $totalPurchaseAmount +=$Order["PurchaseAmount"];
}


$PresentStock = $totalStockValue - $totalUsedStockValue;



$MainContent .= '
            </tbody>
        </table>
    </div>
</div>

</div> <!-- end second row -->

<div class="row">

    <div class="col-md-12">
        <h4 class="mb-3 text-center">Stock Report</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th>Purchase Order</th>
                        <th>Total Stock Value</th>
                        <th>Total Used Stock Value</th>
                        <th>Present Stock Value</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>' . number_format($totalPurchaseAmount, 2) . '</td>
                        <td>' . number_format($totalStockValue, 2) . '</td>
                        <td>' . number_format($totalUsedStockValue, 2) . '</td>
                        <td>' . number_format($PresentStock, 2) . '</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Start Purchase Order -->
    <div class="col-md-6 text-center mt-4">
        <h4 class="mb-3 text-center">Purchase Order</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th rowspan="2">SL</th>
                        <th rowspan="2">Date</th>
                        <th rowspan="2">Purchase ID</th>
                        <th rowspan="2">Requisition ID</th>
                        <th rowspan="2">Vendor Name</th>
                        <th colspan="4" class="text-center">Items</th>
                    </tr>
                    <tr>
                        <th>Expense Head Name</th>
                        <th>Qty</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
';


$totalQty = 0;
$totalRate = 0;
$totalAmount = 0;

foreach ($PurchaseOrder as $key => $Order) {
    $items = json_decode($Order['Items'], true);

    $rowspan = is_array($items) ? count($items) : 1;
    if ($rowspan < 1) $rowspan = 1;

    $firstItem = true;

    $sumQty = 0;
    $sumRate = 0;
    $sumAmount = 0;

    if (is_array($items) && count($items) > 0) {
        foreach ($items as $item) {
            $qty = floatval($item['requisitionQty']);
            $rate = floatval($item['requisitionRate']);
            $amount = floatval($item['requisitionAmount']);
            $expenseHeadName = htmlspecialchars($item['expenseHeadName']);

            $sumQty += $qty;
            $sumRate += $rate;
            $sumAmount += $amount;

            if ($firstItem) {
                $MainContent .= '<tr>';
                $MainContent .= '<td rowspan="' . $rowspan . '">' . ($key + 1) . '</td>';
                $MainContent .= '<td rowspan="' . $rowspan . '">' . $Order['IssuingDate'] . '</td>';
                $MainContent .= '<td rowspan="' . $rowspan . '">' . htmlspecialchars($Order['PurchaseID']) . '</td>';
                $MainContent .= '<td rowspan="' . $rowspan . '">' . htmlspecialchars($Order['confirmRequisitonName']) . '</td>';
                $MainContent .= '<td rowspan="' . $rowspan . '">' . htmlspecialchars($Order['VendorName']) . '</td>';

                $MainContent .= '<td>' . $expenseHeadName . '</td>';
                $MainContent .= '<td class="text-right">' . number_format($qty, 2) . '</td>';
                $MainContent .= '<td class="text-right">' . number_format($rate, 2) . '</td>';
                $MainContent .= '<td class="text-right">' . number_format($amount, 2) . '</td>';
                $MainContent .= '</tr>';

                $firstItem = false;
            } else {
                $MainContent .= '<tr>';
                $MainContent .= '<td>' . $expenseHeadName . '</td>';
                $MainContent .= '<td class="text-right">' . number_format($qty, 2) . '</td>';
                $MainContent .= '<td class="text-right">' . number_format($rate, 2) . '</td>';
                $MainContent .= '<td class="text-right">' . number_format($amount, 2) . '</td>';
                $MainContent .= '</tr>';
            }
        }
    } else {
        // No items, still output one row
        $MainContent .= '<tr>';
        $MainContent .= '<td>' . ($key + 1) . '</td>';
        $MainContent .= '<td>' . $Order['IssuingDate'] . '</td>';
        $MainContent .= '<td>' . htmlspecialchars($Order['PurchaseID']) . '</td>';
        $MainContent .= '<td>' . htmlspecialchars($Order['RequisitionID']) . '</td>';
        $MainContent .= '<td>' . htmlspecialchars($Order['VendorName']) . '</td>';
        $MainContent .= '<td colspan="4" class="text-center">No items</td>';
        $MainContent .= '</tr>';
    }

    $totalQty += $sumQty;
    $totalRate += $sumRate;
    $totalAmount += $sumAmount;
}

$MainContent .= '
    <tr class="font-weight-bold bg-success text-white">
        <td colspan="5" class="text-right">TOTAL</td>
        <td></td>
        <td class="text-right">' . number_format($totalQty, 2) . '</td>
        <td class="text-right">' . number_format($totalRate, 2) . '</td>
        <td class="text-right">' . number_format($totalAmount, 2) . '</td>
    </tr>

';










$MainContent .= '
            </tbody>
        </table>
        </div>
    </div>
';


$MainContent .= '
    <!-- Start Total Stock -->
    <div class="col-md-6 text-center mt-4">
        <h4 class="mb-3 text-center">Total Stock</h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm">
                <thead>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Head of Account</th>
                    <th>QTY</th>
                    <th>Rate</th>
                    <th>Amount</th>
                </thead>
                <tbody>
';

$totalQty = 0;
$totalAmount = 0;
foreach ($stocks as $key => $stock) {
    $totalQty += $stock['Qty'];
    $totalAmount += $stock['Value'];
    $MainContent .= '
                <tr>
                    <td>' . ($key + 1) . '</td>
                    <td>' . $stock['Date'] . '</td>
                    <td>' . htmlspecialchars($stock['HeadOfAccountName']) . '</td>
                    <td>' . number_format($stock['Qty'], 2) . '</td>
                    <td>' . number_format($stock['Rate'], 2) . '</td>
                    <td>' . number_format($stock['Value'], 2) . '</td>
                </tr>
    ';
}
$MainContent .= '
                <tr class="font-weight-bold bg-success text-white">
                    <td colspan="3" class="text-right">TOTAL</td>
                    <td>' . number_format($totalQty, 2) . '</td>
                    <td></td>
                    <td>' . number_format($totalAmount, 2) . '</td>
                </tr>
            </tbody>
        </table>
    </div>
</div> <!-- end Total Stock -->

<div class="col-md-6 text-center mt-4">
    <h4 class="mb-3 text-center">Used Stock</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <th>SL</th>
                <th>Date</th>
                <th>Head of Account</th>
                <th>QTY</th>
                <th>Rate</th>
                <th>Amount</th>
            </thead>
            <tbody>
';

$totalUsedQty = 0;
$totalUsedAmount = 0;
foreach ($UsedStocks as $key => $UsedStock) {
    $totalUsedQty += $UsedStock['Qty'];
    $totalUsedAmount += $UsedStock['Value'];
    $MainContent .= '
                <tr>
                    <td>' . ($key + 1) . '</td>
                    <td>' . $UsedStock['Date'] . '</td>
                    <td>' . htmlspecialchars($UsedStock['HeadOfAccountName']) . '</td>
                    <td>' . number_format($UsedStock['Qty'], 2) . '</td>
                    <td>' . number_format($UsedStock['Rate'], 2) . '</td>
                    <td>' . number_format($UsedStock['Value'], 2) . '</td>
                </tr>
    ';
}
$MainContent .= '
                <tr class="font-weight-bold bg-success text-white">
                    <td colspan="3" class="text-right">TOTAL</td>
                    <td>' . number_format($totalUsedQty, 2) . '</td>
                    <td></td>
                    <td>' . number_format($totalUsedAmount, 2) . '</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-6 text-center mt-4">
    <h4 class="mb-3 text-center">Present Stock</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <th>SL</th>
                <th>Date</th>
                <th>Head of Account</th>
                <th>QTY</th>
                <th>Rate</th>
                <th>Amount</th>
            </thead>
            <tbody>
';

$totalPresentQty = 0;
$totalPresentAmount = 0;

foreach ($stocks as $key => $stock) {

    $usedQtyForThis = 0;
    foreach ($UsedStocks as $u) {
        if ($u['HeadOfAccountID'] == $stock['HeadOfAccountID'] && $u['ProjectID'] == $stock['ProjectID']) {
            $usedQtyForThis += $u['Qty'];
        }
    }


    $presentQty = $stock['Qty'] - $usedQtyForThis;


    if ($presentQty <= 0) {
        continue;
    }

    $presentAmount = $presentQty * $stock['Rate'];

    $totalPresentQty += $presentQty;
    $totalPresentAmount += $presentAmount;

    $MainContent .= '
        <tr>
            <td>' . ($key + 1) . '</td>
            <td>' . $stock['Date'] . '</td>
            <td>' . htmlspecialchars($stock['HeadOfAccountName']) . '</td>
            <td>' . number_format($presentQty, 2) . '</td>
            <td>' . number_format($stock['Rate'], 2) . '</td>
            <td>' . number_format($presentAmount, 2) . '</td>
        </tr>
    ';
}

$MainContent .= '
            <tr class="font-weight-bold bg-success text-white">
                <td colspan="3" class="text-right">TOTAL</td>
                <td>' . number_format($totalPresentQty, 2) . '</td>
                <td></td>
                <td>' . number_format($totalPresentAmount, 2) . '</td>
            </tr>
        </tbody>
    </table>
</div>
';


$MainContent .= '</div> <!-- end Present Stock -->  
';


$MainContent .= '
<div class="col-md-6 text-center mt-4">
    <h4 class="mb-3 text-center">Bank Cash Report</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <th>SL</th>
                <th>Date</th>
                <th>Head of Account</th>
                <th>QTY</th>
                <th>Rate</th>
                <th>Amount</th>
            </thead>
            <tbody>
';

$AllBankCash      = SQL_Select("BankCash");

$totalCR = 0;

foreach ($AllBankCash as $key => $BankCash) {
    $Transactions      = SQL_Select("transaction WHERE VoucherType != 'JV' AND BankCashID = {$BankCash['BankCashID']} and ProjectID={$CategoryID} and Date BETWEEN '{$FromDate}' AND '{$ToDate}'");

    foreach ($Transactions as $tx) {
        if (isset($tx['cr']) && is_numeric($tx['cr'])) {
            $totalCR += $tx['cr']; 
        }
    }
    echo "Bank: " . $BankCash['BankCashName'] . " | Total CR: " . $totalCR . "<br>";
    



}
$MainContent .= '
</div> <!-- end third row -->

</div> <!-- container end -->

</body>
</html>
';
