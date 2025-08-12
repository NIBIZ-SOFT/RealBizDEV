<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 4/9/2019
 * Time: 4:33 PM
 */

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

if (!empty($_POST["CategoryID"]) && !empty($_POST["FromDate"]) && !empty($_POST["ToDate"]) && empty($_POST["HeadOfAccountID"]) && empty($_POST["IncomeExpenseTypeID"]) ) {
    $JournalDetails = SQL_Select("Transaction", "ProjectID='{$_REQUEST["CategoryID"]}' and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}' order by TransactionID ASC");

}elseif (!empty($_POST["CategoryID"]) && empty($_POST["HeadOfAccountID"]) ) {
    $JournalDetails = SQL_Select("Transaction", "ProjectID='{$_REQUEST["CategoryID"]}'  order by TransactionID ASC");

}elseif (!empty($_POST["CategoryID"]) && !empty($_POST["HeadOfAccountID"]) &&  !empty($_POST["FromDate"]) && !empty($_POST["ToDate"])  ){

    $JournalDetails = SQL_Select("Transaction", "ProjectID='{$_REQUEST["CategoryID"]}' and HeadOfAccountID='{$_REQUEST["HeadOfAccountID"]}' and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}'  order by TransactionID ASC");


}elseif (!empty($_POST["CategoryID"]) && !empty($_POST["HeadOfAccountID"])  ){
    $JournalDetails = SQL_Select("Transaction", "ProjectID='{$_REQUEST["CategoryID"]}' and HeadOfAccountID='{$_REQUEST["HeadOfAccountID"]}' order by TransactionID ASC");

} else {


    header("location:index.php?Theme=default&Base=Transaction&Script=LedgerManage");
}


//$ProjectName = $JournalDetails[0]["ProjectName"];
$ProjectName = GetCategoryName($JournalDetails[0]["ProjectID"]);


if (count($JournalDetails) > 0) {

    $uniqHeadOfAccountIds = array();
    foreach ($JournalDetails as $JournalDetail) {
        $uniqHeadOfAccountIds[$JournalDetail["HeadOfAccountID"]] = $JournalDetail["HeadOfAccountID"];
    }

    $headOfAccountArea = "";

    foreach ($uniqHeadOfAccountIds as $uniqHeadOfAccountId) {

        if (empty($uniqHeadOfAccountId)) continue;

        $HeadDetails = SQL_Select("Transaction", "ProjectID='{$_REQUEST["CategoryID"]}' and HeadOfAccountID= '{$uniqHeadOfAccountId}' order by Date");



        if(!empty($_POST["CategoryID"]) && !empty($_POST["FromDate"]) && !empty($_POST["ToDate"]) && empty($_POST["ExpenseHead"]) ){
            $HeadDetails = SQL_Select("Transaction", "ProjectID='{$_REQUEST["CategoryID"]}' and HeadOfAccountID= '{$uniqHeadOfAccountId}' and Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}' ");

        }

        $headDetails = "";
        $sl = 1;
        $headName = "";
        $creditAmount = 0;
        $debitAmount = 0;
        $balance = 0;


        foreach ($HeadDetails as $HeadDetail) {

            $headName = $HeadDetail["HeadOfAccountName"];
            $HeadOfAccountID = $HeadDetail["HeadOfAccountID"];

            $HeadInformations = SQL_Select("expensehead", "ExpenseHeadID='{$HeadOfAccountID}'");

            $HeadType = $HeadInformations[0]["ExpenseHeadIsType"];

            if ($HeadType == 1) {
//                Dr Formula
                $balance += $HeadDetail["dr"] - $HeadDetail["cr"];

            } else {
//                Cr Formula
                $balance += $HeadDetail["cr"] - $HeadDetail["dr"];

            }


            //$GetCustRecord = SQL_Select("crvoucher","BillNo = '{$HeadDetail["BillNo"]}'","",true);

            //print_r($GetCustRecord);


            $GetCustRecordDR["VendorName"]="";
            if($HeadDetail["VoucherType"]=="CV")
                $GetCustRecord = SQL_Select("crvoucher","CrVoucherID = '{$HeadDetail["VoucherNo"]}'","",true);
            if($HeadDetail["VoucherType"]=="DV"){
                $GetCustRecordDR = SQL_Select("drvoucher","VoucherNo = {$HeadDetail["VoucherNo"]}","",true);

                if($HeadDetail["VendorID"]==0 and $HeadDetail["ContructorID"]==0)
                    $GetCustRecordDR["VendorName"] = "Operational Cost";
            }


            $headDetails .= '

                <tr>
                    <th scope="row">' . $sl . '</th>
                    <td>' . HumanReadAbleDateFormat($HeadDetail["Date"]) . '</td>
                    
                    <td>
                        ' . $HeadDetail["Description"] . '
                    </td>
                    <td>' . $HeadDetail["BankCashName"] . '</td>
                    
                    <td>' . $HeadDetail["ChequeNumber"] . '</td>
                    <td>' . $HeadDetail["VoucherNo"] . '</td>
                    <td>' . $HeadDetail["VoucherType"] . '</td>
                    <td class="text-right">' . BangladeshiCurencyFormat($HeadDetail["dr"]) . '</td>
                    <td class="text-right">' . BangladeshiCurencyFormat($HeadDetail["cr"]) . '</td>
                    <td class="text-right">' . BangladeshiCurencyFormat($balance) . '</td>
                   
                </tr>
                

            ';

            $sl++;

        }


        $headOfAccountArea .= '
        <div class="headOfAccountArea m-b-30">
            <div class="text-center">
                <h5>' . $headName . '</h5>
            </div>
            <table class="table table-hover table-sm table-bordered">
                <thead>
                <tr>
                    <th scope="col">S.L No</th>
                    <th scope="col">Date</th>
                    <th scope="col">Name & Particulars</th>
                    <th scope="col">Mode of Payment</th>
                    <th scope="col">Cheque Number</th>
                    <th scope="col">Voucher No</th>
                    <th scope="col">Type Of Voucher</th>
                    <th  class="text-right" scope="col">Dr.</th>
                    <th  class="text-right" scope="col">Cr.</th>
                    <th  class="text-right" scope="col">Balance</th>
                    
                </tr>
                </thead>
                <tbody>
                
                
                ' . $headDetails . '
                
                <tr>
                    <th colspan="8" class="text-right">Balance =</th>
    
                    <td colspan="2" style="font-weight: bold">' . BangladeshiCurencyFormat($balance) . '</td>
                </tr>
    
                </tbody>
    
            </table>
        </div>';



    }


} else {

    $emptyTh = '
    <tr>
        <th colspan="9" class="text-center text-danger" >There Has No Data On This Project</th>
        
    </tr>
    
    
    ';

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

    <title>Ledger of: </title>

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

    </style>
</head>
<body>

<div style="width: 95%; margin: auto">
    <p style="font-size: 16px">Printing Date & Time: '.date('F j-y, h:i:sa').'</p>
</div>

<div style="width: 95%; margin: auto">

    <div style="padding: 10px 0px; border-bottom: 1px solid #DEE2E6;" class="company-name row">
        <div  class="col-md-2 text-center">
            <img height="70px" src="./upload/' . $Settings["logo"] . '" alt="">
        </div>
        <div  class="col-md-9 text-center">
            <h4 style="font-weight: bold">'.$Settings["CompanyName"].'</h4>
            <p style="font-size: 18px;">'.$Settings["Address"].'</p>

        </div>

    </div>

    <div class="projectName text-center m-b-30 m-t-30">
        <h4>' . $ProjectName . '</h4>
    </div>
    ' . $headOfAccountArea . '
    

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

