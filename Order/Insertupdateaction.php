<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"]))$UpdateMode=true;

    $ErrorUserInput["_Error"]=false;

	if(!$UpdateMode)$_REQUEST["{$Entity}ID"]=0;
	//some change goes here
	$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$UniqueField} = '{$_POST["{$UniqueField}"]}' AND {$Entity}ID <> {$_REQUEST[$Entity."ID"]}");
    //'
	$InvoiceNo=$_POST["InvoiceNo"].$_POST["CustomerName"];
	
	if(count($TheEntityName)>0){
	    $ErrorUserInput["_Error"]=true;
	    $ErrorUserInput["_Message"]="This Value Already Taken.";
	}

    if($ErrorUserInput["_Error"]){
        include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	}else{
	    $Where="";
	    if($UpdateMode)$Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'";

		if($_POST["CustomCustomerName"]!=""){
			$InsertNewCustomer=SQL_InsertUpdate(
				"Customer",
				$The_Entity_NameData=array(
					"CustomerName"=>$_POST["CustomCustomerName"],
					"Address"=>$_POST["CustomCustomerAddress"],
					"Phone"=>$_POST["CustomCustomerPhone"],
				),
				""
				
			);		
			$_POST["CustomerName"]=$InsertNewCustomer["CustomerID"];
		
		}		
        
		//$GetProductname=SQL_Select("Products","ProductsID={$_POST["ProductName"]}","","true");
		
		// give the data dase fields name and the post value name
	    $TheEntityName=SQL_InsertUpdate(
	        $Entity="{$Entity}",
			$TheEntityNameData=array(
                                                                                              
				"CustomerID"=>$_POST["CustomerName"],
				/*"ProductsID"=>$_POST["ProductName"],
				"ProductName"=>$GetProductname["ProductName"],*/
				"InvoiceNo"=>$InvoiceNo,
				"Date"=>$_POST["Date"],
				/*"Quantity"=>$_POST["Quantity"],*/
				"Price"=>$_POST["Price"],
				"PaymentMethod"=>$_POST["PaymentMethod"],
				"checkno"=>$_POST["checkno"],
				"bankname"=>$_POST["bankname"],
				"CheckDate"=>$_POST["CheckDate"],
				"cardno"=>$_POST["cardno"],
				"cardname"=>$_POST["cardname"],
				"cardDate"=>$_POST["cardDate"],
		        "PaidAmount"=>$_POST["PaidAmount"],
				"DueAmount"=>$_POST["DueAmount"],
				"DueDate"=>$_POST["DueDate"],
		
			),
			$Where
			);
			
		  $lastId=mysql_fetch_assoc(mysql_query("select * from `tblorder` order by OrderID desc limit 1"));	
		  
		  for($k=1;$k<=50; $k++){
		  
		  	if($_REQUEST['ProductName'.$k]!=''){
			
			    if($UpdateMode){
					if($_POST['OrdProID'.$k]!=''){	
					mysql_query("update `tblorderproducts` set `ProdID`='".$_REQUEST['ProductName'.$k]."',`Qty`='".$_REQUEST['Quantity'.$k]."',`Price`='".$_REQUEST['Price'.$k]."' where OrdProID='".$_REQUEST['OrdProID'.$k]."'" );
			
					}else{
					mysql_query("insert into `tblorderproducts` set `OrderID`='".$lastId['OrderID']."',`ProdID`='".$_REQUEST['ProductName'.$k]."',`Qty`='".$_REQUEST['Quantity'.$k]."',`Price`='".$_REQUEST['Price'.$k]."'" );
			
					}
				
				}else{
				mysql_query("insert into `tblorderproducts` set `OrderID`='".$lastId['OrderID']."',`ProdID`='".$_REQUEST['ProductName'.$k]."',`Qty`='".$_REQUEST['Quantity'.$k]."',`Price`='".$_REQUEST['Price'.$k]."'" );
			
				}
				
				///--Update Table Products--------------
				if($_POST["{$Entity}IsActive"]==1)	{
					$ProductsEdit=SQL_Select("Products","ProductsID='".$_POST["ProductName".$k]."'","","true");
					SQL_InsertUpdate(
						"Products",
						$The_Entity_NameData=array(
							"Quantity"=>$ProductsEdit["Quantity"]-$_POST["Quantity".$k],
						),
							$Where= "ProductsID ='".$_POST["ProductName".$k]."'"
						
					);		
				}
				///End 	Update Table Products-----------
			
              }else if($_POST['OrdProID'.$k]!=''){
			     mysql_query("Delete from `tblorderproducts` where OrdProID='".$_POST['OrdProID'.$k]."'" );
			 
			  }
		  
		  
		  }
		  
			
		If($_REQUEST["PrintPreview"]==1)
			$MainContent.="
				<script language=\"JavaScript\">
						window.open('".ApplicationURL("Order","Voucher&RefNo={$lastId["OrderID"]}&NoHeader&NoFooter")."', 'NewCustomerFormOfficeCopy', 'toolbar=0, status=0, location=0, menubar=0, resizable=0, scrollbars=1,');
				</script>
			";
			
			
			
			
	    $MainContent.="
	        ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","Manage")."\">here</a> to proceed.",300)."
	        <script language=\"JavaScript\" >
	            //window.location='".ApplicationURL("{$_REQUEST["Base"]}","Manage")."';
	        </script>
		";
	}
?>