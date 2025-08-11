<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

// The default value of the input box will goes here according to how many fields we showing
$TheEntityName = array(

    "Name" => "",

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

$MainContent .= '
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">'.$FormTitle.'</h5>
    </div>
    <div class="card-body">
        <form id="projectAddForm" action="' . $ActionURL . '" method="post" enctype="multipart/form-data">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Project Name</label>
                    ' . CTL_InputText("Name", $TheEntityName["Name"], "", 30, "required") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Project Location</label>
                    ' . CCTL_ProjectLocation("ProjectLoactionID", $TheEntityName["ProjectLoactionID"], "", "true", "required") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    ' . CTL_InputText("Address", $TheEntityName["Address"], "", 30, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Facing</label>
                    ' . CTL_InputText("Facing", $TheEntityName["Facing"], "", 30, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Building Height</label>
                    ' . CTL_InputText("BuildingHeight", $TheEntityName["BuildingHeight"], "", 30, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Land Area</label>
                    ' . CTL_InputText("LandArea", $TheEntityName["LandArea"], "", 30, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Project Launching Date</label>
                    ' . CTL_InputTextDate("ProjectLaunchingDate", $TheEntityName["ProjectLaunchingDate"], "", 30, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Project Hand Over Date</label>
                    ' . CTL_InputTextDate("HandOver", $TheEntityName["HandOver"], "", 30, "") . '
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    ' . CTL_InputTextArea("Description", $TheEntityName["Description"], "", 8, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Active?</label>
                    ' . CTL_InputRadioSet("{$Entity}IsActive", array("Yes", "No"), array(1, 0), $TheEntityName["{$Entity}IsActive"]) . '
                </div>
                
                <div class="col-md-12">
                    <div class="text-end">
                        <button type="submit" class="btn btn-success mt-4">'.$ButtonCaption.'</button>
                    </div>
                </div>
            </div> 
        </form>
    </div>
</div>
';
// $MainContent .= FormInsertUpdate(
//     $EntityName = $EntityLower,
//     $FormTitle,
//     $Input,
//     $ButtonCaption,
//     $ActionURL
// );
?>