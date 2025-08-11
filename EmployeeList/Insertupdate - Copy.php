<?
$MainContent.='
<style>
#eminfo_dtails {
	position: absolute;
	top: 186px;
	left: 310px;
	font-size: 23px;
	border-bottom: 0px solid black;
	width: 67.5%;
	padding-bottom: 10px;
	padding-left: 10px;
	color: #fcfcfc;
	background-color: #E64141;
	padding-top: 10px;
	text-align: center;
}


#basic_validate {
	border: 1px solid black;
	padding-top: 18px;
	padding-right: 33px;
	padding-left: 29px;
	background-color: green;
}

.form-horizontal .control-group {
	margin-bottom: 20px;
	*zoom: 1;
	float: left;
}

.form-horizontal .form-actions {
	padding-left: 180px;
	background-color: #4949fe;
}

#Sep_one {
	margin-top: -1px;
	background-color: green;
	border: 1px solid green;
	disabled: disabled;
	margin-bottom: 66px;
}
#Sep_Two {
	margin-top: 69px;
	background-color: #4949fe;
	border: 1px solid #4949fe;
}
#p_dtails {
	position: absolute;
	top: 252px;
	left: 310px;
	font-size: 23px;
	border-bottom: 4px solid black;
	width: 67.5%;
	padding-bottom: 10px;
	padding-left: 10px;
	color: black;
	background-color: #F3EDED;
	padding-top: 10px;
}
#con_address {
	position: absolute;
	top: 986px;
	left: 310px;
	font-size: 23px;
	border-bottom: 4px solid black;
	width: 67.5%;
	padding-bottom: 10px;
    color: black;
    background-color: #F3EDED;
	padding-top: 10px;
	padding-left: 10px;
}

#qualification {
	position: absolute;
	top: 1205px;
	left: 310px;
	font-size: 23px;
	border-bottom: 4px solid black;
	width: 67.5%;
	padding-bottom: 10px;
	color: black;
	background-color: #F3EDED;
	padding-top: 10px;
	padding-left: 10px;
}

#file_attch {
	position: absolute;
	top: 1397px;
	left: 310px;
	font-size: 23px;
	border-bottom: 4px solid black;
	width: 67.5%;
	padding-bottom: 10px;
	padding-top: 10px;
	padding-left: 10px;
    color: black;
    background-color: #F3EDED;}

#slaray {
	position: absolute;
	top: 1698px;
	left: 310px;
	font-size: 23px;
	border-bottom: 4px solid black;
	width: 67.5%;
	padding-bottom: 10px;
	padding-top: 10px;
	padding-left: 10px;
    color: black;
    background-color: #F3EDED;}

#set_titme {
	position: absolute;
	top: 2145px;
	left: 310px;
	font-size: 23px;
	border-bottom: 4px solid black;
	width: 67.5%;
	padding-bottom: 10px;
	padding-top: 10px;
	padding-left: 10px;
    color: black;
    background-color: #F3EDED;}
#page {
	position: absolute;
	top: 3096px;
	left: 310px;
	font-size: 23px;
	border-bottom: 4px solid black;
	width: 67.5%;
	padding-bottom: 10px;
	padding-top: 10px;
	padding-left: 10px;
    color: black;
    background-color: #F3EDED;}
#permission {
	position: absolute;
	top: 3258px;
	left: 310px;
	font-size: 23px;
	border-bottom: 4px solid black;
	width: 67.5%;
	padding-bottom: 10px;
	padding-top: 10px;
	padding-left: 10px;
    color: black;
    background-color: #F3EDED;}

#ref {
	position: absolute;
	top: 814px;
	left: 310px;
	font-size: 23px;
	border-bottom: 4px solid #140505;
	width: 67.5%;
	padding-bottom: 10px;
	padding-left: 10px;
    color: black;
    background-color: #F3EDED;	
	padding-top: 11px;
}

#basic_validate .btn-primary {
	position: absolute;
	top: 3462px;
	right: 367px;
}
.controls img{
	height:40px;
	weight:40px;
}
.widget-content {
	margin-left:0px;
}
.form-horizontal .control-group {
	border: 0px solid #1d19c8;
	background: none;
    color: black;
}
#IntimeH {
	max-width: 64px;
	background-color: antiquewhite;
}
#IntimeS{
	max-width: 70px;
	position: absolute;
	left: 552px;
	background-color: antiquewhite;
}
#set_hour {
	position: absolute;
	top: 2110px;
	left: 482px;
	font-size: 17px;
	width: 72%;
	padding-bottom: 12px;
}

#set_minute {
	position: absolute;
	top: 2110px;
	left: 558px;
	font-size: 17px;
	width: 72%;
	padding-bottom: 12px;
	background-color: o;
}

#FullName, #NID, #PassportNo, #BirthCert, #CompanyID, #DOB, #FathersName, #MothersName, #SpouseName, #Religion, #BloodGroup, #PresentAddress, #PermanentAddress, #PhoneNo, #Email, #Experience, #Nationality, #BirthPlace, #Gender {
	background-color: #b8dee0;
	color: #0f0101;
}
.form-horizontal .control-group {
	border: 0px solid #1d19c8;
	background: none;
	color: #f2eeee;
}

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
                   
			$MainContent.='<p id="eminfo_dtails">Employee Information Insert Section</p>';

			
			$MainContent.='<p id="p_dtails">Personal Details</p>';	
			
			$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_one\" name=\"Sep_one\" class=\"required\" disabled value=\"{$TheEntityName["Sep_one"]}\"/>	");
			$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_one\" name=\"Sep_one\" class=\"required\" disabled value=\"{$TheEntityName["Sep_one"]}\"/>	");

			
			$Input[]=array("VariableName"=>"FullName","Caption"=>"Full Name","ControlHTML"=>CTL_InputText("FullName",$TheEntityName["FullName"],"", 30,"required"));
			$Input[]=array("VariableName"=>"NID","Caption"=>"NID","ControlHTML"=>CTL_InputText("NID",$TheEntityName["NID"],"", 30,"required"));
			$Input[]=array("VariableName"=>"PassportNo","Caption"=>"Passport NUmber","ControlHTML"=>CTL_InputText("PassportNo",$TheEntityName["PassportNo"],"", 30,""));
			$Input[]=array("VariableName"=>"BirthCert","Caption"=>"Birth Certificate","ControlHTML"=>CTL_InputText("BirthCert",$TheEntityName["BirthCert"],"", 30,""));
			$Input[]=array("VariableName"=>"CompanyID","Caption"=>"Company ID","ControlHTML"=>CTL_InputText("CompanyID",$TheEntityName["CompanyID"],"", 30,""));
			$Input[]=array("VariableName"=>"DOB","Caption"=>"DOB","ControlHTML"=>CTL_InputText("DOB",$TheEntityName["DOB"],"", 30,"required"));
			$Input[]=array("VariableName"=>"FathersName","Caption"=>"Fathers Name","ControlHTML"=>CTL_InputText("FathersName",$TheEntityName["FathersName"],"", 30,""));
			$Input[]=array("VariableName"=>"MothersName","Caption"=>"Mothers Name","ControlHTML"=>CTL_InputText("MothersName",$TheEntityName["MothersName"],"", 30,""));
			$Input[]=array("VariableName"=>"SpouseName","Caption"=>"Spouse Name","ControlHTML"=>CTL_InputText("SpouseName",$TheEntityName["SpouseName"],"", 30,""));
			$Input[]=array("VariableName"=>"Religion","Caption"=>"Religion","ControlHTML"=>CTL_InputText("Religion",$TheEntityName["Religion"],"", 30,""));
			//$Input[]=array("VariableName"=>"BloodGroup","Caption"=>"Blood Group","ControlHTML"=>CTL_InputText("BloodGroup",$TheEntityName["BloodGroup"],"", 30,""));
			$Input[]=array("VariableName"=>"BloodGroup","Caption"=>"Blood Group","ControlHTML"=>DP_BloodGroup("BloodGroup",$TheEntityName["BloodGroup"]));
			$Input[]=array("VariableName"=>"PresentAddress","Caption"=>"Present Address","ControlHTML"=>CTL_InputText("PresentAddress",$TheEntityName["PresentAddress"],"", 30,"required"));
			$Input[]=array("VariableName"=>"PermanentAddress","Caption"=>"Permanent Address","ControlHTML"=>CTL_InputText("PermanentAddress",$TheEntityName["PermanentAddress"],"", 30,""));
			$Input[]=array("VariableName"=>"PhoneNo","Caption"=>"Phone Number","ControlHTML"=>CTL_InputText("PhoneNo",$TheEntityName["PhoneNo"],"", 30,"required"));
			$Input[]=array("VariableName"=>"Email","Caption"=>"Email","ControlHTML"=>CTL_InputText("Email",$TheEntityName["Email"],"", 30,"required"));
			$Input[]=array("VariableName"=>"Experience","Caption"=>"Experience","ControlHTML"=>CTL_InputText("Experience",$TheEntityName["Experience"],"", 30,""));
			$Input[]=array("VariableName"=>"Nationality","Caption"=>"Nationality","ControlHTML"=>CTL_InputText("Nationality",$TheEntityName["Nationality"],"", 30,"required"));
			$Input[]=array("VariableName"=>"BirthPlace","Caption"=>"Birth Place","ControlHTML"=>CTL_InputText("BirthPlace",$TheEntityName["BirthPlace"],"", 30,""));
			//$Input[]=array("VariableName"=>"Gender","Caption"=>"Gender","ControlHTML"=>CTL_InputText("Gender",$TheEntityName["Gender"],"", 30,"required"));
			$Input[]=array("VariableName"=>"Gender","Caption"=>"Gender","ControlHTML"=>DP_Gender("Gender",$TheEntityName["Gender"]));
			
			
			$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
			//$Input[]=array("VariableName"=>"Sep_Two","Caption"=>"","ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
			$MainContent.='<p id="ref">Reference</p>';			
			
			$Input[]=array("VariableName"=>"EduReference","Caption"=>"Education Reference","ControlHTML"=>CTL_InputText("EduReference",$TheEntityName["EduReference"],"", 30,""));
			$Input[]=array("VariableName"=>"ProReference","Caption"=>"Professional Reference","ControlHTML"=>CTL_InputText("ProReference",$TheEntityName["ProReference"],"", 30,""));
			$Input[]=array("VariableName"=>"FamReference","Caption"=>"Family Reference","ControlHTML"=>CTL_InputText("FamReference",$TheEntityName["FamReference"],"", 30,""));
			
			
			$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
			$MainContent.='<p id="con_address">Contact Address</p>';			
			$Input[]=array("VariableName"=>"Village","Caption"=>"Village","ControlHTML"=>CTL_InputText("Village",$TheEntityName["Village"],"", 30,""));
			$Input[]=array("VariableName"=>"PO","Caption"=>"P.O","ControlHTML"=>CTL_InputText("PO",$TheEntityName["PO"],"", 30,""));
			$Input[]=array("VariableName"=>"PS","Caption"=>"P.S","ControlHTML"=>CTL_InputText("PS",$TheEntityName["PS"],"", 30,""));
			$Input[]=array("VariableName"=>"District","Caption"=>"District","ControlHTML"=>CTL_InputText("District",$TheEntityName["District"],"", 30,""));
			$Input[]=array("VariableName"=>"HomePhone","Caption"=>"Home Phone","ControlHTML"=>CTL_InputText("HomePhone",$TheEntityName["HomePhone"],"", 30,""));

			
			
			$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
			$MainContent.='<p id="qualification">Qulifications</p>';
			$Input[]=array("VariableName"=>"CourseName","Caption"=>"Course Name","ControlHTML"=>CTL_InputText("CourseName",$TheEntityName["CourseName"],"", 30,""));
			$Input[]=array("VariableName"=>"PassingYear","Caption"=>"Passing Year","ControlHTML"=>CTL_InputText("PassingYear",$TheEntityName["PassingYear"],"", 30,""));
			$Input[]=array("VariableName"=>"Result","Caption"=>"Result","ControlHTML"=>CTL_InputText("Result",$TheEntityName["Result"],"", 30,""));
			$Input[]=array("VariableName"=>"Institute","Caption"=>"Board/University/Institute","ControlHTML"=>CTL_InputText("Institute",$TheEntityName["Institute"],"", 30,""));

			
					
			$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
			$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
			$MainContent.='<p id="file_attch">File Attachments</p>';
		    //$Input[]=array("VariableName"=>"FileName","Caption"=>"FileName","ControlHTML"=>CTL_InputText("FileName",$TheEntityName["FileName"],"", 30,"required"));
			$Input[]=array("VariableName"=>"CvUpload","Caption"=>"Cv Upload","ControlHTML"=>CTL_ImageUpload($ControlName="CvUpload",$TheEntityName["CvUpload"],$AllowDelete=true, $Class="FormTextInput", $ThumbnailHeight=100, $ThumbnailWidth=100 , $Preview=true));
			$Input[]=array("VariableName"=>"OfferLetter","Caption"=>"Offer Letter","ControlHTML"=>CTL_ImageUpload($ControlName="OfferLetter",$TheEntityName["OfferLetter"],$AllowDelete=true, $Class="FormTextInput", $ThumbnailHeight=100, $ThumbnailWidth=100 , $Preview=true));
			$Input[]=array("VariableName"=>"ContractPaper","Caption"=>"Contract Paper","ControlHTML"=>CTL_ImageUpload($ControlName="ContractPaper",$TheEntityName["ContractPaper"],$AllowDelete=true, $Class="FormTextInput", $ThumbnailHeight=100, $ThumbnailWidth=100 , $Preview=true));
			$Input[]=array("VariableName"=>"JoiningLetter","Caption"=>"Joining Letter","ControlHTML"=>CTL_ImageUpload($ControlName="JoiningLetter",$TheEntityName["JoiningLetter"],$AllowDelete=true, $Class="FormTextInput", $ThumbnailHeight=100, $ThumbnailWidth=100 , $Preview=true));
			//$Input[]=array("VariableName"=>"CvUpload","Caption"=>"Cv Upload","ControlHTML"=>CTL_FileUpload("CvUpload",$Preview=true));
			//$Input[]=array("VariableName"=>"EffectiveName","Caption"=>"EffectiveName","ControlHTML"=>CTL_InputText("EffectiveName",$TheEntityName["EffectiveName"],"", 30,"required"));

			
			$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
			$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
			$MainContent.='<p id="slaray">Salary Module</p>';
			
			$Input[]=array("VariableName"=>"BranchName","Caption"=>"Branch Name","ControlHTML"=>CCTL_BranchName($Name="BranchName",$TheEntityName["BranchName"], $ValueSelected=0, $Where="", $PrependBlankOption=false));
			//$Input[]=array("VariableName"=>"BranchName","Caption"=>"BranchName","ControlHTML"=>CTL_InputText("BranchName",$TheEntityName["BranchName"],"", 30,"required"));
			$Input[]=array("VariableName"=>"Department","Caption"=>"Department","ControlHTML"=>CCTL_DepartmentName($Name="Department",$TheEntityName["Department"], $ValueSelected=0, $Where="", $PrependBlankOption=false));
			//$Input[]=array("VariableName"=>"Department","Caption"=>"Department","ControlHTML"=>CTL_InputText("Department",$TheEntityName["Department"],"", 30,"required"));
			$Input[]=array("VariableName"=>"Designation","Caption"=>"Designation","ControlHTML"=>CCTL_DesignationName($Name="Designation",$TheEntityName["Designation"], $ValueSelected=0, $Where="", $PrependBlankOption=false));
			//$Input[]=array("VariableName"=>"Designation","Caption"=>"Designation","ControlHTML"=>CTL_InputText("Designation",$TheEntityName["Designation"],"", 30,"required"));
			$Input[]=array("VariableName"=>"JobStatus","Caption"=>"Job Status","ControlHTML"=>DP_JobStatus("JobStatus",$TheEntityName["JobStatus"]));
			
			$Input[]=array("VariableName"=>"BasicSalary","Caption"=>"Basic Salary","ControlHTML"=>CTL_InputText("BasicSalary",$TheEntityName["BasicSalary"],"", 30,""));		
			$Input[]=array("VariableName"=>"HouseRent","Caption"=>"HouseRent","ControlHTML"=>CTL_InputText("HouseRent",$TheEntityName["HouseRent"],"", 30,""));
			$Input[]=array("VariableName"=>"TravellingAllow","Caption"=>"Travelling Allowance","ControlHTML"=>CTL_InputText("TravellingAllow",$TheEntityName["TravellingAllow"],"", 30,""));
			$Input[]=array("VariableName"=>"MedicalAllow","Caption"=>"Medical Allowance","ControlHTML"=>CTL_InputText("MedicalAllow",$TheEntityName["MedicalAllow"],"", 30,""));
			$Input[]=array("VariableName"=>"Food","Caption"=>"Food","ControlHTML"=>CTL_InputText("Food",$TheEntityName["Food"],"", 30,""));
			$Input[]=array("VariableName"=>"Mobile","Caption"=>"Mobile","ControlHTML"=>CTL_InputText("Mobile",$TheEntityName["Mobile"],"", 30,""));
			$Input[]=array("VariableName"=>"Donation","Caption"=>"Donation","ControlHTML"=>CTL_InputText("Donation",$TheEntityName["Donation"],"", 30,""));
			$Input[]=array("VariableName"=>"PFund","Caption"=>"Provident Fund","ControlHTML"=>CTL_InputText("PFund",$TheEntityName["PFund"],"", 30,""));
			$Input[]=array("VariableName"=>"Tax","Caption"=>"Tax","ControlHTML"=>CTL_InputText("Tax",$TheEntityName["Tax"],"", 30,""));


			
		    //$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
		    $Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
			$MainContent.='<p id="set_titme">Office Time Set(Hour-Minute)</p>';
			//$MainContent.='<p id="set_hour">Hour</p>';
			//$MainContent.='<p id="set_minute">Minute</p>';
			
			
			
			
			/* friday time set start */
			$Input[]=array("VariableName"=>"FridayInHour","Caption"=>"Friday In Time","ControlHTML"=>"<select name=\"FridayInHour\" class=\"required\"  id=\"IntimeH\"><option>{$TheEntityName["FridayInHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"FridayInMin","Caption"=>"","ControlHTML"=>"<select name=\"FridayInMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["FridayInMin"]}</option>'$logoutHTML'</select>");
			$Input[]=array("VariableName"=>"FridayStatus", "Caption"=>"IsHoliday?", "ControlHTML"=>CTL_InputRadioSet($VariableName="FridayStatus", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["FridayStatus"]), "Required"=>false);
			$Input[]=array("VariableName"=>"FridayOutHour","Caption"=>"Friday Out Time","ControlHTML"=>"<select class=\"required\" name=\"FridayOutHour\" id=\"IntimeH\"><option>{$TheEntityName["FridayOutHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"FridayOutMin","Caption"=>"","ControlHTML"=>"<select name=\"FridayOutMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["FridayOutMin"]}</option>'$logoutHTML'</select>");
            $Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled style=\"margin-top: 20px;\" value=\"{$TheEntityName["Sep_Two"]}\"/>	");
            /* friday time set end */	


			/* Saturday time set start */
			$Input[]=array("VariableName"=>"SaturdayInHour","Caption"=>"Saturday In Time","ControlHTML"=>"<select name=\"SaturdayInHour\" class=\"required\"  id=\"IntimeH\"><option>{$TheEntityName["SaturdayInHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"SaturdayInMin","Caption"=>"","ControlHTML"=>"<select name=\"SaturdayInMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["SaturdayInMin"]}</option>'$logoutHTML'</select>");
			$Input[]=array("VariableName"=>"SaturdayStatus", "Caption"=>"IsHoliday?", "ControlHTML"=>CTL_InputRadioSet($VariableName="SaturdayStatus", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["SaturdayStatus"]), "Required"=>false);
			$Input[]=array("VariableName"=>"SaturdayOutHour","Caption"=>"Saturday Out Time","ControlHTML"=>"<select class=\"required\" name=\"SaturdayOutHour\" id=\"IntimeH\"><option>{$TheEntityName["SaturdayOutHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"SaturdayOutMin","Caption"=>"","ControlHTML"=>"<select name=\"SaturdayOutMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["SaturdayOutMin"]}</option>'$logoutHTML'</select>");
            $Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled style=\"margin-top: 20px;\" value=\"{$TheEntityName["Sep_Two"]}\"/>	");
            /* Saturday time set end */
			
			
			/* Sunday time set start */
			$Input[]=array("VariableName"=>"SundayInHour","Caption"=>"Sunday In Time","ControlHTML"=>"<select name=\"SundayInHour\" class=\"required\"  id=\"IntimeH\"><option>{$TheEntityName["SundayInHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"SundayInMin","Caption"=>"","ControlHTML"=>"<select name=\"SundayInMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["SundayInMin"]}</option>'$logoutHTML'</select>");
			$Input[]=array("VariableName"=>"SundayStatus", "Caption"=>"IsHoliday?", "ControlHTML"=>CTL_InputRadioSet($VariableName="SundayStatus", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["SundayStatus"]), "Required"=>false);
			$Input[]=array("VariableName"=>"SundayOutHour","Caption"=>"Sunday Out Time","ControlHTML"=>"<select class=\"required\" name=\"SundayOutHour\" id=\"IntimeH\"><option>{$TheEntityName["SundayOutHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"SundayOutMin","Caption"=>"","ControlHTML"=>"<select name=\"SundayOutMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["SundayOutMin"]}</option>'$logoutHTML'</select>");
            $Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled style=\"margin-top: 20px;\" value=\"{$TheEntityName["Sep_Two"]}\"/>	");
            /* Sunday time set end */

			
			/* Monday time set start */
			$Input[]=array("VariableName"=>"MondayInHour","Caption"=>"Monday In Time","ControlHTML"=>"<select name=\"MondayInHour\" class=\"required\"  id=\"IntimeH\"><option>{$TheEntityName["MondayInHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"MondayInMin","Caption"=>"","ControlHTML"=>"<select name=\"MondayInMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["MondayInMin"]}</option>'$logoutHTML'</select>");
			$Input[]=array("VariableName"=>"MondayStatus", "Caption"=>"IsHoliday?", "ControlHTML"=>CTL_InputRadioSet($VariableName="MondayStatus", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["MondayStatus"]), "Required"=>false);
			$Input[]=array("VariableName"=>"MondayOutHour","Caption"=>"Monday Out Time","ControlHTML"=>"<select class=\"required\" name=\"MondayOutHour\" id=\"IntimeH\"><option>{$TheEntityName["MondayOutHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"MondayOutMin","Caption"=>"","ControlHTML"=>"<select name=\"MondayOutMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["MondayOutMin"]}</option>'$logoutHTML'</select>");
            $Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled style=\"margin-top: 20px;\" value=\"{$TheEntityName["Sep_Two"]}\"/>	");
            /* Monday time set end */

			
			/* Thursday time set start */
			$Input[]=array("VariableName"=>"ThursdayInHour","Caption"=>"Thursday In Time","ControlHTML"=>"<select name=\"ThursdayInHour\" class=\"required\"  id=\"IntimeH\"><option>{$TheEntityName["ThursdayInHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"ThursdayInMin","Caption"=>"","ControlHTML"=>"<select name=\"ThursdayInMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["ThursdayInMin"]}</option>'$logoutHTML'</select>");
			$Input[]=array("VariableName"=>"ThursdayStatus", "Caption"=>"IsHoliday?", "ControlHTML"=>CTL_InputRadioSet($VariableName="ThursdayStatus", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["ThursdayStatus"]), "Required"=>false);
			$Input[]=array("VariableName"=>"ThursdayOutHour","Caption"=>"Thursday Out Time","ControlHTML"=>"<select class=\"required\" name=\"ThursdayOutHour\" id=\"IntimeH\"><option>{$TheEntityName["ThursdayOutHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"ThursdayOutMin","Caption"=>"","ControlHTML"=>"<select name=\"ThursdayOutMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["ThursdayOutMin"]}</option>'$logoutHTML'</select>");
            $Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled style=\"margin-top: 20px;\" value=\"{$TheEntityName["Sep_Two"]}\"/>	");
            /* Thursday time set end */	


			
			/* Wednesday time set start */
			$Input[]=array("VariableName"=>"WednesdayInHour","Caption"=>"Wednesday In Time","ControlHTML"=>"<select name=\"WednesdayInHour\" class=\"required\"  id=\"IntimeH\"><option>{$TheEntityName["WednesdayInHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"WednesdayInMin","Caption"=>"","ControlHTML"=>"<select name=\"WednesdayInMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["WednesdayInMin"]}</option>'$logoutHTML'</select>");
			$Input[]=array("VariableName"=>"WednesdayStatus", "Caption"=>"IsHoliday?", "ControlHTML"=>CTL_InputRadioSet($VariableName="WednesdayStatus", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["WednesdayStatus"]), "Required"=>false);
			$Input[]=array("VariableName"=>"WednesdayOutHour","Caption"=>"Wednesday Out Time","ControlHTML"=>"<select class=\"required\" name=\"WednesdayOutHour\" id=\"IntimeH\"><option>{$TheEntityName["WednesdayOutHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"WednesdayOutMin","Caption"=>"","ControlHTML"=>"<select name=\"WednesdayOutMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["WednesdayOutMin"]}</option>'$logoutHTML'</select>");
            $Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled style=\"margin-top: 20px;\" value=\"{$TheEntityName["Sep_Two"]}\"/>	");
            /* Wednesday time set end */

			
			/* Tuesday time set start */
			$Input[]=array("VariableName"=>"TuesdayInHour","Caption"=>"Tuesday In Time","ControlHTML"=>"<select name=\"TuesdayInHour\" class=\"required\"  id=\"IntimeH\"><option>{$TheEntityName["TuesdayInHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"TuesdayInMin","Caption"=>"","ControlHTML"=>"<select name=\"TuesdayInMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["TuesdayInMin"]}</option>'$logoutHTML'</select>");
			$Input[]=array("VariableName"=>"TuesdayStatus", "Caption"=>"IsHoliday?", "ControlHTML"=>CTL_InputRadioSet($VariableName="TuesdayStatus", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["TuesdayStatus"]), "Required"=>false);
			$Input[]=array("VariableName"=>"TuesdayOutHour","Caption"=>"Tuesday Out Time","ControlHTML"=>"<select class=\"required\" name=\"TuesdayOutHour\" id=\"IntimeH\"><option>{$TheEntityName["TuesdayOutHour"]}</option>'$insertHTML'</select>");
			$Input[]=array("VariableName"=>"TuesdayOutMin","Caption"=>"","ControlHTML"=>"<select name=\"TuesdayOutMin\" class=\"required\" id=\"IntimeS\"><option>{$TheEntityName["TuesdayOutMin"]}</option>'$logoutHTML'</select>");
            $Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\"  disabled style=\"margin-top: 20px;\" value=\"{$TheEntityName["Sep_Two"]}\"/>	");
            /* Tuesday time set end */


	
			
			$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
			$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
			$MainContent.='<p id="page">Manage Page</p>';

			$Input[]=array("VariableName"=>"UserName","Caption"=>"User Name","ControlHTML"=>CTL_InputText("UserName",$TheEntityName["UserName"],"", 30,"required"));
			//$Input[]=array("VariableName"=>"UserEmail","Caption"=>"Email","ControlHTML"=>CTL_InputText("UserEmail",$TheEntityName["UserEmail"],"", 30,"required"));
			$Input[]=array("VariableName"=>"UserPassword","Caption"=>"Password","ControlHTML"=>CTL_InputText("UserPassword",$TheEntityName["UserPassword"],"", 30,"required"));
			//$Input[]=array("VariableName"=>"UserCategory","Caption"=>"Category","ControlHTML"=>UserCategory("UserCategory",$TheEntityName["UserCategory"]));
			//$Input[]=array("VariableName"=>"PhoneHome","Caption"=>"Phone","ControlHTML"=>CTL_InputText("PhoneHome",$TheEntityName["PhoneHome"],"", 30,"required"));

			
			
			$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
			$Input[]=array("ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"Sep_Two\" name=\"Sep_Two\" class=\"required\" disabled value=\"{$TheEntityName["Sep_Two"]}\"/>	");
			$MainContent.='<p id="permission">Permission</p>';

			$Input[]=array("VariableName"=>"PhoneHome","Caption"=>"Allow Options","ControlHTML"=>'
				Branch'.CTL_InputRadioSet($VariableName="OptionCategory", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionCategory"]).'<br>
				Department '.CTL_InputRadioSet($VariableName="OptionProduct", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionProduct"]).'<br>
				Designation '.CTL_InputRadioSet($VariableName="OptionVendor", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionVendor"]).'<br>
				Employee '.CTL_InputRadioSet($VariableName="OptionPurchase", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionPurchase"]).'<br>
				Recruitment '.CTL_InputRadioSet($VariableName="OptionCustomer", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionCustomer"]).'<br>
				Requisiton '.CTL_InputRadioSet($VariableName="OptionSales", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionSales"]).'<br>
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