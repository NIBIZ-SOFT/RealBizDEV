<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$Entity = "AdvancePaidVendor";
$UniqueField = "AdvancePaidVendorID";


$MainContent.='
<a style="margin:19px 5px 0px 20px;" href="'.ApplicationURL("AdvancedPaymentVendor","Manage").'" class="btn btn-warning">Back</a>
';


$UpdateMode = false;
$FormTitle = "( Vendor ) Advanced Payment Management: Project-( $CategoryName	) Vendor-( $VendorName ) ";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "AddActualPaymentAction");


// The default value of the input box will goes here according to how many fields we showing
$TheEntityName = array(

    "Type" => "",
    "AdjustedAmount" => "",
    "Amount" => "",

    "{$Entity}IsActive" => 1,
    "AdvancePaidVendorIsDisplay" => 1
);

//echo "ID=".$_SESSION["ActionID"];




if (isset($_REQUEST["AdvancePaidVendorID"]) && !isset($_REQUEST["DeleteConfirm"])) {

    $UpdateMode = true;
    $FormTitle = "Update $EntityCaption";
    $ButtonCaption = "Update";
    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "AddActualPaymentAction&AdvancePaidVendorID=".$_REQUEST["AdvancePaidVendorID"]);

    if ($UpdateMode && !isset($_POST["" . $Entity . "ID"])) $TheEntityName = SQL_Select($Entity = "AdvancePaidVendor", $Where = "AdvancePaidVendorID = {$_REQUEST["AdvancePaidVendorID"]} ", $OrderBy = "AdvancePaidVendorID", $SingleRow = true);


}

if (!$UpdateMode){
    $_REQUEST["AdvancepaidvendorID"]=0;
}

//echo "<pre>";
//print_r($_REQUEST);
//die();

// Input sytem display goes here
$Input = array();

$Input[] = array("VariableName" => "BankCashID", "Caption" => "Cash Type", "ControlHTML" => CCTL_BankCash($Name = "BankCashID", $TheEntityName["BankCashID"], $Where = "", $PrependBlankOption = false));
$Input[] = array("VariableName" => "checkNumberArea", "Caption" => "Cheque Number", "ControlHTML" => CTL_InputText($Name = "ChequeNumber", $TheEntityName["ChequeNumber"], "", 30, "required"));
$Input[] = array("VariableName" => "HeadOfAccountID", "Caption" => "Head Of Account", "ControlHTML" => GetExpenseID($Name = "HeadOfAccountID", $TheEntityName["HeadOfAccountID"], $Where = "", $PrependBlankOption = true));
$Input[] = array("VariableName" => "BillNo", "Caption" => "M.R/Bill No", "ControlHTML" => CTL_InputText($Name = "BillNo", $TheEntityName["BillNo"], "", 30, "required"));

$Input[] = array("VariableName" => "Date", "Caption" => "Date", "ControlHTML" => CTL_InputText("Date", $TheEntityName["Date"], "", 30, "required"));
$Input[] = array("VariableName" => "Amount", "Caption" => "Amount", "ControlHTML" => CTL_InputText("Amount", $TheEntityName["dr"], "", 30, "required"));
$Input[] = array("VariableName" => "Description", "Caption" => "Particulars", "ControlHTML" => CTL_InputTextArea("Description", $TheEntityName["Description"], "", 5, "required"));

$Input[]=array("VariableName"=>"IsDisplay", "Caption"=>"Confirm?", "ControlHTML"=>CTL_InputRadioSet($VariableName="AdvancePaidVendorIsDisplay", $Captions=array("No", "Yes"), $Values=array(1, 0), $CurrentValue=$TheEntityName["AdvancePaidVendorIsDisplay"]), "Required"=>false);


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
	       	var AmountDom= document.querySelector("form.form-horizontal input[name=Amount]");

	       
	       AmountDom.type="number";
	       
	       
	       document.querySelector("form.form-horizontal").addEventListener("submit",function(e) {
	           
	           
	           var HeadOfAccountIDDom= document.querySelector("form.form-horizontal select[name=HeadOfAccountID]");
	           var BillNoDom= document.querySelector("form.form-horizontal input[name=BillNo]");
	           var DateDom= document.querySelector("form.form-horizontal input[name=Date]");
	           
	          
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