<?
	if(isset($_POST["UserChoice"])){
	    $User=SQL_Select($Entity="User", $Where="U.UserEmail = {$_POST["Email"]}");
	    if(count($User)>0){
	    	$User=SQL_Select($Entity="User", $Where="U.UserEmail = {$_POST["Email"]}", "", true);
	    	$NewPassword=RandomPassword();
	    	MySQLQuery("UPDATE tbluser SET UserPassword = $NewPassword WHERE U.UserEmail = {$_POST["Email"]} AND U.UserName = {$User["UserName"]}")
			SendMail(
                $ToEmail=$User["UserEmail"],
                $Subject="Log in information",
                $Body="
					Upon your request, we have reset your login password on our system.<br>
					<br>
					If you didn't request this information, please log into your account immediately and change your password to prevent unauthorized use of your information.<br>
					<br>
					<b>USERNAME:</b> ".$User["UserName"]."<br>
					<b>PASSWORD:</b> ".$NewPassword."<br>
					Please click <a href=\"".ApplicationURL($Script="login")."\">here</a> to log into your account.<br>
					<br>
					THANK YOU!<br>
					<br>
    				<b>".$Application["Title"]."</b>
                "
            );

		    print CTL_Window(
				$Title="Password sent",
				$Content="
					The password has been reset and the new password is sent to the email address you specified. Please check your email and log into our member area. Remember you can change the password to something you can remember in our member profile area.<br>
					<br>
					Please click <a href=\"".ApplicationURL($Script="login")."\">here</a> to log into the system.<br>
					<br>
					THANK YOU!<br>
					<br>
					<b>".$Application["Title"]."</b><br>
					<br>
				",
				0,
				"info",
				$Template=""
			);
		}else{
		    print CTL_Window(
				$Title="User not found!",
				$Content="
					Sorry.  We could not find any MEMBER account associated with that email address. Please verify that you have provided us with the correct email address and try again.<br>
					<br>
					Please click <a href=\"".ApplicationURL($Script="loginretrieve")."\">here</a> to try again to retrieve your password.<br>
					<br>
					THANK YOU.<br>
					<br>
					<b>".$Application["Title"]."</b>
				",
				0,
				"security",
			);
		}
	}else{
		print "
			<form name=\"frmPasswordRetrieve\" action=\"".ApplicationURL($Script="loginretrieve")."\" method=\"post\" onsubmit=\"ValidateInput()\">
				<b>Forgot Password?</b><br>
				<br>
				Forgot your password?  No problem.  Provide us with the email address that you entered during registration or have since altered in your member profile area.  We will send you a new password to the active email account.<br>
				<br>
				".CTL_InputText("UserEmail", "", "", 30)."
				".CTL_InputSubmit("UserChoice", "Retrieve")."<br>
				<br>
				THANK YOU!<br>
				<br>
				<b>".$Application["Title"]."</b>
			</form>


			<script language=\"JavaScript\">
			<!--
				function ValidateInput(){
					var InputOkay=true;
					if(frmPasswordRetrieve.Email.value=='')InputOkay=false;
					return InputOkay;
				}
			-->
			</script>
		";
	}
?>
 
