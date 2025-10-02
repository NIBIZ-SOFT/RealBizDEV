<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 4/9/2019
 * Time: 2:54 PM
 */

$MainContent .= '
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h1 class="h3 shadow-lg p-4" style="background: rgb(60 125 221 / 34%) !important;box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;">Ledger Manage</h1>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        <!-- Project Wise Ledger -->
        <div class="col">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">Project Wise</div>
                <div class="card-body">
                    <form method="POST" action="' . ApplicationURL("Transaction", "LedgerActionProject&NoHeader&NoFooter") . '">
                        <div class="mb-3">
                            <label class="form-label">Project Name</label>
                            ' . CCTL_ProductsCategory($Name = "CategoryID", $TheEntityName["CategoryID"], $Where = "", $PrependBlankOption = true) . '
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Expense / Income Head</label>
                            ' . GetExpenseID("HeadOfAccountID", "", "", true, "form-select HeadOfAccountIDClass1") . '
                        </div>
                        <div class="mb-3">
                            <label class="form-label">From Date</label>
                            <input type="date" class="form-control" name="FromDate" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">To Date</label>
                            <input type="date" class="form-control" name="ToDate" placeholder="YYYY-MM-DD">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Show Report</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- All Project Ledger -->
        <div class="col">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">All Project</div>
                <div class="card-body">
                    <form method="POST" action="' . ApplicationURL("Transaction", "LedgerActionHead&NoHeader&NoFooter") . '">
                        <div class="mb-3">
                            <label class="form-label">Expense / Income Head</label>
                            ' . GetExpenseID("HeadOfAccount_ID", "", "", true, "form-select HeadOfAccountIDClass") . '
                        </div>
                        <div class="mb-3">
                            <label class="form-label">From Date</label>
                            <input type="date" class="form-control" name="FromDate" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">To Date</label>
                            <input type="date" class="form-control" name="ToDate" placeholder="YYYY-MM-DD">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Show Report</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Cash or Bank Book -->
        <div class="col">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">Cash or Bank Book</div>
                <div class="card-body">
                    <form method="POST" action="' . ApplicationURL("Transaction", "LedgerActionCashBank&NoHeader&NoFooter") . '">
                        <div class="mb-3">
                            <label class="form-label">Project Name</label>
                            ' . CCTL_ProductsCategory($Name = "CategoryID", $TheEntityName["CategoryID"], $Where = "", $PrependBlankOption = true) . '
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Cash or Bank</label>
                            ' . CCTL_BankCash("BankCashID", "", "", true) . '
                        </div>
                        <div class="mb-3">
                            <label class="form-label">From Date</label>
                            <input type="date" class="form-control" name="FromDate" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">To Date</label>
                            <input type="date" class="form-control" name="ToDate" placeholder="YYYY-MM-DD">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Show Report</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Customer Wise Party Ledger -->
        <div class="col">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center">Customer Wise Party Ledger</div>
                <div class="card-body">
                    <form method="POST" action="' . ApplicationURL("Transaction", "CustomerPartyLedger&NoHeader&NoFooter") . '">
                        <div class="mb-3">
                            <label class="form-label">Customer</label>
                            ' . CCTL_Customer("CustomerID", $TheEntityName["CustomerID"], "", true) . '
                        </div>
                        <div class="mb-3">
                            <label class="form-label">From Date</label>
                            <input type="date" class="form-control" name="FromDate" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">To Date</label>
                            <input type="date" class="form-control" name="ToDate" placeholder="YYYY-MM-DD">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Show Report</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Project wise Customer Balance -->
        <div class="col">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">Project Wise Customer Balance</div>
                <div class="card-body">
                    <form method="POST" action="' . ApplicationURL("Transaction", "ProjectwiseCustomerBalance&NoHeader&NoFooter") . '">
                        <div class="mb-3">
                            <label class="form-label">Project Name</label>
                            ' . CCTL_ProductsCategory($Name = "CategoryID", $TheEntityName["CategoryID"], $Where = "", $PrependBlankOption = true) . '
                        </div>
                        <div class="mb-3">
                            <label class="form-label">From Date</label>
                            <input type="date" class="form-control" name="FromDate" placeholder="YYYY-MM-DD">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">To Date</label>
                            <input type="date" class="form-control" name="ToDate" placeholder="YYYY-MM-DD">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Show Report</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">Stock Report</div>
                <div class="card-body">

						<form method="POST" action="' . ApplicationURL("Report", "StockReport&NoHeader&NoFooter") . '">
                            <div class="mb-3">
							Project Name : ' . CCTL_ProductsCategory($Name = "CategoryID", $TheEntityName["CategoryID"], $Where = "", $PrependBlankOption = true) . '
							<div style="height:10px;"></div>
							Expense / Income Head : ' . GetExpenseIDForStock($Name = "HeadOfAccountID", $ValueSelected = "", $Where = "", $PrependBlankOption = true) . '
                            </div>

                            <br><br>

                            <button type="submit" class="btn btn-primary w-100">Show Report</button>
                            
						</form>
                
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">Vendor Wise Ledger</div>
                <div class="card-body">

						<form method="POST" action="' . ApplicationURL("Transaction", "voucherTopVendor&NoHeader&NoFooter") . '">
                            <div class="mb-3">
                                <label class="form-label">Project Name</label>
                                ' . CCTL_ProductsCategory($Name = "CategoryID", $TheEntityName["CategoryID"], $Where = "", $PrependBlankOption = true) . '
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Vendor</label>
                                ' . CCTL_Vendor("VendorID", $TheEntityName["VendorID"], "", true) . '
                            </div>
                            <div class="mb-3">
                                <label class="form-label">From Date</label>
                                <input type="date" class="form-control" name="FromDate" placeholder="YYYY-MM-DD">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">To Date</label>
                                <input type="date" class="form-control" name="ToDate" placeholder="YYYY-MM-DD">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Show Report</button>
                            
						</form>
                
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Select2 Scripts -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $(".select2").select2();
    });
</script>
';




?>
        
