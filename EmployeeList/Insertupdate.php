<?

    $MainContent.='
	 <style>
	  .controls img{max-width: 200px; height:200px}
	 </style>
	';

	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	
	for($in=0;$in<=23;$in++)
	{
	  $insertHTML.='
	   <option>'.$in.'</option>
	  ';
	} 
	
	for($out=0;$out<=60;$out++)
	{
	  $logoutHTML.='
	   <option>'.$out.'</option>
	  ';
	}

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Save Employee Details";
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
                   
			$Input[]=array("VariableName"=>"att_device_id","Caption"=>"Device ID","ControlHTML"=>CTL_InputText("att_device_id",$TheEntityName["att_device_id"],"", 30,""));
			$Input[]=array("VariableName"=>"FullName","Caption"=>"Full Name <span style='color:red'>*</span>","ControlHTML"=>CTL_InputText("FullName",$TheEntityName["FullName"],"", 30,"required"));
			
			//$Input[]=array("VariableName"=>"FullName","Caption"=>"Full Name  <span style='color:red'>*</span>","ControlHTML"=>"<input type=\"text\" required class=\"mmsaCustomCss\" id=\"FullName\" name=\"FullName\"  value=\"{$TheEntityName["FullName"]}\"/>");
			
			
			$Input[]=array("VariableName"=>"FathersName","Caption"=>"Fathers Name","ControlHTML"=>CTL_InputText("FathersName",$TheEntityName["FathersName"],"", 30,"mmsaCustomCss"));
			
			$Input[]=array("VariableName"=>"MothersName","Caption"=>"Mothers Name <span style='color:red'>*</span>","ControlHTML"=>CTL_InputText("MothersName",$TheEntityName["MothersName"],"", 30,"required mmsaCustomCss"));
			
			//$Input[]=array("VariableName"=>"MothersName","Caption"=>"Mothers Name  <span style='color:red'>*</span>","ControlHTML"=>"<input type=\"text\" required class=\"mmsaCustomCss\" id=\"MothersName\" name=\"MothersName\"  value=\"{$TheEntityName["MothersName"]}\"/>");
			
			
			
			$Input[]=array("VariableName"=>"SpouseName","Caption"=>"Spouse Name","ControlHTML"=>CTL_InputText("SpouseName",$TheEntityName["SpouseName"],"", 30,"mmsaCustomCss"));
			
			/*			$Input[]=array("VariableName"=>"NID","Caption"=>"NID","ControlHTML"=>CTL_InputText("NID",$TheEntityName["NID"],"", 30,"required mmsaCustomCss"));
			*/
			if($UpdateMode){
			$Input[]=array("VariableName"=>"NID","Caption"=>"NID <span style='color:red'>*</span>","ControlHTML"=>"<span id=\"nidclickview\"><input type=\"number\"  class=\"DatePicker form-control mmsaCustomCss\" id=\"NID\" name=\"NID\"  value=\"{$TheEntityName["NID"]}\"/></span>");
			}else{
			$Input[]=array("VariableName"=>"NID","Caption"=>"NID <span style='color:red'>*</span>","ControlHTML"=>"<span id=\"nidclickview\"><input type=\"number\" required class=\"DatePicker form-control mmsaCustomCss\" id=\"NID\" name=\"NID\"  value=\"{$TheEntityName["NID"]}\"/></span>");
			}
			

			
			if($UpdateMode){
			$Input[]=array("VariableName"=>"BirthCert","Caption"=>"Birth Certificate <span style='color:red'>*</span>","ControlHTML"=>CTL_InputText("BirthCert",$TheEntityName["BirthCert"],"", 30,"mmsaCustomCss"));
			}else{
			$Input[]=array("VariableName"=>"BirthCert","Caption"=>"Birth Certificate <span style='color:red'>*</span>","ControlHTML"=>"<span id=\"BirthonView\"><a onclick=\"Birthonfunction(1)\" style=\"cursor:pointer\">Input Birth Certificate ! Click Please</a></span>");
            }	


			$Input[]=array("VariableName"=>"PassportNo","Caption"=>"Passport Number","ControlHTML"=>CTL_InputText("PassportNo",$TheEntityName["PassportNo"],"", 30,"mmsaCustomCss"));			
			
			
			//$Input[]=array("VariableName"=>"CompanyID","Caption"=>"Company ID","ControlHTML"=>CTL_InputText("CompanyID",$TheEntityName["CompanyID"],"", 30,"mmsaCustomCss"));
			//$Input[]=array("VariableName"=>"DOB","Caption"=>"DOB","ControlHTML"=>CTL_InputText("DOB",$TheEntityName["DOB"],"", 30,"required"));
			
			
			$Input[]=array("VariableName"=>"DOB","Caption"=>"DOB  <span style='color:red'>*</span>","ControlHTML"=>"<input type=\"text\" required class=\"DatePicker form-control mmsaCustomCss\" id=\"dobuser\" name=\"DOB\"  value=\"{$TheEntityName["DOB"]}\"/>");
			
			$Input[]=array("VariableName"=>"Religion","Caption"=>"Religion","ControlHTML"=>CTL_InputText("Religion",$TheEntityName["Religion"],"", 30,"mmsaCustomCss"));
			//$Input[]=array("VariableName"=>"BloodGroup","Caption"=>"Blood Group","ControlHTML"=>CTL_InputText("BloodGroup",$TheEntityName["BloodGroup"],"", 30,""));
			$Input[]=array("VariableName"=>"BloodGroup","Caption"=>"Blood Group","ControlHTML"=>DP_BloodGroup("BloodGroup",$TheEntityName["BloodGroup"]));
			//$Input[]=array("VariableName"=>"PresentAddress","Caption"=>"Present Address","ControlHTML"=>CTL_InputText("PresentAddress",$TheEntityName["PresentAddress"],"", 30,"required"));
			//$Input[]=array("VariableName"=>"PermanentAddress","Caption"=>"Permanent Address","ControlHTML"=>CTL_InputText("PermanentAddress",$TheEntityName["PermanentAddress"],"", 30,""));
			
			//$Input[]=array("VariableName"=>"PhoneNo","Caption"=>"Phone Number  <span style='color:red'>*</span>","ControlHTML"=>CTL_InputText("PhoneNo",$TheEntityName["PhoneNo"],"", 30,"required mmsaCustomCss"));
			
			$Input[]=array("VariableName"=>"PhoneNo","Caption"=>"Phone Number  <span style='color:red'>*</span>","ControlHTML"=>"<input type=\"number\" required class=\"mmsaCustomCss\" id=\"PhoneNo\" name=\"PhoneNo\"  value=\"{$TheEntityName["PhoneNo"]}\"/>");

			
			//$Input[]=array("VariableName"=>"Email","Caption"=>"Email  <span style='color:red'>*</span>","ControlHTML"=>CTL_InputText("Email",$TheEntityName["Email"],"", 30,"required mmsaCustomCss"));
			
			$Input[]=array("VariableName"=>"Email","Caption"=>"Email","ControlHTML"=>"<input type=\"email\"  class=\"mmsaCustomCss\" id=\"Email\" name=\"Email\"  value=\"{$TheEntityName["Email"]}\"/>");
			
			
			
			$Input[]=array("VariableName"=>"Experience","Caption"=>"Experience","ControlHTML"=>CTL_InputText("Experience",$TheEntityName["Experience"],"", 30,"mmsaCustomCss"));
			
			
			$Input[]=array("VariableName"=>"Nationality","Caption"=>"Nationality  <span style='color:red'>*</span>","ControlHTML"=>CTL_InputText("Nationality",$TheEntityName["Nationality"],"", 30,"required mmsaCustomCss"));
			
			//$Input[]=array("VariableName"=>"Nationality","Caption"=>"Nationality <span style='color:red'>*</span>","ControlHTML"=>"<input type=\"text\" required class=\"mmsaCustomCss\" id=\"Nationality\" name=\"Nationality\"  value=\"{$TheEntityName["Nationality"]}\"/>");
			
			
			
			
			
			$Input[]=array("VariableName"=>"BirthPlace","Caption"=>"Birth Place","ControlHTML"=>CTL_InputText("BirthPlace",$TheEntityName["BirthPlace"],"", 30,"mmsaCustomCss"));
			
			//$Input[]=array("VariableName"=>"Gender","Caption"=>"Gender","ControlHTML"=>CTL_InputText("Gender",$TheEntityName["Gender"],"", 30,"required"));
			$Input[]=array("VariableName"=>"Gender","Caption"=>"Gender  <span style='color:red'>*</span>","ControlHTML"=>DP_Gender("Gender",$TheEntityName["Gender"]));
			
			
			//New add 22-02-2017 

			/*
			$Input[]=array("VariableName"=>"Gender","Caption"=>"Branch Name  <span style='color:red'>*</span>","ControlHTML"=>DP_Gender("Gender",$TheEntityName["Gender"]));
			
			$Input[]=array("VariableName"=>"Gender","Caption"=>"Designation  <span style='color:red'>*</span>","ControlHTML"=>DP_Gender("Gender",$TheEntityName["Gender"]));			
			
			$Input[]=array("VariableName"=>"Gender","Caption"=>"Department  <span style='color:red'>*</span>","ControlHTML"=>DP_Gender("Gender",$TheEntityName["Gender"]));
			
			$Input[]=array("VariableName"=>"Gender","Caption"=>"Job Status <span style='color:red'>*</span>","ControlHTML"=>DP_Gender("Gender",$TheEntityName["Gender"]));
			
			*/
			
			
			

			
			$Input[]=array("VariableName"=>"BranchName","Caption"=>"Branch Name","ControlHTML"=>CCTL_BranchName($Name="BranchName",$TheEntityName["BranchName"], $ValueSelected=0, $Where="", $PrependBlankOption=true));
			//$Input[]=array("VariableName"=>"BranchName","Caption"=>"BranchName","ControlHTML"=>CTL_InputText("BranchName",$TheEntityName["BranchName"],"", 30,"required"));
			$Input[]=array("VariableName"=>"Department","Caption"=>"Department","ControlHTML"=>CCTL_DepartmentName($Name="Department",$TheEntityName["Department"], $ValueSelected=0, $Where="", $PrependBlankOption=true));
			//$Input[]=array("VariableName"=>"Department","Caption"=>"Department","ControlHTML"=>CTL_InputText("Department",$TheEntityName["Department"],"", 30,"required"));
			$Input[]=array("VariableName"=>"Designation","Caption"=>"Designation","ControlHTML"=>CCTL_DesignationName($Name="Designation",$TheEntityName["Designation"], $ValueSelected=0, $Where="", $PrependBlankOption=true));
			//$Input[]=array("VariableName"=>"Designation","Caption"=>"Designation","ControlHTML"=>CTL_InputText("Designation",$TheEntityName["Designation"],"", 30,"required"));
			$Input[]=array("VariableName"=>"JobStatus","Caption"=>"Job Status","ControlHTML"=>DP_JobStatus("JobStatus",$TheEntityName["JobStatus"]));
			
			$Input[]=array("VariableName"=>"UserImage","Caption"=>"Image","ControlHTML"=>CTL_ImageUpload($ControlName="UserImage",$CurrentImage=$TheEntityName["UserImage"],$AllowDelete=true, $Class="FormTextInput", $ThumbnailHeight=100, $ThumbnailWidth=0 , $Preview=true));
			

			
			 $Input[]=array("ControlHTML"=>"<p style=\"margin: 0px;font-size: 21px;border-bottom: 1px solid black;padding-bottom: 11px;\">
	          Present Address </p>");


			
			$Input[]=array("VariableName"=>"Village","Caption"=>"Village","ControlHTML"=>CTL_InputText("Village",$TheEntityName["Village"],"", 30,"mmsaCustomCss"));
			$Input[]=array("VariableName"=>"PO","Caption"=>"P.O","ControlHTML"=>CTL_InputText("PO",$TheEntityName["PO"],"", 30,"mmsaCustomCss"));
			$Input[]=array("VariableName"=>"PS","Caption"=>"P.S","ControlHTML"=>CTL_InputText("PS",$TheEntityName["PS"],"", 30,"mmsaCustomCss"));
			$Input[]=array("VariableName"=>"District","Caption"=>"District","ControlHTML"=>CTL_InputText("District",$TheEntityName["District"],"", 30,"mmsaCustomCss"));
			$Input[]=array("VariableName"=>"HomePhone","Caption"=>"Home Phone","ControlHTML"=>CTL_InputText("HomePhone",$TheEntityName["HomePhone"],"", 30,"mmsaCustomCss"));

			
			if(!$UpdateMode){
			$Input[]=array("VariableName"=>"","Caption"=>"","ControlHTML"=>"<span id=\"addresscheckview\"> Permanent Address Same <input type=\"checkbox\" onchange=addresscheckfunction(this.value) name=\"check_address\"/> </span>");
			}
			 $Input[]=array("ControlHTML"=>"<p style=\"margin: 0px;font-size: 21px;border-bottom: 1px solid black;padding-bottom: 11px;\">
				Permanent Address </p>");

			
			//$Input[]=array("VariableName"=>"p_Village","Caption"=>"Village","ControlHTML"=>CTL_InputText("p_Village",$TheEntityName["p_Village"],"", 30,"mmsaCustomCss"));
			
			$Input[]=array("VariableName"=>"p_Village","Caption"=>"Village","ControlHTML"=>"<span id=\"per_village\"><input type=\"text\" value=\"{$TheEntityName["p_Village"]}\" name=\"p_Village\" class=\"mmsaCustomCss\" /> </span>");
			
			
			
			//$Input[]=array("VariableName"=>"p_PO","Caption"=>"P.O","ControlHTML"=>CTL_InputText("p_PO",$TheEntityName["p_PO"],"", 30,"mmsaCustomCss"));
			
			$Input[]=array("VariableName"=>"p_PO","Caption"=>"P.O","ControlHTML"=>"<span id=\"per_po\"><input type=\"text\" value=\"{$TheEntityName["p_PO"]}\" name=\"p_PO\" class=\"mmsaCustomCss\" /> </span>");
			
			//$Input[]=array("VariableName"=>"p_PS","Caption"=>"P.S","ControlHTML"=>CTL_InputText("p_PS",$TheEntityName["p_PS"],"", 30,"mmsaCustomCss"));
			
			$Input[]=array("VariableName"=>"p_PS","Caption"=>"P.S","ControlHTML"=>"<span id=\"per_ps\"><input type=\"text\" value=\"{$TheEntityName["p_PS"]}\" name=\"p_PS\" class=\"mmsaCustomCss\" /> </span>");
			
			//$Input[]=array("VariableName"=>"p_District","Caption"=>"District","ControlHTML"=>CTL_InputText("p_District",$TheEntityName["p_District"],"", 30,"mmsaCustomCss"));
			
			$Input[]=array("VariableName"=>"p_District","Caption"=>"District","ControlHTML"=>"<span id=\"per_district\"><input type=\"text\" value=\"{$TheEntityName["p_District"]}\" name=\"p_District\" class=\"mmsaCustomCss\" /> </span>");
			
			
			//$Input[]=array("VariableName"=>"p_HomePhone","Caption"=>"Home Phone","ControlHTML"=>CTL_InputText("p_HomePhone",$TheEntityName["p_HomePhone"],"", 30,"mmsaCustomCss"));
			
			$Input[]=array("VariableName"=>"p_HomePhone","Caption"=>"Home Phone","ControlHTML"=>"<span id=\"per_homephone\"><input type=\"text\" value=\"{$TheEntityName["p_HomePhone"]}\" name=\"p_HomePhone\" class=\"mmsaCustomCss\" /> </span>");

		   
			
			//$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
		
		
            $Input[]=array("ControlHTML"=>"<br/>");
			
			if($UpdateMode){
			 $Input[]=array("VariableName"=>"UserName","Caption"=>"User Name  <span style='color:red'>*</span>","ControlHTML"=>CTL_InputText("UserName",$TheEntityName["UserName"],"", 30,"required mmsaCustomCss"));
			 
			 //$Input[]=array("VariableName"=>"UserName","Caption"=>"User Name <span style='color:red'>*</span>","ControlHTML"=>"<input type=\"text\" required class=\"mmsaCustomCss\" id=\"UserName\" name=\"UserName\"  value=\"{$TheEntityName["UserName"]}\"/>");
			 
			}else{
			$Input[]=array("VariableName"=>"UserName","Caption"=>"User Name  <span style='color:red'>*</span>","ControlHTML"=>"<span id=\"usercheck\"><input type=\"text\" class=\"DatePicker form-control mmsaCustomCss\" onchange=\"usernamecheck(this.value)\" required class=\"mmsaCustomCss\" id=\"UserName\" name=\"UserName\" value=\"{$TheEntityName["UserName"]}\"/></span>");
			//$Input[]=array("VariableName"=>"UserName","Caption"=>"User Name","ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" onchange=\"usernamecheck(this.value)\" required id=\"UserName\" name=\"UserName\" value=\"{$TheEntityName["UserName"]}\"/>");
			
			//$Input[]=array("VariableName"=>"","Caption"=>"","ControlHTML"=>"<span id=\"userchecktt\"></span>");
			}
			
			//$Input[]=array("VariableName"=>"UserEmail","Caption"=>"Email","ControlHTML"=>CTL_InputText("UserEmail",$TheEntityName["UserEmail"],"", 30,"required"));
			$Input[]=array("VariableName"=>"UserPassword","Caption"=>"Password","ControlHTML"=>CTL_InputText("UserPassword",$TheEntityName["UserPassword"],"", 30,"required mmsaCustomCss"));
			//$Input[]=array("VariableName"=>"UserCategory","Caption"=>"Category","ControlHTML"=>UserCategory("UserCategory",$TheEntityName["UserCategory"]));
			//$Input[]=array("VariableName"=>"PhoneHome","Caption"=>"Phone","ControlHTML"=>CTL_InputText("PhoneHome",$TheEntityName["PhoneHome"],"", 30,"required"));

			
			$Input[]=array("ControlHTML"=>"<br/>");

			
            $Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);

	$MainContent.=FormInsertUpdate(
		$EntityName=$EntityLower,
		$FormTitle,
		$Input,
		$ButtonCaption,
		$ActionURL
	);
?>