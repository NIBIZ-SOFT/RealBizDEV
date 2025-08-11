<?php
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(       
		"CustomerID"=>"",
		"ProductsID"=>"",
		"Date"=>"",
		"Quantity"=>"",
		"Price"=>"",
		"PaymentMethod"=>"",		
       "{$Entity}IsActive"=>1
	   
	);

	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"])&&!isset($_REQUEST["DeleteConfirm"])){
	    $UpdateMode=true;
	    $FormTitle="Update $EntityCaption";
	    $ButtonCaption="Update";
	    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction", $Entity."ID={$_REQUEST[$Entity."ID"]}&".$Entity."UUID={$_REQUEST[$Entity."UUID"]}");
		if($UpdateMode&&!isset($_POST["".$Entity."ID"]))$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy="{$OrderByValue}", $SingleRow=true);
	}

	//echo $TheEntityName["OrderID"];
	//echo $TheEntityName["PaymentMethod"];
	if($TheEntityName["PaymentMethod"]=="cash"){
		$one=' checked="checked" ';
		
	
	}
	if($TheEntityName["PaymentMethod"]=="due"){
		$two=' checked="checked" ';
		
	
	}
	if($TheEntityName["PaymentMethod"]=="cheque"){
		$three=' checked="checked" ';
		$MainContent.='
			<script>
				$(document).ready(function (){
					if($("#cheque : checked")){
						$("#Paycheque").css(\'display\', \'block\');
						$("#Paycard").css(\'display\', \'none\');
					}
				});
			</script>
		
		';
	
	}
	if($TheEntityName["PaymentMethod"]=="card"){
		$four=' checked="checked" ';
		$MainContent.='
			<script>
				$(document).ready(function (){
					if($("#cheque : checked")){
						$("#Paycheque").css(\'display\', \'none\');
						$("#Paycard").css(\'display\', \'block\');
					}
				});
			</script>
		
		';
	
	}
	ob_start();
	
	$upDateQuery=mysql_fetch_assoc(mysql_query("select * from `tblorder` where OrderID='".$_REQUEST['OrderID']."'"));

?>
<?php if($_REQUEST['OrderID']!=''):?>

<script type="text/javascript" src="script/fusebox.js"></script>

<?php endif;?>

<form enctype="multipart/form-data" method="post" action="<?php echo $ActionURL;?>" name="frmorderInsertUpdate" id="myForm">
  <table cellspacing="0" border="1" align="center">
    <tbody>
      <tr class="DataGrid_Title_Table_Bar">
        <td align="center">Insert Order List</td>
      </tr>
      <tr>
        <td><table class="ThemeFormTABLE">
            <tbody>
              <tr class="ThemeDataTD">
                <td align="right">&nbsp;&nbsp;&nbsp;Customer Name &nbsp;:&nbsp;&nbsp;</td>
                <td><?php echo CCTL_Customer($Name="CustomerName", $ValueSelected=$upDateQuery["CustomerID"]);?> <br>
                  or<br>
                  <input type="text" size="30" name="CustomCustomerName" />
				  <br>
                  <div style="height:5px;"></div>
                  Address :
                  <input type="text" size="20" name="CustomCustomerAddress" />
                  <br>
                  <div style="height:5px;"></div>
                  Phone :
                  <input type="text" size="20" name="CustomCustomerPhone" />
                  <div style="height:5px;"></div></td>
              </tr>
              <tr class="ThemeDataTD">
                <td align="right">&nbsp;&nbsp;&nbsp;Date &nbsp;:&nbsp;&nbsp;</td>
                <td><input type="text" autocomplete="OFF" value="<?php if($upDateQuery['Date'])echo $upDateQuery['Date']; else echo date('Y-m-d');?>" id="datepicker" name="Date" size="12" class="hasDatepicker">
                </td>
              </tr>
              <tr class="ThemeDataTD">
                <td>&nbsp;</td>
                <td colspan="2"><input type="button" value="add more" onclick="fieldLoad('Order')" />
                  <input type="button" value="Remove more" onclick="fieldRemove()" /></td>
              </tr>
              <tr align="center">
                <td colspan="2">
				<div id="productNameTable" style="width:434px;">
                    <div>
                      <div style="float:left; padding:2px 5px;">Products Name</div>
                      <div style="float:left; padding:2px 5px;">Quantity</div>
                      <div style="float:left; padding:2px 5px;">Price</div>
                      <div style="clear:both"></div>
                    </div>
                    <?php
			$incr=1;
			
			if($_REQUEST['OrderID']!=''){
			
			$productQuery=mysql_query("select * from `tblorderproducts` where OrderID='".$_REQUEST['OrderID']."'");
				while($prdasoc=mysql_fetch_assoc($productQuery)){
			?>
                    <div id="moreLoad<?php echo $incr;?>">
                      <div style="float:left; padding:2px 5px;">
                        <?php //echo CCTL_Products($Name="ProductName", $ValueSelected=$TheEntityName["ProductsID"]);?>
                        <select name="ProductName<?php echo $incr;?>" id="ProductName<?php echo $incr;?>">
                          <option value="">Select a product</option>
                          <?php
								$qury=mysql_query("select * from `tblproducts`");
								while($asoc=mysql_fetch_assoc($qury)){
								    if($asoc['ProductsID']==$prdasoc['ProdID']){
									$selcted='selected="selected"';
									}else{
									$selcted='';
									}
									echo '<option '.$selcted.' value="'.$asoc['ProductsID'].'">'.$asoc['ProductName'].'</option>';
								}							
								
							?>
                        </select>
                      </div>
                      <div style="float:left; padding:2px 5px;">
                        <input type="text" value="<?php echo $prdasoc['Qty'];?>" id="Quantity<?php echo $incr;?>" name="Quantity<?php echo $incr;?>" size="5"/>
                      </div>
                      <div style="float:left; padding:2px 5px;"> <img height="16" title="Available" src="./theme/default/images/001_06.gif" name="available" style="display:none;" id="ImageIsAvailableID<?php echo $incr;?>"> <img height="16" title="Not Available" src="./theme/default/images/No-entry.png" name="available" style="display:none;" id="ImageIsNotAvailableID<?php echo $incr;?>">
                        <input type="hidden" value="" name="isquantityavailable<?php echo $incr;?>" id="isquantityavailable<?php echo $incr;?>">
                      </div>
                      <div style="float:left; padding:2px 5px;">
                        <input type="text" value="<?php echo $prdasoc['Price'];?>" id="Price<?php echo $incr;?>" name="Price<?php echo $incr;?>" size="10" onkeyup="viewTotalPrice()">
                        /= Tk. </div>
                      <div style="float:left; padding:2px 5px;"> <img height="16" title="Available" src="./theme/default/images/001_06.gif" name="available" style="display:none;" id="ImageIsAvailableID1_<?php echo $incr;?>"> <img height="16" title="Not Available" src="./theme/default/images/No-entry.png" name="available" style="display:none;" id="ImageIsNotAvailableID1_<?php echo $incr;?>">
                        <input type="hidden" value="1" name="isPriceavailable<?php echo $incr;?>" id="isPriceavailable<?php echo $incr;?>">
                      </div>
					  <div style="float:left; padding:2px 5px;">
				       <img onclick="fieldRemoveOne(<?php echo $incr;?>)" style="border: #ff33cc; cursor: pointer; " alt="Delete" src="./theme/default/image/datagrid/Delete.gif">
                      </div>
					  
                      <div style="clear:both"></div>
                    </div>
                    <input type="hidden" name="OrdProID<?php echo $incr;?>" value="<?php echo $prdasoc['OrdProID'];?>"/>
                    <?php 
			 
			 $incr++; 
			 
			 $TotalPrice+=$prdasoc['Price'];
			   } //while loop
			 
			 }else{?>
                    <div>
                      <div style="float:left; padding:2px 5px;">
                        <?php //echo CCTL_Products($Name="ProductName", $ValueSelected=$TheEntityName["ProductsID"]);?>
                        <select name="ProductName<?php echo $incr;?>" id="ProductName<?php echo $incr;?>">
                          <option value="">Select a product</option>
                          <?php
								$qury=mysql_query("select * from `tblproducts`");
								while($asoc=mysql_fetch_assoc($qury)){
								    
									echo '<option value="'.$asoc['ProductsID'].'">'.$asoc['ProductName'].'</option>';
								}							
								
							?>
                        </select>
                      </div>
                      <div style="float:left; padding:2px 5px;">
                        <input type="text" value="<?php echo $prdasoc['Qty'];?>" id="Quantity<?php echo $incr;?>" name="Quantity<?php echo $incr;?>" size="5"/>
                      </div>
                      <div style="float:left; padding:2px 5px;"> <img height="16" title="Available" src="./theme/default/images/001_06.gif" name="available" style="display:none;" id="ImageIsAvailableID<?php echo $incr;?>"> <img height="16" title="Not Available" src="./theme/default/images/No-entry.png" name="available" style="display:none;" id="ImageIsNotAvailableID<?php echo $incr;?>">
                        <input type="hidden" value="" name="isquantityavailable<?php echo $incr;?>" id="isquantityavailable<?php echo $incr;?>">
                      </div>
                      <div style="float:left; padding:2px 5px;">
                        <input type="text" value="<?php echo $prdasoc['Price'];?>" id="Price1" name="Price<?php echo $incr;?>" size="10" onkeyup="viewTotalPrice()">
                        /= Tk. </div>
                      <div style="float:left; padding:2px 5px;"> <img height="16" title="Available" src="./theme/default/images/001_06.gif" name="available" style="display:none;" id="ImageIsAvailableID1_<?php echo $incr;?>"> <img height="16" title="Not Available" src="./theme/default/images/No-entry.png" name="available" style="display:none;" id="ImageIsNotAvailableID1_<?php echo $incr;?>">
                        <input type="hidden" value="1" name="isPriceavailable<?php echo $incr;?>" id="isPriceavailable<?php echo $incr;?>">
                      </div>
                      <div style="clear:both"></div>
                    </div>
                    <?php
			   
			   
			 }
			 
			 			
			$loopJS.='
			            nowform='.($incr-1).'
			    
				$("#Quantity1").keyup(function(){				
				
				var QuantityVal = $("#Quantity1").val(); 
				var ProdDropval=$("#ProductName1").val(); 
				
				if(QuantityVal!=\'\'){
					$.post("index.php?Theme=admin&Base=Page&Script=QuantityAvailable&NoHeader&NoFooter&ProdID="+ProdDropval,"Quantity="+QuantityVal,function(data){
						//alert(data);
						if(data=="1"){
							$("#ImageIsAvailableID1").css(\'display\', \'block\');
							$("#ImageIsNotAvailableID1").css(\'display\', \'none\');
							$("#isquantityavailable1").val("1");
						}
						if(data=="0"){
							$("#ImageIsNotAvailableID1").css(\'display\', \'block\');
							$("#ImageIsAvailableID1").css(\'display\', \'none\');
							$("#isquantityavailable1").val("0");
						
						}
						
					});
				
				}	
				
				
				
			});	
			
			$("#Price1").keyup(function(){
				
				var PriceVal = $("#Price1").val(); 
				var ProdDropval=$("#ProductName1").val(); 
				
				if(PriceVal!=\'\'){
					$.post("index.php?Theme=admin&Base=Page&Script=PriceAvailable&NoHeader&NoFooter&ProdID="+ProdDropval,"Price="+PriceVal,function(data){
						//alert(data);
						if(data=="1"){
							$("#ImageIsAvailableID1_1").css(\'display\', \'block\');
							$("#ImageIsNotAvailableID1_1").css(\'display\', \'none\');
							$("#isPriceavailable1").val("1");
						}
						if(data=="0"){
							$("#ImageIsNotAvailableID1_1").css(\'display\', \'block\');
							$("#ImageIsAvailableID1_1").css(\'display\', \'none\');
							$("#isPriceavailable1").val("0");
						
						}
						
					});
				
				}	
				
				
				
			});
			
			
			';
			
			?>
                  </div></td>
              </tr>
              <tr class="ThemeDataTD">
                <td align="right">Total Price:</td>
                <td><div id="TotalPriceView"><?php echo $TotalPrice;?></div>
                  <input type="hidden" value="<?php echo $TotalPrice;?>" id="TotalPrice" name="Price">
                </td>
              </tr>
              <tr class="ThemeDataTD">
                <td align="right">Payment Method:</td>
                <td>
				  <input type="radio" value="cash" id="cash" name="PaymentMethod" <?php if($upDateQuery['PaymentMethod']=='cash' or $_REQUEST['PurchaseID']==''){echo 'checked="checked";';}?>>
                  Cash
                  <input type="radio" value="due" id="due" name="PaymentMethod"  <?php if($upDateQuery['PaymentMethod']=='due'){echo 'checked="checked";';}?>>
                  Due
                  <input type="radio" value="cheque" id="cheque" name="PaymentMethod" <?php if($upDateQuery['PaymentMethod']=='cheque'){echo 'checked="checked";';}?>>
                  Cheque
                  <input type="radio" value="card" id="card" name="PaymentMethod" <?php if($upDateQuery['PaymentMethod']=='card'){echo 'checked="checked";';}?>>
                  Card <br>
                  <br>
                  <div style=" <?php if($upDateQuery['checkno']!=''){echo 'display:block;';}else{echo 'display:none;';}?>" id="Paycheque">
                    <table>
                      <tbody>
                        <tr>
                          <td>Check No:</td>
                          <td><input type="text" value="<?php echo $upDateQuery['checkno'];?>" name="checkno"></td>
                        </tr>
                        <tr>
                          <td>Bank Name:</td>
                          <td><input type="text" value="<?php echo $upDateQuery['bankname'];?>" name="bankname">
                          </td>
                        </tr>
                        <tr>
                          <td>Date</td>
                          <td><input type="text" autocomplete="OFF" value="<?php echo $upDateQuery['CheckDate'];?>" id="datepicker1" name="CheckDate" class="hasDatepicker"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
				  
				  <div style=" <?php if($upDateQuery['DueAmount']!=''){echo 'display:block;';}else{echo 'display:none;';}?>" id="Duebox">
                    <table>
                      <tbody>
                        <tr>
                          <td>Paid Amount:</td>
                          <td><input type="text" value="<?php echo $upDateQuery['PaidAmount'];?>" name="PaidAmount" id="PaidAmount" onkeyup="PaidDueCalc()"></td>
                        </tr>
                        <tr>
                          <td>Due Amount:</td>
                          <td><input type="text" value="<?php echo $upDateQuery['DueAmount'];?>" name="DueAmount" id="DueAmount">
                          </td>
                        </tr>
                        <tr>
                          <td>Due pay Date</td>
                          <td><input type="text" autocomplete="OFF" value="<?php echo $upDateQuery['DueDate'];?>" id="datepicker2" name="DueDate" class="hasDatepicker"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
				  
				  
                  <div style=" <?php if($upDateQuery['cardno']!=''){echo 'display:block;';}else{echo 'display:none;';}?>" id="Paycard">
                    <table>
                      <tbody>
                        <tr>
                          <td>Card No:</td>
                          <td><input type="text" value="<?php echo $upDateQuery['cardno'];?>" name="cardno"></td>
                        </tr>
                        <tr>
                          <td>Bank Name:</td>
                          <td><input type="text" value="<?php echo $upDateQuery['cardname'];?>" name="cardname">
                          </td>
                        </tr>
                        <tr>
                          <td>Date</td>
                          <td><input type="text" autocomplete="OFF" value="<?php echo $upDateQuery['cardDate'];?>" id="datepicker2" name="cardDate" class="hasDatepicker"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div></td>
              </tr>
              <tr class="ThemeDataTD">
                <td align="right">&nbsp;&nbsp;&nbsp;Update Product Table?&nbsp;:&nbsp;&nbsp;</td>
                <td><input type="radio" checked="" style="" class="FormInputRadio" value="1" name="OrderIsActive" id="">
                  Yes
                  <input type="radio" style="" class="FormInputRadio" value="0" name="OrderIsActive" id="">
                  No </td>
              </tr>
              <tr class="ThemeDataTD">
                <td align="right">&nbsp;&nbsp;&nbsp;Print Preview?&nbsp;:&nbsp;&nbsp;</td>
                <td><input type="radio" style="" class="FormInputRadio" value="1" name="PrintPreview" id="">
                  Yes
                  <input type="radio" checked="" style="" class="FormInputRadio" value="0" name="PrintPreview" id="">
                  No </td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      <tr align="right" class="DataGrid_Title_Table_Bar">
        <td><input type="submit" onclick="" style="" class="DataGridButton" size="" title="" value="Insert" name="" id=""></td>
      </tr>
    </tbody>
  </table>
</form>
<?php
	$MainContent.=ob_get_contents();
	ob_end_clean();	


	$MainContent.='
		<script> 
		
			function viewTotalPrice(){
			    var TotalPrice=0;
				for(var k=1; k<=nowform; k++){
					
					if (document.getElementById("Price"+k)) {
						var price=$("#Price"+k).val();
									
						if(price!=""){
						  TotalPrice+=parseFloat(price);
						}
					}
					
				}
								
				$("#TotalPrice").val(TotalPrice)
				$("#TotalPriceView").html(TotalPrice)
			
			}
			
			 function PaidDueCalc(){
			   
			   	var totalprice=parseFloat($("#TotalPrice").val());
				var paidPrice=$("#PaidAmount").val();
				var DueAmount=totalprice-paidPrice;
				$("#DueAmount").val(DueAmount)
			   
			   }
			

			$("#myForm").submit(function(){
					if($("#isquantityavailable").val()=="0"){
						alert("Quantity Not Available");
						return false;
					}						
					
					if($("#isPriceavailable").val()=="0"){
						alert("Price Can\'t be Less than Selling Price");
						return false;
					}			
				});
		
		
			
			$("#datepicker").datepicker();
			$("#datepicker1").datepicker();
			$("#datepicker2").datepicker();
			
			$("#cash").click(function(){
				 $("#Paycheque").css(\'display\', \'none\');
				 $("#Paycard").css(\'display\', \'none\');
				 $("#Duebox").css(\'display\', \'none\');
			});
			$("#due").click(function(){
				 $("#Paycheque").css(\'display\', \'none\');
				 $("#Paycard").css(\'display\', \'none\');
				 $("#Duebox").css(\'display\', \'block\');
			});
			$("#cheque").click(function(){
				 $("#Paycheque").css(\'display\', \'block\');
				 $("#Paycard").css(\'display\', \'none\');
				 $("#Duebox").css(\'display\', \'none\');
			});
			$("#card").click(function(){
				 $("#Paycheque").css(\'display\', \'none\');
				 $("#Paycard").css(\'display\', \'block\');
				 $("#Duebox").css(\'display\', \'none\');
			});
			
			'.$loopJS.'

					
			
		</script>
		
	';
	$MainContent.='	

	
	';		
	
	
			
?>
