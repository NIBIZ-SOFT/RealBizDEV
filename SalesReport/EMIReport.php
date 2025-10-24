<?php
function sendSMS($phoneNumber, $message)
{
    // echo "Sending SMS to {$phoneNumber}: {$message}\n";
}


$fromDate = $_POST['FromDate'];
$toDate = $_POST['ToDate'];
$today = date('d');

$project = $_POST['CategoryID'];
$salesID = $GetScheduleDataRow['SalesID'];
$PName = SQL_Select("category", "CategoryID=$project", "", true);

$GetScheduleData = SQL_Select("SchedulePayment", "Date BETWEEN '{$fromDate}' and '{$toDate}'");
$uniqueSalesIDs = [];

$cumulativeAllPendingAmount = 0;

$sl = 1;
$ThisMonthDue = 0;
$TotalReceivedAmount = 0;
$NetSalesPrice = 0;
$TotalDue = 0;
$totalPending = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment Report Of <?php echo $PName['Name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }

            @page {
                size: landscape;
            }

            body {
                font-size: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="mt-4" style="margin: 0 auto; width: 90%;">
        <div class="d-flex justify-content-between">
            <p><strong>Date Of Printing:</strong> <?= date('F j, Y, h:i:sa') ?></p>
            <p><strong>From:</strong> <?= date('F j, Y', strtotime($fromDate)) ?> <strong>To:</strong> <?= date('F j, Y', strtotime($toDate)) ?></p>
        </div>

        <h2 class="text-center">EMI Pending Payment's OF <?php echo $PName['Name']; ?> Report</h2>
        <hr>

        <div class="no-print">
            <button class="btn btn-info" onclick="exportToCSV()">Export to CSV</button>
            <button class="btn btn-success" onclick="exportToExcel()">Export to Excel</button>
            <button onclick="window.print()" class="btn btn-primary print-btn">Print</button>
        </div>



        <table id="myTable" class="mt-4 table table-hover table-sm table-bordered">
            <thead>
                <tr style='text-align: center; vertical-align: middle'>
                    <th>SL.</th>
                    <th>Customer Name</th>
                    <th>Flat Type</th>
                    <th>Sales ID</th>
                    <th>Seller Name</th>
                    <th>This Month Term</th>
                    <th>This Month Scheduled (Tk)</th>
                    <th>This Month Received (Tk)</th>


                    <!-- <th>All Term</th> -->
                    <th>Total Pending OF Scheduled Amount (Tk)</th>

                    <th>Total Received (Tk)</th>
                    <th>Net Price (Tk)</th>
                    <th>Total Due (Tk)</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>

                <?php
                foreach ($GetScheduleData as $GetScheduleDataRow) {
                    $salesID = $GetScheduleDataRow['SalesID'];

                    if (!in_array($salesID, $uniqueSalesIDs)) {
                        $uniqueSalesIDs[] = $salesID;


                        $tblsales = SQL_Select("sales", "SalesID = {$salesID}");
                        if (empty($tblsales)) continue;

                        $customerPhone = $tblsales[0]['CustomerPhone'];
                        $customerName = $tblsales[0]['CustomerName'];
                        $sellerName = $tblsales[0]['SellerName'];
                        $productID = (int)$salesInfo[0]['ProductID'];


                        $productIDs = explode(",", $tblsales[0]['ProductID']);

                        foreach ($productIDs as $productID) {
                            $productID = (int)trim($productID);
                            if ($productID <= 0) continue;

                            $ProductsInfo = SQL_Select("products", "ProductsID = {$productID}");
                            if (!empty($ProductsInfo)) {
                                $FlatType = $ProductsInfo[0]['FlatType'];
                            }
                        }






                        $pendingQuery = "
                            SELECT 
                                SP.SalesID,
                                P.NetSalesPrice,
                                'All Until Today' AS InstallmentTerm,
                                SUM(CASE WHEN SP.Date BETWEEN '$fromDate' AND '$toDate' THEN SP.PayAbleAmount ELSE 0 END) AS ThisMonthDue,
                                MAX(CASE WHEN SP.Date BETWEEN '$fromDate' AND '$toDate' THEN SP.Title ELSE NULL END) AS ThisMonthTerm,
                                SUM(SP.PayAbleAmount) AS DueAmount,
                                MAX(SP.Date) AS DueDate,
                                IFNULL(SUM(ASP.ActualReceiveAmount), 0) AS TotalReceivedAmount,
                                SUM(CASE WHEN ASP.DateOfCollection BETWEEN '$fromDate' AND '$toDate' THEN ASP.ActualReceiveAmount ELSE 0 END) AS ReceivedAmount,
                                P.NetSalesPrice - IFNULL(SUM(ASP.ActualReceiveAmount), 0) AS PendingAmount
                            FROM 
                                tblschedulepayment SP
                            LEFT JOIN 
                                tblactualsalsepayment ASP 
                                ON SP.SalesID = ASP.SalesID AND SP.Title = ASP.Term
                            INNER JOIN 
                                tblsales S ON SP.SalesID = S.SalesID
                            INNER JOIN 
                                tblproducts P ON S.ProductID = P.ProductsID
                            WHERE 
                                SP.Date <= '$toDate'
                                AND SP.SalesID = $salesID
                            GROUP BY 
                                SP.SalesID, P.NetSalesPrice
                            HAVING 
                                PendingAmount > 0
                    ";




                        $pendingResult = mysql_query($pendingQuery);
                        if (!$pendingResult) {
                            die("Query failed: " . mysql_error());
                        }



                        while ($row = mysql_fetch_assoc($pendingResult)) {
                            if ($tblsales[0]['ProjectID'] != $project) continue;
                            // <td style='text-align: center;'>{$row['InstallmentTerm']}</td>
                            $Paid = "";
                            if ($row['ThisMonthDue'] == $row['ReceivedAmount']) {
                                // continue;
                                $Paid = "style='background-color:rgb(8, 255, 65); text-align: center; width: 115px';";
                            } else if ($row['ReceivedAmount'] > 0) {
                                $Paid = "style='background-color:rgb(212, 117, 22); text-align: center; width: 115px;'";
                            }
                            echo "<tr>
                        <td style='text-align: center;'>{$sl}</td>
                        <td>CID:{$tblsales[0]['CustomerID']} - {$customerName}</td>
                        <td style='text-align: center;'>{$FlatType}</td>
                        <td style='text-align: center;'>{$salesID}</td>
                        <td>ID:{$tblsales[0]['SellerID']} - {$sellerName}</td>
                        <td style='text-align: center;'>{$row['ThisMonthTerm']}</td>
                        <td style='text-align: center; width: 115px;'>" . BangladeshiCurencyFormat($row['ThisMonthDue']) . "</td>

                        <td {$Paid}'>" . BangladeshiCurencyFormat($row['ReceivedAmount']) . "</td>

                        <td style='text-align: center; width: 115px;'>" . BangladeshiCurencyFormat($row['DueAmount']) . "</td>

                        <td style='text-align: center; width: 115px;'>" . BangladeshiCurencyFormat($row['TotalReceivedAmount']) . "</td>
                        <td style='text-align: center; width: 115px;'>" . BangladeshiCurencyFormat($row['NetSalesPrice']) . "</td>
                        <td style='text-align: center; width: 115px;'>" . BangladeshiCurencyFormat($row['PendingAmount']) . "</td>
                        <td style='text-align: center; width: 115px;'>{$row['DueDate']}</td>
                    </tr>";

                            $sl++;
                            $ThisMonthDue += $row['ThisMonthDue'];
                            $totalDue += $row['DueAmount'];
                            $TotalReceivedAmount += $row['TotalReceivedAmount'];
                            $NetSalesPrice += $row['NetSalesPrice'];
                            $totalPending += $row['PendingAmount'];
                            $cumulativeAllPendingAmount += $row['PendingAmount'];
                            $cumulativeTotalReceivedAmount += $row['ReceivedAmount'];
                        }

                        if ($totalPending > 0) {
                            $formattedPending = BangladeshiCurencyFormat($totalPending);
                            $formattedDue = BangladeshiCurencyFormat($ThisMonthDue);

                            $smsBody = "সম্মানিত গ্রাহক, আসসালামু আলাইকুম, আপনার মোট বকেয়া- {$formattedPending}/= এবং চলতি মাসের বকেয়া কিস্তির পরিমান - {$formattedDue}/= টাকা, যা যথা সময়ে পরিশোধ করার জন্য অনুরোধ করা হল। (যদি ইতোমধ্যে পরিশোধ করে থাকেন তাহলে এই এসএমএস টি উপেক্ষা করুন।) ধন্যবাদান্তে";

                            if ($today == '05' || ($today == '22' && $totalPending > 0)) {
                                sendSMS($customerPhone, $smsBody);
                            }
                        }

                        mysql_free_result($pendingResult);
                    }
                }
                ?>

                <tr>
                    <td colspan="6" class="text-end fw-bold">Total =</td>
                    <td style='text-align: center; width: 115px;' class="fw-bold"><?= BangladeshiCurencyFormat($ThisMonthDue) ?></td>
                    <td style='text-align: center; width: 115px;' class="fw-bold"><?= BangladeshiCurencyFormat($cumulativeTotalReceivedAmount) ?></td>
                    <td style='text-align: center; width: 115px;' class="fw-bold"><?= BangladeshiCurencyFormat($totalDue) ?></td>
                    <td style='text-align: center; width: 115px;' class="fw-bold"><?= BangladeshiCurencyFormat($TotalReceivedAmount) ?></td>
                    <td style='text-align: center; width: 115px;' class="fw-bold"><?= BangladeshiCurencyFormat($NetSalesPrice) ?></td>
                    <td style='text-align: center; width: 115px;' class="fw-bold"><?= BangladeshiCurencyFormat($cumulativeAllPendingAmount) ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>


    </div>

    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script>
        function exportToCSV() {
            let table = document.getElementById("myTable");
            let wb = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });
            XLSX.writeFile(wb, "table_data.csv", {
                bookType: "csv"
            });
        }

        function exportToExcel() {
            let table = document.getElementById("myTable");
            let wb = XLSX.utils.table_to_book(table, {
                sheet: "Sheet1"
            });
            XLSX.writeFile(wb, "table_data.xlsx");
        }
    </script>
</body>

</html>