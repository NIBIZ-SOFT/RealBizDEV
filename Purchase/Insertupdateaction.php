<?php
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = !empty($_REQUEST[$Entity . "ID"]);

if (!$UpdateMode) {
    $ThisItems = SQL_Select("purchase");
    $padNo = count($ThisItems) + 1;
    $RequisitionOfIdNumber = str_pad($padNo, 5, "0", STR_PAD_LEFT);
    $PurchaseConfirmID = "POD" . substr(date("Y"), 2, 2) . "-" . $RequisitionOfIdNumber;
    $_REQUEST["{$Entity}ID"] = 0;
} else {
    $PurchaseConfirmID = $_POST["PurchaseConfirmID"];
}

// === Validation: Unique Field Check ===
$ErrorUserInput["_Error"] = false;
$check = SQL_Select(
    $Entity,
    "{$UniqueField} = '{$_POST[$UniqueField]}' AND {$Entity}ID <> {$_REQUEST[$Entity . "ID"]}"
);

if (count($check) > 0) {
    $ErrorUserInput["_Error"] = true;
    $ErrorUserInput["_Message"] = "This value already exists.";
    include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
    return;
}

// === Insert / Update Purchase ===
$Where = $UpdateMode ? "{$Entity}ID = {$_REQUEST[$Entity . "ID"]}" : "";

$InsertData = array(
    "CategoryID"           => $_POST["CategoryID"],
    "CategoryName"         => GetCategoryName($_POST["CategoryID"]),
    "VendorID"             => $_POST["VendorID"],
    "VendorName"           => GetVendorName($_POST["VendorID"]),
    "confirmRequisitonId"  => $_POST["confirmRequisitonId"],
    "PurchaseConfirmID"    => $PurchaseConfirmID,
    "confirmRequisitonName"=> GetPurchaseRequisitionConfirmID($_POST["confirmRequisitonId"]),
    "MediaName"            => $_POST["MediaName"],
    "letterTitle"          => $_POST["letterTitle"],
    "ContactPerson1"       => $_POST["ContactPerson1"],
    "ContactPerson2"       => $_POST["ContactPerson2"],
    "TaxesVat"             => $_POST["TaxesVat"],
    "Note"                 => $_POST["Note"],
    "IssuingDate"          => $_POST["IssuingDate"],
    "Subject"              => $_POST["Subject"],
    "MessageBody"          => $_POST["MessageBody"],
    "DateOfDelevery"       => $_POST["DateOfDelevery"],
    "PurchaseAmount"       => round($_POST["PurchaseAmount"], 2),
    "Confirm"              => $_POST["Confirm"],
    "Items"                => json_encode($_POST["items"]),
    "PurchaseIsActive"     => 1
);

SQL_InsertUpdate("purchase", $InsertData, $Where);

    
        // === Fetch Related Requisition ===
        $PurchaseRequisitionID = $_POST["confirmRequisitonId"];
        $PurchaseConfirm = SQL_Select("purchaserequisition", "PurchaseRequisitionID = {$PurchaseRequisitionID}");

        $RequisitionConfirmID = $PurchaseConfirm[0]["RequisitionConfirmID"];
        $RequisitionConfirmID = trim($RequisitionConfirmID);
        $CategoryID = $PurchaseConfirm[0]["CategoryID"];

        $Date = $_POST["IssuingDate"] ?: date("Y-m-d");

if($_POST["Confirm"] == "Confirm"){
    
        // === Handle Voucher Number ===
        if (!$UpdateMode) {
            $lastVoucher = SQL_Select("journalvoucher", "1 ORDER BY VoucherNo DESC LIMIT 1");
            $voucherNo = !empty($lastVoucher) ? intval($lastVoucher[0]["VoucherNo"]) + 1 : 1;
            while (!empty(SQL_Select("journalvoucher", "VoucherNo = {$voucherNo}"))) {
                $voucherNo++;
            }
        } else {
            $existingJV = SQL_Select("journalvoucher", "IsPurchase = '$RequisitionConfirmID'");

            if (!empty($existingJV)) {
                $voucherNo = $existingJV[0]["VoucherNo"];
                // print_r($existingJV);
                
                SQL_Delete("transaction WHERE VoucherType = 'JV' AND VoucherNo = '$voucherNo'");
                SQL_Delete("journalvoucher WHERE VoucherNo = '$voucherNo'");
            } else {
                $lastVoucher = SQL_Select("journalvoucher", "1 ORDER BY VoucherNo DESC LIMIT 1");
                $voucherNo = !empty($lastVoucher) ? intval($lastVoucher[0]["VoucherNo"]) + 1 : 1;
                while (!empty(SQL_Select("journalvoucher", "VoucherNo = {$voucherNo}"))) {
                    $voucherNo++;
                }
                SQL_Delete("transaction WHERE VoucherType = 'JV' AND VoucherNo = '$voucherNo'");
                SQL_Delete("journalvoucher WHERE VoucherNo = '$voucherNo'");
            }
        }

        // === Insert JV / TRX Entries ===
        $items = is_array($_POST["items"]) ? $_POST["items"] : json_decode($_POST["items"], true);
        $totalAmount = 0;

        // === Debit Entries ===
        foreach ($items as $item) {
            if (empty($item["expenseHead"])) continue;

            $expenseHeadID = intval($item["expenseHead"]);
            $amount = floatval($item["requisitionAmount"]);
            $totalAmount += $amount;

            $JVData = array(
                "Type"              => 2,
                "Date"              => $Date,
                "VoucherNo"         => $voucherNo,
                "ProjectID"         => $CategoryID,
                "ProjectName"       => GetCategoryName($CategoryID),
                "HeadOfAccountID"   => $expenseHeadID,
                "HeadOfAccountName" => GetExpenseHeadName($expenseHeadID),
                "VendorID"          => $_POST["VendorID"],
                "VendorName"        => GetVendorName($_POST["VendorID"]),
                "Description"       => "Auto JV for Purchase Order And RQN - {$PurchaseConfirmID} - {$RequisitionConfirmID}",
                "BillNo"            => $PurchaseConfirmID,
                "IsPurchase" => trim($RequisitionConfirmID),
                "dr"                => $amount,
                "cr"                => 0,
                "PurchaseIsDisplay" => 0,
                "JournalVoucherIsDisplay" => 0
            );

            $TXData = array(
                "ProjectID"         => $CategoryID,
                "ProjectName"       => GetCategoryName($CategoryID),
                "HeadOfAccountID"   => $expenseHeadID,
                "HeadOfAccountName" => GetExpenseHeadName($expenseHeadID),
                "Date"              => $Date,
                "VoucherNo"         => $voucherNo,
                "VoucherType"       => "JV",
                "BillDate"          => $Date,
                "BillNo"            => $PurchaseConfirmID,
                "VendorID"          => $_POST["VendorID"],
                "VendorName"        => GetVendorName($_POST["VendorID"]),
                "Description"       => "Auto JV for Purchase Order And RQN - {$PurchaseConfirmID} - {$RequisitionConfirmID}",
                "dr"                => $amount,
                "cr"                => 0
            );

            SQL_InsertUpdate("journalvoucher", $JVData, "");
            SQL_InsertUpdate("transaction", $TXData, "");
        }

        // === Credit Entry (Vendor) ===
        $VendorHeadID = $_POST["VendorHead"];

        $VendorJV = array(
            "Date"              => $Date,
            "VoucherNo"         => $voucherNo,
            "ProjectID"         => $CategoryID,
            "ProjectName"       => GetCategoryName($CategoryID),
            "HeadOfAccountID"   => $VendorHeadID,
            "HeadOfAccountName" => GetExpenseHeadName($VendorHeadID),
            "VendorID"          => $_POST["VendorID"],
            "VendorName"        => GetVendorName($_POST["VendorID"]),
            "Description"       => "Auto JV for Purchase Order And RQN - {$PurchaseConfirmID} - {$RequisitionConfirmID}",
            "BillNo"            => $PurchaseConfirmID,
            "IsPurchase"        => trim($RequisitionConfirmID),
            "dr"                => 0,
            "cr"                => $totalAmount,
            "PurchaseIsDisplay" => 0,
            "JournalVoucherIsDisplay" => 0
        );

        $VendorTX = array(
            "ProjectID"         => $CategoryID,
            "ProjectName"       => GetCategoryName($CategoryID),
            "HeadOfAccountID"   => $VendorHeadID,
            "HeadOfAccountName" => GetExpenseHeadName($VendorHeadID),
            "Date"              => $Date,
            "VoucherNo"         => $voucherNo,
            "VoucherType"       => "JV",
            "BillDate"          => $Date,
            "BillNo"            => $PurchaseConfirmID,
            "VendorID"          => $_POST["VendorID"],
            "VendorName"        => GetVendorName($_POST["VendorID"]),
            "Description"       => "Auto JV for Purchase Order And RQN - {$PurchaseConfirmID} - {$RequisitionConfirmID}",
            "dr"                => 0,
            "cr"                => $totalAmount
        );

        SQL_InsertUpdate("journalvoucher", $VendorJV, "");
        SQL_InsertUpdate("transaction", $VendorTX, "");
        $VendorID = $_POST["VendorID"];
        // === AssaignVendor Check (Vendor & Project Wise) ===
        SQL_Delete("assaignvendorcontroctur WHERE CategoryID = $CategoryID AND VendorID = $VendorID");
        
        $InsertData = array(
            "CategoryID"         => $CategoryID,
            "CategoryName"       => GetCategoryName($CategoryID),
            "VendorID" => $_POST["VendorID"], 
            "VendorName" => GetVendorName($_POST["VendorID"]),
            "AssaignvendorcontrocturIsActive" => 1
        );
        SQL_InsertUpdate("assaignvendorcontroctur", $InsertData, "");
        
        
}else if ($_POST["Confirm"] == "Not Confirm"){
    // If not confirmed Delete TRX & JV
    $JV = SQL_Select("JournalVoucher", "IsPurchase = '{$RequisitionConfirmID}'");
    SQL_Delete("Transaction WHERE VoucherType = 'JV' AND voucherNo = '{$JV[0]["VoucherNo"]}'");
    SQL_Delete("JournalVoucher WHERE voucherno = '{$JV[0]["VoucherNo"]}'");
}



// === Final Output ===
    // $MainContent .= "
	//         " . CTL_Window($Title = "Application Setting Management", "The operation complete successfully and<br>
	// 		<br>
	// 		The $EntityCaptionLower information has been stored.<br>
	// 		<br>
	// 		Please click <a href=\"" . ApplicationURL("{$_REQUEST["Base"]}", "Manage") . "\">here</a> to proceed.", 300) . "
	//         <script language=\"JavaScript\" >
	//             window.location='" . ApplicationURL("{$_REQUEST["Base"]}", "Manage") . "';
	//         </script>
	// 	";
?>
