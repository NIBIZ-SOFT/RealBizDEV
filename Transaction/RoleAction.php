<?

$indAppId=$_REQUEST['UserId'];

$indAppData= SQL_Select("Requsitionreport"," RequsitionReportID='$indAppId'","",true,"","",false,"");


$projectId=$indAppData["ProjectID"];
$BankCashID=$indAppData["BankCashID"];
// Get project name


// Unique id waise project information

$uniqueProjectInformation= SQL_Select("Category"," CategoryID='$projectId'","",true,"","",false,"");

// Unique id waise Bankcash information
$uniqueBankCashInformation= SQL_Select("Bankcash"," BankCashID='$BankCashID'","",true,"","",false,"");


// echo "<pre>";
// print_r($uniqueBankCashInformation);
// die();


$projectInformations=SQL_Select("Category");
// Project 
foreach ($projectInformations as $projectInformation) {

	if ($projectInformation["CategoryID"]==$projectId) {
		$porjetSelected.='<option selected value="'.$projectInformation["CategoryID"].'">'.$projectInformation["Name"].'</option>';
	}else{
		$porjetSelected.='<option value="'.$projectInformation["CategoryID"].'">'.$projectInformation["Name"].'</option>';
	}

}

$BankCashInformations=SQL_Select("Bankcash");

// echo "<pre>";
// print_r($BankCashInformations);
// die();

// Accaunt Type
foreach ($BankCashInformations as $BankCashInformation) {

	if ($BankCashInformation["BankCashID"]==$BankCashID) {
		$BankCashSelected.='<option selected value="'.$BankCashInformation["BankCashID"].'">'.$BankCashInformation["AccountTitle"].'</option>';
	}else{
		$BankCashSelected.='<option value="'.$BankCashInformation["BankCashID"].'">'.$BankCashInformation["AccountTitle"].'</option>';
	}

}



if($_SESSION["UserID"]=="109"){

  $HTML1.='

		<form method="POST" action="'.ApplicationURL("Transaction","IndentAction").'">

			<b>Project Name :</b> <input type="text" value="'.$projectInformations[0]["Name"].'" disabled />

			<br>

			<b>Payment Type :</b> <input type="text" value="'.$BankCashInformations[0]["AccountTitle"].'" disabled />

			<br>

			<b>Descrption :</b>&nbsp; <textarea rows="4" cols="50" disabled>'.$indAppData["Description"].'</textarea>

			<br>

			<b>Amount :</b>&nbsp; <input type="text" value="'.$indAppData["Amount"].'" disabled />

			<br>

			<b>Approval Status:</b>&nbsp;'.CTL_InputRadioSet($VariableName="ApprovalStatus", $Captions=array("Forward", "Cancel"), $Values=array("Forward", "Cancel"), $CurrentValue=$TheEntityName["ApprovalStatus"]).'

			

			<input type="hidden" name="Type" value="forwardrequisitionDir" />

			<input type="hidden" name="TransID" value="'.$indAppId.'" />



			<br>

			<input type="submit" value="Submit" class="btn btn-primary" >

										

		</form>

  

  ';

}elseif($_SESSION["UserID"]=="110"){

  $HTML1.='

		<form method="POST" action="'.ApplicationURL("Transaction","IndentAction").'">

			<b>Project Name :</b> <input type="text" value="'.$uniqueProjectInformation["Name"].'" disabled />

			<br>

			<b>Payment Type :</b> <input type="text" value="'.$uniqueBankCashInformation["AccountTitle"].'" disabled />

			<br>

			<b>Descrption :</b>&nbsp; <textarea rows="4" cols="50" disabled>'.$indAppData["Description"].'</textarea>

			<br>

			<b>Amount :</b>&nbsp; <input type="text" value="'.$indAppData["Amount"].'" disabled />

			<br>

			<b>Approval Status:</b>&nbsp;'.CTL_InputRadioSet($VariableName="ApprovalStatus", $Captions=array("Approval", "Cancel"), $Values=array("Approval", "Cancel"), $CurrentValue=$TheEntityName["ApprovalStatus"]).'

			

			<input type="hidden" name="Type" value="approvalrequisitionMd" />

			<input type="hidden" name="TransID" value="'.$indAppId.'" />


			<br>

			<input type="submit" value="Submit" class="btn btn-primary" >

									
		</form>

 
  ';

}elseif($_SESSION["UserID"]=="108"){

// Chairman

  $HTML1.='

  

		<form method="POST" action="'.ApplicationURL("Transaction","IndentAction").'">

			<b>Project Name :</b> <input type="text" value="'.$uniqueProjectInformation["Name"].'" disabled />

			<br>

			<b>Payment Type :</b> <input type="text" value="'.$uniqueBankCashInformation["AccountTitle"].'" disabled />

			<br>

			<b>Descrption :</b>&nbsp; <textarea rows="4" cols="50" disabled>'.$indAppData["Description"].'</textarea>

			<br>

			<b>Amount :</b>&nbsp; <input type="text" value="'.$indAppData["Amount"].'" disabled />

			<br>

			<b>Approval Status:</b>&nbsp;'.CTL_InputRadioSet($VariableName="ApprovalStatus", $Captions=array("Approved", "Cancel"), $Values=array("Approved", "Cancel"), $CurrentValue=$TheEntityName["ApprovalStatus"]).'

			

			<input type="hidden" name="Type" value="approvalrequisitionChirman" />

			<input type="hidden" name="TransID" value="'.$indAppId.'" />

			<br>

			<input type="submit" value="Submit" class="btn btn-primary" >

										

		</form>

  

  ';

}elseif($_SESSION["UserID"]=="107"){

$HTML1.='

  

		<form method="POST" action="'.ApplicationURL("Transaction","IndentAction").'">

			<b>Project Name :</b>
			<select name="ProjectID" id="ProjectID">
				
				'.$porjetSelected.'
			</select>
			<br>

			<b>Payment Type :</b>
			<select name="BankCashID" id="BankCashID">
				
				'.$BankCashSelected.'
			</select>
			<br>


			<b>Descrption :</b>&nbsp; <textarea rows="4" cols="50" name="Description">'.$indAppData["Description"].'</textarea>

			<br>

			<b>Amount :</b>&nbsp; <input type="text" id="Amount" name="Amount" value="'.$indAppData["Amount"].'" />

			<br>

			<b>Apply Date:</b> <input  placeholder="Year-Month-Day" type="text" name="appDate" style="size:50px;" id="TomDate" value="'.$indAppData["ApplayDate"].'" class="DatePicker">

			<br>			

			<b>Requsition Date:</b> <input  placeholder="Year-Month-Day" type="text" name="RequsitionDate" style="size:50px;" id="FromDate" value="'.$indAppData["RequsitionDate"].'" class="DatePicker">

			<br>

			<input type="hidden" name="nType" value="uprequisition" />

			<input type="hidden" name="ApprovalStatus" value="Pending" />

			<input type="hidden" name="requisitionID" value="'.$indAppId.'" />


			<br>

			<input type="submit" id="requisitionSubmit" value="Submit" class="btn btn-primary" >

										

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

}else{

 $HTML1.='

  

		<form method="POST" action="'.ApplicationURL("Transaction","IndentAction").'">

			<b>Project Name :</b> <input type="text" value="'.$indAppData["ProjectName"].'" disabled />

			<br>

			<b>Payment Type :</b> <input type="text" value="'.$indAppData["BankCashName"].'" disabled />

			<br>

			<b>Descrption :</b>&nbsp; <textarea rows="4" cols="50" disabled>'.$indAppData["Description"].'</textarea>

			<br>

			<b>Amount :</b>&nbsp; <input type="text" value="'.$indAppData["Amount"].'" disabled />

			<br>

			<b>Approval Status:</b>&nbsp;'.CTL_InputRadioSet($VariableName="ApprovalStatus", $Captions=array("Approved", "Cancel"), $Values=array("Approved", "Cancel"), $CurrentValue=$TheEntityName["ApprovalStatus"]).'

			

			<input type="hidden" name="Type" value="approvalrequisition" />

			<input type="hidden" name="TransID" value="'.$indAppId.'" />

			<input type="hidden" name="BankCashID" value="'.$indAppData["BankCashID"].'" />

			<br>

			<input type="submit" value="Submit" class="btn btn-primary" >

										

		</form>

  

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

		

		<style type="text/css" media="print">

		@page {

		    size: auto;   /* auto is the initial value */

		    margin: 0;  /* this affects the margin in the printer settings */

		}

		</style>

';





?>








