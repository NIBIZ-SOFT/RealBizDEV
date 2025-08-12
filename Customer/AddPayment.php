<?
	
//GetPermission("OptionReport");

// when payment submited
if(isset($_REQUEST["MassPayment"])){
    
    //echo "test";
    //print_r($_REQUEST["Invoices"]);
    if(count($_REQUEST["Invoices"])<1){
        
            echo '
            <script>
                alert("Please Choose Invoice(s)");
                window.location = "index.php?Theme=default&Base=Customer&Script=AddPayment&Customer='.$_REQUEST["Customer"].'";
            </script>
        
        ';
        exit;
        
    }
    
    $x=0;
    foreach($_REQUEST["Invoices"] as $ThisInvoice){
        
        //echo $ThisInvoice;
        SQL_InsertUpdate(
                "SalesFund",
                $The_Entity_NameData=array(
                        "PaymentMethod"=>$_REQUEST["PaymentMethod"],
                        "Amount"=>$_REQUEST["DueAmountArr"][$x],
                        "TempNumber"=>$_REQUEST["TempNumberArr"][$x],
                ),
                ""
        );        
        
    }
    
    echo '
        <script>
            alert("Payment Updated");
            window.location = "index.php?Theme=default&Base=Customer&Script=AddPayment&Customer='.$_REQUEST["Customer"].'";
        </script>
    
    ';
    
    exit;
    
}



if($_REQUEST["Customer"]!="")	
	$SalesReport= SQL_Select("Sales","CustomerID='{$_REQUEST["Customer"]}' and SalesIsActive=1 order by SalesID DESC");
else
	$SalesReport= SQL_Select("Sales","SalesIsActive=1 order by SalesID DESC");

if($_REQUEST["Date"]=="Yes"){
	if($_REQUEST["Customer"]!=""){
		$SQLSales="CustomerID={$_REQUEST["Customer"]} and ";
		$SalesText="Customer : ".GetCustomerName($_REQUEST["Customer"])."";
	}	
	$SalesReport= SQL_Select("Sales","{$SQLSales} SalesIsActive=1 and DateInserted between '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}' order by SalesID DESC");
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
	
	if($TotalDue>0)
            $SalesReportHTML.='
            
                    <tr>
                            <td width="45" align="center" style="border : 1px solid black;">
                                    '.$i.'.
                                    <input type="checkbox" name="Invoices[]" value="'.$ThisSalesReport["SalesID"].'">
                                    <input type="hidden" name="TempNumberArr[]" value="'.$ThisSalesReport["TempNumber"].'">
                                    <input type="hidden" name="DueAmountArr[]" value="'.$TotalDue.'">
                            </td>
                            <td width="100" align="center" style="border : 1px solid black;">
                                    '.date("M j, y", strtotime($ThisSalesReport["DateInserted"])).'
                            </td>
                            <td align="left" style="border : 1px solid black;">
                                    <a style="color:blue;font-family:arial;text-decoration:none;"  href="index.php?Theme=default&Base=Sales&Script=Manage&Action=Edit&EditTempNumber='.$ThisSalesReport["TempNumber"].'&CID='.$ThisSalesReport["CustomerID"].'">
                                            Edit
                                    </a>
                                    |
                                    <a style="text-decoration:none;" href="./index.php?Theme=default&Base=Sales&Script=Invoice&TempNumber='.$ThisSalesReport["TempNumber"].'&NoHeader&NoFooter">
                                    <span style="color:blue;">Invoice </span>
                                    </a><span># '.$ThisSalesReport["SalesID"].'</span>
                                    <br>
                                    <div style="padding:5px;">
                                    '.GetInvoiceNumberAndProductList($ThisSalesReport["CustomerID"],$ThisSalesReport["TempNumber"],True).'
                                    </div>
                                    <div style="padding:5px;float:right;">
                                            Total: '.$TotalSales.'/=  Due: '.$TotalDue.'/=
                                    </div>
                                    
                            </td>
                            
                    </tr>
                    
    
            
            ';	
	
	$i++;
}

if($SalesReportHTML=="")
	$SalesReportHTML='No record found.';
        
        
$GetPaymentMethod = explode(",",$Settings["PaymentMethod"]);
$x=0;
foreach($GetPaymentMethod as $ThisGetPaymentMethod){
	
	$HTMLPaymentMethod.='
		<option value="'.$GetPaymentMethod[$x].'">'.$GetPaymentMethod[$x].'</option>
	
	';
	
	$x++;
	
}        
        
$MainContent.='

	<center>
		<h1 style="font-size:20px;">Due Invoice for [ '.GetCustomerName($_REQUEST["Customer"]).' ] </h1>
	</center>
        <form action="index.php?Theme=default&Base=Customer&Script=AddPayment&Customer='.$_REQUEST["Customer"].'&MassPayment=Yes" method="post">
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
			
			
		</tr>
		<center>
		<span style="color:red;">'.$SalesReportHTML.'</span>
		<tr>
			<td colspan=3 align="right">
				<b>Due : '.$GrandTotalDue.'/=	</b>		
                                                                         
			</td>
			<td>
			</td>
		</tr>	                                                           
		
                
		</center>
	</table>
        
        <center>
                Payment Method : <br>
                <select name="PaymentMethod"  id="PaymentMethod" style="font-size:18px;width:150px;">
                        <option value="Cash">Cash</option>
                        '.$HTMLPaymentMethod.'
                </select>
                <br>
                <input type="submit" value="Add Payment" class="btn btn-primary">
        </center>

        </form>
	
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