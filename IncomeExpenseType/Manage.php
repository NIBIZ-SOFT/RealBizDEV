<?


    GetPermission("OptionIncomeExpenseType");

    include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	SetFormvariable("RecordShowFrom", 1);
    SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
    SetFormvariable("SortBy", "Name");
    SetFormvariable("SortType", "ASC");

	if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	// Delete a data
	if(isset($_GET["DeleteConfirm"]))SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");

    $Where="1 = 1";
	if($_POST["FreeText"]!="")
		$Where.=" and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";

$MainContent .= '

        

        <form class="mb-3" name="frmDataGridSearchSaleinfo" 
        action="index.php?Theme=default&Base=IncomeExpenseType&Script=import&NoHeader&NoFooter" method="post" 
        enctype="multipart/form-data">
            <div class="mb-3">
                <label for="formFile" class="form-label">Upload Excel File</label>
                <input class="form-control" type="file" id="formFile" name="importFile">
            </div>
            <div class="d-flex flex-wrap gap-2">
                <input type="submit" class="btn btn-primary" name="btn" value="Import Leads">
                <a class="btn btn-success" href="./ImportLeads.csv">Download Sample File</a>
            </div>
        </form>
        <hr>
        ';
	// DataGrid
    $MainContent.= CTL_Datagrid(
        $Entity,
        $ColumnName=array( "IncomeExpenseTypeID","Name",  "GLCode"   ,"{$Entity}IsActive" ),
        $ColumnTitle=array( "Type ID","Name", "GL Code"  ,"IsActive" ),
        $ColumnAlign=array( "left"  ,"left"  ,"left"  , "left" ),
        $ColumnType=array( "text"  ,"text"  ,"text"  ,"yes/no"),
        $Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
        $SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
        $ActionLinks=true,
        $SearchPanel=true,
        $ControlPanel=true,
        $EntityAlias="".$EntityCaption."",
        $AddButton=true
    );
?>