<?

	$GetCat=SQL_Select("Category","CategoryID={$_REQUEST["CID"]}","","True");
	
	
	$GetProducts=SQL_Select("Products","Category='{$GetCat["Name"]}'");

	
	$i=0;
	foreach($GetProducts as $ThisGetProducts){

		$HTML.='
			<div class="TopButton" style="float:left;padding:12px;" onclick="PlaceOrder('.$ThisGetProducts["ProductsID"].')">
				<img src="./upload/'.$ThisGetProducts["ProductsImage"].'" width="70" height="45"><br>
				'.LimitWords($ThisGetProducts["ProductName"],8).'
			</div>
			<div style="float:left;width:5px;">&nbsp;</div>
		
		';
		
		if($i==1){
			$i=0;
			$HTML1.='
				<div style="clear:both;height:5px;"></div>
			';	
		}	
		$i++;
	
	
			
	}
	
	//print_r($_REQUET);
	
	echo '
	
			
		<!--<div class="GreenButton" style="" onclick="GetCategoryListOnBack();">
			BACK
		</div>-->
		
		<div style="clear:both;height:5px;"></div>
	'.$HTML;

?>