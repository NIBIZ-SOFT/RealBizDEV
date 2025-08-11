<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
if ($_REQUEST["AdvancePaidContructorID"] > 0) {
    $UpdateMode = true;
}

//some change goes here
$Where = "";
if ($UpdateMode) $Where = "AdvancePaidContructorID = {$_REQUEST["AdvancePaidContructorID"]}";


if (empty($_POST["ChequeNumber"])) {
    $_POST["ChequeNumber"] = 0;
}

$lastTransactions=SQL_Select("transaction ORDER BY TransactionID DESC LIMIT 1");
$lastTransactionID=$lastTransactions[0]["TransactionID"]+1;

//echo "<pre>";
//print_r($_POST);
//die();

// give the data dase fields name and the post value name
$TheEntityName = SQL_InsertUpdate(
    $Entity = "advancepaidcontructor",
    $TheEntityNameData = array(

        "CategoryID" => $CategoryID,
        "CategoryName" => $CategoryName,

        "ContructorID" => $ContructorID,
        "ContructorName" => $ContructorName,

        "HeadOfAccountID" => $_POST["HeadOfAccountID"],
        "HeadOfAccountName" => GetExpenseHeadName($_POST["HeadOfAccountID"]),


        "BankCashID" => $_POST["BankCashID"],
        "BankCashName" => GetBankCashTitle($_POST["BankCashID"]),

        "ChequeNumber" => $_POST["ChequeNumber"],

        "VoucherNo"=>$lastTransactionID,

        "MRBillNO" => $_POST["BillNo"],
        "Amount" => $_POST["Amount"],
        "BillDate" => $_POST["Date"],
        "Description" => $_POST["Description"],
        "dr" => $_POST["Amount"],
        "cr" => 0,

        "AdvancePaidContructorIsDisplay"=>$_POST["AdvancePaidContructorIsDisplay"],

    ),
    $Where
);


if ($_POST["AdvancePaidContructorIsDisplay"] == 0) {

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

            "VoucherNo"=>$lastTransactionID,

            "Description" => $_POST["Description"],
            "dr" => $_POST["Amount"],
            "cr" => 0,

            "{$Entity}IsActive" => $_POST["{$Entity}IsActive"],

            "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
        ),
        $Where
    );


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