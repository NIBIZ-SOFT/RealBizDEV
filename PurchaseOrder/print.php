<?php



include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";





$Settings = SQL_Select("Settings", "SettingsID=1", "", true);



$PurchaseId = $_REQUEST["ID"];



$ConfirmItemsRequisitons = SQL_Select("Purchaserequisition where (PurchaseRequisitionID=$PurchaseId)");





if (!empty($ConfirmItemsRequisitons[0])) {





    $CategoryID = $ConfirmItemsRequisitons[0]["CategoryID"];



    $CategoryInfo = SQL_Select("Category where (CategoryID=$CategoryID)");



    $address = $CategoryInfo[0]["Address"];





    $CategoryName = $ConfirmItemsRequisitons[0]["CategoryName"];

    $MPRNO = $ConfirmItemsRequisitons[0]["MPRNO"];

    $Comments = $ConfirmItemsRequisitons[0]["Comments"];

    $Contract = $ConfirmItemsRequisitons[0]["Contract"];

    $NB = $ConfirmItemsRequisitons[0]["NB"];





    $RequisitonDate = $ConfirmItemsRequisitons[0]["Date"];

    $RequiredDate = $ConfirmItemsRequisitons[0]["RequiredDate"];



    $EmployeeName = $ConfirmItemsRequisitons[0]["EmployeeName"];

    $Remark = $ConfirmItemsRequisitons[0]["Remark"];

    $PurchaseRequisitionPurpose = $ConfirmItemsRequisitons[0]["PurchaseRequisitionPurpose"];



    $Status = $ConfirmItemsRequisitons[0]["Confirm"];

    $RequisitionConfirmID = $ConfirmItemsRequisitons[0]["RequisitionConfirmID"];





    $confirmRequisitonName = $ConfirmItemsRequisitons[0]["confirmRequisitonName"];

    $MediaName = $ConfirmItemsRequisitons[0]["MediaName"];





    $Items = json_decode($ConfirmItemsRequisitons[0]["Items"]);



    $itemsIndex = 1;

    foreach ($Items as $item) {





        $customTd = '';

        if ($itemsIndex == 1) {



            $customTd = '<td rowspan="' . (count((array)$Items) + 1) . '"> ' . $Remark . ' </td>';

        }

        $PurchaseAmount +=$item->requisitionAmount;

        $itemsHtml .= '

                <tr>

                    <td style="text-align: center;">' . $itemsIndex . '</td>

                    <td>' . GetExpenseHeadName($item->expenseHead) . '
                        <br>
                        '.$item->Description.'
                    </td>

                    <td>' . GetExpenseUnit($item->expenseHead) . '</td> 

                    <td class="text-right">' . number_format($item->requisitionQty,2) . '</td>

                    <td class="text-right">' . number_format($item->requisitionRate , 2) . '</td>

                    <td class="text-right" >' . number_format($item->requisitionAmount, 2) . '</td>

                    ' . $customTd . '

                </tr>

            ';





        $itemsIndex++;



    }





    if (($itemsIndex - 1) == 1) {

        $px = "400px";

    } elseif (($itemsIndex - 1) == 2) {

        $px = "300px";

    } elseif (($itemsIndex - 1) == 3) {

        $px = "200px";

    } elseif (($itemsIndex - 1) == 4) {

        $px = "150px";

    } elseif (($itemsIndex - 1) == 5) {

        $px = "50px";

    } elseif (($itemsIndex - 1) == 6) {

        $px = "0px";

    } else {

        $px = "0px";

    }





    

    $DateOfDelevery = $ConfirmItemsRequisitons[0]["DateOfDelevery"];





} else {



    /*    $MainContent.="

                ".CTL_Window($Title="Application Setting Management", "You can not Print this item without Confirm<br>



                <br>

                .",300)."

                <script language=\"JavaScript\" >

                    window.location='index.php?Theme=default&Base=PurchaseOrder&Script=Manage';

                </script>

            ";*/



}



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



    <title> Requisition</title>

    

    <style>

    

        .description{

        

            border: 1px solid rgba(0,0,0,.3) !important;

            padding: 10px;

            border-radius: 3px;

            

        }

        .description p{

            padding: 3px 0px;

            margin: 0px;

            

        }

        

        

        .requisitionNo{

            border: 1px solid rgba(0,0,0,.3) !important;

            text-align: center;

         

        }

        

        .requisitionNo p{

            padding: 3px 0px;

            margin: 0px;

        }



        .requisitionNo p+p{

            border: 1px solid rgba(0,0,0,.3) !important;

        }

        

        

        .the-legend {

            border-style: none;

            border-width: 0;

            font-size: 14px;

            line-height: 20px;

            margin-bottom: 0;

            width: auto;

            padding: 0 10px;

            border: 1px solid rgba(0,0,0,.3) !important;

        }

        .the-fieldset {

            border: 1px solid rgba(0,0,0,.3) !important;

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

            

            .bgstyle{

                height: 37px !important;

                width: 71.5% !important;

                background-color: rgba(0,0,0,.5) !important;

                position: absolute !important;

                top: 1.4% !important;

                left: 4% !important; 

            }

            

            



        }

        

        

        .bgstyle{

            height: 37px;

            width: 63.2%;

            background-color: rgba(0,0,0,.5);

            position: absolute;

            top: 1.4%;

            left: 9%;

        }

        

          .table-bordered th, .table-bordered td {

                border: 1px solid rgba(0,0,0,.3) !important;

          }

        

     

    </style>



</head>

<body>



<div class="container">

    <p style="font-size: 16px">Printing Date & Time: '.date('F j-y, h:i:sa').'</p>

</div>



<div class="print-area" style="position: relative">

        <div class="bgstyle"> </div>



        <div class="container">

        

            <div style="padding: 20px 0px;" class="company-name row">

                <div  class="col-md-1">

                    <img style="margin-left:62px;margin-top: -17px;" height="70px" src="./upload/' . $Settings["logo"] . '" alt="">

                </div>

                <div  class="col-md-8 text-center"> 

                    

                </div>

                <div class="col-md-3"> 

                    <div class="requisitionNo"> 

                        <p>Requisition No.</p>

                        <p>' . $RequisitionConfirmID . '</p>

                    </div>

                </div>

            </div>

            <div style="text-align: center;"> 

            

                <h3 style="font-weight: bold">'.$Settings["CompanyName"].'</h3>

                <p style="border-bottom: 1px solid rgba(0,0,0,.3);font-size: 18px;">'.$Settings["Address"].'</p>

                <h4>Purchase Requisition</h4>

            </div>

            

        </div>

    

    <div class="container">

        

        <div class="row" style="margin-bottom: 20px"> 

            <div class="col-md-6"> 

                <div class="description"> 

                    <p>Project Name:' . $CategoryName . '</p>

                    <p>Project Address: ' . $address . '</p>

                    <p>Contract: ' . $Contract . '</p>

                    

                    <p>Description: ' . $PurchaseRequisitionPurpose . '</p>

                  

                </div>

            

            </div>

            <div class="col-md-6"> 

            

                <div class="description"> 

                    

                    <p>Requisition Date: ' . HumanReadAbleDateFormat($RequisitonDate) . '</p>

                    <p>Required Date: ' . HumanReadAbleDateFormat($RequiredDate) . '</p>

                   

                    <p>Requisition Raised By: ' . $EmployeeName . '</p>

                    

                    <p>MPR/REF No.' . $MPRNO . '</p>

                    

                </div>

            

            </div>

        

        </div>

        

       

        <div class="print-rule-area">

            <div class="price-items">

                

                <table class="table table-bordered">

                    <thead>

                    <tr>

                        <th>SL. No.</th>

                        <th>Item Name & Description</th>

                        <th class="text-center">Unit</th>
                        <th>Required Quantity</th>

                        <th>Approx./Last Unit Cost</th>

                        <th> Total Approx. Value (TK)</th>

                        <th>Remarks</th>

                    </tr>

                    </thead>

                    <tbody>



                    ' . $itemsHtml . '

                    

                    <tr style="height: ' . $px . '"> 

                        <td></td>

                        <td></td>

                        <td></td>

                        <td></td>

                        <td></td>

                        

                    </tr>



                    <tr style="height: 10px;">



                        <th colspan="5" class="text-right"> Total =</th>

                        <th class="text-right" >' . number_format($PurchaseAmount, 2) . '</th>

                        <th></th>

                    </tr>

                    



                    </tbody>



                </table>

                <p>In word: <span style="font-weight: bold;text-transform: capitalize;"> ' . NumberToWordsNew($PurchaseAmount) . ' </span>  only.</p>

            </div>

            

             <fieldset class="the-legend">

                <legend class="the-fieldset">Comments:</legend>

                

                <p style="font-size: 16px">' . $Comments . '</p>



            </fieldset>

           

           <p style="font-size: 16px;">NB: ' . $NB . '</p>

           

           

            <div style="padding-left: 20px;margin: 80px 0px;" class="print-rule-sign row ">

                <div class="col-lg-3 text-center" style="flex: 0 0 42%;max-width: 15%;">



                    <span>--------</span>

                    <p>Prepared by<br>

                        Officer/Manager</p>

                </div>





                <div class="col-lg-3 text-center" style="flex: 0 0 70%;max-width: 70%;">

                    <span>--------</span>

                    <p>Checked/Forwarded by<br>

                        GM, FAD</p>

                </div>



                <div class="col-lg-3 text-center" style="flex: 0 0 42%;max-width: 15%;">

                    <span>--------</span>

                    <p>Approved by<br>

                        MD</p>

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



?>





