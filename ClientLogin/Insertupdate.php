<?php
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$MainContent .= '
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>';
$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

// Initialize default values
$TheEntityName = array(
    "UserName" => "",
    "NameFirst" => "",
    "UserEmail" => "",
    "UserPassword" => "",
    "PhoneHome" => "",
    "{$Entity}IsActive" => 1
);

// Update mode setup
if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"]) && !isset($_REQUEST["DeleteConfirm"])) {
    $UpdateMode = true;
    $FormTitle = "Update $EntityCaption";
    $ButtonCaption = "Update";
    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction", $Entity . "ID={$_REQUEST[$Entity . "ID"]}&" . $Entity . "UUID={$_REQUEST[$Entity . "UUID"]}");

    if ($UpdateMode && !isset($_POST[$Entity . "ID"])) {
        $TheEntityName = SQL_Select(
            $Entity = "{$Entity}",
            $Where = "{$Entity}ID = {$_REQUEST[$Entity . "ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity . "UUID"]}'",
            $OrderBy = "{$OrderByValue}",
            $SingleRow = true
        );
    }
}

// Prepare input fields
$Input = array();

// ➤ Add Customer Dropdown
$customerOptions = '<option value="">Select Customer</option>';
$customerList = SQL_Select("customer", "CustomerIsActive = 1 ORDER BY CustomerID DESC");

foreach ($customerList as $customer) {
    $customerID = $customer['CustomerID'];
    $customerPhone = $customer['Phone'];

    $customerName = $customer['CustomerName'];

    $selected = (isset($TheEntityName['PhoneHome']) && $TheEntityName['PhoneHome'] == $customerPhone) ? 'selected' : '';

    $customerOptions .= "<option value='{$customerID}' {$selected}>{$customerID} - {$customerName}</option>";
}

$Input[] = array(
    "VariableName" => "CustomerID",
    "Caption" => "Customer Name",
    "ControlHTML" => "<select name='CustomerID' id='CustomerID' class='form-select' required>{$customerOptions}</select>"
);
$Input[] = array("VariableName" => "UserName", "Caption" => "User Name", "ControlHTML" => CTL_InputText("UserName", $TheEntityName["UserName"], "", 30, "required"));

// Other inputs
//$Input[] = array("VariableName" => "NameFirst", "Caption" => "Name First", "ControlHTML" => CTL_InputText("NameFirst", $TheEntityName["NameFirst"], "", 30, "required"));
$Input[] = array("VariableName" => "UserEmail", "Caption" => "User Email", "ControlHTML" => CTL_InputText("UserEmail", $TheEntityName["UserEmail"], "", 30, ""));
$Input[] = array("VariableName" => "UserPassword", "Caption" => "User Password", "ControlHTML" => CTL_InputText("UserPassword", $TheEntityName["UserPassword"], "", 30, "required"));
//$Input[] = array("VariableName" => "PhoneHome", "Caption" => "Phone", "ControlHTML" => CTL_InputText("PhoneHome", $TheEntityName["PhoneHome"], "", 30, "required"));
$Input[] = array(
    "VariableName" => "IsActive",
    "Caption" => "Active?",
    "ControlHTML" => CTL_InputRadioSet("{$Entity}IsActive", array("Yes", "No"), array(1, 0), $TheEntityName["{$Entity}IsActive"]),
    "Required" => false
);

// Render the form
$MainContent .= FormInsertUpdate(
    $EntityName = $EntityLower,
    $FormTitle,
    $Input,
    $ButtonCaption,
    $ActionURL
);

$MainContent .= '
				<script>
                        $(document).ready(function() {
                        $("#CustomerID").select2();
                    });        
                </script>';
?>
