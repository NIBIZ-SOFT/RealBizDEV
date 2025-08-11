<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"]))$UpdateMode=true;

    $ErrorUserInput["_Error"]=false;

	if(!$UpdateMode)$_REQUEST["{$Entity}ID"]=0;
	//some change goes here
	$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$UniqueField} = '{$_POST["{$UniqueField}"]}' AND {$Entity}ID <> {$_REQUEST[$Entity."ID"]}");
	//'
	
	if(count($TheEntityName)>0){
	    $ErrorUserInput["_Error"]=true;
	    $ErrorUserInput["_Message"]="This Value Already Taken.";
	}

    if($ErrorUserInput["_Error"]){
        include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	}else{
	    $Where="";
	    if($UpdateMode)$Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'";

		//sa($_POST);
		//echo $_POST["OptionVendor"];
		//exit;
		// give the data dase fields name and the post value name
	   $_POST["UserImage"]=ProcessUpload($FieldName="UserImage", $UploadPath=$Application["UploadPath"]);
	   $_POST["OfferLetter"]=ProcessUpload($FieldName="OfferLetter", $UploadPath=$Application["UploadPath"]);
	   $_POST["ContractPaper"]=ProcessUpload($FieldName="ContractPaper", $UploadPath=$Application["UploadPath"]);
	   $_POST["JoiningLetter"]=ProcessUpload($FieldName="JoiningLetter", $UploadPath=$Application["UploadPath"]);
	   
	   
	   	       $p_Village=$_POST["p_Village"];
			   if($p_Village==''){
			     $vaddress=$_POST["Village"];
			   }else{
			     $vaddress=$_POST["p_Village"];
			   }
	   	   
		   
	   	       $p_PO=$_POST["p_PO"];
			   if($p_PO==''){
			     $vpo=$_POST["PO"];
			   }else{
			     $vpo=$_POST["p_PO"];
			   }


			   
	   	       $p_PS=$_POST["p_PS"];
			   if($p_PS==''){
			     $vps=$_POST["PS"];
			   }else{
			     $vps=$_POST["p_PS"];
			   }
	   
			   
	   	       $p_District=$_POST["p_District"];
			   if($p_District==''){
			     $vdistrict=$_POST["District"];
			   }else{
			     $vdistrict=$_POST["p_District"];
			   }
			   
			   
	   	   	   $p_HomePhone=$_POST["p_HomePhone"];
			   if($p_HomePhone==''){
			     $vhomephone=$_POST["HomePhone"];
			   }else{
			     $vhomephone=$_POST["p_HomePhone"];
			   }
	   

	   $TheEntityName=SQL_InsertUpdate(
	   
	        $Entity="{$Entity}",
			$TheEntityNameData=array(
                                                                                              
				"att_device_id"=>$_POST["att_device_id"],
				"FullName"=>$_POST["FullName"],
				"NID"=>$_POST["NID"],
				"PassportNo"=>$_POST["PassportNo"],
				"BirthCert"=>$_POST["BirthCert"],
				"CompanyID"=>$_POST["CompanyID"],
				"DOB"=>$_POST["DOB"],
				"FathersName"=>$_POST["FathersName"],
				"MothersName"=>$_POST["MothersName"],
				"SpouseName"=>$_POST["SpouseName"],
				"Religion"=>$_POST["Religion"],
				"BloodGroup"=>$_POST["BloodGroup"],
				"PresentAddress"=>$_POST["PresentAddress"],
				"PermanentAddress"=>$_POST["PermanentAddress"],
				"PhoneNo"=>$_POST["PhoneNo"],
				"Email"=>$_POST["Email"],
				"Experience"=>$_POST["Experience"],
				"Nationality"=>$_POST["Nationality"],
				"BirthPlace"=>$_POST["BirthPlace"],
				"Gender"=>$_POST["Gender"],
				
				
				"EduReference"=>$_POST["EduReference"],
				"ProReference"=>$_POST["ProReference"],
				"FamReference"=>$_POST["FamReference"],
				
				
				"Village"=>$_POST["Village"],
				"PO"=>$_POST["PO"],
				"PS"=>$_POST["PS"],
				"District"=>$_POST["District"],
				"HomePhone"=>$_POST["HomePhone"],
				
				
								
				"p_Village"=>$vaddress,
				"p_PO"=>$vpo,
				"p_PS"=>$vps,
				"p_District"=>$vdistrict,
				"p_HomePhone"=>$vhomephone,
				
				
				"CourseName"=>$_POST["CourseName"],
				"PassingYear"=>$_POST["PassingYear"],
				"Result"=>$_POST["Result"],
				"Institute"=>$_POST["Institute"],
				
				
				"UserImage"=>$_POST["UserImage"],
				"OfferLetter"=>$_POST["OfferLetter"],
				"ContractPaper"=>$_POST["ContractPaper"],
				"JoiningLetter"=>$_POST["JoiningLetter"],
				
				
				"BranchName"=>$_POST["BranchName"],
				"Department"=>$_POST["Department"],
				"Designation"=>$_POST["Designation"],
				"JobStatus"=>$_POST["JobStatus"],
				
				"BasicSalary"=>$_POST["BasicSalary"],		
				"HouseRent"=>$_POST["HouseRent"],
				"TravellingAllow"=>$_POST["TravellingAllow"],
				"MedicalAllow"=>$_POST["MedicalAllow"],
				"Food"=>$_POST["Food"],
				"Mobile"=>$_POST["Mobile"],
				"Donation"=>$_POST["Donation"],
				"PFund"=>$_POST["PFund"],
				"Tax"=>$_POST["Tax"],
				
				
				"UserName"=>$_POST["UserName"],
				//"UserEmail"=>$_POST["UserEmail"],
				"UserPassword"=>$_POST["UserPassword"],
				"UserCategory"=>$_POST["UserCategory"],
				//"PhoneHome"=>$_POST["PhoneHome"],
				
				
				"FridayInHour"=>$_POST["FridayInHour"],
				"FridayInMin"=>$_POST["FridayInMin"],
				$fih=$_POST["FridayInHour"],
				$fim=$_POST["FridayInMin"],
				$FridayInTime=$fih.':'.$fim,
				"FridayInTime"=>$FridayInTime,
				
				"FridayOutHour"=>$_POST["FridayOutHour"],
				"FridayOutMin"=>$_POST["FridayOutMin"],
				$foh=$_POST["FridayOutHour"],
				$fom=$_POST["FridayOutMin"],
				$FridayOutTime=$foh.':'.$fom,
				"FridayOutTime"=>$FridayOutTime,
				"FridayStatus"=>$_POST["FridayStatus"],	

				
				"SaturdayInHour"=>$_POST["SaturdayInHour"],
				"SaturdayInMin"=>$_POST["SaturdayInMin"],
				$sih=$_POST["SaturdayInHour"],
				$sim=$_POST["SaturdayInMin"],
				$SaturdayInTime=$sih.':'.$sim,
				"SaturdayInTime"=>$SaturdayInTime,
				
				"SaturdayOutHour"=>$_POST["SaturdayOutHour"],
				"SaturdayOutMin"=>$_POST["SaturdayOutMin"],
				$soh=$_POST["SaturdayOutHour"],
				$som=$_POST["SaturdayOutMin"],
				$SaturdayOutTime=$soh.':'.$som,
				"SaturdayOutTime"=>$SaturdayOutTime,
				
				"SaturdayStatus"=>$_POST["SaturdayStatus"],
				
				
				"SundayInHour"=>$_POST["SundayInHour"],
				"SundayInMin"=>$_POST["SundayInMin"],
				$sunih=$_POST["SundayInHour"],
				$sunim=$_POST["SundayInMin"],
				$SundayInTime=$sunih.':'.$sunim,
				"SundayInTime"=>$SundayInTime,
				
				"SundayOutHour"=>$_POST["SundayOutHour"],
				"SundayOutMin"=>$_POST["SundayOutMin"],
				$sunoh=$_POST["SundayOutHour"],
				$sunom=$_POST["SundayOutMin"],
				$SundayOutTime=$sunoh.':'.$sunom,
				"SundayOutTime"=>$SundayOutTime,
				
				"SundayStatus"=>$_POST["SundayStatus"],	


				
				"MondayInHour"=>$_POST["MondayInHour"],
				"MondayInMin"=>$_POST["MondayInMin"],
				$mih=$_POST["MondayInHour"],
				$mim=$_POST["MondayInMin"],
				$MondayInTime=$mih.':'.$mim,
				"MondayInTime"=>$MondayInTime,
				
				"MondayOutHour"=>$_POST["MondayOutHour"],
				"MondayOutMin"=>$_POST["MondayOutMin"],
				$moh=$_POST["MondayOutHour"],
				$mom=$_POST["MondayOutMin"],
				$MondayOutTime=$moh.':'.$mom,
				"MondayOutTime"=>$SundayOutTime,
				
				"MondayStatus"=>$_POST["MondayStatus"],
				
				
				"ThursdayInHour"=>$_POST["ThursdayInHour"],
				"ThursdayInMin"=>$_POST["ThursdayInMin"],
				$thih=$_POST["ThursdayInHour"],
				$thim=$_POST["ThursdayInMin"],
				$ThursdayInTime=$thih.':'.$thim,
				"ThursdayInTime"=>$ThursdayInTime,
				
				"ThursdayOutHour"=>$_POST["ThursdayOutHour"],
				"ThursdayOutMin"=>$_POST["ThursdayOutMin"],
				$thoh=$_POST["ThursdayOutHour"],
				$thom=$_POST["ThursdayOutMin"],
				$ThursdayOutTime=$thoh.':'.$thom,
				"ThursdayOutTime"=>$ThursdayOutTime,
				
				"ThursdayStatus"=>$_POST["ThursdayStatus"],				
				
				
				
				"WednesdayInHour"=>$_POST["WednesdayInHour"],
				"WednesdayInMin"=>$_POST["WednesdayInMin"],
				$wih=$_POST["WednesdayInHour"],
				$wim=$_POST["WednesdayInMin"],
				$WednesdayInTime=$wih.':'.$wim,
				"WednesdayInTime"=>$WednesdayInTime,
				
				"WednesdayOutHour"=>$_POST["WednesdayOutHour"],
				"WednesdayOutMin"=>$_POST["WednesdayOutMin"],
				$woh=$_POST["WednesdayOutHour"],
				$wom=$_POST["WednesdayOutMin"],
				$WednesdayOutTime=$woh.':'.$wom,
				"WednesdayOutTime"=>$WednesdayOutTime,
				
				"WednesdayStatus"=>$_POST["WednesdayStatus"],				
				
				
				
				"TuesdayInHour"=>$_POST["TuesdayInHour"],
				"TuesdayInMin"=>$_POST["TuesdayInMin"],
				$tuih=$_POST["TuesdayInHour"],
				$tuim=$_POST["TuesdayInMin"],
				$TuesdayInTime=$tuih.':'.$tuim,
				"TuesdayInTime"=>$TuesdayInTime,
				
				"TuesdayOutHour"=>$_POST["TuesdayOutHour"],
				"TuesdayOutMin"=>$_POST["TuesdayOutMin"],
				$tuoh=$_POST["TuesdayOutHour"],
				$tuom=$_POST["TuesdayOutMin"],
				$TuesdayOutTime=$tuoh.':'.$tuom,
				"TuesdayOutTime"=>$TuesdayOutTime,
				
				"TuesdayStatus"=>$_POST["TuesdayStatus"],


				
				"UserIsRegistered"=>1,
				"UserIsApproved"=>1,

		        "{$Entity}IsActive"=>$_POST["{$Entity}IsActive"],
			),
			$Where
			);


	    $MainContent.="
	        ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","Manage")."\">here</a> to proceed.",300)."
	        <script language=\"JavaScript\" >
	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","Manage")."';
	        </script>
		";
	}
?>