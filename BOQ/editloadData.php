<?php
// Database connection
    $conn = mysqli_connect("localhost", "root", "", "boq");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
include "ajax-load-data.php";
// Check if 'BoqID' parameter is in the URL
if(isset($_GET['BoqID'])) {
    $BoqID = intval($_GET['BoqID']); // Convert to integer for security
    $project_sql = "SELECT * FROM tblboq WHERE BoqID = $BoqID";
    $result = mysqli_query($conn, $project_sql);

    // Check if the query succeeded and if there are any results
    if ($result && mysqli_num_rows($result) > 0) {
        $project = mysqli_fetch_assoc($result);
        $data = [
            'success' => true,
            'BoqID' => $project['BoqID'],
            'ProjectName' => $project['ProjectName'],
            'BOQTitle' => $project['BOQTitle'],
            'DateInserted' => $project['DateInserted']
        ];

        // Call loadData function and capture its HTML output
        $loadHTML = loadData($conn, $BoqID);
        $data['LoadHTML'] = $loadHTML;

        echo json_encode($data);
    } else {
        // Handle no results found
        $data = [
            'error' => true,
            'message' => 'No project found with the specified ID.'
        ];
        echo json_encode($data);
    }
} else {
    // Handle missing BoqID parameter
    $data = [
        'error' => true,
        'message' => 'Project ID is required.'
    ];
    echo json_encode($data);
}

