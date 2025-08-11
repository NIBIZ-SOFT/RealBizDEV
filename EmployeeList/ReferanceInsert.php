<?php
if(isset($_POST['save_ref'])){
	
	$UserID=$_POST['UserID'];
	$ReferanceName=$_POST['ReferanceName'];
	$PhoneNumber=$_POST['PhoneNumber'];
	$Email=$_POST['Email'];
	$ReferanceType=$_POST['ReferanceType'];
	$ReferanceFullDaitals=$_POST['ReferanceFullDaitals'];
	$C_ourseName=count($ReferanceName);
	for($i=0;$i<$C_ourseName;$i++){
		   $P_ReferanceName=$ReferanceName[$i];
		   $p_PhoneNumber=$PhoneNumber[$i];
		   $p_Email=$Email[$i];
		   $p_ReferanceType=$ReferanceType[$i];
		   $p_ReferanceFullDaitals=$ReferanceFullDaitals[$i];
           $GUID = GUID();		   
           $ins=mysql_query("insert into tblreferance(ReferanceUUID,UserID,ReferanceName,PhoneNumber,Email,ReferanceType,ReferanceFullDaitals)
		   values('$GUID','$UserID','$P_ReferanceName','$p_PhoneNumber','$p_Email','$p_ReferanceType','$p_ReferanceFullDaitals')");		
           
		   //$ins=mysql_query("insert into tblreferance(ReferanceType,ReferanceFullDaitals)
		   //values('$p_Result')");		
	
	
	
           if($ins){
			$MainContent.="
	        ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","home&ql=2")."\">here</a> to proceed.",300)."
	        <script language=\"JavaScript\" >
	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","home&ql=2")."';
	        </script>
		    ";
		   }else{
			echo "No";   
		   }
	
	
	}
		
}