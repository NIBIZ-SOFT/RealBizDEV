<?php
        $conn = mysqli_connect("localhost", "root", "", "boq");    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
include 'ajax-load-project-data.php';
if (isset($_POST['BoqID'])) {
    $BoqID = $_POST['BoqID'];

    mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

    try {
        // Step 1: Copy the Project
        $sql = "SELECT * FROM tblboq WHERE BoqID = '$BoqID'";
        $result = mysqli_query($conn, $sql);

        if ($originalProject = mysqli_fetch_assoc($result)) {
            $newProjectName = $originalProject['ProjectName'] . " (Copy)";
            $newBOQTitle = $originalProject['BOQTitle'];
            $newDateUpdated = date("Y-m-d H:i:s");

            $insertProjectSql = "INSERT INTO tblboq (ProjectName, BOQTitle, DateUpdated) 
                                 VALUES ('$newProjectName', '$newBOQTitle', '$newDateUpdated')";

            if (!mysqli_query($conn, $insertProjectSql)) {
                throw new Exception("Error copying project: " . mysqli_error($conn));
            }

            $newBoqID = mysqli_insert_id($conn); // Get the new Project ID

            // Step 2: Copy Categories for the New Project
            $categorySql = "SELECT * FROM tblboqcategory WHERE BoqID = '$BoqID'";
            $categoryResult = mysqli_query($conn, $categorySql);

            while ($category = mysqli_fetch_assoc($categoryResult)) {
                $newCategoryName    = $category['CategoryName'];
                $newDateInserted    = date("Y-m-d H:i:s");

                $insertCategorySql = "INSERT INTO tblboqcategory (CategoryName, DateInserted, BoqID)
                                      VALUES ('$newCategoryName', '$newDateInserted', '$newBoqID')";

                if (!mysqli_query($conn, $insertCategorySql)) {
                    throw new Exception("Error copying category: " . mysqli_error($conn));
                }

                $newCategoryID = mysqli_insert_id($conn); // Get the new Category ID

                // Step 3: Copy Subcategories for the New Category
                $subcategorySql     = "SELECT * FROM tblboqsubcategory WHERE BoqCategoryID = '{$category['BoqCategoryID']}'";
                $subcategoryResult  = mysqli_query($conn, $subcategorySql);

                while ($subcategory = mysqli_fetch_assoc($subcategoryResult)) {
                    $newSubcategoryName     = $subcategory['SubcategoryName'];
                    $newSubcategoryUnit     = $subcategory['SubcategoryUnit'];
                    $newSubcategoryQty      = $subcategory['SubcategoryQty'];
                    $newSubcategoryRate     = $subcategory['SubcategoryRate'];
                   // $newSubcategoryCost   = $subcategory['SubcategoryCost'];
                    $newSubcategoryDateInserted = date("Y-m-d H:i:s");
//  SubcategoryCost   '$newSubcategoryCost',
                    $insertSubcategorySql   = "INSERT INTO tblboqsubcategory (
                        BoqCategoryID, SubcategoryName, SubcategoryUnit, SubcategoryQty, SubcategoryRate, DateInserted
                    ) VALUES (
                        '$newCategoryID', '$newSubcategoryName', '$newSubcategoryUnit', '$newSubcategoryQty', '$newSubcategoryRate', '$newSubcategoryDateInserted'
                    )";
                    if (!mysqli_query($conn, $insertSubcategorySql)) {
                        throw new Exception("Error copying subcategory: " . mysqli_error($conn));
                    }
                }
            }
            // Commit the transaction if all operations succeed
            mysqli_commit($conn);

            $data = [
                "success" => true,
                "message" => "Project and all related categories and subcategories copied successfully!",
                "loadedHTML" => loadProjectData($conn)
            ];
            echo json_encode($data);
            exit;
        } else {
            $data = [
                "success" => false,
                "message" => "Original project not found.",
                "loadedHTML" => loadProjectData($conn)
            ];
            echo json_encode($data);
            exit;

        }
    } catch (Exception $e) {
        // Roll back the transaction if any error occurs
        mysqli_rollback($conn);
        $data = [
            "success" => false,
            "message" => "Failed to copy project data: " . $e->getMessage(),
            "loadedHTML" => loadProjectData($conn)
        ];
        echo json_encode($data);
        exit;
    }
} else {
    $data = [
        "success" => false,
        "message" => "No project ID specified.",
        "loadedHTML" => loadProjectData($conn)
    ];
    echo json_encode($data);
    exit;
}
mysqli_close($conn);
