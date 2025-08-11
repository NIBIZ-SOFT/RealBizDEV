<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"CompanyName"=>"",
		"logo"=>"",
		"Address"=>"",
		"City"=>"",
		"Zip"=>"",
		"Country"=>"",
		
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
                   
			$Input[]=array("VariableName"=>"Company Name","Caption"=>"CompanyName","ControlHTML"=>CTL_InputText("CompanyName",$TheEntityName["CompanyName"],"", 30,"required"));
			$Input[]=array("VariableName"=>"logo","Caption"=>"logo","ControlHTML"=>CTL_ImageUpload($ControlName="logo",$CurrentImage01=$TheEntityName["logo"],$AllowDelete=true, $Class="FormTextInput", $ThumbnailHeight=100, $ThumbnailWidth=0 , $Preview=true));
			$Input[]=array("VariableName"=>"Address","Caption"=>"Address","ControlHTML"=>CTL_InputTextArea("Address",$TheEntityName["Address"],55, 12,"not required"));
			$Input[]=array("VariableName"=>"City","Caption"=>"Payment Method","ControlHTML"=>CTL_InputText("PaymentMethod",$TheEntityName["PaymentMethod"],"", 30,"required")."<br> Comma Seperated");
			$Input[]=array("VariableName"=>"Zip","Caption"=>"Invoice Prifix","ControlHTML"=>CTL_InputText("InvoicePrifix",$TheEntityName["InvoicePrifix"],"", 30,"required"));
			$Input[]=array("VariableName"=>"InvoiceTerms","Caption"=>"InvoiceTerms","ControlHTML"=>CTL_InputTextArea("InvoiceTerms",$TheEntityName["InvoiceTerms"],55, 12,"not required"));
			$Input[]=array("VariableName"=>"Country","Caption"=>"Lead Status","ControlHTML"=>CTL_InputText("LeadsStatus",$TheEntityName["LeadsStatus"],"", 30,"required"));
			$Input[]=array("VariableName"=>"Country","Caption"=>"Lead Source","ControlHTML"=>CTL_InputText("LeadSource",$TheEntityName["LeadSource"],"", 30,"required"));
			$Input[]=array("VariableName"=>"Country","Caption"=>"Division","ControlHTML"=>CTL_InputText("Division",$TheEntityName["Division"],"", 30,"required"));
			
			// $Input[]=array("VariableName"=>"Phone","Caption"=>"Phone","ControlHTML"=>CTL_InputText("Phone",$TheEntityName["Phone"],"", 30,"required"));
			// $Input[]=array("VariableName"=>"Email","Caption"=>"Email","ControlHTML"=>CTL_InputText("Email",$TheEntityName["Email"],"", 30,"required"));
			// $Input[]=array("VariableName"=>"WebSite","Caption"=>"WebSite","ControlHTML"=>CTL_InputText("WebSite",$TheEntityName["WebSite"],"", 30,"not required"));
			
			$Input[]=array("VariableName"=>"IsActive", "Caption"=>"Print on Company Pad", "ControlHTML"=>CTL_InputRadioSet($VariableName="IsUseCompanyPad", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["IsUseCompanyPad"]), "Required"=>false);

	$MainContent.=FormInsertUpdate(
		$EntityName=$EntityLower,
		$FormTitle,
		$Input,
		$ButtonCaption,
		$ActionURL
	);
?>