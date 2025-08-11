 <?php
// header('Content-Type: application/json');

// // Simulated POST values for testing (you can remove these in production)
// // $_POST['ProjectID'] = 2;
// // $_POST['projectName'] = "fsdsdf";
// // $_POST['boqTitle'] = "BOQ 01";
// // $_POST['dateInserted'] = date('Y-m-d');

// Dummy DB connection (replace with your credentials)
// mysql_connect("localhost", "username", "password") or die("Could not connect to DB");
// mysql_select_db("your_database_name") or die("Could not select DB");

// // Read POST values
// $projectValue = isset($_POST['projectValue']) ? $_POST['projectValue'] : null;
// $columnName = isset($_POST['columnName']) ? $_POST['columnName'] : null;
// $BoqID = isset($_POST['BoqID']) ? intval($_POST['BoqID']) : null;

// if ($BoqID) {
//     // ✅ UPDATE
//     $projectValue = mysql_real_escape_string($projectValue);
//     $columnName = mysql_real_escape_string($columnName);
//     $BoqID = intval($BoqID);

//     $updateSQL = "UPDATE tblboq SET `$columnName` = '$projectValue' WHERE BoqID = $BoqID";
//     $success = mysql_query($updateSQL);

//     if ($success) {
//         echo json_encode(["status" => "success", "message" => "Updated successfully"]);
//     } else {
//         echo json_encode(["status" => "error", "message" => mysql_error()]);
//     }

// } else {
//     // ✅ INSERT
//     $ProjectID = intval($_POST['ProjectID']);
//     $projectName = isset($_POST['projectName']) ? mysql_real_escape_string($_POST['projectName']) : null;
//     $boqTitle = isset($_POST['boqTitle']) ? mysql_real_escape_string($_POST['boqTitle']) : null;
//     $dateInserted = isset($_POST['dateInserted']) ? mysql_real_escape_string($_POST['dateInserted']) : null;

//     if (!$projectName || !$boqTitle || !$dateInserted) {
//         echo json_encode(["status" => "error", "message" => "Missing required fields for insertion"]);
//         exit;
//     }

//     $insertSQL = "INSERT INTO tblboq (ProjectName, ProjectID, BOQTitle, DateInserted) 
//                   VALUES ('$projectName', '$ProjectID', '$boqTitle', '$dateInserted')";

//     $success = mysql_query($insertSQL);

//     if ($success) {
//         $BoqID = mysql_insert_id(); // ✅ get inserted ID

//         echo json_encode([
//             "status" => "success",
//             "BoqID" => $BoqID,
//             "projectName" => $projectName,
//             "BOQTitle" => $boqTitle,
//             "DateInserted" => $dateInserted
//         ]);
//     } else {
//         echo json_encode(["status" => "error", "message" => mysql_error()]);
//     }
// }




 header("Content-Type: application/json");

// Simulate POST (production এ এই অংশ মুছে দিন)
// $_POST['ProjectID'] = 2;
// $_POST['projectName'] = "fsdsdf";
// $_POST['boqTitle'] = 1;
// $_POST['dateInserted'] = date('Y-m-d');
// $_POST['ProjectUUID'] = uniqid(); // যদি UUID লাগে

// Dummy DB connection (replace with your credentials)
// mysql_connect("localhost", "username", "password") or die("Could not connect to DB");
// mysql_select_db("your_database_name") or die("Could not select DB");

// Read POST values
$projectValue = isset($_POST['projectValue']) ? $_POST['projectValue'] : null;
$columnName = isset($_POST['columnName']) ? $_POST['columnName'] : null;
$BoqID = isset($_POST['BoqID']) ? intval($_POST['BoqID']) : null;

if ($BoqID) {
    // ✅ UPDATE
    $projectValue = mysql_real_escape_string($projectValue);
    $columnName = mysql_real_escape_string($columnName);
    $BoqID = intval($BoqID); // always sanitize IDs

    $updateSQL = "UPDATE tblboq SET `$columnName` = '$projectValue' WHERE BoqID = $BoqID";
    $success = mysql_query($updateSQL);

} else {
    // ✅ INSERT
    $ProjectID = $_POST['ProjectID'];
    $projectName = isset($_POST['projectName']) ? mysql_real_escape_string($_POST['projectName']) : null;
    $boqTitle = isset($_POST['boqTitle']) ? mysql_real_escape_string($_POST['boqTitle']) : null;
    $dateInserted = isset($_POST['dateInserted']) ? mysql_real_escape_string($_POST['dateInserted']) : null;
    $ProjectUUID = isset($_POST['ProjectUUID']) ? mysql_real_escape_string($_POST['ProjectUUID']) : uniqid();

    if (!$projectName || !$boqTitle || !$dateInserted) {
        echo json_encode(["status" => "error", "message" => "Missing required fields for insertion"]);
        exit;
    }

    // যদি আপনি ProjectUUID ডাটাবেজে ইনসার্ট করতে চান, তাহলে SQL-এ যুক্ত করুন
    $insertSQL = "INSERT INTO tblboq (ProjectName, ProjectID, BOQTitle, DateInserted, ProjectUUID)
                  VALUES ('$projectName', '$ProjectID', '$boqTitle', '$dateInserted', '$ProjectUUID')";
    $success = mysql_query($insertSQL);
    $BoqID = mysql_insert_id(); // ✅ Insert সফল হলে এখানে ID পাওয়া যাবে

    if ($success) {
        echo json_encode([
            "success" => true,
            "BoqID" => $BoqID,
            "ProjectUUID" => $ProjectUUID,
            "projectName" => $projectName,
            "BOQTitle" => $boqTitle,
            "DateInserted" => $dateInserted
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => mysql_error()]);
    }
} 

?>