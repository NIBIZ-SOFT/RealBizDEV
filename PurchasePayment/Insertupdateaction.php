<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";


$UpdateMode = false;
if (!empty($_REQUEST[$Entity . "ID"])) $UpdateMode = true;

if ($UpdateMode ==false){
    $ThisItems = SQL_Select("purchase");
    $padNo=count($ThisItems )+1;
    $RequisitionOfIdNumber = str_pad($padNo, 5, "0", STR_PAD_LEFT);
    $PurchaseConfirmID = "POD" . date("Y")[2] . date("Y")[3] . "-" . $RequisitionOfIdNumber;


}


$ErrorUserInput["_Error"] = false;

if (!$UpdateMode) $_REQUEST["{$Entity}ID"] = 0;


//some change goes here
$TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$UniqueField} = '{$_POST["{$UniqueField}"]}' AND {$Entity}ID <> {$_REQUEST[$Entity."ID"]}");


if (count($TheEntityName) > 0) {
    $ErrorUserInput["_Error"] = true;
    $ErrorUserInput["_Message"] = "This Value Already Taken.";
}

if ($ErrorUserInput["_Error"]) {
    include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
} else {
    $Where = "";
    if ($UpdateMode) $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]}";



    // give the data dase fields name and the post value name
    $TheEntityName = SQL_InsertUpdate(
        $Entity = "purchase",
        $TheEntityNameData = array(
            "CategoryID" => $_POST["CategoryID"],
            "CategoryName" => GetCategoryName($_POST["CategoryID"]),
            "VendorID" => $_POST["VendorID"],
            "VendorName" => GetVendorName($_POST["VendorID"]),
            "confirmRequisitonId" => $_POST["confirmRequisitonId"],
            "PurchaseConfirmID"=>$PurchaseConfirmID,
            "confirmRequisitonName" => GetPurchaseRequisitionConfirmID($_POST["confirmRequisitonId"]),
            "MediaName" => $_POST["MediaName"],


            "letterTitle" => $_POST["letterTitle"],
            "ContactPerson1" => $_POST["ContactPerson1"],
            "ContactPerson2" => $_POST["ContactPerson2"],
            "TaxesVat" => $_POST["TaxesVat"],
            "Note" => $_POST["Note"],


            "IssuingDate" => $_POST["IssuingDate"],
            "Subject" => $_POST["Subject"],
            "MessageBody" => $_POST["MessageBody"],
            "DateOfDelevery" => $_POST["DateOfDelevery"],
            "PurchaseAmount" => round($_POST["PurchaseAmount"],2),
            "Confirm" => $_POST["Confirm"],
            "Items" => json_encode($_POST["items"]),
            "PurchaseIsActive" => 1,
        ),
        $Where
    );

    $MainContent .= "
	        " . CTL_Window($Title = "Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"" . ApplicationURL("{$_REQUEST["Base"]}", "Manage") . "\">here</a> to proceed.", 300) . "
	        <script language=\"JavaScript\" >
	            window.location='" . ApplicationURL("{$_REQUEST["Base"]}", "Manage") . "';
	        </script>
		";
}
?>