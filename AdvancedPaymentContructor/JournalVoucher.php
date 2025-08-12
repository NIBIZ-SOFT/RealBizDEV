<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 3/30/2019
 * Time: 6:17 PM
 */



if ( isset($_REQUEST["VoucherNo"])){

    $journalContructors=SQL_Select("advancepaymentcontructor where VoucherNo={$_REQUEST["VoucherNo"]}");

    $sl=1;
    $dr=0;
    $cr=0;
    foreach ($journalContructors as $journalContructor){

        $dr +=$journalContructor["dr"];
        $cr +=$journalContructor["cr"];
        $description=$journalContructor["Description"];

        $form=0;
        $to=0;

        $fromProjectID=$journalContructor["CategoryID"];

        if ($journalContructor["dr"] > 0 ){
            $fromProjectName=$journalContructor["CategoryName"];

            $form=$journalContructor["dr"];


        }else{
            $toProjectName=$journalContructor["CategoryName"];
            $to=$journalContructor["cr"];

        }

        if ($sl == 1){

        }else{

            $toProjectName=$journalContructor["CategoryName"];
        }

        $tr .='
            <tr>
                <td style="text-align: center">'.$sl.'</td>
                
                <td>'.$journalContructor["HeadOfAccountName"].'</td>
                
                <td>'.BangladeshiCurencyFormat($form).'</td>
                <td>'.BangladeshiCurencyFormat($to).'</td>
                
            </tr>';

        $sl++;

    }

    $voucherName="JOURNAL VOUCHER";
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

    <title>  '.$voucherName.'</title>

    <style>
    
        .description{
        
            border:1px solid #DEE2E6; 
            padding: 10px;
            border-radius: 3px;
            
        }
        .description p{
            padding: 3px 0px;
            margin: 0px;
            
        }
        
        
        .requisitionNo{
            border:1px solid #DEE2E6; 
            text-align: center;
         
        }
        
        .requisitionNo p{
            padding: 3px 0px;
            margin: 0px;
        }

        .requisitionNo p+p{
            border-top: 1px solid #DEE2E6;
        }
        
        
        .the-legend {
            border-style: none;
            border-width: 0;
            font-size: 14px;
            line-height: 20px;
            margin-bottom: 0;
            width: auto;
            padding: 0 10px;
            border: 1px solid #e0e0e0;
        }
        .the-fieldset {
            border: 1px solid #e0e0e0;
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

        }
        
        .the-legend {
            border-style: none;
            border-width: 0;
            font-size: 14px;
            line-height: 20px;
            margin-bottom: 0;
            width: auto;
            padding: 0 10px;
            border: 1px solid #e0e0e0;
        }
        .the-fieldset {
            border: 1px solid #e0e0e0;
            padding: 5px;
            font-size: 16px;
            width: 100px;
            
        }

    </style>

</head>
<body>

<div class="print-area">

        <div class="container" style="margin-bottom: 20px">
            <div style="padding: 10px 0px;" class="company-name row">
                <div  class="col-md-1">
                    <img src="./upload/d30b70f7508ba6f116fbb4d86913d118_logo.png" alt="">
                </div>
                <div  class="col-md-8 text-center"> 
                    
                </div>
                <div class="col-md-3"> 
                    <div class="requisitionNo"> 
                        <p>Voucher No.</p>
                        <p>C-'. str_pad($_GET["VoucherNo"],"4","0",STR_PAD_LEFT) .'</p>
                    </div>
                </div>
            </div>
            <div style="text-align: center;"> 
            
                <h4 style="font-weight: bold">Japan Taguchi Construction Co. Ltd</h4>
                <p style="border-bottom: 1px solid #DEE2E6;font-size: 18px;">House#257, Road#01, Block# B, Bashundhara R/A, Dhaka-1229</p>
                
                <h4>'.$voucherName.'</h4>
                
            </div>
            
        </div>
    
    <div class="container">
        
        <div class="row" style="margin-bottom: 20px"> 
            <div class="col-md-5 col-sm-5 col-xs-3 col-lg-5"> 
                <div class="description"> 
                    <p>Project Name: '.$fromProjectName.'</p>
                    
                </div>
            
            </div>
            <div class="col-md-5 col-sm-5 col-xs-3 col-lg-5"> 
                <div class="description">  
                    <p> Project Address: '. GetProjectAddress($fromProjectID).'</p>
                    
                </div>
            
            </div>
            <div class="col-md-2 col-sm-2 col-xs-2 col-lg-2"> 
                <div class="description">  
                    <p>Date: '.HumanReadAbleDateFormat($journalvouchers[0]["Date"]).'</p>
                    
                </div>
            
            </div>
            
        
        </div>
        
       
        <div class="print-rule-area">
            <div class="price-items">
                
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>SL. No.</th>
                        
                        <th>Head Of Accounts</th>
                        
                        <th>Debit (Tk) </th>
                        <th>Credit (Tk) </th>
                        
                    </tr>
                    </thead>
                    <tbody>

                        '.$tr.'

                    <tr style="height: 10px;">

                        <th colspan="2" class="text-right"> Total =</th>
                        <th>'.BangladeshiCurencyFormat($dr).' /-</th>
                        <th>'.BangladeshiCurencyFormat($cr).' /-</th>
                        
                    </tr>
                    

                    </tbody>

                </table>
                <p>In word: <span style="font-weight: bold;text-transform: capitalize;"> ' . NumberToWordsNew($dr) . ' </span>  only.</p>
            </div>
            
            <fieldset class="the-legend">
              <legend  class="the-fieldset">Particular:</legend>
              
              <p style="font-size: 16px">' . $description . '</p>
            </fieldset>
            

            
            
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

