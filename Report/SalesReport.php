<?

//GetPermission("OptionReport");

if($_REQUEST["Customer"]!="")
	$SalesReport= SQL_Select("Sales","CustomerID='{$_REQUEST["Customer"]}' and SalesIsActive=1 order by SalesID DESC");
else
	$SalesReport= SQL_Select("Sales","SalesIsActive=1 order by SalesID DESC");


if($_REQUEST["UserReport"]=="Yes") {
	$UserWiseReport= "UserIDInserted={$_REQUEST["UserID"]} and WareHouseID='{$_REQUEST["WareHouseID"]}' and ";
	$UserWiseReportHTML = "for user ".GetUserName($_REQUEST["UserID"])."";
}

if($_REQUEST["Date"]=="Yes"){
	if($_REQUEST["Customer"]!=""){
		$SQLSales="CustomerID={$_REQUEST["Customer"]} and ";
		$SalesText="Customer : ".GetCustomerName($_REQUEST["Customer"])."";
	}
	$SalesReport= SQL_Select("Sales","{$SQLSales} {$UserWiseReport} SalesIsActive=1 and DateInserted between '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}' order by SalesID DESC");

	$ReportHTML='
		<span style="color:black;font-family:arial;text-decoration:none;">
			Date : <b>'.$_REQUEST["FromDate"].'</b> To <b>'.$_REQUEST["ToDate"].'</b><br>
			'.$SalesText.'
		</span>
	';
}


if($_REQUEST["InvoiceNumber"]!=""){

	if($_REQUEST["InvoiceNumber"]>1)
		$SalesReport= SQL_Select("Sales","SalesIsActive=1 and SalesID={$_REQUEST["InvoiceNumber"]}  order by SalesID DESC");
	else{
		echo 'wrong input';
		exit;
	}
}


$i=1;
foreach($SalesReport as $ThisSalesReport){

	$TotalSales = GetSalesOrderTotalAmount($ThisSalesReport["TempNumber"]);
	$TotalDue = GetSalesDueAmount($ThisSalesReport["TempNumber"]);

	$GrandTotalSales = $GrandTotalSales + $TotalSales;
	$GrandTotalDue = $GrandTotalDue + $TotalDue;


	$SalesReportHTML.='
	
		<tr>
			<td width="45" align="center" style="border : 1px solid black;">
				'.$i.'.
			</td>
			<td width="100" align="center" style="border : 1px solid black;">
				'.date("M j, y", strtotime($ThisSalesReport["DateInserted"])).'
			</td>
			<td align="left" style="border : 1px solid black;">
				<a style="color:blue;font-family:arial;text-decoration:none;"  href="index.php?Theme=default&Base=Sales&Script=Manage&Action=Edit&EditTempNumber='.$ThisSalesReport["TempNumber"].'&CID='.$ThisSalesReport["CustomerID"].'">
					Edit
				</a>
				|
				<a style="text-decoration:none;" href="./index.php?Theme=default&Base=Sales&Script=Invoice&TempNumber='.$ThisSalesReport["TempNumber"].'&NoHeader&NoFooter"><span style="color:blue;">Invoice </span></a>
				|
				<a style="text-decoration:none;" href="./index.php?Theme=default&Base=Sales&Script=Chalan&TempNumber='.$ThisSalesReport["TempNumber"].'&NoHeader&NoFooter"><span style="color:blue;">Chalan </span></a><span># '.$ThisSalesReport["SalesID"].'</span>
				
				<br>
				<div style="padding:5px;">
				'.GetInvoiceNumberAndProductList($ThisSalesReport["CustomerID"],$ThisSalesReport["TempNumber"],True).'
				</div>
				<div style="padding:5px;float:right;">
					Total: '.$TotalSales.'/=  Due: '.$TotalDue.'/=
				</div>
				'.$ThisSalesReport["UserIDInserted111"].'
				
			</td>
			<td align="middle" style="border : 1px solid black;">
				&nbsp;'.GetCustomerName($ThisSalesReport["CustomerID"]).'
			</td>
			
		</tr>
		

	
	';

	$i++;
}

if($SalesReportHTML=="")
	$SalesReportHTML='No record found.';
$MainContent.='

	<center>
		<h1>Sales Report '.$UserWiseReportHTML.'</h1>
		<div style="font-size:15px;width:830px;margin: auto 0px;">Date : '.$_REQUEST["FromDate"].' to '.$_REQUEST["ToDate"].'</div>
	</center>
	
	<table border=0 width="1000" style="border : 0px solid black;" align="center">
		<tr>
			<td width="45" align="center" style="border : 1px solid black;">
				SL
			</td>
			<td align="center" style="border : 1px solid black;">
				Date
			</td>
			<td align="center" style="border : 1px solid black;">
				Invoice
				<div style="float:right;">Price&nbsp;</div>
				<div style="float:right;">&nbsp;&nbsp;</div>
				<div style="float:right;">Qty&nbsp;</div>
			</td>
			<td align="center" style="border : 1px solid black;">
				Customer
			</td>
			
		</tr>
		<center>
		<span style="color:red;">'.$SalesReportHTML.'</span>
		<tr>
			<td colspan=3 align="right">
			
				<b>Total</b> : '.$GrandTotalSales.'/= &nbsp;&nbsp;	<b>Due</b> : '.$GrandTotalDue.'/=			

			</td>
			<td>
			</td>
		</tr>	
		
		</center>
	</table>
	
<!--
	<div style="width:800px;padding:10px;">
		<fieldset>
			<legend>Sales Report</legend>
			
				<div style="border: 0px solid black;padding:0px;">
					<div style="float:left;width:400px;">
						Date
					</div>
					<div style="float:left;">
						Invoice
					</div>
					<div style="float:right;">
						Customer
					</div>
				</div>			
				<div style="clear:both;"></div>				
				'.$ReportHTML.'<br>

				'.$SalesReportHTML.'
				
			
		</fieldset>
	</div>
--!>	
';


/*
		<div style="border: 1px solid black;padding:0px;">
			<div style="float:left;width:400px;">
				<a style="color:blue;font-family:arial;text-decoration:none;"  href="index.php?Theme=default&Base=Sales&Script=Manage&Action=Edit&EditTempNumber='.$ThisSalesReport["TempNumber"].'&CID='.$ThisSalesReport["CustomerID"].'">
					Edit
				</a>
				&nbsp;|&nbsp;
				<a target="_blank" style="color:blue;font-family:arial;text-decoration:none;" href="index.php?Theme=default&Base=Sales&Script=Invoice&TempNumber='.$ThisSalesReport["TempNumber"].'&NoHeader&NoFooter">
					Print
				</a>
				&nbsp;
				<b>'.$ThisSalesReport["SalesID"].'</b> to '.GetCustomerName($ThisSalesReport["CustomerID"]).'
			</div>
			<div style="float:left;">
				'.PrevioiusDueForSalesOrder($ThisSalesReport["CustomerID"],$ThisSalesReport["TempNumber"],True).'
			</div>
			<div style="float:right;">
				'.$ThisSalesReport["DateInserted"].'
			</div>
		</div>

		<div style="clear:both;"></div>	 */



?>