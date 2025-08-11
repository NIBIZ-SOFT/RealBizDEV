<?php
	
GetPermission("OptionPurchase");
	
$PurchaseProducts=SQL_Select($Entity="PurchasedProducts", $Where="TempNumber='{$_REQUEST["TempNumber"]}'","","");

$GrandTotal=0;
$i=1;
foreach($PurchaseProducts as $ThisPurchaseProducts){
	$SerialsHTML="";
	$Serials=explode(",",$ThisPurchaseProducts['Serials']);
	 foreach($Serials as $ThisSerials){
		$SerialsHTML.='
			 '.$ThisSerials.',
		';
	 }
	$SerialsHTML = substr($SerialsHTML, 0, -6);
	$HTML.='
		<tr>
			<td>&nbsp;&nbsp;'.$i.'.</td>					
			<td>&nbsp;&nbsp;'.$ThisPurchaseProducts['ProductID'].'</td>					
			<td >
				&nbsp;&nbsp;'.GetProductCategoryName($ThisPurchaseProducts["ProductID"]).' - '.GetProductName($ThisPurchaseProducts['ProductID']).'
				
				
			</td>
			<td align="center">'.$ThisPurchaseProducts['Qty'].' x '.$ThisPurchaseProducts['CostPerProduct'].'</td>
			<td align="right">'.$ThisPurchaseProducts['Qty']*$ThisPurchaseProducts['CostPerProduct'].' /= &nbsp;&nbsp;</td>
		</tr>	
	
	';

	$GrandTotal = $ThisPurchaseProducts['Qty']*$ThisPurchaseProducts['CostPerProduct'] + $GrandTotal;
	//echo $Vendor=$ThisPurchaseProducts["VendorID"];
	$i++;
}



$Vendor=SQL_Select($Entity="Customer", $Where="CustomerID={$ThisPurchaseProducts["CustomerID"]}","","True");
$GetCompanyInfo=SQL_Select("Settings","SettingsID=1","","true");
$MainContent.='
	<title>Quotation Ref No : '.GetPurchaseID($_REQUEST["TempNumber"]).'</title>
	<div style="width:800px;">
		<fieldset>
			<legend>Quotation Ref No : '.GetPurchaseID($_REQUEST["TempNumber"]).'</legend>
				
				<table width="800" align="center" border="0">
					<tr>
						<td>
							<img src="./upload/'.$GetCompanyInfo["logo"].'" width="200" height="100">
						</td>
						<td align="right">
							'.$GetCompanyInfo["CompanyName "].'<br/>
							'.$GetCompanyInfo["Address"].'<br/>
						</td>					
					</tr>
					<tr>
						<td>
							Name : '.$Vendor["CustomerName"].'<br>
							Phone : '.$Vendor["Phone"].' <br>
							Address : '.$Vendor["Address"].' 
						</td>
					
						<td align="right">
							Quotation No. : '.GetPurchaseID($_REQUEST["TempNumber"]).' <br>
							Created on : '.date("F j, Y, h:i A",strtotime($ThisPurchaseProducts['DateInserted'])).'<br>
							Printed on : '.date("F j, Y, h:i A").'
						</td>
					</tr>			
				</table>
			
			
				<table cellpadding="0" cellspacing="0" border="1" width="100%">
					<tr>
						<td width="20">
							&nbsp;&nbsp;<b>SL.</b>&nbsp;
						</td>
						<td width="50">
							&nbsp;&nbsp;<b>P-ID</b>
						</td>
						<td align="center">
							&nbsp;&nbsp;<b>Product Name</b>
						</td>
						<td width="80" align="center">
							<b>Qty</b>
						</td>
						<td align="right" width="150">
							<b>Total Price</b>&nbsp;&nbsp;
						</td>
					</tr>
					'.$HTML.'
					<tr>
						<td colspan="5" align="right">
							<span style="font-size:18px;font-weight:bold;">Total : '.$GrandTotal.' /= </span>&nbsp;&nbsp;
						</td>
					</tr>
				</table>
				In word : <i>'.convertNumberToWords($GrandTotal).'</i>

		
		
				<br>
				<br>
				
				
				
				<div style="clear:both;height:20px;"></div> 
				
				<div style="margin-left:50px; text-align:center; float:left; width:200px;">
				<br />
				<br />
				<br />
				<hr/>
                Receive By
				</div>	
				
				
				<div style="margin-left:322px; text-align:center; float:left; width:200px;">
				<br />
				<br />
				<br />
				<hr/>
                Office Authority
				</div>
		
		
			</fieldset>	
		
		
	</div>
	
		<div sytle="clear:both;"></div>
		
		
		<script>
			window.print();
		</script>
		
		
		<style type="text/css" media="print">
		@page {
		    size: auto;   /* auto is the initial value */
		    margin: 0;  /* this affects the margin in the printer settings */
		}
		</style>		
';

?>