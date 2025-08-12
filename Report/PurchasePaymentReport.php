<?php

/**

 * Created by PhpStorm.

 * User: Mahmud

 * Date: 5/12/2019

 * Time: 10:45 AM

 */





$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

$sl=1;
$VendorList = SQL_Select("purchase","VendorID={$_REQUEST["VendorID"]}");

foreach($VendorList as $ThisVendorList){
    
                $trHtml .='

                    <tr>

                        <th  class="text-center" scope="row">'.$sl.'</th>

                        <td>'.$ThisVendorList["CategoryName"].'</td>

                        <td>'.$ThisVendorList["PurchaseConfirmID"].'</td>

                        <td>'.$ThisVendorList["confirmRequisitonName"].'</td>

                        <td>'.HumanReadAbleDateFormat($ThisVendorList["DateOfDelevery"]).'</td>

                        

                        <td class="text-right">'.BangladeshiCurencyFormat($ThisVendorList["PurchaseAmount"]).'</td>


                    </tr>';

                $sl++;
                
                $totalrequisitionAmount+=$ThisVendorList["PurchaseAmount"];
                

}



    $projectHtml .='

    <div class="headOfAccountArea m-b-30">

        <div class="text-center">

            <h5>'.GetVendorName($_REQUEST["VendorID"]).' </h5>

        </div>

        <table class="table table-hover table-sm table-bordered">

            <thead>

            <tr  class="text-center">

                <th scope="col">S.L No</th>

                <th scope="col">Requisitor Name</th>

                <th scope="col">Requisition ID</th>

                <th scope="col">Purchase Order ID</th>

                <th scope="col">Delivery Date</th>

                <th scope="col">Total Value (Tk)</th>



            </tr>

            </thead>

            <tbody>



            '.$trHtml.'

            

            <tr>

                <th colspan="5" class="text-right">Total =</th>

                <td  class="text-right" style="font-weight: bold">'.BangladeshiCurencyFormat($totalrequisitionAmount).'</td>

            </tr>



            </tbody>

        </table>

    </div>';



$DebitVRList = SQL_Select("drvoucher","VendorID={$_REQUEST["VendorID"]}");
$sl=1;
foreach($DebitVRList as $ThisDebitVRList){
    
                $trHtml1 .='

                    <tr>

                        <th  class="text-center" scope="row">'.$sl.'</th>

                        <td>'.$ThisDebitVRList["HeadOfAccountName"].'</td>

                        <td>'.$ThisDebitVRList["Description"].'</td>

                        <td>'.$ThisDebitVRList["BillNo"].'</td>

                        <td>'.HumanReadAbleDateFormat($ThisDebitVRList["BillDate"]).'</td>

                        <td class="text-right">'.BangladeshiCurencyFormat($ThisDebitVRList["Amount"]).'</td>

                    </tr>';

                $sl++;
                
                $totalPaidAmount+=$ThisDebitVRList["Amount"];
                

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



    <title>Purchase Payment Report</title>



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

            <h4 style="font-weight: bold">'.$Settings["CompanyName"].'</h4>

            <p style="font-size: 18px;">'.$Settings["Address"].'</p>



        </div>



    </div>



    <div class="projectName text-center m-b-30 m-t-30">

        <h4>Purchase Order</h4>

    </div>



    '.$projectHtml.'






        <div class="projectName text-center m-b-30 m-t-30">
    
            <h4>Payment Details</h4>
    
        </div>
        <table class="table table-hover table-sm table-bordered">

            <thead>

            <tr  class="text-center">

                <th scope="col">S.L No</th>

                <th scope="col">Head Of Account</th>

                <th scope="col">Description</th>

                <th scope="col">Bill No</th>

                <th scope="col">Date</th>

                <th scope="col">Total (Tk)</th>



            </tr>

            </thead>

            <tbody>



            '.$trHtml1.'

            

            <tr>

                <th colspan="5" class="text-right">Total =</th>

                <td  class="text-right" style="font-weight: bold">'.BangladeshiCurencyFormat($totalPaidAmount).'</td>

            </tr>

            <tr>

                <th colspan="5" class="text-right">Total Due/Advance =</th>

                <td  class="text-right" style="font-weight: bold">'.BangladeshiCurencyFormat($totalrequisitionAmount-$totalPaidAmount).'</td>

            </tr>


            </tbody>

        </table>


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











