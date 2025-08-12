<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "boq";

try {
        $conn = mysqli_connect("localhost", "root", "", "boq");
    include "ajax-load-data.php";

    if($_POST["BoqSubCategoryID"]){
        $BoqSubCategoryID = $_POST["BoqSubCategoryID"];
        $dynamicColumnName = $_POST["SubCategoryColumnName"];
        $dynamicColumnValue = $_POST["SubCategoryInputValue"];

        $updateQuery = "UPDATE tblboqsubcategory SET $dynamicColumnName='$dynamicColumnValue' WHERE BoqSubcategoryID='$BoqSubCategoryID'";

        if (mysqli_query($conn, $updateQuery)) {
            $insertedCategoryId = mysqli_insert_id($conn);

            $loadDataAsHTML = loadData($conn);

            $data["success"]     = true;
            $data["loadedHTML"]  = $loadDataAsHTML;

            // Return success response with the new subcategory ID
            echo json_encode($data);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

}
catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>




