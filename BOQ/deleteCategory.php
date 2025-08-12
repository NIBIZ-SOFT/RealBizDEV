<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
    $conn = mysqli_connect("localhost", "root", "", "boq");
if (!$conn) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . mysqli_connect_error()]);
    exit;
}

if (isset($_POST['category_id']) && isset($_POST['BoqID'])) {
    $BoqCategoryID = (int) $_POST['category_id'];
    $BoqID = (int) $_POST['BoqID'];

    // 1. Delete the category
    $deleteCategorySQL = "DELETE FROM tblboqcategory WHERE BoqCategoryID = $BoqCategoryID";
    $deletedCategory = mysqli_query($conn, $deleteCategorySQL);

    if ($deletedCategory) {
        // 2. Check if any subcategories still exist (shouldn't if DB uses foreign keys with cascade)
        $checkSub = "SELECT COUNT(*) AS total FROM tblboqsubcategory WHERE BoqCategoryID = $BoqCategoryID";
        $result = mysqli_query($conn, $checkSub);
        $row = mysqli_fetch_assoc($result);

        // 3. If subcategories still exist (not expected), delete them
        if ($row && $row['total'] > 0) {
            $deleteSubs = "DELETE FROM tblboqsubcategory WHERE BoqCategoryID = $BoqCategoryID";
            mysqli_query($conn, $deleteSubs);
        }

        // 4. Return updated HTML

        echo json_encode([
            "success" => true
          
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "error" => mysqli_error($conn)
        ]);
    }
}

mysqli_close($conn);
?>
