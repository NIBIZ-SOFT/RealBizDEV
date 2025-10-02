<?php
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"])) {
    $UpdateMode = true;
}

$ErrorUserInput["_Error"] = false;

if (!$UpdateMode) {
    $_REQUEST["{$Entity}ID"] = 0;
}

$TheEntityName = SQL_Select(
    $Entity,
    "{$UniqueField} = '{$_POST[$UniqueField]}' AND {$Entity}ID <> {$_REQUEST[$Entity . "ID"]}"
);
if (count($TheEntityName) > 0) {
    $ErrorUserInput["_Error"] = true;
    $ErrorUserInput["_Message"] = "This Value Already Taken.";
}

if ($ErrorUserInput["_Error"]) {
    include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
    exit;
} else {
    // Print post data for debug (optional)
    // print_r($_POST); exit;

    $Where = "";
    $journalvoucher = SQL_Select("journalvoucher ORDER BY JournalVoucherID DESC LIMIT 1");

    // Type handling
    if ($_POST["Type"] == 0) {
        $_POST["VendorID"] = 0;
        $_POST["ContructorID"] = 0;
        $_POST["BillPhase"] = 0;
        $_POST["BillDate"] = 0;
    } elseif ($_POST["Type"] == 1) {
        $_POST["VendorID"] = 0;
    } else {
        $_POST["ContructorID"] = 0;
    }
    if (!$UpdateMode) {
            $lastVoucher = SQL_Select("journalvoucher", "1 ORDER BY VoucherNo DESC LIMIT 1");
            $voucherNo = !empty($lastVoucher) ? intval($lastVoucher[0]["VoucherNo"]) + 1 : 1;
            while (!empty(SQL_Select("journalvoucher", "VoucherNo = {$voucherNo}"))) {
                $voucherNo++;
            }
    } else {
        $voucherDetails = SQL_Select("journalvoucher where VoucherNo={$_REQUEST["VoucherNo"]}");
        $voucherNo = $_POST["VoucherNo"];

        if (!empty($voucherDetails)) {
            SQL_Delete("journalvoucher where VoucherNo={$voucherNo}");
            SQL_Delete("transaction where VoucherNo={$voucherNo}");
        }
    }

    

    // === DEBIT ENTRIES ===
    if (!empty($_POST["FormHeadOfAccountID"]["dr"])) {
        foreach ($_POST["FormHeadOfAccountID"]["dr"] as $i => $FormHeadOfAccountID) {
            if (empty($FormHeadOfAccountID)) continue;

            $InsertResult = SQL_InsertUpdate(
                $Entity,
                array(
                    "ProjectID" => $_POST["FormProjectID"],
                    "ProjectName" => GetCategoryName($_POST["FormProjectID"]),
                    "HeadOfAccountID" => $FormHeadOfAccountID,
                    "HeadOfAccountName" => GetExpenseHeadName($FormHeadOfAccountID),
                    "Type" => $_POST["Type"],
                    "VendorID" => $_POST["VendorID"],
                    "VendorName" => GetVendorName($_POST["VendorID"]),
                    "ContructorID" => $_POST["ContructorID"],
                    "ContructorName" => GetContructorName($_POST["ContructorID"]),
                    "Date" => $_POST["Date"],
                    "VoucherNo" => $voucherNo,
                    "BillPhase" => $_POST["BillPhase"],
                    "BillDate" => $_POST["BillDate"],
                    "BillNo" => $_POST["BillNo"],
                    "Description" => $_POST["Description"],
                    "dr" => $_POST["Amount"]["dr"][$i],
                    "cr" => 0,
                    "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"]
                ),
                ""
            );

            if (!$InsertResult) error_log("Failed to insert DR row $i (HOID: $FormHeadOfAccountID)");
        }
    }

    // === CREDIT ENTRIES ===
    if (!empty($_POST["ToHeadOfAccountID"]["cr"])) {
        foreach ($_POST["ToHeadOfAccountID"]["cr"] as $i => $ToHeadOfAccountID) {
            if (empty($ToHeadOfAccountID)) continue;

            $InsertResult = SQL_InsertUpdate(
                $Entity,
                array(
                    "ProjectID" => $_POST["ToProjectID"],
                    "ProjectName" => GetCategoryName($_POST["ToProjectID"]),
                    "HeadOfAccountID" => $ToHeadOfAccountID,
                    "HeadOfAccountName" => GetExpenseHeadName($ToHeadOfAccountID),
                    "Type" => $_POST["Type"],
                    "VendorID" => $_POST["VendorID"],
                    "VendorName" => GetVendorName($_POST["VendorID"]),
                    "ContructorID" => $_POST["ContructorID"],
                    "ContructorName" => GetContructorName($_POST["ContructorID"]),
                    "BillPhase" => $_POST["BillPhase"],
                    "BillDate" => $_POST["BillDate"],
                    "BillNo" => $_POST["BillNo"],
                    "Date" => $_POST["Date"],
                    "VoucherNo" => $voucherNo,
                    "Description" => $_POST["Description"],
                    "dr" => 0,
                    "cr" => $_POST["Amount"]["cr"][$i],
                    "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"]
                ),
                ""
            );

            if (!$InsertResult) error_log("Failed to insert CR row $i (HOID: $ToHeadOfAccountID)");
        }
    }

    // === TRANSACTION INSERTS ===
    if ($_POST["{$Entity}IsDisplay"] == 1) {
        SQL_Delete("transaction WHERE VoucherNo = '{$voucherNo}' AND VoucherType = 'JV'");
    }

    if ($_POST["{$Entity}IsDisplay"] == 0) {
        if (!empty($_POST["FormHeadOfAccountID"]["dr"])) {
            foreach ($_POST["FormHeadOfAccountID"]["dr"] as $i => $FormHeadOfAccountID) {
                if (empty($FormHeadOfAccountID)) continue;

                SQL_InsertUpdate(
                    "transaction",
                    array(
                        "ProjectID" => $_POST["FormProjectID"],
                        "ProjectName" => GetCategoryName($_POST["FormProjectID"]),
                        "HeadOfAccountID" => $FormHeadOfAccountID,
                        "HeadOfAccountName" => GetExpenseHeadName($FormHeadOfAccountID),
                        "Date" => $_POST["Date"],
                        "VoucherNo" => $voucherNo,
                        "VoucherType" => "JV",
                        "BillPhase" => $_POST["BillPhase"],
                        "BillDate" => $_POST["BillDate"],
                        "BillNo" => $_POST["BillNo"],
                        "VendorID" => $_POST["VendorID"],
                        "VendorName" => GetVendorName($_POST["VendorID"]),
                        "ContructorID" => $_POST["ContructorID"],
                        "ContructorName" => GetContructorName($_POST["ContructorID"]),
                        "Description" => $_POST["Description"],
                        "dr" => $_POST["Amount"]["dr"][$i],
                        "cr" => 0,
                    ),
                    ""
                );
            }
        }

        if (!empty($_POST["ToHeadOfAccountID"]["cr"])) {
            foreach ($_POST["ToHeadOfAccountID"]["cr"] as $i => $ToHeadOfAccountID) {
                if (empty($ToHeadOfAccountID)) continue;

                SQL_InsertUpdate(
                    "transaction",
                    array(
                        "ProjectID" => $_POST["ToProjectID"],
                        "ProjectName" => GetCategoryName($_POST["ToProjectID"]),
                        "HeadOfAccountID" => $ToHeadOfAccountID,
                        "HeadOfAccountName" => GetExpenseHeadName($ToHeadOfAccountID),
                        "Date" => $_POST["Date"],
                        "VoucherNo" => $voucherNo,
                        "VoucherType" => "JV",
                        "BillPhase" => $_POST["BillPhase"],
                        "BillDate" => $_POST["BillDate"],
                        "BillNo" => $_POST["BillNo"],
                        "VendorID" => $_POST["VendorID"],
                        "VendorName" => GetVendorName($_POST["VendorID"]),
                        "ContructorID" => $_POST["ContructorID"],
                        "ContructorName" => GetContructorName($_POST["ContructorID"]),
                        "Description" => $_POST["Description"],
                        "dr" => 0,
                        "cr" => $_POST["Amount"]["cr"][$i],
                    ),
                    ""
                );
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
?>