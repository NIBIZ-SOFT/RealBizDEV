<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryId = $_POST['category_id'];
    $BoqID = $_POST['project_id'];
    
    if (!empty($categoryId)) {
        // First delete all subcategories
        $deleteSubcategoriesSQL = "DELETE FROM tblboqsubcategory WHERE BoqCategoryID = ?";
        $stmt = $conn->prepare($deleteSubcategoriesSQL);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        
        // Then delete the category
        $deleteCategorySQL = "DELETE FROM tblboqcategory WHERE BoqCategoryID = ? AND BoqID = ?";
        $stmt = $conn->prepare($deleteCategorySQL);
        $stmt->bind_param("ii", $categoryId, $BoqID);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Category and all its subcategories deleted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error deleting category']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Category ID is required']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
} 