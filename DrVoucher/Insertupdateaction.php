<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"])) $UpdateMode = true;

$ErrorUserInput["_Error"] = false;

if (!$UpdateMode) $_REQUEST["{$Entity}ID"] = 0;
//some change goes here
$TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$UniqueField} = '{$_POST["{$UniqueField}"]}' AND {$Entity}ID <> {$_REQUEST[$Entity . "ID"]}");
if (count($TheEntityName) > 0) {
    $ErrorUserInput["_Error"] = true;
    $ErrorUserInput["_Message"] = "This Value Already Taken.";
}

if ($ErrorUserInput["_Error"]) {
    include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
} else {

    if (!empty($_POST["VoucherNo"])) {
        $voucherNo = $_POST["VoucherNo"];
        SQL_Delete("drVoucher where VoucherNo = '{$voucherNo}'");
    } else {
        $voucherNo = null;
    }

    // --- DELETE transaction ONCE before loop ---
    if ($_POST["{$Entity}IsDisplay"] == 0 ||  $_POST["{$Entity}IsDisplay"] == 1 && !empty($voucherNo)) {
        SQL_Delete("transaction where VoucherNo = '{$voucherNo}' and VoucherType ='DV' ");
    }

    // --- Now start the foreach loop ---
    foreach ($_POST['HeadOfAccountID'] as $index => $headID) {
        $amount = $_POST['Amount'][$index];

        $Where = "";
        if ($UpdateMode) {
            $Where = "{$Entity}ID = {$_REQUEST[$Entity . "ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity . "UUID"]}'";
        }

        if ($_POST["Type"] == 0 || $_POST["Type"] == 3 || $_POST["Type"] == 4) {
            $_POST["VendorID"] = 0;
            $_POST["ContructorID"] = 0;
            $_POST["BillPhase"] = 0;
            $_POST["BillDate"] = 0;
        } elseif ($_POST["Type"] == 1) {
            $_POST["VendorID"] = 0;
        } else {
            $_POST["ContructorID"] = 0;
        }

        $_POST["Image"] = ProcessUpload("Image", $Application["UploadPath"]);

        // Insert or Update main DrVoucher
        $TheEntityName = SQL_InsertUpdate(
            $Entity,
            array(
                "ProjectID" => $_POST["ProjectID"],
                "CustomerID" => $_POST["CustomerID"],
                "ProjectName" => GetCategoryName($_POST["ProjectID"]),

                "HeadOfAccountID" => $headID,
                "HeadOfAccountName" => GetExpenseHeadName($headID),

                "Type" => $_POST["Type"],
                "VendorID" => $_POST["VendorID"],
                "VendorName" => GetVendorName($_POST["VendorID"]),
                "ContructorID" => $_POST["ContructorID"],
                "ContructorName" => GetContructorName($_POST["ContructorID"]),

                "BankCashID" => $_POST["BankCashID"],
                "BankCashName" => GetBankCashTitle($_POST["BankCashID"]),

                "Date" => $_POST["Date"],

                "ChequeNumber" => $_POST["ChequeNumber"],
                "Division" => $_POST["Division"],

                "BillPhase" => $_POST["BillPhase"],
                "BillDate" => $_POST["BillDate"],
                "BillNo" => $_POST["BillNo"],

                "Description" => $_POST["Description"],
                "Amount" => $amount,
                "Image" => $_POST["Image"],
                "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
            )
        );

        // --- Only on first loop, set voucherNo ---
        if ($voucherNo === null) {
            if ($UpdateMode == false) {
                $voucherNo = $TheEntityName["DrVoucherID"];
            } else {
                $voucherNo = $_REQUEST[$Entity . "ID"];
            }
        }

        // Always update VoucherNo field
        SQL_InsertUpdate(
            $Entity,
            array(
                "VoucherNo" => $voucherNo
            ),
            "DrVoucherID = {$TheEntityName["DrVoucherID"]}"
        );

        // Now Insert transaction (no delete inside loop)
        if ($_POST["{$Entity}IsDisplay"] == 0) {
            $result = SQL_InsertUpdate(
                "transaction",
                array(
                    "ProjectID" => $_POST["ProjectID"],
                    "ProjectName" => GetCategoryName($_POST["ProjectID"]),
                    "BankCashID" => $_POST["BankCashID"],
                    "BankCashName" => GetBankCashTitle($_POST["BankCashID"]),

                    "HeadOfAccountID" => $headID,
                    "HeadOfAccountName" => GetExpenseHeadName($headID),

                    "Date" => $_POST["Date"],
                    "ChequeNumber" => $_POST["ChequeNumber"],
                    "Division" => $_POST["Division"],

                    "VoucherNo" => $voucherNo,
                    "VoucherType" => "DV",

                    "BillPhase" => $_POST["BillPhase"],
                    "BillDate" => $_POST["BillDate"],
                    "BillNo" => $_POST["BillNo"],

                    "VendorID" => $_POST["VendorID"],
                    "VendorName" => GetVendorName($_POST["VendorID"]),
                    "ContructorID" => $_POST["ContructorID"],
                    "ContructorName" => GetContructorName($_POST["ContructorID"]),

                    "CustomerID" => $_POST["CustomerID"],
                    "Description" => $_POST["Description"],
                    "dr" => $amount,
                    "cr" => 0,
                )
            );
            if (!$result) {
                echo "Transaction Insert Failed!";
                exit;
            }
        }
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
