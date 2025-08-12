<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"UserName"=>"",
		"UserEmail"=>"",
		"UserPassword"=>"",
		"UserCategory"=>"",
		"PhoneHome"=>"",
		
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
	if($TheEntityName["UserPassword"]=="")
		$TheEntityName["UserPassword"]=RandomPassword();
	$Input=array();
                   
			$Input[]=array("VariableName"=>"UserName","Caption"=>"Name","ControlHTML"=>CTL_InputText("UserName",$TheEntityName["UserName"],"", 30,"required"));
			$Input[]=array("VariableName"=>"UserEmail","Caption"=>"Email","ControlHTML"=>CTL_InputText("UserEmail",$TheEntityName["UserEmail"],"", 30,"required"));
			$Input[]=array("VariableName"=>"UserPassword","Caption"=>"Password","ControlHTML"=>CTL_InputText("UserPassword",$TheEntityName["UserPassword"],"", 30,"required"));
			//$Input[]=array("VariableName"=>"UserCategory","Caption"=>"Category","ControlHTML"=>UserCategory("UserCategory",$TheEntityName["UserCategory"]));
			$Input[]=array("VariableName"=>"PhoneHome","Caption"=>"Phone","ControlHTML"=>CTL_InputText("PhoneHome",$TheEntityName["PhoneHome"],"", 30,"required"));
			$Input[]=array("VariableName"=>"PhoneHome","Caption"=>"Allow Options","ControlHTML"=>'
				Categories'.CTL_InputRadioSet($VariableName="OptionCategory", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionCategory"]).'<br>
				Products '.CTL_InputRadioSet($VariableName="OptionProduct", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionProduct"]).'<br>
				Vendor '.CTL_InputRadioSet($VariableName="OptionVendor", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionVendor"]).'<br>
				Purchase '.CTL_InputRadioSet($VariableName="OptionPurchase", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionPurchase"]).'<br>
				Customer '.CTL_InputRadioSet($VariableName="OptionCustomer", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionCustomer"]).'<br>
				Sales '.CTL_InputRadioSet($VariableName="OptionSales", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionSales"]).'<br>
				Report '.CTL_InputRadioSet($VariableName="OptionReport", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionReport"]).'<br>
				Settings '.CTL_InputRadioSet($VariableName="OptionSettings", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionSettings"]).'<br>
				Users '.CTL_InputRadioSet($VariableName="OptionUsers", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionUsers"]).'<br>
					
			');
			
            $Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);

	$MainContent.=FormInsertUpdate(
		$EntityName=$EntityLower,
		$FormTitle,
		$Input,
		$ButtonCaption,
		$ActionURL
	);
?>