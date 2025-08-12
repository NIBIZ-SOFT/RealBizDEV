<?

if($_POST["TempNumber"]!=""){

	$SalesOrder =  SQL_Select("PurchasedProducts","TempNumber='{$_POST["TempNumber"]}'","");
	foreach($SalesOrder as $ThisSalesOrder){
	
		if($_POST["ReturnQty_{$ThisSalesOrder["ProductID"]}"] == $ThisSalesOrder["Qty"])
			SQL_Delete("PurchasedProducts", "TempNumber='{$_POST["TempNumber"]}' and ProductID='{$ThisSalesOrder["ProductID"]}'");
		else{
			$GetRecentQTY = SQL_Select("PurchasedProducts","TempNumber='{$_POST["TempNumber"]}' and ProductID='{$ThisSalesOrder["ProductID"]}'","",true);
			$_POST["ReturnQty_{$ThisSalesOrder["ProductID"]}"] = $GetRecentQTY["Qty"] - $_POST["ReturnQty_{$ThisSalesOrder["ProductID"]}"];
			SQL_InsertUpdate(
				"PurchasedProducts",
				$The_Entity_NameData=array(
					"Qty"=>$_POST["ReturnQty_{$ThisSalesOrder["ProductID"]}"],
				),
				"TempNumber='{$_POST["TempNumber"]}' and ProductID='{$ThisSalesOrder["ProductID"]}'"
			);
		
		}

		// Record Refund
		
		SQL_InsertUpdate(
			"PurchaseRefund",
			$The_Entity_NameData=array(
				"TempNumber"=>$_POST["TempNumber"],
				"ProductID"=>$ThisSalesOrder["ProductID"],
				"Qty"=>$_POST["ReturnQty_{$ThisSalesOrder["ProductID"]}"],
				"Price"=>$ThisSalesOrder["CostPerProduct"],
				"Reason"=>$_POST["Note_{$ThisSalesOrder["ProductID"]}"],
			),
			""
		);
		
		// update Product Quantity
		UpdateProductQuantity($_POST["TempNumber"],$ThisSalesOrder["ProductID"]);
	}
			

	echo '
		<script>
			alert("Refund DONE");
			window.location = \''.ApplicationURL("Purchase","PurchaseReturn").'\'
		</script>
	
	';

}	



	
?>