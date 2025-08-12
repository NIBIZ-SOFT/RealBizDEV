<?
	
	GetPermission("OptionPurchase");


if($_REQUEST["Action"]=="Edit"){
	$TempNumber=$_REQUEST["EditTempNumber"];
}else
	$TempNumber=randomkeys(10);
	
	
$MainContent.='
	
	<center>
	
	<h1><img height="32" src="./theme/default/images/order-1.png"> Quotation </h1>
	</center>

	<div style="padding:10px;">
		<div class="Input" style="font-size:15px; width:980px;">
			<form method="post" action="" id="QuotationFormID">
				Customer Name : '.CCTL_Customer($Name="CustomerID",$_REQUEST["CID"]).'	
				&nbsp;&nbsp;&nbsp;&nbsp;
				Product\'s Name : '.CCTL_ProductsWithCategory("Category_ID").'
				<span id="ProductDropDownID"></span>
				<input type="button" value="Add" class="Button" id="QuotationID">
				<input type="hidden" value="'.$TempNumber.'" name="TempNumber">
				
			</form>
		</div>
		<div class="Clear"></div>
		<div class="Purchase" style="float:left; width:653px;">

			<div id="AutoRow">Select Product for Quotation.</div>


				
		</div>
		
		<div style="clear:both;height:10px;">
		 &nbsp;
		</div>
		
		<div style="float:left;">
			<div>
				<form id="AddFundForm" method="POST">
						
						<div style="clear:both;height:15px;"></div>
						<div style="float:left;">
							<span class="ActionButton1" id="CompleteQuotation"> [ Complete Quotation  ] </span>			
						</div>
						<div style="float:right;width:50px;"></div>
						<div style="float:right; ">
							<span style="display:none;" class="ActionButton" id="ConvertToSales"> [ Convert To Sales  ] </span>			
						</div>
						
						<input type="hidden" value="'.$TempNumber.'" name="TempNumber" id="TempNumber">
						<input type="hidden" value="0" name="GrandTotalPrice" id="GrandTotalPrice">
				</form>
				


			
			</div>
			


		</div>
		

	</div>

	<div class="Clear"></div>
 
';


if($_REQUEST["Action"]=="Edit"){

	$MainContent.='
		<script>
			$(document).ready(function() {
				PurchaseEdit(\''.$TempNumber.'\');
				$("#ConvertToSales").css("display","block");
				$("#ConvertToSales").click(function(){
					
					window.location ="index.php?Theme=default&Base=Sales&Script=Manage&ConvertToSales=Yes&Action=Edit&EditTempNumber='.$_REQUEST["EditTempNumber"].'&CID='.$_REQUEST["CID"].'";
					
					
				});					
			});
		</script>
	';
}

	
?>