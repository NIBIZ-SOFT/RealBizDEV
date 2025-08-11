<?

$Expense=SQL_Select($Entity="ExpenseList", $Where="ExpenseListRefNo='{$_REQUEST["RefNo"]}'","","True");

if($Expense["ExpenseListFor"]="Common Expense"){
    $Expense["ExpenseListFor"]="ThemexSoft Limited";
}


$GetCompanyInfo=SQL_Select("Settings","SettingsID=1","","true");

$MainContent.="

	<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
	<html>
	<head>
	<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" /><title>Voucher</title>
	</head>
	<body>


	<fieldset>
		<legend>Voucher :: Ref No : {$_REQUEST["RefNo"]}</legend>

	<table width=\"600\" align=\"center\">
		<tr>
		    <td align=\"center\">
	            <h2>{$GetCompanyInfo["CompanyName"]}</h2>
				".nl2br($GetCompanyInfo["Address"])."
			</td>
		</tr>
		<tr>
		    <td>
		        <br>
		        <b>Expense Head :</b> {$Expense["ExpenseListName"]}
		        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		        <b>Paid to :</b> {$Expense["ExpenseListPaidTo"]}
		        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		        <b>Payment Date :</b> {$Expense["ExpenseListDate"]}
		        <br><br>
		        <b>Description :</b> {$Expense["ExpenseListDescription"]}
		        <br><br>
		        <b>Total Amount :</b> Tk. <i><u>{$Expense["ExpenseListTotalAmount"]}</u></i>
		        <br>
		        <b>In word :</b> <u><i>".NumberToWord($MyAmount="{$Expense["ExpenseListPaidAmount"]}")."</i></u>&nbsp;&nbsp;Taka Only
		        &nbsp;&nbsp;
		        <br><br>
";
if($Expense["ExpenseListDueAmount"]!=0)
$MainContent.="

		        &nbsp;&nbsp;
		        <b>Due Amount Payment Date :</b>{$Expense["ExpenseListDueAmountPaidDate"]}
";
$MainContent.="
				<br><br><br><br>
				
				_____________________
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				_____________________
				<br>
				Receive By
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Office Authority

			</td>
		</tr>
	</table>
	</fieldset>

	<script language=\"JavaScript\">
			window.print();
			//window.close();
	</script>

</body>
</html>
";




?>