<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"]))$UpdateMode=true;

    $ErrorUserInput["_Error"]=false;

	if(!$UpdateMode)$_REQUEST["{$Entity}ID"]=0;
	//some change goes here
	$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$UniqueField} = '{$_POST["{$UniqueField}"]}' AND {$Entity}ID <> {$_REQUEST[$Entity."ID"]}");
	//'
	
	if(count($TheEntityName)>0){
	    $ErrorUserInput["_Error"]=true;
	    $ErrorUserInput["_Message"]="This Value Already Taken.";
	}

    if($ErrorUserInput["_Error"]){
        include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	}else{
	    $Where="";
	    if($UpdateMode)$Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'";

		//sa($_POST);
		//echo $_POST["OptionVendor"];
		//exit;
		// give the data dase fields name and the post value name
	    $TheEntityName=SQL_InsertUpdate(
	        $Entity="{$Entity}",
			$TheEntityNameData=array(
                                                                                              
				"UserName"=>$_POST["UserName"],
				"UserEmail"=>$_POST["UserEmail"],
				"UserPassword"=>$_POST["UserPassword"],
				"UserCategory"=>$_POST["UserCategory"],
				"PhoneHome"=>$_POST["PhoneHome"],
				
				"OptionCategory"=>$_POST["OptionCategory"],
				"OptionProduct"=>$_POST["OptionProduct"],
				"OptionVendor"=>$_POST["OptionVendor"],
				"OptionPurchase"=>$_POST["OptionPurchase"],
				"OptionCustomer"=>$_POST["OptionCustomer"],
				"OptionSales"=>$_POST["OptionSales"],
				"OptionReport"=>$_POST["OptionReport"],
				"OptionSettings"=>$_POST["OptionSettings"],
				"OptionUsers"=>$_POST["OptionUsers"],
				
				"UserIsRegistered"=>1,
				"UserIsApproved"=>1,

		        "{$Entity}IsActive"=>$_POST["{$Entity}IsActive"],
			),
			$Where
			);


	    $MainContent.="
	        ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","Manage")."\">here</a> to proceed.",300)."
	        <script language=\"JavaScript\" >
	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","Manage")."';
	        </script>
		";
	}
?>