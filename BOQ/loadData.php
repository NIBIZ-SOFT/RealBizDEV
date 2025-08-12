<?php
        $conn = mysqli_connect("localhost", "root", "", "boq");    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    include "ajax-load-data.php";


    $loadDataAsHTML = loadData($conn);

    $data["success"]          = true;
    $data["loadedHTML"]       = $loadDataAsHTML;

    echo json_encode($data);
?>
