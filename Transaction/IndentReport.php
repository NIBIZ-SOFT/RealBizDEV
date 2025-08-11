<?


if($_SESSION["UserID"]=="107"){
		$selectMultiple="";
}else{
	$selectMultiple="

			<td>
				<b>Select Multiple</b>
			</td>

	";
}


// $date = new DateTime('now', new DateTimeZone('Asia/Dhaka'));

// $todysDate=$date->format('Y-m-d');

$ApprovalStatus="Not Approve";


$ExpenseData= SQL_Select("Requsitionreport" , "ApprovalStatus='{$ApprovalStatus}' order by RequsitionReportID DESC");


// echo "<pre>";
// print_r($ExpenseData);
// die();


$totalBalance=0;


if($_SESSION["UserID"]=="107"){


/*Accaunts*/


	$x=1;

	foreach($ExpenseData as $ThisExpenseData){

		$projectId=$ThisExpenseData["ProjectID"];
		$BankCashID=$ThisExpenseData["BankCashID"];

		// Get project name
		$projectInformation=SQL_Select("Category" , "CategoryID='{$projectId}' ");

		$projectName=$projectInformation[0]["Name"];

		// BankCashName
		// BankCashName
		$BankCashInformation=SQL_Select("Bankcash" , "BankCashID='{$BankCashID}' ");
		$BankCashName=$BankCashInformation[0]["AccountTitle"];



		$userId=$ThisExpenseData["RequsitionReportID"];

		$totalBalance=$totalBalance+$ThisExpenseData["Amount"];

		if($ThisExpenseData["ApprovalStatus"]=="Approved"){
		$HTML2='

		';

		}elseif($ThisExpenseData["ApprovalStatus"]=="Cancel" || $ThisExpenseData["ApprovalStatus"]=="Forward" || $ThisExpenseData["ApprovalStatus"]=="Approval"){

		$HTML2='

		<a href="index.php?Theme=default&Base=Transaction&Script=RoleAction&UserId='.$userId.'" disabled>Edit</a>

		';

		}else{

		$HTML2='

		<a href="index.php?Theme=default&Base=Transaction&Script=RoleAction&UserId='.$userId.'">Edit</a>

		';

		}


	    $HTML.='

	    

			<tr>
			

				<td width="45" align="center" style="border : 1px solid black;">

					'.$x.'.

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$projectName.'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$ThisExpenseData["Description"].'

				</td>

				

				<td align="center" style="border : 1px solid black;">

					'.$BankCashName.'

				</td>

				

				<td align="center" style="border : 1px solid black;">

					'.$ThisExpenseData["Amount"].'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$ThisExpenseData["ApprovalStatus"].'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$ThisExpenseData["ApplayDate"].'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$HTML2.'

				</td>

				

			</tr>    

	    ';

	    $x++;

	}

}elseif($_SESSION["UserID"]=="109"){


/*Director*/

	$x=1;

	foreach($ExpenseData as $ThisExpenseData){


	$projectId=$ThisExpenseData["ProjectID"];
	$BankCashID=$ThisExpenseData["BankCashID"];

	// Get project name
	$projectInformation=SQL_Select("Category" , "CategoryID='{$projectId}' ");

	$projectName=$projectInformation[0]["Name"];

	// BankCashName
	// BankCashName
	$BankCashInformation=SQL_Select("Bankcash" , "BankCashID='{$BankCashID}' ");
	$BankCashName=$BankCashInformation[0]["AccountTitle"];



	$userId=$ThisExpenseData["RequsitionReportID"];

	$totalBalance=$totalBalance+$ThisExpenseData["Amount"];

	if($ThisExpenseData["ApprovalStatus"] !="Approved"){


		if ($ThisExpenseData["Director"]==0) {
			$yourStatus='<span style="color:black;">Not Seen yet</span>';
		}elseif ($ThisExpenseData["Director"]==1) {
			$yourStatus='<span style="color:green;">You Forwarded it </span>';
		}else{
			$yourStatus='<span style="color:red;">You Canceled it</span>';
		}


	$HTML2='

	<a onClick="forword_click(event)"  style="margin-bottom:5px; margin-top:5px;" class="btn btn-success" href="index.php?Theme=default&Base=Transaction&Script=RoleAction&UserId='.$userId.'" >Forward or Cancel</a> 

	';



	    $HTML.='

	    

			<tr>

				<td align="center"> 

					<input type="checkbox" class="requigitationId" name="requigitationDirectorId[]" value="'.$userId.'">

				</td>


				<td width="45" align="center" style="border : 1px solid black;">

					'.$x.'.

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$projectName.'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$BankCashName.'

				</td>				

				<td align="center" style="border : 1px solid black;">

					'.$ThisExpenseData["Description"].'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$ThisExpenseData["Amount"].'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$yourStatus.'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$ThisExpenseData["ApplayDate"].'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$HTML2.'

				</td>

				

			</tr>    

	    ';

	    $x++;

	}
}


}elseif($_SESSION["UserID"]=="108"){

// Chairman

$ApprovalStatus="1";

$ExpenseData= SQL_Select("Requsitionreport" , "Chairman !='{$ApprovalStatus}' order by RequsitionReportID DESC");	



	$x=1;


	foreach($ExpenseData as $ThisExpenseData){


	$projectId=$ThisExpenseData["ProjectID"];
	$BankCashID=$ThisExpenseData["BankCashID"];

	// Get project name
	$projectInformation=SQL_Select("Category" , "CategoryID='{$projectId}' ");

	$projectName=$projectInformation[0]["Name"];

	// BankCashName
	// BankCashName
	$BankCashInformation=SQL_Select("Bankcash" , "BankCashID='{$BankCashID}' ");
	$BankCashName=$BankCashInformation[0]["AccountTitle"];



	$userId=$ThisExpenseData["RequsitionReportID"];


	if ($ThisExpenseData["Director"]==1) {


		if ($ThisExpenseData["Chairman"]==0) {
			$yourStatus='<span style="color:black;">Not Seen yet</span>';
		}elseif ($ThisExpenseData["Chairman"]==1) {
			$yourStatus='<span style="color:green;">You approved it </span>';
		}elseif ($ThisExpenseData["Chairman"]==3) {
			$yourStatus='<span style="color:red;">You Canceled it</span>';
		}

		$totalBalance=$totalBalance+$ThisExpenseData["Amount"];



	    $HTML.='

	    

			<tr>

				<td align="center"> 

					<input type="checkbox" class="requigitationId" name="requigitationChairmanId[]" value="'.$userId.'">

				</td>

				<td width="45" align="center" style="border : 1px solid black;">

					'.$x.'

				</td>


				<td align="center" style="border : 1px solid black;">

					'.$projectName.'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$ThisExpenseData["Description"].'

				</td>

				

				<td align="center" style="border : 1px solid black;">

					'.$BankCashName.'

				</td>

				

				<td align="center" style="border : 1px solid black;">

					'.$ThisExpenseData["Amount"].'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$yourStatus.'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$ThisExpenseData["ApplayDate"].'

				</td>

				<td align="center" style="border : 1px solid black;">

					<a onClick="forword_click(event)" class="btn btn-success" href="index.php?Theme=default&Base=Transaction&Script=RoleAction&UserId='.$userId.'">Approved or Cancel</a>

				</td>

				

			</tr>    

	    ';	

	}


	    $x++;

	}

}

elseif($_SESSION["UserID"]=="110"){

// Md

$ApprovalStatus="1";

$ExpenseData= SQL_Select("Requsitionreport" , "ManagingDirector !='{$ApprovalStatus}' order by RequsitionReportID DESC");


	$x=1;

	foreach($ExpenseData as $ThisExpenseData){

	$projectId=$ThisExpenseData["ProjectID"];
	$BankCashID=$ThisExpenseData["BankCashID"];

	// Get project name
	$projectInformation=SQL_Select("Category" , "CategoryID='{$projectId}' ");

	$projectName=$projectInformation[0]["Name"];

	// BankCashName
	// BankCashName
	$BankCashInformation=SQL_Select("Bankcash" , "BankCashID='{$BankCashID}' ");
	$BankCashName=$BankCashInformation[0]["AccountTitle"];

	$userId=$ThisExpenseData["RequsitionReportID"];


	if ($ThisExpenseData["Director"]==1) {


		if ($ThisExpenseData["ManagingDirector"]==0) {
			$yourStatus='<span style="color:black;">Not Seen yet</span>';
		}elseif ($ThisExpenseData["ManagingDirector"]==1) {
			$yourStatus='<span style="color:green;">You approved it </span>';
		}else{
			$yourStatus='<span style="color:red;">You Canceled it</span>';
		}

		$totalBalance=$totalBalance+$ThisExpenseData["Amount"];


	    $HTML.='

			<tr>

				<td align="center"> 

					<input type="checkbox" class="requigitationId" name="requigitationMDId[]" value="'.$userId.'">

				</td>			

				<td width="45" align="center" style="border : 1px solid black;">

					'.$x.'.

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$projectName.'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$ThisExpenseData["Description"].'

				</td>				

				<td align="center" style="border : 1px solid black;">

					'.$BankCashName.'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$ThisExpenseData["Amount"].'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$yourStatus.'

				</td>

				<td align="center" style="border : 1px solid black;">

					'.$ThisExpenseData["ApplayDate"].'

				</td>

				<td align="center" style="border : 1px solid black;">

					<a onClick="forword_click(event)" class="btn btn-success"  href="index.php?Theme=default&Base=Transaction&Script=RoleAction&UserId='.$userId.'">Approved/Cancel</a>

				</td>

			</tr>    

	    ';

	}


	    $x++;

	}

}




if($_SESSION["UserID"]=="107"){



  $HTML1.='

  

		<form method="POST" action="'.ApplicationURL("Transaction","IndentAction").'">

			<b>Project Name :</b> '.CCTL_ProductsCategory($Name="ProjectID").'

			<br>

			<b>Payment Type :</b> '.CCTL_BankCash($Name="BankCashID").'

			<br>

			<b>Descrption :</b>&nbsp; '.CTL_InputTextArea("Description",$TheEntityName["Description"],40, 8,"not required").'

			<br>

			<b>Amount :</b>&nbsp; '.CTL_InputText("Amount",$TheEntityName["Amount"],"", 30,"required").'

			<br>

			

			<b>Apply Date:</b> <input  placeholder="Year-Month-Day" type="text" name="appDate" style="size:50px;" id="TomDate" class="DatePicker">

			<br>

			<b>Requsition Date:</b> <input  placeholder="Year-Month-Day" type="text" name="Date" style="size:50px;" id="FromDate" class="DatePicker">

			<br>

			

			<input type="hidden" name="Type" value="requisition" />

			<input type="hidden" name="ApprovalStatus" value="Pending" />

			<br>

			<input id="requisitionSubmit" type="submit" value="Submit" class="btn btn-primary" >

		</form>


	<script>
		document.getElementById("requisitionSubmit").addEventListener("click", function(e){
			var Amount =document.getElementById("Amount").value;
				if (Amount === "") {
				     alert("Please Insert your Amount");
				     e.preventDefault();
				} 
		});
	</script>




  ';




}



$MainContent.='

	

	<div class="widget-box">

	

		<div class="widget-title">

                <span class="icon">

                    <i class="icon-th-list"></i>

                </span>				

                <h5>Indent Report</h5>

        </div>

        <div class="widget-content">

		'.$HTML1.'

		</div>

	</div>

	

	

	<title>Indent Report</title>

	<center>

	<br>

	<h1>Daily Cash Requirement</h1>

	<div>

		<form method="POST" action="index.php?Theme=default&Base=Transaction&Script=print&NoHeader&NoFooter">

		
			<b>Report:</b> <input  placeholder="Year-Month-Day" type="text" name="cashRequirMentReportDate" style="size:50px;" id="testFromDate" class="DatePicker">

			<br>

			<input id="cashRequirMentSearch" type="submit" value="Submit" class="btn btn-primary" >

		</form>

	</div>

		<script>
			document.getElementById("cashRequirMentSearch").addEventListener("click", function(e){
				var testFromDate =document.getElementById("testFromDate").value;
					if (testFromDate === "") {
					     alert("Please Insert your Date");
					     e.preventDefault();
					} 
			});
		</script>	

	<br>

	<table border="1" width="95%" style="border : 0px solid black;" align="center">

		<tr>

			
			'.$selectMultiple.'
			


			<td width="45" align="center" style="border : 1px solid black;">

				<b>SL</b>

			</td>

			<td align="center" style="border : 1px solid black;">

				<b>Project Name</b>

			</td>

			<td align="center" style="border : 1px solid black;">

				<b>Payment Status</b>

			</td>

			<td align="center" style="border : 1px solid black;">

				<b>Description</b>

			</td>			

			<td align="center" style="border : 1px solid black;">

				<b>Amount</b>

			</td>

			<td align="center" style="border : 1px solid black;">

				<b>Approval Status</b>

			</td>

			<td align="center" style="border : 1px solid black;">

				<b>Date</b>

			</td>

			<td align="center" style="border : 1px solid black;">

				<b>Action</b>

			</td>

			

		</tr>

		<form method="POST" action="'.ApplicationURL("Transaction","selectedAction").'">
		
			'.$HTML.'	

			<input onClick="selectedAllConfirm_click(event)" name="approved" type="submit" id="selectedApproved" class="btn btn-success" style="margin-bottom:5px; margin-right:5px; display:none;" value="Selected Approve" >

			<input onClick="selectedAllCancel_click(event)" name="Cancel" type="submit" id="selectedCancel" class="btn btn-danger" style="margin-bottom:5px; display:none;" value="Selected Cancel" >

			
	
		</form>




		<tr>

			<td colspan="5" style="text-align:right"><b>Total:&nbsp;'.$totalBalance.' Tk/=</b></td>

		</tr>

		

	</table>
	</center>
		<style type="text/css" media="print">

		@page {

		    size: auto;   /* auto is the initial value */

		    margin: 0;  /* this affects the margin in the printer settings */

		}

		</style>

';


$MainContent.='

<script>

 function forword_click(e){

	var ff = window.confirm("Do you want to allow Or Cancel?");

	   if(ff){
			
	   	}else{
			e.preventDefault();
	   	}	
}

 function selectedAllConfirm_click(e){

	var ff = window.confirm("Do you want to Allow?");

	   if(ff){
			
	   	}else{
			e.preventDefault();
	   	}	
} 


function selectedAllCancel_click(e){

	var ff = window.confirm("Do you want to Cancel?");

	   if(ff){
			
	   	}else{
			e.preventDefault();
	   	}	
}



</script>


<script>

	$(function(){
		var checkedValue=0;
		$(".requigitationId").click(function(){
            if($(this).prop("checked") == true){				 
				checkedValue++;  
				if(checkedValue>1){
					$("#selectedApproved").show();
					$("#selectedCancel").show();
				}

            }else if($(this).prop("checked") == false){
				checkedValue--; 
				if(checkedValue<=1){					
					$("#selectedApproved").hide();
					$("#selectedCancel").hide();
				}
            }

		});
		


	});



</script>

';


//$indAppData= SQL_Select("Transaction"," TransactionID='$transDataByID'");



//$TransDataID=$indAppData["TransactionID"];



?>