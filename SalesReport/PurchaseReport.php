<?
	
GetPermission("OptionReport");		

if($_REQUEST["Vendor"]!="")
	$Purchase= SQL_Select("Purchase","VendorID={$_REQUEST["Vendor"]} and PurchaseIsActive=1 order by PurchaseID DESC");
else
	$Purchase= SQL_Select("Purchase","PurchaseIsActive=1 order by PurchaseID DESC");

if($_REQUEST["Date"]=="Yes"){
	if($_REQUEST["Vendor"]!=""){
		$SQLVendor="VendorID={$_REQUEST["Vendor"]} and ";
		$VendorText="Vendor : ".GetVendorName($_REQUEST["Vendor"])."";
	}	
	$Purchase= SQL_Select("Purchase","{$SQLVendor} PurchaseIsActive=1 and DateInserted between '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}' order by PurchaseID DESC");
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
				<a style="font-size:14px;color:blue;font-family:arial;text-decoration:none;" href="index.php?Theme=default&Base=Purchase&Script=Manage&Action=Edit&EditTempNumber='.$ThisPurchase["TempNumber"].'">
					Edit
				</a>
				&nbsp;|&nbsp;
				<a target="_blank" style="font-size:14px;color:blue;font-family:arial;text-decoration:none;" href="index.php?Theme=default&Base=Purchase&Script=Voucher&TempNumber='.$ThisPurchase["TempNumber"].'&NoHeader&NoFooter">
					Print
				</a>
				<br>
				<div style="padding:5px;">
					'.GetVendorName($ThisPurchase["VendorID"]).' 
				</div>
			</td>
			<td style="border : 1px solid black;">
				Purchase Ref No : '.$ThisPurchase["PurchaseID"].'<br>
				'.GetPurchaseItem($ThisPurchase["TempNumber"]).'
				<div style="float:right;">
					'.PrevioiusDue($ThisPurchase["VendorID"],$ThisPurchase["TempNumber"],True).'
				</div>
			
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
			<h1>Purchase Report</h1>
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
					Vendor
				</td>
				<td style="border : 1px solid black;"
				
				</td>
			</tr>
			'.$PurchaseHTML.'
		</table>


';	
	
?>