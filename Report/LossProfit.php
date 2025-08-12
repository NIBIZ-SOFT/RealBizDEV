<?
	
//GetPermission("OptionReport");		
/* 
$result = mysql_query("
	select sum(CostPerProduct) as Cost from tblpurchasedproducts where DateInserted between '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}'
	and TempNumber in ( Select TempNumber from tblpurchase where PurchaseIsActive=1 )
");
$TotalPurchasedQTY = @mysql_fetch_array($result, MYSQL_ASSOC);

$result = mysql_query("
	select sum(Amount) as Cost, sum(Discount) as Discount from tblsalesfund where DateInserted between '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}'
	and TempNumber in ( Select TempNumber from tblsales where SalesIsActive=1 )
");
$TotalSalesOrderQTY = @mysql_fetch_array($result, MYSQL_ASSOC);



$GetTotalSoldInRealPrice=SQL_Select("Sales"," SalesIsActive=1 and DateInserted between '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}'");



$TotalProfit = $TotalPurchasedQTY["Cost"] - $TotalSalesOrderQTY["Cost"];


if($PurchaseHTML=="")
	$PurchaseHTML='<br><br>No record found.';
$MainContent.='

	<div style="width:800px;padding:10px;">

		<fieldset>
			<legend>Loss Profit Report</legend>
				Total Purchase : '.$TotalPurchasedQTY["Cost"].'<br>
				Total Sales : '.$TotalSalesOrderQTY["Cost"].'<br>
				Total Discount : '.$TotalSalesOrderQTY["Discount"].'<br>
				----------------------------------------------------<br>
				Total Profit : '.$TotalProfit.'
				
		</fieldset>

	</div>
';	
 */

	$result = mysql_query("select * from tblsalesorder where 
		 TempNumber in ( Select TempNumber from tblsales where SalesIsActive=1 )");

	$result = mysql_query("select * from tblsalesorder where 
		 TempNumber in ( Select TempNumber from tblsales where SalesIsActive=1 and DateInserted between '{$_REQUEST["FromDateLossProfit"]}' and '{$_REQUEST["ToDateLossProfit"]}' )");
	//$row = @mysql_fetch_array($result, MYSQL_ASSOC);
	$i=1;
	$TotalSelling=$TotalCosting=0;
	while ($row = mysql_fetch_assoc($result)) {
		$Selling = $row["Price"]*$row["Qty"];
		$Costing = GetProductsLastPurchasePrice($row["ProductID"])*$row["Qty"];
		$Profit = $Selling - $Costing;
		
		$TotalSelling = $Selling + $TotalSelling;
		$TotalCosting = $Costing + $TotalCosting;
		$TotalProfit = $TotalSelling - $TotalCosting;
		
		$HTML.='
			<tr>
				<td width="45" align="center" style="border : 1px solid black;">
					'.$i.'
				</td>
				<td align="left" style="border : 1px solid black;">
					'.GetProductName($row["ProductID"]).'
				</td>
				<td align="right" style="border : 1px solid black;">
					'.GetProductsLastPurchasePrice($row["ProductID"]).'x'.$row["Qty"].' = '.$Costing.'&nbsp;
				</td>
				<td align="center" style="border : 1px solid black;">
					'.$row["Price"].'x'.$row["Qty"].' = '.$Selling.'&nbsp;
				</td>
				<td align="right" style="border : 1px solid black;">
					'.$Profit.'&nbsp;
				</td>
			</tr>		
		
		';	
		$i++;

	}
	

$MainContent.='
	<title>Loss Profit Report</title>
	<center>
	<h1>Loss Profit Report</h1>
	<div style="font-size:20px;float:right;width:830px;">Date : '.$_REQUEST["FromDateLossProfit"].' to '.$_REQUEST["ToDateLossProfit"].'</div><br>
	<table border=0 width="800" style="border : 0px solid black;">
		<tr>
			<td width="45" align="center" style="border : 1px solid black;">
				SL
			</td>
			<td align="center" style="border : 1px solid black;">
				Item Name
			</td>
			<td align="center" style="border : 1px solid black;">
				Costing
			</td>
			<td align="center" style="border : 1px solid black;">
				Selling
			</td>
			<td align="center" style="border : 1px solid black;">
				Profit
			</td>
		</tr>
		'.$HTML.'
		<tr>
			<td width="45" align="center" style="border : 0px solid black;">
				
			</td>
			<td align="right" style="border : 1px solid black;">
				<b>Total</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Tk. '.$TotalCosting.'</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Tk. '.$TotalSelling.'</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Tk. '.$TotalProfit.'</b>
			</td>
		</tr>
	</table>

		
	</center>
	
			

';
	
?>