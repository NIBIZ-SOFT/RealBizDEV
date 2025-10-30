<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

// Default values
$TheEntityName = array(
    "ProjectID" => "",
    "BankCashID" => "1",
    "HeadOfAccountID" => "",
    "VoucherNo" => "",
    "dr" => "",
    "cr" => "",
    "Name" => "0",
    "{$Entity}IsActive" => 1,
    "{$Entity}IsDisplay" => 1
);

// Update mode check
if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"]) && !isset($_REQUEST["DeleteConfirm"])) {
    $UpdateMode = true;
    $FormTitle = "Update $EntityCaption";
    $ButtonCaption = "Update";
    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction", $Entity . "ID={$_REQUEST[$Entity."ID"]}&" . $Entity . "UUID={$_REQUEST[$Entity."UUID"]}");
    if ($UpdateMode && !isset($_POST["" . $Entity . "ID"])) {
        $TheEntityName = SQL_Select(
            $Entity = "{$Entity}",
            $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'",
            $OrderBy = "{$OrderByValue}",
            $SingleRow = true
        );
    }
}

$Input = array();

$Input[] = array("VariableName" => "ProjectName", "Caption" => "Project Name", "ControlHTML" => CCTL_ProductsCategory("ProjectID", $TheEntityName["ProjectID"], "", true, "required"));

$customerSelected = ($TheEntityName["Type"]==1) ? "selected" : "";
$others = ($TheEntityName["Type"]==2) ? "selected" : "";

$Input[] = array("VariableName" => "Type", "Caption" => "Type", "ControlHTML" => '
<select name="Type" id="TypeSelector" class="form-select" required> 
    <option value="0">Select Type</option>
    <option '.$customerSelected.' value="1">Customer</option>
    <option '.$others.' value="2">Others</option>
</select>');

$nameFieldStyle = ($TheEntityName["Type"] == 2) ? '' : 'style="display:none;"';
$Input[] = array("VariableName" => "Name", "Caption" => "Name", "ControlHTML" => CTL_InputText("Name", $TheEntityName["Name"], "", 30, "required"), "RowAttributes" => $nameFieldStyle);

$customerFieldsStyle = ($TheEntityName["Type"] == 1) ? '' : 'style="display:none;"';
$saleOptions = '<select name="SaleID" id="SaleSelector" class="form-select" required>';
$saleOptions .= '<option value="0">Select Sale</option>';
$sales = SQL_Select("Sales");
foreach ($sales as $row) {
    $selected = ($row["SalesID"] == $TheEntityName["SalesID"]) ? 'selected' : '';
    $saleOptions .= '<option value="'.$row["SalesID"].'" '.$selected.'>SID'.$row["SalesID"].'-'.$row["CustomerName"].'</option>';
}
$saleOptions .= '</select>';

$Input[] = array(
    "VariableName" => "SaleID",
    "Caption" => "Sale ID",
    "ControlHTML" => $saleOptions,
    "RowAttributes" => $customerFieldsStyle
);

$termOptions = '';
$term = SQL_Select("Term");
foreach ($term as $row) {
    $selected = ($row["TermID"] == $TheEntityName["TermID"]) ? 'selected' : '';
    $termOptions.= '<option value="'.$row["Name"].'" '.$selected.'>'.$row["Name"].'</option>';
}

$Input[]=array("VariableName"=>"VendorName","Caption"=>"Title","ControlHTML"=>'
	<select class="form-select" name="Title">'.$termOptions.'</select>
');

$Input[] = array("VariableName" => "BankCashID", "Caption" => "Cash Type", "ControlHTML" => CCTL_BankCash("BankCashID", $TheEntityName["BankCashID"], "", false));
$Input[] = array("VariableName" => "checkNumberArea", "Caption" => "Instrument Number", "ControlHTML" => CTL_InputText("ChequeNumber", $TheEntityName["ChequeNumber"], "", 30, "required"));
$Input[] = array("VariableName" => "HeadOfAccountID", "Caption" => "Head Of Account", "ControlHTML" => GetExpenseID("HeadOfAccountID", $TheEntityName["HeadOfAccountID"], "", true));
$Input[] = array("VariableName" => "Division", "Caption" => "Division", "ControlHTML" => CommaSeperated("Division",$Settings["Division"], $TheEntityName["Division"],""));

$Input[] = array("VariableName" => "BillNo", "Caption" => "M.R/Bill No", "ControlHTML" => CTL_InputText("BillNo", $TheEntityName["BillNo"], "", 30, "required"));
$Input[] = array("VariableName" => "Date", "Caption" => "Date", "ControlHTML" => CTL_InputTextDate("Date", $TheEntityName["Date"], "", 30, "required"));
$Input[] = array("VariableName" => "Amount", "Caption" => "Amount", "ControlHTML" => CTL_InputText("Amount", $TheEntityName["Amount"], "", 30, "required"));
$Input[] = array("VariableName" => "Description", "Caption" => "Particulars", "ControlHTML" => CTL_InputTextArea("Description", $TheEntityName["Description"], "", 5, "required"));
$Input[] = array("VariableName" => "ProductsImage", "Caption" => "Image", "ControlHTML" => CTL_ImageUpload("Image", $TheEntityName["Image"], true, "FormTextInput", 100, 0, true));
$Input[] = array("VariableName" => "IsDisplay", "Caption" => "Confirm?", "ControlHTML" => CTL_InputRadioSet("{$Entity}IsDisplay", array("No","Yes"), array(1,0), $TheEntityName["{$Entity}IsDisplay"]), "Required" => false);

$MainContent .= FormInsertUpdate($EntityLower, $FormTitle, $Input, $ButtonCaption, $ActionURL);

$MainContent .= '
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    function toggleFieldsByType() {
        var type = $("#TypeSelector").val();
        
        if (type === "1") { // Customer
            $("#Control_104").show();        // show Control_104
            $("#Control_105").show();        // show Control_102
            $("[data-field=\'Name\']").hide();
        } else if (type === "2") { // Others
            $("#Control_104").hide();        // hide Control_104
            $("#Control_105").hide();        // hide Control_102
            $("[data-field=\'Name\']").show();
        } else {
            $("#Control_104").hide();        // hide Control_104 [data-field=\'Name\']").hide();
        }
    }

    // Run on load
    toggleFieldsByType();

    // Run again whenever Type changes
    $("#TypeSelector").on("change", toggleFieldsByType);
});
</script>
';

?>
