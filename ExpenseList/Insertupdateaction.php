<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"]))$UpdateMode=true;

    $ErrorUserInput["_Error"]=false;

	if(!$UpdateMode)$_REQUEST["{$Entity}ID"]=0;
	//some change goes here

    if($ErrorUserInput["_Error"]){
        include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	}else{
	    $Where="";
	    if($UpdateMode)$Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'";

       // $_POST["Image"]	=ProcessUpload("Image", $Application["UploadPath"]);

if($UpdateMode){
	$PickRefNo=SQL_Select($Entity="ExpenseList", $Where,"","True");
	$_REQUEST["RefNo"]=$PickRefNo["ExpenseListRefNo"];
}

		// give the data dase fields name and the post value name
	    $TheEntityName=SQL_InsertUpdate(
	        $Entity="{$Entity}",
			$TheEntityNameData=array(

			    "ExpenseListName"=>$_REQUEST["Name"],
			    "ExpenseListDescription"=>$_REQUEST["Description"],
			    "ExpenseListDate"=>$_REQUEST["PaidDate"],
			    "ExpenseListPaidTo"=>$_REQUEST["PaidTo"],
			    "ExpenseListPaidAmount"=>$_REQUEST["PaidAmount"],
			    "ExpenseListTotalAmount"=>$_REQUEST["TotalAmount"],
			    "ExpenseListDueAmount"=>$_REQUEST["DueAmount"],
			    "ExpenseListFor"=>$_REQUEST["ExpenseFor"],
			    "ExpenseListBearer"=>$_REQUEST["Bearer"],
			    "ExpenseListRefNo"=>$_REQUEST["RefNo"],
			    "ExpenseListAccountType"=>$_REQUEST["AccountType"],
			    "ExpenseListDueAmountPaidDate"=>$_REQUEST["DueDate"]
			    
			),
			$Where
			);
			
			
		If($_REQUEST["PrintPreview"]==1)
			$MainContent.="
					<script language=\"JavaScript\">
					        window.open('".ApplicationURL("Page","Voucher&RefNo={$_REQUEST["RefNo"]}&NoHeader&NoFooter")."', 'NewCustomerFormOfficeCopy', 'toolbar=0, status=0, location=0, menubar=0, resizable=0, scrollbars=1,');
                    </script>
			";
			

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