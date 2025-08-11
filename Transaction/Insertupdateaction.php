<?




// Change by Mahmud

$bankID = $_POST["BankCashID"];
$BankInformation = SQL_Select("Bankcash", "BankCashID={$bankID}");
$CheckTransitionOrNot = SQL_Select("Transaction", "BankCashID={$bankID}");


if (empty($CheckTransitionOrNot)) {

    //Get initial blance
    $CurrentBalance = $BankInformation[0]["InitialBalance"];

} else {
    $CurrentBalance = $BankInformation[0]["CurrentBalance"];
}



// End

include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"])) $UpdateMode = true;

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
    if ($UpdateMode) $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'";
    // get last Transaction Total


    // Change by Mahmud
    if (empty($CheckTransitionOrNot)) {
        //Get initial blance
        $LastBalance["Balance"] = $BankInformation[0]["InitialBalance"];

    } else {
        $LastBalance = SQL_Select("Transaction", "BankCashID={$_POST["BankCashID"]} order by TransactionID DESC", "", true);
    }


    if ($_POST["Type"] == "Income") {

        $_POST["dr"] = "0";
        $_POST["cr"] = $_POST["Amount"];
        $Balance = $LastBalance["Balance"] + $_POST["Amount"];
        // Change by Mahmud

        $currentBlance = $_POST["Amount"] + $CurrentBalance;
        //Update bankcash tbl to current balance
        mysql_query("UPDATE tblbankcash SET CurrentBalance = {$currentBlance} WHERE BankCashID = {$bankID}");

    }

    if ($_POST["Type"] == "Expense") {
        $_POST["dr"] = $_POST["Amount"];
        $_POST["cr"] = "0";
        $Balance = $LastBalance["Balance"] - $_POST["Amount"];
        //  Change by Mahmud

        $currentBlance = $CurrentBalance - $_POST["Amount"];
        mysql_query("UPDATE tblbankcash SET CurrentBalance = {$currentBlance} WHERE BankCashID = {$bankID}");


    }
// give the data dase fields name and the post value name



//    echo "<pre>";
//    print_r($_POST);
//    die();

    
    $TheEntityName = SQL_InsertUpdate(
        $Entity = "{$Entity}",
        $TheEntityNameData = array(

            "ProjectID" => $_POST["ProjectID"],
            "ProjectName" => GetProjectName($_POST["ProjectID"]),

            "BankCashID" => $_POST["BankCashID"],
            "BankCashName" => GetBankCashTitle($_POST["BankCashID"]),

            "ChequeNumber" => $_POST["ChequeNumber"],

            "HeadOfAccountID" => $_POST["HeadOfAccountID"],
            "HeadOfAccountName" => GetExpenseHeadName($_POST["HeadOfAccountID"]),

            "BillNo" => $_POST["BillNo"],
            "Date" => $_POST["Date"],

            "Amount" => $_POST["Amount"],

            "Type" => $_POST["Type"],
            "Description" => $_POST["Description"],


            "dr" => $_POST["dr"],
            "cr" => $_POST["cr"],
            "Balance" => $Balance,
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