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
        $BankCashID    = isset($data[1]) ? trim($data[1]) : '';
        $ChequeNumber    = isset($data[2]) ? trim($data[2]) : '';
        $HeadOfAccountID    = isset($data[3]) ? trim($data[3]) : '';
        $BillNo    = isset($data[4]) ? trim($data[4]) : '';
        $Date    = isset($data[5]) ? trim($data[5]) : '';
        $Description  = isset($data[6]) ? trim($data[6]) : '';
        $Type    = isset($data[7]) ? trim($data[7]) : '';
        $Name    = isset($data[8]) ? trim($data[8]) : '';
        $CustomerID    = isset($data[9]) ? trim($data[9]) : '';
        $ProductsID    = isset($data[10]) ? trim($data[10]) : '';
        $Amount    = isset($data[11]) ? trim($data[11]) : '';
        $SalesID    = isset($data[12]) ? trim($data[12]) : '';
        $Term    = isset($data[13]) ? trim($data[13]) : '';
        $Division    = isset($data[14]) ? trim($data[14]) : '';


        // Skip if phone is missing
        if ($ProjectID == '' && $HeadOfAccountID == '' &&  $Description == '' && $Type =='' && $CustomerID == '' && $SalesID =='' && $ProductsID=='' && $BankCashID == '' && $Amount =='') {
            $MainContent .= "<p style='color:red;'>Row $row skipped: Some Data</p>";
            $row++;
            continue;
        }




        // Prepare data array (long-form syntax for PHP 5.6)
        $insertData = array(
            "ProjectID" => $ProjectID,
            "BankCashID" => $BankCashID,
            "ChequeNumber" => $ChequeNumber,
            "HeadOfAccountID" => $HeadOfAccountID,
            "BillNo" => $BillNo,
            "Date" => $Date,
            "Description" => $Description,
            "Type" => $Type,
            "Name" => $Name,
            "CustomerID" => $CustomerID,
            "ProductsID" => $ProductsID,
            "Amount" => $Amount,
            "SalesID" => $SalesID,
            "Term" => $Term,
            "Division" => $Division,
            "IsDisplay" => 1,
            "ProjectName" => GetProjectName($ProjectID),
            "BankCashName" => GetBankCashTitle($BankCashID),
            "HeadOfAccountName" => GetExpenseHeadName($HeadOfAccountID),
            "CustomerName" => GetCustomerName($CustomerID),

        );

        // Insert into database
        SQL_InsertUpdate("Crvoucher", $insertData);

        $MainContent .= "<p style='color:green;'>Row $row imported: $Name </p>";


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
    Please click <a href='index.php?Theme=default&Base=CrVoucher&Script=Manage'>here</a> to proceed.",
    300
);

$MainContent .= "<script>
    window.location='index.php?Theme=default&Base=CrVoucher&Script=Manage';
</script>";





?>
