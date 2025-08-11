<?

include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";



$UpdateMode = false;

$FormTitle = "Insert $EntityCaption";

$ButtonCaption = "Insert";

$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");



// The default value of the input box will goes here according to how many fields we showing

$TheEntityName = array(
    "CustomerName" => "",
    "Address" => "",
    "Phone" => "",
    "CustomerEmail" => "",
    "{$Entity}IsActive" => 1
);


if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"]) && !isset($_REQUEST["DeleteConfirm"])) {

    $UpdateMode = true;

    $FormTitle = "Update $EntityCaption";

    $ButtonCaption = "Update";

    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction", $Entity . "ID={$_REQUEST[$Entity."ID"]}&" . $Entity . "UUID={$_REQUEST[$Entity."UUID"]}");

    if ($UpdateMode && !isset($_POST["" . $Entity . "ID"])) $TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy = "{$OrderByValue}", $SingleRow = true);

}

if($_REQUEST["CRMID"]!=""){
    $CRMDetails = SQL_Select("CRM","CRMID={$_REQUEST["CRMID"]}","",true);
    $TheEntityName["CustomerName"] = $CRMDetails["CustomerName"];
    $TheEntityName["Phone"] = $CRMDetails["Phone"];
    $TheEntityName["CustomerEmail"] = $CRMDetails["Email"];
    $TheEntityName["Address"] = $CRMDetails["Address"];
    $TheEntityName["Profession"] = $CRMDetails["Title"];
}



// Input sytem display goes here

$Input = array();
$MainContent .= '
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">Customer Information</h5>
    </div>
    <div class="card-body">
        <form id="customerAddForm" action="' . $ActionURL . '" method="post" enctype="multipart/form-data">
            <div class="row g-3">
    
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Profession</label>
                    ' . CTL_InputText("Profession", $TheEntityName["Profession"], "", 30, "") . '
                </div>
    
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Customer Name</label>
                    ' . CTL_InputText("CustomerName", $TheEntityName["CustomerName"], "", 30, "required") . '
                </div>
    
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Father\'s or Husband Name</label>
                    ' . CTL_InputText("FathersOrHusbandName", $TheEntityName["FathersOrHusbandName"], "", 30, "required") . '
                </div>
    
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Phone</label>
                    ' . CTL_InputPhone("Phone", $TheEntityName["Phone"], "", 30, "required") . '
                </div>
    
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Whatsapp</label>
                    ' . CTL_InputPhone("Whatsapp", $TheEntityName["Whatsapp"], "", 30, "") . '
                </div>
    
                <div class="col-md-6">
                    <label class="form-label fw-semibold">NID</label>
                    ' . CTL_InputNumber("NID", $TheEntityName["NID"], 40, 1, "") . '
                </div>
    
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Customer Email</label>
                    ' . CTL_InputEmail("CustomerEmail", $TheEntityName["CustomerEmail"], "", 30, "required") . '
                </div>
    
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mailing Address</label>
                    ' . CTL_InputTextArea("Address", $TheEntityName["Address"], 40, 3, "") . '
                </div>
    
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Parmanent Address</label>
                    ' . CTL_InputTextArea("ParmanentAddress", $TheEntityName["ParmanentAddress"], 40, 1, "") . '
                </div>
    
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Birth Date</label>
                    ' . CTL_InputTextDate("Date", $TheEntityName["Date"], "", 30, "") . '
                </div>
    
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Image</label>
                    ' . CTL_ImageUpload("Image", $TheEntityName["Image"], true, "FormTextInput", 100, 0, true) . '
                </div>
    
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Active?</label>
                    ' . CTL_InputRadioSet("{$Entity}IsActive", array("Yes", "No"), array(1, 0), $TheEntityName["{$Entity}IsActive"]) . '
                </div>
                
                <div class="col-md-12">
                   <button type="submit" class="btn btn-success mt-4">Submit</button>
                </div>
    
            </div>
        </form>
    </div>
</div>
';


?>