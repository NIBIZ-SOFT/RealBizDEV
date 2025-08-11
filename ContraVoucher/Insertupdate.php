<?


include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

// The default value of the input box will goes here according to how many fields we showing
$TheEntityName = array(

    "ProjectName" => "",
    "BankCashName" => "",
    "HeadOfAccountName" => "",
    "ChequeNumber" => "",
    "VoucherNo" => "",
    "dr" => "",
    "cr" => "",

    "{$Entity}IsActive" => 0,
    "{$Entity}IsDisplay" => 1
);

if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"]) && !isset($_REQUEST["DeleteConfirm"])) {
    $UpdateMode = true;
    $FormTitle = "Update $EntityCaption";
    $ButtonCaption = "Update";
    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction", $Entity . "ID={$_REQUEST[$Entity."ID"]}&" . $Entity . "UUID={$_REQUEST[$Entity."UUID"]}");

    if($TheEntityName["{$Entity}IsDisplay"]==0){

        header("location:index.php?Theme=default&Base={$Entity}&Script=Manage");

    }


    if ($UpdateMode && !isset($_POST["" . $Entity . "ID"])) $TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy = "{$OrderByValue}", $SingleRow = true);





    $contravoucherDetails=SQL_Select("contravoucher where VoucherNo={$TheEntityName["VoucherNo"]}");



    $TheEntityName["formAccaunt"]=$contravoucherDetails[0]["BankCashID"];
    $TheEntityName["toAccaunt"]=$contravoucherDetails[1]["BankCashID"];



    $TheEntityName["Amount"]=$contravoucherDetails[0]["dr"];


    $TheEntityName["Date"]=$contravoucherDetails[0]["Date"];
    $TheEntityName["Description"]=$contravoucherDetails[0]["Description"];
    $TheEntityName["VoucherNo"]=$contravoucherDetails[0]["VoucherNo"];

    $TheEntityName["{$Entity}IsDisplay"]=$contravoucherDetails[0]["ContraVoucherIsDisplay"];


}

// Input sytem display goes here
$Input = array();

$Input[] = array("VariableName" => "ProjectName", "Caption" => "ProjectName", "ControlHTML" => CCTL_ProductsCategory($Name = "ProjectID", $TheEntityName["ProjectID"], $Where = "", $PrependBlankOption = true));

$Input[] = array("VariableName" => "formAccaunt", "Caption" => "Head of Accounts(Dr Bank/Cash)", "ControlHTML" => CCTL_BankCash($Name = "formAccaunt", $TheEntityName["formAccaunt"], $Where = "", $PrependBlankOption = false));
$Input[] = array("VariableName" => "toAccaunt", "Caption" => "Head of Accounts(Cr Bank/Cash)", "ControlHTML" => CCTL_BankCash($Name = "toAccaunt", $TheEntityName["toAccaunt"], $Where = "", $PrependBlankOption = false));
$Input[] = array("VariableName" => "ChequeNumber", "Caption" => "ChequeNumber", "ControlHTML" => CTL_InputText("ChequeNumber", $TheEntityName["ChequeNumber"], "", 30, "required"));

//$Input[] = array("VariableName" => "HeadOfAccountName", "Caption" => "HeadOfAccountName", "ControlHTML" => GetExpenseID($Name = "HeadOfAccountID", $TheEntityName["HeadOfAccountID"], $Where = "", $PrependBlankOption = true));

$Input[] = array("VariableName" => "Amount", "Caption" => "Amount", "ControlHTML" => CTL_InputText("Amount", $TheEntityName["Amount"], "", 30, "required"));
$Input[] = array("VariableName" => "Date", "Caption" => "Date", "ControlHTML" => CTL_InputText("Date", $TheEntityName["Date"], "", 30, "required"));
$Input[] = array("VariableName" => "Description", "Caption" => "Description", "ControlHTML" => CTL_InputTextArea("Description", $TheEntityName["Description"], "", 4, "required").'<input type="hidden" name="VoucherNo" value="'.$TheEntityName["VoucherNo"].'" />');


$Input[]=array("VariableName"=>"IsDisplay", "Caption"=>"Confirm?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsDisplay", $Captions=array("No", "Yes"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsDisplay"]), "Required"=>false);

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
    
    var formAccountSelected=$("select[name=formAccaunt] option:selected");
    var toAccountSelected=$("select[name=toAccaunt] option:selected");

    
    var ChequeNumber=document.querySelector("input[name=ChequeNumber]");
    var Datess=document.querySelector("input[name=Date]");
    
    ChequeNumber.parentNode.parentNode.style.display="none";
    
    var formAccaunt=document.querySelector("select[name=formAccaunt]");
    var toAccaunt=document.querySelector("select[name=toAccaunt]");
    
    var ProjectID=document.querySelector("select[name=ProjectID]");
    
    
    var Amount=document.querySelector("input[name=Amount]");
    
   
    Amount.type="number";
    
    var form = document.querySelector("form");
    
    formAccaunt.addEventListener("change",hideShowChequeNumber);
    toAccaunt.addEventListener("change",hideShowChequeNumber);
    
    
        
    hideShowEditChequeNumber(formAccountSelected);
    hideShowEditChequeNumber(toAccountSelected);
   
    
    
    function hideShowEditChequeNumber(){
        
        if (formAccountSelected.val() > 1 || toAccountSelected.val() > 1){
            
            ChequeNumber.parentNode.parentNode.style.display="block";
            
        } else{
            ChequeNumber.parentNode.parentNode.style.display="none";
        } 
    }
    
    
    
    function hideShowChequeNumber(){
        if (formAccaunt.value > 1 || toAccaunt.value > 1){
            ChequeNumber.parentNode.parentNode.style.display="block";
            
        } else{
            ChequeNumber.parentNode.parentNode.style.display="none";
        } 
    }
    
    form.addEventListener("submit", function (ev) { 
        
        
        validation(ProjectID);
        validation(Amount);
        
        validation(Datess);
        
        if ( parseFloat(formAccaunt.value) === parseFloat(toAccaunt.value) ){
            
            toAccaunt.style.border="1px solid red";
            ev.preventDefault();
        } else{
            toAccaunt.style.border="1px solid rgba(0,0,0,.2)";
        }
        
        
        function validation(DOM) {
          if (DOM.value ===""){
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