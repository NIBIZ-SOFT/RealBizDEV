<?

	$ID = $_REQUEST["ID"];
	$SelectedSeriels = $_REQUEST["SelectedSeriels"] ;
	$MyTempNumber = $_REQUEST["MyTempNumber"];
	
	$HTML1=$HTML='';
	
/* 	echo "select Serials,TempNumber from tblpurchasedproducts 
			  where ProductID='{$ID}' and Serials!='' 
			  
			  TempNumber in (select TempNumber from tblsales where  TempNumber='{$MyTempNumber}' and SalesIsActive=1
			  
			  order by PurchasedProductsID DESC
			  
			  "; */

/* 	echo "select * from tblsalesorder where ProductID='{$ID}' and Serials!=''
						   and  
						   TempNumber in (select TempNumber from tblsales where  TempNumber='{$TemporaryNumber}' and SalesIsActive=1)";
 
 */
			  
	//echo "select Serials from tblpurchasedproducts where ProductID='{$ID}' order by PurchasedProductsID DESC <br>";
	$result = mysql_query("select Serials,TempNumber from tblpurchasedproducts 
			  where ProductID='{$ID}' and Serials!='' 
			  
			  order by PurchasedProductsID DESC
			  
			  ");
			  
			  
	//$row = @mysql_fetch_array($result, MYSQL_ASSOC);
	while ($row = mysql_fetch_assoc($result)) {
		$GetSerial=explode(",",$row["Serials"]);
		foreach($GetSerial as $ThisGetSerial){
			if($SelectedSeriels==$ThisGetSerial and $ThisGetSerial!="")
				$HTML1.='
					<option selected="selected" value="'.$ThisGetSerial.'">'.$ThisGetSerial.'</option>
				';
			else{
				if(FindSoldSerialKey($ID,$ThisGetSerial,$MyTempNumber)=="No" and $ThisGetSerial!="")
					$HTML1.='
						<option value="'.$ThisGetSerial.'">'.$ThisGetSerial.'</option>
					';
			}
		}
		//$TNumber=$row["TempNumber"];
	}
	if($HTML1!="")
		$HTML.='
			<select id="SerialsNumber_'.$ID.'">
				'.$HTML1.'
			</select>
			<input onclick="SerialsAdd('.$ID.',\''.$MyTempNumber.'\')" type="button" style="" id="SerialAddButtonID" class="Button" value="&nbsp;&nbsp;Add &nbsp;&nbsp;">
		';

	echo $HTML;
	

?>