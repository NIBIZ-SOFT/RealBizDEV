<?

//print_r($_REQUET);

$GetCategoryList=SQL_Select("Category","CategoryIsActive<>0");	
$i=0;
foreach($GetCategoryList as $ThisGetCategoryList){
	
	$HTMLCategory.='
		<div class="TopButton" style="float:left;padding:12px;" onclick="GetProductsListPOS('.$ThisGetCategoryList["CategoryID"].')">
			<img src="./upload/'.$ThisGetCategoryList["CategoryImage"].'" width="70" height="45"><br>
			'.LimitWords($ThisGetCategoryList["Name"],8).'
		</div>
		<div style="width:5px;float:left;">&nbsp;</div>
	
	';

}

echo $HTMLCategory;

?>