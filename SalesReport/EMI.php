<?php

$fromDate = "2024-01-01";
$toDate = "2025-01-01";

//$fromDate = $_REQUEST["FromDate"];
//$toDate = $_REQUEST["FromDate"];

//$GetScheduleData =  SQL_Select("SchedulePayment","Date BETWEEN '{$fromDate}' and '{$toDate}'");
//$uniqueSalesIDs = [];
//
//foreach ($GetScheduleData as $GetScheduleDataRow) {
//    $salesID = $GetScheduleDataRow['SalesID'];
//    if (!in_array($salesID, $uniqueSalesIDs)) {
//        $uniqueSalesIDs[] = $salesID;

$salesID = 127;           // SalesID
// Pending Payment's From Date Range
                        $pendingQuery = "
                            SELECT 
                                SP.SchedulePaymentID,
                                SP.SalesID,
                                SP.Title AS InstallmentTerm,
                                SP.PayAbleAmount AS DueAmount,
                                SP.Date AS DueDate,
                                IFNULL(SUM(ASP.ActualReceiveAmount), 0) AS TotalReceivedAmount,
                                (SP.PayAbleAmount - IFNULL(SUM(ASP.ActualReceiveAmount), 0)) AS PendingAmount
                            FROM 
                                tblschedulepayment SP
                            LEFT JOIN 
                                tblactualsalsepayment ASP ON SP.SalesID = ASP.SalesID AND SP.Title = ASP.Term
                            WHERE 
                                SP.Date BETWEEN '$fromDate' AND '$toDate' 
                                AND SP.SalesID = $salesID
                            GROUP BY 
                                SP.SalesID, SP.Title, SP.SchedulePaymentID
                            HAVING 
                                PendingAmount > 0
                            ORDER BY 
                                SP.Date ASC;
                        ";


                        $pendingResult = mysql_query($pendingQuery);

                        if (!$pendingResult) {
                            die("Query failed: " . mysql_error());
                        }

                        // From Date To Date  Received Payment's
                        $receivedQuery = "
                            SELECT 
                                ASP.ActualSalsePaymentID,
                                ASP.SalesID,
                                ASP.Term,
                                ASP.ReceiveAmount,
                                ASP.Adjustment,
                                ASP.ActualReceiveAmount,
                                ASP.DateOfCollection,
                                ASP.MRRNO,
                                ASP.ModeOfPayment,
                                ASP.ChequeNo,
                                ASP.BankName,
                                ASP.Remark
                            FROM 
                                tblactualsalsepayment ASP
                            WHERE 
                                ASP.SalesID = $salesID
                                AND ASP.DateOfCollection BETWEEN '$fromDate' AND '$toDate'
                            ORDER BY 
                                ASP.DateOfCollection ASC;
                        ";
                        $receivedResult = mysql_query($receivedQuery);

                        if (!$receivedResult) {
                            die("Query failed: " . mysql_error());
                        }

                        // All Received Payment's
                        $AllReceivedQuery = "
                            SELECT 
                                ASP.ActualSalsePaymentID,
                                ASP.SalesID,
                                ASP.Term,
                                ASP.ReceiveAmount,
                                ASP.Adjustment,
                                ASP.ActualReceiveAmount,
                                ASP.DateOfCollection,
                                ASP.MRRNO,
                                ASP.ModeOfPayment,
                                ASP.ChequeNo,
                                ASP.BankName,
                                ASP.Remark
                            FROM 
                                tblactualsalsepayment ASP
                            WHERE 
                                ASP.SalesID = $salesID
                            ORDER BY 
                                ASP.DateOfCollection ASC;
                        ";
                        $AllReceivedResult = mysql_query($AllReceivedQuery);

                        if (!$AllReceivedResult) {
                            die("Query failed: " . mysql_error());
                        }




?>






    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment Report</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <hr style="">
    <div class="container mt-3">
        <div class="col-md-6" style="float: left">
            <h4>Date Of Printing : <?= date('F j, Y, h:i:sa') ?></h4>
        </div>
        <div class="col-md-6" style="float: right">
            <h4>From <?= date('F j, Y', strtotime($fromDate)) ?> - To <?= date('F j, Y', strtotime($toDate)) ?></h4>
        </div>
    </div>
    <body>
    <div class="container mt-5">
        <h2 class="text-center">Payment Report of salesID - <?=$salesID ."<br><hr>";?></h2>

        <h4>Pending Payments</h4>
        <table style=" margin-bottom: 50px;" class="table table-bordered">
            <thead>
            <tr>
                <th>SL.</th>
                <th>Term</th>
                <th>Due Amount (Tk)</th>
                <th>Cumulative Due <br> Amount (Tk)</th>
                <th>Due Date</th>
                <th>Received Amount (Tk)</th>
                <th>Pending Amount (Tk)</th>
                <th>Cumulative Pending <br> Amount (Tk)</th>

            </tr>
            </thead>
            <tbody>
            <?php
            $sl = 1;
            $cumulativeDueAmount = 0;
            $cumulativePendingAmount = 0;
while ($row = mysql_fetch_assoc($pendingResult)) {

        echo "<tr>
                <td>{$sl}</td>
                <td>{$row['InstallmentTerm']}</td>
                <td>{$row['DueAmount']}</td>
                <td>".($cumulativeDueAmount + $row['DueAmount'])."</td>
                <td>{$row['DueDate']}</td>
                <td>" . ($row['TotalReceivedAmount']  ) . "</td>
                <td>{$row['PendingAmount']}</td>
                <td>" . ($cumulativePendingAmount + $row['PendingAmount']) . "</td>
                
              </tr>";
    $sl++;
    $cumulativeDueAmount += $row['DueAmount'];
    $cumulativePendingAmount += $row['PendingAmount'];

}
            mysql_free_result($pendingResult);

            ?>
            </tbody>
        </table>

        <h4>Received Payments In <?=$fromDate?> - <?=$toDate?></h4>
        <table style=" margin-bottom: 50px; " class="table table-bordered">
            <thead>
            <tr>
                <th>SL.</th>
                <th>Term</th>
                <th>Received Amount (Tk)</th>
                <th>Adjustment (Tk)</th>
                <th>Actual Amount (Tk)</th>
                <th>Date of Collection</th>
                <th>MRR NO</th>
                <th>Mode of Payment</th>
                <th>Chq No</th>
                <th>Bank Name</th>
                <th>Remarks</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sl = 1;

            // Check if the query returns a result
            if ($receivedResult && mysqli_num_rows($receivedResult) > 0) {
                while ($row = mysqli_fetch_assoc($receivedResult)) {
                    echo "<tr style='text-align: center'>
                <td>{$sl}</td>
                <td>{$row['Term']}</td>
                <td>{$row['ReceiveAmount']}</td>
                <td>{$row['Adjustment']}</td>
                <td>{$row['ActualReceiveAmount']}</td>
                <td>{$row['DateOfCollection']}</td>
                <td>{$row['MRRNO']}</td>
                <td>{$row['ModeOfPayment']}</td>
                <td>{$row['ChequeNo']}</td>
                <td>{$row['BankName']}</td>
                <td>{$row['Remark']}</td>
              </tr>";
                    $sl++;
                }
            } else {
                echo "<tr><td colspan='11' style='text-align: center'>No Data Found</td></tr>";
            }

            mysqli_free_result($receivedResult);
            ?>
            </tbody>

        </table>


        <h4>All Received Payments</h4>
        <table style=" margin-bottom: 50px; " class="table table-bordered">
            <thead>
            <tr>
                <th>SL.</th>
                <th>Term</th>
                <th>Received Amount (Tk)</th>
                <th>Adjustment (Tk)</th>
                <th>Actual Amount (Tk)</th>
                <th>Date of Collection</th>
                <th>MRR NO</th>
                <th>Mode of Payment</th>
                <th>Chq No</th>
                <th>Bank Name</th>
                <th>Remarks</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sl = 1;

            while ($row = mysql_fetch_assoc($AllReceivedResult)) {
                echo "<tr>
                                <td>{$sl}</td>
                                <td>{$row['Term']}</td>
                                <td>{$row['ReceiveAmount']}</td>
                                <td>{$row['Adjustment']}</td>
                                <td>{$row['ActualReceiveAmount']}</td>
                                <td>{$row['DateOfCollection']}</td>
                                <td>{$row['MRRNO']}</td>
                                <td>{$row['ModeOfPayment']}</td>
                                <td>{$row['ChequeNo']}</td>
                                <td>{$row['BankName']}</td>
                                <td>{$row['Remark']}</td>
                              </tr>";
                $sl++;
            }
            mysql_free_result($receivedResult);

            ?>
            </tbody>
        </table>

        <h4>Summary</h4>
        <table style=" margin-bottom: 50px; " class="table table-bordered">
            <thead>
            <tr>
                <th>Total Receivable Amount (Tk)</th>
                <th>Total Actual Received Amount (Tk)</th>
                <th>Total Due Amount (Tk)</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <?php
                    $TotalPayAbleAmountQ = "SELECT SUM(PayAbleAmount) FROM tblschedulepayment WHERE SalesID = '$salesID'";
                    $TotalPayAbleAmount = mysql_query($TotalPayAbleAmountQ);
                    if (!$TotalPayAbleAmount) {
                        die("Query failed: " . mysql_error());
                    }
                    $TotalPayAbleAmountRow = mysql_fetch_assoc($TotalPayAbleAmount);
                    echo $TotalPayAbleAmountRow['SUM(PayAbleAmount)'];
                    ?>
                </td>
                <td>
                    <?php
                    $TotalActualReceiveAmountQ = "SELECT SUM(ActualReceiveAmount) FROM tblactualsalsepayment WHERE SalesID = '$salesID'";
                    $TotalActualReceiveAmount = mysql_query($TotalActualReceiveAmountQ);
                    if (!$TotalActualReceiveAmount) {
                        die("Query failed: " . mysql_error());
                    }
                    $TotalActualReceiveAmountRow = mysql_fetch_assoc($TotalActualReceiveAmount);
                    echo $TotalActualReceiveAmountRow['SUM(ActualReceiveAmount)'];
                    ?>
                </td>
                <td>
                    <?php
                    echo $TotalPayAbleAmountRow['SUM(PayAbleAmount)'] - $TotalActualReceiveAmountRow['SUM(ActualReceiveAmount)'];
                    ?>
                </td>

            </tr>
            </tbody>
        </table>


    </div>
    </body>
</html>

<?php
//        echo "<hr>";
//
//    }
//}
        ?>