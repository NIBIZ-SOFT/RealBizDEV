<?php

$uploadDir = "./upload/";
$filename = $_FILES['importFile']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

if (strtolower($ext) !== "csv") {
    die("Invalid file format. Only CSV files are allowed.");
}

$targetPath = $uploadDir . basename($filename);

if (!move_uploaded_file($_FILES['importFile']['tmp_name'], $targetPath)) {
    die("File upload failed!");
}

$MainContent = '';
$rowCounter = 1;

// Get the starting VoucherNo only once
$result = mysql_query("SELECT MAX(VoucherID) AS LastID FROM tblDrVoucher");
$lastVoucherRow = mysql_fetch_assoc($result);
$voucherNo = isset($lastVoucherRow['LastID']) ? $lastVoucherRow['LastID'] + 1 : 1;


if (($handle = fopen($targetPath, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {


        if ($rowCounter == 1) {
            $rowCounter++;
            continue;
        }


        $ProjectID       = isset($data[0])  ? trim($data[0])  : '';
        $CustomerID      = isset($data[1])  ? trim($data[1])  : null;
        $HeadOfAccountID = isset($data[2])  ? trim($data[2])  : '';
        $Type            = isset($data[3])  ? trim($data[3])  : '';
        $VendorID        = isset($data[4])  ? trim($data[4])  : null;
        $ContructorID    = isset($data[5])  ? trim($data[5])  : null;
        $BankCashID      = isset($data[6])  ? trim($data[6])  : '';
        $Date            = isset($data[7])  ? trim($data[7])  : '';
        $ChequeNumber    = isset($data[8])  ? trim($data[8])  : '';
        $Division        = isset($data[9])  ? trim($data[9])  : '';
        $BillPhase       = isset($data[10]) ? trim($data[10]) : '';
        $BillDate        = isset($data[11]) ? trim($data[11]) : '';
        $BillNo          = isset($data[12]) ? trim($data[12]) : '';
        $Description     = isset($data[13]) ? trim($data[13]) : '';
        $Amount          = isset($data[14]) ? trim($data[14]) : '';


        if (empty($ProjectID) || empty($HeadOfAccountID) || empty($Type) || empty($BankCashID) || empty($Amount)) {
            $MainContent .= "<p style='color:red;'>Row $rowCounter is missing required fields.</p>";
            $rowCounter++;
            continue;
        }


        $newDate = null;
        if (!empty($Date)) {
            $timestamp = strtotime($Date);
            if ($timestamp !== false) {
                $newDate = date('Y-m-d', $timestamp);
            }
        }


        $insertData = array(
            "ProjectID" => $ProjectID,
            "ProjectName" => GetCategoryName($ProjectID),
            "HeadOfAccountID" => $HeadOfAccountID,
            "HeadOfAccountName" => GetExpenseHeadName($HeadOfAccountID),
            "Type" => $Type,
            "BankCashID" => $BankCashID,
            "BankCashName" => GetBankCashTitle($BankCashID),
            "Date" => $newDate,
            "ChequeNumber" => $ChequeNumber,
            "Division" => $Division,
            "BillPhase" => $BillPhase,
            "BillDate" => $BillDate,
            "BillNo" => $BillNo,
            "Description" => $Description,
            "Amount" => $Amount,
            "VoucherNo" => $voucherNo,
            "IsDisplay" => 1
        );

        // Condition
        if ($VendorID == '' && $CustomerID != '') {
            $insertData["CustomerID"] = $CustomerID;
        } elseif ($CustomerID == '' && $ContructorID != '') {
            $insertData["ContructorID"] = $ContructorID;
            $insertData["ContructorName"] = GetContructorName($ContructorID);
        } elseif ($CustomerID == '' && $VendorID != '') {
            $insertData["VendorID"] = $VendorID;
            $insertData["VendorName"] = GetVendorName($VendorID);
        }


        SQL_InsertUpdate("DrVoucher", $insertData);

        $MainContent .= "<p style='color:green;'>Row $rowCounter imported: ProjectID $ProjectID, VoucherNo $voucherNo</p>";

        $voucherNo++;
        $rowCounter++;
    }

    fclose($handle);
} else {
    die("Unable to read the uploaded CSV file.");
}
