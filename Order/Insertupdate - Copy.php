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
	?>

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
              <td><?php echo CCTL_Customer($Name="CustomerName", $ValueSelected=$TheEntityName["CustomerID"]);?>
			    
                <br>
                or<br>
                <input type="text" size="30" name="CustomCustomerName">
                <br>
                <div style="height:5px;"></div>
                Phone :
                <input type="text" size="20" name="CustomCustomerPhone">
                <div style="height:5px;"></div></td>
            </tr>
            <tr class="ThemeDataTD">
              <td align="right">&nbsp;&nbsp;&nbsp;Date &nbsp;:&nbsp;&nbsp;</td>
              <td><input type="text" autocomplete="OFF" value="" id="datepicker" name="Date" size="12" class="hasDatepicker">
                <input type="hidden" name="InvoiceNo" value="100">
				
              </td>
            </tr>
			<tr><td><input type="button" value="add more" onclick="fieldLoad()" /></td>
			<td><input type="button" value="Remove more" onclick="fieldRemove()" /></td></tr>
            <tr align="center">
              <td colspan="2">
			  
			  <div id="productNameTable">
                     <div>
                    <div style="float:left; padding:2px 5px;">Products Name</div>					
                    <div style="float:left; padding:2px 5px;">Quantity</div>		
                    <div style="float:left; padding:2px 5px;">Price</div>
					<div style="clear:both"></div>		
                  </div>                  
				  <div>
					   <div style="float:left; padding:2px 5px;">
						<?php //echo CCTL_Products($Name="ProductName", $ValueSelected=$TheEntityName["ProductsID"]);?>
						 <select name="ProductName1" id="ProductName1">
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
						  <input type="text" value="" id="Quantity1" name="Quantity1" size="5"/>
						</div>					
					   <div style="float:left; padding:2px 5px;">
						  <img height="16" title="Available" src="./theme/default/images/001_06.gif" name="available" style="display:none;" id="ImageIsAvailableID1"> 
						  <img height="16" title="Not Available" src="./theme/default/images/No-entry.png" name="available" style="display:none;" id="ImageIsNotAvailableID1">
						  <input type="hidden" value="" name="isquantityavailable1" id="isquantityavailable1">
						</div>                  
					   <div style="float:left; padding:2px 5px;">
						  <input type="text" value="" id="Price1" name="Price1" size="10">/= Tk. 
					   </div>
					   <div style="float:left; padding:2px 5px;">
							<img height="16" title="Available" src="./theme/default/images/001_06.gif" name="available" style="display:none;" id="ImageIsAvailableID1_1"> <img height="16" title="Not Available" src="./theme/default/images/No-entry.png" name="available" style="display:none;" id="ImageIsNotAvailableID1_1">
							<input type="hidden" value="" name="isPriceavailable1" id="isPriceavailable1">
					   </div>
					   <div style="clear:both"></div>
                  </div>
				  
				  
               <?php			
			$loopJS.='
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
				  
			</div>
			
			
			  </td>
			</tr>  
				  
            <tr class="ThemeDataTD">
              <td align="right"><input type="button" value="view total price" onclick="viewTotalPrice()" /> :</td>
              <td><div id="TotalPriceView"></div>
			  
			  
			  <input type="hidden" value="" id="TotalPrice" name="Price">
                  <!--<input type="hidden" name="InvoiceNo" value="<?php
				  //$query=mysql_fetch_assoc(mysql_query("select `OrderID` from `tblorder` order by id desc limit 1")); 
				  //echo $query['OrderID']+1;
				  ?>">-->
              </td>
            </tr>
      <tr class="ThemeDataTD">
        <td align="right">&nbsp;&nbsp;&nbsp;Payment Method&nbsp;:&nbsp;&nbsp;</td>
        <td><input type="radio" value="cash" id="cash" name="PaymentMethod" checked="">
          Cash
          <input type="radio" value="due" id="due" name="PaymentMethod">
          Due
          <input type="radio" value="cheque" id="cheque" name="PaymentMethod">
          Cheque
          <input type="radio" value="card" id="card" name="PaymentMethod">
          Card <br>
          <br>
          <div style="display:none;" id="Paycheque">
            <table>
              <tbody>
                <tr>
                  <td>Check No:</td>
                  <td><input type="text" value="" name="checkno"></td>
                </tr>
                <tr>
                  <td>Bank Name:</td>
                  <td><input type="text" value="" name="bankname">
                  </td>
                </tr>
                <tr>
                  <td>Date</td>
                  <td><input type="text" autocomplete="OFF" value="" id="datepicker1" name="CheckDate" class="hasDatepicker"></td>
                </tr>
              </tbody>
            </table>
          </div>
          <div style="display:none;" id="Paycard">
            <table>
              <tbody>
                <tr>
                  <td>Card No:</td>
                  <td><input type="text" value="" name="cardno"></td>
                </tr>
                <tr>
                  <td>Bank Name:</td>
                  <td><input type="text" value="" name="cardname">
                  </td>
                </tr>
                <tr>
                  <td>Date</td>
                  <td><input type="text" autocomplete="OFF" value="" id="datepicker2" name="cardDate" class="hasDatepicker"></td>
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
  </table>
  </td>
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
				for(var k=1; k<=5; k++){
					var price=$("#Price"+k).val();
								
					if(price!=""){
					  TotalPrice+=parseFloat(price);
					}
					
				}
								
				$("#TotalPrice").val(TotalPrice)
				$("#TotalPriceView").html(TotalPrice)
			
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
			});
			$("#due").click(function(){
				 $("#Paycheque").css(\'display\', \'none\');
				 $("#Paycard").css(\'display\', \'none\');
			});
			$("#cheque").click(function(){
				 $("#Paycheque").css(\'display\', \'block\');
				 $("#Paycard").css(\'display\', \'none\');
			});
			$("#card").click(function(){
				 $("#Paycheque").css(\'display\', \'none\');
				 $("#Paycard").css(\'display\', \'block\');
			});
			
			'.$loopJS.'

					
			
		</script>
		
	';
	$MainContent.='	

	
	';		
	
	
			
?>
