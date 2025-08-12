<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;
if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"])) $UpdateMode = true;

$ErrorUserInput["_Error"] = false;

if (!$UpdateMode) $_REQUEST["{$Entity}ID"] = 0;
//some change goes here
$TheEntityName = SQL_Select($Entity = "{$Entity}", $Where = "{$UniqueField} = '{$_POST["{$UniqueField}"]}' AND {$Entity}ID <> {$_REQUEST[$Entity."ID"]}");
if (count($TheEntityName) > 0) {
    $ErrorUserInput["_Error"] = true;
    $ErrorUserInput["_Message"] = "This Value Already Taken.";
}

if ($ErrorUserInput["_Error"]) {
    include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
} else {
    $Where = "";
    if ($UpdateMode) $Where = "{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'";


    // give the data dase fields name and the post value name
    $TheEntityName = SQL_InsertUpdate(
        $Entity = "{$Entity}",
        $TheEntityNameData = array(

            "ProjectID" => $_POST["ProjectID"],
            "ProjectName" => GetProjectName($_POST["ProjectID"]),

            "ExpenseHeadID" => $_POST["ExpenseHeadID"],
            "ExpenseHeadName" => GetExpenseHeadName($_POST["ExpenseHeadID"]),

            "Balance" => $_POST["Balance"],
            "Date" => $_POST["Date"],

            "{$Entity}IsDisplay" => $_POST["{$Entity}IsDisplay"],
        ),
        $Where
    );



//    Head Type

    $headOfAccauntsDetails = SQL_Select("expensehead", "ExpenseHeadID='{$_POST["ExpenseHeadID"]}'");
    $HeadType = $headOfAccauntsDetails[0]["ExpenseHeadIsType"];

    $Dr=0;
    $Cr=0;
    if ($HeadType == 1) {
//  Dr

        $Dr=$_POST["Balance"];

    }else{
//  Cr

        $Cr=$_POST["Balance"];

    }


//    Transaction Area

    if ($_POST["{$Entity}IsDisplay"] == 0) {

        $Where="";
        // Form Head
        $TheEntityName = SQL_InsertUpdate(
            $Entity = "transaction",
            $TheEntityNameData = array(

                "ProjectID" => $_POST["ProjectID"],
                "ProjectName" => GetCategoryName($_POST["ProjectID"]),


                "HeadOfAccountID" => $_POST["ExpenseHeadID"],
                "HeadOfAccountName" => GetExpenseHeadName($_POST["ExpenseHeadID"]),

                "Date" => $_POST["Date"],

                "dr" =>  $Dr,
                "cr" => $Cr,

            ),
            $Where
        );

    }



    $MainContent .= "
	        " . CTL_Window($Title = "Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"" . ApplicationURL("{$_REQUEST["Base"]}", "Manage") . "\">here</a> to proceed.", 300) . "
	        <script language=\"JavaScript\" >
	            window.location='" . ApplicationURL("{$_REQUEST["Base"]}", "Manage") . "';
	        </script>
		";
}
?>