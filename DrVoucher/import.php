<?php



// Set upload directory
$uploadDir =  "./upload/";
$filename = $_FILES['importFile']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);

// Validate file extension
if (strtolower($ext) !== "csv") {
    die("Invalid file format. Only CSV files are allowed.");
}

// Final path to save uploaded file
$targetPath = $uploadDir . basename($filename);

// Move file to upload directory
if (!move_uploaded_file($_FILES['importFile']['tmp_name'], $targetPath)) {
    die("File upload failed!");
}

$MainContent = '';
$row = 1;

// Open and read the CSV
if (($handle = fopen($targetPath, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

        // Skip header row
        if ($row == 1) {
            $row++;
            continue;
        }



        // Manually check each index
        $ProjectID    = isset($data[0]) ? trim($data[0]) : '';
        $CustomerID    = isset($data[1]) ? trim($data[1]) : null;
        $HeadOfAccountID    = isset($data[2]) ? trim($data[2]) : '';
        $Type    = isset($data[3]) ? trim($data[3]) : '';
        $VendorID    = isset($data[4]) ? trim($data[4]) : null;
        $ContructorID    = isset($data[5]) ? trim($data[5]) : null;
        $BankCashID     = isset($data[6]) ? trim($data[6]) : '';
        $Date    = isset($data[7]) ? trim($data[7]) : '';
        $ChequeNumber    = isset($data[8]) ? trim($data[8]) : '';
        $Division    = isset($data[9]) ? trim($data[9]) : '';
        $BillPhase    = isset($data[10]) ? trim($data[10]) : '';
        $BillDate    = isset($data[11]) ? trim($data[11]) : '';
        $BillNo    = isset($data[12]) ? trim($data[12]) : '';
        $Description    = isset($data[13]) ? trim($data[13]) : '';
        $Amount    = isset($data[14]) ? trim($data[14]) : '';





        if ($VendorID == '' && $CustomerID == ''){
            // Prepare data array (long-form syntax for PHP 5.6)
            $insertData = array(
                "ProjectID" => $ProjectID,
                "ProjectName" => GetCategoryName($ProjectID),

                "HeadOfAccountID" => $HeadOfAccountID,
                "HeadOfAccountName" => GetExpenseHeadName($HeadOfAccountID),

                "Type" => $Type,
                "ContructorID" => $ContructorID,
                "ContructorName" => GetContructorName($ContructorID),

                "BankCashID" => $BankCashID,
                "BankCashName" => GetBankCashTitle($BankCashID),

                "Date" => $Date,

                "ChequeNumber" => $ChequeNumber,
                "Division" => $Division,

                "BillPhase" => $BillPhase,
                "BillDate" => $BillDate,
                "BillNo" => $BillNo,

                "Description" => $Description,
                "Amount" => $Amount,
                "IsDisplay" => 1,

            );
        } elseif ($VendorID == '' && $ContructorID ==''){
            $insertData = array(
                "ProjectID" => $ProjectID,
                "CustomerID" => $CustomerID ,
                "ProjectName" => GetCategoryName($ProjectID),

                "HeadOfAccountID" => $HeadOfAccountID,
                "HeadOfAccountName" => GetExpenseHeadName($HeadOfAccountID),

                "Type" => $Type,

                "BankCashID" => $BankCashID,
                "BankCashName" => GetBankCashTitle($BankCashID),

                "Date" => $Date,

                "ChequeNumber" => $ChequeNumber,
                "Division" => $Division,

                "BillPhase" => $BillPhase,
                "BillDate" => $BillDate,
                "BillNo" => $BillNo,

                "Description" => $Description,
                "Amount" => $Amount,
                "IsDisplay" => 1,

            );
        } else{
            $insertData = array(
                "ProjectID" => $ProjectID,
                "ProjectName" => GetCategoryName($ProjectID),

                "HeadOfAccountID" => $HeadOfAccountID,
                "HeadOfAccountName" => GetExpenseHeadName($HeadOfAccountID),

                "Type" => $Type,
                "VendorID" => $VendorID,
                "VendorName" => GetVendorName($VendorID),

                "BankCashID" => $BankCashID,
                "BankCashName" => GetBankCashTitle($BankCashID),

                "Date" => $Date,

                "ChequeNumber" => $ChequeNumber,
                "Division" => $Division,

                "BillPhase" => $BillPhase,
                "BillDate" => $BillDate,
                "BillNo" => $BillNo,

                "Description" => $Description,
                "Amount" => $Amount,
                "IsDisplay" => 1,

            );
        }



        // Insert into database
        SQL_InsertUpdate("DrVoucher", $insertData);

        $MainContent .= "<p style='color:green;'>Row $row imported: $ProjectID </p>";


        $row++;
    }

    fclose($handle);
} else {
    die("Unable to read the uploaded CSV file.");
}

// Final success alert
// Final success alert
$MainContent .= "<script>alert('CSV Data Import DONE');</script>";

$MainContent .= CTL_Window(
    $Title = "Application Setting Management",
    "The operation completed successfully and<br>
    Please click <a href='index.php?Theme=default&Base=DrVoucher&Script=Manage'>here</a> to proceed.",
    300
);

$MainContent .= "<script>
    window.location='index.php?Theme=default&Base=DrVoucher&Script=Manage';
</script>";





?>
