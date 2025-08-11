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
        $CustomerID    = isset($data[0]) ? trim($data[0]) : '';
        $ProjectID     = isset($data[1]) ? trim($data[1]) : '';
        $ProductID= isset($data[2]) ? trim($data[2]) : '';
        $SellerID   = isset($data[3]) ? trim($data[3]) : '';
        $Discount   = isset($data[4]) ? trim($data[4]) : '';
        $Quantity    = isset($data[5]) ? trim($data[5]) : '';
        $Division    = isset($data[6]) ? trim($data[6]) : '';
        $SalesDate    = isset($data[7]) ? trim($data[7]) : '';

        // Skip if $CustomerID is missing
        if ($CustomerID == '' && $ProjectID == '' && $ProductID == '' && $SellerID == '' && $Discount == '' && $Quantity == '' && $Division == '' && $SalesDate == '') {
            $MainContent .= "<p style='color:red;'>Row $row skipped: Some Data Are Missing </p>";
            $row++;
            continue;
        }

        $product = SQL_Select("products", "ProductsID='" . addslashes($ProductID) . "'", "", true);


            // Prepare data array (long-form syntax for PHP 5.6)
            $insertData = array(
                "CustomerID" => $CustomerID,
                "ProjectID" => $ProjectID,
                "ProductID" => $ProductID,
                "ProductName" => $product['FlatType'],
                "SellerID" => $SellerID,
                "Discount" => $Discount,
                "Quantity" => $Quantity,
                "Division" => $Division,
                "SalesDate" => $SalesDate,
                "CustomerName"=>GetCustomerName($CustomerID),
                "ProjectName"=>GetProjectName($ProjectID),
                "SellerName"=>GetSellerName($SellerID),
            );

            // Insert into database
        SQL_InsertUpdate("sales", $insertData);

            $MainContent .= "<p style='color:green;'>Row $row imported: $CustomerID ($ProductID)</p>";


        $row++;
    }

    fclose($handle);
} else {
    die("Unable to read the uploaded CSV file.");
}

// Final success alert
$MainContent .= "<script>alert('CSV Data Import DONE');</script>";

$MainContent .= CTL_Window(
    $Title = "Application Setting Management",
    "The operation completed successfully and<br>
    Please click <a href='index.php?Theme=default&Base=Sales&Script=Manage'>here</a> to proceed.",
    300
);

$MainContent .= "<script>
    window.location='index.php?Theme=default&Base=Sales&Script=Manage';
</script>";







?>
