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

	$MainContent .= '<form method="post" action="index.php?Theme=default&Base=PayableLogs&Script=PaymentData&NoHeader&NoFooter">'; 

	$MainContent .= '<div class="card mb-4">
		<div class="card-header text-dark" style="background: #17a2b8;">
			<h5 class="mb-0"><strong>Filter Options</strong></h5>
		</div>
		<div class="card-body">
			<div class="row mb-3">';

	$MainContent .= '<div class="col-md-3">';
	$MainContent .= '<label for="from_date" class="form-label">From Date</label>';
	$MainContent .= '<input type="date" class="form-control" name="FromDate" placeholder="YYYY-MM-DD" required>';
	$MainContent .= '</div>';

	$MainContent .= '<div class="col-md-3">';
	$MainContent .= '<label for="to_date" class="form-label">To Date</label>';
	$MainContent .= '<input type="date" class="form-control" name="ToDate" placeholder="YYYY-MM-DD" required>';
	$MainContent .= '</div>';

	$MainContent .= '<div class="col-md-3">';
	$MainContent .= '<label for="ProjectID" class="form-label">Project</label>';
	$MainContent .= CCTL_ProductsCategory("ProjectID", "", "Select Project", true, "class='form-select'");
	$MainContent .= '</div>';

	$MainContent .= '<div class="col-md-3">';
	$MainContent .= '<label for="WorkerID" class="form-label">Worker</label>';
	$MainContent .= CCTL_WorkerList("WorkerID", "", "Select Worker", true, "class='form-select'");
	$MainContent .= '</div>';

	$MainContent .= '</div>'; 

	
	$MainContent .= '<div class="row">
		<div class="col-md-12 text-end">
			<button type="submit" class="btn btn-success">Filter</button>
		</div>
	</div>';

	$MainContent .= '</div>'; 
	$MainContent .= '</div>'; 
	$MainContent .= '</form>'; 





	// DataGrid
	$MainContent.= CTL_Datagrid(
		$Entity,
		$ColumnName=array( $worker , "date" , "wage_per_day" , "status" , "is_generated"   ,"{$Entity}IsActive" ),
		$ColumnTitle=array( "Worker Name", "Date" , "Wage Per Day" , "Payment Status" , "Is Generated"   ,"IsActive" ),
		$ColumnAlign=array( "left", "left" , "left" , "left" , "left"   , "left" ),
		$ColumnType=array( "sql", "date" , "text" , "text" , "text"   ,"yes/no"),
		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
		$ActionLinks=true,
		$SearchPanel=true,
		$ControlPanel=true,
		$EntityAlias="".$EntityCaption."",
		$AddButton=true
	);
?>