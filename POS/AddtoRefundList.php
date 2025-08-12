<?

if($_POST["TempNumber"]!=""){

	$SalesOrder =  SQL_Select("SalesOrder","TempNumber='{$_POST["TempNumber"]}'","");
	foreach($SalesOrder as $ThisSalesOrder){
	
		if($_POST["ReturnQty_{$ThisSalesOrder["ProductID"]}"] == $ThisSalesOrder["Qty"])
			SQL_Delete("SalesOrder", "TempNumber='{$_POST["TempNumber"]}' and ProductID='{$ThisSalesOrder["ProductID"]}'");
		else{
			
			$GetRecentQTY = SQL_Select("SalesOrder","TempNumber='{$_POST["TempNumber"]}' and ProductID='{$ThisSalesOrder["ProductID"]}'","",true);
			$_POST["ReturnQty_{$ThisSalesOrder["ProductID"]}"] = $GetRecentQTY["Qty"] - $_POST["ReturnQty_{$ThisSalesOrder["ProductID"]}"];
			
			SQL_InsertUpdate(
				"SalesOrder",
				$The_Entity_NameData=array(
					"Qty"=>$_POST["ReturnQty_{$ThisSalesOrder["ProductID"]}"],
				),
				"TempNumber='{$_POST["TempNumber"]}' and ProductID='{$ThisSalesOrder["ProductID"]}'"
			);
		
		}

		// Record Refund	
		SQL_InsertUpdate(
			"Refund",
			$The_Entity_NameData=array(
				"TempNumber"=>$_POST["TempNumber"],
				"ProductID"=>$ThisSalesOrder["ProductID"],
				"Qty"=>$_POST["ReturnQty_{$ThisSalesOrder["ProductID"]}"],
				"Price"=>$ThisSalesOrder["Price"],
				"Reason"=>$_POST["Note_{$ThisSalesOrder["ProductID"]}"],
			),
			""
		);
		
		// update Product Quantity
		UpdateProductQuantity($_POST["TempNumber"],$ThisSalesOrder["ProductID"]);
	}
			

}	



	
?>