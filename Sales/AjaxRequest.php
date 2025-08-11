<?php

if (isset($_POST["id"])){
    $CategoryID=$_POST["id"];
    $allProductByCategories=SQL_Select("Products where CategoryID={$CategoryID}");
    echo json_encode($allProductByCategories);

}

if (isset($_POST["CatID"])){
    //echo $_POST["CatID"];
    $allProductByCategories=SQL_Select("sales where CustomerID={$_POST["CatID"]}");
    echo json_encode($allProductByCategories);

}

if (isset($_POST['CatID'])) {
    $customerID = intval($_POST['CatID']);

    // Get Sales for this customer
    $sales = SQL_Select("Sales", "CustomerID = $customerID", "SaleID DESC");

    $result = [];
    foreach ($sales as $row) {
        $result[] = [
            "SaleID" => $row["SaleID"]
        ];
    }

    echo json_encode($result);
    exit;
}



if (isset($_POST["CatID_Division"])){
    //echo $_POST["CatID"];
    $allProductByCategories=SQL_Select("sales where CustomerID={$_POST["CatID_Division"]}");
    echo json_encode($allProductByCategories);

}

if (isset($_POST["ProductsID"])){
    $ProductsID=$_POST["ProductsID"];
    $allProductByCategories=SQL_Select("Products where ProductsID={$ProductsID}");
    echo json_encode($allProductByCategories);
}

if (isset($_POST['action']) && $_POST['action'] === 'get_products_by_sale' && isset($_POST['ProductsID'])) {
    $saleId = intval($_POST['ProductsID']);

    // First get the sale to find customer and product IDs
    $sale = SQL_Select("Sales", "SaleID = $saleId", "", true);

    if ($sale) {
        // Get all products for this sale (assuming there's a SalesProducts table)
        // Or if products are stored in a different way, adjust this query
        $products = SQL_Select("SalesProducts sp JOIN Products p ON sp.ProductsID = p.ProductsID",
            "sp.SaleID = $saleId");

        echo json_encode($products);
    } else {
        echo json_encode([]);
    }
    exit;
}
?>



