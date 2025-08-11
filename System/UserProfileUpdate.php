<?
    $Entity="UserProfile";
    $EntityLower=strtolower($Entity);

    CheckRequiredFormVariables(
		$Variable=array(
			array("Name"=>"UserEmail", "Message"=>"Please provide with the email."),
			array("Name"=>"UserPassword", "Message"=>"Please provide with the password."),
			array("Name"=>"UserPasswordConfirm", "Message"=>"Please verify password."),
		)
	);
	
	if($_POST["UserPassword"]!=$_POST["UserPasswordConfirm"]){
	    $ErrorUserInput["_Error"]=true;
	     $ErrorUserInput["_Message"]="The passwords didn't match!";
	}

    if($ErrorUserInput["_Error"]){
        include "./script/System/$EntityLower.php";
	}else{
	    $User=SQL_Select($Entity="User", $Where="UserID = {$_SESSION["UserID"]}", $OrderBy="UserName", $SingleRow=true, $RecordShowFrom=0, $RecordShowUpTo=0, $Debug=false);
	    $_POST["UserPicture"]=ProcessUpload($FieldName="UserPicture", $UploadPath=$Application["UploadPath"]);

	    $Where="UserID = {$_SESSION["UserID"]}";
	    SQL_InsertUpdate(
	        $Entity="User",
			$UserData=array(
			    "NameFirst"=>							$_POST["NameFirst"],
			    "UserPassword"=>							$_POST["UserPassword"],
			    "NameLast"=>							$_POST["NameLast"],
			    "Street"=>								$_POST["Street"],
			    "City"=>								$_POST["City"],
			    "ZIP"=>									$_POST["ZIP"],
			    "State"=>								$_POST["State"],
			    "CountryID"=>							$_POST["CountryID"],
			    "PhoneHome"=>							$_POST["PhoneHome"],
			    "PhoneOffice"=>							$_POST["PhoneOffice"],
			    "PhoneMobile"=>							$_POST["PhoneMobile"],
			    "PhoneDay"=>							$_POST["PhoneDay"],
			    "FAX"=>									$_POST["FAX"],
			    "Website"=>								$_POST["Website"],
			    "DateBorn"=>							"{$_POST["DateBornYear"]}-{$_POST["DateBornMonth"]}-{$_POST["DateBornDay"]}",
			    "UserPicture"=>							$_POST["UserPicture"],

			    "UserIDParent"=>						0,
			    "UserIsActive"=>						$User["UserIsActive"],
			    "UserIsRegistered"=>					$User["UserIsRegistered"],
			    "UserRegistrationCode"=>				$User["UserRegistrationCode"],
				"UserRegistrationPendingApprovals"=>	0,
				"UserIsApproved"=>						1,
			),
			$Where
		);

		//Email the log in information to the user
		SendMail(
			$ToEmail=$_POST["UserEmail"],
			$Subject="Your login detail",
			$Body="
				Dear <b>{$_SESSION["UserName"]}</b>,<br>
				<br>
				Please find your log in detail below:<br>
				<br>
				Username: <b>{$_SESSION["UserName"]}</b><br>
				Password: <b>{$_POST["UserPassword"]}</b><br>
				<br>
				Please click <a href=\"".ApplicationURL("System","login")."\">here</a> to log into your account.<br>
				<br>
				Thanking you,<br>
				<br>
				<b>{$Application["Title"]}</b>
			",
			$FromName=$Application["Title"],
			$FromEmail = $Application["EmailContact"],
			$ReplyToName=$Application["Title"],
			$ReplyToEmail=$Application["EmailContact"],
			$ExtraHeaderParameters=""
		);

		$MainContent.=CTL_Window(
				$Title="Operation successful",
				$Content="The user data has been stored successfully, please click <a href=\"".ApplicationURL("Page","Home")."\">here</a> to continue."
			)."
		    <script language=\"JavaScript\">
		       window.location='".ApplicationURL("System","UserProfile")."';
			</script>
		";
	}
	

?> 