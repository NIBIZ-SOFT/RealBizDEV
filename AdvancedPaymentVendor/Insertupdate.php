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
    "{$Entity}IsDisplay" => 1
);



if (isset($_REQUEST[$Entity . "ID"]) && !isset($_REQUEST["DeleteConfirm"])) {
    $UpdateMode = true;
    $FormTitle = "Update $EntityCaption";
    $ButtonCaption = "Update";


    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction", $Entity . "ID={$_REQUEST[$Entity."ID"]}");
    if ($UpdateMode && !isset($_POST["" . $Entity . "ID"])) $TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} ", $OrderBy = "{$OrderByValue}", $SingleRow = true);


    $advancedpaymentvendorDetails=SQL_Select("advancedpaymentvendor where VoucherNo='{$TheEntityName["VoucherNo"]}'");


    $TheEntityName["FormProjectID"]=$advancedpaymentvendorDetails[0]["CategoryID"];
    $TheEntityName["FormHeadOfAccountID"]=$advancedpaymentvendorDetails[0]["HeadOfAccountID"];

    $TheEntityName["ToProjectID"]=$advancedpaymentvendorDetails[1]["CategoryID"];
    $TheEntityName["ToHeadOfAccountID"]=$advancedpaymentvendorDetails[1]["HeadOfAccountID"];

    $TheEntityName["Amount"]=$advancedpaymentvendorDetails[0]["dr"];
    $TheEntityName["PayDate"]=$advancedpaymentvendorDetails[0]["PayDate"];
    $TheEntityName["Description"]=$advancedpaymentvendorDetails[0]["Description"];
    $TheEntityName["VoucherNo"]=$advancedpaymentvendorDetails[0]["VoucherNo"];

    $TheEntityName["{$Entity}IsDisplay"]=$advancedpaymentvendorDetails[0]["AdvancedPaymentVendorIsDisplay"];


//    echo "<pre>";
//    print_r($TheEntityName);
//    die();

}

// Input sytem display goes here
$Input = array();

$Input[] = array("VariableName" => "FormHeadOfAccountID", "Caption" => "Head of Accounts(Dr.)", "ControlHTML" => GetExpenseID($Name = "FormHeadOfAccountID", $TheEntityName["FormHeadOfAccountID"], $Where = "", $PrependBlankOption = true));
$Input[] = array("VariableName" => "ToHeadOfAccountID", "Caption" => "Head of Accounts(Cr.)", "ControlHTML" => GetExpenseID($Name = "ToHeadOfAccountID", $TheEntityName["ToHeadOfAccountID"], $Where = "", $PrependBlankOption = true));


//$Input[] = array("VariableName" => "Title", "Caption" => "Title", "ControlHTML" => CTL_InputText("Title", $TheEntityName["Title"], "", 30, "required"));



$Input[] = array("VariableName" => "Amount", "Caption" => "Amount", "ControlHTML" => CTL_InputText("Amount", $TheEntityName["Amount"], "", 30, "required"));
$Input[] = array("VariableName" => "Date", "Caption" => "Date", "ControlHTML" => CTL_InputText("PayDate", $TheEntityName["PayDate"], "", 30, "required"));
//$Input[] = array("VariableName" => "IsActive", "Caption" => "cr/dr?", "ControlHTML" => CTL_InputRadioSet($VariableName = "crdr", $Captions = array("cr", "dr"), $Values = array(1, 0), $CurrentValue = "", "Required", false));
$Input[] = array("VariableName" => "Description", "Caption" => "Description", "ControlHTML" => CTL_InputTextArea("Description", $TheEntityName["Description"], "", 8, "required").'<input name="VoucherNo" type="hidden" value="'.$TheEntityName["VoucherNo"].'" />');

$Input[]=array("VariableName"=>"IsDisplay", "Caption"=>"Confirm?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsDisplay", $Captions=array("No", "Yes"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsDisplay"]), "Required"=>false);


//$Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);

$MainContent .= FormInsertUpdate(
    $EntityName = $EntityLower,
    $FormTitle,
    $Input,
    $ButtonCaption,
    $ActionURL
);


$MainContent .= '

    <script> 
    
    $("input").attr("autocomplete","off");
    
   
    var FormHeadOfAccountID=document.querySelector("select[name=FormHeadOfAccountID]");
    
    var ToHeadOfAccountID=document.querySelector("select[name=ToHeadOfAccountID]");
    
    
    var Amount=document.querySelector("input[name=Amount]");
    var Datess=document.querySelector("input[name=PayDate]");
    
    Amount.type="number";
    
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