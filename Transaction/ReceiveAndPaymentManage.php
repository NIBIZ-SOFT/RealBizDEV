<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 4/9/2019
 * Time: 2:54 PM
 */


$MainContent.='
<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 4/24/2019
 * Time: 3:08 PM
 */


<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <h1 class="h3 shadow-lg p-4" style="background: rgb(60 125 221 / 34%) !important;box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;">Receive & Payment Manage</h1>
        </div>
    </div>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
        <!-- Project Wise Ledger -->
        <div class="col">
            <div class="card shadow">
                <div class="card-header text-center bg-success text-white">Receive & Payment</div>
                <div class="card-body">
                    <form method="POST" action="' .ApplicationURL("Transaction","ReceiveAndPayment&NoHeader&NoFooter"). '">
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
                <div class="card-header text-center bg-success text-white">Receive & Payment New</div>
                <div class="card-body">
                    <form method="POST" action="' .ApplicationURL("Transaction","ReceiveAndPaymentNewC&NoHeader&NoFooter"). '">
                        <div class="mb-3">
                            <label class="form-label">Project Name</label>
                            '.CCTL_ProductsCategory($Name = "CategoryID", $TheEntityName["CategoryID"], $Where = "", $PrependBlankOption = true).'
                        </div>
                        <div class="mb-3">
                            <label class="form-label">From Date</label>
                            <input type="date" class="form-control" name="FromDate" placeholder="YYYY-MM-DD" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">To Date</label>
                            <input type="date" class="form-control" name="ToDate" placeholder="YYYY-MM-DD" required>
                        </div>
                         <div class="mb-3">
                            <label class="form-label">Second From Date</label>
                            <input type="date" class="form-control" name="secondFromDate" placeholder="YYYY-MM-DD" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Second To Date</label>
                            <input type="date" class="form-control" name="secondToDate" placeholder="YYYY-MM-DD" required >
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Show Report</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
		    ';


?>

