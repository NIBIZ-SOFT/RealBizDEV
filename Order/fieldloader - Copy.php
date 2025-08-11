<?php

$k=$_REQUEST["nextrindx"];


?>

    <div>
	 <div style="float:left; padding:2px 5px;">
                     <select name="ProductName<?php echo $k;?>" id="ProductName<?php echo $k;?>">
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
     
					  <input type="text" value="" id="Quantity<?php echo $k;?>" name="Quantity<?php echo $k;?>" size="5"/>
     </div>
	 <div style="float:left; padding:2px 5px;">
					  <img height="16" title="Available" src="./theme/default/images/001_06.gif" name="available" style="display:none;" id="ImageIsAvailableID<?php echo $k;?>"> 
					  <img height="16" title="Not Available" src="./theme/default/images/No-entry.png" name="available" style="display:none;" id="ImageIsNotAvailableID<?php echo $k;?>">
                      <input type="hidden" value="" name="isquantityavailable<?php echo $k;?>" id="isquantityavailable<?php echo $k;?>">
      </div>                  
     <div style="float:left; padding:2px 5px;">
					  <input type="text" value="" id="Price<?php echo $k;?>" name="Price<?php echo $k;?>" size="10">
                        /= Tk. 
      </div>
	 <div style="float:left; padding:2px 5px;">
					    <img height="16" title="Available" src="./theme/default/images/001_06.gif" name="available" style="display:none;" id="ImageIsAvailableID1_<?php echo $k;?>"> <img height="16" title="Not Available" src="./theme/default/images/No-entry.png" name="available" style="display:none;" id="ImageIsNotAvailableID1_<?php echo $k;?>">
                        <input type="hidden" value="" name="isPriceavailable<?php echo $k;?>" id="isPriceavailable<?php echo $k;?>">
     </div>
	 <div style="clear:both"></div>
    
                  
            <?php
			
			echo ' <script type="text/javascript">
				$("#Quantity'.$k.'").keyup(function(){				
				
				var QuantityVal = $("#Quantity'.$k.'").val(); 
				var ProdDropval=$("#ProductName'.$k.'").val(); 
				
				if(QuantityVal!=\'\'){
					$.post("index.php?Theme=admin&Base=Page&Script=QuantityAvailable&NoHeader&NoFooter&ProdID="+ProdDropval,"Quantity="+QuantityVal,function(data){
						//alert(data);
						if(data=="1"){
							$("#ImageIsAvailableID'.$k.'").css(\'display\', \'block\');
							$("#ImageIsNotAvailableID'.$k.'").css(\'display\', \'none\');
							$("#isquantityavailable'.$k.'").val("1");
						}
						if(data=="0"){
							$("#ImageIsNotAvailableID'.$k.'").css(\'display\', \'block\');
							$("#ImageIsAvailableID'.$k.'").css(\'display\', \'none\');
							$("#isquantityavailable'.$k.'").val("0");
						
						}
						
					});
				
				}	
				
				
				
			});	
			
			$("#Price'.$k.'").keyup(function(){
				
				var PriceVal = $("#Price'.$k.'").val(); 
				var ProdDropval=$("#ProductName'.$k.'").val(); 
				
				if(PriceVal!=\'\'){
					$.post("index.php?Theme=admin&Base=Page&Script=PriceAvailable&NoHeader&NoFooter&ProdID="+ProdDropval,"Price="+PriceVal,function(data){
						//alert(data);
						if(data=="1"){
							$("#ImageIsAvailableID1_'.$k.'").css(\'display\', \'block\');
							$("#ImageIsNotAvailableID1_'.$k.'").css(\'display\', \'none\');
							$("#isPriceavailable'.$k.'").val("1");
						}
						if(data=="0"){
							$("#ImageIsNotAvailableID1_'.$k.'").css(\'display\', \'block\');
							$("#ImageIsAvailableID1_'.$k.'").css(\'display\', \'none\');
							$("#isPriceavailable'.$k.'").val("0");
						
						}
						
					});
				
				}	
				
				
				
			});
			
			</script>
			';
			
			
			?>
	</div>