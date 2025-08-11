<?php
if(isset($_POST['save_Qulifications'])){
	
	$UserID=$_POST['UserID'];
	$CourseName=$_POST['CourseName'];
	$CourseDuration=$_POST['CourseDuration'];
	$PassingYear=$_POST['PassingYear'];
	$Board_University=$_POST['Board_University'];
	$Result=$_POST['Result'];
	$C_ourseName=count($CourseName);
	for($i=0;$i<$C_ourseName;$i++){
		   $P_CourseName=$CourseName[$i];
		   $p_CourseDuration=$CourseDuration[$i];
		   $p_PassingYear=$PassingYear[$i];
		   $p_Board_University=$Board_University[$i];
		   $p_Result=$Result[$i];
           $GUID = GUID();		   
           $ins=mysql_query("insert into tblqulifications(QulificationsUUID,UserID,CourseName,CourseDuration,PassingYear,Board_University,Result)
		   values('$GUID','$UserID','$P_CourseName','$p_CourseDuration','$p_PassingYear','$p_Board_University','$p_Result')");		
	
           if($ins){
			$MainContent.="
	        ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","home&ql=1")."\">here</a> to proceed.",300)."
	        <script language=\"JavaScript\" >
	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","home&ql=1")."';
	        </script>
		    ";
		   }
	
	
	}
	
	mysql_query("update tbluser set QulificationsOn=1 where UserID=$UserID");
	
}