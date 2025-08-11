<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";


    $UpdateMode=false;
	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"]))$UpdateMode=true;

    $ErrorUserInput["_Error"]=false;

	if(!$UpdateMode)$_REQUEST["{$Entity}ID"]=0;
	//some change goes here
	$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$UniqueField} = '{$_POST["{$UniqueField}"]}' AND {$Entity}ID <> {$_REQUEST[$Entity."ID"]}");
    if(count($TheEntityName)>0){
	    $ErrorUserInput["_Error"]=true;
	    $ErrorUserInput["_Message"]="This Value Already Taken.";
	}

    if($ErrorUserInput["_Error"]){
        include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	}else{
	    $Where="";
	    if($UpdateMode)$Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'";

        

		// give the data dase fields name and the post value name
	    $TheEntityName=SQL_InsertUpdate(
	        $Entity="{$Entity}",
			$TheEntityNameData=array(


		"ProjectID"=>$_POST["ProjectID"],
		"ProjectName"=> GetProjectName($_POST["ProjectID"]),

		"HeadOfAccountID"=>$_POST["HeadOfAccountID"],
		"HeadOfAccountName"=>GetExpenseHeadName($_POST["HeadOfAccountID"]),

		"VendorID"=>$_POST["VendorID"],
		"VendorName"=>GetVendorName($_POST["VendorID"]),

		"RequisitionID"=>$_POST["RequisitionID"],
		"RequisitionName"=>GetRequisition($_POST["RequisitionID"]),

		"PurchaseID"=>$_POST["PurchaseID"],
		"PurchasName"=>$_POST["PurchaseID"],


		"Qty"=>$_POST["Qty"],
		"Rate"=>$_POST["Rate"],

		"Value"=>$_POST["Value"],

		"Date"=>$_POST["Date"],


		
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