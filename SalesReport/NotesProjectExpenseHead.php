<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 4/30/2019
 * Time: 12:57 PM
 */


$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

if (empty($_POST["CategoryID"]) and !empty($_POST["IncomeExpenseTypeID"]) and !empty($_POST["FromDate"]) and !empty($_POST["ToDate"]) and !empty($_POST["FromDate1"]) and !empty($_POST["ToDate1"])) {

    $Categories = SQL_Select("Category");


    $tableHtml="";
    foreach ($Categories as $Category) {

        $CategoryID=$Category["CategoryID"];
        $CategoryName=$Category["Name"];

        $IncomeExpenseTypeID = $_REQUEST["IncomeExpenseTypeID"];

        $ParentHeadDetails = SQL_Select("incomeexpensetype where IncomeExpenseTypeID={$IncomeExpenseTypeID}");


        $parentHeadName = $ParentHeadDetails[0]["Name"];

        $FromDate = $_REQUEST["FromDate"];
        $ToDate = $_REQUEST["ToDate"];

        $FromDate1 = $_REQUEST["FromDate1"];
        $ToDate1 = $_REQUEST["ToDate1"];


        $HeadOfItemDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$IncomeExpenseTypeID}");

        $headOfAccountAmount = 0;
        $headOfAccountAmount1 = 0;
        $trhtml = "";
        $headOfAccountName = "";
        $totalAmount = 0;
        $totalAmount1 = 0;
        foreach ($HeadOfItemDetails as $HeadOfItemDetail) {
            $headOfAccountAmount = GetBalanceProjectIdWithHeadOfAccountIDWithDate($CategoryID,$HeadOfItemDetail["ExpenseHeadID"], $FromDate, $ToDate);

            $headOfAccountAmount1 = GetBalanceProjectIdWithHeadOfAccountIDWithDate($CategoryID,$HeadOfItemDetail["ExpenseHeadID"], $FromDate1, $ToDate1);

            $headOfAccountName = $HeadOfItemDetail["ExpenseHeadName"];

            $totalAmount += $headOfAccountAmount;
            $totalAmount1 += $headOfAccountAmount1;

            if (empty($headOfAccountAmount) and empty($headOfAccountAmount1)) continue;

            $trhtml .= '
            <tr >
                <td> ' . $headOfAccountName . ' </td>
                <td class="text-right">' . BangladeshiCurencyFormat($headOfAccountAmount) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($headOfAccountAmount1) . '</td>
                
            </tr>';

        }

        if (empty($totalAmount) and empty($totalAmount1)) continue;


        $tableHtml .= '
    
        <table class="table table-bordered table-hover table-fixed table-sm">
            
              <thead>
              
                    <tr>
                        <th colspan="3" scope="col" class="text-center"> <h4 style="font-weight: bold;">' . $CategoryName . '</h4></th>
                        
                    </tr>
                    
                    <tr>
                        <th scope="col" class="text-center"> <h4 style="font-weight: bold;">' . $parentHeadName . '</h4></th>
                        <th  scope="col" class="text-center"> <h5>' . HumanReadAbleDateFormat($FromDate) . ' To ' . HumanReadAbleDateFormat($ToDate) . '</h5></th>
                        <th  scope="col" class="text-center"> <h5>' . HumanReadAbleDateFormat($FromDate1) . ' To ' . HumanReadAbleDateFormat($ToDate1) . '</h5></th>
                    </tr>
                    
                    
              </thead>
              <thead>
                    <tr>
                        <th style="font-size: 25px" scope="col">Head Of Account</th>
                        <th width="300px" class="text-right" scope="col">Tk</th>
                        <th width="300px"  class="text-right"  scope="col">TK</th>
                    </tr>
              </thead>
            
              <tbody>
                        
                    ' . $trhtml . '
                    
                    <tr style="font-weight: bold; font-size: 25px">
                        <td class="text-right">Total</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($totalAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($totalAmount1) . '</td>
                       
                    </tr>
                    
                    <tr >
                        <td style="height: 35px" colspan="3"></td>
                       
                    </tr>
                        
              </tbody>
                    
        </table>
    
    ';

    }

}elseif (!empty($_POST["CategoryID"]) and !empty($_POST["IncomeExpenseTypeID"]) and !empty($_POST["FromDate"]) and !empty($_POST["ToDate"]) and !empty($_POST["FromDate1"]) and !empty($_POST["ToDate1"])){
    $Categories = SQL_Select("Category where CategoryID={$_POST["CategoryID"]}");


    $tableHtml="";
    foreach ($Categories as $Category) {

        $CategoryID=$Category["CategoryID"];
        $CategoryName=$Category["Name"];

        $IncomeExpenseTypeID = $_REQUEST["IncomeExpenseTypeID"];

        $ParentHeadDetails = SQL_Select("incomeexpensetype where IncomeExpenseTypeID={$IncomeExpenseTypeID}");


        $parentHeadName = $ParentHeadDetails[0]["Name"];

        $FromDate = $_REQUEST["FromDate"];
        $ToDate = $_REQUEST["ToDate"];

        $FromDate1 = $_REQUEST["FromDate1"];
        $ToDate1 = $_REQUEST["ToDate1"];


        $HeadOfItemDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$IncomeExpenseTypeID}");

        $headOfAccountAmount = 0;
        $headOfAccountAmount1 = 0;
        $trhtml = "";
        $headOfAccountName = "";
        $totalAmount = 0;
        $totalAmount1 = 0;
        foreach ($HeadOfItemDetails as $HeadOfItemDetail) {
            $headOfAccountAmount = GetBalanceProjectIdWithHeadOfAccountIDWithDate($CategoryID,$HeadOfItemDetail["ExpenseHeadID"], $FromDate, $ToDate);

            $headOfAccountAmount1 = GetBalanceProjectIdWithHeadOfAccountIDWithDate($CategoryID,$HeadOfItemDetail["ExpenseHeadID"], $FromDate1, $ToDate1);

            $headOfAccountName = $HeadOfItemDetail["ExpenseHeadName"];

            $totalAmount += $headOfAccountAmount;
            $totalAmount1 += $headOfAccountAmount1;

            if (empty($headOfAccountAmount) and empty($headOfAccountAmount1)) continue;

            $trhtml .= '
            <tr >
                <td> ' . $headOfAccountName . ' </td>
                <td class="text-right">' . BangladeshiCurencyFormat($headOfAccountAmount) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($headOfAccountAmount1) . '</td>
                
            </tr>';

        }

        if (empty($totalAmount) and empty($totalAmount1)) continue;


        $tableHtml .= '
    
        <table class="table table-bordered table-hover table-fixed table-sm">
            
              <thead>
              
                    <tr>
                        <th colspan="3" scope="col" class="text-center"> <h4 style="font-weight: bold;">' . $CategoryName . '</h4></th>
                        
                    </tr>
                    
                    <tr>
                        <th scope="col" class="text-center"> <h4 style="font-weight: bold;">' . $parentHeadName . '</h4></th>
                        <th  scope="col" class="text-center"> <h5>' . HumanReadAbleDateFormat($FromDate) . ' To ' . HumanReadAbleDateFormat($ToDate) . '</h5></th>
                        <th  scope="col" class="text-center"> <h5>' . HumanReadAbleDateFormat($FromDate1) . ' To ' . HumanReadAbleDateFormat($ToDate1) . '</h5></th>
                    </tr>
                    
                    
              </thead>
              <thead>
                    <tr>
                        <th style="font-size: 25px" scope="col">Head Of Account</th>
                        <th width="300px" class="text-right" scope="col">Tk</th>
                        <th width="300px"  class="text-right"  scope="col">TK</th>
                    </tr>
              </thead>
            
              <tbody>
                        
                    ' . $trhtml . '
                    
                    <tr style="font-weight: bold; font-size: 25px">
                        <td class="text-right">Total</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($totalAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($totalAmount1) . '</td>
                       
                    </tr>
                    
                    <tr >
                        <td style="height: 35px" colspan="3"></td>
                       
                    </tr>
                        
              </tbody>
                    
        </table>
    
    ';

    }



}else{

    header("location: index.php?Theme=default&Base=Transaction&Script=NotesManage");
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

    <title> Notes</title>

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

    <div style="padding: 10px 0px;" class="company-name row">
        <div  class="col-md-2 text-center">
            <img height="70px" src="./upload/' . $Settings["logo"] . '" alt="">
        </div>
        <div  class="col-md-9 text-center">
            <h3 style="font-weight: bold">'.$Settings["CompanyName"].'</h3>
            <p style="font-size: 18px;">'.$Settings["Address"].'</p>

        </div>

    </div>

    <div class="projectName text-center m-b-30 m-t-30">
        <h4 style="font-weight: bold">Notes</h4>
    </div>
    
    ' . $tableHtml . '

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