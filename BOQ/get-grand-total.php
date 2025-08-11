<?php
include "config.php";
include "grandTotal1.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['project_id'])) {
    $BoqID = $_POST['project_id'];
    echo grandTotal($conn, $BoqID);
} else {
    echo "0.00";
} 