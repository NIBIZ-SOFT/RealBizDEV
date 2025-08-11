<?
	/*
		Script:		userpasswordrecoveraction.php
		Author:		SunJove@gamil.com
		Purpose:	Send the password to the email address
		Date:		Last updated 01-19-07
		Note:		
	*/
	
	$User=SQL_Select($Entity="User", $Where="UserEmail = '{$_POST["UserEmail"]}'", $OrderBy="UserName", $SingleRow=false, $RecordShowFrom=0, $RecordShowUpTo=0, $Debug=false);
	if(count($User)>0){
	    $MainContent.=CTL_Window($Title="System Security",
			$Content="
			    The password has been sent to the email address you specified.
			",
			$Width="",
			$Icon="security",
			$Template=""
		);

    	$NewPassword=RandomPassword();
    	MySQLQuery("UPDATE tbluser SET UserPassword = '$NewPassword' WHERE UserEmail = '{$_POST["UserEmail"]}'");
		$User=SQL_Select($Entity="User", $Where="UserEmail = '{$_POST["UserEmail"]}'", $OrderBy="UserName", $SingleRow=true, $RecordShowFrom=0, $RecordShowUpTo=0, $Debug=false);

		//Email the changed log in information to the user with a registration confirmation
		SendMail(
			$ToEmail=$User["UserEmail"],
			$Subject="Your login detail",
			$Body="
				Upon your request, we have reset your login password on our system.<br>
				<br>
				If you didn't request this information, please log into your account immediately and change your password to prevent unauthorized use of your information.<br>
				<br>
				Username: <b>{$User["UserName"]}</b><br>
				Password: {$User["UserPassword"]}<br>
				<br>
				Please click <a href=\"".ApplicationURL()."\">here</a> to log into your account.<br>
				<br>
				Thanking you,<br>
				<br>
				<b>{$Application["Title"]}</b>
			",
			$FromName="BioBuild",
			$FromEmail = "noreply@BioBuild.net",
			$ReplyToName="BioBuild",
			$ReplyToEmail="noreply@BioBuild.net",
			$ExtraHeaderParameters=""
		);
	}else{
	    $MainContent.=CTL_Window($Title="System Security",
			$Content="
			    Sorry, the specified email address was not found in the system!<br>
			    <br>
			    Click <a href=\"".ApplicationURL("System",$Script="login")."\">here</a> to procced...
			",
			$Width="",
			$Icon="security",
			$Template=""
		);
	}
?>
 
