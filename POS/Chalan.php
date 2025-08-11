<?php

GetPermission("OptionSales");	

$PurchaseProducts=SQL_Select($Entity="SalesOrder", $Where="TempNumber='{$_REQUEST["TempNumber"]}'","","");

$GrandTotal=0;
$i=1;
foreach($PurchaseProducts as $ThisPurchaseProducts){
	//$ThisPurchaseProducts['ProductID']
	$SerialsHTML='';
	if($ThisPurchaseProducts['Serials']!="")
		$SerialsHTML='<br>SL:'.$ThisPurchaseProducts['Serials'].' ';
		
	if($ThisPurchaseProducts['Warranty']=="")
		$ThisPurchaseProducts['Warranty']="N/A";
		
	$HTML.='
		<tr>
			<td align="center">'.$i.'.</td>					
			<td >
				<div style="padding:5px;">
					'.GetProductCategoryName($ThisPurchaseProducts['ProductID']).' - '.GetProductName($ThisPurchaseProducts['ProductID']).' ('.$ThisPurchaseProducts['ProductID'].')
					<span style="font-size:13px;">'.$SerialsHTML.'</span>
				</div>
			</td>
			
			<td align="center">'.$ThisPurchaseProducts['Qty'].'</td>
			
		</tr>	
	
	';

	$GrandTotal = $ThisPurchaseProducts['Qty']*$ThisPurchaseProducts['Price'] + $GrandTotal;
	//echo $Vendor=$ThisPurchaseProducts["VendorID"];
	$i++;
}

//echo GetDiscount($_REQUEST["TempNumber"])."ss";
$GrandTotalAfterDiscount = $GrandTotal - GetDiscount($_REQUEST["TempNumber"]);

$GetCustomerID=SQL_Select($Entity="Sales", $Where="TempNumber='{$_REQUEST["TempNumber"]}'","","True");
if($GetCustomerID["CustomerID"]!="")
$Customer=SQL_Select($Entity="Customer", $Where="CustomerID={$GetCustomerID["CustomerID"]}","","True");
$GetCompanyInfo=SQL_Select("Settings","SettingsID=1","","true");

$CompanyPad=' <br><br><br><br><br><br>';
if($GetCompanyInfo["IsUseCompanyPad"]==1){
    
    $CompanyPad = '
        <table align="center">
            <tr>
                <td align="center">
                    
                    <b style="font-size:25px;">'.$GetCompanyInfo["CompanyName"].'</b><br>
                    '.nl2br($GetCompanyInfo["Address"]).'
                </td>
            </tr>
            
        </table>
        <br><br>
        
    ';
    
}

$MainContent.='
	<title>Challan No. : CW-SALES-DELC-'.GetSalesID($_REQUEST["TempNumber"]).'</title>
        
        
	<div style="width:800px;">
                '.$CompanyPad.'
		<fieldset>
			<legend>Challan No. : CW-SALES-DELC-'.GetSalesID($_REQUEST["TempNumber"]).'</legend>
				
				<table width="800" align="center" border="0">
					
					
					<tr>
						<td>
							Customer : '.$Customer["CustomerName"].' <br>
                                                        Address : '.$Customer["Address"].'<br>
							Phone : '.$Customer["Phone"].'
						</td>
					
						<td align="right">
							Sales by : '.GetUserName($GetCustomerID["SalesBy"]).' <br>
							Invoice No. : CW-SALES-DELC-'.GetSalesID($_REQUEST["TempNumber"]).' <br>
							Created on : '.date("F j, Y, h:i A",strtotime($ThisPurchaseProducts['DateInserted'])).'<br>
							Printed on : '.date("F j, Y, h:i A").'
						</td>
					</tr>			
				</table>
			
			
				<table cellpadding="0" cellspacing="0" border="1" width="100%">
					<tr>
						<td width="60">
							&nbsp;&nbsp;<b>SL No.</b>
						</td>
						<td align="center">
							&nbsp;&nbsp;<b>Product Name</b>
						</td>
						
						<td width="50" align="center">
							<b>Qty</b>
						</td>
						
					</tr>
					'.$HTML.'
					
				</table>
				
		
		
				<br>
				
				
		
				
				<div style="clear:both;height:20px;"></div> 
				
				<div style="margin-left:50px; text-align:center; float:left; width:250px;">
				<br />
				<br />
				<br />
				<hr/>
                                Received goods in good condition
				</div>	
				
				
				<div style="margin-left:322px; text-align:center; float:left; width:150px;">
				<br />
				<br />
				<br />
				<hr/>
                                Authorized Signature
				</div>
		
		
			</fieldset>	
		
		
	</div>
	
		<div sytle="clear:both;"></div>

';

?>