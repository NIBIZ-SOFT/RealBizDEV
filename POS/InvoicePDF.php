<?php
ob_start();
//GetPermission("OptionSales");	

$PurchaseProducts=SQL_Select($Entity="SalesOrder", $Where="TempNumber='{$_REQUEST["TempNumber"]}'","","");

$GrandTotal=0;
$i=1;
foreach($PurchaseProducts as $ThisPurchaseProducts){
	//$ThisPurchaseProducts['ProductID']
	$SerialsHTML='';
	if($ThisPurchaseProducts['Serials']!="")
		$SerialsHTML='<br>SL:'.$ThisPurchaseProducts['Serials'].' ';
		
	if($ThisPurchaseProducts['Warranty']=="")
		$ThisPurchaseProducts['Warranty']="N/A";
                
        $GetProductInfo = SQL_Select("Products","ProductsID={$ThisPurchaseProducts['ProductID']}","",true);        
		
	$HTML.='
		<tr>
			<td align="center">'.$i.'.</td>					
			<td >
				<div style="padding:5px;">
                                        '.$GetProductInfo["ProductName"].' <br>
					'.GetProductCategoryName($ThisPurchaseProducts['ProductID']).'<br>
					<span style="font-size:14px;">'.$GetProductInfo["Color"].','.$GetProductInfo["Grade"].','.$GetProductInfo["Origin"].'</span>
				</div>
			</td>
			
			<td align="center">'.$GetProductInfo['Size'].'</td>
			<td align="center">'.$GetProductInfo['Brand'].'</td>
			<td align="center">'.$GetProductInfo['Units'].'</td>
			<td align="center">'.$ThisPurchaseProducts['Qty'].'</td>
			<td align="center">'.$ThisPurchaseProducts['Price'].'</td>
			<td align="right">'.$ThisPurchaseProducts['Qty']*$ThisPurchaseProducts['Price'].' /= &nbsp;&nbsp;</td>
		</tr>	
	
	';

	$GrandTotal = $ThisPurchaseProducts['Qty']*$ThisPurchaseProducts['Price'] + $GrandTotal;
	//echo $Vendor=$ThisPurchaseProducts["VendorID"];
	$i++;
}

//echo GetDiscount($_REQUEST["TempNumber"])."ss";
$GrandTotalAfterDiscount = $GrandTotal - GetDiscount($_REQUEST["TempNumber"]);

$GetCustomerID=SQL_Select($Entity="Sales", $Where="TempNumber='{$_REQUEST["TempNumber"]}'","","True");
if($GetCustomerID["CustomerID"]!="")
$Customer=SQL_Select($Entity="Customer", $Where="CustomerID={$GetCustomerID["CustomerID"]}","","True");
$GetCompanyInfo=SQL_Select("Settings","SettingsID=1","","true");

$CompanyPad=' <br><br><br><br><br><br>';
if($GetCompanyInfo["IsUseCompanyPad"]==1){
    
    $CompanyPad = '
        <table align="center">
            <tr>
                <td align="center">
                    
                    <b style="font-size:25px;">'.$GetCompanyInfo["CompanyName"].'</b><br>
                    '.nl2br($GetCompanyInfo["Address"]).'
                </td>
            </tr>
            
        </table>
        <br><br>
        
    ';
    
}

$MainContent1.='

                                '.$CompanyPad.'                        
 
                                Invoice No. : '.$GetCompanyInfo["InvoicePrifix"].'-'.GetSalesID($_REQUEST["TempNumber"]).'
				<br><br>
				<table  border="1"  cellpadding="0" cellspacing="0" border="0" width="100%" >
					
					<tr>
						<td align="left" >
							Customer : '.$Customer["CustomerName"].' <br>
							Phone : '.$Customer["Phone"].' <br>
							Address : '.$Customer["Address"].'
						</td>
						<td align="left" style="width:200px;" >
                                                
                                                </td>					
						<td align="right"  >
							Sales by : '.GetUserName($GetCustomerID["SalesBy"]).' <br>
							Created on : '.date("F j, Y, h:i A",strtotime($ThisPurchaseProducts['DateInserted'])).'<br>
						</td>
					</tr>			
				</table>

                                <br><br>
			
				<table cellpadding="0" cellspacing="0" border="1" width="100%">
					<tr>
						<td width="60">
							&nbsp;&nbsp;<b>SL No.</b>
						</td>
						<td align="center">
							&nbsp;&nbsp;<b>Product Name</b>
						</td>
						
						<td width="50" align="center">
							<b>Size</b>
						</td>
						<td width="50" align="center">
							<b>Brand</b>
						</td>
						<td width="50" align="center">
							<b>Units</b>
						</td>
						<td width="50" align="center">
							<b>Qty</b>
						</td>
						<td width="50" align="center">
							<b>Price</b>
						</td>
						<td align="right" width="100">
							<b>Total Price</b>&nbsp;&nbsp;
						</td>
					</tr>
					'.$HTML.'
					<tr>
						<td colspan="9" align="right">
							<span style="font-size:18px;font-weight:bold;">Total : '.$GrandTotal.' /= </span>&nbsp;&nbsp;
						</td>
					</tr>
				</table>
				Grand Total In words : <i>'.convertNumberToWords($GrandTotalAfterDiscount).'</i>

		
		
				<br>
				<br>
                                ';
                                $IfDue = PrevioiusDueForSalesOrder($Customer["CustomerID"],$_REQUEST["TempNumber"]);
                                
                                if($IfDue!="No Previous Due")
                                    $PeviousDue='
                                                <b>Previous Due :</b> <br>
                                                '.$IfDue.'				
                                    
                                    ';
                                
                                
                                $MainContent1.='
                                    <table width="100%">
                                        <tr>
                                            <td width="50%">
                                                '.$PeviousDue.'
                                            </td>
                                            <td style="width:160px;">
                                               
                                            </td>
                                    
                                            
                                            <td align="right" width="50%" valign="top">
                                                <b>Payment History :</b> <br>
                                                '.ShowSalesFundingPDF($_REQUEST["TempNumber"]).'
                                            </td>
                                        </tr>
                                    </table>
				
                                    <hr>
                                    Terms & Condition : <br>
                                          '.nl2br($GetCompanyInfo["InvoiceTerms"]).'

	
	
';


require_once('./script/html2pdf/html2pdf.class.php');
$html2pdf = new HTML2PDF('P','A4','fr');
$html2pdf->WriteHTML($MainContent1);
//$html2pdf->Output('exemple.pdf');

$filename=$GetCompanyInfo["InvoicePrifix"].'-'.GetSalesID($_REQUEST["TempNumber"]).'.pdf';

$html2pdf->Output('upload/'.$filename.'', 'D'); // D for Download and F for File Store


?>

