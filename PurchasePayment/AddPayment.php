<?php
// ...existing code...

// Get ID from URL parameter
$purchaseId = isset($_GET['ID']) ? intval($_GET['ID']) : 0;

// Default values
$categoryName = '';
$vendorName = '';
$today = date('Y-m-d');
$totalAmount = 0;
$totalDr = 0;
$dueAmount = 0;

// Fetch purchase info if ID is provided (PHP 5.6 + mysql, connection already exists)
if ($purchaseId > 0) {
    $purchaseId = intval($purchaseId);
    // Get CategoryName, VendorName, and PurchaseAmount from tblpurchase
    $result = mysql_query("SELECT CategoryID,CategoryName, VendorID,VendorName, PurchaseAmount FROM tblpurchase WHERE PurchaseID = $purchaseId");
    if ($row = mysql_fetch_assoc($result)) {
        $categoryName = $row['CategoryName'];
        $vendorName = $row['VendorName'];
        $CategoryID = $row['CategoryID'];
        $VendorID = $row['VendorID'];
        $totalAmount = floatval($row['PurchaseAmount']);
    }
    mysql_free_result($result);

    // Get total dr from tbltransaction for this PurchaseID
    $result2 = mysql_query("SELECT SUM(dr) as totalDr FROM tbltransaction WHERE PurchaseID = '$purchaseId'");
    if ($row2 = mysql_fetch_assoc($result2)) {
        $totalDr = floatval($row2['totalDr']);
    }
    mysql_free_result($result2);

    // Calculate due amount
    $dueAmount = $totalAmount - $totalDr;
}

// Project and Vendor Info Box (AdminKit style)
$MainContent .= '
<div class="mt-4">
    <div class="card mb-3 shadow-sm">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <span class="fw-bold text-muted">Project Name:</span> <span class="text-primary">'.htmlspecialchars($categoryName).'</span>
            </div>
            <div>
                <span class="fw-bold text-muted">Vendor Name:</span> <span class="text-success">'.htmlspecialchars($vendorName).'</span>
            </div>
        </div>
    </div>
</div>
';

// Total, Paid, and Due Box with Print Button (AdminKit style)
$MainContent .= '
<div class="">
    <div class="d-flex justify-content-between align-items-center mb-3" style="max-width:700px;">
        <ul class="list-group list-group-horizontal mb-0" style="max-width:540px;">
            <li class="list-group-item flex-fill text-center bg-primary text-white border-0 rounded-start">
                <div class="fw-bold small">Total Amount</div>
                <div class="fs-4">'.number_format($totalAmount,2).'</div>
            </li>
            <li class="list-group-item flex-fill text-center bg-success text-white border-0">
                <div class="fw-bold small">Paid Amount</div>
                <div class="fs-4">'.number_format($totalDr,2).'</div>
            </li>
            <li class="list-group-item flex-fill text-center bg-warning text-white border-0">
                <div class="fw-bold small">Due Amount</div>
                <div class="fs-4">'.number_format($dueAmount,2).'</div>
            </li>
        </ul>
        <a href="index.php?Theme=default&Base=PurchasePayment&Script=report&NoHeader&NoFooter&ID='.$purchaseId.'" target="_blank" class="btn btn-outline-secondary ms-3">
            <i class="align-middle" data-feather="printer"></i> Print
        </a>
    </div>
</div>
';

// Add Payment Title and Form with Card (AdminKit style, Head Of Account first)
$MainContent .= '
<div class="">
    <div class="card shadow mb-5">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Add New Payment</h4>
        </div>
        <div class="card-body">
            <form id="paymentForm" method="post" enctype="multipart/form-data" action="./index.php?Theme=default&Base=PurchasePayment&Script=AddPaymentAction&ID='.$purchaseId.'" onsubmit="return validateAmount();">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <input type="hidden" name="ProjectID" value="'.$CategoryID.'">
                        <input type="hidden" name="VendorID" value="'.$VendorID.'">
                        <label class="form-label">Head Of Account Name <span class="text-danger">*</span></label>
                        '.GetExpenseID($Name = "HeadOfAccountID", $TheEntityName["HeadOfAccountID"], $Where = "", $PrependBlankOption = true).'
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bank/Cash Name</label>
                        '.CCTL_BankCash($Name = "BankCashID", $TheEntityName["BankCashID"], $Where = "", $PrependBlankOption = false).'
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Cheque Number</label>
                        <input type="text" class="form-control" name="ChequeNumber">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="Date" value="'.$today.'">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" name="Description">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bill No</label>
                        <input type="text" class="form-control" name="BillNo">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Amount 
                            <span class="text-muted" style="font-size:12px;">
                                (Total: '.number_format($totalAmount,2).' | Paid: '.number_format($totalDr,2).' | Due: '.number_format($dueAmount,2).')
                            </span>
                        </label>
                        <input type="number" step="0.01" class="form-control" name="Amount" id="Amount" max="'.htmlspecialchars($dueAmount).'" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" name="Image">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit Payment</button>
            </form>
        </div>
    </div>
</div>
<script>
function validateAmount() {
    var amount = parseFloat(document.getElementById("Amount").value);
    var due = '.floatval($dueAmount).';
    var headOfAccount = document.getElementsByName("HeadOfAccountID")[0].value;
    if (isNaN(amount) || amount <= 0) {
        alert("Please enter a valid amount.");
        return false;
    }
    if (amount > due) {
        alert("Amount cannot be more than Due Amount ('.number_format($dueAmount,2).').");
        return false;
    }
    if (!headOfAccount) {
        alert("Please select Head Of Account Name.");
        return false;
    }
    return true;
}
</script>
';

// Payment History Section with Card
$historyHtml = '
<div class="mt-5">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h4 class="mb-0">Payment History</h4>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Bank/Cash</th>
                        <th>Head Of Account</th>
                        <th>Cheque Number</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
';


$historyResult = mysql_query("SELECT TransactionID, Date, BankCashName, HeadOfAccountName, ChequeNumber, dr, Description, Image FROM tbltransaction WHERE PurchaseID = '$purchaseId' ORDER BY TransactionID DESC");
while ($row = mysql_fetch_assoc($historyResult)) {
    $imgHtml = '';
    if (!empty($row['Image'])) {
        $imgHtml = '<a href="./upload/'.$row['Image'].'" target="_blank">View</a>';
    }
    $historyHtml .= '
        <tr>
            <td>'.htmlspecialchars($row['Date']).'</td>
            <td>'.htmlspecialchars($row['BankCashName']).'</td>
            <td>'.htmlspecialchars($row['HeadOfAccountName']).'</td>
            <td>'.htmlspecialchars($row['ChequeNumber']).'</td>
            <td>'.number_format($row['dr'],2).'</td>
            <td>'.htmlspecialchars($row['Description']).'</td>
            <td>'.$imgHtml.'</td>
            <td>
                <form method="post" action="" onsubmit="return confirm(\'Are you sure to delete this payment?\');" style="display:inline;">
                    <input type="hidden" name="delete_transaction_id" value="'.$row['TransactionID'].'">
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </td>
        </tr>
    ';
}
mysql_free_result($historyResult);

$historyHtml .= '
                </tbody>
            </table>
        </div>
    </div>
</div>
';

// Handle delete action
if (isset($_POST['delete_transaction_id'])) {
    $deleteId = intval($_POST['delete_transaction_id']);
    mysql_query("DELETE FROM tbltransaction WHERE TransactionID = $deleteId");
    echo '<script>alert("Payment deleted.");window.location.href=window.location.href;</script>';
    exit;
}

$MainContent .= $historyHtml;