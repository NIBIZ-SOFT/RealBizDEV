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
        $GLCode    = isset($data[1]) ? trim($data[1]) : '';


        // Skip if phone is missing
        if ($Name == '') {
            $MainContent .= "<p style='color:red;'>Row $row skipped: Name</p>";
            $row++;
            continue;
        }




        // Prepare data array (long-form syntax for PHP 5.6)
        $insertData = array(
            "Name" => $Name,
            "GLCode" => $GLCode,
            "IsActive" => 0,

        );

        // Insert into database
        SQL_InsertUpdate("Incomeexpensetype", $insertData);

        $MainContent .= "<p style='color:green;'>Row $row imported: $Name ($GLCode)</p>";


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
    Please click <a href='index.php?Theme=default&Base=IncomeExpenseType&Script=Manage'>here</a> to proceed.",
    300
);

$MainContent .= "<script>
    window.location='index.php?Theme=default&Base=IncomeExpenseType&Script=Manage';
</script>";





?>
