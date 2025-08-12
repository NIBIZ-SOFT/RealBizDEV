<?php

include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";



/* Delete Actual */

if ( $_GET["Delete"]==1 ) {

    SQL_Delete("ActualSalsePayment where ActualSalsePaymentID={$_GET["ActualSalsePaymentID"]}");


    $MainContent.='

    <script language="JavaScript" >

	window.location.href = "'.ApplicationURL("SchedulePayment","Manage&SalesID={$_GET["SalesID"]}").'";

    </script>
		';

}




$customerProjectDetails = SQL_Select("Sales", "SalesID={$_GET['SalesID']}", "", true);

$ProjectName = $customerProjectDetails["ProjectName"];
$customerName = $customerProjectDetails["CustomerName"];

$ProductName = $customerProjectDetails["ProductName"];

$MainContent .= '<a style="margin:19px 10px 0px 20px;" href="' . ApplicationURL("SchedulePayment", "Manage&SalesID={$_GET["SalesID"]}") . '" class="btn btn-warning">Back</a>';

$MainContent .= '<h4 class="text-center">Actual Receivable Management (  ' . $customerName . ' || ' . $ProjectName . ' || ' . $ProductName . ')</h4>';
$UpdateMode = false;
$FormTitle = "Insert ";
$ButtonCaption = "Insert";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "AddActualAction&SalesID={$_GET['SalesID']}");


$TheEntityName = array(

    "{$Entity}IsActive" => 1
);

if ( !empty($_REQUEST["ActualSalsePaymentID"])){
    $UpdateMode=true;

    $TheEntityName=SQL_Select("actualsalsepayment", $Where="ActualSalsePaymentID = {$_GET["ActualSalsePaymentID"]}", $OrderBy="ActualSalsePaymentID", $SingleRow=true);

    $ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "AddActualAction&SalesID={$_GET['SalesID']}&ActualSalsePaymentID={$_GET["ActualSalsePaymentID"]}");


}


$Input = array();

$termOptions = '';
$term = SQL_Select("Term");
foreach ($term as $row) {
    $selected = ($row["TermID"] == $TheEntityName["TermID"]) ? 'selected' : '';
    $termOptions.= '<option value="' . $row["Name"] . '" ' . $selected . '>' . $row["Name"] . '</option>';
}
//$termOptions .= '</select>';

$Input[]=array("VariableName"=>"VendorName","Caption"=>"Title","ControlHTML"=>'
	<select class="form-select" name="Title">
		'.$termOptions.'
	</select>

');

$Input[] = array("VariableName" => "ReceiveAmount", "Caption" => "Receive Amount", "ControlHTML" => CTL_InputText("ReceiveAmount", $TheEntityName["ReceiveAmount"], "", 30, "required"));
$Input[] = array("VariableName" => "Adjustment", "Caption" => "Adjustment", "ControlHTML" => CTL_InputText("Adjustment", $TheEntityName["Adjustment"], "", 30, "required"));
$Input[] = array("VariableName" => "ActualReceiveAmount", "Caption" => "Actual Receive Amount", "ControlHTML" => CTL_InputText("ActualReceiveAmount", $TheEntityName["ActualReceiveAmount"], "", 30, "required"));
$Input[] = array("VariableName" => "DateOfCollection", "Caption" => "Date Of Collection", "ControlHTML" => '<input type="date" name="DateOfCollection" class="form-control" value="' . $TheEntityName["DateOfCollection"] . '" />');
$Input[] = array("VariableName" => "MRRNO", "Caption" => "MRR NO", "ControlHTML" => CTL_InputText("MRRNO", $TheEntityName["MRRNO"], "", 30, "required"));
$Input[] = array("VariableName" => "ModeOfPayment", "Caption" => "Mode Of Payment", "ControlHTML" => CTL_InputText("ModeOfPayment", $TheEntityName["ModeOfPayment"], "", 30, "required"));
$Input[] = array("VariableName" => "ChequeNo", "Caption" => "Cheque No", "ControlHTML" => CTL_InputText("ChequeNo", $TheEntityName["ChequeNo"], "", 30, "required"));
$Input[] = array("VariableName" => "BankName", "Caption" => "Bank Name", "ControlHTML" => CTL_InputText("BankName", $TheEntityName["BankName"], "", 30, "required"));

$Input[] = array("VariableName" => "Remark", "Caption" => "Remark", "ControlHTML" => CTL_InputTextArea("Remark", $TheEntityName["Remark"], 40, 4, "required"));

$MainContent .= FormInsertUpdate(
    $EntityName = $EntityLower,
    $FormTitle,
    $Input,
    $ButtonCaption,
    $ActionURL
);

$MainContent .='

<script>

   
    $ReceiveAmountDom =$("input[name=ReceiveAmount]");
    $AdjustmentDom =$("input[name=Adjustment]");
    $ActualReceiveAmountDom =$("input[name=ActualReceiveAmount]"); 
    
    $ReceiveAmountDom.keyup(function() {
      calculation();
        
    });
    
    $AdjustmentDom.keyup(function() {
      calculation();
    });
    
    function calculation(){
        
        $ReceiveAmount=$ReceiveAmountDom.val() == "" ? 0 : parseFloat($ReceiveAmountDom.val());
        $Adjustment=$AdjustmentDom.val() == "" ? 0 : parseFloat($AdjustmentDom.val());
        
        $actualAmount= $ReceiveAmount - $Adjustment;
        $ActualReceiveAmountDom.val($actualAmount);
    
    }
    
    
    $ReceiveAmountDom.prop("autocomplete", "off");
    $AdjustmentDom.prop("autocomplete", "off");
    
    $ActualReceiveAmountDom.prop("readonly", true);




    $("form").submit(function(e) {
        
        $termDom =$("input[name=Term]");
        $ReceiveAmountDom =$("input[name=ReceiveAmount]");
        $AdjustmentDom =$("input[name=Adjustment]");
        $ActualReceiveAmountDom =$("input[name=ActualReceiveAmount]");
        $DateOfCollectionDom =$("input[name=DateOfCollection]");
        $MRRNODom =$("input[name=MRRNO]");
        $ModeOfPaymentDom =$("input[name=ModeOfPayment]");
        
        $BankNameDom =$("input[name=BankName]");
        
        
      
        $Term=$termDom.val() == "" ? 0 : $termDom.val();
        $ReceiveAmount=$ReceiveAmountDom.val() == "" ? 0 : parseFloat($ReceiveAmountDom.val());
        $Adjustment=$AdjustmentDom.val() == "" ? 0 : parseFloat($AdjustmentDom.val());
        $ActualReceiveAmount=$ActualReceiveAmountDom.val() == "" ? 0 : parseFloat($ActualReceiveAmountDom.val());
        $MRRNO=$MRRNODom.val() == "" ? 0 : $MRRNODom.val();
        $ModeOfPayment=$ModeOfPaymentDom.val() == "" ? 0 : $ModeOfPaymentDom.val();
        $BankName=$BankNameDom.val() == "" ? 0 : $BankNameDom.val();
        
        $DateOfCollection=$DateOfCollectionDom.val() == "" ? 0 : $DateOfCollectionDom.val();
        
        
        
        validation($termDom , $Term , e);
        validation($ReceiveAmountDom , $ReceiveAmount , e);
      //  validation($AdjustmentDom , $Adjustment , e);
        validation($ActualReceiveAmountDom , $ActualReceiveAmount , e);
        validation($MRRNODom , $MRRNO , e);
        validation($ModeOfPaymentDom , $ModeOfPayment , e);
       // validation($BankNameDom , $BankName , e);
        validation($DateOfCollectionDom , $DateOfCollection , e);
        
        function validation(dom,value , e){
            
            if (value==0) {
                
                dom.css("border","1px solid red");
                e.preventDefault();
            }else{
                dom.css("border","1px solid rgba(0,0,0,.1)");
                
            }
             
        }
        
        
    });


</script>

';





