<?php 

// Chairman

if($_SESSION["UserID"]=="108"){

	if ( !empty($_POST["requigitationChairmanId"] ) ){
		
		if ( $_POST["approved"]=="Selected Approve" ) {
		
			foreach ($_POST["requigitationChairmanId"] as $value) {
			
				$TheEntityName=SQL_InsertUpdate(

		        $Entity="Requsitionreport",

				$TheEntityNameData=array(

	            	"Chairman"=>"1",

				),

				$Where="RequsitionReportID=$value"

				);

				
			}

		}elseif ($_POST["Cancel"]=="Selected Cancel") {

			foreach ($_POST["requigitationChairmanId"] as $value) {
			
				$TheEntityName=SQL_InsertUpdate(

		        $Entity="Requsitionreport",

				$TheEntityNameData=array(

	            	"Chairman"=>"3",

				),

				$Where="RequsitionReportID=$value"

				);

				
			}

				
		}


	}

}


// Md
if($_SESSION["UserID"]=="110"){

	if ( !empty($_POST["requigitationMDId"] ) ){
		
		if ( $_POST["approved"]=="Selected Approve" ) {
		
			foreach ($_POST["requigitationMDId"] as $value) {
			
				$TheEntityName=SQL_InsertUpdate(

		        $Entity="Requsitionreport",

				$TheEntityNameData=array(

	            	"ManagingDirector"=>"1",
	            	"ApprovalStatus"=>"Approve",

				),

				$Where="RequsitionReportID=$value"

				);

				
			}

		}elseif ($_POST["Cancel"]=="Selected Cancel") {

			foreach ($_POST["requigitationMDId"] as $value) {
			
				$TheEntityName=SQL_InsertUpdate(

		        $Entity="Requsitionreport",

				$TheEntityNameData=array(

	            	"ManagingDirector"=>"3",


				),

				$Where="RequsitionReportID=$value"

				);

				
			}

				
		}


	}

}

// Director
if($_SESSION["UserID"]=="109"){

	if ( !empty($_POST["requigitationDirectorId"] ) ){
		
		if ( $_POST["approved"]=="Selected Approve" ) {
		
			foreach ($_POST["requigitationDirectorId"] as $value) {
			
				$TheEntityName=SQL_InsertUpdate(

		        $Entity="Requsitionreport",

				$TheEntityNameData=array(

	            	"Director"=>"1",

				),

				$Where="RequsitionReportID=$value"

				);

				
			}

		}elseif ($_POST["Cancel"]=="Selected Cancel") {

			foreach ($_POST["requigitationDirectorId"] as $value) {
			
				$TheEntityName=SQL_InsertUpdate(

		        $Entity="Requsitionreport",

				$TheEntityNameData=array(

	            	"Director"=>"3",

				),

				$Where="RequsitionReportID=$value"

				);

				
			}

				
		}


	}

}







	$MainContent.="

   

    <script language=\"JavaScript\" >

        window.location='".ApplicationURL("{$_REQUEST["Base"]}","IndentReport")."';

    </script>

";





?>