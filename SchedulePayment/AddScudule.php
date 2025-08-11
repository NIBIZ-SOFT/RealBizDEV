<?php 

/* Delete Scudule */

if ( $_GET["Delete"]==1 ) {

	SQL_Delete("Schedulepayment where SchedulePaymentID={$_GET["SchedulePaymentID"]}");


 $MainContent.='

    <script language="JavaScript" >

	window.location.href = "'.ApplicationURL("SchedulePayment","Manage&SalesID={$_GET["SalesID"]}").'";

    </script>
		';	
	
}




$customerProjectDetails=SQL_Select("Sales","SalesID={$_GET['SalesID']}","",true);

$customerName=$customerProjectDetails["CustomerName"];
$ProjectName=$customerProjectDetails["ProjectName"];



$TheEntityName=array(
       
		"VendorName"=>"",
		"VendorDescription"=>"",
		"Date"=>"",
		"Address"=>"",
		"VendorWebSite"=>"",
		"VendorPhone"=>"",
		"VendorEmail"=>"",
	);

if ( !empty($_GET["SchedulePaymentID"]) ) {


	$TheEntityName=SQL_Select("Schedulepayment", $Where="SchedulePaymentID = {$_GET["SchedulePaymentID"]}", $OrderBy="{$OrderByValue}", $SingleRow=true);

}

// echo "<pre>";
// print_r($TheEntityName);
// die();




$FormTitle="Add Scudule on $customerName || $ProjectName";
$ButtonCaption="Submit";

$ActionURL=ApplicationURL("SchedulePayment","AddScuduleAction&SalesID={$_GET["SalesID"]}");


$Input=array();

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

$Input[]=array("VariableName"=>"VendorName","Caption"=>"Payable Amount","ControlHTML"=>CTL_InputText("PayAbleAmount",$TheEntityName["PayAbleAmount"],"", 30,"required"));

$Input[]=array(

	"VariableName"=>"VendorName",
	"Caption"=>"Scudule Date",
	"ControlHTML"=>CTL_InputTextDate("Date",$TheEntityName["Date"],"", 30,"required").'
		
	<input type="hidden" value="'.$_GET["SchedulePaymentID"].'" name="SchedulePaymentID">

	'
);



$MainContent.=FormInsertUpdate(
	$EntityName="",
	$FormTitle,
	$Input,
	$ButtonCaption,
	$ActionURL
	);
$MainContent.='

<a class="btn btn-primary mt-3" href="'.ApplicationURL("SchedulePayment","Manage&SalesID={$_GET["SalesID"]}").'">Back</a>';

?>


