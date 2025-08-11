<?php 

// echo "<pre>";

// print_r($_GET["SalesID"]);

// die();

/*ScudeleCumulativePayment*/

$Where="SchedulePaymentID={$_POST["SchedulePaymentID"]}";

if (!empty($_POST["SchedulePaymentID"])) {


	if ( !empty( $_POST["Title"]) and !empty( $_POST["PayAbleAmount"]) and !empty( $_POST["Date"]) ) {
	SQL_InsertUpdate(
	    $Entity = "Schedulepayment",
	    $TheEntityNameData = array(

	        "Title" => $_POST["Title"],
	        "PayAbleAmount" => $_POST["PayAbleAmount"],
	        "Date" => $_POST["Date"],

	    ),
	    $Where
	);


	}

 $MainContent.='

    <script language="JavaScript" >

	window.location.href = "'.ApplicationURL("SchedulePayment","Manage&SalesID={$_GET["SalesID"]}").'";

    </script>
		';



}else{



	if ( !empty( $_POST["Title"]) and !empty( $_POST["PayAbleAmount"]) and !empty( $_POST["Date"]) ) {


		SQL_InsertUpdate(
		    $Entity = "Schedulepayment",
		    $TheEntityNameData = array(

		        "Title" => $_POST["Title"],
		        "PayAbleAmount" => $_POST["PayAbleAmount"],
		        "Date" => $_POST["Date"],
		        "SalesID"=>$_GET["SalesID"],


		    ),
		    ""
		);



	}


	 $MainContent.='

        <script language="JavaScript" >

		window.location.href = "'.ApplicationURL("SchedulePayment","AddScudule&SalesID={$_GET["SalesID"]}").'";

        </script>
		';


}



?>