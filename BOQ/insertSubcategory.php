<?php

header('Content-Type: application/json');
    $conn = mysqli_connect("localhost", "root", "", "boq");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

include "ajax-load-data.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $BoqID = $_POST['BoqID'];
    $categoryId =  $_POST['categoryId'];

    $insertQuery = "INSERT INTO tblboqsubcategory (BoqCategoryID) VALUES ('$categoryId')";
    if (mysqli_query($conn, $insertQuery)) {
        $newSubcategoryID = mysqli_insert_id($conn);

        $loadDataAsHTML = loadData($conn,$BoqID,$categoryId,$newSubcategoryID);

        $data["success"]          = true;
        $data["newSubcategoryID"] = $newSubcategoryID;
        $data["loadedHTML"]       = $loadDataAsHTML;

        echo json_encode($data);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($conn)]);
    }
}

mysqli_close($conn);
?>

