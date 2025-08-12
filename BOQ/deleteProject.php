<?php

// Database connection
    $conn = mysqli_connect("localhost", "root", "", "boq");if (!$conn) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . mysqli_connect_error()]);
    exit;
}

include 'ajax-load-project-data.php';

if (isset($_POST['BoqID'])) {
    $BoqID = $_POST['BoqID'];

    // Start transaction
    mysqli_begin_transaction($conn);

    // Check if project exists
    $sql = "SELECT * FROM tblboq WHERE BoqID='$BoqID'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $checkCategory = mysqli_query($conn, "SELECT * FROM tblboqcategory WHERE BoqID='$BoqID'");
        if (mysqli_num_rows($checkCategory) > 0) {
            while ($row = mysqli_fetch_assoc($checkCategory)) {
                $boqCategoryID = $row['BoqCategoryID'];

                // Delete associated subcategories
                $checkSubcategory = mysqli_query($conn, "SELECT * FROM tblboqsubcategory WHERE BoqCategoryID='$boqCategoryID'");
                if (mysqli_num_rows($checkSubcategory) > 0) {
                    $sqlSub = "DELETE FROM tblboqsubcategory WHERE BoqCategoryID='$boqCategoryID'";
                    if (!mysqli_query($conn, $sqlSub)) {
                        mysqli_rollback($conn);
                        $data = [
                            "success" => false,
                            "message" => "Failed to delete subcategories: " . mysqli_error($conn),
                            "loadedHTML" => loadProjectData($conn) // Load updated data
                        ];
                        echo json_encode($data);
                        exit;
                    }
                }

                // Delete category
                $sqlCat = "DELETE FROM tblboqcategory WHERE BoqCategoryID='$boqCategoryID'";
                if (!mysqli_query($conn, $sqlCat)) {
                    mysqli_rollback($conn);
                   $data = [
                        "success" => false,
                        "message" => "Failed to delete category: " . mysqli_error($conn),
                        "loadedHTML" => loadProjectData($conn)
                    ];
                    echo json_encode($data);
                    exit;
                }
            }
        }

        // Delete project
        $sqlProject = "DELETE FROM tblboq WHERE BoqID='$BoqID'";
        if (mysqli_query($conn, $sqlProject)) {
            mysqli_commit($conn);
            $data = [
                "success" => true,
                "message" => "Project and related records deleted successfully.",
                "loadedHTML" => loadProjectData($conn) // Load updated data
            ];
            echo json_encode($data);
            exit;
        } else {
            mysqli_rollback($conn);
            $data = [
                "success" => false,
                "message" => "Failed to delete project: " . mysqli_error($conn),
                "loadedHTML" => loadProjectData($conn)
            ];
            echo json_encode($data);
            exit;
        }
    } else {
        // Project not found
        $data = [
            "success" => false,
            "message" => "Project not found",
            "loadedHTML" => loadProjectData($conn)
        ];
        echo json_encode($data);
        exit;
    }
} else {
    $data = [
        "success" => false,
        "message" => "Project ID not provided",
        "loadedHTML" => loadProjectData($conn)
    ];
    echo json_encode($data);
    exit;
}

mysqli_close($conn);
