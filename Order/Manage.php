<?php
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";
	

	SetFormvariable("RecordShowFrom", 1);
    SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
    SetFormvariable("SortBy", "{$OrderByValue}");
    SetFormvariable("SortType", "DESC");
	$MainContent.="<img style=\"vertical-align: middle;width:35px;height:30px;\" src=\"./theme/default/images/sellorder.png\">&nbsp;&nbsp;&nbsp;<b style=\"font-size:16px;\">Sales Order</b>
	";	

	if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	// Delete a data
	if(isset($_GET["DeleteConfirm"]))SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");

    $Where="1 = 1";
	if($_POST["FreeText"]!="")
		$Where.=" and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";

	// DataGrid
	//$MainContent.='<script type="text/javascript" s';
	
	
	/*$MainContent.= CTL_Datagrid(
		$Entity,
		$ColumnName=array( "OrderID","ProductName","Date" , "Quantity" , "Price" , "PaymentMethod"),
		$ColumnTitle=array( "Invoice", "Products Name", "Date" , "Quantity" , "Price" , "Payment" ),
		$ColumnAlign=array( "left", "left", "left" , "left" , "left" , "left" ),
		$ColumnType=array( "text",  "text", "text" , "text" , "text" , "text"),
		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
		$ActionLinks=true,
		$SearchPanel=true,
		$ControlPanel=true,
		$EntityAlias="".$EntityCaption."",
		$AddButton=true
	);
	
	*/
	
ob_start();
	
//ApplicationURL("Order","Manage&ActionNewOrder=1&SearchCombo=");
	
?>
<script type="text/javascript" src="script/fusebox.js"></script>
<script>
function confirmSubmit(url){
						var agree=confirm("Are you sure you want to delete?");
						if(agree){
							window.location=url;
						}
						else
							return false ;
					}
</script>
<?php
  
  $TotalDataRowQuery=mysql_query("select * from `tblorder`");
  
  if($_REQUEST['PageNo']=='' or $_REQUEST['PageNo']==1){
      $queryStart=0;
  	  $prvBtnOnclick="alert('This Operation Not Possible!')";
      $nextBtnOnclick="window.location='".ApplicationURL("Order","Manage&RecordShowFrom=51&SortBy=OrderID&SortType=DESC&PageNo=2&SearchCombo=")."'";
  }else{
      $queryStart=($_REQUEST['PageNo']-1)*50+1;
	  	 
	 if(floor(count($TotalDataRowQuery)/50)>$_REQUEST['PageNo']){
	 
	   $prvRecordShowFrom=($_REQUEST['PageNo']-2)*50+1;
	   $nextRecordShowFrom=$queryStart;
		
	   $prvBtnOnclick="window.location='".ApplicationURL("Order","Manage&RecordShowFrom=".$prvRecordShowFrom."&SortBy=OrderID&SortType=DESC&PageNo=".($_REQUEST['PageNo']-1)."&SearchCombo=")."'";
       $nextBtnOnclick="window.location='".ApplicationURL("Order","Manage&RecordShowFrom=".$nextRecordShowFrom."&SortBy=OrderID&SortType=DESC&PageNo=".($_REQUEST['PageNo']-1)."&SearchCombo=")."'";
 
	 }else{
	   $prvBtnOnclick="window.location='".ApplicationURL("Order","Manage&RecordShowFrom=51&SortBy=OrderID&SortType=DESC&PageNo=".($_REQUEST['PageNo']-1)."&SearchCombo=")."'";
       $nextBtnOnclick="alert('This Operation Not Possible!')";
 
	 }
	 
	 
	 
  }
  

 $query=mysql_query("select * from `tblorder` limit ".$queryStart.",50");


?>

<tr>
	<td><br>
								 
		 <img onclick="window.location='<?php echo ApplicationURL("Order","Manage&ActionNewOrder=1&SearchCombo=");?>'" style="border: #ff33cc; cursor: pointer;" alt="Add New Order" src="./theme/default/image/datagrid/add.gif">&nbsp;&nbsp;
	
			<img onclick="<?php echo $prvBtnOnclick;?>" style="border: #ff33cc; cursor: pointer;  padding-top: 0px;" alt="Previous" src="./theme/default/image/datagrid/leftarrow.gif">&nbsp;
			<b><?php echo $_REQUEST['PageNo'];?></b>&nbsp;<img onclick="<?php echo $nextBtnOnclick;?>" style="border: #ff33cc; cursor: pointer; " alt="Next" src="./theme/default/image/datagrid/rightarrow.gif">

								 <select class="DataGridComboBox" name="SearchCombo" style="visibility: visible;"><option value="OrderID">Invoice</option><option value="ProductName">Products Name</option><option value="Date">Date</option><option value="Quantity">Quantity</option><option value="Price">Price</option><option value="PaymentMethod">Payment</option></select><input type="text" style="" class="DataGridSearchBox" size="26" title="" value="" name="FreeText" id="FreeText"> <input type="submit" onclick="" style="" class="DataGridButton" size="" title="" value="Search" name="" id="">
								 <input type="button" onclick="window.location='<?php echo ApplicationURL("Order","Manage&ActionNewOrder=1&SearchCombo=");?>'" style="" class="DataGridButton" size="" title="" value="Show All" name="" id="">
						</td>
					</tr>

<table cellspacing="0" border="0" class="DataGrid_GridTable">
	<tbody>
	    <tr valign="middle" class="DataGrid_Title_Table_Bar">
		<td class="DataGrid_ColumnTitle_Row_Serial_Cell">&nbsp;&nbsp;&nbsp;SL&nbsp;No.</td>
		<td width="20"></td>
		<td width=""><a class="DataGrid_ColumnTitle_Link" href="">Invoice</a><img src="./theme/default/image/datagrid/datagrid_sortorder_desc.gif"></td>
		<td></td>
		<td width=""><a class="DataGrid_ColumnTitle_Link" href="">Date</a></td>		
		<td width=""><a class="DataGrid_ColumnTitle_Link" href="">Total Price</a></td>
		<td width=""><a class="DataGrid_ColumnTitle_Link" href="">Payment</a></td>
		<td class="DataGrid_ColumnTitle_Row_Action_Cell">&nbsp;Options&nbsp;</td>
		</tr>
	
	  <?php
	  $incr=1;
	 
	  while($asoc=mysql_fetch_assoc($query)){
	  
	  	echo '<tr>
		       <td>'.$incr.'</td>
			   <td></td>
		       <td>'.$asoc['OrderID'].'</td>
		       <td><!--(( Products list ))-->
			   <div style="cursor:pointer; " onclick="document.getElementById(\'prdbox'.$incr.'\').style.display=\'block\'">View products</div>
			   <div id="prdbox'.$incr.'" style="display:none; padding:12px; border:1px solid #000; background:#ffffff; position:absolute;">
			   <div style="float:right; cursor:pointer;" onclick="document.getElementById(\'prdbox'.$incr.'\').style.display=\'none\'">close</div>
			   <div style="clear:both"></div>
			     <table border="1">
				 	<tr><th>Product Name</th><th>Quantity</th><th>Price</th></tr>
				';
				$totalPrice=0;
				//echo "select * from `tblorderproducts` where OrderID='".$asoc['OrderID']."'";
				$productQuery=mysql_query("select * from `tblorderproducts` where OrderID='".$asoc['OrderID']."'");
				while($prdasoc=mysql_fetch_assoc($productQuery)){
					echo '<tr><td>'.$prdasoc['ProdID'].'</td>
					<td>'.$prdasoc['Qty'].'</td>
					<td>'.$prdasoc['Price'].'</td>
					</tr>';
					 $totalPrice+=$prdasoc['Price'];
					
				}
				
				echo '
				<tr><td colspan="2" align="right">Total Price:</td><td>'.$totalPrice.'</td></tr>
				 </table>
			   </div>
			   
			   </td><!--(( Products list end ))-->
			   <td>'.$asoc['Date'].'</td>
			   <td>'.$asoc['Price'].'</td>
			   <td>'.$asoc['PaymentMethod'].'</td>
			   <td align="center">
							<a href="'.ApplicationURL("Order","Insertupdate&OrderID=".$asoc['OrderID']."&OrderUUID=".$asoc['OrderUUID']."&SearchCombo=").'"><img width="16" height="16" style="border: #ff33cc;" alt="Edit" src="./theme/default/image/datagrid/Edit.gif"></a>
            				<img onclick="confirmSubmit(\''.ApplicationURL("Order","Manage&OrderID=".$asoc['OrderID']."&OrderUUID=".$asoc['OrderUUID']."&DeleteConfirm&SearchCombo=").'\')" style="border: #ff33cc; cursor: pointer; " alt="Delete" src="./theme/default/image/datagrid/Delete.gif">
			   </td>
			 </tr>';
	  
	     
	 $incr++; }
	        
	  ?> 


	</tbody>
</table>

<?php

$MainContent.=ob_get_contents();

ob_end_clean();
