<?php
//
///**
//
// * Created by PhpStorm.
//
// * User: Mahmud
//
// * Date: 6/20/2019
//
// * Time: 1:09 PM
//
// */
//
//
//
//$Settings = SQL_Select("Settings", "SettingsID=1", "", true);
//
//
//if ( !empty($_REQUEST["CategoryID"]) and !empty($_REQUEST["customer_id"]) and !empty($_REQUEST["SalesID"])  ){
//
////    Project Customer No date
//
//    $Getpackagename = SQL_Select("sales","SalesID={$_REQUEST["SalesID"]}","",true);
//
//    $CustomerDetails=SQL_Select("customer Where CustomerID={$_REQUEST["customer_id"]}");
//    $ProjectDetails=SQL_Select("category Where CategoryID={$_REQUEST["CategoryID"]}");
//    $ProjectWithCustomerSalesDetails=SQL_Select("sales Where ProjectID={$_REQUEST["CategoryID"]} and CustomerID={$_REQUEST["customer_id"]} and ProductName='{$Getpackagename["ProductName"]}' ");
//
//
//    //sa($_REQUEST);
//
//    if (!empty($ProjectWithCustomerSalesDetails)){
//        $ProductDetails=SQL_Select("products Where ProductsID={$ProjectWithCustomerSalesDetails[0]["ProductID"]} ");
//    }else{
//        header("location: index.php?Theme=default&Base=SalesReport&Script=Manage");
//    }
//
//
//
//    // Schedule Payment
//    $SchedulePaymentDetails=SQL_Select("schedulepayment Where SalesID={$ProjectWithCustomerSalesDetails[0]["SalesID"]} ");
//
//    // Actual Payment
//    $AllActualPaymentDetails = SQL_Select("Actualsalsepayment where SalesID={$ProjectWithCustomerSalesDetails[0]["SalesID"]} ");
//
//
//
//
//
//
//
//    $AptType="";
//
//    $AptSize="";
//
//    $Floor="";
//
//    $Price="";
//
//    $SalesDate=$ProjectWithCustomerSalesDetails[0]["SalesDate"];
//
//
//
//
//
//
//
////    Customer
//
//    foreach ($CustomerDetails as $CustomerDetail){
//        $FileNo=$CustomerDetail["CustomerID"];
//        $CustomerName=$CustomerDetail["CustomerName"];
//        $PresentAddress=$CustomerDetail["Address"];
//        $MobileNo=$CustomerDetail["Phone"];
//        $PhoneNo="";
//        $EmailAddress=$CustomerDetail["CustomerEmail"];
//    }
//
//
//
////    Project Information
//    foreach ($ProjectDetails as $ProjectDetail){
//
//        $ProjectName=$ProjectDetail["Name"];
//
//        $ProjectLocation=$ProjectDetail["Address"];
//
//        $Facing=$ProjectDetail["Facing"];
//
//        $HandOver=$ProjectDetail["HandOver"];
//
//
//    }
//
//
//
////    Product Details
//
//
//
//    foreach ( $ProductDetails as $ProductDetail ){
//
//        $ProjectLandArea=$ProductDetail["LandArea"];
//        $ProjectBuildArea=$ProductDetail["BuildArea"];
//
//
//        $ApartmentPrice=$ProductDetail["FlatPrice"];
//        //$ShareQTY=$ProductDetail["Quantity"];
//
//        $DeductionCharge=$ProductDetail["DeductionCharge"];
//
//        $TotalPrice= $ApartmentPrice- $DeductionCharge;
//
//        $CarParkingCharge=$ProductDetail["CarParkingCharge"];
//
//        $UtilityCharge=$ProductDetail["UtilityCharge"];
//
//        $TotalApartmentValue = $TotalPrice +$CarParkingCharge + $UtilityCharge;
//
//
//
//        //$AdditionalWorkCharge=$ProductDetail["AdditionalWorkCharge"];
//        $AdditionalWorkCharge=$ProjectWithCustomerSalesDetails[0]["Discount"];
//
//
//
//        $OtherCharge=$ProductDetail["OtherCharge"];  // 3 items total= Refund for additional work material supply by client
//
//
//
//        $RefundAdditionalworkCharge= $ProductDetail["RefundAdditionalWorkCharge"];
//
//
//
//        $TotalAptValuewithAdditionalCharge= ($TotalApartmentValue * $ProjectWithCustomerSalesDetails[0]["Quantity"]) - $AdditionalWorkCharge;
//
//
//
//        $AptType =$ProductDetail["FlatType"];
//
//        $AptSize =$ProductDetail["FlatSize"];
//
//        $Floor=$ProductDetail["FloorNumber"];
//
//        $Price=$ProductDetail["UnitPrice"];
//
//
//    }
//
//
//    $SheudulePaymentHtml="";
//
//
//    $totalDue=0;
//
//
//    foreach ($SchedulePaymentDetails as $SchedulePaymentDetail){
//
//
//
//        $Date=$SchedulePaymentDetail["Date"];
//
//        $Term=$SchedulePaymentDetail["Title"];
//
//        $PayAbleAmount=$SchedulePaymentDetail["PayAbleAmount"];
//
//        $totalDue +=$PayAbleAmount;
//
//        $SheudulePaymentHtml .='
//
//
//
//                <tr>
//
//                    <td class="text-left">'.HumanReadAbleDateFormat($Date).'</td>
//
//                    <td class="text-left">'.$Term.'</td>
//
//                    <td class="text-right">'.BangladeshiCurencyFormat($PayAbleAmount).'</td>
//
//
//
//                </tr>
//
//        ';
//
//
//    }
//
//
//
////    Actual Payment
//
//
//    $ActualPaymentHtml="";
//
//
//
//    $TotalReceiveAmount=0;
//
//    $TotalAdjustmentAmount=0;
//
//    $TotalActualReceiveAmount=0;
//
//    foreach ($AllActualPaymentDetails as $AllActualPaymentDetail){
//
//
//        $DateOfCollection=$AllActualPaymentDetail["DateOfCollection"];
//
//        $Term=$AllActualPaymentDetail["Term"];
//
//        $ReceiveAmount=$AllActualPaymentDetail["ReceiveAmount"];
//
//        $Adjustment=$AllActualPaymentDetail["Adjustment"];
//
//        $ActualReceiveAmount=$AllActualPaymentDetail["ActualReceiveAmount"];
//
//        $MRRNO=$AllActualPaymentDetail["MRRNO"];
//
//        $ModeOfPayment=$AllActualPaymentDetail["ModeOfPayment"];
//
//        $ChequeNo=$AllActualPaymentDetail["ChequeNo"];
//
//        $BankName=$AllActualPaymentDetail["BankName"];
//
//        $Remark=$AllActualPaymentDetail["Remark"];
//
//
//
//        $TotalReceiveAmount +=$ReceiveAmount;
//
//        $TotalAdjustmentAmount +=$Adjustment;
//
//        $TotalActualReceiveAmount +=$ActualReceiveAmount;
//
//
//
//        $ActualPaymentHtml .='
//
//
//
//                <tr>
//
//
//
//                    <td class="text-left">'.HumanReadAbleDateFormat($DateOfCollection).'</td>
//
//                    <td class="text-left">'.$Term.'</td>
//
//                    <td class="text-right">'.BangladeshiCurencyFormat($ReceiveAmount).'</td>
//
//                    <td class="text-right">'.BangladeshiCurencyFormat($Adjustment).'</td>
//
//                    <td class="text-right">'.BangladeshiCurencyFormat($ActualReceiveAmount).'</td>
//
//                    <td class="text-left">'.$MRRNO.'</td>
//
//                    <td class="text-left">'.$ModeOfPayment.'</td>
//
//                    <td class="text-left">'.$ChequeNo.'</td>
//
//                    <td class="text-left">'.$BankName.'</td>
//
//                    <td class="text-left">'.$Remark.'</td>
//
//
//                </tr>
//
//        ';
//
//
//    }
//
//
//    $TotalDueAmount= $TotalAptValuewithAdditionalCharge -$TotalActualReceiveAmount;
//
//
//}else{
//
//    header("location: index.php?Theme=default&Base=SalesReport&Script=Manage");
//
//}
//
//
//
//
//
//
//// Till Due Amount start
//
//
//$allScheduleDetails = SQL_Select("Schedulepayment where SalesID={$_REQUEST["SalesID"]} ORDER BY SchedulePaymentID ASC");
//
//$allActualPaymentDetails = SQL_Select("Actualsalsepayment where SalesID={$_REQUEST["SalesID"]} ORDER BY actualsalsepaymentID ASC");
//
//
//// $allScheduleDetails
//
//$todaysDate = date("Y-m-d");
//$todaysDateNumber=strtotime($todaysDate);
//$totalDateSchedulAmount=0;
//
//foreach ($allScheduleDetails as $allScheduleDateDetail) {
//	if (  strtotime($allScheduleDateDetail["Date"]) <= $todaysDateNumber ) {
//		$totalDateSchedulAmount += $allScheduleDateDetail["PayAbleAmount"];
//	}
//}
//
//
//foreach ($allActualPaymentDetails as $allActualPaymentDateDetail) {
//	if (  strtotime($allActualPaymentDateDetail["DateOfCollection"]) <= $todaysDateNumber ) {
//		$totalDateActualAmount += $allActualPaymentDateDetail["ActualReceiveAmount"];
//	}
//}
//
//$tillDueAmount=$TotalAptValuewithAdditionalCharge-$totalDateSchedulAmount;
//
////if ($tillDueAmount == 0) {
////	$dueText = '<h5 class="text-center text-success">Till Due Amount: '.$tillDueAmount.'</h5>';
////}else if ( $tillDueAmount > 0) {
////		$dueText = '<h5 class="text-center text-success">Till Due Amount: '.$tillDueAmount.'</h5>';
////}else{
////	$dueText = '<h2 style="color:red" class="text-center">Till Due Amount: '.$tillDueAmount.'</h5>';
////}
//// Till Due Amount End
//
//
//
//
//$MainContent .='
//
//
//<!doctype html>
//
//<html lang="en">
//
//<head>
//
//    <!-- Required meta tags -->
//
//    <meta charset="utf-8">
//
//    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
//
//
//    <!-- Bootstrap CSS -->
//
//    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
//
//          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
//
//
//
//    <title>Party Ledger</title>
//
//
//    <style>
//
//        .m-b-30 {
//
//            margin-bottom: 30px;
//
//        }
//
//
//
//        .m-t-30 {
//
//            margin-top: 30px;
//
//        }
//
//
//
//          .table-bordered th, .table-bordered td {
//
//                border: 1px solid rgba(0,0,0,.3) !important;
//
//          }
//
//
//
//          .company-name{
//
//            border-bottom: 1px solid rgba(0,0,0,.3);
//
//          }
//
//
//    </style>
//
//</head>
//
//<body>
//
//
//
//<div style="width: 95%; margin: auto">
//
//    <p style="font-size: 16px">Printing Date & Time: '.date('F j-y, h:i:sa').'</p>
//
//</div>
//
//<div style="width: 95%; margin: auto">
//
//
//
//    <div style="padding: 10px 0px;" class="company-name row">
//
//        <div class="col-md-2 text-center">
//
//            <img height="70px" src="./upload/' . $Settings["logo"] . '" alt="">
//
//        </div>
//
//        <div class="col-md-9 text-center">
//
//            <h3 style="font-weight: bold">'.$Settings["CompanyName"].'</h3>
//
//            <p style="font-size: 18px;">'.$Settings["Address"].'</p>
//
//        </div>
//
//    </div>
//
//
//    <div class="projectName text-center m-b-30 m-t-30">
//
//        <h4 style="font-weight: bold">Party Ledger</h4>
//
//    </div>
//
//
//    <div class="row">
//
//        <div style="font-size:14px" class="col-md-6">
//
//            <table class="table table-bordered table-hover table-fixed table-sm">
//
//                <thead>
//
//                <tr>
//
//                    <th colspan="2" scope="col" class="text-center"><h6 style="font-weight: bold;">Customer
//
//                            Information</h6></th>
//
//                </tr>
//
//                <tr style="text-align: center">
//
//                    <td>Description</td>
//
//                    <td>Description</td>
//
//
//                </tr>
//
//
//                </thead>
//
//
//                <tbody>
//
//
//                <tr>
//
//                    <td class="text-left">Customer ID</td>
//
//                    <td class="text-left">'.str_pad($FileNo, "4", "0", STR_PAD_LEFT).'</td>
//
//
//
//                </tr>
//
//                <tr>
//
//                    <td class="text-left">Customer Name</td>
//
//                    <td class="text-left">'.$CustomerName.'</td>
//
//
//                </tr>
//
//                <tr>
//
//                    <td class="text-left">Contract Address</td>
//
//                    <td class="text-left">'.$PresentAddress.'</td>
//
//
//                </tr>
//
//                <tr>
//
//                    <td class="text-left">Mobile No</td>
//
//                    <td class="text-left">'.$MobileNo.'</td>
//
//
//                </tr>
//
//                <tr>
//
//                    <td class="text-left">Phone No</td>
//
//                    <td class="text-left">'.$PhoneNo.'</td>
//
//                </tr>
//
//                <tr>
//
//                    <td class="text-left">Email Address</td>
//
//                    <td class="text-left">'.$EmailAddress.'</td>
//
//
//                </tr>
//
//
//
//                <tr>
//
//                    <td style="height: 35px" colspan="2"></td>
//
//
//
//                </tr>
//
//
//
//                </tbody>
//
//
//
//            </table>
//
//
//
//
//
//            <table class="table table-bordered table-hover table-fixed table-sm">
//
//
//
//                <thead>
//
//                <tr>
//
//                    <th colspan="2" scope="col" class="text-center"><h6 style="font-weight: bold;">Project
//
//                            Information</h6></th>
//
//                </tr>
//
//                <tr style="text-align: center">
//
//                    <td>Description</td>
//
//                    <td>Description</td>
//
//
//
//                </tr>
//
//
//
//                </thead>
//
//
//
//                <tbody>
//
//
//
//                <tr>
//
//                    <td class="text-left">Project Name</td>
//
//                    <td class="text-left">'.$ProjectName.'</td>
//
//
//
//                </tr>
//
//                <tr>
//
//                    <td class="text-left">Project Location</td>
//
//                    <td class="text-left">'.$ProjectLocation.'</td>
//
//
//
//                </tr>
//
//
//
//                <tr>
//
//                    <td class="text-left">Package Type</td>
//
//                    <td class="text-left">'.$AptType.'</td>
//
//
//
//                </tr>
//
//                <tr>
//
//                    <td class="text-left">Land Area</td>
//
//                    <td class="text-left">'.$ProjectLandArea.'</td>
//
//
//
//                </tr>
//
//                <tr>
//
//                    <td class="text-left">Build Area</td>
//
//                    <td class="text-left">'.$ProjectBuildArea.'</td>
//
//
//
//                </tr>
//
//                <tr>
//
//                    <td style="height: 35px" colspan="2"></td>
//
//
//
//                </tr>
//
//
//
//                </tbody>
//
//
//
//            </table>
//
//
//
//
//
//        </div>
//
//        <div style="font-size:14px" class="col-md-6">
//
//
//
//            <table class="table table-bordered table-hover table-fixed table-sm">
//
//                <thead>
//
//                <tr>
//
//                    <th colspan="2" scope="col" class="text-center"><h6 style="font-weight: bold;">Share Value
//
//                            Summery</h6></th>
//
//                </tr>
//
//                <tr>
//
//                    <td class="text-center">Description</td>
//
//                    <td class="text-center">Amount tk</td>
//
//
//
//                </tr>
//
//
//
//                </thead>
//
//
//
//                <tbody>
//
//
//
//                <tr>
//
//                    <td class="text-left">Price</td>
//
//                    <td class="text-right">'.BangladeshiCurencyFormat($ApartmentPrice).'</td>
//
//
//
//                </tr>
//
//
//
//                <tr>
//
//                    <td class="text-left">Quantity</td>
//
//                    <td class="text-right">'.$ProjectWithCustomerSalesDetails[0]["Quantity"].'</td>
//
//
//
//                </tr>
//
//
//
//
//                <tr style="font-weight: bold">
//
//                    <td class="text-left">Total Value</td>
//
//                    <td class="text-right">'.BangladeshiCurencyFormat($TotalApartmentValue * $ProjectWithCustomerSalesDetails[0]["Quantity"]).'</td>
//
//
//
//                </tr>
//
//
//
//                <tr>
//
//                    <td class="text-left">Discount</td>
//
//                    <td class="text-right">(-) '.BangladeshiCurencyFormat($AdditionalWorkCharge).'</td>
//
//
//
//                </tr>
//
//
//
//
//
//                <tr style="font-weight: bold">
//
//                    <td class="text-left">Grand Total</td>
//
//                    <td class="text-right">'.BangladeshiCurencyFormat($TotalAptValuewithAdditionalCharge).'</td>
//
//
//
//                </tr>
//
//
//
//
//
//                <tr>
//
//                    <td style="height: 35px" colspan="2"></td>
//
//
//
//                </tr>
//
//
//
//                </tbody>
//
//            </table>
//
//
//<table class="table table-bordered table-hover table-fixed table-sm">
//
//                <thead>
//
//                <tr>
//
//                    <th colspan="2" scope="col" class="text-center"><h6 style="font-weight: bold;">Project Information</h6></th>
//
//                </tr>
//
//                <tr>
//
//                    <td class="text-center">Description</td>
//
//                    <td class="text-center">Description</td>
//
//
//
//                </tr>
//
//
//
//                </thead>
//
//
//
//                <tbody>
//
//
//
//                <tr>
//
//                    <td class="text-left">Price</td>
//
//                    <td class="text-left">'.$Price.'</td>
//
//
//
//                </tr>
//
//                <tr>
//
//                    <td class="text-left">Sales Date</td>
//
//                    <td class="text-left">'.HumanReadAbleDateFormat($SalesDate).'</td>
//
//
//
//                </tr>
//
//
//
//                <tr>
//
//                    <td class="text-left">Hadnover Date</td>
//
//                    <td class="text-left">'.HumanReadAbleDateFormat($HandOver).'</td>
//
//
//
//                </tr>
//
//                <tr>
//
//                    <td style="height: 35px" colspan="2"></td>
//
//                </tr>
//
//                </tbody>
//
//            </table>
//
//        </div>
//
//    </div>
//
//    <div class="row">
//
//        <div class="col-12">
//
//            <table class="table table-bordered table-hover table-fixed table-sm">
//
//                <thead>
//
//                <tr>
//
//                    <th scope="col" class="text-center"><h6 style="font-weight: bold;">Payment History</h6></th>
//
//                </tr>
//
//                </thead>
//
//                </tbody>
//            </table>
//
//        </div>
//
//        <div style="font-size: 14px" class="col-4">
//
//            <table class="table table-bordered table-hover table-fixed table-sm">
//
//                <thead>
//
//                <tr>
//
//                    <th colspan="3" scope="col" class="text-center"><h6 style="font-weight: bold;">Schedule Payment</h6></th>
//
//                </tr>
//
//                <tr>
//
//                    <td class="text-center">Date</td>
//
//                    <td class="text-center">Term</td>
//
//                    <td class="text-center">Payable amount</td>
//
//
//                </tr>
//
//                </thead>
//
//                <tbody>
//
//                '.$SheudulePaymentHtml.'
//
//                <tr style="font-weight: bold">
//
//                    <td colspan="2" class="text-right">Total</td>
//
//                    <td class="text-right">'.BangladeshiCurencyFormat($totalDue).'</td>
//
//                </tr>
//
//
//                <tr>
//
//                    <td style="height: 35px" colspan="3"></td>
//
//                </tr>
//
//                </tbody>
//
//            </table>
//
//        </div>
//
//        <div style="font-size: 14px" class="col-8">
//
//            <table class="table table-bordered table-hover table-fixed table-sm">
//
//                <thead>
//
//                <tr>
//
//                    <th colspan="10" scope="col" class="text-center"><h6 style="font-weight: bold;">Actual Payment
//
//                            History</h6></th>
//
//                </tr>
//
//                <tr>
//
//                    <td class="text-center">Date Of Collection</td>
//
//                    <td class="text-center">Term</td>
//
//                    <td class="text-center">Receive Amount(tk)</td>
//
//                    <td class="text-center">Adjustment (tk)</td>
//
//                    <td class="text-center">Actual Amount (tk)</td>
//
//                    <td class="text-center">MRR No</td>
//
//                    <td class="text-center">Mode of Payment</td>
//
//                    <td class="text-center">Cheque No</td>
//
//                    <td class="text-center">Bank Name</td>
//
//                    <td class="text-center">Remarks</td>
//
//
//
//                </tr>
//
//
//
//                </thead>
//
//
//
//                    <tbody>
//
//
//
//                    '.$ActualPaymentHtml.'
//
//
//
//                    <tr style="font-weight: bold">
//
//
//
//                        <td colspan="2" class="text-right">Total</td>
//
//
//
//                        <td class="text-right">'.BangladeshiCurencyFormat($TotalReceiveAmount).'</td>
//
//                        <td class="text-right">'.BangladeshiCurencyFormat($TotalAdjustmentAmount).'</td>
//
//                        <td class="text-right">'.BangladeshiCurencyFormat($TotalActualReceiveAmount).'</td>
//
//
//
//                        <td colspan="5" class="text-center"></td>
//
//
//
//                    </tr>
//
//
//
//                    <tr style="font-size: 25px;font-weight: bold">
//
//
//
//                        <td colspan="5" class="text-right">Total Received Amount : '.BangladeshiCurencyFormat($TotalReceiveAmount).'</td>
//
//                        <td colspan="5" class="text-right">Total Due : '.BangladeshiCurencyFormat($TotalDueAmount).'</td>
//
//
//
//                    </tr>
//                    <tr style="font-size: 25px;font-weight: bold">
//
//
//
//                        <td colspan="5" class="text-right"></td>
//
//                        <td colspan="5" class="text-right">'.$dueText.'</td>
//
//
//
//                    </tr>
//
//
//
//                </tbody>
//
//            </table>
//
//        </div>
//
//
//
//    </div>
//
//
//
//</div>
//
//
//
//
//
//<!-- Optional JavaScript -->
//
//<!-- jQuery first, then Popper.js, then Bootstrap JS -->
//
//<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
//
//        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
//
//        crossorigin="anonymous"></script>
//
//<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
//
//        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
//
//        crossorigin="anonymous"></script>
//
//<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
//
//        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
//
//        crossorigin="anonymous"></script>
//
//</body>
//
//</html>';
//




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

//$_REQUEST["CategoryID"] = 116;
//$_REQUEST["customer_id"] = 1124;
$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

if (!empty($_REQUEST["CategoryID"]) and !empty($_REQUEST["customer_id"])) {
    $CustomerDetails = SQL_Select("customer Where CustomerID={$_REQUEST["customer_id"]}");
    $ProjectDetails = SQL_Select("category", "CategoryID={$_REQUEST['CategoryID']}");
    $saleIds = SQL_Select("sales", "CustomerID={$_REQUEST['customer_id']} AND ProjectID={$_REQUEST['CategoryID']}");

    $salesData = [];
    foreach ($saleIds as $sale) {
        $saleDetails = SQL_Select("sales", "SalesID={$sale['SalesID']}", "", true);
        $productDetails = SQL_Select("products", "ProductsID={$saleDetails['ProductID']}", "",  true);
        $schedulePayments = SQL_Select("schedulepayment", "SalesID={$sale['SalesID']} ORDER BY `Date` Asc");
//        echo "<pre>";
//        print_r($schedulePayments);
//        echo "</pre>";
        $actualPayments = SQL_Select("Actualsalsepayment", "SalesID={$sale['SalesID']} ORDER BY `DateOfCollection` Asc");

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
            font-size: 14px;
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
                <div class="card-header" style="
    background: #2e2822;
">
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
                <div class="card-header" style="
    background: #1b5fa2;
">
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
            <div style="
    background: #4CAF50;
" class="card-header">
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
                        <table style="text-align: center" class="table table-sm table-bordered table-hover">
                            <thead>
                            <tr style="text-align: center">
                                <th>Date</th>
                                <th>Term</th>
                                <th class="text-end">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($sale['schedulePayments'] as $payment): ?>
                                <tr style="text-align: center">
                                    <td><?php echo HumanReadAbleDateFormat($payment['Date']); ?></td>
                                    <td><?php echo $payment['Title']; ?></td>
                                    <td class=""><?php echo BangladeshiCurencyFormat($payment['PayAbleAmount']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mt-2" style="text-align: center">Actual Payments</h6>
                        <table class="table table-sm table-bordered table-hover">
                            <thead>
                            <tr style="text-align: center">
                                <th>Date of Collection</th>
                                <th>Term</th>
                                <th class="">Received Amount</th>
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
                                    <td class=""><?php echo BangladeshiCurencyFormat($payment['ActualReceiveAmount']); ?></td>
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
                <h6 style="text-align: center" class="mt-4 mb-3">Payment Summary</h6>
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
