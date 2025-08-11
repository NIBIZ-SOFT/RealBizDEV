<?php
$_POST["HeadOfAccountID"] = $_POST["HeadOfAccount_ID"];
$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

$Transactions = SQL_Select("Transaction","1=1 order by Date ASC");

$uniqHeadProjectIDS = array();
foreach ($Transactions as $Transaction) {
    $uniqHeadProjectIDS[$Transaction["ProjectID"]] = $Transaction["ProjectID"];
}

foreach ($uniqHeadProjectIDS as $uniqHeadProjectID){

    if (!empty($_POST["FromDate"]) && !empty($_POST["ToDate"]) && !empty($_POST["HeadOfAccountID"])) {

        $JournalDetails = SQL_Select("Transaction", "ProjectID='{$uniqHeadProjectID}' and  HeadOfAccountID='{$_REQUEST["HeadOfAccountID"]}' and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}' order by Date ASC");

    } elseif (!empty($_POST["FromDate"]) && !empty($_POST["ToDate"]) && empty($_POST["HeadOfAccountID"])) {

        $JournalDetails = SQL_Select("Transaction", "ProjectID='{$uniqHeadProjectID}' and Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}' order by Date ASC");

    } elseif (!empty($_POST["HeadOfAccountID"])) {

        $JournalDetails = SQL_Select("Transaction", "ProjectID='{$uniqHeadProjectID}' and HeadOfAccountID='{$_POST["HeadOfAccountID"]}' order by Date ASC");


    } else {
        $JournalDetails = SQL_Select("Transaction","ProjectID='{$uniqHeadProjectID}'  order by Date ASC");
    }

    if (empty($JournalDetails[0]["ProjectName"])) continue;

    $headDetails="";
    $sl=1;
    $dr=0;
    $cr=0;
    
    //print_r($JournalDetails);
    foreach ($JournalDetails as $JournalDetail){

        $dr+=$JournalDetail["dr"];
        $cr+=$JournalDetail["cr"];

        $GetCustRecordDR["VendorName"]="";
        if($JournalDetail["VoucherType"]=="CV")
            $GetCustRecord = SQL_Select("crvoucher","CrVoucherID = '{$JournalDetail["VoucherNo"]}'","",true);
        if($JournalDetail["VoucherType"]=="DV"){
            $GetCustRecordDR = SQL_Select("drvoucher","VoucherNo = {$JournalDetail["VoucherNo"]}","",true);

            if($JournalDetail["VendorID"]==0 and $JournalDetail["ContructorID"]==0)
                $GetCustRecordDR["VendorName"] = "Operational Cost";
        }
            

        $headDetails .= '

                <tr>
                    <th class="text-center" scope="row">' . $sl . '</th>
                    <td>' . HumanReadAbleDateFormat($JournalDetail["Date"]) . '</td>
                    <td>
                        <b>' . $GetCustRecord["CustomerName"] . '' . $GetCustRecordDR["VendorName"] . '' . $GetCustRecordDR["ContructorName"] . '<br>
                        ' . GetCustomerPhone($GetCustRecord["CustomerID"]) . '</b>
                        <hr>
                        
                        ' . $JournalDetail["Description"] . '
                                            
                    </td>
                    <td>' . $JournalDetail["HeadOfAccountName"] . '</td>
                    <td class="text-center">' . $JournalDetail["BankCashName"] . '</td>
                    <td class="text-center">' . $JournalDetail["VoucherNo"] . '</td>
                    <td class="text-center">' . $JournalDetail["VoucherType"] . '</td>
                    <td class="text-right">' . BangladeshiCurencyFormat($JournalDetail["dr"]) . '</td>
                    <td class="text-right">' . BangladeshiCurencyFormat($JournalDetail["cr"]) . '</td>
                    
                   
                </tr>
                

            ';

        $sl++;


    }

    $headOfAccountArea .= '
        <div class="headOfAccountArea m-b-30">
            <div class="text-center">
                <h5>' . $JournalDetails[0]["ProjectName"] . '</h5>
            </div>
            <table class="table table-hover table-sm table-bordered">
                <thead>
                <tr>
                    <th scope="col">S.L No</th>
                    <th scope="col">Date</th>
                    <th scope="col">Name & Particulars</th>
                    <th scope="col">Head Of Account</th>
                    <th scope="col">Mode of Payment</th>
                    <th class="text-center" scope="col">Voucher No</th>
                    <th class="text-center" scope="col">Type Of Voucher</th>
                    <th class="text-right" scope="col">Dr.</th>
                    <th class="text-right" scope="col">Cr.</th>
                    
                    
                </tr>
                </thead>
                <tbody>
                
                
                ' . $headDetails . '
                
                <tr>
                    <th colspan="7" class="text-right">Total =</th>
    
                    <td class="text-right" style="font-weight: bold">' . BangladeshiCurencyFormat($dr). '</td>
                    <td class="text-right" style="font-weight: bold">' . BangladeshiCurencyFormat($cr). '</td>
                </tr>
    
                </tbody>
    
            </table>
        </div>';


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
        <h4></h4>
    </div>
    
        '.$headOfAccountArea.'
    
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