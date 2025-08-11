<?php
/**
 * Party Ledger Report
 * Created by PhpStorm.
 * User: Mahmud
 * Date: 6/20/2019
 * Time: 1:09 PM
 */

// Assuming these functions are defined elsewhere in your application
// function SQL_Select($table, $condition = "", $order = "", $limit = false) { ... }
// function HumanReadAbleDateFormat($date) { ... }
// function BangladeshiCurencyFormat($amount) { ... }

$_REQUEST["CategoryID"] = 116;
$_REQUEST["customer_id"] = 1124;
$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

if (!empty($_REQUEST["CategoryID"]) and !empty($_REQUEST["customer_id"])) {
    $CustomerDetails = SQL_Select("customer Where CustomerID={$_REQUEST["customer_id"]}");
    $ProjectDetails = SQL_Select("category", "CategoryID={$_REQUEST['CategoryID']}");
    $saleIds = SQL_Select("sales", "CustomerID={$_REQUEST['customer_id']} AND ProjectID={$_REQUEST['CategoryID']}");

    $salesData = [];
    foreach ($saleIds as $sale) {
        $saleDetails = SQL_Select("sales", "SalesID={$sale['SalesID']}", "", true);
        $productDetails = SQL_Select("products", "ProductsID={$saleDetails['ProductID']}", "", true);
        $schedulePayments = SQL_Select("schedulepayment", "SalesID={$sale['SalesID']}");
        $actualPayments = SQL_Select("Actualsalsepayment", "SalesID={$sale['SalesID']}");

        $totalValue = $saleDetails['Quantity'] * $productDetails['FlatPrice'];
        $grandTotal = $totalValue - $saleDetails['Discount'];
        $totalReceived = array_sum(array_column($actualPayments, 'ActualReceiveAmount'));
        $totalDue = $grandTotal - $totalReceived;

        $salesData[] = [
            'saleDetails' => $saleDetails,
            'productDetails' => $productDetails,
            'schedulePayments' => $schedulePayments,
            'actualPayments' => $actualPayments,
            'totalValue' => $totalValue,
            'grandTotal' => $grandTotal,
            'totalReceived' => $totalReceived,
            'totalDue' => $totalDue
        ];
    }
} else {
    die("Invalid request parameters.");
}
?>
<?php
$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Party Ledger</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            padding: 20px;
        }

        .card {
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            font-size: 1.1rem;
            border-radius: 8px 8px 0 0;
        }

        .card-body {
            padding: 1.5rem;
            background-color: #fff;
        }

        .table-sm th, .table-sm td {
            padding: 0.8rem;
            border: 1px solid #dee2e6;
        }

        .table-sm th {
            background-color: #f1f3f5;
            font-weight: 600;
        }

        .text-end {
            text-align: right;
        }

        h1 {
            font-size: 2rem;
            color: #333;
            font-weight: 600;
        }

        h6 {
            font-size: 1rem;
            color: #555;
            font-weight: 600;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }

        /* Hover effect for tables */
        .table-hover tbody tr:hover {
            background-color: #f1f3f5;
        }

        /* Styling for the footer section */
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>

<div style="width: 95%; margin: auto">

    <p style="font-size: 16px">Printing Date & Time: <?=date('F j-y, h:i:sa')?></p>

</div>
<div style="padding: 10px 0px;" class="company-name row">

    <div class="col-md-2 text-center">

        <img height="70px" src="https://nibizsoft.net/Sunset/upload/WhatsApp%20Image%202024-12-10%20at%207.21.27%20PM.jpeg" alt="">

    </div>

    <div class="col-md-9 text-center">

        <h3 style="font-weight: bold"><?=$Settings["CompanyName"]?></h3>

        <p style="font-size: 18px;"><?=$Settings["Address"]?></p>

    </div>

</div>
<div style="border: 1px solid #ddd; border-radius: 8px;" class="mt-5 bg-white p-3">
    <h1 class="text-center mb-4">Party Ledger</h1>

    <div class="row">
        <!-- Customer Information -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="text-center mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <td>Customer ID:</td>
                            <td><?php echo $CustomerDetails[0]['CustomerID']; ?></td>
                        </tr>
                        <tr>
                            <td>Name:</td>
                            <td><?php echo $CustomerDetails[0]['CustomerName']; ?></td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td><?php echo $CustomerDetails[0]['Address']; ?></td>
                        </tr>
                        <tr>
                            <td>Phone:</td>
                            <td><?php echo $CustomerDetails[0]['Phone']; ?></td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td><?php echo $CustomerDetails[0]['CustomerEmail']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Project Information -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="text-center mb-0">Project Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <tr>
                            <td>Project Name:</td>
                            <td><?php echo $ProjectDetails[0]['Name']; ?></td>
                        </tr>
                        <tr>
                            <td>Location:</td>
                            <td><?php echo $ProjectDetails[0]['Address']; ?></td>
                        </tr>
                        <tr>
                            <td>Facing:</td>
                            <td><?php echo $ProjectDetails[0]['Facing']; ?></td>
                        </tr>
<!--                        <tr>-->
<!--                            <td>Sales Date:</td>-->
<!--                            <td>--><?php //echo HumanReadAbleDateFormat($ProjectDetails[0]['SalesDate']); ?><!--</td>-->
<!--                        </tr>-->
<!--                        <tr>-->
<!--                            <td>Handover Date:</td>-->
<!--                            <td>--><?php //echo HumanReadAbleDateFormat($ProjectDetails[0]['HandOver']); ?><!--</td>-->
<!--                        </tr>-->
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Information -->
    <?php foreach ($salesData as $index => $sale): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Package <?php echo $index + 1; ?>: <?php echo $sale['saleDetails']['ProductName']; ?></h5>
            </div>
            <div class="card-body">
                <!-- Share Value Summary -->
                <div class="col-md-12">
                    <h6 style="text-align: center" class="mb-3">Share Value Summary</h6>

                    <table class="table table-sm table-bordered">
                        <tr>
                            <td>Price:</td>
                            <td class="text-end"><?php echo BangladeshiCurencyFormat($sale['productDetails']['FlatPrice']); ?></td>
                        </tr>
                        <tr>
                            <td>Quantity:</td>
                            <td class="text-end"><?php echo $sale['saleDetails']['Quantity']; ?></td>
                        </tr>
                        <tr>
                            <td>Total Value:</td>
                            <td class="text-end"><?php echo BangladeshiCurencyFormat($sale['totalValue']); ?></td>
                        </tr>
                        <tr>
                            <td>Discount:</td>
                            <td class="text-end"><?php echo BangladeshiCurencyFormat($sale['saleDetails']['Discount']); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Grand Total:</strong></td>
                            <td class="text-end"><strong><?php echo BangladeshiCurencyFormat($sale['grandTotal']); ?></strong></td>
                        </tr>
                    </table>

                </div>

                <!-- Payment History -->

                <div class="card-header">
                    <h5  class="text-center mb-0">Payment History</h5>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mt-2" style="text-align: center">Schedule Payments</h6>
                        <table class="table table-sm table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Term</th>
                                <th class="text-end">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($sale['schedulePayments'] as $payment): ?>
                                <tr>
                                    <td><?php echo HumanReadAbleDateFormat($payment['Date']); ?></td>
                                    <td><?php echo $payment['Title']; ?></td>
                                    <td class="text-end"><?php echo BangladeshiCurencyFormat($payment['PayAbleAmount']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mt-2" style="text-align: center">Actual Payments</h6>
                        <table class="table table-sm table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Date of Collection</th>
                                <th>Term</th>
                                <th class="text-end">Received Amount</th>
                                <th>MRR No</th>
                                <th>Mode of Payment</th>
                                <th>Cheque No</th>
                                <th>Bank Name</th>
                                <th>Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($sale['actualPayments'] as $payment): ?>
                                <tr>
                                    <td><?php echo HumanReadAbleDateFormat($payment['DateOfCollection']); ?></td>
                                    <td><?php echo $payment['Term']; ?></td>
                                    <td class="text-end"><?php echo BangladeshiCurencyFormat($payment['ActualReceiveAmount']); ?></td>
                                    <td><?php echo $payment['MRRNO']; ?></td>
                                    <td><?php echo $payment['ModeOfPayment']; ?></td>
                                    <td><?php echo $payment['ChequeNo']; ?></td>
                                    <td><?php echo $payment['BankName']; ?></td>
                                    <td><?php echo $payment['Remark']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Payment Summary -->
                <h6 class="mt-4 mb-3">Payment Summary</h6>
                <table class="table table-sm table-bordered">
                    <tr>
                        <td>Total Received Amount:</td>
                        <td class="text-end"><?php echo BangladeshiCurencyFormat($sale['totalReceived']); ?></td>
                    </tr>
                    <tr>
                        <td>Total Due Amount:</td>
                        <td class="text-end"><?php echo BangladeshiCurencyFormat($sale['totalDue']); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
