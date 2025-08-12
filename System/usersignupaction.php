<?
    $Entity="UserSignUp";
    $EntityLower=strtolower($Entity);

    CheckRequiredFormVariables(
		$Variable=array(
			array("Name"=>"SignUpUserName", "Message"=>"Please provide with the user name."),
			array("Name"=>"SignUpUserEmail", "Message"=>"Please provide with the email."),
		)
	);

	$User=SQL_Select($Entity="User", $Where="U.UserName='{$_POST["SignUpUserName"]}' OR U.UserEmail = '{$_POST["SignUpUserEmail"]}'");
    if(count($User)>0){
	    $ErrorUserInput["_Error"]=true;
	    $ErrorUserInput["_Message"]="Sorry, this username and/or email address has already been used!";
	}

    if($ErrorUserInput["_Error"]){
        include "./script/System/$EntityLower.php";
	}else{
	    $Where="";
	    $User=SQL_InsertUpdate(
	        $Entity="User",
	        $EntityAlias="U",
			$UserData=array(
	            "UserName"							=>	$_POST["SignUpUserName"],
	            "UserPassword"						=>	RandomPassword(),
	            "UserEmail"							=>	$_POST["SignUpUserEmail"],
				"UserCategory"						=>	$_POST["UserCategory"],
				"NameFirst"							=>	"",
				"NameMiddle"						=>	"",
				"NameLast"							=>	"",
				"Street"							=>	"",
				"City"								=>	"",
				"ZIP"								=>	"",
				"State"								=>	"",
				"CountryID"							=>	1,
				"PhoneHome"							=>	"",
				"PhoneOffice"						=>	"",
				"PhoneMobile"						=>	"",
				"PhoneDay"							=>	"",
				"FAX"								=>	"",
				"Website"							=>	"",
				"DateBorn"							=>	"",
				"UserPicture"						=>	"",
				"UserIDParent"						=>	0,
	            "UserIsActive"						=>	1,
				"UserRegistrationCode"				=>	GUID().GUID(),
				"UserIsRegistered"  				=>  0,
				"UserRegistrationPendingApprovals"	=>	0,
				"UserIsApproved"					=>	1
			),
			$Where
		);
		

		//Email the log in information to the user with a registration confirmation
		SendMail(
			$ToEmail=$User["UserEmail"],
			$Subject="Your login detail",
			$Body="
				Welcome <b>{$User["UserName"]}</b> to <b>{$Application["Title"]}</b>.<br>
				<br>
				Please find your log in detail below:<br>
				<br>
				Username: <b>{$User["UserName"]}</b><br>
				Password: {$User["UserPassword"]}<br>
				<br>
				Please click <a href=\"".ApplicationURL("System",$Script="usersignupconfirm", $OtherParameter="UserID={$User["UserID"]}&UserUUID={$User["UserUUID"]}&UserRegistrationCode={$User["UserRegistrationCode"]}")."\">here</a> or follow the link below to confirm your registration first in order to allow the system to log you in.<br>
				<br>
				".ApplicationURL("System",$Script="usersignupconfirm", $OtherParameter="UserID={$User["UserID"]}&UserUUID={$User["UserUUID"]}&UserRegistrationCode={$User["UserRegistrationCode"]}")."<br>
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

		//Email a notification to the administrator
		SendMail(
			$ToEmail=$Application["EmailContact"],
			$Subject="New user registration alert",
			$Body="
				The following user has registerd into the system:<br>
				<br>
				Username: <b>{$User["UserName"]}</b><br>
				Email: <a href=\"mailto:{$User["UserEmail"]}\">{$User["UserEmail"]}</a><br>
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
				$Title="Registration successful",
				$Content="
				    Thank you for registering with us.<br>
				    <br>
				    Please check your email account for the log in information.<br>
				    <br>
				    Also note that you will have to follow the link provided into that email to actiavte your account here.<br>
				    <br>
				    Have a nice journey with us.<br>
					<br>
					Please click <a href=\"".ApplicationURL("Page","Home")."\">here</a> to continue.
				"
			)."
		    <script language=\"JavaScript\">
		    <!--
		        //window.location='".ApplicationURL("Page","Home")."';
		    //-->
			</script>
		";
	}
?> 