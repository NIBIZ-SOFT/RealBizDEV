<?php

//echo GetCustomerBalance("663");

//n_bulk_sms($mobile_no="01969101010",$message="Hello This is Test");
if($_REQUEST["CustomerID"]=="") {
    echo '
        <script>
            alert( "Please select a customer first!" );
            history.go(-1);
        </script>
    ';
    exit;
}

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);
//echo $_REQUEST["CustomerID"];
$CrVoucher = SQL_Select("CrVoucher","CustomerID={$_REQUEST["CustomerID"]}  and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}' ORDER BY Date DESC");
//$CrVoucher = SQL_Select("Transaction","CustomerID={$_REQUEST["CustomerID"]}  and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}' ORDER BY Date DESC");

$sl=1;

foreach ($CrVoucher as $ThisCrVoucher){


    $headDetails .= '

                <tr>
                    <th class="text-center" scope="row">' . $sl . '</th>
                    <td>' . HumanReadAbleDateFormat($ThisCrVoucher["Date"]) . '</td>
                    <td>
                        ' . $ThisCrVoucher["ProjectName"] . '
                                            
                    </td>
                    <td>' . $ThisCrVoucher["HeadOfAccountName"] . '</td>
                    <td>' . $ThisCrVoucher["BankCashName"] . '</td>
                    <td class="text-center">' . $ThisCrVoucher["BillNo"] . '</td>
                    <td class="text-right">' . BangladeshiCurencyFormat($ThisCrVoucher["Amount"]) . '</td>

                </tr>
                

            ';

    $TAmountCr = $ThisCrVoucher["Amount"] +     $TAmountCr;

    $sl++;


}

$headOfAccountArea .= '
        <div class="headOfAccountArea m-b-30">
            <div class="text-center">
                <h5>' . GetCustomerName($_REQUEST["CustomerID"]) . '  </h5>
            </div>
            <table class="table table-hover table-sm table-bordered">
                <thead>
                <tr>
                    <th scope="col">S.L No</th>
                    <th scope="col">Date</th>
                    <th scope="col">Project Name</th>
                    <th scope="col">Head Of Account</th>
                    <th scope="col">Mode of Payment</th>
                    <th class="text-center" scope="col">Bil No</th>
                    <th class="text-right" scope="col">Amount(Cr.)</th>
                    
                    
                </tr>
                </thead>
                <tbody>
                
                
                ' . $headDetails . '
                
                <tr>
                    <th colspan="6" class="text-right">Total =</th>
    
                    <td class="text-right" style="font-weight: bold">' . BangladeshiCurencyFormat($TAmountCr). '</td>
                </tr>
    

    
                </tbody>
    
            </table>
        </div>
        
    ';



/////   Debit hisab   ///////


$DrVoucher = SQL_Select("Transaction","CustomerID={$_REQUEST["CustomerID"]}  and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}' ORDER BY Date DESC");

$sl=1;

foreach ($DrVoucher as $ThisDrVoucher){


    $headDetails1 .= '

                <tr>
                    <th class="text-center" scope="row">' . $sl . '</th>
                    <td>' . HumanReadAbleDateFormat($ThisDrVoucher["Date"]) . '</td>
                    <td>
                        ' . $ThisDrVoucher["ProjectName"] . '
                                            
                    </td>
                    <td>' . $ThisDrVoucher["HeadOfAccountName"] . '</td>
                    <td>' . $ThisDrVoucher["BankCashName"] . '</td>
                    <td class="text-center">' . $ThisDrVoucher["BillNo"] . '</td>
                    <td class="text-right">' . BangladeshiCurencyFormat($ThisDrVoucher["dr"]) . '</td>

                </tr>
                

            ';

    $TAmountdr = $ThisDrVoucher["dr"] +     $TAmountdr;

    $sl++;


}

$headOfAccountArea1 .= '
        <div class="headOfAccountArea m-b-30">

            <table class="table table-hover table-sm table-bordered">
                <thead>
                <tr>
                    <th scope="col">S.L No</th>
                    <th scope="col">Date</th>
                    <th scope="col">Project Name</th>
                    <th scope="col">Head Of Account</th>
                    <th scope="col">Mode of Payment</th>
                    <th class="text-center" scope="col">Bil No</th>
                    <th class="text-right" scope="col">Amount(Dr.)</th>
                    
                    
                </tr>
                </thead>
                <tbody>
                
                
                ' . $headDetails1 . '
                
                <tr>
                    <th colspan="6" class="text-right">Total =</th>
    
                    <td class="text-right" style="font-weight: bold">' . BangladeshiCurencyFormat($TAmountdr). '</td>
                </tr>
    

    
                </tbody>
    
            </table>
        </div>
        
    ';








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
        <h4>Customer Party Ladger ( '.$_REQUEST["FromDate"].' to  '.$_REQUEST["ToDate"].' )</h4>
    </div>
    
        '.$headOfAccountArea.'
        
        
        '.$headOfAccountArea1.'
        
            <table class="table table-hover table-sm table-bordered">

                <tbody>
                <tr>
                    <th class="text-right">Balance =</th>
                    <td class="text-right" style="font-weight: bold;width:300px;">' . BangladeshiCurencyFormat(($TAmountCr-$TAmountdr)). '</td>
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


?>