<?

/*
' . CCTL_Sales_ID($Name = "SalesID", $TheEntityName["SalesID"], $Where = "", $PrependBlankOption = true) . '

						*/	

//GetPermission("OptionSalesReport");


$MainContent .= '
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h1 class="h3 shadow-lg p-4" style="background: rgb(60 125 221 / 34%) !important;box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;">CRM Report</h1>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
<style>
.card {
box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
}
</style>

            <!-- Project Wise Report -->
            <div class="col">
                <div class="card">
                    <div class="card-header text-center bg-success text-white">Project Wise Report</div>
                    <div class="card-body">
                        <form id="partyLedgerFrom" method="POST" action="' . ApplicationURL("CRM", "ProjectWiseReport&NoHeader&NoFooter") . '">
                            <div class="mb-3">
                                <label class="form-label">Project Name</label>
                                ' . CCTL_ProductsCategory("CategoryID", $TheEntityName["CategoryID"], "", true) . '
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

            <!-- Lead Status Wise -->
            <div class="col">
                <div class="card">
                    <div class="card-header text-center bg-success text-white">Lead Status Wise</div>
                    <div class="card-body">
                        <form method="POST" action="' . ApplicationURL("CRM", "LeadStatusWise&Type=LeadsStatus&NoHeader&NoFooter") . '">
                            <div class="mb-3">
                                <label class="form-label">Lead Status</label>
                                ' . CommaSeperated("LeadsStatus", $Settings["LeadsStatus"], $TheEntityName["LeadsStatus"]) . '
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

            <!-- Lead Source Wise -->
            <div class="col">
                <div class="card">
                    <div class="card-header text-center bg-success text-white">Lead Source Wise</div>
                    <div class="card-body">
                        <form method="POST" action="' . ApplicationURL("CRM", "LeadStatusWise&Type=LeadSource&NoHeader&NoFooter") . '">
                            <div class="mb-3">
                                <label class="form-label">Lead Source</label>
                                ' . CommaSeperated("LeadSource", $Settings["LeadSource"], $TheEntityName["LeadSource"]) . '
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

            <!-- Assigned User Wise -->
            <div class="col">
                <div class="card">
                    <div class="card-header text-center bg-success text-white">Assigned User Wise</div>
                    <div class="card-body">
                        <form method="POST" action="' . ApplicationURL("CRM", "LeadStatusWise&Type=AssignedUser&NoHeader&NoFooter") . '">
                            <div class="mb-3">
                                <label class="form-label">User Name</label>
                                ' . CCTL_UserList("AssignTo", $TheEntityName["AssignTo"], "", true) . '
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

        </div>

        <script>
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
        </script>
    </div>
';
