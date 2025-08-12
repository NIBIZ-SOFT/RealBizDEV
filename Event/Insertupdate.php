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
		"UserID"=>"",
		"DateAndTime"=>"",
		"OfficialWebsite"=>"",
		"Cost"=>"",
		"SubmitterBy"=>"",
		"WhatorWhy"=>"",
		"Images"=>"",
		
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
			$Input[]=array("VariableName"=>"Category","Caption"=>"Category","ControlHTML"=>CCTL_EventCategory("Category",$TheEntityName["Category"]));
			$Input[]=array("VariableName"=>"UserID","Caption"=>"Submitter By","ControlHTML"=>CCTL_UserList("SubmitterBy",$TheEntityName["SubmitterBy"]));
			$Input[]=array("VariableName"=>"DateAndTime","Caption"=>"Date And Time","ControlHTML"=>CTL_InputTextDate("DateAndTime",$TheEntityName["DateAndTime"],"", 30,"required date"));
			$Input[]=array("VariableName"=>"OfficialWebsite","Caption"=>"Official Website","ControlHTML"=>CTL_InputText("OfficialWebsite",$TheEntityName["OfficialWebsite"],"", 30,"required"));
			$Input[]=array("VariableName"=>"Cost","Caption"=>"Cost","ControlHTML"=>CTL_InputText("Cost",$TheEntityName["Cost"],"", 30,"required"));
			$Input[]=array("VariableName"=>"WhatorWhy","Caption"=>"What/Why","ControlHTML"=>CTL_InputTextArea("WhatorWhy",$TheEntityName["WhatorWhy"],40, 8,"required"));
			$Input[]=array("VariableName"=>"Images","Caption"=>"Images","ControlHTML"=>CTL_InputText("Images",$TheEntityName["Images"],"", 30,"required"));
			
            $Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["IsActive"]), "Required"=>false);

	$MainContent.=FormInsertUpdate(
		$EntityName=$EntityLower,
		$FormTitle,
		$Input,
		$ButtonCaption,
		$ActionURL
	);
?>