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
				<br>
				
			</td>
			<td align="center">'.$ThisPurchaseProducts['Qty'].' x '.$ThisPurchaseProducts['CostPerProduct'].'</td>
			<td align="right">'.$ThisPurchaseProducts['Qty']*$ThisPurchaseProducts['CostPerProduct'].' /= &nbsp;&nbsp;</td>
		</tr>	
	
	';

	$GrandTotal = $ThisPurchaseProducts['Qty']*$ThisPurchaseProducts['CostPerProduct'] + $GrandTotal;
	//echo $Vendor=$ThisPurchaseProducts["VendorID"];
	$i++;
}



$Vendor=SQL_Select($Entity="Vendor", $Where="VendorID={$ThisPurchaseProducts["VendorID"]}","","True");
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
        
        
    ';
    
}

$MainContent.='
	<title>Purchase Ref No : '.GetPurchaseID($_REQUEST["TempNumber"]).'</title>
	<div style="width:800px;">
				'.$CompanyPad.'
		<fieldset>
			<legend>Purchase Ref No : '.GetPurchaseID($_REQUEST["TempNumber"]).'</legend>
				<table width="800" align="center" border="0">
					
					<tr>
						<td>
							Vendor : '.$Vendor["VendorName"].'
						</td>
					
						<td align="right">

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
				<div style="padding:8px;border: 1px solid black; float:left; width:280px;">
					<b>Previous Due :</b> <br>
					'.PrevioiusDue($ThisPurchaseProducts["VendorID"],$_REQUEST["TempNumber"]).'				
				</div>	
				
				<div style="padding:8px;border: 1px solid black; float:right; width:300px;">
					<b>Payment History :</b> <br>
					'.ShowFunding($_REQUEST["TempNumber"]).'				
				</div>	
				
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
		
		<style type="text/css" media="print">
		@page {
		    size: auto;   /* auto is the initial value */
		    margin: 0;  /* this affects the margin in the printer settings */
		}
		</style>

		
';

?>