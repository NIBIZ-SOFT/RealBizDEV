<?
	
	GetPermission("OptionSales");
	
	if($_REQUEST["ConvertToSales"]=="Yes"){
		
			SQL_InsertUpdate(
			
				"Sales",
				$The_Entity_NameData=array(
					"CustomerID"=>$_POST["CID"],
					"TempNumber"=>$_REQUEST["EditTempNumber"],
					"SalesBy"=>$_SESSION["UserID"],
					"SalesIsActive"=>0,
				),
				""
			);
			
			$PurchaseProducts=SQL_Select($Entity="PurchasedProducts", $Where="TempNumber='{$_REQUEST["EditTempNumber"]}'","","");

			foreach($PurchaseProducts as $ThisPurchaseProducts){
				SQL_InsertUpdate(
					"SalesOrder",
					$The_Entity_NameData=array(
						"ProductID"=>$ThisPurchaseProducts["ProductID"],
						"Price"=>$ThisPurchaseProducts["CostPerProduct"],
						"Qty"=>$ThisPurchaseProducts["Qty"],
						"TempNumber"=>$_REQUEST["EditTempNumber"],
					),
					""
				
				);					

			}			
	}
	
	
	
	if($_REQUEST["Action"]=="Edit"){
		$TempNumber=$_REQUEST["EditTempNumber"];
		
		$GetRemarks =  SQL_Select("Sales","TempNumber='{$TempNumber}'","",true);
		
	}else
		$TempNumber=GUID();
	
	
	


//echo $Settings["PaymentMethod"];
$GetPaymentMethod = explode(",",$Settings["PaymentMethod"]);
$x=0;
foreach($GetPaymentMethod as $ThisGetPaymentMethod){
	
	$HTMLPaymentMethod.='
		<option value="'.$GetPaymentMethod[$x].'">'.$GetPaymentMethod[$x].'</option>
	
	';
	
	$x++;
	
}
//echo $TempNumber;
$MainContent.='

	
	<center>

	<span style="font-size:25px;"><img height="15" src="./theme/default/images/order.png"> POS </span>
	</center>
	<div style="padding:10px;">
		<div class="Input" style="padding:10px;font-size:15px; width:985px;">
			<form method="post" action="" id="SalesFormID">
				Warehouse '.CCTL_WarehouseSales("WareHouseID", "{$GetRemarks["WareHouseID"]}").'	<br>
				Customer '.CCTL_Customer($Name="CustomerID",$_REQUEST["CID"]).'	
				Or New Customer : <input type="text" value="" name="NewCustomer"  id="NewCustomer" size="30">
				Phone : <input type="text" value="" name="Phone"  id="Phone" size="30">
				
				<input type="hidden" value="'.$TempNumber.'" name="TempNumber">
				<br>
				Or Barcode <input text="text" placeholder="Put Barcode" name="Barcode" id="Barcode" value="">
				<input type="hidden" value="" name="ProductID" id="ProductID">
				<input type="button" value="&nbsp;&nbsp;Add to Sales &nbsp;&nbsp;" class="Button" id="SalesButtonID" style="width:290px;">
			
		</div>
		<div class="Clear"></div>
		
		<div class="Input" style="padding:10px;font-size:15px; width:985px;">		
		
			Category to start<hr style="margin:3px">
			<div style="" id="TopMenusList" >
				
			</div>	
			<div class="Purchase222" style="" id="MenusList" >
				'.$HTMLCategory.'
			</div>			
			<div style="clear:both;height:5px;"></div>
			Items<hr style="margin:3px">
			<div style="" id="TopMenusListItems" >
				Choose a Category to view items
			</div>
		
		</div>
		<div style="clear:both;height:10px;"></div>		
		
		
		
		<div class="Purchase" style="float:left; width:653px;">

			<div id="AutoRow">Select Product to Sale.</div>

			<hr>
			Remarks : <br> 
			<textarea id="Remarks" name="Remarks" style="width:300px;height:100px;">'.$GetRemarks["Remarks"].'</textarea>
			
		</div>
		
		</form>
		
		<div style="float:left;width:10px;">
		 &nbsp;


		</div>

		
		<div style="float:left;">
			<div>
					<form id="SalesAddFundForm" method="POST">
							<div style="width:298px;float:right;border: 1px solid #CCCCCC; border-radius: 6px 6px 6px 6px; box-shadow: 1px 2px 4px #1583A9; margin: 5px; padding: 10px; ">
							
								Payment Method : <br>
								<select name="PaymentMethod"  id="PaymentMethod" style="font-size:18px;width:150px;">
									<option value="Cash">Cash</option>
									'.$HTMLPaymentMethod.'
								</select>
								
								<div style="clear:both;height:5px;"></div>
								<div id="Cash" >
									Amount : <br> 
									<input  style="font-size:18px;width:150px;" type="text" size="20" name="Amount" id="Amount">
									<br>
									Discount : <br> 
									<input onblur="DiscountCal();"  style="font-size:18px;width:150px;" type="text" value="0" size="20" name="Discount" id="Discount">
									<br>
									Payment Note : <br> 
									<textarea id="PaymentNote" name="PaymentNote" style="width:200px;height:100px;"></textarea>
									<br>
									
								</div>
								
								<div style="clear:both;height:5px;"></div>
								
								<div id="Cheque" style="display:none;" >
									Bank Name : <br> 
									<input  style="font-size:18px;width:240px;" type="text" size="20" name="BankName">
									<br> 
									Card Number : <br> 
									<input  style="font-size:18px;width:200px;" type="text" size="20" name="ChequeNumber">
									
								</div>
								
								<div style="clear:both;height:5px;"></div>
								<div>
									<span class="ActionButton1" id="SalesActionButton1">Add Fund</span>
								</div>
								
								<div style="clear:both;height:15px;"></div>
								<div style="float:right;">
									<span class="ActionButton1" id="CompleteSales"> [ Complete Sale & Print ] </span>			
								</div>
								<div style="clear:both;height:5px;"></div>
								<div style="float:right;">
									<span class="ActionButton1" id="CompleteSalesNDownloadPDF"> [ Complete Sale & Download PDF ] </span>			
								</div>
								<div style="clear:both;height:5px;"></div>
								<div style="float:right;">
									<span class="ActionButton1" id="CompleteSalesOnly"> [ Complete Sale ] </span>			
								</div>
								
								<input type="hidden" value="'.$TempNumber.'" name="TempNumber" id="TempNumber">
								<input type="hidden" value="0" name="GrandTotalPrice" id="GrandTotalPrice">

							</div>
							

						</form>			
			</div>
			<div class="Clear"></div>
			<div class="PaymentHistory">
				<span style="font-size:20px;color:black;">Payment History [ Sales ]</span>
				<div id="PaymentHistory"></div>
			</div>
		</div>	

	</div>

	<div class="Clear"></div>
	
	
	<script>
		$.post("index.php?Theme=default&Base=POS&Script=GetCategoryList&NoHeader&NoFooter",function(data){
			$("#MenusList").html(data);
		});	
		
		function GetCategoryListOnBack(){
			$.post("index.php?Theme=default&Base=Sales&Script=GetCategoryList&NoHeader&NoFooter",function(data){
				$("#TopMenusList").css("display","none");
				$("#MenusList").html(data);
			});	
			
		}
		
	</script>	
 
';


if($_REQUEST["Action"]=="Edit"){

	$MainContent.='
		<script>
			$(document).ready(function() {
				SalesOrderEdit(\''.$TempNumber.'\');
			});
		</script>
	';
}



	
?>