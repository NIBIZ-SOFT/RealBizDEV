<?php
header('Content-Type: application/json');

    $conn = mysqli_connect("localhost", "root", "", "boq");
if (!$conn) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . mysqli_connect_error()]);
    exit;
}

if(isset($_POST['BoqID'])){
    $BoqID = $_POST['BoqID'];
    $GrandTotalCost = 0;

    $sql = "SELECT * FROM tblboqcategory WHERE BoqID = '$BoqID'";

    $categoryResult = mysqli_query($conn, $sql);

    while ($category = mysqli_fetch_assoc($categoryResult)) {

        $boqCategoryID = $category['BoqCategoryID'];

        $SubSql = "SELECT * FROM tblboqsubcategory WHERE BoqCategoryID='$boqCategoryID'";

        $result = mysqli_query($conn, $SubSql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $Cost = $row["SubcategoryQty"] * $row["SubcategoryRate"];
                $GrandTotalCost += $Cost;
            }
        }
    }
    $data["success"] = true;
    $data["TotalCost"] = $GrandTotalCost;
    echo json_encode($data);
}
?>