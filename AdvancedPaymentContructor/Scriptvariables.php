<?

if (array_key_exists("AssaignControcturID",$_REQUEST)){
    if ($_REQUEST["AssaignControcturID"] != $_SESSION["AssaignControcturID"]) {
        $_SESSION["AssaignControcturID"] = $_REQUEST["AssaignControcturID"];
    } elseif (empty($_REQUEST["AssaignControcturID"])) {
        $_SESSION["AssaignControcturID"] = $_REQUEST["AssaignControcturID"];
    }
}

$Where="AssaignvendorcontrocturID=".$_SESSION["AssaignControcturID"];

$AssaignControcturInfos=SQL_Select($Entity = "Assaignvendorcontroctur", $Where);

$CategoryID=$AssaignControcturInfos[0]["CategoryID"];
$CategoryName=$AssaignControcturInfos[0]["CategoryName"];

$ContructorID=$AssaignControcturInfos[0]["ContructorID"];
$ContructorName=$AssaignControcturInfos[0]["ContructorName"];

//GetContructorName( $_SESSION["AssaignControcturID"] );

if ($_SESSION["UserID"] == 1) Header("Location:index.php?Theme=default&Base=System&Script=login");
$Entity = "AdvancePaymentContructor";
$EntityLower = strtolower($Entity);
$EntityCaption = "( Contructor ) Advanced Bill Management ( ".$CategoryName." ) ( ".$ContructorName." )";


$EntityCaptionLower = strtolower($EntityCaption);
$OrderByValue = "AdvancePaymentContructorID";
// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
$UniqueField = "{$Entity}ID";


?>
