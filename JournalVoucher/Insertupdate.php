<?php
include "./script/" . $_REQUEST['Base'] . "/Scriptvariables.php";

$UpdateMode = false;
$FormTitle = "Insert " . $EntityCaption;
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL($_REQUEST['Base'], "Insertupdateaction");

$TheEntityName = array(
    "DrProjectID" => "",
    "CrProjectID" => "",
    "FormHeadOfAccountID" => array(),
    "ToHeadOfAccountID" => array(),
    "drAmount" => array(),
    "crAmount" => array(),
    $Entity . "IsDisplay" => 1
);

// Load existing record for update
if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"]) && !isset($_REQUEST["DeleteConfirm"])) {
    $UpdateMode = true;
    $FormTitle = "Update " . $EntityCaption;
    $ButtonCaption = "Update";
    $ActionURL = ApplicationURL($_REQUEST['Base'], "Insertupdateaction", $Entity . "ID=" . $_REQUEST[$Entity . "ID"] . "&" . $Entity . "UUID=" . $_REQUEST[$Entity . "UUID"]);

    $TheEntityName = SQL_Select($Entity, $Entity . "ID=" . $_REQUEST[$Entity . "ID"] . " AND " . $Entity . "UUID='" . $_REQUEST[$Entity . "UUID"] . "'", "", true);

    $voucherDetails = SQL_Select("journalvoucher", "VoucherNo=" . $TheEntityName["VoucherNo"], "JournalVoucherID");

    foreach ($voucherDetails as $vd) {
        if ($vd["dr"] > 0) {
            $TheEntityName["drAmount"][] = $vd["dr"];
            $TheEntityName["FormHeadOfAccountID"][] = $vd["HeadOfAccountID"];
        } elseif ($vd["cr"] > 0) {
            $TheEntityName["crAmount"][] = $vd["cr"];
            $TheEntityName["ToHeadOfAccountID"][] = $vd["HeadOfAccountID"];
        }
    }
}

// Utility to build group HTML
function buildGroupRows($type, $headIds, $amounts) {
    $html = '';
    $fieldPrefix = $type === 'dr' ? "FormHeadOfAccountID" : "ToHeadOfAccountID";
    $amountPrefix = $type === 'dr' ? "drAmount" : "crAmount";
    $rowClass = $type . "-group mb-2";

    for ($i = 0; $i < max(1, count($headIds)); $i++) {
        $headId = isset($headIds[$i]) ? $headIds[$i] : "";
        $amt = isset($amounts[$i]) ? $amounts[$i] : "";
        $btn = $i === 0
            ? '<button type="button" class="btn btn-success btn-add-' . $type . '">+</button>'
            : '<button type="button" class="btn btn-danger btn-remove-' . $type . '">−</button>';

        $html .= '<div class="row ' . $rowClass . '">
                    <div class="col-md-6">' . GetExpenseID($fieldPrefix . '[' . $type . '][' . $i . ']', $headId, "", true) . '</div>
                    <div class="col-md-4"><input type="number" name="Amount[' . $type . '][' . $i . ']" value="' . htmlspecialchars($amt) . '" class="form-control" required></div>
                    <div class="col-md-2">' . $btn . '</div>
                </div>';
    }
    return $html;
}

if ($TheEntityName["Type"]==1){
    $Selected="selected";
}elseif ($TheEntityName["Type"]==2){
    $Selected="selected";
}else{
    $Selected="";
}
$Input = array();

$MainContent .= '
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Insert Journal Voucher</h5>
    </div>
    <div class="card-body">
        <form id="requisitionForm" action="' . $ActionURL . '" method="post">
            <div class="row g-3">
                    <!-- Type -->
                    <div class="col-md-6">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="Type" id="TypeSelect" required>
                            <option value="0">Others</option>
                            <option ' . $ContructorID . ' value="1" '.$Selected.' >Contructor</option>
                            <option ' . $VendorID . ' value="2" '.$Selected.'>Vendor</option>
                        </select>
                    </div>
                
                    <!-- Vendor -->
                    
                    <div id="vendorDiv" style="display:none;" class="col-md-6">
                        <label class="form-label">Vendor</label>
                            ' . CCTL_Vendor($Name = "VendorID", $TheEntityName["VendorID"], $Where = "", $PrependBlankOption = true) . '
                    </div>
                
                    <!-- Contructor -->
                    <div class="col-md-6" id="contractorDiv" style="display:none;">
                        <label class="form-label">Contractor</label>
                            ' . CCTL_Contructor("ContructorID", $TheEntityName["ContructorID"],$Where = "", true) . '
                    </div>
                    
                    
                    
                    <!-- Project (Dr.) -->
                    <div class="col-md-4">
                        <label class="form-label">Project (Dr.)</label>
                        ' . CCTL_ProductsCategory($Name = "FormProjectID", $TheEntityName["ProjectID"], $Where = "", $PrependBlankOption = true) . '
                    </div>
                    <!-- Debit Entries -->
                    <div class="col-md-8">
                        <label class="form-label">Debit Entries</label>
                        ' . buildGroupRows("dr", $TheEntityName["FormHeadOfAccountID"], $TheEntityName["drAmount"]) . '
                    </div>
                    <!-- Project (Cr.) -->
                    <div class="col-md-4">
                        <label class="form-label">Project (Cr.)</label>
                        ' . CCTL_ProductsCategory($Name = "ToProjectID", $TheEntityName["ProjectID"], $Where = "", $PrependBlankOption = true) . '
                    </div>
                    <!-- Credit Entries -->
                    <div class="col-md-8">
                        <label class="form-label">Credit Entries</label>
                        ' . buildGroupRows("cr", $TheEntityName["ToHeadOfAccountID"], $TheEntityName["crAmount"]) . '
                    </div>
                
                    <!-- Bill Phase -->
                    <div class="col-md-3">
                        <label class="form-label">Bill Phase</label>
                        ' . CTL_InputText("BillPhase", $TheEntityName["BillPhase"], "", 30) . '
                    </div>
                
                    <!-- Bill Date -->
                    <div class="col-md-3">
                        <label class="form-label">Bill Date</label>
                        <input type="date" class="form-control" name="BillDate" value="' . $TheEntityName["BillDate"] . '" />
                    </div>
                
                    <!-- MR / Bill No -->
                    <div class="col-md-3">
                        <label class="form-label">MR / Bill No</label>
                        ' . CTL_InputText("BillNo", isset($TheEntityName["BillNo"]) ? $TheEntityName["BillNo"] : "", "", 30) . '
                    </div>
                
                    <!-- Date -->
                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        ' . CTL_InputTextDate("Date", isset($TheEntityName["Date"]) ? $TheEntityName["Date"] : "", "", 30, "required") . '
                    </div>
                
                    <!-- Description -->
                    <div class="col-md-12">
                        <label class="form-label">Description</label>
                        ' . CTL_InputTextArea("Description", isset($TheEntityName["Description"]) ? $TheEntityName["Description"] : "", "", 4, "required") . '
                    </div>
                
                    <!-- Confirm? -->
                    <div class="col-md-6">
                        <label class="form-label">Confirm?</label>
                        ' . CTL_InputRadioSet($Entity . "IsDisplay", array("No", "Yes"), array(1, 0), $TheEntityName[$Entity . "IsDisplay"]) . '
                    </div>
                    
                    <input type="hidden" name="VoucherNo" value="'.$TheEntityName["VoucherNo"].'">
            </div>

            <button type="submit" class="btn btn-success w-100">Submit</button>
        </form>
    </div>
</div>

';
?>

<!-- Include jQuery for JS logic -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        function cloneRow(groupSelector, groupType) {
            var groupContainer = $(groupSelector).closest(".col-md-8"); // the container of all .dr-group or .cr-group
            var rows = groupContainer.find("." + groupType + "-group");
            var newIndex = rows.length;

            var lastRow = rows.last();
            var newRow = lastRow.clone();

            // Clear values
            newRow.find("input, select").each(function () {
                $(this).val("");

                // Update name attributes with new index
                var name = $(this).attr("name");
                if (name) {
                    var newName = name.replace(/\[(\d+)\]/, "[" + newIndex + "]");
                    $(this).attr("name", newName);
                }
            });

            // Change button from "+" to "-"
            newRow.find(".btn-add-" + groupType)
                .removeClass("btn-success btn-add-" + groupType)
                .addClass("btn-danger btn-remove-" + groupType)
                .text("−");

            lastRow.after(newRow);
        }


// Add Row
        $(document).on("click", ".btn-add-dr", function () {
            cloneRow(".dr-group", "dr");
        });
        $(document).on("click", ".btn-add-cr", function () {
            cloneRow(".cr-group", "cr");
        });

// Remove Row
        $(document).on("click", ".btn-remove-dr", function () {
            $(this).closest(".dr-group").remove();
        });
        $(document).on("click", ".btn-remove-cr", function () {
            $(this).closest(".cr-group").remove();
        });

// Validation
        const typeSelect = document.getElementById("TypeSelect");
        const vendorDiv = document.getElementById("vendorDiv");
        const contractorDiv = document.getElementById("contractorDiv");

        const vendorField = vendorDiv.querySelector("select");
        const contractorField = contractorDiv.querySelector("select");

        function toggleFields() {
            const selected = typeSelect.value;

            if (selected === "2") {
                vendorDiv.style.display = "block";
                vendorField.required = true;

                contractorDiv.style.display = "none";
                contractorField.required = false;
            } else if (selected === "1") {
                contractorDiv.style.display = "block";
                contractorField.required = true;

                vendorDiv.style.display = "none";
                vendorField.required = false;
            } else {
                vendorDiv.style.display = "none";
                vendorField.required = false;

                contractorDiv.style.display = "none";
                contractorField.required = false;
            }
        }

        typeSelect.addEventListener("change", toggleFields);

        // Trigger once on load
        toggleFields();
    });

</script>

