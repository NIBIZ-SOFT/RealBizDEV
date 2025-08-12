<?


// echo "<pre>";

// print_r($_REQUEST);
// die();

function taka_format($amount = 0)
{
    $tmp = explode(".",$amount);  // for float or double values
    $strMoney = "";
    $amount = $tmp[0];
    $strMoney .= substr($amount, -3, 3);
    $amount = substr($amount, 0, -3);
    while (strlen($amount) > 0) {
        $strMoney = substr($amount, -2, 2) .",".$strMoney;
        $amount = substr($amount, 0, -2);
    }

    if (isset($tmp[1]))         // if float and double add the decimal digits here.
    {
        return $strMoney .".".$tmp[1];
    }
    return $strMoney;
}






GetPermission("OptionReport");		


if( !empty($_REQUEST["BankCashID"]) ){
	$ExpenseData= SQL_Select("Transaction","BankCashID='{$_REQUEST["BankCashID"]}' order by BankCashID DESC");
}

if( !empty($_REQUEST["CategoryID"]) and !empty($_REQUEST["ExpenseHead"]) ){
	$ExpenseData= SQL_Select("Transaction","ProjectID='{$_REQUEST["CategoryID"]}' and ExpenseHead= '{$_REQUEST["ExpenseHead"]}'");
}elseif ( !empty($_REQUEST["CategoryID"]) and !empty($_REQUEST["FromDate"]) and !empty( $_REQUEST["ToDate"] ) ) {
	$ExpenseData= SQL_Select("Transaction","ProjectID='{$_REQUEST["CategoryID"]}' and  Date BETWEEN '{$_REQUEST["FromDate"]}' AND  '{$_REQUEST["ToDate"]}'  ");
}elseif ( !empty($_REQUEST["CategoryID"]) ) {
	$ExpenseData= SQL_Select("Transaction","ProjectID='{$_REQUEST["CategoryID"]}' ");
}

// echo "<pre>";

// print_r($ExpenseData);
// die();




if (empty($ExpenseData)) {

$MainContent.='
	<title>Journal/Trx Report</title>
	<center>
	<br>
	<img src="http://napps.click/RelainceHoldings/upload/f7f8da37a84d0ebaf39823fee6b2cc6c_logo%20(Software).jpg">
	<h1>Journal/Trx Report</h1>
	<div style="display:none;font-size:20px;width:830px;margin: auto 0px;">Date : '.$_REQUEST["FromDate"].' to '.$_REQUEST["ToDate"].'</div>


		
  <h3 style="color:red;">Data is empty</h3>

	';
	
}else{


$x=1;
foreach($ExpenseData as $ThisExpenseData){
    $HTML.='
    
		<tr>
			<td width="45" align="center" style="border : 1px solid black;">
				'.$x.'.
			</td>
			<td align="center" style="border : 1px solid black;">
				'.$ThisExpenseData["BankCashName"].'
			</td>
			<td align="center" style="border : 1px solid black;">
				'.$ThisExpenseData["Type"].'
			</td>
			<td align="center" style="border : 1px solid black;">
				'.$ThisExpenseData["ProjectName"].'
			</td>
			<td align="center" style="border : 1px solid black;">
				'.taka_format($ThisExpenseData["Amount"]).'
			</td>
			<td align="center" style="border : 1px solid black;">
				'.$ThisExpenseData["Date"].'
			</td>
			<td align="center" style="border : 1px solid black;">
				'.taka_format($ThisExpenseData["dr"]).'
			</td>
			<td align="center" style="border : 1px solid black;">
				'.taka_format($ThisExpenseData["cr"]).'
			</td>
			<td align="center" style="border : 1px solid black;">
				'.taka_format($ThisExpenseData["Balance"]).'
			</td>
		</tr>    
    ';
    $Total = $Total + $ThisExpenseData["Balance"];
    $x++;

}

//array( "BankCashName" , "Type" , "Amount" , "Date" , "dr" , "cr" , "Balance"  ),

$MainContent.='
	<title>Journal/Trx Report</title>
	<center>
	<br>
	<img src="http://napps.click/RelainceHoldings/upload/f7f8da37a84d0ebaf39823fee6b2cc6c_logo%20(Software).jpg">
	<h1>Journal/Trx Report</h1>
	<div style="display:none;font-size:20px;width:830px;margin: auto 0px;">Date : '.$_REQUEST["FromDate"].' to '.$_REQUEST["ToDate"].'</div>
	<table border=0 width="95%" style="border : 0px solid black;" align="center">
		<tr>
			<td width="45" align="center" style="border : 1px solid black;">
				<b>SL</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Account</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Type</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Project Name</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Amount</b>
			</td>
			<td align="center" style="border : 1px solid black;">
				<b>Date</b>
			</td>
			<td align="center" style="border : 1px solid black;">
                <b>dr</b>
			</td>
			<td align="center" style="border : 1px solid black;">
                <b>cr</b>
			</td>
			<td align="center" style="border : 1px solid black;">
                <b>Balance</b>
			</td>
		</tr>
		'.$HTML.'
		<tr style="display: none">
			<td width="45" align="center" style="border : 0px solid black;">
				
			</td>
			<td align="right" style="border : 0px solid black;">
			</td>
			<td align="right" style="border : 0px solid black;">
			</td>
			<td align="center" style="border : 0px solid black;">
				
			</td>
			<td align="center" style="border : 0px solid black;">
				
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
	
			
		
		<style type="text/css" media="print">
		@page {
		    size: auto;   /* auto is the initial value */
		    margin: 0;  /* this affects the margin in the printer settings */
		}
		</style>
';

}


?>