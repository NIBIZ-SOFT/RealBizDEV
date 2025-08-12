<?

	$GetCat=SQL_Select("Category","CategoryID={$_REQUEST["CID"]}","","True");
	
	
	$GetProducts=SQL_Select("Products","Category='{$GetCat["Name"]}' order by ProductName ASC");
	$HTML.='
		<select name="ProductID" style=" width:200px;" id="ProductID">
	';	
	foreach($GetProducts as $ThisGetProducts){
		
		$HTML.='
			<option value="'.$ThisGetProducts["ProductsID"].'">'.$ThisGetProducts["ProductName"].'</option>		
		';
			
	}
	
	$HTML.='
		</select>
	';
	
	echo $HTML;

?>