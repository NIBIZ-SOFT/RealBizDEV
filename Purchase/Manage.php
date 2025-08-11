<?


GetPermission("OptionPurchase");

include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

SetFormvariable("RecordShowFrom", 1);
SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
SetFormvariable("SortBy", "{$OrderByValue}");
SetFormvariable("SortType", "DESC");

if (isset($_REQUEST["ActionNew{$Entity}"])) include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
// Delete a data



//if (isset($_GET["DeleteConfirm"])) SQL_Delete($Entity = "{$Entity}", $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");

// Delete a data
if (isset($_GET["DeleteConfirm"])) SQL_Delete($Entity = "{$Entity}", $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");


$Where = "1 = 1";
if ($_POST["FreeText"] != "")
    $Where .= " and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";

// DataGrid
$MainContent .= CTL_Datagrid(
    $Entity,
    $ColumnName = array("confirmRequisitonName", "PurchaseConfirmID", "CategoryName", "VendorName", "MediaName", "IssuingDate", "DateOfDelevery", "PurchaseAmount", "Confirm"),
    $ColumnTitle = array( "Requisiton ID","Purchase ID" , "Project Name", "Vendor Name", "Media Name", "Issuing Date", "Date Of Delivery", "Purchase Amount", "IsConfirm"),
    $ColumnAlign = array("left", "left","left","left", "left", "left", "left", "left","left"),
    $ColumnType = array("text", "text", "text","text", "text", "date", "date", "text", "text"),
    $Rows = SQL_Select($Entity = "{$Entity}", $Where, $OrderBy = "{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow = false, $RecordShowFrom = $_REQUEST["RecordShowFrom"], $RecordShowUpTo = $Application["DatagridRowsDefault"], $Debug = false),
    $SearchHTML = "" . CTL_InputText($Name = "FreeText", "", "", 26, $Class = "DataGridSearchBox") . " ",
    $ActionLinks = true,
    $SearchPanel = true,
    $ControlPanel = true,
    $EntityAlias = "" . $EntityCaption . "",

    $AddButton = true,
    $AdditionalLinkCaption = array("PRINT<br>"),
    $AdditionalLinkField = array("PurchaseID"),
    $AdditionalLink = array(ApplicationURL("Purchase", "report&NoHeader&NoFooter&ID="))


);


?>