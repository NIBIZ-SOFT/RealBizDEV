<?php


        // Get Purchase ID from URL
        $purchaseId = isset($_GET['ID']) ? intval($_GET['ID']) : 0;
        $voucherNo = $purchaseId;

        $_POST["Image"] = ProcessUpload("Image", $Application["UploadPath"]);


        $TheEntityName = SQL_InsertUpdate(
            $Entity = "transaction",
            $TheEntityNameData = array(
                "ProjectID" => $_POST["ProjectID"],
                "ProjectName" => GetProjectName($_POST["ProjectID"]),
                "BankCashID" => $_POST["BankCashID"],
                "BankCashName" => GetBankCashTitle($_POST["BankCashID"]),
                "HeadOfAccountID" => $_POST["HeadOfAccountID"],
                "HeadOfAccountName" => GetExpenseHeadName($_POST["HeadOfAccountID"]),
                "Date" => $_POST["Date"],
                "Description" => $_POST["Description"],
                "cr" => 0,
                "dr" => $_POST["Amount"],
                "VoucherNo" => $voucherNo,
                "PurchaseID" => $voucherNo,
                "VoucherType" => "DV",
                "VendorID" => $_POST["VendorID"],
                "VendorName" => GetVendorName($_POST["VendorID"]),
                "Image" => $_POST["Image"],
                "ChequeNumber" => $_POST["ChequeNumber"],

            ),
            ""
        );


        // Redirect with floating message
        echo '
        <script>
            alert("Payment added");
            window.location.href = "index.php?Theme=default&Base=PurchasePayment&Script=AddPayment&ID='.$purchaseId.'";
        </script>
        ';
        exit;

?>