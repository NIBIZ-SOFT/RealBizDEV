<?
	$MainContent.="<br><br>";
    $Category=$_REQUEST['Category'];
	$CompanyName=$_REQUEST['CompanyName'];
	$Entity="UserSignUp";
    $EntityLower=strtolower($Entity);

    $User=array(
        "SignUpUserName"=>"",
        "SignUpUserEmail"=>"",
		"Category"=>"",
        "UserTypeID"=>0
	);

    $FormTitle="Put Your User Name And Email";
    $ButtonCaption="Proceed";
    $ActionURL=ApplicationURL("System",$Script="usersignupaction");

	$Input=array();
    $Input[]=array("VariableName"=>"SignUpUserName", "DefaultValue"=>$User["SignUpUserName"], "Caption"=>"Username", "ControlHTML"=>CTL_InputText("SignUpUserName", $User["SignUpUserName"], "", 61), "Required"=>true);
    $Input[]=array("VariableName"=>"SignUpUserEmail", "DefaultValue"=>$User["SignUpUserEmail"], "Caption"=>"Email", "ControlHTML"=>CTL_InputText("SignUpUserEmail", $User["SignUpUserEmail"], "", 61), "Required"=>true);


    
	//$Input[]=array("VariableName"=>"UserTypeID", "DefaultValue"=>$User["UserTypeID"], "Caption"=>"User Type", "ControlHTML"=>CCTL_UserTypeLookup($Name="UserTypeID", $ValueSelected=$User["UserTypeID"], $Where="UT.UserTypeID NOT IN ({$Application["UserTypeIDAdministrator"]}, {$Application["UserTypeIDGuest"]})", $PrependBlankOption=false), "Required"=>false);

	$MainContent.=
	FormInsertUpdate(
		$EntityName=$EntityLower,
		$FormTitle,
		$Input,
		$ButtonCaption,
		$ActionURL
	);
?> 