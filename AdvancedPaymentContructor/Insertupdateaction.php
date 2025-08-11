<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";
	
	
    $UpdateMode=false;
	if(isset($_REQUEST[$Entity."ID"]))$UpdateMode=true;
	
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

        $advancepaymentcontructor= SQL_Select("advancepaymentcontructor");

        if ($UpdateMode == false) {

            if (!empty($advancepaymentcontructor)) {
                $voucherNo = (count($advancepaymentcontructor) / 2 + 1);
            } else {
                $voucherNo = 1;
            }

        }else{
            $advancepaymentcontructorDetails=SQL_Select("advancepaymentcontructor where VoucherNo={$_REQUEST["VoucherNo"]}");
            $voucherNo=$_POST["VoucherNo"];

        }

        if ($UpdateMode) $Where = "{$Entity}ID = {$advancepaymentcontructorDetails[0][$Entity."ID"]} AND {$Entity}UUID = '{$advancepaymentcontructorDetails[0][$Entity."UUID"]}'";


        // Form Head
        $TheEntityName = SQL_InsertUpdate(
            $Entity = "{$Entity}",
            $TheEntityNameData = array(

                "CategoryID" => $CategoryID,
                "CategoryName" => GetCategoryName($CategoryID),

                "ContructorID" => $ContructorID,
                "ContructorName" => GetContructorName($ContructorID),


                "HeadOfAccountID" => $_POST["FormHeadOfAccountID"],
                "HeadOfAccountName" => GetExpenseHeadName($_POST["FormHeadOfAccountID"]),

                "Date" => $_POST["BillDate"],
                "VoucherNo" => $voucherNo,

                "BillPhase"=>$_POST["BillPhase"],

                "MRBillNo"=>$_POST["MRBillNo"],

                "Description" => $_POST["Description"],
                "dr" => $_POST["Amount"],
                "cr" => 0,

                "{$Entity}IsActive" => $_POST["{$Entity}IsActive"],

                "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
            ),
            $Where
        );

        if ($UpdateMode) $Where = "{$Entity}ID = {$advancepaymentcontructorDetails[1][$Entity."ID"]} AND {$Entity}UUID = '{$advancepaymentcontructorDetails[1][$Entity."UUID"]}'";


        // To Head
        $TheEntityName = SQL_InsertUpdate(
            $Entity = "{$Entity}",
            $TheEntityNameData = array(
                "CategoryID" => $CategoryID,
                "CategoryName" => GetCategoryName($CategoryID),

                "ContructorID" => $ContructorID,
                "ContructorName" => GetContructorName($ContructorID),


                "HeadOfAccountID" => $_POST["ToHeadOfAccountID"],
                "HeadOfAccountName" => GetExpenseHeadName($_POST["ToHeadOfAccountID"]),

                "Date" => $_POST["BillDate"],
                "VoucherNo" => $voucherNo,
                "BillPhase"=>$_POST["BillPhase"],

                "MRBillNo"=>$_POST["MRBillNo"],

                "Description" => $_POST["Description"],
                "dr" => 0,
                "cr" => $_POST["Amount"],

                "{$Entity}IsActive" => $_POST["{$Entity}IsActive"],

                "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
            ),
            $Where
        );

//    Transition

        if ( $_POST["{$Entity}IsDisplay"] == 0 ){

            $Where="";

            // Form Head
            $TheEntityName = SQL_InsertUpdate(
                $Entity = "transaction",
                $TheEntityNameData = array(

                    "ProjectID" => $CategoryID,
                    "ProjectName" => GetCategoryName($CategoryID),

                    "ContructorID" => $ContructorID,
                    "ContructorName" => GetContructorName($ContructorID),

                    "HeadOfAccountID" => $_POST["FormHeadOfAccountID"],
                    "HeadOfAccountName" => GetExpenseHeadName($_POST["FormHeadOfAccountID"]),

                    "Date" => $_POST["BillDate"],
                    "VoucherNo" => $voucherNo,

                    "Description" => $_POST["Description"],
                    "dr" => $_POST["Amount"],
                    "cr" => 0,

                    "{$Entity}IsActive" => $_POST["{$Entity}IsActive"],

                    "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
                ),
                $Where
            );



            // To Head
            $TheEntityName = SQL_InsertUpdate(
                $Entity = "transaction",
                $TheEntityNameData = array(

                    "ProjectID" => $CategoryID,
                    "ProjectName" => GetCategoryName($CategoryID),

                    "ContructorID" => $ContructorID,
                    "ContructorName" => GetContructorName($ContructorID),


                    "HeadOfAccountID" => $_POST["ToHeadOfAccountID"],
                    "HeadOfAccountName" => GetExpenseHeadName($_POST["ToHeadOfAccountID"]),

                    "Date" => $_POST["BillDate"],

                    "VoucherNo" => $voucherNo,

                    "Description" => $_POST["Description"],
                    "dr" => "0",
                    "cr" => $_POST["Amount"],

                    "{$Entity}IsActive" => $_POST["{$Entity}IsActive"],

                    "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"]
                ),
                $Where
            );

        }



        $MainContent.="
	        ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","Manage&VendorID={$_SESSION["VendorID"]}")."\">here</a> to proceed.",300)."
	        <script language=\"JavaScript\" >
	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","Manage&VendorID={$_SESSION["VendorID"]}")."';
	        </script>
		";
	}
?>