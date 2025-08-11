<?php

/**

 * Created by PhpStorm.

 * User: NiBiZ Soft

 * Date: 5/12/2019

 * Time: 1:05 PM

 */



$Settings = SQL_Select("Settings", "SettingsID=1", "", true);





if (!empty($_REQUEST["ID"])){



    $purchaserequisitionDetails=SQL_Select("purchaserequisition where Confirm='Confirm' and  RequisitionConfirmID like  '%{$_REQUEST["ID"]}%' ");





    $totalrequisitionQty=0;

    $totalrequisitionRate=0;

    $totalrequisitionAmount=0;



    $trHtml="";



    foreach ($purchaserequisitionDetails as $purchaserequisitionDetail){



        $CategoryName=$purchaserequisitionDetail["CategoryName"];

        $RequisitionConfirmID=$purchaserequisitionDetail["RequisitionConfirmID"];

        $EmployeeName=$purchaserequisitionDetail["EmployeeName"];

        $RequiredDate=$purchaserequisitionDetail["RequiredDate"];



        $Items=$purchaserequisitionDetail["Items"];



        $Items=json_decode($Items);



        foreach ($Items as $Item){





            $expenseHead=GetExpenseHeadName($Item->expenseHead);

            $requisitionQty=$Item->requisitionQty;

            $requisitionRate=$Item->requisitionRate;

            $requisitionAmount=$Item->requisitionAmount;



            $totalrequisitionQty +=$requisitionQty;

            $totalrequisitionRate +=$requisitionRate;

            $totalrequisitionAmount +=$requisitionAmount;





            $trHtml .='

                    <tr>

                        <th  class="text-center" scope="row">01</th>

                        <td>'.$EmployeeName.'</td>

                        <td>'.$RequisitionConfirmID.'</td>

                        <td>'.HumanReadAbleDateFormat($RequiredDate).'</td>

                        <td>'.$expenseHead.'</td>

                        <td class="text-right">'.BangladeshiCurencyFormat($requisitionQty).'</td>

                        <td  class="text-right">'.BangladeshiCurencyFormat($requisitionRate).'</td>

                        <td  class="text-right">'.BangladeshiCurencyFormat($requisitionAmount).'</td>     

                    </tr>';



        }





    }







}else{

    header("location:index.php?Theme=default&Base=Report&Script=Manage");

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



    <title>Purchase Requisition Report</title>



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

        <h4>Purchase Requisition</h4>

    </div>



    <div class="headOfAccountArea m-b-30">

        <div class="text-center">

            <h5>'.$CategoryName.'</h5>

        </div>

        <table class="table table-hover table-sm table-bordered">

            <thead>

            <tr  class="text-center">

                <th scope="col">S.L No</th>

                <th scope="col">Requisitor Name</th>

                <th scope="col">Requisition Name</th>

                <th scope="col">Required Date</th>

                <th scope="col">Head Of Account</th>

                <th scope="col">Required Quantity</th>

                <th scope="col">Approx Unit Cost</th>

                <th scope="col">Total Approx. Value (Tk)</th>



            </tr>

            </thead>

            <tbody>

            

             '.$trHtml.'

            



            <tr>

                <th colspan="5" class="text-right">Total =</th>



                <td class="text-right" style="font-weight: bold;">'.BangladeshiCurencyFormat($totalrequisitionQty).'</td>

                <td  class="text-right" style="font-weight: bold">'.BangladeshiCurencyFormat($totalrequisitionRate).'</td>

                <td  class="text-right" style="font-weight: bold">'.BangladeshiCurencyFormat($totalrequisitionAmount).'</td>

            </tr>



            </tbody>

        </table>

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









