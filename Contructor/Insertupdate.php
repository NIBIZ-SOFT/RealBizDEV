<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

// The default value of the input box will goes here according to how many fields we showing
$TheEntityName = array(

    "VendorName" => "",
    "VendorDescription" => "",
    "Date" => "",
    "Address" => "",
    "VendorWebSite" => "",
    "VendorPhone" => "",
    "VendorEmail" => "",

    "{$Entity}IsActive" => 1
);

if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"]) && !isset($_REQUEST["DeleteConfirm"])) {
    $UpdateMode = true;
    $FormTitle = "Update $EntityCaption";
    $ButtonCaption = "Update";
    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction", $Entity . "ID={$_REQUEST[$Entity."ID"]}&" . $Entity . "UUID={$_REQUEST[$Entity."UUID"]}");
    if ($UpdateMode && !isset($_POST["" . $Entity . "ID"])) $TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy = "{$OrderByValue}", $SingleRow = true);
}

// Input sytem display goes here
$Input = array();

// $Input[]=array("VariableName"=>"IsActive", "Caption"=>"Vendor Type", "ControlHTML"=>CTL_InputRadioSet($VariableName="VendorType", $Captions=array("Supplier", "Sub Contractor"), $Values=array("Supplier", "Sub Contractor"), $CurrentValue=$TheEntityName["VendorType"]), "Required"=>false);
//$Input[] = array("VariableName" => "PermanentAddress", "Caption" => "Permanent Address", "ControlHTML" => CTL_InputText("PermanentAddress", $TheEntityName["PermanentAddress"], 40, 8, "required"));


$MainContent = '
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">'. $FormTitle .'</h5>
    </div>
    <div class="card-body">
        <form method="post" enctype="multipart/form-data" action="' . $ActionURL . '">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Name</label>
                    ' . CTL_InputText("VendorName", $TheEntityName["VendorName"], "", 30, "required") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mailing Address</label>
                    ' . CTL_InputText("Address", $TheEntityName["Address"], 40, 8, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Date</label>
                    ' . CTL_InputTextDate("Date", $TheEntityName["Date"], "", 30, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">WebSite</label>
                    ' . CTL_InputText("VendorWebSite", $TheEntityName["VendorWebSite"], "", 30, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Phone</label>
                    ' . CTL_InputText("VendorPhone", $TheEntityName["VendorPhone"], "", 30, "required") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    ' . CTL_InputText("VendorEmail", $TheEntityName["VendorEmail"], "", 30, "") . '
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-semibold">Description</label>
                    ' . CTL_InputTextArea("VendorDescription", $TheEntityName["VendorDescription"], 40, 8, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Active?</label>
                    ' . CTL_InputRadioSet("{$Entity}IsActive", array("Yes", "No"), array(1, 0), $TheEntityName["{$Entity}IsActive"]) . '
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn btn-success px-4">'.$ButtonCaption.'</button>
                </div>

            </div>
        </form>
    </div>
</div>';




?>