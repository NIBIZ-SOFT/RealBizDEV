<?php


$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

$FromDate="UpTo";
$ToDate= date("d-m-Y");

if (empty($_POST["FromDate"]) and empty($_POST["ToDate"])) {
//    All Categories no date

    //$Projects = SQL_Select("category");

    $totalDrAmount=0;
    $totalCrAmount=0;

    //foreach ($Projects as $Project) {

        //$transactions = SQL_Select("transaction where ProjectID={$Project["CategoryID"]}");
        $transactions = SQL_Select("transaction");

        $subDrTotal = 0;
        $subCrTotal = 0;

        if (!empty($transactions)) {
            $uniqueHeadOfAccountIds = array();
            foreach ($transactions as $transaction) {
                $uniqueHeadOfAccountIds[$transaction["HeadOfAccountID"]] = $transaction["HeadOfAccountID"];
            }

            $trHtml = "";
            $sl = 1;
            $HeadOfAccountName = "";



            foreach ($uniqueHeadOfAccountIds as $uniqueHeadOfAccountId) {

                if (empty($uniqueHeadOfAccountId)) continue;
                $UniqueTransactionHeadOfAccaunts = SQL_Select("transaction where HeadOfAccountID={$uniqueHeadOfAccountId} ");

                

                $HeadOfAccountID = $UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountID"];
                $HeadOfAccountName = $UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountName"];

                $headOfAccauntsDetails = SQL_Select("expensehead", "ExpenseHeadID='{$HeadOfAccountID}'");

                $HeadType = $headOfAccauntsDetails[0]["ExpenseHeadIsType"];

                $totalTdDrAmountHtml = '<td class="text-right">0</td>';
                $totalTdCrAmountHtml = '<td class="text-right">0</td>';

                if ($HeadType == 1) {
//                Dr Formula
                    $balance = 0;
                    foreach ($UniqueTransactionHeadOfAccaunts as $UniqueTransactionHeadOfAccaunt) {
                        $balance += $UniqueTransactionHeadOfAccaunt["dr"] - $UniqueTransactionHeadOfAccaunt["cr"];
                    }

                    $totalTdDrAmountHtml = '<td class="text-right">' . BangladeshiCurencyFormat($balance) . '</td>';
                    $subDrTotal += $balance;

                } else {
//                Cr Formula
                    $balance = 0;
                    foreach ($UniqueTransactionHeadOfAccaunts as $UniqueTransactionHeadOfAccaunt) {
                        $balance += $UniqueTransactionHeadOfAccaunt["cr"] - $UniqueTransactionHeadOfAccaunt["dr"];
                    }
                    $totalTdCrAmountHtml = '<td class="text-right">' . BangladeshiCurencyFormat($balance ). '</td>';

                    $subCrTotal += $balance;

                }

                $trHtml .= '
                
                    <tr>
                        <th class="text-center" scope="row">' . $sl . '</th>
                        <td>' . $HeadOfAccountName . '</td>
                        ' . $totalTdDrAmountHtml . '
                        ' . $totalTdCrAmountHtml . '
                    </tr>
                
                
                ';



                $sl++;


            }
            
            

            $projectHtml .= '
            
            
            <table class="table table-bordered table-hover table-fixed table-sm">
        

            
            <thead>
            <tr>
                <th width="20px" class="text-center"  scope="col">Serial No.</th>
                <th  scope="col" class="text-center"> <h5>Head Of Account</h5></th>
                <th  colspan="2" scope="col" class="text-center"> <h5>'.$FromDate.' to '.$ToDate.'</h5></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th width="200px" class="text-right" scope="col">Dr. Tk</th>
                <th width="200px"  class="text-right"  scope="col">Cr.TK</th>
            </tr>
            </thead>
    
    
            <tbody>
            
            
            ' . $trHtml . '
            
            
            </tbody>
            
            
            
            <thead>
            <tr>
                <th style="height: 40px" scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th class="text-right" scope="col" colspan="2">Sub Total =</th>
                <th scope="col" class="text-right">'.BangladeshiCurencyFormat($subDrTotal).'</th>
                <th scope="col" class="text-right">'.BangladeshiCurencyFormat($subCrTotal).'</th>
            </tr>
            </thead>
        </table>
            
            ';


            $totalDrAmount +=$subDrTotal;
            $totalCrAmount +=$subCrTotal;




        } else {

            continue;
        }

   // }

//    Bank & Cash

    $BankCashes=SQL_Select("bankcash");
    $bankCashName="";
    $sl=1;
    $totalBankCashBalance=0;
    foreach ($BankCashes as $BankCash){

        $TransactionInfos=SQL_Select("transaction where BankCashID={$BankCash["BankCashID"]}");
        $drAmount=0;
        $crAmount=0;

        $bankCashName=$BankCash["AccountTitle"];

        foreach ($TransactionInfos as $TransactionInfo){

            if ($TransactionInfo["dr"] > 0 ){

                $drAmount +=$TransactionInfo["dr"];
            }else{
                $crAmount +=$TransactionInfo["cr"];

            }

        }

        $balance= $crAmount - $drAmount;
        $totalBankCashBalance +=$balance;

        $bankCashHtml.='
            <tr>
                <th class="text-center" scope="row">'.$sl.'</th>
                <td  >'.$bankCashName.'</td>
                <td class="text-right">'.BangladeshiCurencyFormat($balance).'</td>
                <td class="text-right">0</td>
                
            </tr>';
        $sl++;

    }

    $grandTotalDr=$totalBankCashBalance+$totalDrAmount;
    $grandTotalCr=$totalCrAmount;



} elseif (!empty($_POST["CategoryID"]) and empty($_POST["FromDate"]) and empty($_POST["ToDate"])) {
//    One Categories No dates


        $totalDrAmount=0;
        $totalCrAmount=0;


        $transactions = SQL_Select("transaction");

        $subDrTotal = 0;
        $subCrTotal = 0;

        if (!empty($transactions)) {
            $uniqueHeadOfAccountIds = array();
            foreach ($transactions as $transaction) {
                $uniqueHeadOfAccountIds[$transaction["HeadOfAccountID"]] = $transaction["HeadOfAccountID"];
            }

            $trHtml = "";
            $sl = 1;
            $HeadOfAccountName = "";

            foreach ($uniqueHeadOfAccountIds as $uniqueHeadOfAccountId) {

                if (empty($uniqueHeadOfAccountId)) continue;
                $UniqueTransactionHeadOfAccaunts = SQL_Select("transaction where HeadOfAccountID={$uniqueHeadOfAccountId}");

                $ProjectName=$UniqueTransactionHeadOfAccaunts[0]["ProjectName"];

                $HeadOfAccountID = $UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountID"];
                $HeadOfAccountName = $UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountName"];

                $headOfAccauntsDetails = SQL_Select("expensehead", "ExpenseHeadID='{$HeadOfAccountID}'");

                $HeadType = $headOfAccauntsDetails[0]["ExpenseHeadIsType"];

                $totalTdDrAmountHtml = '<td class="text-right">0</td>';
                $totalTdCrAmountHtml = '<td class="text-right">0</td>';

                if ($HeadType == 1) {
//                Dr Formula
                    $balance = 0;
                    foreach ($UniqueTransactionHeadOfAccaunts as $UniqueTransactionHeadOfAccaunt) {
                        $balance += $UniqueTransactionHeadOfAccaunt["dr"] - $UniqueTransactionHeadOfAccaunt["cr"];
                    }

                    $totalTdDrAmountHtml = '<td class="text-right">' . BangladeshiCurencyFormat($balance) . '</td>';
                    $subDrTotal += $balance;

                } else {
//                Cr Formula
                    $balance = 0;
                    foreach ($UniqueTransactionHeadOfAccaunts as $UniqueTransactionHeadOfAccaunt) {
                        $balance += $UniqueTransactionHeadOfAccaunt["cr"] - $UniqueTransactionHeadOfAccaunt["dr"];
                    }
                    $totalTdCrAmountHtml = '<td class="text-right">' . BangladeshiCurencyFormat($balance ). '</td>';

                    $subCrTotal += $balance;

                }

                $trHtml .= '
                
                    <tr>
                        <th class="text-center" scope="row">' . $sl . '</th>
                        <td>' . $HeadOfAccountName . '</td>
                        ' . $totalTdDrAmountHtml . '
                        ' . $totalTdCrAmountHtml . '
                    </tr>
                
                
                ';



                $sl++;


            }



            $projectHtml .= '
            
            
            <table class="table table-bordered table-hover table-fixed table-sm">
        

            
            <thead>
            <tr>
                <th width="20px" class="text-center"  scope="col">Serial No.</th>
                <th  scope="col" class="text-center"> <h5>Head Of Account</h5></th>
                <th  colspan="2" scope="col" class="text-center"> <h5> '.$FromDate.' to '.$ToDate.'</h5></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th width="200px" class="text-right" scope="col">Dr. Tk</th>
                <th width="200px"  class="text-right"  scope="col">Cr.TK</th>
            </tr>
            </thead>
    
    
            <tbody>
            
            
            ' . $trHtml . '
            
            
            </tbody>
            
            
            
            <thead>
            <tr>
                <th style="height: 40px" scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th class="text-right" scope="col" colspan="2">Sub Total =</th>
                <th scope="col" class="text-right">'.BangladeshiCurencyFormat($subDrTotal).'</th>
                <th scope="col" class="text-right">'.BangladeshiCurencyFormat($subCrTotal).'</th>
            </tr>
            </thead>
        </table>
            
            ';


            $totalDrAmount +=$subDrTotal;
            $totalCrAmount +=$subCrTotal;



        } else {



        }




//    Bank & Cash

    $BankCashes=SQL_Select("bankcash");
    $bankCashName="";
    $sl=1;
    $totalBankCashBalance=0;
    foreach ($BankCashes as $BankCash){

        $TransactionInfos=SQL_Select("transaction where BankCashID={$BankCash["BankCashID"]} ");
        $drAmount=0;
        $crAmount=0;

        $bankCashName=$BankCash["AccountTitle"];

        foreach ($TransactionInfos as $TransactionInfo){

            if ($TransactionInfo["dr"] > 0 ){

                $drAmount +=$TransactionInfo["dr"];
            }else{
                $crAmount +=$TransactionInfo["cr"];

            }

        }

        $balance= $crAmount - $drAmount;
        $totalBankCashBalance +=$balance;

        $bankCashHtml.='
            <tr>
                <th class="text-center" scope="row">'.$sl.'</th>
                <td  >'.$bankCashName.'</td>
                <td class="text-right">'.BangladeshiCurencyFormat($balance).'</td>
                <td class="text-right">0</td>
                
            </tr>';
        $sl++;

    }

    $grandTotalDr=$totalBankCashBalance+$totalDrAmount;
    $grandTotalCr=$totalCrAmount;




} elseif ( !empty($_POST["FromDate"]) and !empty($_POST["ToDate"])) {
//    Date ways Categories

    $FromDate=$_POST["FromDate"];
    $ToDate=$_POST["ToDate"];

    $totalDrAmount=0;
    $totalCrAmount=0;


    $transactions = SQL_Select("transaction where  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}'  ");

    $subDrTotal = 0;
    $subCrTotal = 0;

    if (!empty($transactions)) {
        $uniqueHeadOfAccountIds = array();
        foreach ($transactions as $transaction) {
            $uniqueHeadOfAccountIds[$transaction["HeadOfAccountID"]] = $transaction["HeadOfAccountID"];
        }

        $trHtml = "";
        $sl = 1;
        $HeadOfAccountName = "";

        foreach ($uniqueHeadOfAccountIds as $uniqueHeadOfAccountId) {

            if (empty($uniqueHeadOfAccountId)) continue;
            $UniqueTransactionHeadOfAccaunts = SQL_Select("transaction where HeadOfAccountID={$uniqueHeadOfAccountId} and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}'  ");

            $ProjectName=$UniqueTransactionHeadOfAccaunts[0]["ProjectName"];

            $HeadOfAccountID = $UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountID"];
            $HeadOfAccountName = $UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountName"];

            $headOfAccauntsDetails = SQL_Select("expensehead", "ExpenseHeadID='{$HeadOfAccountID}'");

            $HeadType = $headOfAccauntsDetails[0]["ExpenseHeadIsType"];

            $totalTdDrAmountHtml = '<td class="text-right">0</td>';
            $totalTdCrAmountHtml = '<td class="text-right">0</td>';

            if ($HeadType == 1) {
//                Dr Formula
                $balance = 0;
                foreach ($UniqueTransactionHeadOfAccaunts as $UniqueTransactionHeadOfAccaunt) {
                    $balance += $UniqueTransactionHeadOfAccaunt["dr"] - $UniqueTransactionHeadOfAccaunt["cr"];
                }

                $totalTdDrAmountHtml = '<td class="text-right">' . BangladeshiCurencyFormat($balance) . '</td>';
                $subDrTotal += $balance;

            } else {
//                Cr Formula
                $balance = 0;
                foreach ($UniqueTransactionHeadOfAccaunts as $UniqueTransactionHeadOfAccaunt) {
                    $balance += $UniqueTransactionHeadOfAccaunt["cr"] - $UniqueTransactionHeadOfAccaunt["dr"];
                }
                $totalTdCrAmountHtml = '<td class="text-right">' . BangladeshiCurencyFormat($balance ). '</td>';

                $subCrTotal += $balance;

            }

            $trHtml .= '
                
                    <tr>
                        <th class="text-center" scope="row">' . $sl . '</th>
                        <td>' . $HeadOfAccountName . '</td>
                        ' . $totalTdDrAmountHtml . '
                        ' . $totalTdCrAmountHtml . '
                    </tr>
                
                
                ';



            $sl++;


        }



        $projectHtml .= '
            
            
            <table class="table table-bordered table-hover table-fixed table-sm">
        

            
            <thead>
            <tr>
                <th width="20px" class="text-center"  scope="col">Serial No.</th>
                <th  scope="col" class="text-center"> <h5>Head Of Account</h5></th>
                <th  colspan="2" scope="col" class="text-center"> <h5>'.$FromDate.' to '.$ToDate.'</h5></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th width="200px" class="text-right" scope="col">Dr. Tk</th>
                <th width="200px"  class="text-right"  scope="col">Cr.TK</th>
            </tr>
            </thead>
    
    
            <tbody>
            
            
            ' . $trHtml . '
            
            
            </tbody>
            
            
            
            <thead>
            <tr>
                <th style="height: 40px" scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th class="text-right" scope="col" colspan="2">Sub Total =</th>
                <th scope="col" class="text-right">'.BangladeshiCurencyFormat($subDrTotal).'</th>
                <th scope="col" class="text-right">'.BangladeshiCurencyFormat($subCrTotal).'</th>
            </tr>
            </thead>
        </table>
            
            ';


        $totalDrAmount +=$subDrTotal;
        $totalCrAmount +=$subCrTotal;



    } else {



    }




//    Bank & Cash

    $BankCashes=SQL_Select("bankcash");
    $bankCashName="";
    $sl=1;
    $totalBankCashBalance=0;
    foreach ($BankCashes as $BankCash){

        $TransactionInfos=SQL_Select("transaction where BankCashID={$BankCash["BankCashID"]} and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}'  ");
        $drAmount=0;
        $crAmount=0;

        $bankCashName=$BankCash["AccountTitle"];

        foreach ($TransactionInfos as $TransactionInfo){

            if ($TransactionInfo["dr"] > 0 ){

                $drAmount +=$TransactionInfo["dr"];
            }else{
                $crAmount +=$TransactionInfo["cr"];

            }

        }

        $balance= $crAmount - $drAmount;
        $totalBankCashBalance +=$balance;

        $bankCashHtml.='
            <tr>
                <th class="text-center" scope="row">'.$sl.'</th>
                <td  >'.$bankCashName.'</td>
                <td class="text-right">'.BangladeshiCurencyFormat($balance).'</td>
                <td class="text-right">0</td>
                
            </tr>';
        $sl++;

    }

    $grandTotalDr=$totalBankCashBalance+$totalDrAmount;
    $grandTotalCr=$totalCrAmount;





} elseif (empty($_POST["CategoryID"]) and !empty($_POST["FromDate"]) and !empty($_POST["ToDate"])) {
//    All Project Date ways

    $FromDate=$_POST["FromDate"];
    $ToDate=$_POST["ToDate"];


    $Projects = SQL_Select("category");

    $totalDrAmount=0;
    $totalCrAmount=0;

    foreach ($Projects as $Project) {

        $transactions = SQL_Select("transaction where  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}' ");


        
        $subDrTotal = 0;
        $subCrTotal = 0;

        if (!empty($transactions)) {
            $uniqueHeadOfAccountIds = array();
            foreach ($transactions as $transaction) {


                $uniqueHeadOfAccountIds[$transaction["HeadOfAccountID"]] = $transaction["HeadOfAccountID"];
            }

            
            $trHtml = "";
            $sl = 1;
            $HeadOfAccountName = "";

            

            foreach ($uniqueHeadOfAccountIds as $uniqueHeadOfAccountId) {

                if (empty($uniqueHeadOfAccountId)) continue;
                $UniqueTransactionHeadOfAccaunts = SQL_Select("transaction where HeadOfAccountID={$uniqueHeadOfAccountId}  and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}'  ");

                
                $HeadOfAccountID = $UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountID"];
                $HeadOfAccountName = $UniqueTransactionHeadOfAccaunts[0]["HeadOfAccountName"];

                $headOfAccauntsDetails = SQL_Select("expensehead", "ExpenseHeadID='{$HeadOfAccountID}'");

                $HeadType = $headOfAccauntsDetails[0]["ExpenseHeadIsType"];

                $totalTdDrAmountHtml = '<td class="text-right">0</td>';
                $totalTdCrAmountHtml = '<td class="text-right">0</td>';

                if ($HeadType == 1) {
//                Dr Formula
                    $balance = 0;
                    foreach ($UniqueTransactionHeadOfAccaunts as $UniqueTransactionHeadOfAccaunt) {
                        $balance += $UniqueTransactionHeadOfAccaunt["dr"] - $UniqueTransactionHeadOfAccaunt["cr"];
                    }

                    $totalTdDrAmountHtml = '<td class="text-right">' . BangladeshiCurencyFormat($balance) . '</td>';
                    $subDrTotal += $balance;

                } else {
//                Cr Formula
                    $balance = 0;
                    foreach ($UniqueTransactionHeadOfAccaunts as $UniqueTransactionHeadOfAccaunt) {
                        $balance += $UniqueTransactionHeadOfAccaunt["cr"] - $UniqueTransactionHeadOfAccaunt["dr"];
                    }
                    $totalTdCrAmountHtml = '<td class="text-right">' . BangladeshiCurencyFormat($balance ). '</td>';

                    $subCrTotal += $balance;

                }

                $trHtml .= '
                
                    <tr>
                        <th class="text-center" scope="row">' . $sl . '</th>
                        <td>' . $HeadOfAccountName . '</td>
                        ' . $totalTdDrAmountHtml . '
                        ' . $totalTdCrAmountHtml . '
                    </tr>
                
                
                ';

                $sl++;


            }

            $projectHtml .= '
            
            
            <table class="table table-bordered table-hover table-fixed table-sm">
        
            <thead>
            <tr>
                <th class="text-center" scope="col" colspan="4">' . $Project["Name"] . '</th>
            </tr>
            </thead>
            
            <thead>
            <tr>
                <th width="20px" class="text-center"  scope="col">Serial No.</th>
                <th  scope="col" class="text-center"> <h5>Head Of Account</h5></th>
                <th  colspan="2" scope="col" class="text-center"> <h5>'.$FromDate.' to '.$ToDate.'</h5></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th width="200px" class="text-right" scope="col">Dr. Tk</th>
                <th width="200px"  class="text-right"  scope="col">Cr.TK</th>
            </tr>
            </thead>
    
    
            <tbody>
            
            
            ' . $trHtml . '
            
            
            </tbody>
            
            
            
            <thead>
            <tr>
                <th style="height: 40px" scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th class="text-right" scope="col" colspan="2">Sub Total =</th>
                <th scope="col" class="text-right">'.BangladeshiCurencyFormat($subDrTotal).'</th>
                <th scope="col" class="text-right">'.BangladeshiCurencyFormat($subCrTotal).'</th>
            </tr>
            </thead>
        </table>
            
            ';


            $totalDrAmount +=$subDrTotal;
            $totalCrAmount +=$subCrTotal;


        } else {

            continue;
        }

    }

//    Bank & Cash

    $BankCashes=SQL_Select("bankcash");
    $bankCashName="";
    $sl=1;
    $totalBankCashBalance=0;
    foreach ($BankCashes as $BankCash){

        $TransactionInfos=SQL_Select("transaction where BankCashID={$BankCash["BankCashID"]} and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}'  ");
        $drAmount=0;
        $crAmount=0;

        $bankCashName=$BankCash["AccountTitle"];

        foreach ($TransactionInfos as $TransactionInfo){

            if ($TransactionInfo["dr"] > 0 ){

                $drAmount +=$TransactionInfo["dr"];
            }else{
                $crAmount +=$TransactionInfo["cr"];

            }

        }

        $balance= $crAmount - $drAmount;
        $totalBankCashBalance +=$balance;

        $bankCashHtml.='
            <tr>
                <th class="text-center" scope="row">'.$sl.'</th>
                <td  >'.$bankCashName.'</td>
                <td class="text-right">'.BangladeshiCurencyFormat($balance).'</td>
                <td class="text-right">0</td>
                
            </tr>';
        $sl++;

    }

    $grandTotalDr=$totalBankCashBalance+$totalDrAmount;
    $grandTotalCr=$totalCrAmount;

    $FromDate= $_REQUEST["FromDate"];
    $ToDate=$_REQUEST["ToDate"];



} else {


    header("location:index.php?Theme=default&Base=Transaction&Script=TrialBalanceManage");

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

    <div style="padding: 10px 0px" class="company-name row">
        <div  class="col-md-2 text-center">
           <img style="width: 70px;" src="./upload/' . $Settings["logo"] . '" alt="">
        </div>
        <div  class="col-md-9 text-center">
            <h3 style="font-weight: bold">'.$Settings["CompanyName"].'</h3>
            <p style="font-size: 18px;">'.$Settings["Address"].'</p>

        </div>

    </div>

    <div class="projectName text-center m-b-30 m-t-30">
        <h4 style="font-weight: bold">Trial Balance</h4>
    </div>
    
    ' . $projectHtml . '
    
    <table class="table table-bordered table-hover table-fixed table-sm">
    <thead>
    <tr>
        <th class="text-right" scope="col">Total Amount=</th>
        <th  width="200px"  class="text-right" scope="col">'.BangladeshiCurencyFormat($totalDrAmount).'</th>
        <th  width="200px"  class="text-right" scope="col">'.BangladeshiCurencyFormat($totalCrAmount).'</th>
    </tr>
    
    </thead>
    
    </table>
    
    
    
   <!----  BankCash --->
    
    <table class="table table-bordered table-hover table-fixed table-sm">
        
            
            <thead>
            <tr>
                <th width="20px" class="text-center"  scope="col">Serial No.</th>
                <th  scope="col" class="text-center"> <h5>Closing Bank & Cash Balance</h5></th> 
    
 
                <th  colspan="2" scope="col" class="text-center"> <h5> '.$FromDate.' To '.$ToDate.'</h5></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col"></th>
                <th width="200px" class="text-right" scope="col">Dr. Tk</th>
                <th width="200px"  class="text-right"  scope="col">Cr.TK</th>
            </tr>
            </thead>
    
    
            <tbody>
            
                '.$bankCashHtml.'
            
            </tbody>
            
            
            
            <thead>
            <tr>
                <th style="height: 40px" scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <thead>
            <tr>
                <th class="text-right" scope="col" colspan="2">Sub Total =</th>
                <th scope="col" class="text-right">'.BangladeshiCurencyFormat($totalBankCashBalance).'</th>
                <th scope="col" class="text-right">0</th>
                
            </tr>
            </thead>
            
            <thead>
                <tr>
                    <th class="text-right" colspan="2" scope="col">Grand Total Amount=</th>
                    <th  width="200px"  class="text-right" scope="col">'.BangladeshiCurencyFormat($grandTotalDr).'</th>
                    <th  width="200px"  class="text-right" scope="col">'.BangladeshiCurencyFormat($grandTotalCr).'</th>
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


?>

