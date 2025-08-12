<?php



$Settings = SQL_Select("Settings", "SettingsID=1", "", true);





$PurchaseId = $_REQUEST["ID"];

$ConfirmItemsRequisitons = SQL_Select("Purchase where (PurchaseID=$PurchaseId and Confirm='Confirm')");



if (!empty($ConfirmItemsRequisitons[0])) {

	$ProjectDesc = SQL_Select("Category where CategoryID={$ConfirmItemsRequisitons[0]["CategoryID"]}");

	$ProjectAddress=$ProjectDesc[0]["Address"];




    $CategoryName = $ConfirmItemsRequisitons[0]["CategoryName"];
    $Note = $ConfirmItemsRequisitons[0]["Note"];

    $VendorName = $ConfirmItemsRequisitons[0]["VendorName"];



    $letterTitle = $ConfirmItemsRequisitons[0]["letterTitle"];

    $ContactPerson1 = $ConfirmItemsRequisitons[0]["ContactPerson1"];

    $ContactPerson2 = $ConfirmItemsRequisitons[0]["ContactPerson2"];

    $TaxesVat = $ConfirmItemsRequisitons[0]["TaxesVat"];



    $VendorID = $ConfirmItemsRequisitons[0]["VendorID"];



    $VendorInfo = SQL_Select("Vendor where (VendorID=$VendorID )");



    $Address = $VendorInfo[0]["Address"];





    $confirmRequisitonName = $ConfirmItemsRequisitons[0]["confirmRequisitonName"];

    $MediaName = $ConfirmItemsRequisitons[0]["MediaName"];

    $IssuingDate = $ConfirmItemsRequisitons[0]["IssuingDate"];

    $Subject = $ConfirmItemsRequisitons[0]["Subject"];

    $MessageBody = $ConfirmItemsRequisitons[0]["MessageBody"];

    $PurchaseConfirmID = $ConfirmItemsRequisitons[0]["PurchaseConfirmID"];



    $RequisitionConfirmID = $ConfirmItemsRequisitons[0]["confirmRequisitonName"];



    $Items = json_decode($ConfirmItemsRequisitons[0]["Items"]);





    $itemsIndex = 1;

    foreach ($Items as $item) {



        if ($item->requisitionQty > 0) {





            $itemsHtml .= '

                        <tr>

                            <td>' . $itemsIndex . '</td>

                            <td>' . $item->expenseHeadName . '
                                <br>
                                '.$item->Description.' 
                            
                            </td>

                            <td class="text-center">' . GetExpenseUnit($item->expenseHead) . '
                            </td>

                            <td class="text-right">' . number_format($item->requisitionQty,2) . '</td>

                            <td class="text-right">' . number_format($item->requisitionRate , 2) . '</td>

                            <td class="text-right">' . number_format($item->requisitionAmount, 2) . '</td>

                        </tr>

                     

                    ';

        }



        $itemsIndex++;



    }




    if (($itemsIndex - 1) == 1) {

        $px = "250px";

    } elseif (($itemsIndex - 1) == 2) {

        $px = "200px";

    } elseif (($itemsIndex - 1) == 3) {

        $px = "150px";

    } elseif (($itemsIndex - 1) == 4) {

        $px = "100px";

    } elseif (($itemsIndex - 1) == 5) {

        $px = "0px";

    } elseif (($itemsIndex - 1) == 6) {

        $px = "0px";

    } else {

        $px = "0px";

    }




    $PurchaseAmount = $ConfirmItemsRequisitons[0]["PurchaseAmount"];

    $DateOfDelevery = $ConfirmItemsRequisitons[0]["DateOfDelevery"];





} else {



    $MainContent .= "

	        " . CTL_Window($Title = "Application Setting Management", "You can not Print this item without Confirm<br>

			

			<br>

			.", 300) . "

	        <script language=\"JavaScript\" >

	            window.location='index.php?Theme=default&Base=Purchase&Script=Manage';

	        </script>

		";



}



if ($ContactPerson1){



    $contactPersonsHtml .='<p class="text-right" style="margin: 0px;"> Contact person: '.$ContactPerson1.'</p>';

}



if ($ContactPerson2){



    $contactPersonsHtml .='<p class="text-right"> '.$ContactPerson2.'</p>';

}

// if ( ($itemsIndex - 1) < 5) {
// 	$spaceHtml ='
// 	<tr style="height: ' . $px . '">
// 		<td></td>
// 		<td></td>
// 		<td></td>
// 		<td></td>
// 		<td></td>
// 		<td></td>
// 	</tr>
// ';
// }else{
// 	$spaceHtml="";
// }






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



    <title>Purchase Order</title>







    <style>



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

        

          .table-bordered th, .table-bordered td {

                border: 1px solid rgba(0,0,0,.3) !important;

          }





    </style>





</head>

<body>



<div class="container">

    <p style="font-size: 16px">Printing Date & Time: '.date('F j-y, h:i:sa').'</p>

</div>



<div class="print-area">



    <div class="container">

        <div style="padding: 10px 0px;" class="company-name row">

            <div  class="col-md-1">

                <img height="70px" src="./upload/' . $Settings["logo"] . '" alt="">

            </div>

            <div  class="col-md-9 text-center"> 

                <h4>'.$Settings["CompanyName"].'</h4>

                <p>'.$Settings["Address"].'</p>

            </div>

            <div class="col-md-2"> 

                <p class="text-right" style="margin:0px">' . $RequisitionConfirmID . '</p>

                <p class="text-right">' . $PurchaseConfirmID . '</p>

            </div>

            

        </div>

        

        <div style="text-align: center;"> 

            <h4>Purchase Order</h4>

        </div>

            

    </div>



    <div class="container">

        

        <div class="print-title-date row">

            <div class="col-lg-6">

                <p class="text-left">'.$letterTitle.'</p>

            </div>

            <div class="col-lg-6">

                <p class="text-right">' .  HumanReadAbleDateFormat( $IssuingDate ) . '</p>

            </div>

        </div>



        <div class="print-address row">

            <div class="col-lg-6">

                <p style="margin: 0px">' . $VendorName . '</p>

                <p>Address: ' . $Address . '</p>

            </div>

            

        </div>



        <div class="print-media">

            <h6>Attr: ' . $MediaName . '</h6>

        </div>

        <div class="print-subject">

            <h5>Subject: ' . $Subject . '</h5>

        </div>

        <div class="print-body">

            <p>' . $MessageBody . '</p>

        </div>



        <div class="print-rule-area">

            <div class="price-items">

                <h6> 1. Price</h6>



                <table class="table table-bordered">

                    <thead>

                    <tr>

                        <th>S I</th>

                        <th>Description of work</th>

                        <th class="text-center">Unit</th>

                        <th class="text-right">Qty.</th>

                        <th class="text-right">Rate (Tk)</th>

                        <th class="text-right">Total Price (Tk)</th>

                    </tr>

                    </thead>

                    <tbody>



                    ' . $itemsHtml . '

					'.$spaceHtml.'

                    <tr>



                        <th colspan="5" class="text-right"> Total =</th>

                        <th class="text-right">' . number_format($PurchaseAmount , 2) . '</th>

                    </tr>



                    </tbody>



                </table>



                <p>In word: <span style="font-weight: bold;text-transform: capitalize;"> ' . NumberToWordsNew($PurchaseAmount) . ' </span>  only.</p>

            </div>

            <div class="print-rule">

                <h6> 2. Mode of payment: <span

                            style="font-weight: normal">Payment will be made through bank deposit / Account payee cheque</span></h6>

                <h6> 3. Date of Delivery: <span style="font-weight: bold">' . HumanReadAbleDateFormat($DateOfDelevery) . '</span></h6>

                <h6> 4. Validity: <span style="font-weight: normal">This order will be valid for 05 (Five) days from the date of issuing this order</span>

                </h6>

                <p> <span style="font-weight:bold;"> 5. Place of Delivery: </span> <span style="font-weight: bold">' . $CategoryName . '</span>, '.$ProjectAddress.'</p>



                <p>If any of the above items found in damaged condition at the time of delivery or installation, will not be

                    accepted.

                    we hope you wil find the order acceptable.

                </p>

                <p> <span style="font-weight:bold"> Note: </span> '.$Note.'</p>



            </div>



            <div class="print-rule-ack row">

                <div class="col-lg-6">

                    <p class="text-left">Please acknowledge receipts</p>

                </div>

                <div class="col-lg-6">

                

                    

                    '.$contactPersonsHtml.'

                    

                </div>

            </div>





            <div style="margin: 50px 0px 35px 0px;" class="print-rule-sign row ">

           
                <div class="col-lg-3 text-center">



                    

                </div>

                <div class="col-lg-3 text-center">



                    

                </div>



                <div class="col-lg-3 text-center">

                    

                </div>

                    


                <div class="col-lg-3 text-center">

                    <span>--------</span><br>

                   
                        Authorized Signature</p>

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











