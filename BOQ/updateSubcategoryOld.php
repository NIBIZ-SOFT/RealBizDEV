

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "boq";

try {
        $conn = mysqli_connect("localhost", "root", "", "boq");

    $type = $_POST['type'];
    $subcategory_id = (int)$_POST['subcategory_id'];
    $field_type = $_POST['field_type'];
    $value = $_POST['value'];
    $cost = isset($_POST['cost']) ? (float)$_POST['cost'] : null; // Cast to float if provided

    // Define allowed field types for security
    $allowed_fields = ['SubcategoryName', 'SubcategoryUnit', 'SubcategoryQty', 'SubcategoryRate'];
    if (!in_array($field_type, $allowed_fields)) {
        die(json_encode(['status' => 'error', 'message' => 'Invalid field type']));
    }

    if ($type === 'update_subcategory') {

        if ($cost !== null) {
            // If cost is provided, update both the specified field and cost
            $sql = "UPDATE tblboqsubcategory SET $field_type = '$value', SubcategoryCost = $cost WHERE BoqSubcategoryID = $subcategory_id";
        } else {

            $sql = "UPDATE tblboqsubcategory SET $field_type = '$value' WHERE BoqSubcategoryID = $subcategory_id";
        }

        if ($conn->query($sql)) {
            // Fetch the updated data to return
            $sql = "SELECT * FROM tblboqsubcategory WHERE BoqSubcategoryID = '$subcategory_id'";

            $result = mysqli_query($conn,$sql);
            if ($result) {
                $updatedSubcategory = $result->fetch_assoc(); // Use fetch_assoc for MySQLi
                echo json_encode(['status' => 'success', 'updatedSubcategory' => $updatedSubcategory]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to fetch updated subcategory']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update subcategory']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>