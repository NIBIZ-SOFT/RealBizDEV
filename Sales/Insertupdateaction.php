<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";


//echo "<pre>";
//print_r($_REQUEST);
//die();
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

        
        $_POST["Image"]	=ProcessUpload("Image", $Application["UploadPath"]);
		
		$GetWorkerName =SQL_Select("Worker","WorkerID=xxxx","",true);
		echo $GetWorkerName["name"];
		// give the data dase fields name and the post value name
	    $TheEntityName=SQL_InsertUpdate(
	        $Entity="{$Entity}",
			$TheEntityNameData=array(
                                                                                              
            "CustomerID"=>$_POST["CustomerID"],
            "CustomerName"=>GetCustomerName($_POST["CustomerID"]),

            "ProjectID"=>$_POST["ProjectID"],
            "ProjectName"=>GetProjectName($_POST["ProjectID"]),

            "ProductID"=>$_POST["ProductID"],
            "ProductName"=>$_POST["ProductName"],

            "SellerID"=>$_POST["SalerNameID"],
            "SellerName"=>GetSellerName($_POST["SalerNameID"]),

            "Image"=>$_POST["Image"],
            "Discount"=>$_POST["Discount"],
            "Quantity"=>$_POST["Quantity"],
            "Division"=>$_POST["Division"],
            
            "SalesDate"=>$_POST["SalesDate"],

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