<?php


if(isset($_POST['update_Qulifications'])){
	
	$UserID=$_POST['UserID'];
	$QulificationsID=$_POST['QulificationsID'];
	$CourseName=$_POST['CourseNameU'];
	$CourseDuration=$_POST['CourseDurationU'];
	$PassingYear=$_POST['PassingYearU'];
	$Board_University=$_POST['Board_UniversityU'];
	$Result=$_POST['ResultU'];
	$C_ourseName=count($CourseName);
	
	
	
	
	   for($i=0;$i<$C_ourseName;$i++){
		   $P_QulificationsID=$QulificationsID[$i];
		   $P_CourseName=$CourseName[$i];
		   $p_CourseDuration=$CourseDuration[$i];
		   $p_PassingYear=$PassingYear[$i];
		   $p_Board_University=$Board_University[$i];
		   $p_Result=$Result[$i];
           //$GUID = GUID();		   
           //$ins=mysql_query("insert into tblqulifications(QulificationsUUID,UserID,CourseName,CourseDuration,PassingYear,Board_University,Result)
		  // values('$GUID','$UserID','$P_CourseName','$p_CourseDuration','$p_PassingYear','$p_Board_University','$p_Result')");		
	
	       mysql_query("update tblqulifications set CourseName='$P_CourseName', CourseDuration='$p_CourseDuration', PassingYear='$p_PassingYear', Board_University='$p_Board_University', Result='$p_Result' where QulificationsID='$P_QulificationsID'");
	
          // if($ins){
			/*$MainContent.="
	        ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","home&ql=1")."\">here</a> to proceed.",300)."
	        <script language=\"JavaScript\" >
	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","home&ql=1")."';
	        </script>
		    ";
		   }*/
	
	     }
		 
		


	$CourseNameR=$_POST['CourseName'];
	$CourseDurationR=$_POST['CourseDuration'];
	$PassingYearR=$_POST['PassingYear'];
	$Board_UniversityR=$_POST['Board_University'];
	$ResultR=$_POST['Result'];
	$C_ourseNameR=count($CourseNameR);
	
	
	
	
	   for($i=0;$i<$C_ourseNameR;$i++){
		   $R_CourseName=$CourseNameR[$i];
		   $R_CourseDuration=$CourseDurationR[$i];
		   $R_PassingYear=$PassingYearR[$i];
		   $R_Board_University=$Board_UniversityR[$i];
		   $R_Result=$ResultR[$i];
           $GUID = GUID();

		   if($R_CourseName){
              $ins=mysql_query("insert into tblqulifications(QulificationsUUID,UserID,CourseName,CourseDuration,PassingYear,Board_University,Result)
		      values('$GUID','$UserID','$R_CourseName','$R_CourseDuration','$R_PassingYear','$R_Board_University','$R_Result')");
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

		   
		   }else{
			 //echo "Yes";
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
		 

}