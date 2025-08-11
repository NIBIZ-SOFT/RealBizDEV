<?
	/*
		Script:		
		Author:		SunJove@gmail.com
		Date:		
		Purpose:	
		Note:		
	*/
	
	SessionUnsetUser();

	$MainContent.="
	    ".CTL_Window(
			$Title="System Security",
			$Content="
				Dear user,<br>
				<br>
				You have successfully logged off the system, click <a href=\"".ApplicationURL("Page","Home")."\">here</a> to proceed.<br>
				<br>
				{$Application["Title"]}
			"
		)."
		<script language=\"JavaScript\">
		<!--
		    window.location.href='".ApplicationURL("System","login")."';
		-->
		</script>
	";
?> 
