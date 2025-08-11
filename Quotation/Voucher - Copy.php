<?php
	
$Expense=SQL_Select($Entity="PurchaseProducts", $Where="PurchaseID='{$_REQUEST["RefNo"]}'","","True");

$Customer=SQL_Select($Entity="Customer", $Where="CustomerID='{$Expense["VendID"]}'","","True");


	switch($Expense['PaymentMethod']){
	 
	 case 'cash':
	  $PaymentMethodRowPrint='<tr><td align="right" colspan="4"><b>Paid Amount :</b></td>
	  <td>Tk. <i><u>'.$Expense['Price'].'</u></i></td></tr>'; 	 
	 break;
	 	 
	 case 'due':
	 $PaymentMethodRowPrint='
	 <tr><td align="right" colspan="4"><b>Paid Amount :</b></td>
	 <td> Tk. <i><u> '.$Expense['PaidAmount'].'</u></i></td></tr>	 
	 <tr><td align="right" colspan="4"><b>Due Amount :</b></td><td> Tk. <i><u>'.$Expense['DueAmount'].'</u></i></td></tr>
	 <tr><td align="right" colspan="4"><b>Due Date :</b></td><td><i><u>'.$Expense['DueDate'].'</u></i></td></tr>';
	 break;
	 	 
	 case 'cheque':
	 $PaymentMethodRowPrint="<tr><td colspan='4' align='right'><b>Check No:</b></td>
	 <td>".$Expense["checkno"]."</td></tr><tr><td colspan='4' align='right'><b>Bank Name:</b></td>
	 <td>".$Expense["bankname"]."</td></tr><tr><td colspan='4' align='right'><b>Check Date:</b></td>
	 <td>".$Expense["CheckDate"]."</td></tr>";
	 break;
	 	 
	 case 'card':
	 $PaymentMethodRowPrint="<tr><td colspan='4' align='right'><b>Card No:</b></td>
	 <td>".$Expense["cardno"]."</td></tr><tr><td colspan='4' align='right'><b>Card Name:</b></td>
	 <td>".$Expense["cardname"]."</td></tr><tr><td colspan='4' align='right'><b>Card Date:</b></td>
	 <td>".$Expense["cardDate"]."</td></tr>";
	 
	 break;
	
	
	}

$GetCompanyInfo=SQL_Select("Settings","SettingsID=503","","true");
/*$GetCompanyInfo=mysql_fetch_assoc(mysql_query("select * from `tblsettings` where SettingsID=503 "));
echo "select * from `tblsettings` where SettingsID=1 ";

print_r($GetCompanyInfo);*/


$MainContent.="

	<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
	<html>
	<head>
	<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" /><title>Invoice</title>
	<style type='text/css'>
	th{
		text-align:left;
		padding-left:5px;
		
	}
	td{
	  padding-left:5px;
	}
	
	</style>
	
	</head>
	<body>


	<fieldset>
		<legend>Ref No : {$_REQUEST["RefNo"]}</legend>

	<table width=\"800\" align=\"center\" border=\"0\" cellpadding='0' cellspacing='0'>
		<tr>
			<td>
				<table>
					<tr><th>Name:</th><td>".$Expense['PurchaseName']."</td></tr>
					<tr><th>Vendor:</th><td>".$Expense['VendorNane']."</td></tr>
					<tr><th>Date:</th><td>".$Expense['DateInserted']."</td></tr>
				</table>
			</td>
		
		    <td align=\"right\">
                {$GetCompanyInfo["CompanyName "]}<br/>
	            {$GetCompanyInfo["Address"]}<br/>
				{$GetCompanyInfo["City"]},{$GetCompanyInfo["Zip"]}<br/>
				{$GetCompanyInfo["Country"]}
			</td>
		</tr>
		<tr>
		    <td colspan='2'>
			
			<table cellpadding='0' cellspacing='0' border='1' width='100%'><tr><th width='14%'>Product code</th><th colspan='2'>Name</th><th width='90'>Qty</th><th>Price</th></tr>";
			
			$productQuery=mysql_query("select * from `tblpurchaseproducts` where PurchaseID='".$Expense['PurchaseID']."'");
				while($prdasoc=mysql_fetch_assoc($productQuery)){
					$prdName=mysql_fetch_assoc(mysql_query("select * from `tblproducts` where ProductsID='".$prdasoc['ProductsID']."'"));
					//$VendName=mysql_fetch_assoc(mysql_query("select * from `tblvendor` where VendorID='".$prdasoc['VendID']."'"));
					
					$MainContent.='<tr>
					<td>'.$prdasoc['ProductsID'].'</td>					
					<td colspan="2">'.$prdName['ProductName'].'</td>
					<td>'.$prdasoc['Qty'].' X '.floor($prdasoc['PrdPrice']/$prdasoc['Qty']).'</td>
					<td>'.$prdasoc['PrdPrice'].'</td>
					</tr>';
				
				}	
				
		   $MainContent.="	      
			  <tr><td colspan='4' align='right'><b>Total Amount :</b></td><td>Tk. <i><u>{$Expense["Price"]}</u></i></td></tr>
		      ".$PaymentMethodRowPrint."			  
			  <tr><td colspan='5'><b>In word :</b> <u><i>".convertNumberToWords($Expense["Price"])."</i></u>&nbsp;&nbsp;Taka Only
		       </td></tr> 
		   </table>    
		    
		            
				
				
";

$purchaseDueTExt=getPurchasePayDue($Expense['VendorNane'],$Expense['PurchaseID']);

if($purchaseDueTExt!=''){
 
 $dueText='<table><tr><th>Ref</th><th>Due amount</th></tr>'.$purchaseDueTExt.'</table>';
}else{
 $dueText='No previous Due';
}

$MainContent.="
				
				<br>
				<div style='padding:8px;border: 1px solid black; float:left; width:200px;'>
					<b>Previous Due :</b> <br>
					".$dueText."				
				</div>	
				
				<div style=\"clear:both;height:20px;\"></div> 
				
				<div style='margin-left:50px; text-align:center; float:left; width:200px;'>
				<br />
				<br />
				<br />
				<hr/>
                Receive By
				</div>	
				
				
				<div style='margin-left:322px; text-align:center; float:left; width:200px;'>
				<br />
				<br />
				<br />
				<hr/>
                Office Authority
				</div>
				
			</td>
		</tr>
	</table>
	</fieldset>

	<center style='font-family:arial;font-size:12px;'>
		Developed by N.I Biz Soft Solutions. cell : 01712643138, email : info@nibizsoft.com
	</center>
	
	<script language=\"JavaScript\">
			//window.print();
			//window.close();
	</script>

</body>
</html>
";




?>