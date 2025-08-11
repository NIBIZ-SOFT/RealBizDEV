<?

	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	$StockDetails=SQL_Select("stock");

	$stockAmount=0;
	foreach ($StockDetails as $StockDetail){

	    if ($StockDetail["StockIsActive"]==1){
            $stockAmount+=$StockDetail["Value"];
        }else{
	        continue;
        }

    }

    $usedStocks= SQL_Select("usedstock");
    $usedStockAmount=0;
	foreach ($usedStocks as $usedStock){
        if ($usedStock["UsedStockIsActive"]==1){
            $usedStockAmount+=$usedStock["Value"];
        }else{
            continue;
        }
    }


    $currentAmount=$stockAmount - $usedStockAmount;


	SetFormvariable("RecordShowFrom", 1);
    SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
    SetFormvariable("SortBy", "{$OrderByValue}");
    SetFormvariable("SortType", "DESC");

	if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	// Delete a data
	if(isset($_GET["DeleteConfirm"]))SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");


$MainContent = '
<div class="card mb-4">
    <div class="card-header bg-primary text-white d-flex align-items-center">
        <i class="bi bi-list me-2"></i>
        <h4 class="mb-0">Stock Manage</h4>
    </div>
    <div class="card-body">
        <h3>Total Stock Value: <span class="text-primary">'.$stockAmount.'</span> TK</h3>
        <h3>Used Stock Value: <span class="text-danger">'.$usedStockAmount.'</span> TK</h3>
        <h3>Present Stock Value: <span class="text-success">'.$currentAmount.'</span> TK</h3>
        <a href="index.php?Theme=default&Base=UsedStock&Script=Manage" class="btn btn-outline-primary">
            Used Stock
        </a>
    </div>
</div>
';





    $Where="1 = 1";
	if($_POST["FreeText"]!="")
		$Where.=" and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";


	// DataGrid
	$MainContent.= CTL_Datagrid(
		$Entity,
        $ColumnName=array( "Date" , "ProjectName", "HeadOfAccountName" , "VendorName" , "RequisitionName" , "PurchasName" , "Qty" , "Rate" ,"Value"  ,"{$Entity}IsActive" ),
        $ColumnTitle=array("Date" , "Project Name" , "Head Of Account Name" , "Vendor Name" , "Requisition ID" , "Purchase Order ID" , "Qty" , "Rate" ,"Value",  "Is Stock ?" ),
		$ColumnAlign=array( "left", "left", "left" , "left" , "left" , "left" , "left" , "left" , "left"   , "left" ),
		$ColumnType=array( "Date", "text", "text" , "text" , "text" , "text" , "text" , "text", "text"   ,"yes/no"),
		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
		$ActionLinks=true,
		$SearchPanel=true,
		$ControlPanel=true,
		$EntityAlias="".$EntityCaption."",
		$AddButton=true
	);



?>