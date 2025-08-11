<? GetPermission("OptionPurchase");
if ($_REQUEST["Action"] == "Delete") {
    SQL_Delete("Purchase", "TempNumber='{$_REQUEST["EditTempNumber"]}'");
    echo "			<script>				alert('Delete DONE');				window.location='./index.php';						</script>				";
    exti;
}

if ($_REQUEST["Action"] == "Edit") {
    $TempNumber = $_REQUEST["EditTempNumber"];
} else    $TempNumber = randomkeys(10);


$MainContent .= '		
		<center>
            <h1>
                <img height="32" src="./theme/default/images/order-1.png">
                 Purchase 
            </h1>	
		</center>
			
		<div style="padding:10px;">		
            
            <div class="Input" style="font-size:15px; width:980px;">
                <form method="post" action="" id="PurchaseFormID">
                    Vendor Name : ' . CCTL_Vendor("Vendor", GetVendorIDFromTempNumber($_REQUEST["EditTempNumber"])) . '				&nbsp;&nbsp;&nbsp;&nbsp;
                        <div style="display: none">
                             Warehouse ' . CCTL_Warehouse("WareHouseID", "{$GetRemarks["WareHouseID"]}") . ' 
                        </div>	<br>				
                    Project\'s Name : ' . CCTL_ProductsWithCategory("Category_ID") . '				
                    <span id="ProductDropDownID"></span>				
                    
                    <input type="button" value="Add" class="Button" id="PurchaseID">				
                    
                    <input type="hidden" value="' . $TempNumber . '" name="TempNumber">							
                </form>		
            </div>		
		
		
		<div class="Clear"></div>		
				<div class="Purchase" style="float:left; width:653px;">			
				<div id="AutoRow">							Select Product to Purchase.				
				<p>				<br><br><br><br><br><br><br><br><br><br><br><br><br>			
				</div>						
				</div>				
				
				<div style="float:left;width:10px;">&nbsp;</div>				
				
				<div style="float:left;"><div>				
				<form id="AddFundForm" method="POST">					
				    <div style="width:298px;float:right;border: 1px solid #CCCCCC; border-radius: 6px 6px 6px 6px; box-shadow: 1px 2px 4px #1583A9; margin: 5px; padding: 10px; ">
				        Payment Method : <br>						
				        <select name="PaymentMethod"  id="PaymentMethod" style="font-size:18px;width:150px;">						
				            <option value="Cash">Cash</option>							
				            <option value="Cheque">Cheque</option>						
				        </select>												
				        <div style="clear:both;height:5px;"></div>						
				        <div id="Cash" >							
				        Amount : <br> 							
				        <input  style="font-size:18px;width:150px;" type="text" size="20" name="Amount" id="Amount">							<br>						
				        </div>												
				        <div style="clear:both;height:5px;"></div>												
				        <div id="Cheque" style="display:none;" >							
				        Bank Name : <br> 							
				        <input  style="font-size:18px;width:240px;" type="text" size="20" name="BankName">							<br> 							Cheque Number : <br> 							
				        <input  style="font-size:18px;width:200px;" type="text" size="20" name="ChequeNumber">							<br> 							Due Date : <br> 							
				        <input  style="font-size:18px;width:150px;" type="text" size="20" name="DueDate">													</div>												
				        <div style="clear:both;height:5px;"></div>						
				        <div>							
				        <span class="ActionButton1" id="ActionButton1">Add Fund</span>						
				        </div>												
				        <div style="clear:both;height:15px;"></div>						
				        <div style="float:right;">							
				        <span class="ActionButton1" id="CompletePurchase"> [ Complete Purchase ] </span>									
				        </div>												
				        <input type="hidden" value="' . $TempNumber . '" name="TempNumber" id="TempNumber">						
				        <input type="hidden" value="0" name="GrandTotalPrice" id="GrandTotalPrice">					
				        </div>				
				        </form>									
				        </div>						
				        
				        <div class="PaymentHistory" style="clear:both;">				
				        <span style="font-size:20px;color:black;">Payment History [ Purchase ]</span>				
				        <div id="PaymentHistory">No History yet.</div>			
				        </div>		
				        </div>			
				        </div>	
				        <div class="Clear">
				        
        </div> ';




if ($_REQUEST["Action"] == "Edit") {
    $MainContent .= '		
	<script>			
		$(document).ready(function() {				
		    PurchaseEdit(\'' . $TempNumber . '\');			
		});		
	</script>';

} ?>