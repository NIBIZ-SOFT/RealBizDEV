<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 5/2/2019
 * Time: 3:09 PM
 */

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

if (empty($_REQUEST["CategoryID"]) and empty($_REQUEST["FromDate"]) and empty($_REQUEST["ToDate"])) {


//    all Project

    $categories = SQL_Select("category");

    $sl = 1;
    $trHtml = "";

    $TotalFlatAmount = 0;
    $TotalCarParkingCharge = 0;
    $TotalUtilityCharge = 0;
    $TotalAdditionalWorkCharge = 0;
    $TotalOtherCharge = 0;

    $TotalDeductionCharge = 0;

    $TotalNetSalesPriceAmount = 0;

    $GrandTotalActualReceiveAmount = 0;
    $GrandTotalDueAmount = 0;

    $grandActualDue = 0;

    foreach ($categories as $category) {


        $salesProjctDetails = SQL_Select("sales where ProjectID={$category["CategoryID"]}");

        foreach ($salesProjctDetails as $salesProjctDetail) {


            $SalesID = $salesProjctDetail["SalesID"];

            $customerName = $salesProjctDetail["CustomerName"];
            $SellerName = $salesProjctDetail["SellerName"];
            $SalesDate = $salesProjctDetail["SalesDate"];
            $ProjectName = $salesProjctDetail["ProjectName"];

            $ProductName = $salesProjctDetail["ProductName"];

            $ProductDetailsArray = explode("-", $ProductName);

            $floor = $ProductDetailsArray[0];
            $type = $ProductDetailsArray[1];


            $ProductDetails = SQL_Select("products where CategoryID={$category["CategoryID"]} and FlatType='{$type}' and FloorNumber='{$floor}' ");


            $FlatPrice = $ProductDetails[0]["FlatPrice"];

            $TotalFlatAmount += $FlatPrice;

            $CarParkingCharge = $ProductDetails[0]["CarParkingCharge"];

            $TotalCarParkingCharge += $CarParkingCharge;

            $UtilityCharge = $ProductDetails[0]["UtilityCharge"];

            $TotalUtilityCharge += $UtilityCharge;

            $AdditionalWorkCharge = $ProductDetails[0]["AdditionalWorkCharge"];

            $TotalAdditionalWorkCharge += $AdditionalWorkCharge;

            $OtherCharge = $ProductDetails[0]["OtherCharge"];
            $TotalOtherCharge += $OtherCharge;

            $DeductionCharge = $ProductDetails[0]["DeductionCharge"];
            $TotalDeductionCharge += $DeductionCharge;

            $TotalNetSalesPrice = $ProductDetails[0]["NetSalesPrice"];
            $TotalNetSalesPriceAmount += $TotalNetSalesPrice;


//        Actual payment
            $ActualPaymentDetails = SQL_Select("actualsalsepayment where SalesID={$SalesID}");


            $TotalActualReceiveAmount = 0;
            foreach ($ActualPaymentDetails as $ActualPaymentDetail) {
                $TotalActualReceiveAmount += $ActualPaymentDetail["ActualReceiveAmount"];
            }
            $GrandTotalActualReceiveAmount += $TotalActualReceiveAmount;


//        Due payment

            $DuePaymentDetails = SQL_Select("schedulepayment where SalesID={$SalesID}");


            $TotalDueAmount = 0;
            foreach ($DuePaymentDetails as $DuePaymentDetail) {
                $TotalDueAmount += $DuePaymentDetail["PayAbleAmount"];
            }
            $GrandTotalDueAmount += $TotalDueAmount;


            $ActualDue = $TotalDueAmount - $TotalActualReceiveAmount;

            $grandActualDue += $ActualDue;

            $percentOfcollection = ($TotalActualReceiveAmount / $TotalNetSalesPrice) * 100;


            $trHtml .= '
        
        <tr>
            <td class="text-center">' . $sl . '</td>
            <td class="text-left">' . $customerName . '</td>
            <td class="text-left">' . $SellerName . '</td>
            <td class="text-left">' . $SalesDate . '</td>
            <td class="text-left">' . $ProjectName . '</td>
            <td class="text-left">' . $ProductName . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($FlatPrice) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($CarParkingCharge) . '</td>
            
            <td class="text-right">' . BangladeshiCurencyFormat($UtilityCharge) . '</td>
            
            <td class="text-right">' . BangladeshiCurencyFormat($AdditionalWorkCharge) . '</td>
            
            <td class="text-right">' . BangladeshiCurencyFormat($OtherCharge) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($DeductionCharge) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($TotalNetSalesPrice) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($TotalActualReceiveAmount) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($ActualDue) . '</td>
            <td class="text-right">' . round($percentOfcollection, 2) . ' %</td>
            
        </tr>
        
        
        ';

            $sl++;


        }


    }


} elseif (!empty($_REQUEST["CategoryID"]) and empty($_REQUEST["FromDate"]) and empty($_REQUEST["ToDate"]) ) {

    // One Project


    $categories = SQL_Select("category where CategoryID={$_REQUEST["CategoryID"]}");


    $sl = 1;
    $trHtml = "";

    $TotalFlatAmount = 0;
    $TotalCarParkingCharge = 0;
    $TotalUtilityCharge = 0;
    $TotalAdditionalWorkCharge = 0;
    $TotalOtherCharge = 0;

    $TotalDeductionCharge = 0;

    $TotalNetSalesPriceAmount = 0;

    $GrandTotalActualReceiveAmount = 0;
    $GrandTotalDueAmount = 0;

    $grandActualDue = 0;

    foreach ($categories as $category) {
        $salesProjctDetails = SQL_Select("sales where ProjectID={$category["CategoryID"]}");


        foreach ($salesProjctDetails as $salesProjctDetail) {


            $SalesID = $salesProjctDetail["SalesID"];

            $customerName = $salesProjctDetail["CustomerName"];
            $SellerName = $salesProjctDetail["SellerName"];
            $SalesDate = $salesProjctDetail["SalesDate"];
            $ProjectName = $salesProjctDetail["ProjectName"];

            $ProductName = $salesProjctDetail["ProductName"];

            $ProductDetailsArray = explode("-", $ProductName);

            $floor = $ProductDetailsArray[0];
            $type = $ProductDetailsArray[1];


            $ProductDetails = SQL_Select("products where CategoryID={$category["CategoryID"]} and FlatType='{$type}' and FloorNumber='{$floor}' ");


            $FlatPrice = $ProductDetails[0]["FlatPrice"];

            $TotalFlatAmount += $FlatPrice;

            $CarParkingCharge = $ProductDetails[0]["CarParkingCharge"];

            $TotalCarParkingCharge += $CarParkingCharge;

            $UtilityCharge = $ProductDetails[0]["UtilityCharge"];

            $TotalUtilityCharge += $UtilityCharge;

            $AdditionalWorkCharge = $ProductDetails[0]["AdditionalWorkCharge"];

            $TotalAdditionalWorkCharge += $AdditionalWorkCharge;

            $OtherCharge = $ProductDetails[0]["OtherCharge"];
            $TotalOtherCharge += $OtherCharge;

            $DeductionCharge = $ProductDetails[0]["DeductionCharge"];
            $TotalDeductionCharge += $DeductionCharge;

            $TotalNetSalesPrice = $ProductDetails[0]["NetSalesPrice"];
            $TotalNetSalesPriceAmount += $TotalNetSalesPrice;


//        Actual payment
            $ActualPaymentDetails = SQL_Select("actualsalsepayment where SalesID={$SalesID}");
            $TotalActualReceiveAmount = 0;
            foreach ($ActualPaymentDetails as $ActualPaymentDetail) {
                $TotalActualReceiveAmount += $ActualPaymentDetail["ActualReceiveAmount"];
            }
            $GrandTotalActualReceiveAmount += $TotalActualReceiveAmount;

//        Due payment

            $DuePaymentDetails = SQL_Select("schedulepayment where SalesID={$SalesID}");

            $TotalDueAmount = 0;
            foreach ($DuePaymentDetails as $DuePaymentDetail) {
                $TotalDueAmount += $DuePaymentDetail["PayAbleAmount"];
            }
            $GrandTotalDueAmount += $TotalDueAmount;


            $ActualDue = $TotalDueAmount - $TotalActualReceiveAmount;

            $grandActualDue += $ActualDue;

            $percentOfcollection = ($TotalActualReceiveAmount / $TotalNetSalesPrice) * 100;


            $trHtml .= '
        
        <tr>
            <td class="text-center">' . $sl . '</td>
            <td class="text-left">' . $customerName . '</td>
            <td class="text-left">' . $SellerName . '</td>
            <td class="text-left">' . $SalesDate . '</td>
            <td class="text-left">' . $ProjectName . '</td>
            <td class="text-left">' . $ProductName . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($FlatPrice) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($CarParkingCharge) . '</td>
            
            <td class="text-right">' . BangladeshiCurencyFormat($UtilityCharge) . '</td>
            
            <td class="text-right">' . BangladeshiCurencyFormat($AdditionalWorkCharge) . '</td>
            
            <td class="text-right">' . BangladeshiCurencyFormat($OtherCharge) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($DeductionCharge) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($TotalNetSalesPrice) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($TotalActualReceiveAmount) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($ActualDue) . '</td>
            <td class="text-right">' . round($percentOfcollection, 2) . ' %</td>
            
        </tr>
        
        
        ';

            $sl++;


        }

    }




}elseif (empty($_REQUEST["CategoryID"]) and !empty($_REQUEST["FromDate"]) and !empty($_REQUEST["ToDate"])){


//    all Project Date ways

    $categories = SQL_Select("category");

    $sl = 1;
    $trHtml = "";

    $TotalFlatAmount = 0;
    $TotalCarParkingCharge = 0;
    $TotalUtilityCharge = 0;
    $TotalAdditionalWorkCharge = 0;
    $TotalOtherCharge = 0;

    $TotalDeductionCharge = 0;

    $TotalNetSalesPriceAmount = 0;

    $GrandTotalActualReceiveAmount = 0;
    $GrandTotalDueAmount = 0;

    $grandActualDue = 0;

    foreach ($categories as $category) {


        $salesProjctDetails = SQL_Select("sales where ProjectID={$category["CategoryID"]}");

        foreach ($salesProjctDetails as $salesProjctDetail) {


            $SalesID = $salesProjctDetail["SalesID"];

            $customerName = $salesProjctDetail["CustomerName"];
            $SellerName = $salesProjctDetail["SellerName"];
            $SalesDate = $salesProjctDetail["SalesDate"];
            $ProjectName = $salesProjctDetail["ProjectName"];

            $ProductName = $salesProjctDetail["ProductName"];

            $ProductDetailsArray = explode("-", $ProductName);

            $floor = $ProductDetailsArray[0];
            $type = $ProductDetailsArray[1];


            $ProductDetails = SQL_Select("products where CategoryID={$category["CategoryID"]} and FlatType='{$type}' and FloorNumber='{$floor}' ");


            $FlatPrice = $ProductDetails[0]["FlatPrice"];

            $TotalFlatAmount += $FlatPrice;

            $CarParkingCharge = $ProductDetails[0]["CarParkingCharge"];

            $TotalCarParkingCharge += $CarParkingCharge;

            $UtilityCharge = $ProductDetails[0]["UtilityCharge"];

            $TotalUtilityCharge += $UtilityCharge;

            $AdditionalWorkCharge = $ProductDetails[0]["AdditionalWorkCharge"];

            $TotalAdditionalWorkCharge += $AdditionalWorkCharge;

            $OtherCharge = $ProductDetails[0]["OtherCharge"];
            $TotalOtherCharge += $OtherCharge;

            $DeductionCharge = $ProductDetails[0]["DeductionCharge"];
            $TotalDeductionCharge += $DeductionCharge;

            $TotalNetSalesPrice = $ProductDetails[0]["NetSalesPrice"];
            $TotalNetSalesPriceAmount += $TotalNetSalesPrice;


//        Actual payment
            $ActualPaymentDetails = SQL_Select("actualsalsepayment where SalesID={$SalesID} and DateOfCollection BETWEEN '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}'");


            $TotalActualReceiveAmount = 0;
            foreach ($ActualPaymentDetails as $ActualPaymentDetail) {
                $TotalActualReceiveAmount += $ActualPaymentDetail["ActualReceiveAmount"];
            }
            $GrandTotalActualReceiveAmount += $TotalActualReceiveAmount;


//        Due payment

            $DuePaymentDetails = SQL_Select("schedulepayment where SalesID={$SalesID} and Date BETWEEN '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}' ");


            $TotalDueAmount = 0;
            foreach ($DuePaymentDetails as $DuePaymentDetail) {
                $TotalDueAmount += $DuePaymentDetail["PayAbleAmount"];
            }
            $GrandTotalDueAmount += $TotalDueAmount;


            $ActualDue = $TotalDueAmount - $TotalActualReceiveAmount;

            $grandActualDue += $ActualDue;

            $percentOfcollection = ($TotalActualReceiveAmount / $TotalNetSalesPrice) * 100;


            $trHtml .= '
        
        <tr>
            <td class="text-center">' . $sl . '</td>
            <td class="text-left">' . $customerName . '</td>
            <td class="text-left">' . $SellerName . '</td>
            <td class="text-left">' . $SalesDate . '</td>
            <td class="text-left">' . $ProjectName . '</td>
            <td class="text-left">' . $ProductName . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($FlatPrice) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($CarParkingCharge) . '</td>
            
            <td class="text-right">' . BangladeshiCurencyFormat($UtilityCharge) . '</td>
            
            <td class="text-right">' . BangladeshiCurencyFormat($AdditionalWorkCharge) . '</td>
            
            <td class="text-right">' . BangladeshiCurencyFormat($OtherCharge) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($DeductionCharge) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($TotalNetSalesPrice) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($TotalActualReceiveAmount) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($ActualDue) . '</td>
            <td class="text-right">' . round($percentOfcollection, 2) . ' %</td>
            
        </tr>
        
        
        ';

            $sl++;


        }


    }



}elseif (!empty($_REQUEST["CategoryID"]) and !empty($_REQUEST["FromDate"]) and !empty($_REQUEST["ToDate"])){

    // One Project Date


    $categories = SQL_Select("category where CategoryID={$_REQUEST["CategoryID"]}");


    $sl = 1;
    $trHtml = "";

    $TotalFlatAmount = 0;
    $TotalCarParkingCharge = 0;
    $TotalUtilityCharge = 0;
    $TotalAdditionalWorkCharge = 0;
    $TotalOtherCharge = 0;

    $TotalDeductionCharge = 0;

    $TotalNetSalesPriceAmount = 0;

    $GrandTotalActualReceiveAmount = 0;
    $GrandTotalDueAmount = 0;

    $grandActualDue = 0;

    foreach ($categories as $category) {
        $salesProjctDetails = SQL_Select("sales where ProjectID={$category["CategoryID"]}");


        foreach ($salesProjctDetails as $salesProjctDetail) {


            $SalesID = $salesProjctDetail["SalesID"];

            $customerName = $salesProjctDetail["CustomerName"];
            $SellerName = $salesProjctDetail["SellerName"];
            $SalesDate = $salesProjctDetail["SalesDate"];
            $ProjectName = $salesProjctDetail["ProjectName"];

            $ProductName = $salesProjctDetail["ProductName"];

            $ProductDetailsArray = explode("-", $ProductName);

            $floor = $ProductDetailsArray[0];
            $type = $ProductDetailsArray[1];


            $ProductDetails = SQL_Select("products where CategoryID={$category["CategoryID"]} and FlatType='{$type}' and FloorNumber='{$floor}' ");


            $FlatPrice = $ProductDetails[0]["FlatPrice"];

            $TotalFlatAmount += $FlatPrice;

            $CarParkingCharge = $ProductDetails[0]["CarParkingCharge"];

            $TotalCarParkingCharge += $CarParkingCharge;

            $UtilityCharge = $ProductDetails[0]["UtilityCharge"];

            $TotalUtilityCharge += $UtilityCharge;

            $AdditionalWorkCharge = $ProductDetails[0]["AdditionalWorkCharge"];

            $TotalAdditionalWorkCharge += $AdditionalWorkCharge;

            $OtherCharge = $ProductDetails[0]["OtherCharge"];
            $TotalOtherCharge += $OtherCharge;

            $DeductionCharge = $ProductDetails[0]["DeductionCharge"];
            $TotalDeductionCharge += $DeductionCharge;

            $TotalNetSalesPrice = $ProductDetails[0]["NetSalesPrice"];
            $TotalNetSalesPriceAmount += $TotalNetSalesPrice;


//        Actual payment
            $ActualPaymentDetails = SQL_Select("actualsalsepayment where SalesID={$SalesID} and DateOfCollection BETWEEN '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}'");
            $TotalActualReceiveAmount = 0;
            foreach ($ActualPaymentDetails as $ActualPaymentDetail) {
                $TotalActualReceiveAmount += $ActualPaymentDetail["ActualReceiveAmount"];
            }
            $GrandTotalActualReceiveAmount += $TotalActualReceiveAmount;

//        Due payment

            $DuePaymentDetails = SQL_Select("schedulepayment where SalesID={$SalesID} and Date BETWEEN '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}' ");

            $TotalDueAmount = 0;
            foreach ($DuePaymentDetails as $DuePaymentDetail) {
                $TotalDueAmount += $DuePaymentDetail["PayAbleAmount"];
            }
            $GrandTotalDueAmount += $TotalDueAmount;


            $ActualDue = $TotalDueAmount - $TotalActualReceiveAmount;

            $grandActualDue += $ActualDue;

            $percentOfcollection = ($TotalActualReceiveAmount / $TotalNetSalesPrice) * 100;


            $trHtml .= '
        
        <tr>
            <td class="text-center">' . $sl . '</td>
            <td class="text-left">' . $customerName . '</td>
            <td class="text-left">' . $SellerName . '</td>
            <td class="text-left">' . $SalesDate . '</td>
            <td class="text-left">' . $ProjectName . '</td>
            <td class="text-left">' . $ProductName . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($FlatPrice) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($CarParkingCharge) . '</td>
            
            <td class="text-right">' . BangladeshiCurencyFormat($UtilityCharge) . '</td>
            
            <td class="text-right">' . BangladeshiCurencyFormat($AdditionalWorkCharge) . '</td>
            
            <td class="text-right">' . BangladeshiCurencyFormat($OtherCharge) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($DeductionCharge) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($TotalNetSalesPrice) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($TotalActualReceiveAmount) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($ActualDue) . '</td>
            <td class="text-right">' . round($percentOfcollection, 2) . ' %</td>
            
        </tr>
        
        
        ';

            $sl++;


        }

    }






} else {

    header("location: index.php?Theme=default&Base=Report&Script=Manage");
}


$MainContent .= '

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title> Customer Party Ledger Summary</title>

    <style>
        .m-b-30 {
            margin-bottom: 30px;
        }

        .m-t-30 {
            margin-top: 30px;
        }
        
          .table-bordered th, .table-bordered td {
                border: 1px solid rgba(0,0,0,.3) !important;
          }
          
          .company-name{
            border-bottom: 1px solid rgba(0,0,0,.3);
          }

    </style>
</head>
<body>


<div style="width: 95%; margin: auto">
    <p style="font-size: 16px">Printing Date & Time: ' . date('F j-y, h:i:sa') . '</p>
</div>
<div style="width: 95%; margin: auto">

    <div style="padding: 10px 0px;" class="company-name row">
        <div class="col-md-2 text-center">
            <img height="70px" src="./upload/' . $Settings["logo"] . '" alt="">
        </div>
        <div class="col-md-9 text-center">
            <h3 style="font-weight: bold">' . $Settings["CompanyName"] . '</h3>
            <p style="font-size: 18px;">' . $Settings["Address"] . '</p>

        </div>

    </div>

    <div class="projectName text-center m-b-30 m-t-30">
        <h4 style="font-weight: bold">Project Wise Party Ledger Summary</h4>
    </div>
    
    <table style="font-size: 16px" class="table table-bordered table-hover table-fixed table-sm">

        <thead>
            <tr>
                <th colspan="16" scope="col" class="text-center"><h6 style="font-weight: bold;">Customer
                        Information</h6></th>
            </tr>
            <tr style="text-align: center">
                <td>Serial No.</td>
                <td>Customer Name</td>
                <td>Seller Name</td>
                <td>Date Of Sales</td>
                <td>Project Name</td>
                <td>Floor No</td>
                <td>Apat Value</td>
                <td>Car Parking Charge</td>
                <td>Utility Charge</td>
                <td>Additional Charge</td>
                <td>Other Charge</td>
                <td>Discount</td>
                <td>Total</td>
                <td>Total Collection</td>
                <td>Total Due</td>
                <td>Percent of Collection</td>

            </tr>

        </thead>

        <tbody>
              
            ' . $trHtml . '
            
            <tr style="height: 35px;">
                <td colspan="16" class="text-left"></td>
                
            </tr>
            <tr style="font-weight: bold">
                <td colspan="6" class="text-right">Total =</td>
                
                <td class="text-right">' . BangladeshiCurencyFormat($TotalFlatAmount) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalCarParkingCharge) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalUtilityCharge) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalAdditionalWorkCharge) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalOtherCharge) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalDeductionCharge) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalNetSalesPriceAmount) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($GrandTotalActualReceiveAmount) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($grandActualDue) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat() . '</td>
                
                
            </tr>
            
            
        </tbody>

    </table>

</div>';
