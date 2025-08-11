<?php
if(isset($_POST['save_training'])){
	
	$UserID=$_POST['UserID'];
	$CourseName=$_POST['CourseName'];
	$InstituteName=$_POST['InstituteName'];
	$CourseDuration=$_POST['CourseDuration'];
	$CourseRemarks=$_POST['CourseRemarks'];
	$C_ourseName=count($CourseName);
	for($i=0;$i<$C_ourseName;$i++){
		   $P_CourseName=$CourseName[$i];
		   $p_InstituteName=$InstituteName[$i];
		   $p_CourseDuration=$CourseDuration[$i];
		   $p_CourseRemarks=$CourseRemarks[$i];
           $GUID = GUID();		   
           $ins=mysql_query("insert into tbltraining(TrainingUUID,UserID,CourseName,InstituteName,CourseDuration,CourseRemarks)
		   values('$GUID','$UserID','$P_CourseName','$p_InstituteName','$p_CourseDuration','$p_CourseRemarks')");		
	
           if($ins){
			$MainContent.="
	        ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","home&uc=4&ql=4")."\">here</a> to proceed.",300)."
	        <script language=\"JavaScript\" >
	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","home&uc=4&ql=4")."';
	        </script>
		    ";
		   } 
	
	
	}
	
}







if(isset($_POST['Update_training'])){
	
	$TrainingID=$_POST['TrainingID'];
	$UserID=$_POST['UserID'];
	$CourseName=$_POST['CourseName'];
	$InstituteName=$_POST['InstituteName'];
	$CourseDuration=$_POST['CourseDuration'];
	$CourseRemarks=$_POST['CourseRemarks'];
	$C_ourseName=count($CourseName);
	for($i=0;$i<$C_ourseName;$i++){
		   $P_TrainingID=$TrainingID[$i];
		   $P_CourseName=$CourseName[$i];
		   $p_InstituteName=$InstituteName[$i];
		   $p_CourseDuration=$CourseDuration[$i];
		   $p_CourseRemarks=$CourseRemarks[$i];
           //$ins=mysql_query("insert into tbltraining(TrainingUUID,UserID,CourseName,InstituteName,CourseDuration,CourseRemarks)
		   //values('$GUID','$UserID','$P_CourseName','$p_InstituteName','$p_CourseDuration','$p_CourseRemarks')");		
	
	       $ins=mysql_query("update tbltraining set CourseName='$P_CourseName',InstituteName='$p_InstituteName',CourseDuration='$p_CourseDuration',CourseRemarks='$p_CourseRemarks' where TrainingID='$P_TrainingID'");
	 
           if($ins){
			$MainContent.="
	        ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","home&uc=4&ql=4")."\">here</a> to proceed.",300)."
	        <script language=\"JavaScript\" >
	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","home&uc=4&ql=4")."';
	        </script>
		    ";
		   } 
	
	
	}
	
}


