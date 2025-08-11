<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"SalerName"=>"",
		"Amount"=>"",
		"Date"=>"",
		
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

$MainContent .= '
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0">'.$FormTitle.'</h5>
    </div>
    <div class="card-body">
        <form action="' . $ActionURL . '" method="post">
            <div class="row g-3">
            
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Saler Name</label>
                    ' . CCTL_SellerName("SalerID", $TheEntityName["SalerID"], "required", true) . '
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Amount</label>
                    ' . CTL_InputText("Amount", $TheEntityName["Amount"], "", 30, "required") . '
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Sales ID</label>
                    ' . CTL_InputText("SalesID", $TheEntityName["SalesID"], "", 30, "") . '
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Date</label>
                    ' . CTL_InputTextDate("Date", $TheEntityName["Date"], "", 30, "") . '
                </div>
                
                <div class="col-md-12">
                    <button type="submit" class="btn btn-success">'.$ButtonCaption.'</button>
                </div>
                
            </div>
        </form>
    </div>
</div>';

//$Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);

	// $MainContent.=FormInsertUpdate(
	// 	$EntityName=$EntityLower,
	// 	$FormTitle,
	// 	$Input,
	// 	$ButtonCaption,
	// 	$ActionURL
	// );
?>