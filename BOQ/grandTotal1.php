<?php
header('Content-Type: application/json');

// ✅ No need to connect again. Assuming mysql_connect() is already done.
function grandTotal($BoqID) {

    $GrandTotalCost = 0.00;

    $categoryResult = mysql_query("SELECT * FROM tblboqcategory WHERE BoqID = '$BoqID'");

    while ($category = mysql_fetch_array($categoryResult)) {

        $boqCategoryID = $category['BoqCategoryID'];

        $subResult = mysql_query("SELECT * FROM tblboqsubcategory WHERE BoqCategoryID = '$boqCategoryID'");

        if ($subResult && mysql_num_rows($subResult) > 0) {
            while ($row = mysql_fetch_array($subResult)) {
                $Cost = $row["SubcategoryQty"] * $row["SubcategoryRate"];
                $GrandTotalCost += $Cost;
            }
        }
    }

    return $GrandTotalCost;
}
?>
