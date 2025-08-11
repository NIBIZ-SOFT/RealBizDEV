<?php


function taka_format($amount = 0)
{
    $tmp = explode(".",$amount);  // for float or double values
    $strMoney = "";
    $amount = $tmp[0];
    $strMoney .= substr($amount, -3, 3);
    $amount = substr($amount, 0, -3);
    while (strlen($amount) > 0) {
        $strMoney = substr($amount, -2, 2) .",".$strMoney;
        $amount = substr($amount, 0, -2);
    }

    if (isset($tmp[1]))         // if float and double add the decimal digits here.
    {
        return $strMoney .".".$tmp[1];
    }
    return $strMoney;
}


$cashRequirMentReportDate=$_POST['cashRequirMentReportDate'];


$cashRequirMentReportDateInfos= SQL_Select("Requsitionreport","ApplayDate='$cashRequirMentReportDate'");


// echo "<pre>";
// print_r($cashRequirMentReportDateInfos);
// die();

if (empty($cashRequirMentReportDateInfos)) {
	$HTML.='<h4 style="color:red;">There has no data</h4>';
}



$x=1;

$totalAmount=0;

$cashBalance=0;

$otherBalance=0;

$totalApprovedAmount=0;
$totalUnApprovedAmount=0;

foreach($cashRequirMentReportDateInfos as $cashRequirMentReportDateInfo){

	$totalAmount=$totalAmount+$cashRequirMentReportDateInfo["Amount"];

	$projectId=$cashRequirMentReportDateInfo["ProjectID"];
	$BankCashID=$cashRequirMentReportDateInfo["BankCashID"];

	// Get project name
	$projectInformation=SQL_Select("Category" , "CategoryID='{$projectId}' ");

	$projectName=$projectInformation[0]["Name"];

	// BankCashName
	// BankCashName
	$BankCashInformation=SQL_Select("Bankcash" , "BankCashID='{$BankCashID}' ");
	$BankCashName=$BankCashInformation[0]["AccountTitle"];


	
	$totalApprovedAmount=$totalApprovedAmount+$cashRequirMentReportDateInfo["Amount"];


		// Checkby
	$Director=$cashRequirMentReportDateInfo["Director"];
	if ($Director=="0") {
		$IsCheckDirector="Not Checked";
	}elseif ($Director=="3") {
		$IsCheckDirector="Canceled";
	}else{
		$IsCheckDirector="Checked";
	}

	$ManagingDirector=$cashRequirMentReportDateInfo["ManagingDirector"];
	if ($ManagingDirector=="0") {
		$IsManagingDirectorApprove="Not Approved";
	}elseif ($ManagingDirector=="3") {
		$IsManagingDirectorApprove="Canceled";
	}else{
		$IsManagingDirectorApprove="Approved";
	}

	$Chairman=$cashRequirMentReportDateInfo["Chairman"];
	if ($Chairman=="0") {
		$IsChairmanApprove="Not Approved";
	}elseif ($Chairman=="3") {
		$IsChairmanApprove="Canceled";
	}else{
		$IsChairmanApprove="Approved";
	}


	if ($Director=="1" && $ManagingDirector=="1") {
		$approvalStatus="Approved";
	}else{
		$approvalStatus="Not Approved";
	}


	$HTML.='

 	  <tr>
	    <td>'.$x.'</td>
	    <td>'.$projectName.'</td>
	    <td>'.$BankCashName.'</td>
	    <td>'.$cashRequirMentReportDateInfo["Description"].'</td>
	    
	    <td>'.taka_format($cashRequirMentReportDateInfo["Amount"]).'</td>
	    <td>'.$IsCheckDirector.'</td>
	    <td>'.$IsManagingDirectorApprove.'</td>
	    <td>'.$IsChairmanApprove.'</td>
	   
	  </tr>  

    ';

    $x++;

}




$MainContent.='



	<title>Indent Report</title>

	<center>

	<br>

	<h1>Daily Cash Requirement</h1>

	<h1>Date:'.$cashRequirMentReportDate.'</h1>


	<table border="1px" style="width:100%; text-align:center;">
	  <tr>
	    <th>Sl</th>
	    <th>Project Name</th> 
	    <th>Payment Status</th>
	    <th>Description</th>	    
	    <th>Amount</th>
	    <th>Checked By Director</th>
	    <th>Approved By Managing Director</th>
	    <th>Approved By Chairman</th>
	   
	  </tr>

		'.$HTML.'

		<tr>
			<th colspan="7"></th>
			<th>Total Amount: '.taka_format($totalApprovedAmount).'</th>
			
		</tr>

	</table>




		<style type="text/css" media="print">

		@page {

		    size: auto;   /* auto is the initial value */

		   
		    margin-top: 20px;
		    

		    

		}
		@media print {
  			
		}

		</style>

';



?>