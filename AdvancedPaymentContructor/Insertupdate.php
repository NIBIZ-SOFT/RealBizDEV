<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

// The default value of the input box will goes here according to how many fields we showing
$TheEntityName = array(

    "Type" => "",
    "AdjustedAmount" => "",
    "Amount" => "",

    "{$Entity}IsActive" => 1,
    "AdvancePaymentContructorIsDisplay" => 1
);


if (isset($_REQUEST[$Entity . "ID"]) && !isset($_REQUEST["DeleteConfirm"])) {
    $UpdateMode = true;
    $FormTitle = "Update $EntityCaption";
    $ButtonCaption = "Update";
    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction", $Entity . "ID={$_REQUEST[$Entity."ID"]}");

    if ($UpdateMode && !isset($_POST["" . $Entity . "ID"])) $TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} ", $OrderBy = "{$OrderByValue}", $SingleRow = true);

    $AdvancePaymentContructorDetails=SQL_Select("advancepaymentcontructor where VoucherNo={$TheEntityName["VoucherNo"]}");

    $TheEntityName["FormHeadOfAccountID"]=$AdvancePaymentContructorDetails[0]["HeadOfAccountID"];

    $TheEntityName["ToHeadOfAccountID"]=$AdvancePaymentContructorDetails[1]["HeadOfAccountID"];

    $TheEntityName["Amount"]=$AdvancePaymentContructorDetails[0]["dr"];

    $TheEntityName["PayDate"]=$AdvancePaymentContructorDetails[0]["Date"];
    $TheEntityName["Description"]=$AdvancePaymentContructorDetails[0]["Description"];
    $TheEntityName["VoucherNo"]=$AdvancePaymentContructorDetails[0]["VoucherNo"];

    $TheEntityName["AdvancePaymentContructorIsDisplay"]=$AdvancePaymentContructorDetails[0]["AdvancePaymentContructorIsDisplay"];


}

// Input sytem display goes here
$Input = array();
$Input[] = array("VariableName" => "FormHeadOfAccountID", "Caption" => "Head of Accounts(Dr.)", "ControlHTML" => GetExpenseID($Name = "FormHeadOfAccountID", $TheEntityName["FormHeadOfAccountID"], $Where = "", $PrependBlankOption = true));
$Input[] = array("VariableName" => "ToHeadOfAccountID", "Caption" => "Head of Accounts(Cr.)", "ControlHTML" => GetExpenseID($Name = "ToHeadOfAccountID", $TheEntityName["ToHeadOfAccountID"], $Where = "", $PrependBlankOption = true));

$Input[] = array("VariableName" => "Amount", "Caption" => "Amount", "ControlHTML" =>"<input type='number' name='Amount' value='".$TheEntityName["Amount"]."' />");
$Input[] = array("VariableName" => "BillDate", "Caption" => "Bill Date", "ControlHTML" =>"<input type='date' name='BillDate' value='".$TheEntityName["PayDate"]."' />");
$Input[] = array("VariableName" => "BillPhase", "Caption" => "Bill Phase", "ControlHTML" => CTL_InputText("BillPhase", $TheEntityName["BillPhase"], "", 30, "required"));

$Input[] = array("VariableName" => "MRBillNo", "Caption" => "MR / BillNo", "ControlHTML" => CTL_InputText("MRBillNo", $TheEntityName["MRBillNo"], "", 30, "required"));

$Input[] = array("VariableName" => "Description", "Caption" => "Description", "ControlHTML" => CTL_InputTextArea("Description", $TheEntityName["Description"], "", 4, "required").'<input name="VoucherNo" type="hidden" value="'.$TheEntityName["VoucherNo"].'" />');

$Input[]=array("VariableName"=>"IsDisplay", "Caption"=>"Confirm?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsDisplay", $Captions=array("No", "Yes"), $Values=array(1, 0), $CurrentValue=$TheEntityName["AdvancePaymentContructorIsDisplay"]), "Required"=>false);


$MainContent .= FormInsertUpdate(
    $EntityName = $EntityLower,
    $FormTitle,
    $Input,
    $ButtonCaption,
    $ActionURL
);

$MainContent .='

<script>

    var FormHeadOfAccountID=document.querySelector("select[name=FormHeadOfAccountID]");
    var ToHeadOfAccountID=document.querySelector("select[name=ToHeadOfAccountID]");
    
    var Amount=document.querySelector("input[name=Amount]");
    var Datess=document.querySelector("input[name=BillDate]");
    
    var form = document.querySelector("form");
    
    form.addEventListener("submit", function (ev) { 
        
        validation(FormHeadOfAccountID);
        validation(ToHeadOfAccountID);
        
        validation(Amount);
        validation(Datess);
         
        function validation(DOM) {
          if (DOM.value ===""  ){
                DOM.style.border="1px solid red";
                ev.preventDefault();
          }else{
                DOM.style.border="1px solid rgba(0,0,0,.2)";
          } 
        }
        
        
        var FormHeadOfAccountIDValue = FormHeadOfAccountID.value == "" ? 0 : parseFloat(FormHeadOfAccountID.value);
        var ToHeadOfAccountIDValue = ToHeadOfAccountID.value == "" ? 0 : parseFloat(ToHeadOfAccountID.value);
        
        checkDifferent( FormHeadOfAccountIDValue , ToHeadOfAccountIDValue , ToHeadOfAccountID );
        function checkDifferent( value1, value2, DOM ){
            
            if( ( value1 == value2 ) || ( value1 == 0  ||  value2 == 0 ) ){
                
                DOM.style.border="1px solid red";
                ev.preventDefault();
                
            }else{
                DOM.style.border="1px solid rgba(0,0,0,.2)";
            }
             
        }
       
     });


</script>

';

?>