<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"Name"=>"",
		
       "{$Entity}IsActive"=>1
	);

	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"])&&!isset($_REQUEST["DeleteConfirm"])){
	    $UpdateMode=true;
	    $FormTitle="Update $EntityCaption";
	    $ButtonCaption="Update";
	    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction", $Entity."ID={$_REQUEST[$Entity."ID"]}&".$Entity."UUID={$_REQUEST[$Entity."UUID"]}");
		if($UpdateMode&&!isset($_POST["".$Entity."ID"]))$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy="{$OrderByValue}", $SingleRow=true);
	}

	// Input sytem display goes here
	$Input=array();

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
                    ' . CTL_InputText("Name", $TheEntityName["Name"], "", 30, "required") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">GL Code</label>
                    ' . CTL_InputText("GLCode", $TheEntityName["GLCode"], "", 30, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Balancesheet Perticular</label>
                    ' . CCTL_BalanceSheet($Name = "FinancialPositionList", $ValueSelected = $TheEntityName["FinancialPositionList"], $Where = "", $PrependBlankOption = true) . '
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Active?</label>
                    ' . CTL_InputRadioSet("{$Entity}IsActive", array("Yes", "No"), array(1, 0), $TheEntityName["{$Entity}IsActive"]) . '
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn btn-success px-4">Submit</button>
                </div>

            </div>
        </form>
    </div>
</div>';

$MainContent.=FormInsertUpdate(
		$EntityName=$EntityLower,
		$FormTitle,
		$Input,
		$ButtonCaption,
		$ActionURL
	);
?>