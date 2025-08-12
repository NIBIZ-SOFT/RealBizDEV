<?
	
	// Edit Mood.
		//echo $_REQUEST["EditTempNumber"];	
	if($_REQUEST["Action"]=="Delete"){
		
		//echo $_POST["EditTempNumber"];
		SQL_Delete("PurchasedProducts", "PurchasedProductsID={$_REQUEST["PurchasedProductsID"]}");
		echo UpdatePurchaseRecord($_REQUEST["TempNumber"]);
		exit;
	}
	
	// Updte warehouse if changed
	if($_REQUEST["Action"]=="WareHouse"){
		
		SQL_InsertUpdate(
			"Purchase",
			$The_Entity_NameData=array(
				"WareHouseID"=>$_REQUEST["WareHouseID"],
				
			),
			"TempNumber='{$_REQUEST["TempNumber"]}'"
			
		);	
		SQL_InsertUpdate(
			"PurchasedProducts",
			$The_Entity_NameData=array(
				"WareHouseID"=>$_REQUEST["WareHouseID"],
				
			),
			"TempNumber='{$_REQUEST["TempNumber"]}'"
			
		);	

		exit;
	}
	
	
	if($_REQUEST["Action"]=="Edit"){
		
		//echo $_POST["EditTempNumber"];
		echo UpdatePurchaseRecord($_REQUEST["EditTempNumber"]);
		exit;
	}
	
	
	
	// update mode for cost and quantity
	
	if($_REQUEST["TempNumberFromCost"]!=""){
	
		$PurchasedProducts=SQL_InsertUpdate(
			"PurchasedProducts",
			$The_Entity_NameData=array(
				"CostPerProduct"=>$_REQUEST["Cost"],
				"Qty"=>$_REQUEST["Qty"],
				"Serials"=>$_REQUEST["Serials"],
				
			),
			"TempNumber='{$_REQUEST["TempNumberFromCost"]}' and ProductID='{$_REQUEST["PID"]}'"
			
		);		
		
		echo UpdatePurchaseRecord($_REQUEST["TempNumberFromCost"]);
		
		
	}
	
	
	// this page is for Purchase
	
	if($_REQUEST["TempNumber"]!=""){
		$IsExist=SQL_Select("Purchase","TempNumber='{$_REQUEST["TempNumber"]}'");
		//echo count($IsExist);
		if(count($IsExist)==0){
			$Data=SQL_InsertUpdate(
			
				"Purchase",
				$The_Entity_NameData=array(
					"PurchaseName"=>$_POST["PurchaseName"],
					"WareHouseID"=>$_POST["WareHouseID"],
					"VendorID"=>$_POST["Vendor"],
					"TempNumber"=>$_POST["TempNumber"],
					"PurchaseIsActive"=>0,
				),
				""
				
			);
		}// end of if
		
		
		
		// insert Products NOW
		$PurchasedProductsDate=SQL_Select("PurchasedProducts","TempNumber='{$_POST["TempNumber"]}' and ProductID='{$_REQUEST["ProductID"]}'","","True");

		$Where="";
		$Qty=1;
		if(count($PurchasedProductsDate)>1){
			$Where="TempNumber='{$_POST["TempNumber"]}' and ProductID='{$_POST["ProductID"]}'";
			$Qty= $Qty + $PurchasedProductsDate["Qty"];
		}
		
		$PurchasedProducts=SQL_InsertUpdate(
			"PurchasedProducts",
			$The_Entity_NameData=array(
				"ProductID"=>$_POST["ProductID"],
				"WareHouseID"=>$_POST["WareHouseID"],
				"VendorID"=>$_POST["Vendor"],
				"TempNumber"=>$_POST["TempNumber"],
				"Qty"=>$Qty,
			),
			$Where
			
		);		
		

		echo UpdatePurchaseRecord($_POST["TempNumber"]);
		
		
	}
	

	
	function UpdatePurchaseRecord($MyTempNumber){
	
		$GrandTotal=0;
		$PurchasedProductsDate=SQL_Select("PurchasedProducts","TempNumber='{$MyTempNumber}' order by PurchasedProductsID DESC","");		
		//echo count($PurchasedProductsDate).$MyTempNumber;
		$i=0;
		foreach($PurchasedProductsDate as $ThisPurchasedProductsDate){
			if($i%2==0)
				$BgColor="E7F5F8";
			else
				$BgColor="EBEAD8";
			
			$HTML.='
			
				<TR bgcolor="#'.$BgColor.'">
					<TD width="70" align="center" style="color:red;cursor:pointer;" onclick="DeletePurchase('.$ThisPurchasedProductsDate["PurchasedProductsID"].',\''.$MyTempNumber.'\');">Delete</TD>
					<TD style="color:#000;">
						'.GetProductCategoryName($ThisPurchasedProductsDate["ProductID"]).' - 
						'.GetProductName($ThisPurchasedProductsDate["ProductID"]).'
						
						<!--
						<textarea id="Serials_'.$ThisPurchasedProductsDate["ProductID"].'" row="30" col ="70">'.nl2br($ThisPurchasedProductsDate["Serials"]).'</textarea>
						-->
					</TD>
					<TD style="color:#000;" width="100"><input onchange="CalculatePurchase(\''.$MyTempNumber.'\',\''.$ThisPurchasedProductsDate["ProductID"].'\')" style="width:60px;"  size="10" type="text" id="Cost_'.$ThisPurchasedProductsDate["ProductID"].'" value="'.$ThisPurchasedProductsDate["CostPerProduct"].'"> x </TD>
					<TD width="40"><input onchange="CalculatePurchase(\''.$MyTempNumber.'\',\''.$ThisPurchasedProductsDate["ProductID"].'\')"   style="width:35px;"  type="text" id="Qty_'.$ThisPurchasedProductsDate["ProductID"].'" value="'.$ThisPurchasedProductsDate["Qty"].'"></TD>
					<TD style="color:#000;" width="85" align="right"> '.$ThisPurchasedProductsDate["Qty"]*$ThisPurchasedProductsDate["CostPerProduct"].' /= </TD>
				</TR>				
			
			';
			
			$GrandTotal = $ThisPurchasedProductsDate["Qty"]*$ThisPurchasedProductsDate["CostPerProduct"] + $GrandTotal;
			
			$i++;
		}
		
		$HTML_First='
				<TABLE id="dataTable" width="100%" border="0">
					<TR>
						<TD></TD>
						<TD> Product\'s Name </TD>
						<TD> Cost </TD>
						<TD> Qty </TD>
						<TD> Total </TD>
					</TR>	
					'.$HTML.'
					<TR>
						<TD colspan="5" align="right">
							<span style="color:blue;font-size:25px;">Grand Total : <u>'.$GrandTotal.' /=</u></span> 
							<input type="hidden" id="GrandTotal" value="'.$GrandTotal.'">
						</TD>
					</TR>	
					
				</table>
		';	
			
		return $HTML_First;	
		
	}
	
	
	
	
	
?>