<?php


if(isset($_POST['update_ref'])){
	
	$UserID=$_POST['UserID'];
	$ReferanceID=$_POST['ReferanceID'];
	$ReferanceName=$_POST['ReferanceName'];
	$PhoneNumber=$_POST['PhoneNumber'];
	$Email=$_POST['Email'];
	$ReferanceType=$_POST['ReferanceType'];
	$ReferanceFullDaitals=$_POST['ReferanceFullDaitals'];
	$C_ReferanceName=count($ReferanceName);
	
	
	
	
	   for($i=0;$i<$C_ReferanceName;$i++){
		   $P_ReferanceID=$ReferanceID[$i];
		   $P_ReferanceName=$ReferanceName[$i];
		   $P_PhoneNumber=$PhoneNumber[$i];
		   $p_Email=$Email[$i];
		   $p_ReferanceType=$ReferanceType[$i];
		   $p_ReferanceFullDaitals=$ReferanceFullDaitals[$i];
           
		   $ins=mysql_query("update tblreferance set ReferanceName='$P_ReferanceName',PhoneNumber='$p_PhoneNumber', Email='$p_Email', ReferanceType='$p_ReferanceType', ReferanceFullDaitals='$p_ReferanceFullDaitals' where ReferanceID='$P_ReferanceID'");
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
		   } 
		   
	     }
		 

}