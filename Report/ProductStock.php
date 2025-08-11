<?


	$ProductsCategory= SQL_Select("Category","1=1 order by Name Asc");

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
		
		$TotalValue = $ThisProducts["SellingPrice"] * $ThisProducts["Quantity"];
		$HTML.='
			<tr>
				<td style="border : 1px solid black;">
					&nbsp;'.$i.'.
				</td>
				<td style="border : 1px solid black;">
					&nbsp;'.$ThisProducts["ProductName"].'<br>
					
				</td>
				<td style="border : 1px solid black;">
					&nbsp;'.$ThisProducts["Quantity"].'
				</td>
				<td style="border : 1px solid black;">
					&nbsp;'.$ThisProducts["SellingPrice"].'
				</td>
				<td style="border : 1px solid black;">
					&nbsp;'.$TotalValue.'
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
	<span style="font-size:20px;">Warehouse : All &nbsp;&nbsp;&nbsp;Date : '.date("M d Y").'</span><br>
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
				Selling Price
			</td>
			<td align="center" style="border : 1px solid black;">
				Total Value
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