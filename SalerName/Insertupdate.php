<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"Name"=>"",
		"Description"=>"",
		
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
        <form  action="' . $ActionURL . '" method="post" enctype="multipart/form-data">
            <div class="row g-3">
        
            <div class="col-md-6">
                <label class="form-label fw-semibold">Name</label>
                 <input type="text" name="Name" value="' . $TheEntityName["Name"] . '"  placeholder="Seller Name" class="form-control"  required>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold">Booking Commission (%)</label>
                <input type="number" name="Commission" value="' . $TheEntityName["Commission"] . '"  placeholder="20" class="form-control" required>
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold">Rest of Commission (%)</label>
                <input type="number" name="RestOfCommission" value="' . $TheEntityName["RestOfCommission"] . '"  placeholder="20" class="form-control" required>
            </div>
            
            <div class="col-md-12">
                <label class="form-label fw-semibold">Description</label>
                ' . CTL_InputTextArea("Description", $TheEntityName["Description"], 40, 8, "") . '
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-semibold">Active?</label>
                ' . CTL_InputRadioSet("{$Entity}IsActive", array("Yes", "No"), array(1, 0), $TheEntityName["{$Entity}IsActive"]) . '
            </div>
            
            <div class="col-md-6">
                <button type="submit" class="btn btn-success">'.$ButtonCaption.'</button>
            </div>

        </div>
        </form>
    </div>
</div>
';


?>