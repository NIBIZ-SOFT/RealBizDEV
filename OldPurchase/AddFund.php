<?


	//GetTotalAmount($MyTempNumber)

	if($_REQUEST["Action"]=="Delete"){
		
		//echo $_POST["EditTempNumber"];
		SQL_Delete("Fund", "FundID={$_REQUEST["FundID"]}");
		echo ShowFunding($_REQUEST["TempNumber"]);
		exit;
	}

	if($_REQUEST["Action"]=="Edit"){
		
		//echo $_POST["EditTempNumber"];
		echo ShowFunding($_REQUEST["EditTempNumber"]);
		exit;
	}
	
		
	
	
	if($_REQUEST["CompletePurchase"]==True){
		
		$Data=SQL_InsertUpdate(
		
			"Purchase",
			$The_Entity_NameData=array(
				"PurchaseIsActive"=>1,
			),
			"TempNumber='{$_REQUEST["TempNumber"]}'"
			
		);	
		// now update the Latest Price and Qty
		$GetAllPurchaseList=SQL_Select("PurchasedProducts","TempNumber='{$_REQUEST["TempNumber"]}'");
		foreach($GetAllPurchaseList as $ThisGetAllPurchaseList){
			UpdateProductQuantity($_REQUEST["TempNumber"],$ThisGetAllPurchaseList["ProductID"]);
		}
		
		exit;
	
	}
	
	
	// this page is for Purchase
	
	if($_POST["Amount"]>0 and $_POST["GrandTotalPrice"]>0){

		$TotalPaidAmount=$_POST["Amount"] + GetTotalFund($_POST["TempNumber"]);
		if($TotalPaidAmount>$_POST["GrandTotalPrice"]){
		
			echo '<span style="color:red;font-size:17px;">*Amount is bigger than Due Amount.';
			//exit;
		}else{
			if($_POST["PaymentMethod"]=="Cash")
				$FundDataList=SQL_InsertUpdate(
					"Fund",
					$The_Entity_NameData=array(
						"PaymentMethod"=>$_POST["PaymentMethod"],
						"Amount"=>$_POST["Amount"],
						"TempNumber"=>$_POST["TempNumber"],
					),
					""
				);		
			
			if($_POST["PaymentMethod"]=="Cheque")
				$FundDataList=SQL_InsertUpdate(
					"Fund",
					$The_Entity_NameData=array(
						"PaymentMethod"=>$_POST["PaymentMethod"],
						"Amount"=>$_POST["Amount"],
						"BankName"=>$_POST["BankName"],
						"ChequeNumber"=>$_POST["ChequeNumber"],
						"DueDate"=>$_POST["DueDate"],
						"TempNumber"=>$_POST["TempNumber"],
					),
					""
				);	
			}	
		

		echo ShowFunding($_POST["TempNumber"]);
		
		
	}else{
	
		echo '<span style="color:red;font-size:17px;">*Amount or Product not set.';
		echo ShowFunding($_POST["TempNumber"]);
	
	}
	

	
	
?>