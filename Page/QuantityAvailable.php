<?php 


	$_REQUEST["ProdID"];
	
	$Products=SQL_Select("Products","ProductsID='{$_REQUEST["ProdID"]}'","","true");
	$_REQUEST["Quantity"];
	$Products["Quantity"];
	if($Products["Quantity"]>$_REQUEST["Quantity"]){
		echo "1";
	
	}else{
		echo "0";
	
	}
	exit();

?>