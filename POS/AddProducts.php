<?


	// if barcode submitted
	
	if($_REQUEST["Barcode"]!=""){
		
		$GetProductsDetails = SQL_Select("Products","Barcode='{$_REQUEST["Barcode"]}'","",true);
		

		$_POST["ProductID"]=$_REQUEST["ProductID"] = $GetProductsDetails["ProductsID"];
		$_POST["Category_ID"]=$_REQUEST["Category_ID"] = $GetProductsDetails["CategoryID"];
		
		
		
	}
	
	
	
	
	
	

	$j=1;
	
	// Serial Number show in the Sales pages. which are added by
	if($_REQUEST["Action"]=="SerialsNumber"){
		
		$GetrecentSerials=SQL_Select("SalesOrder","TempNumber='{$_REQUEST["TempNumber"]}' and ProductID='{$_REQUEST["ProductID"]}'","","True");
		//echo $GetrecentSerials["Serials"];
		$SerialSeparation=explode(",",$GetrecentSerials["Serials"]);
		//sa($_REQUEST);
		//sa($SerialSeparation);
		// if delete 
		if($_REQUEST["Delete"]=="Yes"){
			foreach($SerialSeparation as $ThisSerialSeparation){	
				//echo $ThisSerialSeparation."--{$_REQUEST["SerialNumber"]}";
				if($ThisSerialSeparation!="{$_REQUEST["SerialNumber"]}")
					$NewSerial.=$ThisSerialSeparation.",";
			
			}
			$NewSerial = substr($NewSerial, 0, -1); // f
			$SalesProduct=SQL_InsertUpdate(
				"SalesOrder",
				$The_Entity_NameData=array(
					"Serials"=>$NewSerial,
				
				),
				"TempNumber='{$_REQUEST["TempNumber"]}' and ProductID='{$_REQUEST["ProductID"]}'",
				flase
				
			);	
			
			$Serial_Separation=explode(",",$NewSerial);
			//$i=0;
			foreach($Serial_Separation as $ThisSerial_Separation){
				
				
				$TempNumber=randomkeys(8);
				// find out sold Serial Number.
					$SHTML.='
						<div style="float:left;cursor:pointer;" onclick="DeleteSerial(\''.$_REQUEST["ProductID"].'\',\''.$_REQUEST["TempNumber"].'\',\''.$TempNumber.'\')">
							<input type="hidden"  id="SerialHTML_'.$TempNumber.'" value="'.$ThisSerial_Separation.'" >
							'.$ThisSerial_Separation.',
						</div>
					';
				$j++;
			}
			
			echo $SHTML."<br>";
			exit;			
			
			
		}// End of delete option.
		
		
		if (in_array($_REQUEST["SerialNumber"], $SerialSeparation)){
			$_REQUEST["SerialNumber"]=$GetrecentSerials["Serials"];
		}else{
			if($GetrecentSerials["Serials"]!="")
				$_REQUEST["SerialNumber"]=$GetrecentSerials["Serials"].",".$_REQUEST["SerialNumber"];
				
				$SalesProduct=SQL_InsertUpdate(
					"SalesOrder",
					$The_Entity_NameData=array(
						"Serials"=>$_REQUEST["SerialNumber"],
					
					),
					"TempNumber='{$_REQUEST["TempNumber"]}' and ProductID='{$_REQUEST["ProductID"]}'",
					flase
					
				);			
		}// else end.	
			//echo $_POST["EditTempNumber"];
		//print_r($SalesProduct);
		
		$Serial_Separation=explode(",",$_REQUEST["SerialNumber"]);
		//$i=0;
		foreach($Serial_Separation as $ThisSerial_Separation){
			$TempNumber=randomkeys(8);
			$SHTML.='
			
					<div style="float:left;cursor:pointer;" onclick="DeleteSerial(\''.$_REQUEST["ProductID"].'\',\''.$_REQUEST["TempNumber"].'\',\''.$TempNumber.'\')">
						<input type="hidden"  id="SerialHTML_'.$TempNumber.'" value="'.$ThisSerial_Separation.'" >
						'.$ThisSerial_Separation.',
					</div>
					
			';
			$j++;
		}
		
		echo $SHTML."<br>";
		exit;
	}
	

	if($_REQUEST["Action"]=="Delete"){
		
		//echo $_POST["EditTempNumber"];
		SQL_Delete("SalesOrder", "SalesOrderID={$_REQUEST["SalesOrderID"]}");
		echo UpdateSalesOrderRecord($_REQUEST["TempNumber"]);
		exit;
	}
	


	if($_REQUEST["Action"]=="Edit"){
		
		//echo $_POST["EditTempNumber"];
		echo UpdateSalesOrderRecord($_REQUEST["EditTempNumber"]);
		exit;
	}
	
	


	
	if($_REQUEST["TempNumberFromCost"]!=""){
	

		// if quantity available
		$IsQTYAvailable=SQL_Select("Products","ProductsID='{$_REQUEST["PID"]}'","","True");
		// for Qty Checking
		if($_REQUEST["Qty"]>$IsQTYAvailable["Quantity"]){
		
			echo "
				<div style='float:right;color:red;'>
					{$_REQUEST["Qty"]} Qty for {$IsQTYAvailable["ProductName"]} Not Available.<br>
				</div>
				<div style='clear:both;'></div>
			";
			echo UpdateSalesOrderRecord($_REQUEST["TempNumberFromCost"]);
			exit;
		}	
		
		// For Pricing Checking.
		if($_REQUEST["Cost"] < $IsQTYAvailable["PurchaseLatestPrice"]){
		
			echo "
				<div style='float:right;color:red;'>
					{$_REQUEST["Cost"]} Price for {$IsQTYAvailable["ProductName"]} is Not Acceptable.<br>
				</div>
				<div style='clear:both;'></div>
			";
			echo UpdateSalesOrderRecord($_REQUEST["TempNumberFromCost"]);
			exit;
		}	
	
		if($_REQUEST["Serials"]=="undefined")
			$_REQUEST["Serials"]="";
			
		$PurchasedProducts=SQL_InsertUpdate(
			"SalesOrder",
			$The_Entity_NameData=array(
				"Price"=>$_REQUEST["Cost"],
				"Qty"=>$_REQUEST["Qty"],
				"WareHouseID"=>$_REQUEST["WareHouseID"],
				"Warranty"=>$_REQUEST["WarrantyTime"]." ".$_REQUEST["Warranty"],
			),
			"TempNumber='{$_REQUEST["TempNumberFromCost"]}' and ProductID='{$_REQUEST["PID"]}'"
			
		);		
		
		echo UpdateSalesOrderRecord($_REQUEST["TempNumberFromCost"]);
		
		
	}
	

	if($_REQUEST["TempNumber"]!=""){
		
		
		$PurchasedProductsDate=SQL_Select("SalesOrder","TempNumber='{$_POST["TempNumber"]}' and ProductID='{$_REQUEST["ProductID"]}'","","True");

		$Where="";
		$Qty=1;
		if(count($PurchasedProductsDate)>1){
			$Where="TempNumber='{$_POST["TempNumber"]}' and ProductID='{$_POST["ProductID"]}'";
			$Qty= $Qty + $PurchasedProductsDate["Qty"];
		}
		
		// if quantity available
		$IsQTYAvailable=SQL_Select("Products","ProductsID='{$_POST["ProductID"]}'","","True");
		if($Qty>$IsQTYAvailable["Quantity"]){
		
			echo "
				<div style='float:right;color:red;'>
					{$Qty} Qty for {$IsQTYAvailable["ProductName"]} Not Available.<br>
				</div>
				<div style='clear:both;'></div>
			";
			echo UpdateSalesOrderRecord($_POST["TempNumber"]);
			exit;
		}
		
		//$GetProductsPrice=SQL_Select("Products","ProductsID='{$_POST["ProductID"]}'","","True");
		$IsExist=SQL_Select("Sales","TempNumber='{$_REQUEST["TempNumber"]}'");
		//echo count($IsExist);
		if(count($IsExist)==0){
			$Data=SQL_InsertUpdate(
			
				"Sales",
				$The_Entity_NameData=array(
					"CustomerID"=>$_POST["CustomerID"],
					"TempNumber"=>$_POST["TempNumber"],
					"Remarks"=>$_POST["Remarks"],
					"WareHouseID"=>$_POST["WareHouseID"],
					"SalesBy"=>$_SESSION["UserID"],
					"SalesIsActive"=>0,
				),
				""
				
			);
		}// end of if
		
		
		
		// insert Products NOW
		//print_r($_POST);
		$PurchasedProducts=SQL_InsertUpdate(
			"SalesOrder",
			$The_Entity_NameData=array(
				"Price"=>$IsQTYAvailable["PurchaseLatestPrice"],
				"ProductID"=>$_POST["ProductID"],
				"WareHouseID"=>$_POST["WareHouseID"],
				"TempNumber"=>$_POST["TempNumber"],
				"Qty"=>$Qty,
			),
			$Where
			
		);		
		//"Warranty"=>$_POST["WarrantyTime"]." ".$_POST["Warranty"],
		

		echo UpdateSalesOrderRecord($_POST["TempNumber"]);
		
		
	}
	

	
	function UpdateSalesOrderRecord($MyTempNumber){
		$GrandTotal=0;
		//$PurchasedProductsDate=SQL_Select("SalesOrder","TempNumber='{$MyTempNumber}' order by SalesOrderID DESC","");		
		$i=0;
		
		$sql = "
			SELECT * 
			FROM   tblsalesorder
			WHERE  TempNumber='{$MyTempNumber}' order by SalesOrderID DESC
		";

		$result = mysql_query($sql);	
		
		while ($ThisPurchasedProductsDate = mysql_fetch_assoc($result)) {
		//foreach($PurchasedProductsDate as $ThisPurchasedProductsDate){
			if($i%2==0)
				$BgColor="E7F5F8";
			else
				$BgColor="EBEAD8";
			//echo $ThisPurchasedProductsDate["Price"];	
			//if($ThisPurchasedProductsDate["Price"]=="")	
			//	$ThisPurchasedProductsDate["Price"] = GetProductsLastPurchasePrice($ThisPurchasedProductsDate["ProductID"]);

			// this is Serial Part Fetching Section	
			$SHTML="";
		
			$GetProductPrice=GetProductPrice($ThisPurchasedProductsDate["ProductID"]);	
			$HTML.='
			
				<TR bgcolor="#'.$BgColor.'">
					<TD width="50" align="center" style="color:red;cursor:pointer;" onclick="DeleteProducts('.$ThisPurchasedProductsDate["SalesOrderID"].',\''.$MyTempNumber.'\')">Delete</TD>
					<TD style="color:#000;">
						'.GetProductCategoryName($ThisPurchasedProductsDate["ProductID"]).' - 
						'.GetProductName($ThisPurchasedProductsDate["ProductID"]).'
					
												
					</TD>
					<TD style="color:#000;" width="70" align="center">
						<input onchange="CalculateSalesOrderPOS(\''.$MyTempNumber.'\',\''.$ThisPurchasedProductsDate["ProductID"].'\')"  style="width:30px;"   type="text" name="Cost"  id="Cost_'.$ThisPurchasedProductsDate["ProductID"].'" value="'.$GetProductPrice.'">
						
					</TD>
					<TD width="40">
						
						<input onchange="CalculateSalesOrderPOS(\''.$MyTempNumber.'\',\''.$ThisPurchasedProductsDate["ProductID"].'\')"  size="2" type="text" style="width:30px;"  id="Qty_'.$ThisPurchasedProductsDate["ProductID"].'" value="'.$ThisPurchasedProductsDate["Qty"].'">
						
					</TD>
					
					<TD width="40">
						<input onchange="CalculateSalesOrder(\''.$MyTempNumber.'\',\''.$ThisPurchasedProductsDate["ProductID"].'\')"  type="text" id="Warranty_'.$ThisPurchasedProductsDate["ProductID"].'" value="'.$ThisPurchasedProductsDate["Warranty"].'" style="width:30px;" >

					</TD>
					
					<TD style="color:#000;" width="65" align="right"> '.$ThisPurchasedProductsDate["Qty"]*$GetProductPrice.' /= </TD>
				</TR>				
			
			';
			
			$GrandTotal = $ThisPurchasedProductsDate["Qty"]*$GetProductPrice + $GrandTotal;
			
			$i++;
		}
		
		//'.GetProductsSerial($ThisPurchasedProductsDate["ProductID"],$ThisPurchasedProductsDate["Serials"],$MyTempNumber).'
		
		$HTML_First='
		

		
				<TABLE id="dataTable" width="100%" border="0">
					<TR>
						<TD></TD>
						<TD align="center"> Product\'s Name </TD>
						<TD align="center"> Price </TD>
						<TD align="center"> Qty </TD>
						<TD align="center"> Ctn </TD>
						
						<TD align="center"> Total </TD>
					</TR>	
					'.$HTML.'
					<TR>
						<TD colspan="6" align="right">
							<span style="color:blue;font-size:25px;">Grand Total : <u>'.$GrandTotal.' /=</u></span> 
							<input type="hidden" id="GrandTotal" value="'.$GrandTotal.'">
						</TD>
					</TR>	
					
				</table>
		';	
			
		return $HTML_First;	
		
	}

	
?>