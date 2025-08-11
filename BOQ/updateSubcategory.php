<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "boq";



try {
        $conn = mysqli_connect("localhost", "root", "", "boq");
    include "grandTotal1.php";

    if($_POST["BoqSubCategoryID"]){
        $BoqID = $_POST["BoqID"];
        $BoqCategoryID = $_POST["BoqCategoryID"];
        $BoqSubCategoryID   = $_POST["BoqSubCategoryID"];
        $dynamicColumnName  = $_POST["SubCategoryColumnName"];
        $dynamicColumnValue = $_POST["SubCategoryInputValue"];

        $updateQuery = "UPDATE tblboqsubcategory SET $dynamicColumnName='$dynamicColumnValue' WHERE BoqSubcategoryID='$BoqSubCategoryID'";

       // $GrandTotalCost = 0;

        if (mysqli_query($conn, $updateQuery)) {
            $insertedCategoryId = mysqli_insert_id($conn);
            $data['message2'] = "SubCategory update successfully.";

             $getSubData_sql = "SELECT * FROM tblboqsubcategory WHERE BoqSubCategoryID = '$BoqSubCategoryID'";

             $result = mysqli_query($conn, $getSubData_sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

//                $unit = '';
//
//                if (isset($row['SubcategoryUnit'])) {
//                    if ($row['SubcategoryUnit'] === 'm3' || $row['SubcategoryUnit'] === 'M3' || $row['SubcategoryUnit'] === 'm^3' || $row['SubcategoryUnit'] === 'M^3') {
//                        $unit = "&#179";
//                    } else {
//                        $unit = $row['SubcategoryUnit'];
//                    }
//                }
                $data['message2'] = "SubCategory fetch successfully.";
                $data["success"] = true;
                $data["SubcategoryName"]    = $row["SubcategoryName"] ? $row["SubcategoryName"] : "";
                $data["SubcategoryUnit"]    = $row["SubcategoryUnit"] ? $row["SubcategoryUnit"] : "";
                $data["SubcategoryQty"]     =  $row["SubcategoryQty"] === null ?  '' : $row["SubcategoryQty"];
                $data["SubcategoryRate"]    = $row["SubcategoryRate"] ? $row["SubcategoryRate"] : "";
                $cost = $row["SubcategoryQty"] && $row["SubcategoryRate"] ? $data["SubcategoryQty"] * $data["SubcategoryRate"] : 0.00;
                $data["SubcategoryCost"]    = number_format($cost, 2);


                $sub_Query = "SELECT SubcategoryQty, SubcategoryRate FROM tblboqsubcategory WHERE BoqCategoryID='$BoqCategoryID'";

                $result = mysqli_query($conn, $sub_Query);

                $totalCost = 0;
                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $Cost = $row["SubcategoryQty"] * $row["SubcategoryRate"];
                            $totalCost += $Cost;
                        }
                }

                $data["TotalCosts"] = $totalCost;


                 // Find GranTotal According to BoqID
//                $data["GrandTotalCost"] = 0;
            } else {
                $data["success"] = false;
                $data["message"] = "No subcategory found.";
                echo json_encode($data);
            }
          $data["GrandTotalCost"] = grandTotal($conn,$BoqID);
            echo json_encode($data);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
}
catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}






//
//if (mysqli_num_rows($checkSubcategory) > 0) {
//
//$SubSql = "SELECT SubcategoryQty, SubcategoryRate FROM tblboqsubcategory where BoqCategoryID='$BoqCategoryID'";
//
//$result = mysqli_query($conn, $SubSql);

?>



