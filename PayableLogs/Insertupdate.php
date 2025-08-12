<?


	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"worker_id"=>"",
		"date"=>"",
		"wage_per_day"=>"",
		"status"=>"",
		"is_generated"=>"",
		
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
                   
			$Input[]=array("VariableName"=>"worker_id","Caption"=>"Worker Name","ControlHTML"=>CTL_InputText("worker_id",$TheEntityName["worker_id"],"", 30,"required"));
			$Input[]=array("VariableName"=>"date","Caption"=>"Date","ControlHTML"=>CTL_InputText("date",$TheEntityName["date"],"", 30,"required"));
			$Input[]=array("VariableName"=>"wage_per_day","Caption"=>"Wage Per Day","ControlHTML"=>CTL_InputText("wage_per_day",$TheEntityName["wage_per_day"],"", 30,"required"));
			$Input[]=array("VariableName"=>"status","Caption"=>"Payment Status","ControlHTML"=>CTL_InputText("status",$TheEntityName["status"],"", 30,"required"));
			$Input[]=array("VariableName"=>"is_generated","Caption"=>"is_generated","ControlHTML"=>CTL_InputText("is_generated",$TheEntityName["is_generated"],"", 30,"required"));
			
            $Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);

	$MainContent.=FormInsertUpdate(
		$EntityName=$EntityLower,
		$FormTitle,
		$Input,
		$ButtonCaption,
		$ActionURL
	);
?>