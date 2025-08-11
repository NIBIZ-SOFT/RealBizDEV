<?

/*
' . CCTL_Sales_ID($Name = "SalesID", $TheEntityName["SalesID"], $Where = "", $PrependBlankOption = true) . '

						*/	

GetPermission("OptionSalesReport");

$MainContent .= '
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h1 class="h3 shadow-lg p-4" style="background: rgb(60 125 221 / 34%) !important;box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;">Sales Report</h1>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">

    <!-- Customer Wise Party Ledger -->
    <div class="col">
        <div class="card">
            <div class="card-header text-center bg-success text-white">Customer Wise Party Ledger</div>
            <div class="card-body">
                <form id="partyLedgerFrom" target="_blank" method="POST" action="' . ApplicationURL("Report", "CustomerWaysPartyLedger&NoHeader&NoFooter") . '">
                    <div class="mb-3">
                        <label class="form-label">Project Name</label>
                        ' . CCTL_ProductsCategory("CategoryID", $TheEntityName["CategoryID"], "", true) . '
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Customer Name</label>
                        <select name="customer_id" id="CustomerName" class="form-select select2">
                            <option value="">Select Customer</option>';
$customerlist = SQL_Select("customer", "CustomerIsActive=1 order by CustomerID DESC");
foreach ($customerlist as $customer) {
    $customerID = $customer['CustomerID'];
    $customerName = $customer['CustomerName'];
    $MainContent .= '<option value="' . $customerID . '">' . $customerID . ' - ' . $customerName . '</option>';
}
$MainContent .= '
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Show Report</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Project Wise Party Ledger Summary -->
    <div class="col">
        <div class="card">
            <div class="card-header text-center bg-success text-white">Project Wise Party Ledger Summary</div>
            <div class="card-body">
                <form method="POST" action="' . ApplicationURL("Report", "CustomerPartyLedgerSummery&NoHeader&NoFooter") . '">
                    <div class="mb-3">
                        <label class="form-label">Project Name</label>
                        ' . CCTL_ProductsCategory("CategoryID", $TheEntityName["CategoryID"], "", true, "form-select select2") . '
                    </div>
                    <div class="mb-3">
                        <label class="form-label">From Date</label>
                        <input type="date" class="form-control" name="FromDate" placeholder="Year-Month-Day">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">To Date</label>
                        <input type="date" class="form-control" name="ToDate" placeholder="Year-Month-Day">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Show Report</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Seller Name Wise Party Ledger -->
    <div class="col">
        <div class="card">
            <div class="card-header text-center bg-success text-white">Seller Name Wise Party Ledger</div>
            <div class="card-body">
                <form method="POST" action="' . ApplicationURL("Report", "SellerNameWisePartyLedger&NoHeader&NoFooter") . '">
                    <div class="mb-3">
                        <label class="form-label">Seller Name</label>
                        <select name="SalerNameID" id="salerDropdown" class="form-select select2">
                            <option value="" disabled selected>Select Seller</option>';
$SalerName = SQL_Select("salername", "SalerNameIsActive=1 order by SalerNameID ASC");
foreach ($SalerName as $saler) {
    $MainContent .= '<option value="' . $saler['SalerNameID'] . '">' . $saler['SalerNameID'] . ' - ' . $saler['Name'] . '</option>';
}
$MainContent .= '
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">From Date</label>
                        <input type="date" class="form-control" name="FromDate">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">To Date</label>
                        <input type="date" class="form-control" name="ToDate">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Show Report</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Package Wise Party Ledger Summary -->
    <div class="col">
        <div class="card">
            <div class="card-header text-center bg-success text-white">Package Wise Party Ledger Summary</div>
            <div class="card-body">
                <form method="POST" action="' . ApplicationURL("Report", "LocationWisePartyLedgerSummery&NoHeader&NoFooter") . '">
                    <div class="mb-3">
                        <label class="form-label">Package Name</label>
                        ' . CCTL_Products("ProductID", $TheEntityName["ProductID"], "", true) . '
                    </div>
                    <div class="mb-3">
                        <label class="form-label">From Date</label>
                        <input type="date" class="form-control" name="FromDate">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">To Date</label>
                        <input type="date" class="form-control" name="ToDate">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Show Report</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Division Wise Party Ledger Summary -->
    <div class="col">
        <div class="card">
            <div class="card-header text-center bg-success text-white">Division Wise Party Ledger Summary</div>
            <div class="card-body">
                <form method="POST" action="' . ApplicationURL("Report", "CustomerPartyLedgerSummeryDivision&NoHeader&NoFooter") . '">
                    <div class="mb-3">
                        <label class="form-label">Division</label>
                        <select name="Division" class="form-select">
                            <option value="">Select Division</option>
                            <option value="Corporate">Corporate</option>
                            <option value="SSD">SSD</option>
                            <option value="SED">SED</option>
                            <option value="CST">CST</option>
                            <option value="Founder">Founder</option>
                            <option value="Referral">Referral</option>
                            <option value="Director">Director</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">From Date</label>
                        <input type="date" class="form-control" name="FromDate">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">To Date</label>
                        <input type="date" class="form-control" name="ToDate">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Show Report</button>
                </form>
            </div>
        </div>
    </div>

    <!-- EMI Report -->
    <div class="col">
        <div class="card">
            <div class="card-header text-center bg-success text-white">EMI Report</div>
            <div class="card-body">
                <form method="POST" action="' . ApplicationURL("SalesReport", "EMIReport&NoHeader&NoFooter") . '">
                    <div class="mb-3">
                        <label class="form-label">Division</label>
                        <select name="Division" class="form-select">
                            <option value="" disabled>Select a division</option>
                            <option value="Corporate">Corporate</option>
                            <option value="SSD">SSD</option>
                            <option value="SED">SED</option>
                            <option value="CST">CST</option>
                            <option value="Founder">Founder</option>
                            <option value="Referral">Referral</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">From Date</label>
                        <input type="date" class="form-control" name="FromDate">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">To Date</label>
                        <input type="date" class="form-control" name="ToDate">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Show Report</button>
                </form>
            </div>
        </div>
    </div>

    </div>
<script>
$(document).ready(function() {
       $(".select2").select2();
    if ($("#CustomerName").length > 0) {
        console.log("#customer_id element found.");
        $("#CustomerName").on("change", function() {
            var customerId = $(this).val();
            if (customerId) {
                console.log("Selected Customer ID: " + customerId);
            } else {
                console.log("No Customer selected.");
            }
        });
    } else {
        console.log("#customer_id element not found.");
    }
});
</script>
    <script>
        $(document).ready(function() {
            $(".select2").select2();

            $("#salesOption").on("change", function() {
                $.ajax({
                    url: "index.php?Theme=default&Base=Report&Script=SalesID&ProductID=" + $("#salesOption").val() + "&NoHeader&NoFooter",
                    type: "POST",
                    dataType: "text",
                    success: function(data) {
                        $("#CustomerList").html(data);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });		    
            });

            $("#partyLedgerFrom select[name=CategoryID]").on("change", function() {
                var mainThis = $(this);
                var SalesOptionDom = document.getElementById("salesOption");
                SalesOptionDom.innerHTML = "<option value=\'0\'>Select Product</option>";

                $.ajax({
                    url: "index.php?Theme=default&Base=Report&Script=SalesID&NoHeader&NoFooter",
                    type: "POST",
                    dataType: "JSON",
                    data: { ProjectID: mainThis.val() },
                    success: function(data) {
                        data.forEach(function(element) {
                            var node = document.createElement("option");
                            node.setAttribute("value", element["SalesID"]);
                            node.textContent = element["ProductName"];
                            SalesOptionDom.appendChild(node);
                        });
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
</div>
';

