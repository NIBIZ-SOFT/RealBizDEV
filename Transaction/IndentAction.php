<?php



$transDataByID=$_POST["TransID"];

$appStatus=$_POST["ApprovalStatus"];


// echo "<pre>";
// print_r($_POST);
// die();



if($_POST["Type"]=="requisition"){

			$TheEntityName=SQL_InsertUpdate(

	        $Entity="Requsitionreport",

			$TheEntityNameData=array(

			"ProjectID"=>$_POST["ProjectID"],

            "BankCashID"=>$_POST["BankCashID"],

            "Description"=>$_POST["Description"],

            "Amount"=>$_POST["Amount"],

            "ApplayDate"=>$_POST["Date"],

            "RequsitionDate"=>$_POST["appDate"],

            "ApprovalStatus"=>"Not Approve",

			),

			$Where=""

			);

		$MainContent.="

	       

	        <script language=\"JavaScript\" >

	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","IndentReport")."';

	        </script>

		";

		}elseif($_POST["nType"]=="uprequisition"){


			$requisitionID=$_POST["requisitionID"];
		

			$TheEntityName=SQL_InsertUpdate(

	        $Entity="Requsitionreport",

			$TheEntityNameData=array(

				"ProjectID"=>$_POST["ProjectID"],

	            "BankCashID"=>$_POST["BankCashID"],

	            "Description"=>$_POST["Description"],

	            "Amount"=>$_POST["Amount"],

	            "ApplayDate"=>$_POST["appDate"],

	            "RequsitionDate"=>$_POST["RequsitionDate"],
	        
	            "Director"=>"0",
	            "ManagingDirector"=>"0",
	            "Chairman"=>"0",
	            "ApprovalStatus"=>"Not Approve",


			),

			$Where="RequsitionReportID=$requisitionID"

			);

		$MainContent.="

	       

	        <script language=\"JavaScript\" >

	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","IndentReport")."';

	        </script>

		";
	}elseif( $_POST["Type"]=="forwardrequisitionDir"){

		if ($_POST["ApprovalStatus"]=="Forward") {

			$TheEntityName=SQL_InsertUpdate(

	        $Entity="Requsitionreport",

			$TheEntityNameData=array(

            	"Director"=>"1",

			),

			$Where="RequsitionReportID=$transDataByID"

			);

		}else{

			$TheEntityName=SQL_InsertUpdate(

	        $Entity="Requsitionreport",

			$TheEntityNameData=array(

            	"Director"=>"3",

			),

			$Where="RequsitionReportID=$transDataByID"

			);




		}




			$MainContent.="

	       

	        <script language=\"JavaScript\" >

	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","IndentReport")."';

	        </script>

		";		

	}elseif ($_POST["Type"]=="approvalrequisitionChirman") {

		if ($_POST["ApprovalStatus"]=="Approved") {

			$TheEntityName=SQL_InsertUpdate(

	        $Entity="Requsitionreport",

			$TheEntityNameData=array(

            	"Chairman"=>"1",

			),

			$Where="RequsitionReportID=$transDataByID"

			);

		}else{

			$TheEntityName=SQL_InsertUpdate(

	        $Entity="Requsitionreport",

			$TheEntityNameData=array(

            	"Chairman"=>"3",

			),

			$Where="RequsitionReportID=$transDataByID"

			);

		}

			$MainContent.="

	       

	        <script language=\"JavaScript\" >

	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","IndentReport")."';

	        </script>

		";			



	}elseif ( $_POST["Type"]=="approvalrequisitionMd" ) {

		if ($_POST["ApprovalStatus"]=="Approval") {

			$TheEntityName=SQL_InsertUpdate(

	        $Entity="Requsitionreport",

			$TheEntityNameData=array(

            	"ManagingDirector"=>"1",
            	"ApprovalStatus"=>"Approve"

			),

			$Where="RequsitionReportID=$transDataByID"

			);

		}else{

			$TheEntityName=SQL_InsertUpdate(

	        $Entity="Requsitionreport",

			$TheEntityNameData=array(

            	"ManagingDirector"=>"3",
            	"ApprovalStatus"=>"Not Approve"

			),

			$Where="RequsitionReportID=$transDataByID"

			);

		}

			$MainContent.="

	       

	        <script language=\"JavaScript\" >

	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","IndentReport")."';

	        </script>

		";	


	}		

		

?>