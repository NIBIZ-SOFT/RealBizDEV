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
        $title    = isset($data[0]) ? trim($data[0]) : '';
        $name     = isset($data[1]) ? trim($data[1]) : '';
        $address  = isset($data[2]) ? trim($data[2]) : '';
        $status   = isset($data[3]) ? trim($data[3]) : '';
        $source   = isset($data[4]) ? trim($data[4]) : '';
        $phone    = isset($data[5]) ? trim($data[5]) : '';
        $email    = isset($data[6]) ? trim($data[6]) : '';

        // Skip if phone is missing
        if ($phone == '') {
            $MainContent .= "<p style='color:red;'>Row $row skipped: No phone number</p>";
            $row++;
            continue;
        }

        // Check if phone already exists
        $PhoneNumberExists = SQL_Select("crm", "Phone='" . addslashes($phone) . "'", "", true);
        if (!$PhoneNumberExists) {

            // Prepare data array (long-form syntax for PHP 5.6)
            $insertData = array(
                "Title" => $title,
                "CustomerName" => $name,
                "Address" => $address,
                "LeadsStatus" => $status,
                "LeadSource" => $source,
                "Phone" => $phone,
                "Email" => $email,
                "CRMIsActive" => 1,
                "CRMIsDisplay" => 1
            );

            // Insert into database
            SQL_InsertUpdate("crm", $insertData);

            $MainContent .= "<p style='color:green;'>Row $row imported: $name ($phone)</p>";
        } else {
            $MainContent .= "<p style='color:orange;'>Row $row skipped: Duplicate Phone ($phone)</p>";
        }

        $row++;
    }

    fclose($handle);
} else {
    die("Unable to read the uploaded CSV file.");
}

// Final success alert
$MainContent .= "<script>alert('CSV Data Import DONE');</script>";

?>
