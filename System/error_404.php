<?
	/*
		Script:		
		Author:		
		Date:		
		Purpose:	
		Note:		
	*/
	
	// if($_SESSION["UserID"]==2)
		// CTL_Create_File("./script/Page/{$_REQUEST["Script"]}.php",$_REQUEST["Script"]);
	// else
		$MainContent.="
		    <div align=\"center\">
			    <table style=\"padding: 20px; background-color: silver; color: black; font-size: 13px; border-style: solid; border-width: 1px; border-color: red;\">
			        <tr>
						<td style=\"padding: 5px; text-align: center;\">
							<b>Access is Denied.</b><br>
							<br>
							{$Application["Title"]}
						</td>
					</tr>
				</table>
			</div>
		";

	


/*
	//Email the webmaster that the requested page was not found!
	SendMail(
		$ToEmail=$Application["EmailSupport"],
		$Subject="Page missing!",
		$Body="
		    The '<b>./script/{$_REQUEST["Script"]}.php</b>' was missing while '<b>{$_SESSION["UserName"]}</b> ({$_SESSION["UserTypeName"]})' requested it.<br>
		    <br>
		    <a href=\"".ApplicationURL($Script="")."\">{$Application["Title"]}</a>
		",
		$FromName=$Application["Title"],
		$FromEmail = $Application["EmailContact"],
		$ReplyToName=$Application["Title"],
		$ReplyToEmail=$Application["EmailContact"],
		$ExtraHeaderParameters=""
	);
	*/
?> 