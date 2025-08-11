
<?php
//$salesID = '205,20'; // SalesID values as a string
//$tblsales = SQL_Select("sales WHERE SalesID IN ({$salesID})");
//
//echo "<pre>";
//print_r($tblsales);
//echo "</pre>";

?>



<?php
$fromDate = $_REQUEST["FromDate"];
$toDate = $_REQUEST["ToDate"];
$Division = $_REQUEST['Division'];
//$Division = 'SED';

//$fromDate = "2024-01-01";
//$toDate = "2029-07-01";
$GetScheduleData =  SQL_Select("SchedulePayment","Date BETWEEN '{$fromDate}' and '{$toDate}' ");
//$salesIDs = "201,209"; // The list of SalesIDs as a string
//$GetScheduleData = SQL_Select("SchedulePayment", "SalesID IN ({$salesIDs}) AND Date BETWEEN '{$fromDate}' AND '{$toDate}'");

$uniqueSalesIDs = [];


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
<div style="margin-left: 20px;margin-right: 20px" class=" mt-3">
    <div class="" style="float: left">
        <p>Date Of Printing : <?= date('F j, Y, h:i:sa') ?></p>
    </div>
    <div class="" style="float: right">
        <p>From <?= date('F j, Y', strtotime($fromDate)) ?> - To <?= date('F j, Y', strtotime($toDate)) ?></p>
    </div>
</div>

<body>
<div style="margin-left: 20px;margin-right: 20px;" class=" mt-5">

    <h2 class="text-center">EMI Pending Payment's of <?=($Division == null) ? "All Division" : $_REQUEST['Division'];?>
        <br>
        <hr>

    </h2>



    <h4>Pending Payments - <?=($Division == null) ? "All Division" : $_REQUEST['Division'];?></h4>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>SL.</th>
            <th>Sale ID.</th>
            <th>Customer Name</th>
            <th>Saller Name</th>
            <th>Term</th>
            <th>Due Amount (Tk)</th>
            <!--            <th>Cumulative Due <br> Amount (Tk)</th>-->
            <th>Due Date</th>
            <!--            <th>Received Amount (Tk)</th>-->
            <!--            <th>Pending Amount (Tk)</th>-->
            <!--            <th>Cumulative Pending <br> Amount (Tk)</th>-->

        </tr>
        </thead>
        <tbody>
        <?php
        $sl = 1;
        $cumulativeAllPendingAmount = 0;
        foreach ($GetScheduleData as $GetScheduleDataRow) {
            $salesID = $GetScheduleDataRow['SalesID'];
            if (!in_array($salesID, $uniqueSalesIDs)) {
                $uniqueSalesIDs[] = $salesID;


                //$salesID = 127;           // SalesID
                //        $salesID=[205,20];
                $tblsales = SQL_Select("sales WHERE SalesID IN ({$salesID})");


                //        echo "<pre>";
                //        print_r($tblsales);
                //        echo "</pre>";


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

                ?>


                <?php

                $cumulativeDueAmount = 0;
                $cumulativePendingAmount = 0;
                while ($row = mysql_fetch_assoc($pendingResult)) {
// Some Time Table Sale's id null but tbl tblschedulepayment sale's id avalable

                    if ($Division==null && $tblsales[0]['SalesID']==$row['SalesID']){
                                    echo "<tr>
                            <td>{$sl}</td>
                            <td>{$tblsales[0]['SalesID']}</td>
                            <th style='font-weight: normal;'>{$tblsales[0]['CustomerID']} - {$tblsales[0]['CustomerName']}</th>
                            <th style='font-weight: normal;'>{$tblsales[0]['SellerID']} - {$tblsales[0]['SellerName']}</th>
                            <td>{$row['InstallmentTerm']}</td>
                            <td>".BangladeshiCurencyFormat($row['DueAmount'])."</td>
            
                            <td>{$row['DueDate']}</td>
            
                            
                          </tr>";
                                    $sl++;
                                    $cumulativeDueAmount += $row['DueAmount'];
                                    $cumulativePendingAmount += $row['PendingAmount'];
                                    $cumulativeAllPendingAmount+=$cumulativeDueAmount;
                    }else{
                        if($tblsales[0]['SalesID']==$row['SalesID']&& $tblsales[0]['Division']==$Division){
                                    echo "<tr>
                                        <td>{$sl}</td>
                                        <td>{$tblsales[0]['SalesID']}</td>
                                        <th style='font-weight: normal;'>{$tblsales[0]['CustomerID']} - {$tblsales[0]['CustomerName']}</th>
                                        <th style='font-weight: normal;'>{$tblsales[0]['SellerID']} - {$tblsales[0]['SellerName']}</th>
                                        <td>{$row['InstallmentTerm']}</td>
                                        <td>".BangladeshiCurencyFormat($row['DueAmount'])."</td>
                        
                                        <td>{$row['DueDate']}</td>
                        
                                        
                                      </tr>";
                                    $sl++;
                                    $cumulativeDueAmount += $row['DueAmount'];
                                    $cumulativePendingAmount += $row['PendingAmount'];
                                    $cumulativeAllPendingAmount+=$cumulativeDueAmount;
                        }
                    }
                    mysql_free_result($pendingResult);
                    //end $pendingResult
                }
                ?>

                <?php
//end $GetScheduleData
            }
        }

        ?>
        <tr>
            <td style="text-align: right; font-weight: bold" colspan="5">Total Due Amount</td>
            <td style="font-weight: bold" colspan="2"><?=BangladeshiCurencyFormat($cumulativeAllPendingAmount)?>/-</td>

        </tr>
        </tbody>
    </table>

    <!--            <h4>Received Payments</h4>-->
    <!--            <table class="table table-bordered">-->
    <!--                <thead>-->
    <!--                <tr>-->
    <!--                    <th>SL.</th>-->
    <!--                    <th>Term</th>-->
    <!--                    <th>Received Amount (Tk)</th>-->
    <!--                    <th>Adjustment (Tk)</th>-->
    <!--                    <th>Actual Amount (Tk)</th>-->
    <!--                    <th>Date of Collection</th>-->
    <!--                    <th>MRR NO</th>-->
    <!--                    <th>Mode of Payment</th>-->
    <!--                    <th>Chq No</th>-->
    <!--                    <th>Bank Name</th>-->
    <!--                    <th>Remarks</th>-->
    <!--                </tr>-->
    <!--                </thead>-->
    <!--                <tbody>-->
    <!--                --><?php
    //                $sl = 1;
    //
    //                while ($row = mysql_fetch_assoc($receivedResult)) {
    //                    echo "<tr>
    //                                <td>{$sl}</td>
    //                                <td>{$row['Term']}</td>
    //                                <td>{$row['ReceiveAmount']}</td>
    //                                <td>{$row['Adjustment']}</td>
    //                                <td>{$row['ActualReceiveAmount']}</td>
    //                                <td>{$row['DateOfCollection']}</td>
    //                                <td>{$row['MRRNO']}</td>
    //                                <td>{$row['ModeOfPayment']}</td>
    //                                <td>{$row['ChequeNo']}</td>
    //                                <td>{$row['BankName']}</td>
    //                                <td>{$row['Remark']}</td>
    //                              </tr>";
    //                    $sl++;
    //                }
    //                mysql_free_result($receivedResult);
    //
    //                ?>
    <!--                </tbody>-->
    <!--            </table>-->

    <!--            <h4>Summary</h4>-->
    <!--            <table class="table table-bordered">-->
    <!--                <thead>-->
    <!--                <tr>-->
    <!--                    <th>Total Receivable Amount (Tk)</th>-->
    <!--                    <th>Total Actual Received Amount (Tk)</th>-->
    <!--                    <th>Total Due Amount (Tk)</th>-->
    <!--                </tr>-->
    <!--                </thead>-->
    <!--                <tbody>-->
    <!--                <tr>-->
    <!--                    <td>-->
    <!--                        --><?php
    //                        $TotalPayAbleAmountQ = "SELECT SUM(PayAbleAmount) FROM tblschedulepayment WHERE SalesID = '$salesID'";
    //                        $TotalPayAbleAmount = mysql_query($TotalPayAbleAmountQ);
    //                        if (!$TotalPayAbleAmount) {
    //                            die("Query failed: " . mysql_error());
    //                        }
    //                        $TotalPayAbleAmountRow = mysql_fetch_assoc($TotalPayAbleAmount);
    //                        echo $TotalPayAbleAmountRow['SUM(PayAbleAmount)'];
    //                        ?>
    <!--                    </td>-->
    <!--                    <td>-->
    <!--                        --><?php
    //                        $TotalActualReceiveAmountQ = "SELECT SUM(ActualReceiveAmount) FROM tblactualsalsepayment WHERE SalesID = '$salesID'";
    //                        $TotalActualReceiveAmount = mysql_query($TotalActualReceiveAmountQ);
    //                        if (!$TotalActualReceiveAmount) {
    //                            die("Query failed: " . mysql_error());
    //                        }
    //                        $TotalActualReceiveAmountRow = mysql_fetch_assoc($TotalActualReceiveAmount);
    //                        echo $TotalActualReceiveAmountRow['SUM(ActualReceiveAmount)'];
    //                        ?>
    <!--                    </td>-->
    <!--                    <td>-->
    <!--                        --><?php
    //                        echo $TotalPayAbleAmountRow['SUM(PayAbleAmount)'] - $TotalActualReceiveAmountRow['SUM(ActualReceiveAmount)'];
    //                        ?>
    <!--                    </td>-->
    <!---->
    <!--                </tr>-->
    <!--                </tbody>-->
    <!--            </table>-->


</div>
</body>
</html>















<?php
// ডেটাবেস কানেকশন
//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "sunx";
//
//$conn = new mysqli($servername, $username, $password, $dbname);

//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}

// প্যারামিটার সেট করুন
//$fromDate = '2024-05-06'; // ফ্রম ডেট
//$toDate = '2024-09-28';   // টু ডেট
//$salesID = 127;           // SalesID
//// বাকি পেমেন্টের ডেটা
//
//
//$GetScheduleData =  SQL_Select("SchedulePayment","SalesID=127 and Date BETWEEN '{$fromDate}' and '{$toDate}'");
//
//foreach($GetScheduleData as $ThisGetScheduleData){
//
//    // $Ac = mysql_query("select SUM(CostPerProduct*Qty) as Total from tblpurchasedproducts where TempNumber='{$MyTempNumber}'");
//    // $row = @mysql_fetch_array($result, MYSQL_ASSOC);
//
//    $GetActualPaymentData =  SQL_Select("actualsalsepayment","SalesID=127 and DateOfCollection BETWEEN '{$fromDate}' and '{$toDate}'");
//    $HTMLActualPayment="";
//    foreach ($GetActualPaymentData as $ThisGetActualPaymentData){
//
//        if($ThisGetActualPaymentData["Term"]== $ThisGetScheduleData["Title"]){
//            if ($ThisGetActualPaymentData)
//            $ShowIntheReport ="NO";
//
//        }else{
//
//            $ShowIntheReport ="Yes";
//            $PendingAmount = $ThisGetScheduleData["PayAbleAmount"] - $ThisGetActualPaymentData["ReceiveAmount"];
//        }
//
//
//        if($ShowIntheReport=='Yes')
//            $HTMLActualPayment.='
//                scp
//                '.$ThisGetActualPaymentData["SalesID"].'<br>
//                '.$ThisGetActualPaymentData["Term"].'<br>
//                '.$ThisGetActualPaymentData["ReceiveAmount"].'<br>
//                '.$ThisGetActualPaymentData["DateOfCollection"].'<br>
//                <hr>
//
//            ';
//
//    }
//
//    $HTML.='
//        acp
//        '.$ThisGetScheduleData["SalesID"].'<br>
//        '.$ThisGetScheduleData["Title"].'<br>
//        '.$ThisGetScheduleData["PayAbleAmount"].'<br>
//        '.$ThisGetScheduleData["Date"].'<br>
//        <hr>
//        '.$HTMLActualPayment.'
//        <hr><hr>
//
//    ';
//
//
//
//}
//
//
//echo '
//
//    '.$HTML.'
//
//';
//
//
//
//?>
<!---->
<!---->
<!---->
<!--</body>-->
<!--</html>-->