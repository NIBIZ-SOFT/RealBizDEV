<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 5/2/2019
 * Time: 11:09 AM
 */

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);


if ( !empty($_REQUEST["CategoryID"]) and !empty($_REQUEST["customer_id"])){

//    Project Customer No date

    $CustomerDetails=SQL_Select("customer Where CustomerID={$_REQUEST["customer_id"]}");

    $ProjectDetails=SQL_Select("category Where CategoryID={$_REQUEST["CategoryID"]}");

    $ProjectWithCustomerSalesDetails=SQL_Select("sales Where ProjectID={$_REQUEST["CategoryID"]} and CustomerID={$_REQUEST["customer_id"]} ");



    if (!empty($ProjectWithCustomerSalesDetails)){
        $ProductDetails=SQL_Select("products Where ProductsID={$ProjectWithCustomerSalesDetails[0]["ProductID"]} ");
    }else{

        header("location: index.php?Theme=default&Base=Report&Script=Manage");
    }




//    Schedule Payment
    $SchedulePaymentDetails=SQL_Select("schedulepayment Where SalesID={$ProjectWithCustomerSalesDetails[0]["SalesID"]} ");

    // Actual Payment
    $AllActualPaymentDetails = SQL_Select("Actualsalsepayment where SalesID={$ProjectWithCustomerSalesDetails[0]["SalesID"]} ");



    $AptType="";
    $AptSize="";
    $Floor="";
    $Price="";
    $SalesDate=$ProjectWithCustomerSalesDetails[0]["SalesDate"];



//    Customer

    foreach ($CustomerDetails as $CustomerDetail){

        $FileNo=$CustomerDetail["CustomerID"];
        $CustomerName=$CustomerDetail["CustomerName"];
        $PresentAddress=$CustomerDetail["Address"];
        $MobileNo=$CustomerDetail["Phone"];
        $PhoneNo="";
        $EmailAddress=$CustomerDetail["CustomerEmail"];

    }

//    Project Information

    foreach ($ProjectDetails as $ProjectDetail){
        $ProjectName=$ProjectDetail["Name"];
        $ProjectLocation=$ProjectDetail["Address"];
        $Facing=$ProjectDetail["Facing"];
        $HandOver=$ProjectDetail["HandOver"];


    }

//    Product Details


    foreach ( $ProductDetails as $ProductDetail ){
        $ApartmentPrice=$ProductDetail["FlatPrice"];
        $DeductionCharge=$ProductDetail["DeductionCharge"];
        $TotalPrice= $ApartmentPrice- $DeductionCharge;
        $CarParkingCharge=$ProductDetail["CarParkingCharge"];
        $UtilityCharge=$ProductDetail["UtilityCharge"];
        $TotalApartmentValue = $TotalPrice +$CarParkingCharge + $UtilityCharge;

        $AdditionalWorkCharge=$ProductDetail["AdditionalWorkCharge"];

        $OtherCharge=$ProductDetail["OtherCharge"];  // 3 items total= Refund for additional work material supply by client

        $RefundAdditionalworkCharge= $ProductDetail["RefundAdditionalWorkCharge"];

        $TotalAptValuewithAdditionalCharge= ($TotalApartmentValue + $AdditionalWorkCharge + $OtherCharge) - $RefundAdditionalworkCharge;

        $AptType =$ProductDetail["FlatType"];
        $AptSize =$ProductDetail["FlatSize"];
        $Floor=$ProductDetail["FloorNumber"];
        $Price=$ProductDetail["UnitPrice"];


    }


    $SheudulePaymentHtml="";

    $totalDue=0;

    foreach ($SchedulePaymentDetails as $SchedulePaymentDetail){

        $Date=$SchedulePaymentDetail["Date"];
        $Term=$SchedulePaymentDetail["Title"];
        $PayAbleAmount=$SchedulePaymentDetail["PayAbleAmount"];
        $totalDue +=$PayAbleAmount;
        $SheudulePaymentHtml .='
        
                <tr>
                    <td class="text-left">'.$Date.'</td>
                    <td class="text-left">'.$Term.'</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($PayAbleAmount).'</td>

                </tr>
        ';

        
    }

//    Actual Payment


    $ActualPaymentHtml="";

    $TotalReceiveAmount=0;
    $TotalAdjustmentAmount=0;
    $TotalActualReceiveAmount=0;
    foreach ($AllActualPaymentDetails as $AllActualPaymentDetail){

        $DateOfCollection=$AllActualPaymentDetail["DateOfCollection"];
        $Term=$AllActualPaymentDetail["Term"];
        $ReceiveAmount=$AllActualPaymentDetail["ReceiveAmount"];
        $Adjustment=$AllActualPaymentDetail["Adjustment"];
        $ActualReceiveAmount=$AllActualPaymentDetail["ActualReceiveAmount"];
        $MRRNO=$AllActualPaymentDetail["MRRNO"];
        $ModeOfPayment=$AllActualPaymentDetail["ModeOfPayment"];
        $ChequeNo=$AllActualPaymentDetail["ChequeNo"];
        $BankName=$AllActualPaymentDetail["BankName"];
        $Remark=$AllActualPaymentDetail["Remark"];

        $TotalReceiveAmount +=$ReceiveAmount;
        $TotalAdjustmentAmount +=$Adjustment;
        $TotalActualReceiveAmount +=$ActualReceiveAmount;

        $ActualPaymentHtml .='
        
                <tr>

                    <td class="text-left">'.$DateOfCollection.'</td>
                    <td class="text-left">'.$Term.'</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($ReceiveAmount).'</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($Adjustment).'</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($ActualReceiveAmount).'</td>
                    <td class="text-left">'.$MRRNO.'</td>
                    <td class="text-left">'.$ModeOfPayment.'</td>
                    <td class="text-left">'.$ChequeNo.'</td>
                    <td class="text-left">'.$BankName.'</td>
                    <td class="text-left">'.$Remark.'</td>


                </tr>
        
        
        ';

    }


    $TotalDueAmount= $totalDue -$TotalActualReceiveAmount;




}else{


    header("location: index.php?Theme=default&Base=Report&Script=Manage");

}








$MainContent .='

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Party Ledger</title>

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
    <p style="font-size: 16px">Printing Date & Time: '.date('F j-y, h:i:sa').'</p>
</div>
<div style="width: 95%; margin: auto">

    <div style="padding: 10px 0px;" class="company-name row">
        <div class="col-md-2 text-center">
            <img height="70px" src="./upload/' . $Settings["logo"] . '" alt="">
        </div>
        <div class="col-md-9 text-center">
            <h3 style="font-weight: bold">'.$Settings["CompanyName"].'</h3>
            <p style="font-size: 18px;">'.$Settings["Address"].'</p>

        </div>

    </div>

    <div class="projectName text-center m-b-30 m-t-30">
        <h4 style="font-weight: bold">Party Ledger</h4>
    </div>


    <div class="row">

        <div style="font-size:14px" class="col-md-6">

            <table class="table table-bordered table-hover table-fixed table-sm">

                <thead>
                <tr>
                    <th colspan="2" scope="col" class="text-center"><h6 style="font-weight: bold;">Customer
                            Information</h6></th>
                </tr>
                <tr style="text-align: center">
                    <td>Description</td>
                    <td>Description</td>

                </tr>

                </thead>

                <tbody>
                
                
                <tr>
                    <td class="text-left">File No.</td>
                    <td class="text-left">'.str_pad($FileNo, "4", "0", STR_PAD_LEFT).'</td>

                </tr>
                <tr>
                    <td class="text-left">Customer Name</td>
                    <td class="text-left">'.$CustomerName.'</td>

                </tr>
                <tr>
                    <td class="text-left">Contract Address</td>
                    <td class="text-left">'.$PresentAddress.'</td>

                </tr>
                <tr>
                    <td class="text-left">Mobile No</td>
                    <td class="text-left">'.$MobileNo.'</td>

                </tr>
                <tr>
                    <td class="text-left">Phone No</td>
                    <td class="text-left">'.$PhoneNo.'</td>

                </tr>
                <tr>
                    <td class="text-left">Email Address</td>
                    <td class="text-left">'.$EmailAddress.'</td>

                </tr>

                <tr>
                    <td style="height: 35px" colspan="2"></td>

                </tr>

                </tbody>

            </table>


            <table class="table table-bordered table-hover table-fixed table-sm">

                <thead>
                <tr>
                    <th colspan="2" scope="col" class="text-center"><h6 style="font-weight: bold;">Project
                            Information</h6></th>
                </tr>
                <tr style="text-align: center">
                    <td>Description</td>
                    <td>Description</td>

                </tr>

                </thead>
                
                <tbody>

                <tr>
                    <td class="text-left">Project Name</td>
                    <td class="text-left">'.$ProjectName.'</td>

                </tr>
                <tr>
                    <td class="text-left">Project Location</td>
                    <td class="text-left">'.$ProjectLocation.'</td>

                </tr>

                <tr>
                    <td class="text-left">Facing</td>
                    <td class="text-left">'.$Facing.'</td>

                </tr>
                <tr>
                    <td class="text-left">Apt Type</td>
                    <td class="text-left">'.$AptType.'</td>

                </tr>
                <tr>
                    <td class="text-left">Apt Size</td>
                    <td class="text-left">'.$AptSize.'</td>

                </tr>
                <tr>
                    <td class="text-left">Floor</td>
                    <td class="text-left">'.$Floor.'</td>

                </tr>
                <tr>
                    <td class="text-left">Price</td>
                    <td class="text-left">'.$Price.'</td>

                </tr>
                <tr>
                    <td class="text-left">Sales Date</td>
                    <td class="text-left">'.$SalesDate.'</td>

                </tr>

                <tr>
                    <td class="text-left">Hadnover Date</td>
                    <td class="text-left">'.$HandOver.'</td>

                </tr>

                <tr>
                    <td style="height: 35px" colspan="2"></td>

                </tr>

                </tbody>

            </table>


        </div>
        <div style="font-size:14px" class="col-md-6">

            <table class="table table-bordered table-hover table-fixed table-sm">
                <thead>
                <tr>
                    <th colspan="2" scope="col" class="text-center"><h6 style="font-weight: bold;">Apartment Value
                            Summery</h6></th>
                </tr>
                <tr>
                    <td class="text-center">Description</td>
                    <td class="text-center">Amount tk</td>

                </tr>

                </thead>

                <tbody>
                
                <tr>
                    <td class="text-left">Apartment Price</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($ApartmentPrice).'</td>

                </tr>

                <tr>
                    <td class="text-left">(-) Discount</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($DeductionCharge).'</td>

                </tr>
                <tr>
                    <td class="text-left">Total Price</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($TotalPrice).'</td>

                </tr>
                <tr>
                    <td class="text-left">Parking Charge</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($CarParkingCharge).'</td>

                </tr>
                <tr>
                    <td class="text-left">Utility Charge</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($UtilityCharge).'</td>

                </tr>
                <tr style="font-weight: bold">
                    <td class="text-left">Total Apartment Value</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($TotalApartmentValue).'</td>

                </tr>

                <tr>
                    <td class="text-left">Additional Work Charge</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($AdditionalWorkCharge).'</td>

                </tr>

                <tr>
                    <td class="text-left">Other Charge</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($OtherCharge).'</td>

                </tr>
                <tr>
                    <td class="text-left">Refund Additional Work Charge</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($RefundAdditionalworkCharge).'</td>

                </tr>
                

                

                <tr style="font-weight: bold">
                    <td class="text-left">Total Apt Value with Additional Charge</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($TotalAptValuewithAdditionalCharge).'</td>

                </tr>


                <tr>
                    <td style="height: 35px" colspan="2"></td>

                </tr>

                </tbody>
            </table>
        </div>

    </div>

    <div class="row">

        <div class="col-12">


            <table class="table table-bordered table-hover table-fixed table-sm">
                <thead>
                <tr>
                    <th scope="col" class="text-center"><h6 style="font-weight: bold;">Payment History: Japan Taguchi Construction Company Ltd.</h6></th>
                </tr>

                </thead>

                </tbody>
            </table>
        </div>

        <div style="font-size: 14px" class="col-4">
            <table class="table table-bordered table-hover table-fixed table-sm">
                <thead>
                <tr>
                    <th colspan="3" scope="col" class="text-center"><h6 style="font-weight: bold;">Due Payment
                            History</h6></th>
                </tr>
                
                <tr>
                    <td class="text-center">Date</td>
                    <td class="text-center">Term</td>
                    <td class="text-center">Payable amount</td>

                </tr>

                </thead>

                <tbody>

                '.$SheudulePaymentHtml.'
                
                <tr style="font-weight: bold"> 
                    <td colspan="2" class="text-right">Total</td>
                    <td class="text-right">'.BangladeshiCurencyFormat($totalDue).'</td>
                </tr>
                
                <tr>
                    <td style="height: 35px" colspan="3"></td>

                </tr>

                </tbody>
            </table>
        </div>

        <div style="font-size: 14px" class="col-8">
            <table class="table table-bordered table-hover table-fixed table-sm">
                <thead>
                <tr>
                    <th colspan="10" scope="col" class="text-center"><h6 style="font-weight: bold;">Actual Payment
                            History</h6></th>
                </tr>
                <tr>
                    <td class="text-center">Date Of Collection</td>
                    <td class="text-center">Term</td>
                    <td class="text-center">Receive Amount(tk)</td>
                    <td class="text-center">Adjustment (tk)</td>
                    <td class="text-center">Actual Amount (tk)</td>
                    <td class="text-center">MRR No</td>
                    <td class="text-center">Mode of Payment</td>
                    <td class="text-center">Cheque No</td>
                    <td class="text-center">Bank Name</td>
                    <td class="text-center">Remarks</td>

                </tr>

                </thead>

                    <tbody>
    
                    '.$ActualPaymentHtml.'
                    
                    <tr style="font-weight: bold">
                 
                        <td colspan="2" class="text-right">Total</td>
                       
                        <td class="text-right">'.BangladeshiCurencyFormat($TotalReceiveAmount).'</td>
                        <td class="text-right">'.BangladeshiCurencyFormat($TotalAdjustmentAmount).'</td>
                        <td class="text-right">'.BangladeshiCurencyFormat($TotalActualReceiveAmount).'</td>
                        
                        <td colspan="5" class="text-center"></td>
                        
                    </tr>
                    
                    <tr style="font-size: 25px;font-weight: bold">
                        
                        <td colspan="10" class="text-right">Total Due : '.BangladeshiCurencyFormat($TotalDueAmount).'</td>
                       
                    </tr>
                    
                </tbody>
            </table>
        </div>

    </div>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>';
