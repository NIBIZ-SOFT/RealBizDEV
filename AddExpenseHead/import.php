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
        $Name    = isset($data[0]) ? trim($data[0]) : '';
        $Unit    = isset($data[1]) ? trim($data[1]) : '';
        $IncomeExpenseTypeID    = isset($data[2]) ? trim($data[2]) : '';
        $InventorySubCategory    = isset($data[3]) ? trim($data[3]) : '';
        $GLCode    = isset($data[4]) ? trim($data[4]) : '';
        $IsType    = isset($data[5]) ? trim($data[5]) : '';
        $IsStock  = isset($data[6]) ? trim($data[6]) : '';




        // Skip if phone is missing
        if ($Name == '' && $Unit == '' &&  $IncomeExpenseTypeID == '' && $InventorySubCategory ==''  && $IsType =='' && $IsStock=='' ) {
            $MainContent .= "<p style='color:red;'>Row $row skipped: Some Data Missing</p>";
            $row++;
            continue;
        }




        // Prepare data array (long-form syntax for PHP 5.6)
        $insertData = array(
            "ExpenseHeadName" => $Name,
            "Unit" => $Unit,
            "IncomeExpenseTypeID" => $IncomeExpenseTypeID,
            "InventorySubCategory" => $InventorySubCategory,
            "GLCode" => $GLCode,
            "IsType" => $IsType,
            "ExpenseHeadIsStock" => $IsStock,
            "IsActive" => 0,
            "IncomeExpenseTypeName" => GetIncomeExpenseTypeName($IncomeExpenseTypeID),

        );

        // Insert into database
        SQL_InsertUpdate("ExpenseHead", $insertData);

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
    Please click <a href='index.php?Theme=default&Base=AddExpenseHead&Script=Manage'>here</a> to proceed.",
    300
);

$MainContent .= "<script>
    window.location='index.php?Theme=default&Base=AddExpenseHead&Script=Manage';
</script>";





?>
