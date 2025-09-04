<?

include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
if (isset($_REQUEST["CrVoucherID"]) && isset($_REQUEST[$Entity . "UUID"])) $UpdateMode = true;

$ErrorUserInput["_Error"] = false;

if (!$UpdateMode) $_REQUEST["{$Entity}ID"] = 0;
//some change goes here
$TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$UniqueField} = '{$_POST["{$UniqueField}"]}' AND {$Entity}ID <> {$_REQUEST["CrVoucherID"]}");
if (count($TheEntityName) > 0) {
    $ErrorUserInput["_Error"] = true;
    $ErrorUserInput["_Message"] = "This Value Already Taken.";
}



if ($ErrorUserInput["_Error"]) {
    include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
} else {

    if (!empty($_REQUEST["CrVoucherUUID"])) {
        $voucherNo = $_REQUEST["CrVoucherID"];
    } else {
        $voucherNo = null;
    }


    $Where = "";
    if ($UpdateMode) $Where = "CrVoucherID = {$_REQUEST["CrVoucherID"]} AND CrVoucherUUID = '{$_REQUEST["CrVoucherUUID"]}'";

    if (empty($_POST["ProductsID"])) {
        $_POST["ProductsID"] = 0;
    }

    $_POST["Image"]    = ProcessUpload("Image", $Application["UploadPath"]);

    $SaleX = SQL_Select("sales", "SalesID='{$_REQUEST["SaleID"]}'", "", true);

    $TheEntityName = SQL_InsertUpdate(
        $Entity = "{$Entity}",
        $TheEntityNameData = array(

            "ProjectID" => $_POST["ProjectID"],
            "ProjectName" => GetProjectName($_POST["ProjectID"]),
            "Division" => $_POST["Division"],

            "BankCashID" => $_POST["BankCashID"],
            "BankCashName" => GetBankCashTitle($_POST["BankCashID"]),

            "ChequeNumber" => $_POST["ChequeNumber"],

            "HeadOfAccountID" => $_POST["HeadOfAccountID"],
            "HeadOfAccountName" => GetExpenseHeadName($_POST["HeadOfAccountID"]),

            "BillNo" => $_POST["BillNo"],
            "Date" => $_POST["Date"],

            "Description" => $_POST["Description"],
            "Type" => $_POST["Type"],
            "SalesID" => $_REQUEST["SaleID"],

            "Name" => $_POST["Name"],
            "CustomerID" => $SaleX["CustomerID"],
            "CustomerName" => GetCustomerName($SaleX["CustomerID"]),


            "ProductsID" => $_POST["ProductsID"],

            "Amount" => $_POST["Amount"],
            "BankCharge" => $_POST["BankCharge"],
            "Image" => $_POST["Image"],

            "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],

        ),
        $Where
    );

    //ac


    if ($voucherNo === null) {
        if ($UpdateMode == false) {
            $voucherNo = $TheEntityName["CrVoucherID"];
        } else {
            $voucherNo = $_REQUEST["CrVoucherID"];
        }
    }
    if ($_POST["CrVoucherIsDisplay"] == 0 && $_REQUEST["SaleID"] != "") {
        SQL_InsertUpdate(
            $Entity = "Actualsalsepayment",
            $TheEntityNameData = array(

                "ProjectID" => $_POST["ProjectID"],
                "ProjectName" => GetProjectName($_POST["ProjectID"]),

                "CustomerID" => $SaleX["CustomerID"],
                "CustomerName" => GetCustomerName($SaleX["CustomerID"]),
                "SalesID" => $_REQUEST["SaleID"],
                "Term" => $_POST["Title"],
                "ReceiveAmount" => $_POST["Amount"],
                "Adjustment" => 0,
                "ActualReceiveAmount" => $_POST["Amount"],
                "DateOfCollection" => $_POST["Date"],
                "MRRNO" => $voucherNo,
                "ModeOfPayment" => GetBankCashTitle($_POST["BankCashID"]),
                "ChequeNo" => $_POST["ChequeNumber"],
                "BankName" => GetBankCashTitle($_POST["BankCashID"]),
                "Remark" => $_POST["Description"],

                "ActualSalsePaymentIsActive" => $_REQUEST["ActualSalsePaymentIsActive"],
            )
        );
    }
    //ac


    ////        Transaction made final.
    //
    if ($_POST["CrVoucherIsDisplay"] == 0) {

        $Where = "";

        $CheckforVoucerEntry = SQL_Select("Transaction", "VoucherNo='{$voucherNo}' and VoucherType='CV' ", "", true);

        if ($CheckforVoucerEntry["cr"] == "")
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
                    "Division" => $_POST["Division"],

                    "Description" => $_POST["Description"],
                    "dr" => 0,
                    "cr" => $_POST["Amount"],
                    "VoucherNo" => $voucherNo,
                    "VoucherType" => "CV",

                    "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
                ),
                $Where
            );


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
                "Division" => $_POST["Division"],

                "Description" => $_POST["Description"],
                "dr" => 0,
                "cr" => $_POST["Amount"],
                "VoucherNo" => $voucherNo,
                "VoucherType" => "CV",

                "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
            ),
            "VoucherNo='{$voucherNo}'  and VoucherType='CV' "
        );


        /// Bank Charge Entry ////

        if ($_POST["BankCharge"] > 0) {

            if ($CheckforVoucerEntry["cr"] == "")
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
                        "dr" => $_POST["BankCharge"],
                        "cr" => 0,
                        "VoucherNo" => $voucherNo,
                        "VoucherType" => "DV",

                        "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
                    ),
                    ""
                );


            $TheEntityName = SQL_InsertUpdate(
                $Entity = "transaction",
                $TheEntityNameData = array(

                    "ProjectID" => $_POST["ProjectID"],
                    "ProjectName" => GetProjectName($_POST["ProjectID"]),

                    "BankCashID" => $_POST["BankCashID"],
                    "BankCashName" => GetBankCashTitle($_POST["BankCashID"]),

                    "HeadOfAccountID" => 1914,
                    "HeadOfAccountName" => GetExpenseHeadName(1914),

                    "Date" => $_POST["Date"],

                    "Description" => $_POST["Description"],
                    "dr" => $_POST["BankCharge"],
                    "cr" => 0,
                    "VoucherNo" => $voucherNo,
                    "VoucherType" => "DV",

                    "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
                ),
                "VoucherNo='{$voucherNo}' and cr='0' and VoucherType='DV'"
            );
        }



        /// End of Bank Charges



        //Send SMS Notification...

        $mobile_no = GetCustomerPhone($SaleX["CustomerID"]);
        $message = "
Dear Customer,
Your Payment {$_POST["Amount"]}Tk. received. Voucher No. {$voucherNo}
Thanks,
Sunset
            ";

        n_bulk_sms($mobile_no, $message);
    }

    if ($_POST["CrVoucherIsDisplay"] == 1 && !empty($voucherNo)) {
        SQL_Delete("transaction where VoucherNo = '{$voucherNo}' and VoucherType ='CV' ");
        SQL_Delete("Actualsalsepayment where MRRNO = '{$voucherNo}'");
    }
    print_r($_POST["CrVoucherIsDisplay"]);



    $MainContent .= "
	        " . CTL_Window($Title = "Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"" . ApplicationURL("{$_REQUEST["Base"]}", "Manage") . "\">here</a> to proceed.", 300) . "
	        <script language=\"JavaScript\" >
	           window.location='" . ApplicationURL("{$_REQUEST["Base"]}", "Manage") . "';
	        </script>
		";
}
