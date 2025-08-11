<?
	
GetPermission("OptionReport");		

if($_REQUEST["Customer"]!="")
	$Purchase= SQL_Select("Purchase","CustomerID={$_REQUEST["Customer"]} and IsQuotation=1 and PurchaseIsActive=1 order by PurchaseID DESC");
else
	$Purchase= SQL_Select("Purchase","PurchaseIsActive=1 order by PurchaseID DESC");

if($_REQUEST["Date"]=="Yes"){
	if($_REQUEST["Customer"]!=""){
		$SQLVendor="CustomerID={$_REQUEST["Customer"]} and ";
		//$VendorText="Vendor : ".GetVendorName($_REQUEST["Vendor"])."";
	}	
	$Purchase= SQL_Select("Purchase","{$SQLVendor} IsQuotation=1 and PurchaseIsActive=1 and DateInserted between '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}' order by PurchaseID DESC");
	$ReportHTML='
		<span style="color:black;font-family:arial;text-decoration:none;">
			Date : <b>'.$_REQUEST["FromDate"].'</b> To <b>'.$_REQUEST["ToDate"].'</b><br>
			<div style="float:right;width:800px;">
			'.$VendorText.'
			</div>
		</span>
	';
}	

$i=1;	
foreach($Purchase as $ThisPurchase){
	
	$PurchaseHTML.='
		<tr>
			<td width="35" align="center" style="border : 1px solid black;">
				'.$i.'.
			</td>
			<td width="100" align="center" style="border : 1px solid black;">
				'.date("M j, y", strtotime($ThisPurchase["DateInserted"])).'
			</td>
			<td align="left" style="border : 1px solid black;">
				<div style="padding:5px;">
					'.GetCustomerName($ThisPurchase["CustomerID"]).' 
				</div>
			</td>
			<td style="border : 1px solid black;">
				<div style="float:right;">Ref No : '.$ThisPurchase["PurchaseID"].'</div><br>
				'.GetPurchaseItem($ThisPurchase["TempNumber"]).'
			
			</td>
			<td style="border : 1px solid black;" align="right">
				'.QuotationAmount($ThisPurchase["CustomerID"],$ThisPurchase["TempNumber"]).'/=
			</td>
			<td style="border : 1px solid black;" align="center" >
				<a style="font-size:14px;color:blue;font-family:arial;text-decoration:none;" href="index.php?Theme=default&Base=Quotation&Script=Manage&Action=Edit&EditTempNumber='.$ThisPurchase["TempNumber"].'&CID='.$ThisPurchase["CustomerID"].'">
					Edit
				</a>
				&nbsp;|&nbsp;
				<a target="_blank" style="font-size:14px;color:blue;font-family:arial;text-decoration:none;" href="index.php?Theme=default&Base=Quotation&Script=Voucher&TempNumber='.$ThisPurchase["TempNumber"].'&NoHeader&NoFooter">
					Print
				</a>
			
			</td>


		</tr>

	
	';	
	$i++;
}

if($PurchaseHTML=="")
	$PurchaseHTML='
		<tr>
			<td colspan="3">
				No record found.
			</td>
		</tr>
	';
	
$MainContent.='

		<center>
			<h1>Quotation Report</h1>
			<div style="float:right;width:800px;">
				'.$ReportHTML.'
			</div>
		</center>
		<table border=0 width="800" style="border : 0px solid black;" align="center">
			<tr>
				<td width="25" align="center" style="border : 1px solid black;">
					SL
				</td>
				<td align="center" style="border : 1px solid black;">
					Date
				</td>
				<td align="center" style="border : 1px solid black;">
					Customer
				</td>
				<td style="border : 1px solid black;">
				
				</td>
				<td style="border : 1px solid black;" align="center" >
					Amount
				</td>
				<td  align="center" style="border : 1px solid black;">
					Action
				</td>
			</tr>
			'.$PurchaseHTML.'
		</table>


';	
	
?>