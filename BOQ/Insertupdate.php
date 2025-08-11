<?php
// Enable error reporting for debugging
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";
//echo  $Entity."ID";
//
//echo  $_REQUEST[$Entity."ID"];

$UpdateMode = false;
if (isset($_REQUEST[$Entity."ID"]) || isset($_REQUEST[$Entity."UUID"])) {
    $UpdateMode = true;

    echo $updateMode;
    $FormTitle = "Update $EntityCaption";
    $ButtonCaption = "Update";
    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction") . "&{$Entity}ID=" . intval($_REQUEST[$Entity . "ID"]) . "&{$Entity}UUID=" . addslashes($_REQUEST[$Entity . "UUID"]);
} else {
    $FormTitle = "Insert $EntityCaption";
    $ButtonCaption = "Insert";
    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");
}

// The default value of the input box will goes here according to how many fields we showing
$TheEntityName = SQL_Select($Entity, 'BoqID = ' . intval(isset($_REQUEST[$Entity . 'ID']) ? $_REQUEST[$Entity . 'ID'] : 0));
if ($TheEntityName && is_array($TheEntityName) && isset($TheEntityName[0])) {
    $TheEntityName = $TheEntityName[0];
}
if (!$TheEntityName || !is_array($TheEntityName)) {
    // default values for new entry
    $TheEntityName = array(
        'ProjectID' => 0,
        'BOQTitle' => '',
        'DateInserted' => date('Y-m-d'),
        $Entity . 'IsActive' => 1
    );
}


// --- Build $categoriesData for JS (PHP 5.6 compatible)
$categoriesData = array();
if ($UpdateMode && isset($_REQUEST[$Entity . 'ID'])) {
    $categories = SQL_Select('boqcategory', 'BoqID = ' . intval($_REQUEST[$Entity . 'ID']));
    if ($categories && is_array($categories)) {
        foreach ($categories as $cat) {
            $catData = array(
                'category_name' => isset($cat['CategoryName']) ? $cat['CategoryName'] : '',
                'sub' => array()
            );
            $subs = SQL_Select('boqsubcategory', 'BoqCategoryID = ' . intval(isset($cat['BoqCategoryID']) ? $cat['BoqCategoryID'] : 0));
            if ($subs && is_array($subs)) {
                foreach ($subs as $sub) {
                    $catData['sub'][] = array(
                        'subcategory_id' => isset($sub['SubcategoryID']) ? $sub['SubcategoryID'] : '',
                        'unit' => isset($sub['SubcategoryUnit']) ? $sub['SubcategoryUnit'] : '',
                        'qty' => isset($sub['SubcategoryQty']) ? $sub['SubcategoryQty'] : '',
                        'rate' => isset($sub['SubcategoryRate']) ? $sub['SubcategoryRate'] : '',
                        'cost' => isset($sub['SubcategoryCost']) ? $sub['SubcategoryCost'] : '',
                        'remarks' => isset($sub['SubcategoryName']) ? $sub['SubcategoryName'] : ''
                    );
                }
            }
            $categoriesData[] = $catData;
        }
    }
}

$Project = SQL_Select('category');
$Boqcategory = SQL_Select('incomeexpensetype');
$Boqsubcategory = SQL_Select('expensehead','ExpenseHeadIsStock=1');

$ProjectOptions = '';
foreach ($Project as $p) {
    $ProjectOptions .= '<option value="' . (isset($p['CategoryID']) ? $p['CategoryID'] : '') . '">' . htmlspecialchars(isset($p['Name']) ? $p['Name'] : '') . '</option>';
}

$CategoryOptions = '';
foreach ($Boqcategory as $c) {
    $CategoryOptions .= '<option value="' . (isset($c['IncomeExpenseTypeID']) ? $c['IncomeExpenseTypeID'] : '') . '">' . htmlspecialchars(isset($c['Name']) ? $c['Name'] : '') . '</option>';
}
$HeadOfAccount  =  SQL_Select("expensehead","ExpenseHeadIsActive=1");

$SubcategoryOptions = '';
foreach ($HeadOfAccount as $h) {
    $id = isset($h['ExpenseHeadID']) ? $h['ExpenseHeadID'] : '';
    $name = isset($h['ExpenseHeadName']) ? htmlspecialchars($h['ExpenseHeadName']) : '';
    $SubcategoryOptions .= '<option value="' . $id . '">' . $name . '</option>';
}

//$SubcategoryOptions = GetExpenseIDForStock($Name = 'HeadOfAccountID', isset($TheEntityName['']) ? $TheEntityName[''] : '', $Where = '', $PrependBlankOption = true, $Class = 'form-select');


//print_r($HeadOfAccount);
//die();





if (isset($_GET['action']) && $_GET['action'] === 'get_unit' && isset($_GET['subcategory_id'])) {
    error_reporting(0);
    header('Content-Type: application/json');

    $subcategory_id = intval($_GET['subcategory_id']);

    $result = MySQLQuery("SELECT Unit FROM expensehead WHERE ExpenseHeadID = $subcategory_id LIMIT 1");

    if ($result && count($result) > 0) {
        echo json_encode(['unit' => $result[0]['Unit']]);
    } else {
        echo json_encode(['unit' => '']);
    }
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "<pre>";
    // print_r($_POST);
    echo "</pre>";



    $project_id = intval($_POST['project_id']);
    $boq_title = trim($_POST['boq_title']);
    $boq_date = $_POST['boq_date'];
    $user_id = 1;

    if ($project_id <= 0 || $boq_title == '') {
        exit('❌ Invalid Project ID or BOQ Title');
    }

    // 1. Insert into `tblboq`
    $insertData = array(
        "ProjectID" => $ProjectID,
        "ProjectName" => GetCategoryName($ProjectID),
        "BOQTitle" => $boq_title,
        "UserIDInserted" => $user_id,
        "DateInserted" => $boq_date,
    );
// $projectIDs = isset( $ProjectID) ?  $ProjectID : "dshfkj";

//     $GetProjectData =SQL_Select("Category","CategoryID={$ProjectID}","",true);
//     $Name = $GetProjectName['name'];

    SQL_InsertUpdate("boq", $insertData);

    // $boq_id = mysql_insert_id(); // last inserted BOQ ID

    // if ($boq_id <= 0) {
    //     exit('❌ Failed to insert into tblboq');
    // }

    // 2. Loop through categories
    foreach ($_POST['categories'] as $category) {
        $category_name = addslashes($category['category_name']);

         $insertData = array(
        "BoqID" => $boq_id,
        "CategoryName" => $category_name,

        "UserIDInserted" => $user_id,
        "DateInserted" => date('Y-m-d'),
    );

SQL_InsertUpdate("boqcategory", $insertData);

        

        // 3. Loop through subcategories
        if (isset($category['sub']) && is_array($category['sub'])) {
            foreach ($category['sub'] as $sub) {
                $subcategory_id = intval($sub['subcategory_id']);
                $unit = addslashes($sub['unit']);
                $qty = floatval($sub['qty']);
                $rate = floatval($sub['rate']);
                $cost = floatval($sub['cost']);
                $remarks = addslashes($sub['remarks']);


                 $insertData = array(
                            "BoqCategoryID" => $category_id,
                            "SubcategoryName" => $remarks,
                            "SubcategoryUnit" => $unit,
                            "SubcategoryQty" => $qty,
                            "SubcategoryRate" => $rate,
                            "SubcategoryCost" => $cost,
                            "UserIDInserted" => $user_id,
                            "DateInserted" => date('Y-m-d'),
                        );
                SQL_InsertUpdate("boqsubcategory", $insertData);





                // $sql_sub = "INSERT INTO boqsubcategory
                //     (BoqCategoryID, SubcategoryName, SubcategoryUnit, SubcategoryQty, SubcategoryRate, SubcategoryCost, UserIDInserted, DateInserted)
                //     VALUES
                //     ($category_id, '$remarks', '$unit', $qty, $rate, $cost, $user_id, NOW())";

                // MySQLQuery($sql_sub);
            }
        }
    }

    echo "<p style='color:green'>✅ Data saved successfully!</p>";
}






$MainContent .= <<<EOD
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">(BOQ)</h5>
    </div>
    <div class="card-body">
       <form method="post" action="{$ActionURL}">
            <div class="row pb-4 border border-success p-3 rounded mb-4">
                <div class="col-md-4">
                    <label class="form-label">Project</label>
                    <select name="project_id" class="form-select" required>
EOD;

foreach ($Project as $p) {
    $selected = (isset($TheEntityName['ProjectID']) && isset($p['CategoryID']) && $TheEntityName['ProjectID'] == $p['CategoryID']) ? 'selected' : '';
    $MainContent .= '<option value="' . (isset($p['CategoryID']) ? $p['CategoryID'] : '') . '" ' . $selected . '>' . htmlspecialchars(isset($p['Name']) ? $p['Name'] : '') . '</option>';
}

$MainContent .='
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">BOQ Title</label>
                    <input type="text" name="boq_title" class="form-control" required value="'.$TheEntityName["BOQTitle"].'">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date</label>
                    <input type="date" id="boq_date" name="boq_date" class="form-control" required value="{$TheEntityName["DateInserted"]}">


                </div>
            </div>

            <div id="category-container"></div>

            <button type="button" class="btn btn-success mb-3" onclick="addCategory()">+ Add Category</button>

            <div class="grand-total text-end bg-light p-3 rounded fw-bold fs-5 border" id="grand-total-box">
                Grand Total: 0.00
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5">Save BOQ</button>
            </div>
        </form>
    </div>
</div>

<style>
   .category-block {
    border: 2px dashed #339af0;
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 5px;
    background: #e7f5ff;
    color: #212529;
}
    .subcategory-block { border: 1px solid #000000; padding: 10px; margin: 10px; border-radius: 5px; background: #0b86be8f; }
    .subtotal-box { margin-top: 10px; font-weight: bold; text-align: right; }
    .category-title { font-weight: bold; font-size: 1.1rem; color: #007bff; margin-bottom: 10px; }
</style>';


$MainContent .= '
<script>
let categoryIndex = 0;
const subcategoryOptions = `' . addslashes($SubcategoryOptions) . '`;

function addCategory(categoryData = null) {
    const container = document.getElementById("category-container");
    const block = document.createElement("div");
    block.className = "category-block";
    block.setAttribute("data-cat-index", categoryIndex);

    block.innerHTML = `
        <div class="category-title">Category ${categoryIndex + 1}</div>
        <div class="mb-3 col-md-4">
            <label class="form-label">Category Name</label>
            <input type="text" name="categories[${categoryIndex}][category_name]" class="form-control" required>
        </div>
        <div id="subcats-${categoryIndex}"></div>
        <button type="button" class="btn btn-sm btn-outline-primary mb-2" onclick="addSubcategory(${categoryIndex})">+ Add Subcategory</button>
        <div class="subtotal-box" id="subtotal-${categoryIndex}">Subtotal: 0.00</div>
    `;
    container.appendChild(block);

    if (categoryData && Array.isArray(categoryData.sub)) {
        categoryData.sub.forEach(sub => addSubcategory(categoryIndex, sub));
    }

    if (categoryData && categoryData.category_name) {
        block.querySelector(`input[name="categories[${categoryIndex}][category_name]"]`).value = categoryData.category_name;
    }

    categoryIndex++;
}

function addSubcategory(catIdx, subData = null) {
    const subContainer = document.getElementById("subcats-" + catIdx);
    const subIndex = subContainer ? subContainer.children.length : 0;

    const div = document.createElement("div");
    div.className = "subcategory-block mb-3";
    div.innerHTML = `
        <div class="col-md-3">
            <label>Remarks / Description</label>
            <textarea name="categories[${catIdx}][sub][${subIndex}][remarks]" class="form-control" rows="2" placeholder="Write details..."></textarea>
        </div>
        <div class="row align-items-end gx-2">
            <div class="col-md-3">
                <label>Subcategory</label>
                <select name="categories[${catIdx}][sub][${subIndex}][subcategory_id]" class="form-select" onchange="fetchUnit(this)">
                    ${subcategoryOptions}
                </select>
            </div>
            <div class="col-md-2">
                <label>Unit</label>
                <input type="text" name="categories[${catIdx}][sub][${subIndex}][unit]" class="form-control unit-input" readonly>
            </div>
            <div class="col-md-2">
                <label>Qty</label>
                <input type="number" name="categories[${catIdx}][sub][${subIndex}][qty]" class="form-control" step="0.01" oninput="calculate()">
            </div>
            <div class="col-md-2">
                <label>Rate</label>
                <input type="number" name="categories[${catIdx}][sub][${subIndex}][rate]" class="form-control" step="0.01" oninput="calculate()">
            </div>
            <div class="col-md-2">
                <label>Amount</label>
                <div class="form-control text-end bg-light" data-amount>0.00</div>
                <input type="hidden" name="categories[${catIdx}][sub][${subIndex}][cost]" value="0">
            </div>
            <div class="col-md-1 text-end">
                <button type="button" class="btn btn-danger btn-sm mt-4" onclick="this.closest(\'.subcategory-block\').remove(); calculate();">−</button>
            </div>
        </div>
    `;
    subContainer.appendChild(div);

    if (subData) {
        div.querySelector(`textarea[name="categories[${catIdx}][sub][${subIndex}][remarks]"]`).value = subData.remarks || "";
        div.querySelector(`select[name="categories[${catIdx}][sub][${subIndex}][subcategory_id]"]`).value = subData.subcategory_id || "";
        div.querySelector(`input[name="categories[${catIdx}][sub][${subIndex}][unit]"]`).value = subData.unit || "";
        div.querySelector(`input[name="categories[${catIdx}][sub][${subIndex}][qty]"]`).value = subData.qty || "";
        div.querySelector(`input[name="categories[${catIdx}][sub][${subIndex}][rate]"]`).value = subData.rate || "";
        div.querySelector(`input[name="categories[${catIdx}][sub][${subIndex}][cost]"]`).value = subData.cost || "";
        div.querySelector("[data-amount]").innerText = (parseFloat(subData.cost) || 0).toFixed(2);
    }
}

function fetchUnit(selectElement) {
    const subcatID = selectElement.value;
    const unitInput = selectElement.closest(".subcategory-block").querySelector("input[name$=\'[unit]\']");
    if (!subcatID) {
        unitInput.value = "";
        return;
    }
    fetch("index.php?Theme=default&Base=BOQ&Script=Insertupdate&action=get_unit&subcategory_id=" + subcatID)
        .then(response => response.json())
        .then(data => {
            unitInput.value = data.unit || "";
        })
        .catch(err => {
            console.error("Unit fetch failed:", err);
            unitInput.value = "";
        });
}

function calculate() {
    let grandTotal = 0;
    for (let i = 0; i < categoryIndex; i++) {
        const subBlocks = document.querySelectorAll(`#subcats-${i} .subcategory-block`);
        let subtotal = 0;
        subBlocks.forEach(block => {
            const qty = parseFloat(block.querySelector("input[name$=\'[qty]\']").value) || 0;
            const rate = parseFloat(block.querySelector("input[name$=\'[rate]\']").value) || 0;
            const amount = qty * rate;
            block.querySelector("[data-amount]").innerText = amount.toFixed(2);
            block.querySelector("input[name$=\'[cost]\']").value = amount.toFixed(2);
            subtotal += amount;
        });
        const subtotalBox = document.getElementById("subtotal-" + i);
        if (subtotalBox) subtotalBox.innerText = "Subtotal: " + subtotal.toFixed(2);
        grandTotal += subtotal;
    }
    document.getElementById("grand-total-box").innerText = "Grand Total: " + grandTotal.toFixed(2);
}

document.addEventListener("DOMContentLoaded", function () {
';

if (!$UpdateMode) {
    $MainContent .= '
    const dateField = document.getElementById("boq_date");
    if (dateField) {
        dateField.value = new Date().toISOString().split("T")[0];
    }
    ';
}

$MainContent .= '
    const oldCategories = ' . json_encode($categoriesData) . ';
    if (oldCategories && oldCategories.length > 0) {
        categoryIndex = 0;
        oldCategories.forEach(cat => addCategory(cat));
        calculate();
    }
});
</script>
';

?>
