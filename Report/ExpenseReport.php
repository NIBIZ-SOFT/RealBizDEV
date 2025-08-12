<?


if($_REQUEST["ExpenseHead"]=="")
    $ExpenseData = SQL_Select("ExpenseList","1=1 and ExpenseListDate between '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}'");
else    
    $ExpenseData = SQL_Select("ExpenseList","ExpenseListName='{$_REQUEST["ExpenseHead"]}' and ExpenseListDate between '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}'");

$x=1;    
foreach($ExpenseData as $ThisExpenseData){
    $HTML.='
    
		<tr>
			<td width="45" align="center" style="border : 1px solid black;">
				'.$x.'.
			</td>
			<td align="center" style="border : 1px solid black;">
				'.$ThisExpenseData["ExpenseListName"].'
			</td>
			<td align="center" style="border : 1px solid black;">
				'.$ThisExpenseData["ExpenseListPaidTo"].'
			</td>
			<td align="center" style="border : 1px solid black;">
				'.$ThisExpenseData["ExpenseListAccountType"].'
			</td>
			<td align="center" style="border : 1px solid black;">
				'.$ThisExpenseData["ExpenseListDate"].'
			</td>
			<td align="center" style="border : 1px solid black;">
				'.$ThisExpenseData["ExpenseListTotalAmount"].'
			</td>
		</tr>    
    ';
    $Total = $Total + $ThisExpenseData["ExpenseListTotalAmount"];
    $x++;
    
}    

$MainContent.='
	<title>Expense Report</title>
	<center>
	<h1>Expense Report</h1>
	<div style="font-size:20px;width:830px;margin: auto 0px;">Date : '.$_REQUEST["FromDate"].' to '.$_REQUEST["ToDate"].'</div>
	<table border=0 width="800" style="border : 0px solid black;" align="center">
		<tr>
			<td width="45" align="center" style="border : 1px solid black;">
				<b>SL</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Head</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Paid To</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Account</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Date</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				
                                <b>Amount</b>
			</td>
		</tr>
		'.$HTML.'
		<tr>
			<td width="45" align="center" style="border : 0px solid black;">
				
			</td>
			<td align="right" style="border : 0px solid black;">
			</td>
			<td align="right" style="border : 0px solid black;">
			</td>
			<td align="center" style="border : 0px solid black;">
				
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Total&nbsp;</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Tk. '.$Total.'/=</b>
			</td>
		</tr>
	</table>

		
	</center>
	
			

';


?>