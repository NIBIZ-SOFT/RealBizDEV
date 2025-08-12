<?

	if($_REQUEST["Action"]=="Delete"){
		
		//echo $_POST["EditTempNumber"];
		SQL_Delete("SalesFund", "SalesFundID={$_REQUEST["SalesFundID"]}");
		echo ShowSalesFunding($_REQUEST["TempNumber"]);
		exit;
	}

	if($_REQUEST["Action"]=="Edit"){
		
		//echo $_POST["EditTempNumber"];
		echo ShowSalesFunding($_REQUEST["EditTempNumber"]);
		exit;
	}
	

	// when complete sales button clicked.
	if($_REQUEST["CompleteSales"]==True){
		
		if($_REQUEST["FormComboBoxCustomer"]!="")
			$CustomerID=$_REQUEST["FormComboBoxCustomer"];

		if($_REQUEST["NewCustomer"]!=""){
			$CustomerData=SQL_InsertUpdate(
				"Customer",
				$The_Entity_NameData=array(
					"CustomerName"=>$_REQUEST["NewCustomer"],
					"Phone"=>$_REQUEST["Phone"],

				),
				""
			);	
			
			$CustomerID=$CustomerData["CustomerID"];
			
		}
			
		
		$Data=SQL_InsertUpdate(
		
			"Sales",
			$The_Entity_NameData=array(
				"SalesIsActive"=>1,
				"CustomerID"=>$CustomerID,
				"Remarks"=>$_POST["Remarks"],
			),
			"TempNumber='{$_REQUEST["TempNumber"]}'"
			
		);	

		// Update Products Quantity
		$MySales=SQL_Select("SalesOrder","TempNumber='{$_REQUEST["TempNumber"]}'");
		foreach($MySales as $ThisMySales){
		
			UpdateProductQuantity($_REQUEST["TempNumber"],$ThisMySales["ProductID"]);
			
			// $ProductsQTY=SQL_Select("Products","ProductsID='{$ThisMySales["ProductID"]}'","","true");
			// $TotalCalculateQTY = $ProductsQTY["Quantity"] - $ThisMySales["Qty"];
			
			
			// SQL_InsertUpdate(
					// "Products",
					// $The_Entity_NameData=array(
						// "Quantity"=>$TotalCalculateQTY,
					// ),
					// "ProductsID={$ThisMySales["ProductID"]}"
			// );	
			
		}
		
		exit;
	
	}
	
	
	// this page is for Purchase
	
	if($_POST["Amount"]>0 and $_POST["GrandTotalPrice"]>0){

		//echo GetTotalSalesFund($_POST["TempNumber"]);
		//echo $_POST["TempNumber"];
		$TotalPaidAmount=$_POST["Amount"] + GetTotalSalesFund($_POST["TempNumber"]) + $_POST["Discount"];
		if($TotalPaidAmount>$_POST["GrandTotalPrice"]){
		
			echo '<span style="color:red;font-size:17px;">*Amount is bigger than Due Amount.';
			//exit;
		}else{
			if($_POST["PaymentMethod"]=="Cash")
				$FundDataList=SQL_InsertUpdate(
					"SalesFund",
					$The_Entity_NameData=array(
						"PaymentMethod"=>$_POST["PaymentMethod"],
						"Amount"=>$_POST["Amount"],
						"Discount"=>$_POST["Discount"],
						"TempNumber"=>$_POST["TempNumber"],
						"PaymentNote"=>$_POST["PaymentNote"],
					),
					""
				);		
			
			if($_POST["PaymentMethod"]=="Cheque")
				$FundDataList=SQL_InsertUpdate(
					"SalesFund",
					$The_Entity_NameData=array(
						"PaymentMethod"=>$_POST["PaymentMethod"],
						"Amount"=>$_POST["Amount"],
						"Discount"=>$_POST["Discount"],
						"BankName"=>$_POST["BankName"],
						"ChequeNumber"=>$_POST["ChequeNumber"],
						"DueDate"=>$_POST["DueDate"],
						"TempNumber"=>$_POST["TempNumber"],
						"PaymentNote"=>$_POST["PaymentNote"],
					),
					""
				);	
			}	
		

		echo ShowSalesFunding($_POST["TempNumber"]);
		
		
	}else{
	
		echo '<span style="color:red;font-size:17px;">*Amount or Product not set.';
		echo ShowSalesFunding($_POST["TempNumber"]);
	
	}
	

	
?>