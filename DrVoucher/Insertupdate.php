<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

// The default value of the input box will goes here according to how many fields we showing
$TheEntityName = array(
    "ProjectID" => "",
    "HeadOfAccountID" => "",
    "VoucherNo" => "",
    "ChequeNumber" => 0,
    "dr" => "",
    "cr" => "",
    "{$Entity}IsActive" => 1,
    "{$Entity}IsDisplay" => 1
);

if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"]) && !isset($_REQUEST["DeleteConfirm"])) {
    $UpdateMode = true;
    $FormTitle = "Update $EntityCaption";
    $ButtonCaption = "Update";
    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction", $Entity . "ID={$_REQUEST[$Entity."ID"]}&" . $Entity . "UUID={$_REQUEST[$Entity."UUID"]}");
    if ($UpdateMode && !isset($_POST["" . $Entity . "ID"])) $TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy = "{$OrderByValue}", $SingleRow = true);

    $ContructorID="";
    if ($TheEntityName["Type"]==1){
        $ContructorID= "selected";
    }
    $VendorID="";
    if ($TheEntityName["Type"]==2){
        $VendorID= "selected";
    }
    $OperationCost="";
    if ($TheEntityName["Type"]==4){
        $OperationCost= "selected";
    }
    $CustomerSelect="";
    if ($TheEntityName["Type"]==3){
        $CustomerSelect= "selected";
    }
}

$Vendor = SQL_Select("vendor ");
$VendorList = array();
foreach ($Vendor as $VendorItem) {
    $VendorList[] = array(
        "value" => $VendorItem["VendorID"],
        "text" => $VendorItem["VendorName"]
    );
}

$MainContent = '<style>

#Control_102{
    display: none;
}
#Control_103{
    display: none;
}
#Control_104{
    display: none;
}
    </style>';


$Input = array();
$Input[] = array("VariableName" => "Type", "Caption" => "Type", "ControlHTML" => '<select class="form-select" name="Type" id="MyType"><option value="0">Select Type</option><option '.$ContructorID.' value="1">Contructor</option><option '.$VendorID.' value="2">Vendor</option><option '.$CustomerSelect.' value="3">Customer</option><option '.$OperationCost.' value="4">Operation Cost/Others</option></select>');
                
$Input[] = array("VariableName" => "VendorID", "Caption" => "Vendor", "ControlHTML" => '
<select class="form-select" name="VendorID" id="">
<option value="" disabled ' . $VendorSelect . '>Select a vendor</option>' .
    implode('', array_map(function($option) use ($TheEntityName) {
        return '<option value="' . htmlspecialchars($option['value']) . '" ' . ($TheEntityName["VendorID"] == $option['value'] ? 'selected' : '') . '>' . htmlspecialchars($option['text']) . '</option>';
    }, $VendorList)) .
'</select>');


$Input[] = array("VariableName" => "ContructorID", "Caption" => "Contructor", "ControlHTML" => CCTL_Contructor($Name = "ContructorID", $TheEntityName["ContructorID"] , $Where = "", $PrependBlankOption = true));
$Input[] = array("VariableName" => "CustomerID", "Caption" => "Customer Name", "ControlHTML" => CCTL_Customer($Name = "CustomerID", $ValueSelected = $TheEntityName["CustomerID"], $Where = "", $PrependBlankOption = true));


$Input[] = array("VariableName" => "FormProjectID", "Caption" => "Project Name", "ControlHTML" => CCTL_ProductsCategory($Name = "ProjectID", $TheEntityName["ProjectID"], $Where = "", $PrependBlankOption = true));
$Input[] = array("VariableName" => "BankCashID", "Caption" => "Cash Type", "ControlHTML" => CCTL_BankCash($Name = "BankCashID", $TheEntityName["BankCashID"], $Where = "", $PrependBlankOption = false));
$Input[] = array("VariableName" => "checkNumberArea", "Caption" => "Cheque Number", "ControlHTML" => '<input class="form-control form-control-lg" type="text" id="ChequeNumber" name="ChequeNumber" value="' . htmlspecialchars($TheEntityName["ChequeNumber"]) . '" size="30" class="" >');

$Settings = SQL_Select("Settings", "", "", true);
$Divitions = explode(",", $Settings["Division"]);//Array ( [0] => Corporate [1] => Director [2] => SSD [3] => CSD [4] => new )
$DivitionList = array();
foreach ($Divitions as $Divition) {
    $DivitionList[] = array(
        "value" => $Divition,
        "text" => $Divition
    );
}
$Input[] = array("VariableName" => "Division", "Caption" => "Division", "ControlHTML" => '
<select class="form-select" name="Division" id="Division">
    <option value="" disabled selected>Select Division</option>' .
    implode('', array_map(function($option) use ($TheEntityName) {
        return '<option value="' . htmlspecialchars($option['value']) . '" ' . ($TheEntityName["Division"] == $option['value'] ? 'selected' : '') . '>' . htmlspecialchars($option['text']) . '</option>';
    }, $DivitionList)) .
'</select>');

$GroupTransations = SQL_Select("drVoucher", "VoucherNo = '{$TheEntityName['VoucherNo']}'");
$Head = SQL_Select("expensehead", "ExpenseHeadIsActive = 1");
$HeadOfAccountID = array();
foreach ($Head as $HeadOfAccount) {
    $HeadOfAccountID[] = array(
        "value" => $HeadOfAccount["ExpenseHeadID"],
        "text" => $HeadOfAccount["ExpenseHeadName"]
    );
}




if (count($GroupTransations) > 1) {
    $Add = true;
    foreach ($GroupTransations as $GroupTransation) {
        $ButtonHTML = '';

        if ($Add) {
            $ButtonHTML = '<button type="button" class="btn btn-success btn-add"><i class="glyphicon glyphicon-plus">+</i></button>';
            $Add = false;
        } else {
            $ButtonHTML = '<button type="button" class="btn btn-danger btn-remove"><i class="glyphicon glyphicon-minus">-</i></button>';
        }
//echo $GroupTransation['HeadOfAccountID'];
        $Input[] = array(
            "VariableName" => "AccountAmountGroup",
            "Caption" => "Head Of Account & Amount",
            "ControlHTML" => '
        <div class="account-amount-group row mb-2">
            <div class="col-12 col-md-6 mb-2 mb-md-0">         
               <select class="form-select" name="HeadOfAccountID[]" required>
                    <option value="" disabled selected>Select Head Of Account</option>' .
                    implode('', array_map(function($option) use ($GroupTransation) {
                        return '<option value="' . htmlspecialchars($option['value']) . '" ' . ($GroupTransation['HeadOfAccountID'] == $option['value'] ? 'selected' : '') . '>' . htmlspecialchars($option['text']) . '</option>';
                    }, $HeadOfAccountID)) .
                '</select>
                
            </div>
            <div class="col-6 col-md-3 mb-2 mb-md-0">
                <input type="text" name="Amount[]" value="' . htmlspecialchars($GroupTransation["Amount"]) . '" size="5" class="form-control required" required>
            </div>
            <div class="col-6 col-md-3">
                ' . $ButtonHTML . '
            </div>
        </div>'
        );
    }
}else{
    $Input[] = array(
        "VariableName" => "AccountAmountGroup",
        "Caption" => "Head Of Account & Amount",
        "ControlHTML" => '
        <div class="account-amount-group row mb-2">
           <div class="col-12 col-md-6 mb-2 mb-md-0">' .
            GetExpenseID("HeadOfAccountID[]", "{$TheEntityName['HeadOfAccountID']}", "", true) . '
            </div>
            <div class="col-6 col-md-3 mb-2 mb-md-0">
                <input type="text" name="Amount[]" value="' . htmlspecialchars($TheEntityName["Amount"]) . '" size="5" class="form-control required" required>
            </div>
            <div class="col-6 col-md-3">
                <button type="button" class="btn btn-success btn-add"><i class="glyphicon glyphicon-plus">+</i></button>
            </div>
        </div>'
    );
}


$Input[] = array("VariableName" => "BillNo", "Caption" => "M.R/Bill No", "ControlHTML" => CTL_InputText($Name = "BillNo", $TheEntityName["BillNo"], "", 30, ""));
$Input[] = array("VariableName" => "Date", "Caption" => "Date", "ControlHTML" => '<div class="input-group mb-3"><input class="form-control" type="date" id="Date" name="Date" value="' . htmlspecialchars($TheEntityName["Date"], ENT_QUOTES, 'UTF-8') . '" size="30" class="required" required></div>');
$Input[] = array("VariableName" => "Description", "Caption" => "Particulars", "ControlHTML" => CTL_InputTextArea("Description", $TheEntityName["Description"], "", 5, ""). '<input name="VoucherNo" type="hidden" value="' . $TheEntityName["VoucherNo"] . '" />');
$Input[] = array("VariableName" => "ProductsImage", "Caption" => "Image", "ControlHTML" => CTL_ImageUpload($ControlName = "Image", $CurrentImage01 = $TheEntityName["Image"], $AllowDelete = true, $Class = "FormTextInput", $ThumbnailHeight = 100, $ThumbnailWidth = 0, $Preview = true));
$Input[] = array("VariableName" => "IsDisplay", "Caption" => "Confirm?", "ControlHTML" => CTL_InputRadioSet($VariableName = "{$Entity}IsDisplay", $Captions = array("No", "Yes"), $Values = array(1, 0), $CurrentValue = $TheEntityName["{$Entity}IsDisplay"]), "Required" => false);
$MainContent .= FormInsertUpdate(
    $EntityName = $EntityLower,
    $FormTitle,
    $Input,
    $ButtonCaption,
    $ActionURL
);

$MainContent .= "
<script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.btn-add', function() {
            var group = $(this).closest('.account-amount-group');
            var newGroup = group.clone();

            newGroup.find('.btn-add')
                .removeClass('btn-success btn-add')
                .addClass('btn-danger btn-remove')
                .html('<i class=\"glyphicon glyphicon-minus\"> - </i>');
            newGroup.find('select').val('');
            newGroup.find('input').val('');
            $('.account-amount-group').last().after(newGroup);
        });

        $(document).on('click', '.btn-remove', function() {
            $(this).closest('.account-amount-group').remove();
        });



    var select = document.getElementById('MyType');

    select.addEventListener('change', function () {
        var selectedValue = this.value;

        document.getElementById('Control_102').style.display = 'none';
        document.getElementById('Control_103').style.display = 'none';
        document.getElementById('Control_104').style.display = 'none';

        if (selectedValue === '1') {
            document.getElementById('Control_103').style.display = 'block';
        } else if (selectedValue === '2') {
            document.getElementById('Control_102').style.display = 'block';
        } else if (selectedValue === '3') {
            document.getElementById('Control_104').style.display = 'block';
        }
    });

    select.dispatchEvent(new Event('change'));

    });

    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('basic_validate').removeAttribute('novalidate');

        const selectElements = document.querySelectorAll('select[name=\"HeadOfAccountID[]\"]');

        selectElements.forEach(function(select) {
            select.setAttribute('required', 'required');
            select.classList.add('ProjectNameClass');
        });

        const selectElementsProject = document.querySelectorAll('.ProjectNameClass');

        selectElementsProject.forEach(function(select) {
            select.setAttribute('required', 'required');
        });
    });
</script>
";

?>