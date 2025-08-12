<?

GetPermission("OptionSales");	

function CreateDropDown($Name,$Val){
	$HTML.='
		<select name="'.$Name.'" id="'.$Name.'">
	';
	for($i=0; $i<=$Val;$i++){
	
		$HTML.='
			<option value="'.$i.'">'.$i.'</option>
		';
	}
	$HTML.='
		</select>
	';
	
	return $HTML;

}


if($_POST["PurchaseNumber"]!=""){

	$GetPurchase =  SQL_Select("Purchase","PurchaseID='{$_REQUEST["PurchaseNumber"]}'","",True);
	
	$SalesOrder =  SQL_Select("PurchasedProducts","TempNumber='{$GetPurchase["TempNumber"]}'","");
	foreach($SalesOrder as $ThisSalesOrder){
		$HTML.='
			<tr>
				<td>
					'.$ThisSalesOrder["ProductID"].'
				</td>
				<td>
					'.GetProductName($ThisSalesOrder["ProductID"]).'
				</td>
				<td>
					'.$ThisSalesOrder["Qty"].'
				</td>
				<td>
					'.$ThisSalesOrder["Price"].'
				</td>
				<td>
					'.CreateDropDown("ReturnQty_{$ThisSalesOrder["ProductID"]}",$ThisSalesOrder["Qty"]).'
				</td>
				<td>
					<input type="text" value="" name="Note_'.$ThisSalesOrder["ProductID"].'"  id="NoteID_'.$ThisSalesOrder["ProductID"].'" size="30">
				</td>
			</tr>		
		';
	
	}
	
	//echo $GetSales["TempNumber"];

}	

//echo $TempNumber;
$MainContent.='
	
	<center>

	<h1><img height="32" src="./theme/default/images/order.png"> Purchase Return </h1>
	
	<div style="padding:10px;">
		<div class="Input" style="padding:10px;font-size:15px; width:985px;">
			<form method="post" action="" id="SalesFormID">

				Purchase Number : <input value="'.$_REQUEST["PurchaseNumber"].'" type="text" value="" name="PurchaseNumber"  id="InvoiceNumber" size="30">

				<input type="submit" value="&nbsp;&nbsp;Search &nbsp;&nbsp;" class="Button" id="SalesButtonID" style="width:290px;">
			
			</form>
			<br>

			<form method="post" action="'.ApplicationURL("Purchase","AddtoRefundList").'" id="PurchaseFormID">
				<table width="100%">	
					<tr>
						<td>
							ID
						</td>
						<td>
							Product Name
						</td>
						<td>
							Qty
						</td>
						<td>
							Price
						</td>
						<td>
							Return Qty
						</td>
						<td>
							Note/Reason
						</td>
					</tr>
						
					'.$HTML.'
				
				</table>

				<br>
				<br>
				<input type="hidden" value="'.$GetPurchase["TempNumber"].'" name="TempNumber"  id="TempNumber" size="30">
				<input value="'.$_REQUEST["InvoiceNumber"].'" type="hidden" value="" name="Invoice_Number"  id="Invoice_Number" size="30">
				
				<br>
				<input type="submit" value="&nbsp;&nbsp; Refund &nbsp;&nbsp;" class="Button" id="AddtoRefundListID" style="width:290px;">

			</form>
			
		</div>
		<div class="Clear"></div>

	</div>

	<div class="Clear"></div>
 </center>
';




	
?>