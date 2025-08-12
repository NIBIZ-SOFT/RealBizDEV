<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";


$UpdateMode = false;
$FormTitle = "Insert $EntityCaption";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

// The default value of the input box will goes here according to how many fields we showing
$TheEntityName = array(

    "BankCashID" => "",
    "Type" => "",
    "Amount" => "",
    "Date" => "",
    "dr" => "",
    "cr" => "",
     "ChequeNumber"=>0,

    "{$Entity}IsActive" => 1
);

if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"]) && !isset($_REQUEST["DeleteConfirm"])) {
    $UpdateMode = true;
    $FormTitle = "Update $EntityCaption";
    $ButtonCaption = "Update";
    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction", $Entity . "ID={$_REQUEST[$Entity."ID"]}&" . $Entity . "UUID={$_REQUEST[$Entity."UUID"]}");
    if ($UpdateMode && !isset($_POST["" . $Entity . "ID"])) $TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy = "{$OrderByValue}", $SingleRow = true);
}

$TrxType = $TheEntityName["Type"];
if ($_REQUEST["TrxType"] == "cr")
    $TrxType = "Income";
if ($_REQUEST["TrxType"] == "dr")
    $TrxType = "Expense";


// Input sytem display goes here
$Input = array();

$Input[] = array("VariableName" => "ProjectName", "Caption" => "Project Name", "ControlHTML" => CCTL_ProductsCategory($Name = "ProjectID", $TheEntityName["ProjectID"] , $Where = "", $PrependBlankOption = true ));
$Input[] = array("VariableName" => "BankCashID", "Caption" => "Cash Type", "ControlHTML" => CCTL_BankCash($Name = "BankCashID", $TheEntityName["BankCashID"], $Where = "", $PrependBlankOption = false));
$Input[] = array("VariableName" => "checkNumberArea", "Caption" => "Cheque Number", "ControlHTML" => CTL_InputText($Name = "ChequeNumber", $TheEntityName["ChequeNumber"], "", 30, "required"));
$Input[] = array("VariableName" => "HeadOfAccountID", "Caption" => "Head Of Account", "ControlHTML" => GetExpenseID($Name = "HeadOfAccountID", $TheEntityName["HeadOfAccountID"], $Where = "", $PrependBlankOption = true));
$Input[] = array("VariableName" => "BillNo", "Caption" => "M.R/Bill No", "ControlHTML" => CTL_InputText($Name = "BillNo", $TheEntityName["BillNo"], "", 30, "required"));

$Input[] = array("VariableName" => "Date", "Caption" => "Date", "ControlHTML" => CTL_InputText("Date", $TheEntityName["Date"], "", 30, "required"));
$Input[] = array("VariableName" => "Amount", "Caption" => "Amount", "ControlHTML" => CTL_InputText("Amount", $TheEntityName["Amount"], "", 30, "required") . '
			    <input type="hidden" name="Type" value="' . $TrxType . '">
			');
$Input[] = array("VariableName" => "Description", "Caption" => "Particulars", "ControlHTML" => CTL_InputTextArea("Description", $TheEntityName["Description"], "", 5, "required"));


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
	       $("select[name=BankCashID]").closest(".control-group").next().hide(); 
	       $(document).on("change","select[name=BankCashID]",function() {
	           var mainThis= $(this);
	           var input="";
               if ( mainThis.val() > 1){ 
                mainThis.closest(".control-group").next().show();
               } else{
                    mainThis.closest(".control-group").next().hide();
               }  
	       });
	       
	       document.querySelector("form.form-horizontal").addEventListener("submit",function(e) {
	           
	           var ProjectIDDom= document.querySelector("form.form-horizontal select[name=ProjectID]");
	           var HeadOfAccountIDDom= document.querySelector("form.form-horizontal select[name=HeadOfAccountID]");
	           var BillNoDom= document.querySelector("form.form-horizontal input[name=BillNo]");
	           var DateDom= document.querySelector("form.form-horizontal input[name=Date]");
	           var AmountDom= document.querySelector("form.form-horizontal input[name=Amount]");
	           
	          
	           validation(ProjectIDDom);
	           validation(HeadOfAccountIDDom);
	           validation(BillNoDom);
	           validation(DateDom);
	           validation(AmountDom);
	          
	           function validation(dom){
	               
	               if (dom.value == ""){
	                   dom.style.border="1px solid red";
	                   e.preventDefault();
	                   
	               } else{
	                    dom.style.border="1px solid rgba(0,0,0,.3)";
	               }
	               
	           }
	           
	            var BankCashIDDom= document.querySelector("form.form-horizontal select[name=BankCashID]");
	           
	           if(BankCashIDDom.value > 1){
	            var ChequeNumberDom= document.querySelector("form.form-horizontal input[name=ChequeNumber]");
	               
	                if ( ChequeNumberDom.value == 0 ){
	                    ChequeNumberDom.style.border="1px solid red";
	                   e.preventDefault();
	                } else{
	                     ChequeNumberDom.style.border="1px solid rgba(0,0,0,.3)";
	                }
	            
	           }
	         
	           
	       });
	       
	       
	       
	    </script>
	
	';


?>

