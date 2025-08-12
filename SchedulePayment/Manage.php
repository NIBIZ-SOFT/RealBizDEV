<?

include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";


function taka_format($amount = 0)
{
    $tmp = explode(".", $amount);  // for float or double values
    $strMoney = "";
    $amount = $tmp[0];
    $strMoney .= substr($amount, -3, 3);
    $amount = substr($amount, 0, -3);
    while (strlen($amount) > 0) {
        $strMoney = substr($amount, -2, 2) . "," . $strMoney;
        $amount = substr($amount, 0, -2);
    }

    if (isset($tmp[1]))         // if float and double add the decimal digits here.
    {
        return $strMoney . "." . $tmp[1];
    }
    return $strMoney;
}


$allScheduleDetails = SQL_Select("Schedulepayment where SalesID={$_GET["SalesID"]} ORDER BY SchedulePaymentID ASC");

$allActualPaymentDetails = SQL_Select("Actualsalsepayment where SalesID={$_GET["SalesID"]} ORDER BY actualsalsepaymentID ASC");


// Till Due Amount start

// $allScheduleDetails 

$todaysDate = date("Y-m-d");
$todaysDateNumber=strtotime($todaysDate);
$totalDateSchedulAmount=0;

foreach ($allScheduleDetails as $allScheduleDateDetail) {
	if (  strtotime($allScheduleDateDetail["Date"]) <= $todaysDateNumber ) {
		$totalDateSchedulAmount += $allScheduleDateDetail["PayAbleAmount"];
	}
}


foreach ($allActualPaymentDetails as $allActualPaymentDateDetail) {
	if (  strtotime($allActualPaymentDateDetail["DateOfCollection"]) <= $todaysDateNumber ) {
		$totalDateActualAmount += $allActualPaymentDateDetail["ActualReceiveAmount"];
	}
}
$tillDueAmount=$totalDateActualAmount-$totalDateSchedulAmount;

if ($tillDueAmount == 0) {
	$dueText = '<h5 class="text-center text-success">Till Due Amount: '.$tillDueAmount.'</h5>';
}else if ( $tillDueAmount > 0) {
		$dueText = '<h5 class="text-center text-success">Till Due Amount: '.$tillDueAmount.'</h5>';
}else{
	$dueText = '<h2 style="color:red" class="text-center">Till Due Amount: '.$tillDueAmount.'</h5>';
}
// Till Due Amount End




$i = 1;

if (!empty($allScheduleDetails)) {

    $ScudeleCumulativePayment = array();
    $schedleDate = array();
    $tatalDueAmount = array();




    $totalDueamountValue = 0;

    $ActualReceiveAmount=0;
    $TotalReceiveAmount=0;

    foreach ($allScheduleDetails as $allScheduleDetail) {


        /*		Comuulitive schedule payment*/

        if ($i == 1) {
            $ScudeleCumulativePayment[$i] = $allScheduleDetail["PayAbleAmount"];
        } else {
            $ScudeleCumulativePayment[$i] = $ScudeleCumulativePayment[$i - 1] + $allScheduleDetail["PayAbleAmount"];
        }

        // Due area
        $schedleDate[$i] = $allScheduleDetail["Date"];

        if ($i == 1) {

            $AcutalPamentDetails = SQL_Select("Actualsalsepayment where DateOfCollection='{$schedleDate[$i]}' AND SalesID={$_GET["SalesID"]} ");


            $AcutalPament = $AcutalPamentDetails[0]["Amount"];

            if (!empty($AcutalPament)) {
                $tatalDueAmount[$i] = $allScheduleDetail["PayAbleAmount"] - $AcutalPament;
                $displayStatusForEdit = "";
            } else {
                $tatalDueAmount[$i] = $allScheduleDetail["PayAbleAmount"];
                $displayStatusForEdit = "";
            }

        } else {
            $AcutalPamentDetails = SQL_Select("Actualsalsepayment where DateOfCollection > '{$schedleDate[$i-1]}' AND  DateOfCollection <='{$schedleDate[$i]}'   AND SalesID={$_GET["SalesID"]} ");


            // finding this date or bigger date then edit lock
            if (!empty($AcutalPamentDetails)) {
                $displayStatusForEdit = "";
            } else {
                $displayStatusForEdit = "";
            }

            $installmentDue = 0;
            foreach ($AcutalPamentDetails as $AcutalPamentDetail) {
                $installmentDue += $AcutalPamentDetail["Amount"];
            }
            $tatalDueAmount[$i] = $allScheduleDetail["PayAbleAmount"] - $installmentDue;
        }

        $DateFormatSchedule = HumanReadAbleDateFormat($allScheduleDetail["Date"]);

        $ScheduleItems .= '
			<tr>
			  <td>' . $i . '</th>
			  <td style="text-align:center">' . $allScheduleDetail["Title"] . '</td>
			  <td style="text-align:center">' . taka_format($allScheduleDetail["PayAbleAmount"]) . '</td>
			  <td style="text-align:center">' . taka_format($ScudeleCumulativePayment[$i]) . '</td>
			  
			  <td style="text-align:center">' . $DateFormatSchedule . '</td>
			  <td>

			  <a  class="btn btn-warning" href="' . ApplicationURL("SchedulePayment", "AddScudule&SchedulePaymentID={$allScheduleDetail["SchedulePaymentID"]}&SalesID={$_GET["SalesID"]}") . '">Edit</a>
			  
			  <a  style="margin-top:5px; " class="btn btn-danger " href="' . ApplicationURL("SchedulePayment", "AddScudule&Delete=1&SchedulePaymentID={$allScheduleDetail["SchedulePaymentID"]}&SalesID={$_GET["SalesID"]}") . '">Delete</a>
			  
			  </td>
			</tr>
		';

        $i++;
    }

    $totalSchedulePament = $ScudeleCumulativePayment[count($allScheduleDetails)];

} else {

    $ScheduleItems .= '

		<tr>
		  <td colspan="9" style="text-align: center; color:red;"><p>Not Schedule Yet</p></td>
		</tr>
	';
}




$customerProjectDetails = SQL_Select("Sales", "SalesID={$_GET['SalesID']}", "", true);

$customerName = $customerProjectDetails["CustomerName"];
$ProjectName = $customerProjectDetails["ProjectName"];

$ProductName = $customerProjectDetails["ProductName"];


/*actual Area start*/

$i = 1;

if (!empty($allActualPaymentDetails)) {

    $ActualCumulativePayment = array();
    $totalDueamount = 0;
    foreach ($allActualPaymentDetails as $allScheduleDetail) {



        if ($i == 1) {
            $ActualCumulativePayment[$i] = $allScheduleDetail["Amount"];
        } else {
            $ActualCumulativePayment[$i] = $ActualCumulativePayment[$i - 1] + $allScheduleDetail["Amount"];
        }

        $ActualReceiveAmount += $allScheduleDetail["ActualReceiveAmount"];
        $TotalReceiveAmount +=$allScheduleDetail["ReceiveAmount"];

        $TotalAdjustment +=$allScheduleDetail["Adjustment"];


        $ActualleItems .= '

			<tr>
			  <td>' . $i . '</th>
			  <td>'.$allScheduleDetail["Term"].'</td>
			  <td style="text-align:center">' . taka_format($allScheduleDetail["ReceiveAmount"]) . '</td>
			  <td style="text-align:center">' . taka_format($allScheduleDetail["Adjustment"]) . '</td>
			  <td style="text-align:center">' . taka_format($allScheduleDetail["ActualReceiveAmount"]) . '</td>
			  <td style="text-align:center">' . HumanReadAbleDateFormat($allScheduleDetail["DateOfCollection"]) . '</td>
			  <td style="text-align:center">'.$allScheduleDetail["MRRNO"].'</td>
			  <td style="text-align:center">'.$allScheduleDetail["ModeOfPayment"].'</td>
			  <td style="text-align:center">'.$allScheduleDetail["ChequeNo"].'</td>
			  <td style="text-align:center">'.$allScheduleDetail["BankName"].'</td>
			  <td style="text-align:center">'.$allScheduleDetail["Remark"].'</td>
			  <td>

			  <a class="btn btn-warning" href="' . ApplicationURL("SchedulePayment", "AddActualPayment&SalesID={$_GET["SalesID"]}&ActualSalsePaymentID={$allScheduleDetail["ActualSalsePaymentID"]}").'">Edit</a>
			  
			  <a  style="margin-top:5px; " class="btn btn-danger " href="' . ApplicationURL("SchedulePayment", "AddActualPayment&SalesID={$_GET["SalesID"]}&ActualSalsePaymentID={$allScheduleDetail["ActualSalsePaymentID"]}&Delete=1").'">Delete</a>
			  
			  </td>
			  
			</tr>

		';

        $i++;

    }

    $totalActualPament = $ActualCumulativePayment[count($allActualPaymentDetails)];


}

$DueAmount=$totalSchedulePament-$ActualReceiveAmount;



if (!empty($allActualPaymentDetails)) {

    $emptyTable = '
		
		<tr>
			<td style="text-align: right" colspan="2">Total =</td>
            
            <td style="text-align: center">'.taka_format($TotalReceiveAmount).'</td>
            <td style="text-align: center">'.taka_format($TotalAdjustment).'</td>
            <td  style="text-align: center">'.taka_format($ActualReceiveAmount).'</td>
            <td colspan="7"></td>
		<tr>
    
        <tr style="font-size: 25px;font-weight: bold">
            
			<td colspan="4" style="text-align: right">Actual Received Amount = </td>
            <td colspan="1" style="text-align: center">' . taka_format($ActualReceiveAmount) . '</td>
            
            <td colspan="5" style="text-align: right;" colspan="2">Total Receivable  Amount =</td>
            
            <td colspan="2" style="text-align: center"> '.taka_format($DueAmount).' </td>
            
		<tr>';

} else {

    $emptyTable = '
	<tr>
		<td colspan="4" style="color:red; text-align:center;">Empty field</td>

	<tr>';
}




$MainContent .= '


<h4 class="text-center">Schedule Receivable Management (' . $customerName . ' || ' . $ProjectName . ' || ' . $ProductName . ')</h4>  

<a class="btn btn-info" style="margin-bottom:5px;margin-top:20px;" href="' . ApplicationURL("Sales", "Manage") . '">Back</a> 

<a class="btn btn-success pull-right" style="margin-bottom:5px;margin-top:20px;" href="' . ApplicationURL("SchedulePayment", "AddScudule&SalesID={$_GET["SalesID"]}") . '">Add Schedule</a>   



'.$dueText.'

<table  class="table table-bordered">
	<tr>
	  <th style=" font-size:14px;">SL.</th>
	  <th style=" font-size:14px;">Term</th>
	  <th style=" font-size:14px;">Receivable Amount (Tk)</th>
	  <th style=" font-size:14px;">Cumulative Receivable Amount (Tk)</th>
	  
	  <th style=" font-size:14px;">Due Date</th>
	  <th style=" font-size:14px;">Action</th>
	</tr>
	
	' . $ScheduleItems . '
	

</table>

';

/*Schedule area end*/








if (empty($allScheduleDetails)) {

} else {

    $MainContent .= '


<h4 style="margin-top:20px;" class="text-center">Actual Received Management (' . $customerName . ' || ' . $ProjectName . ' || ' . $ProductName . ')</h4>


<a style="margin-top:45px;" class="btn btn-success pull-right" style="margin-bottom:5px;" href="' . ApplicationURL("SchedulePayment", "AddActualPayment&SalesID={$_GET["SalesID"]}") . '">Add Payment</a> 

<table  class="table table-bordered">
	

	<tr>
	  <th style=" font-size:14px;">SL.</th>
	  <th style=" font-size:14px;">Term</th>
	  <th style=" font-size:14px;">Received Amount (Tk)</th>
	  <th style=" font-size:14px;">Adjustment (Tk)</th>
	  <th style=" font-size:14px; ">Actual Amount</th>
	  <th style=" font-size:14px; ">Data Of Collection</th>
	  <th style=" font-size:14px; ">MRR NO</th>
	  <th style=" font-size:14px; ">Mode of Payment</th>
	  <th style=" font-size:14px; ">Chq No</th>
	  <th style=" font-size:14px; ">Bank Name</th>
	  <th style=" font-size:14px; ">Remarks</th>
	  <th style=" font-size:14px;">Action</th>
	</tr>

	' . $ActualleItems . '
	' . $emptyTable . '


</table>


';


}


$MainContent .= '

<script language="JavaScript" >

	$(function(){

		$(".btn-danger").click(function(e){
		    var r = confirm("Are you want to delete ?");
		    if (r == true) {
		       
		    } else {
		       e.preventDefault();
		    }		  
		    
		});

	});


</script>';


?>