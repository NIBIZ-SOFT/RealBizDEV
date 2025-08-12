<?
	// sunjove@gmail.com


    $Entity="UserProfile";
    $EntityLower=strtolower($Entity);

    $User=SQL_Select($Entity="User", $Where="UserID = {$_SESSION["UserID"]}", $OrderBy="", $SignleRow=true, $Debug=false);
    $User["UserPassword"]=$User["UserPasswordConfirm"]=$User["UserPassword"];

    $FormTitle="User Profile";
    $ButtonCaption="Update";
    $ActionURL=ApplicationURL("System",$Script="UserProfileUpdate");

	$Input=array();
    $Input[]=array("VariableName"=>"UserEmail", "DefaultValue"=>$User["UserEmail"], "Caption"=>"Email", "ControlHTML"=>CTL_InputText("UserEmail", $User["UserEmail"], "", 51), "Required"=>true);
	$Input[]=array("VariableName"=>"UserPassword", "DefaultValue"=>$User["UserPassword"], "Caption"=>"Password", "ControlHTML"=>CTL_InputPassword("UserPassword", $User["UserPassword"], "", 30), "Required"=>true);
    $Input[]=array("VariableName"=>"UserPasswordConfirm", "DefaultValue"=>$User["UserPasswordConfirm"], "Caption"=>"Password&nbsp;again", "ControlHTML"=>CTL_InputPassword("UserPasswordConfirm", $User["UserPasswordConfirm"], "", 30), "Required"=>true);
    $Input[]=array("VariableName"=>"NameFirst", "DefaultValue"=>$User["NameFirst"], "Caption"=>"First name", "ControlHTML"=>CTL_InputText("NameFirst", $User["NameFirst"], "", 51), "Required"=>true);
    $Input[]=array("VariableName"=>"NameMiddle", "DefaultValue"=>$User["NameMiddle"], "Caption"=>"Middle name", "ControlHTML"=>CTL_InputText("NameMiddle", $User["NameMiddle"], "", 51), "Required"=>false);
    $Input[]=array("VariableName"=>"NameLast", "DefaultValue"=>$User["NameLast"], "Caption"=>"Last name", "ControlHTML"=>CTL_InputText("NameLast", $User["NameLast"], "", 51), "Required"=>true);
	//$Input[]=array("VariableName"=>"DateBorn", "DefaultValue"=>$User["DateBorn"], "Caption"=>"Date of birth", "ControlHTML"=>CTL_DateSelector($DateSelectorName="DateBorn", $SelectedDate=$User["DateBorn"], $YearHalfSpan=50, $Class="", $Years=true, $Months=true, $Days=true), "Required"=>false);

	$Input[]=array("VariableName"=>"UserPicture", "DefaultValue"=>$User["UserPicture"], "Caption"=>"Avatar", "ControlHTML"=>CTL_ImageUpload($ControlName="UserPicture", $CurrentImage=$User["UserPicture"], $AllowDelete=true, $Class="FormTextInput", $ThumbnailHeight=100, $ThumbnailWidth=0, $Preview=true, $Size=40)."<br><br>", "Required"=>false);

	$Input[]=array("VariableName"=>"Street", "DefaultValue"=>$User["Street"], "Caption"=>"Street", "ControlHTML"=>CTL_InputText("Street", $User["Street"], "", 51), "Required"=>false);
    $Input[]=array("VariableName"=>"City", "DefaultValue"=>$User["City"], "Caption"=>"City", "ControlHTML"=>CTL_InputText("City", $User["City"], "", 51), "Required"=>false);
    $Input[]=array("VariableName"=>"ZIP", "DefaultValue"=>$User["ZIP"], "Caption"=>"ZIP", "ControlHTML"=>CTL_InputText("ZIP", $User["ZIP"], "", 51), "Required"=>false);
    $Input[]=array("VariableName"=>"State", "DefaultValue"=>$User["State"], "Caption"=>"State", "ControlHTML"=>CTL_InputText("State", $User["State"], "", 51), "Required"=>false);
    //$Input[]=array("VariableName"=>"CountryID", "DefaultValue"=>$User["CountryID"], "Caption"=>"Country", "ControlHTML"=>CCTL_CountryLookup($Name="CountryID", $ValueSelected=$User["CountryID"]), "Required"=>false);
    $Input[]=array("VariableName"=>"PhoneHome", "DefaultValue"=>$User["PhoneHome"], "Caption"=>"Home phone", "ControlHTML"=>CTL_InputText("PhoneHome", $User["PhoneHome"], "", 51), "Required"=>false);
    $Input[]=array("VariableName"=>"PhoneOffice", "DefaultValue"=>$User["PhoneOffice"], "Caption"=>"Office phone", "ControlHTML"=>CTL_InputText("PhoneOffice", $User["PhoneOffice"], "", 51), "Required"=>false);
    $Input[]=array("VariableName"=>"PhoneMobile", "DefaultValue"=>$User["PhoneMobile"], "Caption"=>"Mobile phone", "ControlHTML"=>CTL_InputText("PhoneMobile", $User["PhoneMobile"], "", 51), "Required"=>false);
    $Input[]=array("VariableName"=>"PhoneDay", "DefaultValue"=>$User["PhoneDay"], "Caption"=>"Day phone", "ControlHTML"=>CTL_InputText("PhoneDay", $User["PhoneDay"], "", 51), "Required"=>false);
    $Input[]=array("VariableName"=>"FAX", "DefaultValue"=>$User["FAX"], "Caption"=>"FAX", "ControlHTML"=>CTL_InputText("FAX", $User["FAX"], "", 51), "Required"=>false);
    $Input[]=array("VariableName"=>"Website", "DefaultValue"=>$User["Website"], "Caption"=>"Website", "ControlHTML"=>CTL_InputText("Website", $User["Website"], "", 51)."", "Required"=>false);

	$MainContent.=FormInsertUpdate(
		$EntityName=$EntityLower,
		$FormTitle,
		$Input,
		$ButtonCaption,
		$ActionURL
	);
?> 