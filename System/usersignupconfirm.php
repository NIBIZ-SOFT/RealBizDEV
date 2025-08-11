<?
	/*
		Script:		usersignupconfirm.php
		Author:		@gmail.com
		Purpose:    Update the registration information for the registrant user
		Date:		Last updated 02-02-07
		Note:		
	*/
	
	$User=SQL_Select($Entity="User", $Where="U.UserID = {$_REQUEST["UserID"]} AND U.UserUUID = '{$_REQUEST["UserUUID"]}' AND U.UserRegistrationCode = '{$_REQUEST["UserRegistrationCode"]}'", $OrderBy="U.UserName", $SignleRow=true, $Debug=false);
	if(count($User)>1){
	    $User=SQL_InsertUpdate(
	        $Entity="User",
	        $EntityAlias="U",
			$UserData=array(
	            "UserName"			=>	$User["UserName"],
	            "UserPassword"		=>	$User["UserPassword"],
	            "UserEmail"			=>	$User["UserEmail"],
				"UserCategory"		=>	$User["UserCategory"],
	            "UserIsActive"		=>	$User["UserIsActive"],
				"NameFirst"			=>	$User["NameFirst"],
				"NameMiddle"		=>	$User["NameMiddle"],
				"NameLast"			=>	$User["NameLast"],
				"Street"			=>	$User["Street"],
				"City"				=>	$User["City"],
				"State"				=>	$User["State"],
				"ZIP"				=>	$User["ZIP"],
				"CountryID"			=>	$User["CountryID"],
				"PhoneHome"			=>	$User["PhoneHome"],
				"PhoneOffice"		=>	$User["PhoneOffice"],
				"PhoneMobile"		=>	$User["PhoneMobile"],
				"PhoneDay"			=>	$User["PhoneDay"],
				"FAX"				=>	$User["FAX"],
				"Website"			=>	$User["Website"],
				"DateBorn"			=>	$User["DateBorn"],

				"UserIDParent"			=>	$User["UserIDParent"],
				"UserRegistrationPendingApprovals"			=>	$User["UserRegistrationPendingApprovals"],
				"UserIsApproved"			=>	$User["UserIsApproved"],

				"UserRegistrationCode"	=>	$User["UserRegistrationCode"],
				"UserIsRegistered"    	=>  1,
				"UserPicture"		=>	$User["UserPicture"]
			),
			$Where="UserID = {$_REQUEST["UserID"]} AND UserUUID = '{$_REQUEST["UserUUID"]}' AND UserRegistrationCode = '{$_REQUEST["UserRegistrationCode"]}'"
		);

		SendMail(
			$ToEmail=$User["UserEmail"],
			$Subject="Your login detail",
			$Body="
				Dear <b>{$User["UserName"]}</b>,<br>
				<br>
				This is to confirm that you have successfully confirmed your user account over <b>{$Application["Title"]}</b>.<br>
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

	// Insert the memeber UserName
	$User=SQL_Select($Entity="User", $Where="U.UserID = {$_REQUEST["UserID"]} AND U.UserUUID = '{$_REQUEST["UserUUID"]}' AND U.UserRegistrationCode = '{$_REQUEST["UserRegistrationCode"]}'", $OrderBy="U.UserName", $SignleRow=true, $Debug=false);
	SQL_InsertUpdate(
	    $Entity="Members",
	    $EntityAlias="M",
	    $Data=array(
	        "MembersUserName" => "{$User["UserName"]}",
	        "MembersIsActive" => 1
		),
	    $Where="",
	    $Debug=false
	);


		$Message="
		    Thank you for confirming your registration. You can now log into the system using the log in information we sent you before
		    to the email address you signed up with.<br>
		    <br>
		    <b>{$Application["Title"]}</b>
		";
	}else{
		$Message="
		    Sorry, we could not find any sign up request for the confirmation link you provided with.<br>
		    <br>
		    <b>{$Application["Title"]}</b>
		";
	}

	$MainContent.=CTL_Window(
		$Title="Registration successful",
		$Content=$Message
	);
	
	
	
	
?> 
