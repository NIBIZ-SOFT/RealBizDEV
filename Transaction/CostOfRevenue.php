<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 4/24/2019
 * Time: 3:13 PM
 */

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

$ParentHeads=SQL_Select("incomeexpensetype");

foreach ($ParentHeads as $parentHead){

    if ($parentHead["Name"]=="Construction Material Purchases"){
        $ConstructionMaterialPurchasesID=$parentHead["IncomeExpenseTypeID"];
    }

    if ($parentHead["Name"]=="Construction Labour Expenses"){
        $ConstructionLabourExpensesID=$parentHead["IncomeExpenseTypeID"];
    }
    if ($parentHead["Name"]=="Project Approval Expense"){
        $ProjectApprovalExpenseID=$parentHead["IncomeExpenseTypeID"];
    }
    if ($parentHead["Name"]=="Other Expense"){
        $OtherExpenseID=$parentHead["IncomeExpenseTypeID"];
    }

}

$FromDate=0;
$ToDate=0;

$FromDate1=0;
$ToDate1=0;

if (!empty($_POST["FromDate"]) and !empty($_POST["ToDate"])){
    $FromDate=$_POST["FromDate"];
    $ToDate=$_POST["ToDate"];



//    Opening Construction Material start

    // Stock Balance

    $StockDetails=SQL_Select("stock","Date BETWEEN '2016-01-01' AND  '{$_REQUEST["FromDate"]}' ");
    $stockAmount=0;
    foreach ($StockDetails as $StockDetail){

        if ($StockDetail["StockIsActive"]==1){
            $stockAmount+=$StockDetail["Value"];
        }else{
            continue;
        }

    }
//    used Stock
    $UsedStockDetails=SQL_Select("usedstock","Date BETWEEN '2016-01-01' AND  '{$_REQUEST["FromDate"]}' ");
    $usedStockAmount=0;
    foreach ($UsedStockDetails as $UsedStockDetail){

        if ($UsedStockDetail["UsedStockIsActive"]==1){
            $usedStockAmount+=$UsedStockDetail["Value"];
        }else{
            continue;
        }

    }
    
    $OpeningConstructionMaterialAmount =$stockAmount-$usedStockAmount;

//   Opening Constraction material End



    //    Construction Material Purchase start

    $ConstructionMaterialHeadChildDetails=SQL_Select("expensehead where IncomeExpenseTypeID={$ConstructionMaterialPurchasesID}");


    $TotalAmountOfConstructionMaterialPurchases=0;

    foreach ($ConstructionMaterialHeadChildDetails as $ConstructionMaterialHeadChildDetail){
        $ConstructionMaterialChildTransactionDetails=SQL_Select("transaction where HeadOfAccountID={$ConstructionMaterialHeadChildDetail["ExpenseHeadID"]} and Date BETWEEN '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}' ");

        foreach ($ConstructionMaterialChildTransactionDetails as $ConstructionMaterialChildTransactionDetail){

            if ($ConstructionMaterialHeadChildDetail["ExpenseHeadIsType"] == 1){

                $TotalAmountOfConstructionMaterialPurchases += $ConstructionMaterialChildTransactionDetail["dr"] - $ConstructionMaterialChildTransactionDetail["cr"];
            }else{
                $TotalAmountOfConstructionMaterialPurchases += $ConstructionMaterialChildTransactionDetail["cr"] - $ConstructionMaterialChildTransactionDetail["dr"];

            }

        }

    }

    //    Construction Material Purchase End


//    Material Available For Used Start

    $MaterialAvailableForUsed =$OpeningConstructionMaterialAmount+$TotalAmountOfConstructionMaterialPurchases;

//    Material Available For Used End



//    Closing Construction Material Start

// Stock Balance

    $ClosingStockDetails=SQL_Select("stock","Date BETWEEN '2016-01-01' AND  '{$_REQUEST["ToDate"]}' ");
    $ClosingStockAmount=0;
    foreach ($ClosingStockDetails as $ClosingStockDetail){

        if ($ClosingStockDetail["StockIsActive"]==1){
            $ClosingStockAmount+=$ClosingStockDetail["Value"];
        }else{
            continue;
        }

    }
//    used Stock
    $ClosingUsedStockDetails=SQL_Select("usedstock","Date BETWEEN '2016-01-01' AND  '{$_REQUEST["ToDate"]}' ");
    $ClosingUsedStockAmount=0;
    foreach ($ClosingUsedStockDetails as $ClosingUsedStockDetail){

        if ($ClosingUsedStockDetail["UsedStockIsActive"]==1){
            $ClosingUsedStockAmount+=$ClosingUsedStockDetail["Value"];
        }else{
            continue;
        }

    }

    $ClosingConstructionMaterialAmount =$ClosingStockAmount-$ClosingUsedStockAmount;


//    Closing Construction Material End



//    Material Used During the Period Start

        $MaterialUsedDuringthePeriod=$MaterialAvailableForUsed -$ClosingConstructionMaterialAmount;

//    Material Used During the Period End


//    Construction Labour Expense Start


    $ConstructionLabourExpensesHeadDetails=SQL_Select("expensehead where IncomeExpenseTypeID={$ConstructionLabourExpensesID}");


    $TotalAmountOfConstructionLabourExpenses=0;
    foreach ($ConstructionLabourExpensesHeadDetails as $ConstructionLabourExpensesHeadDetail){
        $ConstructionLabourExpensesTransactionDetails=SQL_Select("transaction where HeadOfAccountID={$ConstructionLabourExpensesHeadDetail["ExpenseHeadID"]} and Date BETWEEN '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}' ");



        foreach ($ConstructionLabourExpensesTransactionDetails as $ConstructionLabourExpensesTransactionDetail){

            if ($ConstructionLabourExpensesHeadDetail["ExpenseHeadIsType"] == 1){

                $TotalAmountOfConstructionLabourExpenses += $ConstructionLabourExpensesTransactionDetail["dr"] - $ConstructionLabourExpensesTransactionDetail["cr"];
            }else{
                $TotalAmountOfConstructionLabourExpenses += $ConstructionLabourExpensesTransactionDetail["cr"] - $ConstructionLabourExpensesTransactionDetail["dr"];

            }

        }

        
    }


//    Construction Labour End


//    Project Approval Expenses Start


    $ProjectApprovalExpenseHeadDetails=SQL_Select("expensehead where IncomeExpenseTypeID={$ProjectApprovalExpenseID}");


    $TotalAmountOfProjectApprovalExpense=0;
    foreach ($ProjectApprovalExpenseHeadDetails as $ProjectApprovalExpenseHeadDetail){
        $ProjectApprovalExpenseTransactionDetails=SQL_Select("transaction where HeadOfAccountID={$ProjectApprovalExpenseHeadDetail["ExpenseHeadID"]} and Date BETWEEN '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}' ");



        foreach ($ProjectApprovalExpenseTransactionDetails as $ProjectApprovalExpenseTransactionDetail){

            if ($ProjectApprovalExpenseHeadDetail["ExpenseHeadIsType"] == 1){

                $TotalAmountOfProjectApprovalExpense += $ProjectApprovalExpenseTransactionDetail["dr"] - $ProjectApprovalExpenseTransactionDetail["cr"];
            }else{
                $TotalAmountOfProjectApprovalExpense += $ProjectApprovalExpenseTransactionDetail["cr"] - $ProjectApprovalExpenseTransactionDetail["dr"];

            }

        }

    }

//    Project Approval Expenses End


//    Other Expense Start


    $OtherExpenseHeadDetails=SQL_Select("expensehead where IncomeExpenseTypeID={$OtherExpenseID}");


    $TotalAmountOfOtherExpense=0;
    foreach ($OtherExpenseHeadDetails as $OtherExpenseHeadDetail){
        $OtherExpenseHeadDetailTransactionDetails=SQL_Select("transaction where HeadOfAccountID={$OtherExpenseHeadDetail["ExpenseHeadID"]} and Date BETWEEN '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}' ");



        foreach ($OtherExpenseHeadDetailTransactionDetails as $OtherExpenseHeadDetailTransactionDetail){

            if ($OtherExpenseHeadDetail["ExpenseHeadIsType"] == 1){

                $TotalAmountOfOtherExpense += $OtherExpenseHeadDetailTransactionDetail["dr"] - $OtherExpenseHeadDetailTransactionDetail["cr"];
            }else{
                $TotalAmountOfOtherExpense += $OtherExpenseHeadDetailTransactionDetail["cr"] - $OtherExpenseHeadDetailTransactionDetail["dr"];

            }

        }


    }

//    Other Expense End



//    Total Cost Transferred to Work in Process Start

        $TotalCostTransferredtoWorkinProcess= $MaterialUsedDuringthePeriod + $TotalAmountOfConstructionLabourExpenses + $TotalAmountOfProjectApprovalExpense + $TotalAmountOfOtherExpense;

//    Total Cost Transferred to Work in Process End
    


}



// Right side

if ( !empty($_POST["FromDate1"]) and !empty($_POST["ToDate1"]) ){
    $FromDate1=$_POST["FromDate1"];
    $ToDate1=$_POST["ToDate1"];


//    Opening Construction Material start

    // Stock Balance

    $StockDetails1=SQL_Select("stock","Date BETWEEN '2016-01-01' AND  '{$_REQUEST["FromDate1"]}' ");
    $stockAmount1=0;
    foreach ($StockDetails1 as $StockDetail1){

        if ($StockDetail1["StockIsActive"]==1){
            $stockAmount1+=$StockDetail1["Value"];
        }else{
            continue;
        }

    }
//    used Stock
    $UsedStockDetails1=SQL_Select("usedstock","Date BETWEEN '2016-01-01' AND  '{$_REQUEST["FromDate1"]}' ");
    $usedStockAmount1=0;
    foreach ($UsedStockDetails1 as $UsedStockDetail1){

        if ($UsedStockDetail1["UsedStockIsActive"]==1){
            $usedStockAmount1+=$UsedStockDetail1["Value"];
        }else{
            continue;
        }

    }

    $OpeningConstructionMaterialAmount1 =$stockAmount1-$usedStockAmount1;

//   Opening Constraction material End



    //    Construction Material Purchase start

    $ConstructionMaterialHeadChildDetails1=SQL_Select("expensehead where IncomeExpenseTypeID={$ConstructionMaterialPurchasesID}");


    $TotalAmountOfConstructionMaterialPurchases1=0;

    foreach ($ConstructionMaterialHeadChildDetails1 as $ConstructionMaterialHeadChildDetail1){
        $ConstructionMaterialChildTransactionDetails1=SQL_Select("transaction where HeadOfAccountID={$ConstructionMaterialHeadChildDetail1["ExpenseHeadID"]} and Date BETWEEN '{$_REQUEST["FromDate1"]}' and '{$_REQUEST["ToDate1"]}' ");

        foreach ($ConstructionMaterialChildTransactionDetails1 as $ConstructionMaterialChildTransactionDetail1){

            if ($ConstructionMaterialHeadChildDetail1["ExpenseHeadIsType"] == 1){

                $TotalAmountOfConstructionMaterialPurchases1 += $ConstructionMaterialChildTransactionDetail1["dr"] - $ConstructionMaterialChildTransactionDetail1["cr"];
            }else{
                $TotalAmountOfConstructionMaterialPurchases1 += $ConstructionMaterialChildTransactionDetail1["cr"] - $ConstructionMaterialChildTransactionDetail1["dr"];

            }

        }

    }

    //    Construction Material Purchase End


//    Material Available For Used Start

    $MaterialAvailableForUsed1 =$OpeningConstructionMaterialAmount1+$TotalAmountOfConstructionMaterialPurchases1;

//    Material Available For Used End



//    Closing Construction Material Start

// Stock Balance

    $ClosingStockDetails1=SQL_Select("stock","Date BETWEEN '2016-01-01' AND  '{$_REQUEST["ToDate1"]}' ");
    $ClosingStockAmount1=0;
    foreach ($ClosingStockDetails1 as $ClosingStockDetail1){

        if ($ClosingStockDetail1["StockIsActive"]==1){
            $ClosingStockAmount1+=$ClosingStockDetail1["Value"];
        }else{
            continue;
        }

    }
//    used Stock
    $ClosingUsedStockDetails1=SQL_Select("usedstock","Date BETWEEN '2016-01-01' AND  '{$_REQUEST["ToDate1"]}' ");
    $ClosingUsedStockAmount1=0;
    foreach ($ClosingUsedStockDetails1 as $ClosingUsedStockDetail1){

        if ($ClosingUsedStockDetail1["UsedStockIsActive"]==1){
            $ClosingUsedStockAmount1+=$ClosingUsedStockDetail1["Value"];
        }else{
            continue;
        }

    }

    $ClosingConstructionMaterialAmount1 =$ClosingStockAmount1-$ClosingUsedStockAmount1;


//    Closing Construction Material End



//    Material Used During the Period Start

    $MaterialUsedDuringthePeriod1=$MaterialAvailableForUsed1 -$ClosingConstructionMaterialAmount1;

//    Material Used During the Period End


//    Construction Labour Expense Start


    $ConstructionLabourExpensesHeadDetails1=SQL_Select("expensehead where IncomeExpenseTypeID={$ConstructionLabourExpensesID}");


    $TotalAmountOfConstructionLabourExpenses1=0;
    foreach ($ConstructionLabourExpensesHeadDetails1 as $ConstructionLabourExpensesHeadDetail1){
        $ConstructionLabourExpensesTransactionDetails1=SQL_Select("transaction where HeadOfAccountID={$ConstructionLabourExpensesHeadDetail1["ExpenseHeadID"]} and Date BETWEEN '{$_REQUEST["FromDate1"]}' and '{$_REQUEST["ToDate1"]}' ");



        foreach ($ConstructionLabourExpensesTransactionDetails1 as $ConstructionLabourExpensesTransactionDetail1){

            if ($ConstructionLabourExpensesHeadDetail1["ExpenseHeadIsType"] == 1){

                $TotalAmountOfConstructionLabourExpenses1 += $ConstructionLabourExpensesTransactionDetail1["dr"] - $ConstructionLabourExpensesTransactionDetail1["cr"];
            }else{
                $TotalAmountOfConstructionLabourExpenses1 += $ConstructionLabourExpensesTransactionDetail1["cr"] - $ConstructionLabourExpensesTransactionDetail1["dr"];

            }

        }


    }


//    Construction Labour End


//    Project Approval Expenses Start


    $ProjectApprovalExpenseHeadDetails1=SQL_Select("expensehead where IncomeExpenseTypeID={$ProjectApprovalExpenseID}");


    $TotalAmountOfProjectApprovalExpense1=0;
    foreach ($ProjectApprovalExpenseHeadDetails1 as $ProjectApprovalExpenseHeadDetail1){
        $ProjectApprovalExpenseTransactionDetails1=SQL_Select("transaction where HeadOfAccountID={$ProjectApprovalExpenseHeadDetail1["ExpenseHeadID"]} and Date BETWEEN '{$_REQUEST["FromDate1"]}' and '{$_REQUEST["ToDate1"]}' ");

        foreach ($ProjectApprovalExpenseTransactionDetails1 as $ProjectApprovalExpenseTransactionDetail1){

            if ($ProjectApprovalExpenseHeadDetail1["ExpenseHeadIsType"] == 1){

                $TotalAmountOfProjectApprovalExpense1 += $ProjectApprovalExpenseTransactionDetail1["dr"] - $ProjectApprovalExpenseTransactionDetail1["cr"];
            }else{
                $TotalAmountOfProjectApprovalExpense1 += $ProjectApprovalExpenseTransactionDetail1["cr"] - $ProjectApprovalExpenseTransactionDetail1["dr"];

            }

        }

    }

//    Project Approval Expenses End


//    Other Expense Start


    $OtherExpenseHeadDetails1=SQL_Select("expensehead where IncomeExpenseTypeID={$OtherExpenseID}");


    $TotalAmountOfOtherExpense1=0;
    foreach ($OtherExpenseHeadDetails1 as $OtherExpenseHeadDetail1){
        $OtherExpenseHeadDetailTransactionDetails1=SQL_Select("transaction where HeadOfAccountID={$OtherExpenseHeadDetail1["ExpenseHeadID"]} and Date BETWEEN '{$_REQUEST["FromDate1"]}' and '{$_REQUEST["ToDate1"]}' ");



        foreach ($OtherExpenseHeadDetailTransactionDetails1 as $OtherExpenseHeadDetailTransactionDetail1){

            if ($OtherExpenseHeadDetail1["ExpenseHeadIsType"] == 1){

                $TotalAmountOfOtherExpense1 += $OtherExpenseHeadDetailTransactionDetail1["dr"] - $OtherExpenseHeadDetailTransactionDetail1["cr"];
            }else{
                $TotalAmountOfOtherExpense1 += $OtherExpenseHeadDetailTransactionDetail1["cr"] - $OtherExpenseHeadDetailTransactionDetail1["dr"];

            }

        }


    }

//    Other Expense End



//    Total Cost Transferred to Work in Process Start

    $TotalCostTransferredtoWorkinProcess1= $MaterialUsedDuringthePeriod1 + $TotalAmountOfConstructionLabourExpenses1 + $TotalAmountOfProjectApprovalExpense1 + $TotalAmountOfOtherExpense1;

//    Total Cost Transferred to Work in Process End


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

    <title>Trial Balance</title>

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
            <img style="width:70px;" src="./upload/' . $Settings["logo"] . '" alt="">
        </div>
        <div  class="col-md-9 text-center">
            <h3 style="font-weight: bold">'.$Settings["CompanyName"].'</h3>
            <p style="font-size: 18px;">'.$Settings["Address"].'</p>

        </div>

    </div>

    <div class="projectName text-center m-b-30 m-t-30">
        <h4 style="font-weight: bold">Cost Of Revenue</h4>
    </div>
    
   <table class="table table-bordered table-hover table-fixed table-sm">
        
          <thead>
                <tr>
                    <th  scope="col" class="text-center"> <h5>Particulars</h5></th>
                    <th  scope="col" class="text-center"> <h5>'.HumanReadAbleDateFormat($FromDate).' To '.HumanReadAbleDateFormat($ToDate).'</h5></th>
                    <th  scope="col" class="text-center"> <h5>'.HumanReadAbleDateFormat($FromDate1).' To '.HumanReadAbleDateFormat($ToDate1).'</h5></th>
                </tr>
                </thead>
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th width="300px" class="text-right" scope="col">Tk</th>
                    <th width="300px"  class="text-right"  scope="col">TK</th>
                </tr>
                </thead>
        
                <tbody>
                    <tr>
                        <td>Opening Construction Material</td>
                        <td class="text-right">'.$OpeningConstructionMaterialAmount.'</td>
                        <td class="text-right">'.$OpeningConstructionMaterialAmount1.'</td>
                        
                    </tr>
                    <tr>
                        <td>Construction Material Purchases</td>
                        <td class="text-right">'.$TotalAmountOfConstructionMaterialPurchases.'</td>
                        <td class="text-right">'.$TotalAmountOfConstructionMaterialPurchases1.'</td>
                        
                    </tr>
                    <tr>
                        <td>Material Available For Used</td>
                        <td class="text-right">'.$MaterialAvailableForUsed.'</td>
                        <td class="text-right">'.$MaterialAvailableForUsed1.'</td>
                        
                    </tr>
                    <tr>
                        <td>Closing Construction Material</td>
                        <td class="text-right">'.$ClosingConstructionMaterialAmount.'</td>
                        <td class="text-right">'.$ClosingConstructionMaterialAmount1.'</td>
                        
                    </tr>
                    <tr style="font-weight: bold">
                        <td>Material Used During the Period</td>
                        <td class="text-right">'.$MaterialUsedDuringthePeriod.'</td>
                        <td class="text-right">'.$MaterialUsedDuringthePeriod1.'</td>
                        
                    </tr>
                    
                    <tr>
                        <td>Construction Labour Expense</td>
                        <td class="text-right">'.$TotalAmountOfConstructionLabourExpenses.'</td>
                        <td class="text-right">'.$TotalAmountOfConstructionLabourExpenses1.'</td>
                        
                    </tr>
                    <tr>
                        <td>Project Approval Expenses</td>
                        <td class="text-right">'.$TotalAmountOfProjectApprovalExpense.'</td>
                        <td class="text-right">'.$TotalAmountOfProjectApprovalExpense1.'</td>
                        
                    </tr>
                    
                    <tr>
                        <td>Other Expense</td>
                        <td class="text-right">'.$TotalAmountOfOtherExpense.'</td>
                        <td class="text-right">'.$TotalAmountOfOtherExpense1.'</td>
                        
                    </tr>
                    
                    <tr style="font-weight: bold">
                        <td>Total Cost Transferred to Work in Process</td>
                        <td class="text-right">'.$TotalCostTransferredtoWorkinProcess.'</td>
                        <td class="text-right">'.$TotalCostTransferredtoWorkinProcess1.'</td>
                        
                    </tr>
                    
                    <tr>
                        <td>Opening Work in Process</td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                        
                    </tr>
                    <tr>
                        <td>Closing Work in Process</td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                        
                    </tr>
                    
                    <tr style="font-weight: bold;">
                        <td>Transfer To Finished Stock</td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                        
                    </tr>
                    <tr>
                        <td>Opening Finished Stock</td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                        
                    </tr>
                    
                    
                    <tr style="font-weight: bold">
                        <td>Transferred Stock Available for Sale</td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                        
                    </tr>
                    <tr>
                        <td>Closing Finished Stock</td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                        
                    </tr>
                    <tr style="font-weight: bold">
                        <td>Cost Of Revenue</td>
                        <td class="text-right">'.$TotalCostTransferredtoWorkinProcess.'</td>
                        <td class="text-right">'.$TotalCostTransferredtoWorkinProcess1.'</td>
                        
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
</html>


';