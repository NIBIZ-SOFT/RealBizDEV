<?

GetPermission("OptionReport");


$MainContent .= '


<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h1 class="h3 shadow-lg p-4" style="background: rgb(60 125 221 / 34%) !important;box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;">Purchase Report</h1>
        </div>
    </div>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        <!-- Project Wise Ledger -->
        <div style="" class="col">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">Purchase Requisition Report ( All & One Project Ways)</div>
                <div class="card-body">
                    <form method="POST" action="' .ApplicationURL("Report", "PurchaseRequisition&NoHeader&NoFooter"). '">
                        <div class="mb-3">
                            <label class="form-label">Project Name</label>
                            '.CCTL_ProductsCategory($Name = "CategoryID", $TheEntityName["CategoryID"], $Where = "", $PrependBlankOption = true).'
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
                <div class="card-header text-center bg-success text-white">Purchase Order Report ( All & One Project Ways)</div>
                <div class="card-body">
                    <form method="POST" action="' .ApplicationURL("Report", "PurchaseOrder&NoHeader&NoFooter"). '">
                        <div class="mb-3">
                            <label class="form-label">Project Name</label>
                            '.CCTL_ProductsCategory($Name = "CategoryID", $TheEntityName["CategoryID"], $Where = "", $PrependBlankOption = true).'
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
                <div class="card-header text-center bg-success text-white">Purchase Requisition Report ( ID )</div>
                <div class="card-body">
                    <form method="POST" action="' .ApplicationURL("Report","PurchaseRequisitionID&NoHeader&NoFooter"). '">
                        <div class="mb-3">
                            <label class="form-label">Purchase Requisition ID</label>
                            <input type="text" class="form-control" placeholder="Purchase Requisition ID"  name="ID" placeholder="YYYY-MM-DD">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Show Report</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">Purchase Order Report ( ID )</div>
                <div class="card-body">
                    <form method="POST" action="' .ApplicationURL("Report", "PurchaseOrder&NoHeader&NoFooter"). '">
                        <div class="mb-3">
                            <label class="form-label">Purchase Order ID</label>
                             <input type="text" class="form-control" placeholder=" Purchase Order ID" type="text" name="ID">
                            <br>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Show Report</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">Purchase Payment Report</div>
                <div class="card-body">
						<form method="POST" action="' . ApplicationURL("Report", "PurchasePaymentReport&NoHeader&NoFooter") . '">
							
							Vendor Name : ' . CCTL_Vendor($Name = "VendorID", $TheEntityName["VendorID"], $Where = "", $PrependBlankOption = true) . '
							
                            <br>
							
                            <input type="submit" value="Show Report" class="btn btn-primary" >
                            
						</form>
                </div>
            </div>
        </div>
    </div>
</div>


	
		
		

		    
		 
		
		
		
		    
		    
		    ';