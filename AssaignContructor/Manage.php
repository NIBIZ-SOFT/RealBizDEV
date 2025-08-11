<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	SetFormvariable("RecordShowFrom", 1);
    SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
    SetFormvariable("SortBy", "{$OrderByValue}");
    SetFormvariable("SortType", "DESC");

	if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	// Delete a data
	if(isset($_GET["DeleteConfirm"]))SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");

    $Where="ContructorID != ''";
	if($_POST["FreeText"]!="")
		$Where.=" and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";

	// DataGrid
	$MainContent.= CTL_Datagrid(
		$Entity,
		$ColumnName=array( "CategoryName" , "ContructorName"   ,"{$Entity}IsActive" ),
		$ColumnTitle=array( "Project Name", "Contructor Name"   ,"IsActive" ),
		$ColumnAlign=array( "left", "left"    ,"left" ),
		$ColumnType=array( "text", "text"  ,"yes/no"),
		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
		$ActionLinks=true,
		$SearchPanel=true,
		$ControlPanel=true,
		$EntityAlias="".$EntityCaption."",
		$AddButton=true,
        $AdditionalLinkCaption=array("Adv Payment<br>"),
        $AdditionalLinkField=array("AssaignvendorcontrocturID"),
        $AdditionalLink=array(ApplicationURL("AdvancedPaymentContructor","Manage&AssaignControcturID="))

    );
?>