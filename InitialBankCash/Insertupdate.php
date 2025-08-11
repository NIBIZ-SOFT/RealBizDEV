<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

// The default value of the input box will goes here according to how many fields we showing
$TheEntityName = array(

    "BankCashName" => "",
    "Balance" => "",
    "Date" => "",

    "{$Entity}IsDisplay" => 1
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
                    <label class="form-label fw-semibold">Bank & Cash Name</label>
                    ' . CCTL_BankCash("BankCashID", $TheEntityName["BankCashID"], "", false) . '
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Initial Balance</label>
                    ' . CTL_InputText("Balance", $TheEntityName["Balance"], "", 30, "required") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Date</label>
                    <input type="date" name="Date" value="' . $TheEntityName["Date"] . '" class="form-control" />
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Confirm?</label><br>
                    ' . CTL_InputRadioSet("{$Entity}IsDisplay", array("No", "Yes"), array(1, 0), $TheEntityName["{$Entity}IsDisplay"]) . '
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn btn-success px-4">' . $ButtonCaption . '</button>
                </div>

            </div>
        </form>
    </div>
</div>';

$MainContent .= FormInsertUpdate(
    $EntityName = $EntityLower,
    $FormTitle,
    $Input,
    $ButtonCaption,
    $ActionURL
);
?>