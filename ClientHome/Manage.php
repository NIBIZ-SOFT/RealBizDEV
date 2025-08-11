<?php

$MainContent .= '
<div class="col-md-6 offset-md-3 mb-4">
    <div class="card">
        <div class="card-header text-center bg-primary text-white">
            Customer Party Ledger
        </div>
        <div class="card-body">
            <form method="POST" action="' . ApplicationURL("ClientHome", "CustomerPartyLedger&NoHeader&NoFooter") . '">
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
';
?>
