<?
GetPermission("OptionProduct");

include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

SetFormvariable("RecordShowFrom", 1);
SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
SetFormvariable("SortBy", "{$OrderByValue}");
SetFormvariable("SortType", "ASC");


if (isset($_REQUEST["ActionNew{$Entity}"])) include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
// Delete a data
if (isset($_GET["DeleteConfirm"])) SQL_Delete($Entity = "{$Entity}", $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");

$Where = "ProductType = '{$_SESSION["ProductType"]}'";
if ($_POST["FreeText"] != "")
    $Where .= " and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";

// DataGrid
$MainContent .= CTL_Datagrid(
    $Entity,
    $ColumnName = array("CategoryName","FlatType","BuildArea","LandArea","UnitPrice", ),
    $ColumnTitle = array("Project's Name","Package Name","Build Area","Land Area","Price"),
    $ColumnAlign = array("left", "left","left","left","left" ),
    $ColumnType = array("text", "text", "text", "text", "text"),
    $Rows = SQL_Select($Entity = "{$Entity}", $Where, $OrderBy = "{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow = false, $RecordShowFrom = $_REQUEST["RecordShowFrom"], $RecordShowUpTo = $Application["DatagridRowsDefault"], $Debug = false),
    $SearchHTML = "" . CTL_InputText($Name = "FreeText", "", "", 26, $Class = "DataGridSearchBox") . " ",
    $ActionLinks = true,
    $SearchPanel = true,
    $ControlPanel = true,
    $EntityAlias = "" . $EntityCaption . "",
    $AddButton = true
);
?>