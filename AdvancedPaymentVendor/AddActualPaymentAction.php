<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$Entity = "AdvancePaidVendor";
$UniqueField = "AdvancePaidVendorID";

$UpdateMode = false;

if (isset($_REQUEST[$Entity . "ID"]) ) $UpdateMode = true;
$ErrorUserInput["_Error"] = false;

if (!$UpdateMode) $_REQUEST["{$Entity}ID"] = 0;
//some change goes here
$TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$UniqueField} = '{$_POST["{$UniqueField}"]}' AND {$Entity}ID <> {$_REQUEST[$Entity."ID"]}");


if (count($TheEntityName) > 0) {
    $ErrorUserInput["_Error"] = true;
    $ErrorUserInput["_Message"] = "This Value Already Taken.";
}

if ($ErrorUserInput["_Error"]) {
    // include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
} else {
    $Where = "";

    if ($UpdateMode) $Where = "AdvancePaidVendorID = {$_REQUEST["AdvancePaidVendorID"]} ";

    if (empty($_POST["ChequeNumber"])) {
        $_POST["ChequeNumber"] = 0;
    }

    $LastDrVoucherDetails=SQL_Select("drvoucher ORDER BY DrVoucherID DESC LIMIT 1");
    
    if (count($LastDrVoucherDetails) > 0 ){
        $LastDrVoucherID=$LastDrVoucherDetails[0]["DrVoucherID"]+1;
    }else{
        $LastDrVoucherID=1;
    }

    $TheEntityName = SQL_InsertUpdate(
        $Entity = "AdvancePaidVendor",
        $TheEntityNameData = array(

            "CategoryID" => $CategoryID,
            "CategoryName" => $CategoryName,

            "BankCashID" => $_POST["BankCashID"],
            "BankCashName" => GetBankCashTitle($_POST["BankCashID"]),

            "VendorID" => $VendorID,
            "VendorName" => $VendorName,

            "ChequeNumber" => $_POST["ChequeNumber"],

            "HeadOfAccountID" => $_POST["HeadOfAccountID"],
            "HeadOfAccountName" => GetExpenseHeadName($_POST["HeadOfAccountID"]),

            "BillNo" => $_POST["BillNo"],
            "Date" => $_POST["Date"],

            "VoucherNo" => $LastDrVoucherID,

            "Description" => $_POST["Description"],

            "dr" => $_POST["Amount"],
            "cr" => 0,

            "AdvancePaidVendorIsDisplay" => $_POST["AdvancePaidVendorIsDisplay"],


        ),
        $Where
    );


    if ($_POST["{$Entity}IsDisplay"] == 0) {

        $Where = "";

        $TheEntityName = SQL_InsertUpdate(
            $Entity = "transaction",
            $TheEntityNameData = array(

                "ProjectID" => $CategoryID,
                "ProjectName" => $CategoryName,

                "BankCashID" => $_POST["BankCashID"],
                "BankCashName" => GetBankCashTitle($_POST["BankCashID"]),

                "ChequeNumber" => $_POST["ChequeNumber"],

                "HeadOfAccountID" => $_POST["HeadOfAccountID"],
                "HeadOfAccountName" => GetExpenseHeadName($_POST["HeadOfAccountID"]),

                "BillNo" => $_POST["BillNo"],
                "Date" => $_POST["Date"],

                "VoucherNo"=>$LastDrVoucherID,
                "VoucherType"=>"DV",

                "Description" => $_POST["Description"],
                "dr" => $_POST["Amount"],
                "cr" => 0,

                "{$Entity}IsActive" => $_POST["{$Entity}IsActive"],

                "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
            ),
            $Where
        );


    }


}


$MainContent .= "
	        " . CTL_Window($Title = "Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"" . ApplicationURL("{$_REQUEST["Base"]}", "Manage&VendorID={$_SESSION["VendorID"]}") . "\">here</a> to proceed.", 300) . "
	        <script language=\"JavaScript\" >
	            window.location='" . ApplicationURL("{$_REQUEST["Base"]}", "Manage&VendorID={$_SESSION["VendorID"]}") . "';
	        </script>
		";

?>