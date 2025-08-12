<?php 

include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";


$SalseInformation=SQL_Select("Sales","SalesID={$_REQUEST["SalesID"]}","",true);


$ProjectID=$SalseInformation["ProjectID"];
$ProjectName=$SalseInformation["ProjectName"];

$ProductID = $SalseInformation["ProductID"];
$ProductName = $SalseInformation["ProductName"];

$CustomerID=$SalseInformation["CustomerID"];
$CustomerName=$SalseInformation["CustomerName"];


// Acutual salse payment

$Where="";

if (!empty($_REQUEST["ActualSalsePaymentID"])){
    $Where="ActualSalsePaymentID={$_REQUEST["ActualSalsePaymentID"]}";
}


SQL_InsertUpdate(
    $Entity = "Actualsalsepayment",
    $TheEntityNameData = array(

        "ProjectID" => $ProjectID,
        "ProjectName" => $ProjectName,

        "CustomerID" => $CustomerID,
        "CustomerName" => $CustomerName,

        "SalesID" => $_REQUEST["SalesID"],


        "Term" => $_POST["Title"],
        "ReceiveAmount" => $_POST["ReceiveAmount"],
        "Adjustment" => $_POST["Adjustment"],
        "ActualReceiveAmount" => $_POST["ActualReceiveAmount"],
        "DateOfCollection" => $_POST["DateOfCollection"],
        "MRRNO" => $_POST["MRRNO"],
        "ModeOfPayment" => $_POST["ModeOfPayment"],
        "ChequeNo" => $_POST["ChequeNo"],
        "BankName" => $_POST["BankName"],
        "Remark" => $_POST["Remark"],

        "ActualSalsePaymentIsActive"=>$_REQUEST["ActualSalsePaymentIsActive"],

    ),
    $Where
);


 $MainContent.='

        <script language="JavaScript" >
        
        window.location.href = "'.ApplicationURL("SchedulePayment","Manage&SalesID={$_GET["SalesID"]}").'";
        
        </script>
		';


?>