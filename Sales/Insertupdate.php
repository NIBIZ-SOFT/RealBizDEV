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
<script src="https://multivendor.ecommatrix.xyz/public/combo.js"></script>

<script>
$(function() {
    // Log jQuery status
    if (typeof jQuery !== "undefined") {
        console.log("jQuery is loaded!");
    } else {
        console.log("jQuery is not loaded.");
    }

    // Modern combobox UI (merged input + dropdown) for a <select> by id
    function enableComboSelect(selectId, placeholderText) {
        var selectEl = document.getElementById(selectId);
        if (!selectEl || selectEl.dataset.comboAttached === "1") return;

        // Wrap and hide original select (kept for form submission)
        var wrapper = document.createElement("div");
        wrapper.className = "combo-select position-relative";
        selectEl.parentNode.insertBefore(wrapper, selectEl);
        wrapper.appendChild(selectEl);
        selectEl.style.position = "absolute";
        selectEl.style.left = "-9999px";

        // Create visible input
        var inputEl = document.createElement("input");
        inputEl.type = "text";
        inputEl.className = "form-control";
        inputEl.placeholder = placeholderText || "Search...";
        wrapper.insertBefore(inputEl, selectEl);

        // Dropdown container
        var menu = document.createElement("div");
        menu.className = "combo-menu shadow";
        menu.style.position = "absolute";
        menu.style.top = "100%";
        menu.style.left = 0;
        menu.style.right = 0;
        menu.style.zIndex = 1050;
        menu.style.background = "#fff";
        menu.style.border = "1px solid #dee2e6";
        menu.style.borderTop = "0";
        menu.style.maxHeight = "260px";
        menu.style.overflowY = "auto";
        menu.style.display = "none";
        wrapper.appendChild(menu);

        function optionToItem(opt) {
            var div = document.createElement("div");
            div.className = "combo-item px-3 py-2";
            div.style.cursor = "pointer";
            div.textContent = opt.text;
            div.dataset.value = opt.value;
            return div;
        }

        function renderList(options) {
            menu.innerHTML = "";
            if (!options || !options.length) {
                var empty = document.createElement("div");
                empty.className = "px-3 py-2 text-muted";
                empty.textContent = "No results";
                menu.appendChild(empty);
                return;
            }
            for (var i = 0; i < options.length; i++) {
                if (i === 0 && options[i].value === "") continue; // skip placeholder in menu
                menu.appendChild(optionToItem(options[i]));
            }
        }

        function snapshotOptions() {
            var out = [];
            for (var i = 0; i < selectEl.options.length; i++) {
                var o = selectEl.options[i];
                out.push({ value: o.value, text: o.text });
            }
            return out;
        }

        function showMenu() { menu.style.display = "block"; }
        function hideMenu() { menu.style.display = "none"; }

        // Select an item
        menu.addEventListener("click", function (e) {
            var t = e.target.closest(".combo-item");
            if (!t) return;
            var val = t.dataset.value;
            var txt = t.textContent;
            selectEl.value = val;
            inputEl.value = txt;
            hideMenu();
            // update hidden ProductName if exists
            var hideName = document.getElementById("HideProductName");
            if (hideName) hideName.value = txt;
        });

        // Open on focus
        inputEl.addEventListener("focus", function(){
            renderList(snapshotOptions());
            showMenu();
        });

        // Close on outside click
        document.addEventListener("click", function(e){
            if (!wrapper.contains(e.target)) hideMenu();
        });

        // Debounced server search
        var debounceTimer = null;
        var typingXhr = null;
        inputEl.addEventListener("input", function(){
            clearTimeout(debounceTimer);
            var q = this.value || "";
            debounceTimer = setTimeout(function(){
                var projectSel = document.getElementById("ProjectID");
                var projectIdVal = projectSel ? (projectSel.value || 0) : 0;
                if (typeof $ === "function" && projectIdVal) {
                    if (typingXhr && typeof typingXhr.abort === "function") typingXhr.abort();
                    typingXhr = $.ajax({
                        url: "./index.php?Theme=default&Base=Sales&Script=AjaxRequest&NoHeader&NoFooter",
                        type: "POST",
                        dataType: "json",
                        data: { id: projectIdVal, action: "search_products_lite", q: q, limit: 50 }
                    }).done(function(data){
                        // also sync <select> for form submission
                        var frag = document.createDocumentFragment();
                        var placeholder = selectEl.options.length && selectEl.options[0].value === "" ? selectEl.options[0] : null;
                        selectEl.innerHTML = "";
                        if (placeholder) {
                            var optp = document.createElement("option");
                            optp.value = placeholder.value; optp.text = placeholder.text;
                            selectEl.appendChild(optp);
                        } else {
                            var opt0 = document.createElement("option");
                            opt0.value = ""; opt0.text = "-- Select Product --";
                            selectEl.appendChild(opt0);
                        }
                        var arr = Array.isArray(data) ? data : [];
                        for (var i = 0; i < arr.length; i++) {
                            var it = arr[i];
                            var opt = document.createElement("option");
                            opt.value = it.ProductsID;
                            opt.text = (it.FloorNumber || "") + "-" + (it.FlatType || "");
                            frag.appendChild(opt);
                        }
                        selectEl.appendChild(frag);
                        renderList(snapshotOptions());
                        showMenu();
                    });
                } else {
                    // fallback: filter existing options client-side
                    var opts = snapshotOptions().filter(function(o){
                        return o.text.toLowerCase().indexOf(q.toLowerCase()) !== -1;
                    });
                    renderList(opts);
                    showMenu();
                }
            }, 200);
        });

        // Initialize input with current selected text
        var selOpt = selectEl.options[selectEl.selectedIndex];
        if (selOpt && selOpt.value) inputEl.value = selOpt.text;

        selectEl.dataset.comboAttached = "1";
    }
    function enableSelectSearch(selectId, placeholderText) {
        var selectEl = document.getElementById(selectId);
        if (!selectEl || selectEl.dataset.searchAttached === "1") return;

        // Create and insert a single search input per select
        var inputEl = document.createElement("input");
        inputEl.type = "text";
        inputEl.className = "form-control mb-2";
        inputEl.placeholder = placeholderText || "Search...";
        selectEl.parentNode.insertBefore(inputEl, selectEl);

        // Keep a source copy of options
        function snapshotOptions() {
            var list = [];
            for (var i = 0; i < selectEl.options.length; i++) {
                var opt = selectEl.options[i];
                list.push({ value: opt.value, text: opt.text, selected: opt.selected });
            }
            selectEl._sourceOptions = list;
        }

        // Build options from source applying a filter safely (guard observer)
        function rebuildOptions(filterText) {
            var src = selectEl._sourceOptions || [];
            var q = (filterText || "").toLowerCase();
            var firstIsPlaceholder = src.length && src[0].value === "";
            var frag = document.createDocumentFragment();
            for (var i = 0; i < src.length; i++) {
                var it = src[i];
                if (i === 0 && firstIsPlaceholder) {
                    var opt0 = document.createElement("option");
                    opt0.value = it.value;
                    opt0.text = it.text;
                    opt0.selected = it.selected;
                    frag.appendChild(opt0);
                    continue;
                }
                if (!q || it.text.toLowerCase().indexOf(q) !== -1) {
                    var opt = document.createElement("option");
                    opt.value = it.value;
                    opt.text = it.text;
                    opt.selected = it.selected;
                    frag.appendChild(opt);
                }
            }
            // Guard against observer loops
            selectEl._isUpdating = true;
            selectEl.innerHTML = "";
            selectEl.appendChild(frag);
            selectEl._isUpdating = false;
        }

        // Initial snapshot
        snapshotOptions();

        // Filter as user types (debounced) - prefer server-side when possible
        var debounceTimer = null;
        inputEl.addEventListener("input", function () {
            clearTimeout(debounceTimer);
            var v = this.value;
            debounceTimer = setTimeout(function(){
                var projectSel = document.getElementById("ProjectID");
                var projectIdVal = projectSel ? (projectSel.value || 0) : 0;
                if (typeof $ === "function" && projectIdVal) {
                    $.post("./index.php?Theme=default&Base=Sales&Script=AjaxRequest&NoHeader&NoFooter", {
                        id: projectIdVal,
                        action: "search_products_lite",
                        q: v,
                        limit: 50
                    }, function(data){
                        // Build options from server
                        var src = Array.isArray(data) ? data : [];
                        var frag = document.createDocumentFragment();
                        // keep placeholder
                        if (selectEl._sourceOptions && selectEl._sourceOptions.length && selectEl._sourceOptions[0].value === "") {
                            var ph = selectEl._sourceOptions[0];
                            var optp = document.createElement("option");
                            optp.value = ph.value;
                            optp.text = ph.text;
                            optp.selected = ph.selected;
                            frag.appendChild(optp);
                        }
                        for (var i = 0; i < src.length; i++) {
                            var it = src[i];
                            var opt = document.createElement("option");
                            opt.value = it.ProductsID;
                            opt.text = (it.FloorNumber || "") + "-" + (it.FlatType || "");
                            frag.appendChild(opt);
                        }
                        selectEl._isUpdating = true;
                        selectEl.innerHTML = "";
                        selectEl.appendChild(frag);
                        selectEl._isUpdating = false;
                        snapshotOptions();
                    }, "json");
                } else {
                    // Fallback to client-side filter
                    rebuildOptions(v);
                }
            }, 200);
        });

        // Remove MutationObserver to avoid DOM churn loops

        // Expose a light refresh hook for external callers
        selectEl._refreshSearch = function () {
            snapshotOptions();
            rebuildOptions(inputEl.value);
        };

        // Mark attached
        selectEl.dataset.searchAttached = "1";
    }

    // Helper to refresh search after AJAX replaces options
    function refreshSelectSearch(selectId) {
        var el = document.getElementById(selectId);
        if (el && typeof el._refreshSearch === "function") {
            el._refreshSearch();
        }
    }

    // Track in-flight product search request to avoid stacking
    var productSearchXhr = null;

    // Handle project change
    $(document).on("change", "#ProjectID", function () {
        const projectID = $(this).val() || 0;
        console.log("Selected Project ID:", projectID);

        // Initial load - fetch first page (limited) for quick render
        if (productSearchXhr && typeof productSearchXhr.abort === "function") {
            productSearchXhr.abort();
        }
        productSearchXhr = $.ajax({
            url: "./index.php?Theme=default&Base=Sales&Script=AjaxRequest&NoHeader&NoFooter",
            type: "POST",
            dataType: "json",
            data: { id: projectID, action: "search_products_lite", q: "", limit: 50 }
        }).done(function (data) {
            console.log("Received products:", Array.isArray(data) ? data.length : 0);

            let options = "<option value=\'\'>-- Select Product --</option>";
            if (data?.length) {
                $.each(data, function (i, item) {
                    options += `<option value="${item.ProductsID}">${item.FloorNumber}-${item.FlatType}</option>`;
                });
            } else {
                options += "<option value=\'\'>No products available</option>";
            }
            $("#ProductID").html(options);
            // Build modern combobox UI on first load (library)
            try { new ComboSelect("#ProductID", { ajaxUrl: "./index.php?Theme=default&Base=Sales&Script=AjaxRequest&NoHeader&NoFooter", projectSelect: "#ProjectID", limit: 50, placeholder: "Search product..." }); } catch(e) { console.error(e); }
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error: " + textStatus + " - " + errorThrown);  // Log if the AJAX request fails
        });
    });
});
</script>';


?>