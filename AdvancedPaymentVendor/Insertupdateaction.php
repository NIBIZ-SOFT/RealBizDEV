<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";


$UpdateMode = false;
if (isset($_REQUEST[$Entity . "ID"])) $UpdateMode = true;

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

    $advancedpaymentvendor = SQL_Select("advancedpaymentvendor");

    if ($UpdateMode == false) {

        if (!empty($advancedpaymentvendor)) {

            $Number = (count($advancedpaymentvendor) / 2 + 1);
            $voucherNo = "V-" . str_pad($Number, "4", "0", STR_PAD_LEFT);

        } else {
            $voucherNo = "V-" . str_pad(1, "4", "0", STR_PAD_LEFT);
        }

    } else {
        $voucherDetails = SQL_Select("advancedpaymentvendor where VoucherNo='{$_REQUEST["VoucherNo"]}'");
        $voucherNo = $_POST["VoucherNo"];

    }

    if ($UpdateMode) $Where = "{$Entity}ID = {$voucherDetails[0][$Entity."ID"]} AND {$Entity}UUID = '{$voucherDetails[0][$Entity."UUID"]}'";


    // Form Head
    $TheEntityName = SQL_InsertUpdate(
        $Entity = "{$Entity}",
        $TheEntityNameData = array(

            "CategoryID" => $CategoryID,
            "CategoryName" => GetCategoryName($CategoryID),

            "VendorID" => $VendorID,
            "VendorName" => GetVendorName($VendorID),


            "HeadOfAccountID" => $_POST["FormHeadOfAccountID"],
            "HeadOfAccountName" => GetExpenseHeadName($_POST["FormHeadOfAccountID"]),

            "PayDate" => $_POST["PayDate"],
            "VoucherNo" => $voucherNo,

            "Description" => $_POST["Description"],
            "dr" => $_POST["Amount"],
            "cr" => 0,

            "{$Entity}IsActive" => $_POST["{$Entity}IsActive"],

            "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
        ),
        $Where
    );

    if ($UpdateMode) $Where = "{$Entity}ID = {$voucherDetails[1][$Entity."ID"]} AND {$Entity}UUID = '{$voucherDetails[1][$Entity."UUID"]}'";


    // To Head
    $TheEntityName = SQL_InsertUpdate(
        $Entity = "{$Entity}",
        $TheEntityNameData = array(

            "CategoryID" => $CategoryID,
            "CategoryName" => GetCategoryName($CategoryID),

            "VendorID" => $VendorID,
            "VendorName" => GetVendorName($VendorID),


            "HeadOfAccountID" => $_POST["ToHeadOfAccountID"],
            "HeadOfAccountName" => GetExpenseHeadName($_POST["ToHeadOfAccountID"]),

            "PayDate" => $_POST["PayDate"],

            "VoucherNo" => $voucherNo,

            "Description" => $_POST["Description"],
            "dr" => "0",
            "cr" => $_POST["Amount"],

            "{$Entity}IsActive" => $_POST["{$Entity}IsActive"],

            "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"]
        ),
        $Where
    );

//    Transition

    if ($_POST["{$Entity}IsDisplay"] == 0) {

        $Where = "";

        // Form Head
        $TheEntityName = SQL_InsertUpdate(
            $Entity = "transaction",
            $TheEntityNameData = array(

                "ProjectID" => $CategoryID,
                "ProjectName" => GetCategoryName($CategoryID),

                "VendorID" => $VendorID,
                "VendorName" => GetVendorName($VendorID),


                "HeadOfAccountID" => $_POST["FormHeadOfAccountID"],
                "HeadOfAccountName" => GetExpenseHeadName($_POST["FormHeadOfAccountID"]),

                "Date" => $_POST["PayDate"],
                "VoucherNo" => $voucherNo,
                "VoucherType" => "JV",

                "Description" => $_POST["Description"],
                "dr" => $_POST["Amount"],
                "cr" => 0,

                "{$Entity}IsActive" => $_POST["{$Entity}IsActive"],

                "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
            ),
            $Where
        );


        // To Head
        $TheEntityName = SQL_InsertUpdate(
            $Entity = "transaction",
            $TheEntityNameData = array(

                "ProjectID" => $CategoryID,
                "ProjectName" => GetCategoryName($CategoryID),

                "VendorID" => $VendorID,
                "VendorName" => GetVendorName($VendorID),


                "HeadOfAccountID" => $_POST["ToHeadOfAccountID"],
                "HeadOfAccountName" => GetExpenseHeadName($_POST["ToHeadOfAccountID"]),

                "Date" => $_POST["PayDate"],

                "VoucherNo" => $voucherNo,
                "VoucherType" => "JV",

                "Description" => $_POST["Description"],
                "dr" => "0",
                "cr" => $_POST["Amount"],

                "{$Entity}IsActive" => $_POST["{$Entity}IsActive"],

                "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"]
            ),
            $Where
        );

    }


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