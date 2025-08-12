<?php

// Set upload directory
$uploadDir = "./upload/";
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
$Entity = "Customer"; // Or dynamically determine if needed

// Open and read the CSV
if (($handle = fopen($targetPath, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

        // Skip header row
        if ($row == 1) {
            $row++;
            continue;
        }

        // Map each column
        $CustomerName         = isset($data[0]) ? trim($data[0]) : '';
        $FathersOrHusbandName = isset($data[1]) ? trim($data[1]) : '';
        $Address              = isset($data[2]) ? trim($data[2]) : '';
        $ParmanentAddress     = isset($data[3]) ? trim($data[3]) : '';
        $Phone                = isset($data[4]) ? trim($data[4]) : '';
        $NID                  = isset($data[5]) ? trim($data[5]) : '';
        $WhatsApp             = isset($data[6]) ? trim($data[6]) : '';
        $Date                 = isset($data[7]) ? trim($data[7]) : '';
        $CustomerEmail        = isset($data[8]) ? trim($data[8]) : '';
        $Profession           = isset($data[9]) ? trim($data[9]) : '';

        // Skip if phone is missing
        if ($Phone == '') {
            $MainContent .= "<p style='color:red;'>Row $row skipped: No phone number</p>";
            $row++;
            continue;
        }



            // Prepare data
            $insertData = array(
                "CustomerName"         => $CustomerName,
                "FathersOrHusbandName" => $FathersOrHusbandName,
                "Address"              => $Address,
                "ParmanentAddress"     => $ParmanentAddress,
                "Phone"                => $Phone,
                "NID"                  => $NID,
                "Whatsapp"             => $WhatsApp,
                "Date"                 => $Date,
                "CustomerEmail"        => $CustomerEmail,
                "Profession"           => $Profession,
                "IsActive"             => 1,
            );

            // Insert into database
            SQL_InsertUpdate("customer", $insertData);


            $MainContent .= "<p style='color:green;'>Row $row imported: $CustomerName ($Phone)</p>";


        $row++;
    }

    fclose($handle);
} else {
    die("Unable to read the uploaded CSV file.");
}

// Final success alert
$MainContent .= "<script>alert('CSV Data Import DONE');</script>";
$MainContent .= CTL_Window(
    $Title = "Customer Import",
    "The operation completed successfully.<br>
    Click <a href='index.php?Theme=default&Base=Customer&Script=Manage'>here</a> to manage customers.",
    300
);
$MainContent .= "<script>window.location='index.php?Theme=default&Base=Customer&Script=Manage';</script>";

echo $MainContent;

?>
