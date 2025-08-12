<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";


//echo "<pre>";
//print_r($_POST);
//die();
	
	
	
    $UpdateMode=false;
	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"]))$UpdateMode=true;

    $ErrorUserInput["_Error"]=false;

	if(!$UpdateMode)$_REQUEST["{$Entity}ID"]=0;
	//some change goes here
	$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$UniqueField} = '{$_POST["{$UniqueField}"]}' AND {$Entity}ID <> {$_REQUEST[$Entity."ID"]}");
    //'
	if(count($TheEntityName)>0){
	    $ErrorUserInput["_Error"]=true;
	    $ErrorUserInput["_Message"]="Product Name Already Taken.";
	}

    if($ErrorUserInput["_Error"]){
        $MainContent.='
	        <div style="border:1px solid red; width:500px; padding:5px; background-color: red;color:white;margin: auto;text-align:center;">
	            Product Name Already Exist
	        </div>
	    
	    ';
        include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	}else{
	
	    $Where="";
	    if($UpdateMode)$Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'";


        if($UpdateMode){
            $ProductTypeValue = $TheEntityName["ProductType"];
        }else
            $ProductTypeValue =  $_SESSION["ProductType"];
        
        $_POST["ProductsImage"]	=ProcessUpload("ProductsImage", $Application["UploadPath"]);
			

		// give the data dase fields name and the post value name

            $val_a= $_POST["Units"]*$_POST["PurchaseLatestPrice"];
            $total_sellingprice= $val_a + $_POST["CarParking"]+$_POST["UtilityCharge"]; 



	    $TheEntityName=SQL_InsertUpdate(
	         $Entity="{$Entity}",

                        

			$TheEntityNameData=array(


				"CategoryID"=>$_POST["CategoryID"],
				"CategoryName"=>GetCategoryName($_POST["CategoryID"]),
				"FlatType"=>$_POST["FlatType"],
				"FloorNumber"=>$_POST["FloorNumber"],
				"FlatSize"=>$_POST["FlatSize"],
				"UnitPrice"=>$_POST["UnitPrice"],
				"FlatPrice"=>$_POST["FlatPrice"],
				"CarParkingCharge"=>$_POST["CarParkingCharge"],
				"UtilityCharge"=>$_POST["UtilityCharge"],
				"AdditionalWorkCharge"=>$_POST["AdditionalWorkCharge"],
				"OtherCharge"=>$_POST["OtherCharge"],
				"DeductionCharge"=>$_POST["DeductionCharge"],
				"RefundAdditionalWorkCharge"=>$_POST["RefundAdditionalWorkCharge"],
				"NetSalesPrice"=>$_POST["NetSalesPrice"],
				"Description"=>$_POST["Description"],
				"ProductsImage"=>$_POST["ProductsImage"],
				"BuildArea"=>$_POST["BuildArea"],
				"LandArea"=>$_POST["LandArea"],

				"ProductType"=>$ProductTypeValue,

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