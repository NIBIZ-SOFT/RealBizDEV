<?php 


	$_REQUEST["ProdID"];
	$_REQUEST["Price"];
	
	$Products=SQL_Select("Products","ProductsID='{$_REQUEST["ProdID"]}'","","true");
	
	$Products["SellingPrice"];
	if($Products["SellingPrice"]>$_REQUEST["Price"]){
		echo "0";
	
	}else{
		echo "1";
	
	}
	exit();

?>