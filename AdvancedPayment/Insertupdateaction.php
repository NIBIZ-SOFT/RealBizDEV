<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"]))$UpdateMode=true;

    $ErrorUserInput["_Error"]=false;

	if(!$UpdateMode)$_REQUEST["{$Entity}ID"]=0;
	//some change goes here
	$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$UniqueField} = '{$_POST["{$UniqueField}"]}' AND {$Entity}ID <> {$_REQUEST[$Entity."ID"]}");
    if(count($TheEntityName)>0){
	    $ErrorUserInput["_Error"]=true;
	    $ErrorUserInput["_Message"]="This Value Already Taken.";
	}

    if($ErrorUserInput["_Error"]){

        include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	}else{
	    $Where="";
	    if($UpdateMode)$Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'";

        //echo "ID=".$_SESSION["ActionID"];

        $GetLastAmount=SQL_Select("{$Entity}","CustomerID={$_SESSION["CustomerID"]} order by AdvancedPaymentID desc","",true);

        if($_POST["crdr"]==1) {
            $FinalAmount = $GetLastAmount["Amount"] + $_POST["Amount"];
            $cr= $_POST["Amount"];
        }
        else {
            $FinalAmount = $GetLastAmount["Amount"] - $_POST["Amount"];
            $dr= $_POST["Amount"];
        }

        // give the data dase fields name and the post value name
	    $TheEntityName=SQL_InsertUpdate(
	        $Entity="{$Entity}",
			$TheEntityNameData=array(
                                                                                              
                "Title"=>$_POST["Title"],
                "CustomerID"=>$_SESSION["CustomerID"],
                "PayDate"=>$_POST["PayDate"],
                "cr"=>$cr,
                "dr"=>$dr,
                "Amount"=>$FinalAmount,
		
		        "{$Entity}IsActive"=>$_POST["{$Entity}IsActive"],
			),
			$Where
			);

	    // update to customer table
        SQL_InsertUpdate(
            $Entity="Customer",
            $TheEntityNameData=array(

                "BalanceAmount"=>$FinalAmount
            ),
            "CustomerID={$_SESSION["CustomerID"]}"
        );


	    $MainContent.="
	        ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","Manage&CustomerID={$_SESSION["CustomerID"]}")."\">here</a> to proceed.",300)."
	        <script language=\"JavaScript\" >
	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","Manage&CustomerID={$_SESSION["CustomerID"]}")."';
	        </script>
		";
	}
?>