<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";


//echo "<pre>";
//print_r($_POST["items"]);
//die();


    $UpdateMode=false;
	if(!empty($_REQUEST[$Entity."ID"]))$UpdateMode=true;

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
	    if($UpdateMode)$Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]}";

		// give the data dase fields name and the post value name
	    $TheEntityName=SQL_InsertUpdate(
	        $Entity="purchaserequisition",
			$TheEntityNameData=array(
                                                                                              
		"CategoryID"=>$_POST["CategoryID"],
		"CategoryName"=>GetCategoryName($_POST["CategoryID"]),

		"EmployeeID"=>$_POST["EmployeeID"],
		"EmployeeName"=>GetEmployeeName($_POST["EmployeeID"]),

		"Date"=>$_POST["Date"],

        "RequiredDate"=>$_POST["RequiredDate"],
        "MPRNO"=>$_POST["MPRNO"],

		"TotalRequisitionAmount"=>$_POST["TotalRequisitionAmount"],

        "NB" => $_POST["NB"],


		"Remark"=>$_POST["Remark"],

		"Items"=>json_encode($_POST["items"]),

		        "PurchaseRequisitionIsActive"=>1,
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