<?
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
    $contravoucher = SQL_Select("contravoucher");
    if ($UpdateMode == false) {

        if (!empty($contravoucher)) {
            $voucherNo = (count($contravoucher) / 2 + 1);
        } else {
            $voucherNo = 1;
        }

    }else{
        $contravoucherDetails=SQL_Select("contravoucher where VoucherNo={$_REQUEST["VoucherNo"]}");
        $voucherNo=$_POST["VoucherNo"];

    }


    if ($UpdateMode) $Where = "{$Entity}ID = {$contravoucherDetails[0][$Entity."ID"]} AND {$Entity}UUID = '{$contravoucherDetails[0][$Entity."UUID"]}'";

//    echo "<pre>";
//    print_r($_POST["Amount"]);
//    die();

    // Form
    $TheEntityName = SQL_InsertUpdate(
        $Entity = "{$Entity}",
        $TheEntityNameData = array(

            "ProjectID" => $_POST["ProjectID"],
            "ProjectName" => GetCategoryName($_POST["ProjectID"]),

            "BankCashID" => $_POST["formAccaunt"],
            "BankCashName" => GetBankCashTitle($_POST["formAccaunt"]),

            "ChequeNumber" => $_POST["ChequeNumber"],
            "Description" => $_POST["Description"],

            "VoucherNo" => $voucherNo,

            "Date" => $_POST["Date"],

            "dr" => $_POST["Amount"],
            "cr" => 0,

            "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
        ),
        $Where
    );

    if ($UpdateMode) $Where = "{$Entity}ID = {$contravoucherDetails[1][$Entity."ID"]} AND {$Entity}UUID = '{$contravoucherDetails[1][$Entity."UUID"]}'";


    // To
    $TheEntityName = SQL_InsertUpdate(
        $Entity = "{$Entity}",
        $TheEntityNameData = array(

            "ProjectID" => $_POST["ProjectID"],
            "ProjectName" => GetCategoryName($_POST["ProjectID"]),

            "BankCashID" => $_POST["toAccaunt"],
            "BankCashName" => GetBankCashTitle($_POST["toAccaunt"]),

            "ChequeNumber" => $_POST["ChequeNumber"],
            "Description" => $_POST["Description"],

            "VoucherNo" => $voucherNo,

            "Date" => $_POST["Date"],

            "dr" => 0,
            "cr" => $_POST["Amount"],

            "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
        ),
        $Where
    );


//    Transaction area

    if ($_POST["{$Entity}IsDisplay"] == 0) {

//	    Form accaunt
        $Where = "";

        SQL_InsertUpdate(
            $Entity = "Transaction",
            $TheEntityNameData = array(

                "ProjectID" => $_POST["ProjectID"],
                "ProjectName" => GetCategoryName($_POST["ProjectID"]),

                "BankCashID" => $_POST["formAccaunt"],
                "BankCashName" => GetBankCashTitle($_POST["formAccaunt"]),

                "HeadOfAccountName" => GetBankCashTitle($_POST["formAccaunt"]),


                "VoucherNo"=> $voucherNo,
                "VoucherType"=>"Contra",

                "Description" => $_POST["Description"],

                "Date" => $_POST["Date"],
                "dr" => $_POST["Amount"],
                "cr" => "0",

            ),
            $Where
        );


// Data to transfer transation accaunt

        SQL_InsertUpdate(
            $Entity = "Transaction",
            $TheEntityNameData = array(

                "ProjectID" => $_POST["ProjectID"],
                "ProjectName" => GetCategoryName($_POST["ProjectID"]),

                "BankCashID" => $_POST["toAccaunt"],
                "BankCashName" => GetBankCashTitle($_POST["toAccaunt"]),

                "HeadOfAccountName" => GetBankCashTitle($_POST["toAccaunt"]),

                "VoucherNo"=> $voucherNo,
                "VoucherType"=>"Contra",

                "Description" => $_POST["Description"],

                "Date" => $_POST["Date"],

                "dr" => "0",
                "cr" => $_POST["Amount"],

            ),
            $Where
        );

    }

    if ($_POST["{$Entity}IsDisplay"] == 1) {
        SQL_Delete("transaction where VoucherNo = {$voucherNo} and VoucherType = 'Contra'");
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