<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"Name"=>"",
		"Category"=>"",
		
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
                   
			$Input[]=array("VariableName"=>"Name","Caption"=>"Name","ControlHTML"=>CTL_InputText("Name",$TheEntityName["Name"],"", 30,"required"));
			// $Input[]=array("VariableName"=>"Category","Caption"=>"Category","ControlHTML"=>CTL_InputText("Category",$TheEntityName["Category"],"", 30,"required"));

			$Input[] = array(
				"VariableName" => "Category",
				"Caption" => "Category",
				"ControlHTML" => '<select name="Category" class="form-control" required>
									<option value="">-- Select Category --</option>
									<option value="Liabilities" '.($TheEntityName["Category"]=="Liabilities" ? "selected" : "").'>Liabilities</option>
									<option value="Equity" '.($TheEntityName["Category"]=="Equity" ? "selected" : "").'>Equity</option>
									<option value="ASSETS" '.($TheEntityName["Category"]=="ASSETS" ? "selected" : "").'>ASSETS</option>
								</select>'
			);
			
            $Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);

	$MainContent.=FormInsertUpdate(
		$EntityName=$EntityLower,
		$FormTitle,
		$Input,
		$ButtonCaption,
		$ActionURL
	);
?>