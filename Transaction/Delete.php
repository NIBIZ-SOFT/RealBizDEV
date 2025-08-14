<?php
// Assuming connection is already made and SQL_Select and SQL_Delete are defined functions.

// First, get all vouchers without transactions from all 4 voucher types:
function getVouchersWithoutTransaction() {
    $result = [];

    // CV
    $Crvoucher = SQL_Select("crVoucher", "CrVoucherIsDisplay = 0");
    foreach ($Crvoucher as $value) {
        $voucherID = $value['CrVoucherID'];
        $Transaction = SQL_Select("transaction", "VoucherType = 'CV' AND VoucherNo = '{$voucherID}'");
        if (empty($Transaction)) {
            $result[] = ['type' => 'CV', 'voucherID' => $voucherID];
        }
    }

    // DV
    $Drvoucher = SQL_Select("drvoucher", "DrVoucherIsDisplay = 0");
    foreach ($Drvoucher as $value) {
        $voucherID = $value['VoucherNo'];
        $Transaction = SQL_Select("transaction", "VoucherType = 'DV' AND VoucherNo = '{$voucherID}'");
        if (empty($Transaction)) {
            $result[] = ['type' => 'DV', 'voucherID' => $voucherID];
        }
    }

    // JV
    $JvVoucher = SQL_Select("journalvoucher", "JournalVoucherIsDisplay = 0");
    foreach ($JvVoucher as $value) {
        $voucherID = $value['VoucherNo'];
        $Transaction = SQL_Select("transaction", "VoucherType = 'JV' AND VoucherNo = '{$voucherID}'");
        if (empty($Transaction)) {
            $result[] = ['type' => 'JV', 'voucherID' => $voucherID];
        }
    }

    // Contra
    $Contravoucher = SQL_Select("contravoucher", "ContraVoucherIsDisplay = 0");
    foreach ($Contravoucher as $value) {
        $voucherID = $value['VoucherNo'];
        $Transaction = SQL_Select("transaction", "VoucherType = 'Contra' AND VoucherNo = '{$voucherID}'");
        if (empty($Transaction)) {
            $result[] = ['type' => 'Contra', 'voucherID' => $voucherID];
        }
    }

    return $result;
}

// Handle AJAX delete request
if (isset($_POST['action']) && $_POST['action'] === 'delete_voucher') {
    $voucherType = isset($_POST['voucherType']) ? trim($_POST['voucherType']) : '';
    $voucherID = isset($_POST['voucherID']) ? trim($_POST['voucherID']) : '';

    if ($voucherType && $voucherID) {
        // Delete voucher by type
        if ($voucherType == 'CV') {
            SQL_Delete("crVoucher where CrVoucherID = '{$voucherID}'");
        } elseif ($voucherType == 'DV') {
            SQL_Delete("drvoucher where VoucherNo = '{$voucherID}'");
        } elseif ($voucherType == 'JV') {
            SQL_Delete("journalvoucher where VoucherNo = '{$voucherID}'");
        } elseif ($voucherType == 'Contra') {
            SQL_Delete("contravoucher where VoucherNo = '{$voucherID}'");
        }

        // Also delete related transactions if any
        SQL_Delete("transaction where VoucherType = '{$voucherType}' AND VoucherNo = '{$voucherID}'");

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid voucher type or ID']);
    }
    exit;
}

$vouchers = getVouchersWithoutTransaction();

$MainContent = '

<style>
    table { border-collapse: collapse; width: 80%; margin: 20px auto; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }

    button.delete-btn { background-color: #e74c3c; color: white; border: none; padding: 6px 12px; cursor: pointer; }
    button.delete-btn:hover { background-color: #c0392b; }
    .message { width: 80%; margin: 10px auto; font-family: Arial, sans-serif; color: green; }
</style>

<h2 style="text-align:center;">Vouchers Available But No Transactions</h2>

<table id="voucherTable" align="center">
    <thead>
        <tr>
            <th>Voucher Type</th>
            <th>Voucher ID</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
';

foreach ($vouchers as $v) {
    $MainContent .= "<tr data-type='{$v['type']}' data-id='{$v['voucherID']}'>
        <td>{$v['type']}</td>
        <td>{$v['voucherID']}</td>
        <td><button class='delete-btn'>Delete</button></td>
    </tr>";
}

$MainContent .= '
    </tbody>
</table>

<div class="message" id="message"></div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const table = document.getElementById("voucherTable");
    const messageDiv = document.getElementById("message");

    table.addEventListener("click", function(e) {
        if (e.target && e.target.classList.contains("delete-btn")) {
            const row = e.target.closest("tr");
            const voucherType = row.getAttribute("data-type");
            const voucherID = row.getAttribute("data-id");

            if (confirm("Are you sure you want to delete Voucher Type: " + voucherType + ", ID: " + voucherID + "?")) {
                // Send AJAX request to delete
                fetch("", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: new URLSearchParams({
                        action: "delete_voucher",
                        voucherType: voucherType,
                        voucherID: voucherID
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageDiv.textContent = "Deleted voucher " + voucherType + " with ID " + voucherID;
                        row.remove();
                    } else {
                        messageDiv.textContent = "Error: " + (data.message || "Could not delete voucher.");
                    }
                })
                .catch(err => {
                    messageDiv.textContent = "Error deleting voucher.";
                });
            }
        }
    });
});
</script>
';