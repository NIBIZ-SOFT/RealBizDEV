<?php


// DB connection include
include "ajax-load-data.php";

// Always set the response header to JSON
header('Content-Type: application/json');

// Ensure $_POST['type'] is set
if (!isset($_POST['type'])) {
    echo json_encode(['status' => 'error', 'message' => 'Request type not specified']);
    exit;
}

$type = $_POST['type'];

if ($type == 'category') {
    $BoqID = $_POST['BoqID'] ?? null;

    if (!$BoqID) {
        echo json_encode(['status' => 'error', 'message' => 'BoqID is missing']);
        exit;
    }

    $sql = "INSERT INTO tblboqcategory (BoqID) VALUES ('$BoqID')";
    if (mysqli_query($conn, $sql)) {
        $insertedCategoryId = mysqli_insert_id($conn);
        echo json_encode([
            'success' => true,
            'BoqID' => $BoqID,
            'category_id' => $insertedCategoryId
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Database insert failed']);
    }
    exit;
}

// Category update
if ($type == 'category_update') {
    $categoryName  = $_POST['CategoryName'] ?? null;
    $BoqCategoryId = $_POST['BoqCategoryID'] ?? null;

    if (!$categoryName || !$BoqCategoryId) {
        echo json_encode(['status' => 'error', 'message' => 'Missing data']);
        exit;
    }

    $sql = "UPDATE tblboqcategory SET CategoryName = '$categoryName' WHERE BoqCategoryId = $BoqCategoryId";
    if (mysqli_query($conn, $sql)) {
        $category_sql = "SELECT CategoryName FROM tblboqcategory WHERE BoqCategoryID = $BoqCategoryId";
        $result = mysqli_query($conn, $category_sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo json_encode([
                'success' => true,
                'message' => 'Category updated and fetched successfully.',
                'CategoryName' => $row['CategoryName']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Category updated but fetch failed.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Update failed']);
    }
    exit;
}

// If none of the above types matched
echo json_encode(['status' => 'error', 'message' => 'Invalid request type']);
exit;
?>
