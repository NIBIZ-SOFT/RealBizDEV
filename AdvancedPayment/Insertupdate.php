<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"Type"=>"",
		"AdjustedAmount"=>"",
		"Amount"=>"",
		
       "{$Entity}IsActive"=>1
	);

    //echo "ID=".$_SESSION["ActionID"];

	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"])&&!isset($_REQUEST["DeleteConfirm"])){
	    $UpdateMode=true;
	    $FormTitle="Update $EntityCaption";
	    $ButtonCaption="Update";
	    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction", $Entity."ID={$_REQUEST[$Entity."ID"]}&".$Entity."UUID={$_REQUEST[$Entity."UUID"]}");
		if($UpdateMode&&!isset($_POST["".$Entity."ID"]))$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy="{$OrderByValue}", $SingleRow=true);
	}

	// Input sytem display goes here
	$Input=array();
                   
			$Input[]=array("VariableName"=>"Type","Caption"=>"Title","ControlHTML"=>CTL_InputText("Title",$TheEntityName["Title"],"", 30,"required"));
			//$Input[]=array("VariableName"=>"AdjustedAmount","Caption"=>"AdjustedAmount","ControlHTML"=>CTL_InputText("AdjustedAmount",$TheEntityName["AdjustedAmount"],"", 30,"required"));
			$Input[]=array("VariableName"=>"Amount","Caption"=>"Amount","ControlHTML"=>CTL_InputText("Amount",$TheEntityName["Amount"],"", 30,"required"));
            $Input[]=array("VariableName"=>"IsActive", "Caption"=>"cr/dr?", "ControlHTML"=>CTL_InputRadioSet($VariableName="crdr", $Captions=array("cr", "dr"), $Values=array(1, 0), $CurrentValue="", "Required",false));
			$Input[]=array("VariableName"=>"Date","Caption"=>"Date","ControlHTML"=>CTL_InputText("PayDate",$TheEntityName["PayDate"],"", 30,"required"));

            //$Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);

	$MainContent.=FormInsertUpdate(
		$EntityName=$EntityLower,
		$FormTitle,
		$Input,
		$ButtonCaption,
		$ActionURL
	);
?>