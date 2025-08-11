<?

	//NotAdmin();
		///GetPermission("OptionExpense");

	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	SetFormvariable("RecordShowFrom", 1);
    SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
    SetFormvariable("SortBy", "ExpenseListID");
    SetFormvariable("SortType", "DESC");

	if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	// Delete a data
	if(isset($_GET["DeleteConfirm"]))SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");


	$Today=date('Y-m-d');
    $Where="1 = 1";
	if($_POST["FreeText"]!="")
		$Where.=" and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";



$Month1st=date('m/1/Y');

//$Where= "{$Entity}Date BETWEEN '{$Month1st}' and '{$Today}'";
//$_SESSION["WhereQuery"]=$Where;

if($_REQUEST["Search"]==True){
    $Where= "{$Entity}Date BETWEEN '{$_REQUEST["StartDate"]}' and '{$_REQUEST["EndDate"]}'";
    $_SESSION["WhereQuery"]=$Where;
}
if($_REQUEST["Today"]==True){
    $Where= "{$Entity}Date='{$Today}'";
    $_SESSION["WhereQuery"]=$Where;
}
if($_REQUEST["Month"]==True){
	$Where= "{$Entity}Date BETWEEN '{$Month1st}' and '{$Today}'";
    $_SESSION["WhereQuery"]=$Where;
}



	$TotalAmount=SQL_Select($Entity="{$Entity}", $Where);
	//sa($TotalAmount);
	$PaidAmount=0;
	$DueAmount=0;
	foreach($TotalAmount as $ThisTotalAmount){
        $PaidAmount=$PaidAmount+$ThisTotalAmount["{$Entity}PaidAmount"];
        $DueAmount=$DueAmount+$ThisTotalAmount["{$Entity}DueAmount"];
	}

$MainContent111.="
	<fieldset>
		<legend>Expense Manager</legend>
	
	<form action=\"".ApplicationURL("ExpenseList","Manage&Search=True")."\" method=\"post\">
		Start Date : ".DatePicker("StartDate","{$_REQUEST["StartDate"]}")."
		End Date :".DatePicker("EndDate","{$_REQUEST["EndDate"]}")."
		<input class=\"SubmitButton\"  type=\"submit\" value=\"Search\">
	</form>

	<a href=\"".ApplicationURL("AddExpenseHead","Manage")."\" class=\"btn btn-primary\">Add Expense Head</a>
	<a href=\"".ApplicationURL("ExpenseList","Manage&Today=True")."\" class=\"btn btn-info\">Show Today's Expense List</a>
	<a href=\"".ApplicationURL("ExpenseList","Manage&Month=True")."\" class=\"btn btn-info\">Show Current Month Expense List</a>
	
	<!--
	<form action=\"".ApplicationURL("ExpenseList","Manage&Today=True")."\" method=\"post\">
		<input class=\"SubmitButton\" type=\"submit\" value=\"Show Today's Expense List\">
	</form>
	<form action=\"".ApplicationURL("ExpenseList","Manage&Month=True")."\" method=\"post\">
		<input class=\"SubmitButton\"  type=\"submit\" value=\"Show Current Month Expense List\">
	</form>
	
	--!>
	
	</fieldset>

	<br>

	<b style=\"color:green\">Today's Date : {$Today}</b>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b style=\"color:#D1450A\">Total Paid Amount : Tk. {$PaidAmount}/=</b>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b style=\"color:red\">Total Due Amount : Tk. {$DueAmount}/=</b>
";


$MainContent.="
	<fieldset>
		<legend>Expense Manager</legend>
	<a href=\"".ApplicationURL("AddExpenseHead","Manage")."\" class=\"btn btn-primary\">Add Expense Head</a>


";


	//$Where=$_SESSION["WhereQuery"];

	// DataGrid
	$MainContent.= CTL_Datagrid(
		$Entity,
		$ColumnName=array( "{$Entity}Name"  , "{$Entity}PaidTo"  , "ExpenseListAccountType" , "{$Entity}TotalAmount", "{$Entity}Date" ),
		$ColumnTitle=array( "Name", "Paid To", "Account", "Total Amount", "Date" ),
		$ColumnAlign=array( "left",  "left", "left", "left", "left"  ),
		$ColumnType=array( "text",  "text", "text", "text", "date"),
		$Rows=SQL_Select($Entity="{$Entity}", $Where,  $OrderBy="ExpenseListID DESC", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
		$SearchHTML="".DatePicker($Name="FreeText",$Value=$_POST["FreeText"],$Size=50,$TodayDate=false)."",
		$ActionLinks=true,
		$SearchPanel=true,
		$ControlPanel=true,
		$EntityAlias="".$EntityCaption.""
	);
?>