<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

// The default value of the input box will goes here according to how many fields we showing
$TheEntityName = array(

    "CategoryName" => "",
    "VendorName" => "",

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

$MainContent = '
<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-info text-white">
    <h5 class="mb-0">'. $FormTitle .'</h5>
  </div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" action="' . $ActionURL . '">
      <div class="row g-3">

        <div class="col-md-6">
          <label for="CategoryID" class="form-label fw-semibold">Project Name</label>
          ' . CCTL_ProductsCategory("CategoryID", $TheEntityName["CategoryID"], "", true) . '
        </div>

        <div class="col-md-6">
          <label for="VendorID" class="form-label fw-semibold">Vendor Name</label>
          ' . CCTL_Vendor("VendorID", $TheEntityName["VendorID"], "", true) . '
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold d-block">Active?</label>
          ' . CTL_InputRadioSet(
        "AssaignvendorcontrocturIsActive",
        array("Yes", "No"),
        array(1, 0),
        $TheEntityName["AssaignvendorcontrocturIsActive"]
    ) . '
        </div>

      </div>

      <div class="mt-4">
        <button type="submit" class="btn btn-success">' . $ButtonCaption . '</button>
      </div>
    </form>
  </div>
</div>
';


//$Input[] = array("VariableName" => "ExpenseId", "Caption" => "Expense Head ", "ControlHTML" => GetExpenseID($Name = "ExpenseHeadID", $TheEntityName["ExpenseHeadID"], $Where = "", $PrependBlankOption = true));


$MainContent .= FormInsertUpdate(
    $EntityName = $EntityLower,
    $FormTitle,
    $Input,
    $ButtonCaption,
    $ActionURL
);
?>