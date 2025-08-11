<?
	
//GetPermission("OptionReport");		


	//$result = mysql_query("select * from tblsalesorder where 
	//	 TempNumber in ( Select TempNumber from tblsales where SalesIsActive=1 ) order by SalesOrderID DESC limit 10");
	//echo "select * from tblsalesorder where 
	//		 TempNumber in ( Select TempNumber from tblsales where SalesIsActive=1 and DateInserted between '{$_REQUEST["FromDateReport"]}' and '{$_REQUEST["ToDateReport"]}' )";
	/*
	exit;		 
	if($_REQUEST["FromDateReport"]!="" or $_REQUEST["ToDateReport"]!=""){
		$result = mysql_query("select * from tblsalesorder where 
			 TempNumber in ( Select TempNumber from tblsales where SalesIsActive=1 and DateInserted between '{$_REQUEST["FromDateReport"]}' and '{$_REQUEST["ToDateReport"]}' )");
	}else{
		echo "Please choose Date";
		exit;
	
	}
	*/
	//$row = @mysql_fetch_array($result, MYSQL_ASSOC);
	$i=1;
	$TotalSelling=$TotalCosting=0;

	if($_REQUEST["WareHouseID"]!=""){
		$WareHouseSQL = " WareHouseID = '{$_REQUEST["WareHouseID"]}' and";	
		
	}	
	
	$GetActiveSalesOrder = mysql_query("Select TempNumber from tblsales where {$WareHouseSQL} SalesIsActive=1 and DateInserted between '{$_REQUEST["FromDateReport"]}' and '{$_REQUEST["ToDateReport"]}'");
	while ($row_GetActiveSalesOrder = mysql_fetch_assoc($GetActiveSalesOrder)) {
	
		$result = mysql_query("select * from tblsalesorder where TempNumber = '{$row_GetActiveSalesOrder["TempNumber"]}'");
		while ($row = mysql_fetch_assoc($result)) {
			$Selling = $row["Price"]*$row["Qty"];
			$Costing = GetProductsLastPurchasePrice($row["ProductID"])*$row["Qty"];
			$Profit = $Selling - $Costing;
			
			$TotalSelling = $Selling + $TotalSelling;
			$TotalCosting = $Costing + $TotalCosting;
			$TotalProfit = $TotalSelling - $TotalCosting;
			$IsQTYAvailable=SQL_Select("Products","ProductsID='{$row["ProductID"]}'","","True");
			
			
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
					<td align="right" style="border : 1px solid black;">
						'.$IsQTYAvailable["Quantity"].'&nbsp;
					</td>
				</tr>		
			
			';	
			$i++;

		}
	}	

	
	
$MainContent.='
	<title>Overall Report</title>
	<center>
	<h1>Loss Profit Report</h1>
	
	<div style="font-size:20px;width:830px;margin: auto 0px;">Warehouse : '.GetWareHouseName($_REQUEST["WareHouseID"]).' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date : '.$_REQUEST["FromDateReport"].' to '.$_REQUEST["ToDateReport"].'</div>
	
	<table border=0 width="800" style="border : 0px solid black;" align="center">
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
			<td align="center" style="border : 1px solid black;">
				Stock
			</td>
		</tr>
		'.$HTML.'
		<tr>
			<td width="45" align="center" style="border : 0px solid black;">
				
			</td>
			<td align="right" style="border : 1px solid black;">
				<b>Total&nbsp;</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Tk. '.$TotalCosting.'/=</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Tk. '.$TotalSelling.'/=</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Tk. '.$TotalProfit.'/=</b>
			</td>
		</tr>
	</table>

		
	</center>
	
			

';
	
?>