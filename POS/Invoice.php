<?php
ob_start();
//GetPermission("OptionSales");	

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
                
        $GetProductInfo = SQL_Select("Products","ProductsID={$ThisPurchaseProducts['ProductID']}","",true);        
		
	$HTML.='
		<tr>
			<td align="center">'.$i.'.</td>					
			<td >
				<div style="padding:5px;">
                                        '.$GetProductInfo["ProductName"].' <br>
					'.GetProductCategoryName($ThisPurchaseProducts['ProductID']).'<br>
					<span style="font-size:14px;">'.$GetProductInfo["Color"].','.$GetProductInfo["Grade"].','.$GetProductInfo["Origin"].'</span>
				</div>
			</td>
			
			<td align="center">'.$GetProductInfo['Size'].'</td>
			<td align="center">'.$GetProductInfo['Brand'].'</td>
			<td align="center">'.$GetProductInfo['Units'].'</td>
			<td align="center">'.$ThisPurchaseProducts['Qty'].'</td>
			<td align="center">'.$ThisPurchaseProducts['Price'].'</td>
			<td align="right">'.$ThisPurchaseProducts['Qty']*$ThisPurchaseProducts['Price'].' /= &nbsp;&nbsp;</td>
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
        
        
    ';
    
}

$MainContent.='
	<title>Invoice No. : CW-SALES-INV-'.GetSalesID($_REQUEST["TempNumber"]).'</title>
        
       
        
	<div style="width:800px;">
                '.$CompanyPad.'
		<fieldset>
			<legend>Invoice No. : '.$GetCompanyInfo["InvoicePrifix"].'-'.GetSalesID($_REQUEST["TempNumber"]).'</legend>
				
				<table width="800" align="center" border="0">
					
					<tr>
						<td>
							Customer : '.$Customer["CustomerName"].' <br>
							Phone : '.$Customer["Phone"].'<br>
							Address : '.$Customer["Address"].'
						</td>
					
						<td align="right">
							Sales by : '.GetUserName($GetCustomerID["SalesBy"]).' <br>
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
							<b>Size</b>
						</td>
						<td width="50" align="center">
							<b>Brand</b>
						</td>
						<td width="50" align="center">
							<b>Units</b>
						</td>
						<td width="50" align="center">
							<b>Qty</b>
						</td>
						<td width="50" align="center">
							<b>Price</b>
						</td>
						<td align="right" width="100">
							<b>Total Price</b>&nbsp;&nbsp;
						</td>
					</tr>
					'.$HTML.'
					<tr>
						<td colspan="9" align="right">
							<span style="font-size:18px;font-weight:bold;">Total : '.$GrandTotal.' /= </span>&nbsp;&nbsp;
						</td>
					</tr>
				</table>
				Grand Total In words : <i>'.convertNumberToWords($GrandTotalAfterDiscount).'</i>

		
		
				<br>
				<br>
                                ';
                                $IfDue = PrevioiusDueForSalesOrder($Customer["CustomerID"],$_REQUEST["TempNumber"]);
                                
                                if($IfDue!="No Previous Due")
                                    $MainContent.='
                                        <div style="padding:8px;border: 1px solid black; float:left; width:280px;">
                                                <b>Previous Due :</b> <br>
                                                '.$IfDue.'				
                                        </div>
                                    
                                    ';
                                
                                
                                $MainContent.='
				
				<div style="padding:8px;border: 1px solid black; float:right; width:300px;">
					<b>Payment History :</b> <br>
					'.ShowSalesFunding($_REQUEST["TempNumber"]).'				
				</div>	
				
				<div style="clear:both;height:30px;"></div> 
				Terms & Condition : <br>
                                    '.nl2br($GetCompanyInfo["InvoiceTerms"]).'
				
                                <br><br>
                                <center>
                                <b>*This is an electronically generated invoice, which requires no sign.</b><br>
				</center>	
				
				<div style="clear:both;height:20px;"></div> 
				
				<div style="margin-left:50px; text-align:center; float:left; width:200px; display:none;">
                                        <br />
                                        <br />
                                        <br />
                                        <hr/>
                        Receive By
                                        </div>	
                                        
                                        
                                        <div style="margin-left:322px; text-align:center; float:left; width:200px;display:none;">
                                        <br />
                                        <br />
                                        <br />
                                        <hr/>
                        Office Authority
				</div>
		
		
			</fieldset>	
		
		
	</div>
	
		<div sytle="clear:both;"></div>
';



?>

