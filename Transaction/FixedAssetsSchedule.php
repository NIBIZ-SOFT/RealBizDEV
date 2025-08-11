<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 4/28/2019
 * Time: 10:49 AM
 */


$Settings = SQL_Select("Settings", "SettingsID=1", "", true);


if (!empty($_REQUEST["FromDate"]) && !empty($_REQUEST["ToDate"]) ){

    $FromDate=$_REQUEST["FromDate"];
    $ToDate=$_REQUEST["ToDate"];

    $ParentHeads=SQL_Select("incomeexpensetype");
    foreach ($ParentHeads as $parentHead){

        if ($parentHead["Name"]=="Property, Plant & Equipment"){
            $OtherExpenseID=$parentHead["IncomeExpenseTypeID"];
        }

    }

    $FixedAssetsChildDetails=SQL_Select("expensehead where IncomeExpenseTypeID={$OtherExpenseID}");

    $FromTotalBalance=0;
    $ToTotalBalance=0;

    $trHtml="";
    foreach ($FixedAssetsChildDetails as $FixedAssetsChildDetail){

        $TotalFrom=GetBalanceHeadOfAccountIDWithDate($FixedAssetsChildDetail["ExpenseHeadID"],'1-1-2014',$FromDate);


        $TotalTo=GetBalanceHeadOfAccountIDWithDate($FixedAssetsChildDetail["ExpenseHeadID"],'1-1-2014',$ToDate);

        $FromTotalBalance +=$TotalFrom;
        $ToTotalBalance +=$TotalTo;
        $trHtml .='
        
            <tr>
               <td>'.$FixedAssetsChildDetail["ExpenseHeadName"].'</td>
               <td class="text-right">'.BangladeshiCurencyFormat($TotalFrom).'</td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td class="text-right">'.BangladeshiCurencyFormat($TotalTo).'</td>
            </tr>
        
        ';


    }


}else{
    header("location:index.php?Theme=default&Base=Transaction&Script=FixedAssetsScheduleManage");

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

    <title>Receive & Payment Manage</title>

    <style>
        .m-b-30{
            margin-bottom: 30px;
        }
        .m-t-30{
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

    <div style="padding: 10px 0px; border-bottom: 1px solid #DEE2E6;" class="company-name row">
        <div  class="col-md-2 text-center">
              <img style="width:70px;" src="./upload/' . $Settings["logo"] . '" alt="">
        </div>
        <div  class="col-md-9 text-center">
            <h3 style="font-weight: bold">'.$Settings["CompanyName"].'</h3>
            <p style="font-size: 18px;">'.$Settings["Address"].'</p>

        </div>

    </div>

    <div class="projectName text-center m-b-30 m-t-30">
        <h4 style="font-weight: bold">Fixed Assets Schedule</h4>
    </div>
    
    <table class="table table-bordered table-hover table-fixed table-sm">
        
            <thead>
            <tr>
                <th scope="col">Particulars</th>
                <th scope="col">Opening Balance <br>( '.$FromDate.' )</th>
                <th scope="col">Addition During Year</th>
                <th scope="col">Deduction During Year</th>
                <th scope="col">Total Assets</th>
                <th scope="col">Dep.Rate (%)</th>
                <th scope="col">Accumulated Depreciation</th>
                <th scope="col">Current Year Depreciation</th>
                <th scope="col">Total Depreciation</th>
                <th scope="col">Closing Balance <br> ( '.$ToDate.' )</th>
                
            </tr>
            </thead>
    
    
            <tbody>
            
            
            '.$trHtml.'
            
            
            </tbody>
            
            
            
            <thead>
            <tr>
                <th style="height: 40px" scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <thead>
            <tr>
                
                <th scope="col">Total =</th>
                <th class="text-right" scope="col">'.BangladeshiCurencyFormat($FromTotalBalance).'</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th class="text-right" scope="col">'.BangladeshiCurencyFormat($ToTotalBalance).'</th>
            
            </tr>
            </thead>
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
</html>


';



