<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

// The default value of the input box will goes here according to how many fields we showing
$TheEntityName = array(

    "ProjectID" => "",
    "BankCashID" => "1",
    "HeadOfAccountID" => "",
    "VoucherNo" => "",
    "dr" => "",
    "cr" => "",
    "Name" => "0",

    "{$Entity}IsActive" => 1,
    "{$Entity}IsDisplay" => 1
);

if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"]) && !isset($_REQUEST["DeleteConfirm"])) {
    $UpdateMode = true;
    $FormTitle = "Update $EntityCaption";
    $ButtonCaption = "Update";
    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction", $Entity . "ID={$_REQUEST[$Entity."ID"]}&" . $Entity . "UUID={$_REQUEST[$Entity."UUID"]}");
    if ($UpdateMode && !isset($_POST["" . $Entity . "ID"])) $TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy = "{$OrderByValue}", $SingleRow = true);


    // if($TheEntityName["{$Entity}IsDisplay"]==0){

    //     header("location:index.php?Theme=default&Base={$Entity}&Script=Manage");

    // }


}

$htmlProductSelect = "";
if ($UpdateMode) {
    $id = $TheEntityName["ProductsID"];

    $Products = SQL_Select("products where ProductsID=" . $id);
    $floorNumber = $Products[0]["FloorNumber"];
    $flatType = $Products[0]["FlatType"];

    $ProductName = $floorNumber . "-" . $flatType;

    $productOption="";

    $productOption='<option selected value="'.$id.'">'.$ProductName.'</option>';


}




$customerSelected="";
$others="";

if ($TheEntityName["Type"]==1){
    $customerSelected="selected";
}elseif ($TheEntityName["Type"]==2){
    $others="selected";
}


//echo "<pre>";
//print_r($TheEntityName);
//die();

// Input sytem display goes here
$Input = array();

// Project Name (always visible)
$Input[] = array("VariableName" => "ProjectName", "Caption" => "Project Name", "ControlHTML" => CCTL_ProductsCategory($Name = "ProjectID", $TheEntityName["ProjectID"], $Where = "", $PrependBlankOption = true, "required"));

// Type selector
$Input[] = array("VariableName" => "Type", "Caption" => "Type", "ControlHTML" => '
<select name="Type" id="TypeSelector" class="form-select" required> 
    <option value="0">Select Type</option>
    <option '.$customerSelected.' value="1">Customer</option>
    <option '.$others.' value="2">Others</option>
</select>');

// Name field (visible only when Type=Others)
$nameFieldStyle = ($TheEntityName["Type"] == 2) ? '' : 'style="display:none;"';
$Input[] = array("VariableName" => "Name", "Caption" => "Name", "ControlHTML" => CTL_InputText($Name = "Name", $TheEntityName["Name"], "", 30, "required"), "RowAttributes" => $nameFieldStyle);

// Customer-related fields (visible only when Type=Customer)
$customerFieldsStyle = ($TheEntityName["Type"] == 1) ? '' : 'style="display:none;"';

// Customer dropdown
$Input[] = array(
    "VariableName" => "CustomerID",
    "Caption" => "Customer Name",
    "ControlHTML" => CCTL_Customer(
        $Name = "CustomerID",
        $ValueSelected = $TheEntityName["CustomerID"],
        $Where = "",
        $PrependBlankOption = true
    ),
    "RowAttributes" => $customerFieldsStyle
);

// Sanitize and validate inputs
$salesID = isset($TheEntityName["SalesID"]) ? intval($TheEntityName["SalesID"]) : 0;
$customerID = isset($TheEntityName["CustomerID"]) ? intval($TheEntityName["CustomerID"]) : 0;
$productID = isset($TheEntityName["ProductsID"]) ? intval($TheEntityName["ProductsID"]) : 0;

$sale = SQL_Select("Sales", "SalesID = {$salesID} AND CustomerID = {$customerID} AND ProductID = {$productID}", "", true);

// Sale dropdown
$saleOptions = '<select id="SaleID" name="SaleID" class="form-select">';
if ($saleID) {
    $saleOptions .= '<option value="' . $saleID . '">' . $saleID . '</option>';
} else {
    $saleOptions .= '<option value="0">-- Select Sale. --</option>';
}
if ($UpdateMode && $TheEntityName["Type"] == 1 && !empty($TheEntityName["SaleID"])) {
    $saleOptions .= '<option value="' . htmlspecialchars($TheEntityName["SaleID"]) . '" selected>' . 
                    htmlspecialchars($TheEntityName["SaleID"]) . '</option>';
} elseif ($UpdateMode && !empty($sale)) {
    $saleOptions .= '<option value="' . htmlspecialchars($sale["SalesID"]) . '" selected>' . 
                    htmlspecialchars($sale["SalesID"]) . '</option>';
}

$saleOptions .= '</select>';

$Input[] = array(
    "VariableName" => "SaleID",
    "Caption" => "Sale ID",
    "ControlHTML" => $saleOptions,
    "RowAttributes" => $customerFieldsStyle
);


// Product dropdown
$productOptions = '<select id="Product" name="ProductsID" class="form-select">';
$productOptions .= '<option value="0">-- Select Product --</option>';
if ($UpdateMode && $TheEntityName["Type"] == 1 && !empty($TheEntityName["ProductsID"])) {
    $id = $TheEntityName["ProductsID"];
    $Products = SQL_Select("products where ProductsID=" . $id);
    if (!empty($Products)) {
        $floorNumber = $Products[0]["FloorNumber"];
        $flatType = $Products[0]["FlatType"];
        $ProductName = $floorNumber . "-" . $flatType;
        $productOptions .= '<option selected value="'.$id.'">'.$ProductName.'</option>';
    }
}
$productOptions .= '</select>';

$Input[] = array(
    "VariableName" => "ProductsID",
    "Caption" => "Product",
    "ControlHTML" => $productOptions,
    "RowAttributes" => $customerFieldsStyle
);

// Term dropdown
$termOptions = '';
$term = SQL_Select("Term");
foreach ($term as $row) {
    $selected = ($row["TermID"] == $TheEntityName["TermID"]) ? 'selected' : '';
    $termOptions.= '<option value="' . $row["Name"] . '" ' . $selected . '>' . $row["Name"] . '</option>';
}
//$termOptions .= '</select>';

$Input[]=array("VariableName"=>"VendorName","Caption"=>"Title","ControlHTML"=>'
	<select class="form-select" name="Title">
		'.$termOptions.'
	</select>

');


$Input[] = array("VariableName" => "BankCashID", "Caption" => "Cash Type", "ControlHTML" => CCTL_BankCash($Name = "BankCashID", $TheEntityName["BankCashID"], $Where = "", $PrependBlankOption = false));
$Input[] = array("VariableName" => "checkNumberArea", "Caption" => "Cheque Number", "ControlHTML" => CTL_InputText($Name = "ChequeNumber", $TheEntityName["ChequeNumber"], "", 30, "required"));
$Input[] = array("VariableName" => "HeadOfAccountID", "Caption" => "Head Of Account", "ControlHTML" => GetExpenseID($Name = "HeadOfAccountID", $TheEntityName["HeadOfAccountID"], $Where = "", $PrependBlankOption = true));

$Settings = SQL_Select("Settings", "", "", true);
$Divitions = explode(",", $Settings["Division"]);
$DivitionList = array();
foreach ($Divitions as $Divition) {
    $DivitionList[] = array(
        "value" => $Divition,
        "text" => $Divition
    );
}
$Input[] = array("VariableName" => "Division", "Caption" => "Division", "ControlHTML" => '
<select class="form-select" name="Division" id="Division">
    <option value="" disabled selected>Select Division</option>' .
    implode('', array_map(function($option) use ($TheEntityName) {
        return '<option value="' . htmlspecialchars($option['value']) . '" ' . ($TheEntityName["Division"] == $option['value'] ? 'selected' : '') . '>' . htmlspecialchars($option['text']) . '</option>';
    }, $DivitionList)) .
    '</select>');

$Input[] = array("VariableName" => "BillNo", "Caption" => "M.R/Bill No", "ControlHTML" => CTL_InputText($Name = "BillNo", $TheEntityName["BillNo"], "", 30, "required"));

$Input[] = array("VariableName" => "Date", "Caption" => "Date", "ControlHTML" => CTL_InputTextDate("Date", $TheEntityName["Date"], "", 30, "required"));
$Input[] = array("VariableName" => "Amount", "Caption" => "Amount", "ControlHTML" => CTL_InputNumber("Amount", $TheEntityName["Amount"], "", 30, "required"));
//$Input[] = array("VariableName" => "BankCharge", "Caption" => "Bank Charge (-)", "ControlHTML" => CTL_InputText("BankCharge", $TheEntityName["BankCharge"], "", 30, "required"));
$Input[] = array("VariableName" => "Description", "Caption" => "Particulars", "ControlHTML" => CTL_InputTextArea("Description", $TheEntityName["Description"], "", 5, "required"));

$Input[] = array("VariableName" => "ProductsImage", "Caption" => "Image", "ControlHTML" => CTL_ImageUpload($ControlName = "Image", $CurrentImage01 = $TheEntityName["Image"], $AllowDelete = true, $Class = "FormTextInput", $ThumbnailHeight = 100, $ThumbnailWidth = 0, $Preview = true));


$Input[] = array("VariableName" => "IsDisplay", "Caption" => "Confirm?", "ControlHTML" => CTL_InputRadioSet($VariableName = "{$Entity}IsDisplay", $Captions = array("No", "Yes"), $Values = array(1, 0), $CurrentValue = $TheEntityName["{$Entity}IsDisplay"]), "Required" => false);


$MainContent .= FormInsertUpdate(
    $EntityName = $EntityLower,
    $FormTitle,
    $Input,
    $ButtonCaption,
    $ActionURL
);


$MainContent .= '
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            console.log("Document ready"); // Debugging line
            // Function to toggle fields based on type
            function toggleFieldsByType() {
                var type = $("#TypeSelector").val();
                console.log("Type changed to: " + type); // Debugging line
                
                if (type === "1") { // Customer
                    $("[data-field-group=\'customer\']").show();
                    $("[data-field=\'Name\']").hide();
                } else if (type === "2") { // Others
                    $("[data-field-group=\'customer\']").hide();
                    $("[data-field=\'Name\']").show();
                } else {
                    $("[data-field-group=\'customer\'], [data-field=\'Name\']").hide();
                    console.log("Type changed to: " + type);
                }
            }
        
            
            $(document).on("change", "select[name=\'CustomerID\']", function() {
                var customerId = $(this).val();
                console.log("Customer changed to ID: " + customerId); // Debugging line

                var $saleSelect = $("select[name=\'SaleID\']");
                
                if (customerId > 0) {
                    console.log("Fetching sales for customer: " + customerId); // Debugging line
                    $.ajax({
                        url: window.location.href, // Use current page URL
                        method: "POST",
                        data: { 
                            action: "get_sales_by_customer",
                            CatID: customerId 
                        },
                        dataType: "json",
                        success: function(data) {
                            console.log("Received sales data:", data); // Debugging line
                            $saleSelect.empty().append("<option value=\'0\'>Select Sale</option>");
                            
                            if (data && data.length > 0) {
                                
                                $.each(data, function(index, sale) {
                                    $saleSelect.append($("<option></option>")
                                        .attr("value", sale.SalesID)
                                        .text(sale.SalesID));
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error); // Debugging line
                        }
                    });
                } else {
                    $saleSelect.empty().append("<option value=\'0\'>Select Sale</option>");
                    $("select[name=\'ProductsID\']").empty().append("<option value=\'0\'>-- Select Product --</option>");
                }
            });
            
            // Handle sale change - load products
            $(document).on("change", "select[name=\'SaleID\']", function() {
                var saleId = $(this).val();
                console.log("Sale changed to ID: " + saleId); // Debugging line
                
                var $productSelect = $("select[name=\'ProductsID\']");
                
                if (saleId > 0) {
                    console.log("Fetching products for sale: " + saleId); // Debugging line
                    $.ajax({
                        url: window.location.href,
                        method: "POST",
                        data: { 
                            action: "get_products_by_sale",
                            SaleID: saleId 
                        },
                        dataType: "json",
                        success: function(data) {
                            console.log("Received products data:", data); // Debugging line
                            $productSelect.empty().append("<option value=\'0\'>-- Select Product --</option>");
                            
                            if (data && data.length > 0) {
                                $.each(data, function(index, product) {
                                    var productName = product.FloorNumber + "-" + product.FlatType;
                                    $productSelect.append($("<option></option>")
                                        .attr("value", product.ProductsID)
                                        .text(productName));
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error); // Debugging line
                        }
                    });
                } else {
                    $productSelect.empty().append("<option value=\'0\'>-- Select Product --</option>");
                }
            });
            
            // Initialize
            toggleFieldsByType();
            $("#TypeSelector").on("change", toggleFieldsByType);
            
            // Trigger change if customer is pre-selected (edit mode)
            if ($("select[name=\'CustomerID\']").val() > 0) {
                $("select[name=\'CustomerID\']").trigger("change");
            }
        });

        var select = document.getElementById("TypeSelector"); 
        
    </script>
';

$MainContent.="
<script>
document.addEventListener('DOMContentLoaded', function () {
    var select = document.getElementById('TypeSelector');

    select.addEventListener('change', function () {
        var selectedValue = this.value;

        // Hide all controls first
        document.getElementById('Control_103').style.display = 'none';
        document.getElementById('Control_104').style.display = 'none';
        document.getElementById('Control_105').style.display = 'none';
        document.getElementById('Control_106').style.display = 'none';
        document.getElementById('Control_107').style.display = 'none';
        document.getElementById('SaleID').required = false;


        // Show only the selected control
        if (selectedValue === '1') {
            document.getElementById('Control_104').style.display = 'block';
            document.getElementById('Control_105').style.display = 'block';
            document.getElementById('Control_106').style.display = 'block';
            document.getElementById('Control_107').style.display = 'block';
            document.getElementById('SaleID').required = true;
            
        } else if (selectedValue === '2') {
            document.getElementById('Control_103').style.display = 'block';
        }
    });

    // Optional: trigger once on page load
    select.dispatchEvent(new Event('change'));
});
</script>


";
// AJAX handlers at the bottom of your script
if (isset($_POST['action'])) {
    if ($_POST['action'] === 'get_sales_by_customer' && isset($_POST['CatID'])) {
        $customerId = intval($_POST['CatID']);
        $sales = SQL_Select("Sales", "CustomerID = $customerId");
        echo json_encode($sales);
        exit;
    }
    elseif ($_POST['action'] === 'get_products_by_sale' && isset($_POST['SaleID'])) {
        $saleId = intval($_POST['SaleID']);
        $products = SQL_Select("Sales s
            JOIN tblproducts p ON s.ProductID = p.ProductsID
            WHERE s.SalesID = $saleId
        ");
        echo json_encode($products);
        exit;
    }
}

?>