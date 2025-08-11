<?


	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"name"=>"",
		"phone"=>"",
		"nid"=>"",
		"address"=>"",
		"join_date"=>"",
		"daily_wage"=>"",
		"Image"=>"",
		
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
    <h5 class="mb-0"> '.$FormTitle.' </h5>
  </div>
  <div class="card-body">
    <form method="post" enctype="multipart/form-data" action="' . $ActionURL . '">
      <div class="row g-3">
      
        <div class="col-md-6">
            <label class="form-label">Projects\'s Name</label>
            ' . CCTL_ProductsCategory("ProjectID", $TheEntityName["ProjectID"], "", true, "required") . '
        </div>
    
        <div class="col-md-6">
          <label for="name" class="form-label fw-semibold">Name</label>
          ' . CTL_InputText("name", $TheEntityName["name"], "", 30, "required") . '
        </div>

        <div class="col-md-6">
          <label for="phone" class="form-label fw-semibold">Phone</label>
          ' . CTL_InputText("phone", $TheEntityName["phone"], "", 30, "required") . '
        </div>

        <div class="col-md-6">
          <label for="nid" class="form-label fw-semibold">NID</label>
          ' . CTL_InputText("nid", $TheEntityName["nid"], "", 30, "required") . '
        </div>

        <div class="col-md-6">
          <label for="address" class="form-label fw-semibold">Address</label>
          ' . CTL_InputText("address", $TheEntityName["address"], "", 30, "required") . '
        </div>

        <div class="col-md-6">
          <label for="join_date" class="form-label fw-semibold">Join Date</label>
          ' . CTL_InputTextDate("join_date", $TheEntityName["join_date"], "", 30, "required date") . '
        </div>

        <div class="col-md-6">
          <label for="daily_wage" class="form-label fw-semibold">Per Day Salary</label>
          ' . CTL_InputText("daily_wage", $TheEntityName["daily_wage"], "", 30, "required") . '
        </div>
        
        <div class="col-md-6">
          <label for="work_hours" class="form-label fw-semibold">Work Hours</label>
          ' . CTL_InputText("work_hours", $TheEntityName["work_hours"], "", 30, "required") . '
        </div>

        <div class="col-md-12">
          <label for="Image" class="form-label fw-semibold">Image</label><br>
          ' . CTL_ImageUpload("Image", $TheEntityName["Image"], true, "FormTextInput", 100, 0, true) . '
        </div>

        <div class="col-md-6">
          <label class="form-label fw-semibold d-block">Active?</label>
          ' . CTL_InputRadioSet(
        "{$Entity}IsActive",
        array("Yes", "No"),
        array(1, 0),
        $TheEntityName["{$Entity}IsActive"]
    ) . '
        </div>

      </div>

      <div class="mt-4">
        <button type="submit" class="btn btn-primary">'. $ButtonCaption .'</button>
      </div>
    </form>
  </div>
</div>
';


//$MainContent.=FormInsertUpdate(
//		$EntityName=$EntityLower,
//		$FormTitle,
//		$Input,
//		$ButtonCaption,
//		$ActionURL
//	);
?>