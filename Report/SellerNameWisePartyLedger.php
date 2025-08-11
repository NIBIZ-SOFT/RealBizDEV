<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 5/2/2019
 * Time: 3:09 PM
 */

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

$FromDate = isset($_REQUEST["FromDate"]) && strtotime($_REQUEST["FromDate"]) ? $_REQUEST["FromDate"] : '2000-01-01';
$ToDate = isset($_REQUEST["ToDate"]) && strtotime($_REQUEST["ToDate"]) ? $_REQUEST["ToDate"] : '3000-01-01';



if (!empty($_REQUEST["SalerNameID"])) {

    // One Project


    $categories = SQL_Select("category");


    $sl = 1;
    $trHtml = "";

    $TotalFlatAmount = 0;
    $TotalCarParkingCharge = 0;
    $TotalUtilityCharge = 0;
    $TotalAdditionalWorkCharge = 0;
    $TotalOtherCharge = 0;

    $TotalDeductionCharge = 0;

    $TotalRefundWorkCharge=0;

    $TotalNetSalesPriceAmount = 0;

    $GrandTotalActualReceiveAmount = 0;
    $GrandTotalDueAmount = 0;

    $grandActualDue = 0;
    $GrandTotalCommission =0;
    $GrandTotalPaidCommission =0;
    $GrandTotalDueCommission=0;
    $grandPDQuantity = 0;


    foreach ($categories as $category) {
        $salesProjctDetails = SQL_Select("sales where SellerID='{$_REQUEST["SalerNameID"]}' and SalesDate BETWEEN '{$FromDate}' and '{$ToDate}' ORDER BY `SalesDate` Asc");


        foreach ($salesProjctDetails as $salesProjctDetail) {

            $DeductionCharge=$TotalNetSalesPrice=0;

            $SalesID = $salesProjctDetail["SalesID"];

            $customerName = $salesProjctDetail["CustomerName"];
            $CustomerID = $salesProjctDetail["CustomerID"];

            $SellerName = $salesProjctDetail["SellerName"];
            $SalerNameID = $_REQUEST["SalerNameID"];

            $SalesDate = $salesProjctDetail["SalesDate"];
            $ProjectName = $salesProjctDetail["ProjectName"];

            $ProductName = $salesProjctDetail["ProductName"];

            $grandPDQuantity += $salesProjctDetail["Quantity"];

            $ProductDetailsArray = explode("-", $ProductName);

            $floor = $ProductDetailsArray[0];
            $type = $ProductDetailsArray[1];
            $TotalDueCommission = 0;


//            $ProductDetails = SQL_Select("products where CategoryID={$category["CategoryID"]} ");
//
//
//            $FlatPrice = $ProductDetails[0]["FlatPrice"];
//
//            $TotalFlatAmount += $FlatPrice;

            $ProductDetails = SQL_Select("products where ProductsID={$salesProjctDetail["ProductID"]} ");
            $FlatPrice = $ProductDetails[0]["FlatPrice"];
            $TotalFlatAmount += $FlatPrice;

            //$CarParkingCharge = $ProductDetails[0]["CarParkingCharge"];

            //$TotalCarParkingCharge += $CarParkingCharge;

            //$UtilityCharge = $ProductDetails[0]["UtilityCharge"];

            //$TotalUtilityCharge += $UtilityCharge;

            //$AdditionalWorkCharge = $ProductDetails[0]["AdditionalWorkCharge"];

           // $TotalAdditionalWorkCharge += $AdditionalWorkCharge;

            // $OtherCharge = $ProductDetails[0]["OtherCharge"];
            // $TotalOtherCharge += $OtherCharge;

            //$DeductionCharge = $ProductDetails[0]["DeductionCharge"];
            $DeductionCharge = $salesProjctDetail["Discount"];

            $TotalDeductionCharge += $DeductionCharge;

            // $RefundAdditionalWorkCharge= $ProductDetails[0]["RefundAdditionalWorkCharge"];
            // $TotalRefundWorkCharge +=$RefundAdditionalWorkCharge;

            $TotalNetSalesPrice = ($ProductDetails[0]["NetSalesPrice"] * $salesProjctDetail["Quantity"])-$salesProjctDetail["Discount"];
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


            $ActualDue = $TotalNetSalesPrice - $TotalActualReceiveAmount;

            $grandActualDue += $ActualDue;

            $percentOfcollection = ($TotalActualReceiveAmount / $TotalNetSalesPrice) * 100;


// Fetch Booking Money (Total Payable Amount for "Booking Money")
            $GetBookingMoney = @mysql_fetch_array(mysql_query("SELECT SUM(PayAbleAmount) as total FROM tblschedulepayment WHERE SalesID={$SalesID} AND Title='Booking Money'"), MYSQL_ASSOC);

// Fetch Rest of Money (Total Payable Amount for non-Booking Money)
            $GetRestofMoney = @mysql_fetch_array(mysql_query("SELECT SUM(PayAbleAmount) as total FROM tblschedulepayment WHERE SalesID={$SalesID} AND Title != 'Booking Money'"), MYSQL_ASSOC);

// Step 1: Fetch SellerID from tblsales based on SalesID
            $GetSellerID = @mysql_fetch_array(mysql_query("SELECT SellerID FROM tblsales WHERE SalesID = {$SalesID}"), MYSQL_ASSOC);

// Step 2: Fetch Seller's Commission Percentages
            if ($GetSellerID) {
                $SellerID = $GetSellerID['SellerID'];

                // Fetch RestOfCommission for the seller from tblsalername
                $GetSalerRestofPercent = @mysql_fetch_array(mysql_query("SELECT RestOfCommission FROM tblsalername WHERE SalerNameID = {$SellerID}"), MYSQL_ASSOC);
                $GetSalerBookingPercent = @mysql_fetch_array(mysql_query("SELECT Commission FROM tblsalername WHERE SalerNameID = {$SellerID}"), MYSQL_ASSOC);

                // Step 3: Calculate Total Commission if Seller and Data are found
                if ($GetSalerRestofPercent && $GetSalerBookingPercent) {
                    $BookingCommissionPercent = isset($GetSalerBookingPercent['Commission']) ? $GetSalerBookingPercent['Commission'] : 0; // Default to 0 if null
                    $RestOfCommissionPercent = isset($GetSalerRestofPercent['RestOfCommission']) ? $GetSalerRestofPercent['RestOfCommission'] : 0; // Default to 0 if null

                    $TotalCommission = 0;

                    // Calculate Commission for Booking Money
                    //$BookingMoneyTotal = isset($GetBookingMoney["total"]) ? $GetBookingMoney["total"] : 0; // Default to 0 if null
                    $BookingMoneyTotal = $TotalActualReceiveAmount; // Default to 0 if null



                    if ($TotalActualReceiveAmount > $GetBookingMoney['total']) {
                        // Apply 10% commission on the booking money
                        $TotalCommission += ($GetBookingMoney['total'] * $BookingCommissionPercent) / 100;

                        // Calculate the remaining money after booking money
                        $RestofMoneyTotal = $TotalActualReceiveAmount - $GetBookingMoney['total'];

                        // Apply 4% commission on the remaining amount
                        $TotalCommission += ($RestofMoneyTotal * $RestOfCommissionPercent) / 100;
                    } else {
                        // If actual amount is less than or equal to booking money, apply 10% commission on the actual amount
                        $TotalCommission += ($TotalActualReceiveAmount * $BookingCommissionPercent) / 100;
                    }
                    $GrandTotalCommission += $TotalCommission;
                    // Calculate Commission for Rest of Money
                    //$RestofMoneyTotal = isset($GetRestofMoney["total"]) ? $GetRestofMoney["total"] : 0; // Default to 0 if null




                    // DUE And PAid
                    // Step 1: Fetch Total Paid Commission from tblsalerpayment
                    $GetTotalPaidCommission = @mysql_fetch_array(mysql_query("SELECT SUM(Amount) as total FROM tblsalerpayment WHERE SalesID = {$SalesID}"), MYSQL_ASSOC);

                    // Step 2: Calculate Total Due Commission
                    if ($GetTotalPaidCommission) {
                        $TotalPaidCommission = isset($GetTotalPaidCommission['total']) ? $GetTotalPaidCommission['total'] : 0; // Default to 0 if null

                        // Step 3: Calculate Total Due Commission
                        $TotalDueCommission = $TotalCommission - $TotalPaidCommission;

                        // Optional: Output the total commission
//                         echo "Total Paid Commission: " . $TotalPaidCommission;
//                         echo "Total Due Commission: " . $TotalDueCommission;
                    } else {
                        // Default to 0 if no paid commission data found
                        $TotalPaidCommission = 0;
                        $TotalDueCommission = $TotalCommission; // If no paid commission, all is due
                    }
                    $GrandTotalPaidCommission += $TotalPaidCommission;
                    $GrandTotalDueCommission += $TotalDueCommission;
                    // Output the total commission (optional)
                    // echo "Total Commission: " . $TotalCommission;
                } else {
                    echo "Error: Could not fetch commission percentages for SellerID {$SellerID}.";
                }
            } else {
                echo "Error: SellerID not found for SalesID {$SalesID}.";
            }







            // salesman commission calculation


            $trHtml .= '
        
        <tr>
            <td class="text-center">' . $sl . '</td>
            <td class="text-left">' . $SalesID . '</td>
            <td class="text-left">' . $customerName." - $CustomerID" . '</td>
            <td class="text-left">' . $SellerName." - $SalerNameID" . '</td>
            <td class="text-left">' . HumanReadAbleDateFormat($SalesDate) . '</td>
            <td class="text-left">' . $ProjectName . '</td>
            <td class="text-left">' . $ProductName . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($FlatPrice) . '</td>
            <td class="text-right">' . $salesProjctDetail["Quantity"] . '</td>

            <td class="text-right">' . BangladeshiCurencyFormat($DeductionCharge) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($TotalNetSalesPrice) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($TotalActualReceiveAmount) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($ActualDue) . '</td>
            <td class="text-right">' . round($percentOfcollection, 2) . ' %</td>

            <td class="text-right">' . BangladeshiCurencyFormat($TotalCommission) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($TotalPaidCommission) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($TotalDueCommission) . '</td>
            
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

    <title>Customer Party Ledger Summary</title>

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
        <h4 style="font-weight: bold">Seller Name Wise Party Ledger</h4>
        <p class="text-right">From: '.$_REQUEST["FromDate"].' To:  '.$_REQUEST["ToDate"].'</p>
    </div>
    
    
    <table style="font-size: 16px" class="table table-bordered table-hover table-fixed table-sm">

        <thead>
            <tr>
                <th colspan="17" scope="col" class="text-center"><h6 style="font-weight: bold;">Customer
                        Information</h6></th>
            </tr>
            <tr style="text-align: center">
                <td>Serial No.</td>
                <td>Sales ID</td>
                <td>Customer Name</td>
                <td>Seller Name</td>
                <td>Date Of Sales</td>
                <td>Project Name</td>
                <td>Share No</td>
                <td>Share Value</td>
                <td>Share QTY</td>
                <td>Discount</td>
                <td>Total</td>
                <td>Total Collection</td>
                <td>Total Due</td>
                <td>Percent of Collection</td>
                <td>Total Comm.</td>
                <td>Paid Comm.</td>
                <td>Due Comm.</td>

            </tr>

        </thead>

        <tbody>
              
            ' . $trHtml . '
            
            <tr style="height: 35px;">
                <td colspan="17" class="text-left"></td>
                
            </tr>
            <tr style="font-weight: bold;">
                <td colspan="7" class="text-right">Total =</td>
                
                <td class="text-right">' . BangladeshiCurencyFormat($TotalFlatAmount) . '</td>
                <td class="text-right">' . $grandPDQuantity . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalDeductionCharge) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalNetSalesPriceAmount) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($GrandTotalActualReceiveAmount) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($grandActualDue) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat() . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($GrandTotalCommission) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($GrandTotalPaidCommission) . '</td>
            <td class="text-right">' . BangladeshiCurencyFormat($GrandTotalDueCommission) . '</td>
                
                
            </tr>
             
            
        </tbody>

    </table>

</div>';






//Draft

//$GetBookingMoney = @mysql_fetch_array(mysql_query("SELECT SUM(PayAbleAmount) as total FROM tblschedulepayment WHERE SalesID=115 AND Title='Booking Money'"), MYSQL_ASSOC);
//$GetRestofMoney = @mysql_fetch_array(mysql_query("SELECT SUM(PayAbleAmount) as total FROM tblschedulepayment WHERE SalesID=115 AND Title != 'Booking Money'"), MYSQL_ASSOC);
//
//$ActualPaymentDetails = @mysql_fetch_array(mysql_query("SELECT SUM(ActualReceiveAmount) as total FROM tblactualsalsepayment WHERE SalesID=115"), MYSQL_ASSOC);
//
//$bookingAmount = $GetBookingMoney['total'];
//$actualAmount = $ActualPaymentDetails['total'];
//
//$commission = 0;
//
//// Commission calculation logic
//if ($actualAmount <= $bookingAmount) {
//    // If the actual amount is less than or equal to booking money, apply 10% commission
//    $commission = $actualAmount * 0.10;
//} else {
//    // If the actual amount is greater than the booking money
//    // Apply 10% commission on booking amount
//    $commission = $bookingAmount * 0.10;
//
//    // Apply 4% commission on the remaining amount (ActualAmount - BookingAmount)
//    $commission += ($actualAmount - $bookingAmount) * 0.04;
//}
//
//echo "Commission: " . $commission;

