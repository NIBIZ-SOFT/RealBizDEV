<?php

// give the data dase fields name and the post value name
$Where="UserID = {$_REQUEST['UserID']}";
$TheEntityName=SQL_InsertUpdate(
$Entity="User",
$TheEntityNameData=array(
                                                                                              
"BranchName"=>$_POST["BranchName"],
"Department"=>$_POST["Department"],
"Designation"=>$_POST["Designation"],
"JobStatus"=>$_POST["JobStatus"],
"BasicSalary"=>$_POST["BasicSalary"],
"HouseRent"=>$_POST["HouseRent"],
"TravellingAllow"=>$_POST["TravellingAllow"],
"MedicalAllow"=>$_POST["MedicalAllow"],
"Food"=>$_POST["Food"],
"Mobile"=>$_POST["Mobile"],
"Donation"=>$_POST["Donation"],
"PFund"=>$_POST["PFund"],
"Tax"=>$_POST["Tax"],

),
$Where
);

$MainContent.="
	".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
	 <br>
	 The $EntityCaptionLower information has been stored.<br>
	 <br>
	 Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","home&rr=1")."\">here</a> to proceed.",300)."
	 <script language=\"JavaScript\" >
	       window.location='".ApplicationURL("{$_REQUEST["Base"]}","home&rr=1")."';
	 </script>
     ";