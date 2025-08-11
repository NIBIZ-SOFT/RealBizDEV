<?


if($_REQUEST["Category_ID"]!="0"){
	
	$ProductsCategory= SQL_Select("Category","CategoryID={$_REQUEST["Category_ID"]} order by Name Asc");
	
}else
	$ProductsCategory= SQL_Select("Category","1=1 order by Name Asc");
	
	
	$WareHouse =  SQL_Select("WareHouse","WareHouseID={$_REQUEST["WareHouseID"]}","",True);	

foreach ($ProductsCategory as $ThisProductsCategory){
	$Products= SQL_Select("Products","Category='{$ThisProductsCategory["Name"]}' order by ProductName Asc");

	$i=1;
	$HTML.='
		<tr bgcolor="#A2D0E7">
			<td style="border : 1px solid black;" colspan="5">
				&nbsp;'.$ThisProductsCategory["Name"].'.
			</td>
		</tr>		
	
	';
	foreach($Products as $ThisProducts){
		$resultPurchase = mysql_query("select SUM(Qty) as Total from tblpurchasedproducts where ProductID='{$ThisProducts["ProductsID"]}' and WareHouseID='{$_REQUEST["WareHouseID"]}'");
		$rowPurchase = @mysql_fetch_array($resultPurchase, MYSQL_ASSOC);
		///echo $rowPurchase["Total"];
		
		$resultSales = mysql_query("select SUM(Qty) as Total from tblsalesorder where ProductID='{$ThisProducts["ProductsID"]}' and WareHouseID='{$_REQUEST["WareHouseID"]}'");
		$rowSales = @mysql_fetch_array($resultSales, MYSQL_ASSOC);
		
		$AvailableQTY = $rowPurchase["Total"] - $rowSales["Total"];
		
		$HTML.='
			<tr>
				<td style="border : 1px solid black;">
					&nbsp;'.$i.'.
				</td>
				<td style="border : 1px solid black;">
					&nbsp;'.$ThisProducts["ProductName"].'<br>
					
				</td>
				<td style="border : 1px solid black;">
					&nbsp;'.$AvailableQTY.'
				</td>
				<td style="border : 1px solid black;">
					&nbsp;'.$ThisProducts["PurchaseLatestPrice"].'
				</td>
				<td style="border : 1px solid black;">
					&nbsp;'.$ThisProducts["SellingPrice"].'
				</td>
			</tr>		
		
		';
		
		$i++;
		
	}
}

$GetCompanyInfo=SQL_Select("Settings","SettingsID=1","","true");
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

$MainContent.='
	<title>PRODUCT STOCK</title>
	<center>
	'.$CompanyPad.'
	<h1>PRODUCT STOCK</h1>
	<span style="font-size:20px;">Warehouse : '.$WareHouse["Name"].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date : '.date("M d Y").'</span><br>
	<table border=0 width="800" style="border : 0px solid black;">
		<tr>
			<td width="45" align="center" style="border : 1px solid black;">
				SL
			</td>
			<td align="center" style="border : 1px solid black;">
				Item Name
			</td>
			<td align="center" style="border : 1px solid black;">
				Qty
			</td>
			<td align="center" style="border : 1px solid black;">
				Cost Price
			</td>
			<td align="center" style="border : 1px solid black;">
				Selling Price
			</td>
		</tr>
		'.$HTML.'
	</table>
		<p><br>
		<hr>
		<div sytle="clear:both;"></div>
		<div class="footer" style="font-size:10px;">
			Powered by : N I Biz Soft
		</div>	
		
	</center>
	
			

';

?>