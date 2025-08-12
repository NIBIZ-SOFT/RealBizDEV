<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"]))$UpdateMode=true;

    $ErrorUserInput["_Error"]=false;

	if(!$UpdateMode)$_REQUEST["{$Entity}ID"]=0;
	//some change goes here
	$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$UniqueField} = '{$_POST["{$UniqueField}"]}' AND {$Entity}ID <> {$_REQUEST[$Entity."ID"]}");
    //'
	if(count($TheEntityName)>0){
	    $ErrorUserInput["_Error"]=true;
	    $ErrorUserInput["_Message"]="This Value Already Taken.";
	}

    if($ErrorUserInput["_Error"]){
        include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	}else{
	    $Where="";
	    if($UpdateMode)$Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'";

        if($_REQUEST["Transaction"]=="Yes"){


            /* update to transaction Table */

            // get last Transaction Total
            $PropetyInfo=SQL_Select("Sales","SalesID={$_SESSION["SalesID"]}","",true);

            $LastBalance = SQL_Select("Transaction","BankCashID={$_POST["BankCashID"]} order by TransactionID DESC","",true);
            $_POST["Type"]="Income";

            if($_POST["Type"]=="Income"){
                $_POST["dr"]="0";
                $_POST["cr"]=$_POST["PaymentMade"];
                $Balance = $LastBalance["Balance"] + $_POST["PaymentMade"];
            }

//            if($_POST["Type"]=="Expense"){
//                $_POST["dr"]=$_POST["Amount"];
//                $_POST["cr"]="0";
//                $Balance = $LastBalance["Balance"] - $_POST["Amount"];
//            }


            // give the data dase fields name and the post value name
            SQL_InsertUpdate(
                "Transaction",
                $TheEntityNameData=array(

                    "BankCashID"=>$_POST["BankCashID"],
                    "BankCashName"=>GetBankCashTitle($_POST["BankCashID"]),
                    "Type"=>$_POST["Type"],
                    "Amount"=>$_POST["PaymentMade"],
                    "Date"=>$_POST["PaymentDate"],
                    "Description"=>$_POST["PaymentNote"],
                    "dr"=>$_POST["dr"],
                    "cr"=>$_POST["cr"],

                    "ProjectID"=>$PropetyInfo["ProjectID"],
                    "ProjectName"=>$PropetyInfo["ProjectName"],
                    "CustomerName"=>$PropetyInfo["CustomerName"],
                    "CustomerID"=>$PropetyInfo["CustomerID"],

                    "Balance"=>$Balance,
                ),
                ""
            );


$resultActualCumulative = mysql_query("select SUM(TotalPayment) as CumulativeTotalPayment from tblschedulepayment where SalesID='{$_SESSION["SalesID"]}'");
            $row = @mysql_fetch_array($result, MYSQL_ASSOC);

$ActualTotalPayment=$row["ActualTotalPayment"];

            /* end of update to transaction table */


            if($_REQUEST["TrxID"]=="Yes"){
                // give the data dase fields name and the post value name
                $TheEntityName = SQL_InsertUpdate(
                    $Entity = "{$Entity}",
                    $TheEntityNameData = array(

                        "PaymentNote" => $_POST["PaymentNote"],
                        "PaymentMade" => $_POST["PaymentMade"],
                        "PaymentDate" => $_POST["PaymentDate"],
                    ),
                    $Where
                );

            }else{

                // give the data dase fields name and the post value name
                $TheEntityName = SQL_InsertUpdate(
                    $Entity = "{$Entity}",
                    $TheEntityNameData = array(

                        "PaymentNote" => $_POST["PaymentNote"],
                        "PaymentMade" => $_POST["PaymentMade"],
                        "PaymentDate" => $_POST["PaymentDate"],
                        "PaymentID" => $_POST["PaymentID"],
                        "BankCashID"=>$_POST["BankCashID"],
                        "ActualTotalPayment"=>$ActualTotalPayment,
                        "BankCashName"=>GetBankCashTitle($_POST["BankCashID"]),
                        "{$Entity}IsActive" => $_POST["{$Entity}IsActive"],
                    ),
                    ""
                );

            }


			echo "select SUM(PaymentMade) as Total from tblschedulepayment where PaymentID='{$_POST["PaymentID"]}'";
            $result = mysql_query("select SUM(PaymentMade) as Total from tblschedulepayment where PaymentID='{$_POST["PaymentID"]}'");
            $row = @mysql_fetch_array($result, MYSQL_ASSOC);



            $PendingPayment = $row["Total"];
            // give the data dase fields name and the post value name
            $TheEntityName = SQL_InsertUpdate(
                $Entity = "{$Entity}",
                $TheEntityNameData = array(

                    "TotalPayment" => $row["Total"],
                    "PendingPayment" => $row["Total"],
                ),
                "SchedulePaymentID={$_POST["PaymentID"]}"
            );





        }else {

            // give the data dase fields name and the post value name
            $TheEntityName = SQL_InsertUpdate(
                $Entity = "{$Entity}",
                $TheEntityNameData = array(

                    "Title" => $_POST["Title"],
                    "Amount" => $_POST["Amount"],
                    "Date" => $_POST["Date"],
                    "SalesID" => $_SESSION["SalesID"],

                    "{$Entity}IsActive" => $_POST["{$Entity}IsActive"],
                ),
                $Where
            );
        }

	    $MainContent.="
	        ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","Manage")."\">here</a> to proceed.",300)."
	        <script language=\"JavaScript\" >
	            //window.location='".ApplicationURL("{$_REQUEST["Base"]}","Manage")."';
	        </script>
		";
	}
?>