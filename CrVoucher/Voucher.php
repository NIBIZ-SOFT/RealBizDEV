<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 3/30/2019
 * Time: 6:17 PM
 */


$Settings = SQL_Select("Settings", "SettingsID=1", "", true);


if (isset($_REQUEST["CrVoucherID"])) {
    $CrVoucher = SQL_Select("CrVoucher where CrVoucherID={$_REQUEST["CrVoucherID"]}");
    $amount = $CrVoucher[0]["Amount"];
    $voucherName = "CREDIT";

    $BankGLCode = SQL_Select("bankcash","BankCashID={$CrVoucher[0]["BankCashID"]}","",true);
    $ExpenseGLCode = SQL_Select("expensehead","ExpenseHeadID={$CrVoucher[0]["HeadOfAccountID"]}","",true);



    $MainContent .= '

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link media="screen,print" rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <title>' . $voucherName . ' VOUCHER</title>


    <style>
    
    
        
        .description{
        
            border:1px solid rgba(0,0,0,.3); 
            padding: 10px;
            border-radius: 3px;
            
        }
        .description p{
            padding: 3px 0px;
            margin: 0px;
            
        }
        
        
        .requisitionNo{
            border:1px solid rgba(0,0,0,.3); 
            text-align: center;
         
        }
        
        .requisitionNo p{
            padding: 3px 0px;
            margin: 0px;
        }

        .requisitionNo p+p{
            border-top: 1px solid rgba(0,0,0,.3);
        }
        
        
        .the-legend {
            border-style: none;
            border-width: 0;
            font-size: 14px;
            line-height: 20px;
            margin-bottom: 0;
            width: auto;
            padding: 0 10px;
            border: 1px solid rgba(0,0,0,.3);
        }
        .the-fieldset {
            border: 1px solid rgba(0,0,0,.3);
            padding: 5px;
            font-size: 16px;
            width: 100px;
            
        }

        @media print {
            .col-sm-6, .col-lg-3 {
                float: left;
            }

            .col-lg-6 {
                width: 50%;
            }

            .col-lg-3 {
                width: 25%;
            }

            .print-footer-text {
                background-color: rgba(0, 0, 0, .5) !important;
            }
            
           .table-bordered th, .table-bordered td {
                border: 1px solid rgba(0,0,0,.3) !important;
           }
              
             
        }
        
          .table-bordered th, .table-bordered td {
                border: 1px solid rgba(0,0,0,.3) !important;
          }
          
          .customeBorder{
            border: 1px solid rgba(0,0,0,.3) !important;
          }
          .customeBorderBottom{
            border-bottom:1px solid rgba(0,0,0,.3) !important;
          }
          
        
        

    </style>

</head>
<body>


<div class="container">
    <p style="font-size: 16px">Printing Date & Time: ' . date('F j-y, h:i:sa') . '</p>
</div>

<div class="print-area">

        <div class="container" style="margin-bottom: 20px">
            <div style="padding: 10px 0px;" class="company-name row">
                <div  class="col-md-1">
                    <img  style="height: 70px" src="./upload/' . $Settings["logo"] . '" alt="">
                </div>
                <div  class="col-md-8 text-center"> 
                    
                </div>
                <div class="col-md-3"> 
                    <div class="requisitionNo"> 
                        <p>Voucher No.</p>
                        <p>' . str_pad($_REQUEST["CrVoucherID"], "4", "0", STR_PAD_LEFT) . '</p>
                    </div>
                </div>
            </div>
            <div style="text-align: center;"> 
            
                <h4 style="font-weight: bold">'.$Settings["CompanyName"].'</h4>
                <p style="border-bottom: 1px solid rgba(0,0,0,.3);font-size: 18px;">'.$Settings["Address"].'</p>
                
                <h4>' . $voucherName . ' VOUCHER</h4>
                
            </div>
            
        </div>
    
    <div class="container">
        
        <div class="row" style="margin-bottom: 20px"> 
            <div class="col-md-5 col-sm-5 col-xs-3 col-lg-5"> 
                <div class="description"> 
                    <p>Project Name: ' . $CrVoucher[0]["ProjectName"] . '</p>
                    
                </div>
            
            </div>
            <div class="col-md-5 col-sm-5 col-xs-3 col-lg-5"> 
                <div class="description">  
                    <p>Location : ' . GetProjectAddress($CrVoucher[0]["ProjectID"]) . ' </p>
                    
                </div>
            
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2"> 
                <div class="description">  
                    <p>Date: ' . HumanReadAbleDateFormat($CrVoucher[0]["Date"]) . '</p>
                    
                </div>
            
            </div>
          
        </div>
        
        <div class="print-rule-area">
            <div class="price-items">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>SL. No.</th>
                        <th>Particulars</th>
                        <th>Customer Name</th>
                        <th>Bank Name</th>
                        <th>Head Of Accounts</th>
                        <th>CQ. No</th>
                        
                        <th> M.R/ Bill No.</th>
                        <th>Amount(TK)</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <td style="text-align: center">1</td>
                        <td>' . $CrVoucher[0]["Description"] . '</td>
                        <td>'.$CrVoucher[0]["CustomerID"].' - ' . $CrVoucher[0]["CustomerName"] . '</td>
                        <td>'.$BankGLCode["GLCode"].' - ' . $CrVoucher[0]["BankCashName"] . '</td>
                        <td>'.$ExpenseGLCode["GLCode"].' - ' . $CrVoucher[0]["HeadOfAccountName"] . '</td>
                        <td>' . $CrVoucher[0]["ChequeNumber"] . '</td>
                        <td>' . $CrVoucher[0]["BillNo"] . '</td>
                        
                        <td align="right">' . BangladeshiCurencyFormat($amount) . '/-</td>
                        
                    </tr>
                    
';

$FindDV = SQL_Select("transaction", "VoucherNo='{$_REQUEST["CrVoucherID"]}' and VoucherType='DV'","",true);


    if($FindDV["VoucherNo"]!="" ){
        $MainContent99.='
                        <tr>
                            <td style="text-align: center">2</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>' . $FindDV["HeadOfAccountName"] . '</td>
                            <td></td>
                            <td></td>
                            
                            <td align="right">(-)' . BangladeshiCurencyFormat($FindDV["dr"]) . '/-</td>
                            
                        </tr>
                        
        ';    
        //$amount = $amount - $FindDV["dr"];
    }
$MainContent.='
                    <tr style="height: 10px;">

                        <th colspan="7" class="text-right"> Total =</th>
                        <th  class="text-right">' . BangladeshiCurencyFormat($amount) . ' /-</th>
                        
                    </tr>
                    
                    </tbody>

                </table>
                <p>In word: <span style="font-weight: bold;text-transform: capitalize;"> ' . NumberToWordsNew($amount) . ' </span>  only.</p>
            </div>
           
            <div style="margin: 80px 0px;" class="print-rule-sign row ">
                <div class="col-lg-3 text-center">

                    <span>--------</span>
                    <p>Prepared by <br>
                        </p>
                </div>
                <div class="col-lg-3 text-center">

                    <span>--------</span>
                    <p>Checked by <br>
                        </p>
                </div>

                <div class="col-lg-3 text-center">
                    <span>--------</span>
                    <p>Forward by <br>
                       </p>
                </div>

                <div class="col-lg-3 text-center">
                    <span>--------</span>
                    <p>Approved by <br>
                        </p>
                </div>

            </div>

        </div>

    </div>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
</body>
</html>';


}

