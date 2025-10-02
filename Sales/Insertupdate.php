<?php
include "./script/{$_REQUEST['Base']}/Scriptvariables.php";

$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST['Base']}", "Insertupdateaction");

$TheEntityName = [
    "CustomerName" => "",
    "Address" => "",
    "Phone" => "",
    "CustomerEmail" => "",
    "{$Entity}IsActive" => 1
];

if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"]) && !isset($_REQUEST["DeleteConfirm"])) {
    $UpdateMode = true;
    $FormTitle = "Update $EntityCaption";
    $ButtonCaption = "Update";
    $ActionURL = ApplicationURL(
        "{$_REQUEST['Base']}",
        "Insertupdateaction",
        $Entity . "ID={$_REQUEST[$Entity.'ID']}&" . $Entity . "UUID={$_REQUEST[$Entity.'UUID']}"
    );
    if (!isset($_POST[$Entity . "ID"])) {
        $TheEntityName = SQL_Select($Entity, "{$Entity}ID = {$_REQUEST[$Entity.'ID']} AND {$Entity}UUID = '{$_REQUEST[$Entity.'UUID']}'", "{$OrderByValue}", true);
    }
}

$Settings = SQL_Select("Settings", "", "", true);
$Divitions = explode(",", $Settings["Division"]);
$DivitionList = array();
foreach ($Divitions as $Divition) {
    $DivitionList[] = array(
        "value" => $Divition,
        "text" => $Divition
    );
}


// print_r($TheEntityName['Division']);
$ProductNamex = SQL_Select("Products", "ProductsID = '" . $TheEntityName["ProductID"] . "'", "", true);
// print_r($ProductNamex);
$MainContent .= '
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">' . $FormTitle . '</h5>
    </div>
    <div class="card-body">
        <form action="' . $ActionURL . '" method="post" enctype="multipart/form-data" id="saleForm">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Division</label>
                    <select id="division" name="Division" class="form-select">
                        <option value="" disabled selected>Select Division</option>' .
                        implode('', array_map(function($option) use ($TheEntityName) {
                            return '<option value="' . htmlspecialchars($option['value']) . '" ' . ($TheEntityName["Division"] == $option['value'] ? 'selected' : '') . '>' . htmlspecialchars($option['text']) . '</option>';
                        }, $DivitionList)) .
                        '</select>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Customer</label>
                    ' . CCTL_Customer("CustomerID", $TheEntityName["CustomerID"], "", true) . '
                </div>

                <div class="col-md-4">
                    <label class="form-label">Project</label>
                    ' . CCTL_ProductsCategory("ProjectID", $TheEntityName["ProjectID"], "", true) . '
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Product</label>
                    <select name="ProductID" id="ProductID" class="form-select" required>
                        <option value="">-- Select Product --</option>
                        <option value="' . $TheEntityName["ProductID"] . '" selected>' . $ProductNamex["FloorNumber"] . "-" . $ProductNamex["FlatType"] . '</option>
                    </select>
                    <input type="hidden" name="ProductName" id="HideProductName" value="' . $TheEntityName["ProductName"] . '">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Seller</label>
                    ' . CCTL_SellerName("SalerNameID", $TheEntityName["SellerID"], "", true) . '
                </div>

                <div class="col-md-4">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="Quantity" class="form-control" value="' . $TheEntityName["Quantity"] . '" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Discount (Taka)</label>
                    <input type="number" name="Discount" class="form-control" value="' . $TheEntityName["Discount"] . '">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Sales Date</label>
                    <input type="date" name="SalesDate" class="form-control" value="' . $TheEntityName["SalesDate"] . '" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Upload Image</label>
                    ' . CTL_ImageUpload("Image", $TheEntityName["Image"], true, "form-control", 100, 0, true) . '
                </div>
                <div class="mb-3 product_type"></div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">' . $ButtonCaption . ' Sale Entry</button>
                </div>
            </div>

            

        </form>
    </div>
</div>';

$MainContent .= '
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(function() {
    // Log jQuery status
    if (typeof jQuery !== "undefined") {
        console.log("jQuery is loaded!");
    } else {
        console.log("jQuery is not loaded.");
    }

    // Handle project change
    $(document).on("change", "#ProjectID", function () {
        const projectID = $(this).val() || 0;
        console.log("Selected Project ID: ", projectID);  // Log the selected project ID

        $.post("./index.php?Theme=default&Base=Sales&Script=AjaxRequest&NoHeader&NoFooter", { id: projectID }, function (data) {
            console.log("Received data: ", data);  // Log the response data

            let options = "<option value=\'\'>-- Select Product --</option>";
            if (data?.length) {
                $.each(data, function (i, item) {
                    options += `<option value="${item.ProductsID}">${item.FloorNumber}-${item.FlatType}</option>`;
                });
            } else {
                options += "<option value=\'\'>No products available</option>";
            }
            $("#ProductID").html(options);  // Update the product dropdown with the options
        }, "json")
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error: " + textStatus + " - " + errorThrown);  // Log if the AJAX request fails
        });
    });
});
</script>';

?>