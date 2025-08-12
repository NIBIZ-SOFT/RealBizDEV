<?



	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	SetFormvariable("RecordShowFrom", 1);
    SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
    SetFormvariable("SortBy", "{$OrderByValue}");
    SetFormvariable("SortType", "ASC");

	if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	// Delete a data
	if(isset($_GET["DeleteConfirm"]))SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");

    $Where="1 = 1";
	if($_POST["FreeText"]!="")
		$Where.=" and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";

    $worker = "SELECT name as Value FROM tblworkers WHERE WorkersID =:worker_id";

    $MainContent.= '
    <style>
    .card-header {
    background-color: #17a2b8 !important;
    }
    .card-header h5{
    color: #000 !important;
    font-size: 18px !important;
    font-weight: bold !important;
    }
    .DataGrid_Title_Table_Bar td a{
        font-size: 16px !important;
        color: #000 !important;
        font-weight: bold !important;
    }
    .DataGrid_Title_Table_Bar .DataGrid_ColumnTitle_Row_Serial_Cell{
        font-size: 16px !important;
        color: #000 !important;
        font-weight: bold !important;
    }
    .DataGrid_Title_Table_Bar .DataGrid_ColumnTitle_Row_Action_Cell{
        font-size: 16px !important;
        color: #000 !important;
        font-weight: bold !important;
    }
    .DataGrid_DataRow_Odd {
        font-size: 16px !important;
        color: #000 !important;
        font-weight: normal !important;
         letter-spacing: 1px;
    }
    .DataGrid_DataRow_Even {
        font-size: 16px !important;
        color: #000 !important;
        font-weight: normal !important;
         letter-spacing: 1px;
    }
    .RowMouseOver {
        font-size: 16px !important;
        color: #ffffff !important;
        font-weight: normal !important;
         letter-spacing: 1px;
    }
    </style>
    ';
    
	// DataGrid
	$MainContent.= CTL_Datagrid(
		$Entity,
		$ColumnName=array( $worker , "date" , "status" , "work_hours" , "amount"    ,"{$Entity}IsActive" ),
		$ColumnTitle=array( "Worker Name", "Date", "Status" , "Work Hours" , "Amount"    ,"IsActive" ),
		$ColumnAlign=array( "left", "left", "left" , "left" , "left"    , "left" ),
		$ColumnType=array( "sql", "date", "text" , "text" , "text"    ,"yes/no"),
		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
		$ActionLinks=true,
		$SearchPanel=true,
		$ControlPanel=true,
		$EntityAlias="".$EntityCaption."",
		$AddButton=true
	);
?>