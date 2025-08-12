<?

if (array_key_exists("AssaignVendorID",$_REQUEST)){
    if ($_REQUEST["AssaignVendorID"] != $_SESSION["AssaignVendorID"]) {
        $_SESSION["AssaignVendorID"] = $_REQUEST["AssaignVendorID"];
    } elseif (empty($_REQUEST["AssaignVendorID"])) {
        $_SESSION["AssaignVendorID"] = $_REQUEST["AssaignVendorID"];
    }
}

$Where="AssaignvendorcontrocturID=".$_SESSION["AssaignVendorID"];

$AssaignVendorInfos=SQL_Select($Entity = "Assaignvendorcontroctur", $Where);

$CategoryID=$AssaignVendorInfos[0]["CategoryID"];
$CategoryName=$AssaignVendorInfos[0]["CategoryName"];

$VendorID=$AssaignVendorInfos[0]["VendorID"];
$VendorName=$AssaignVendorInfos[0]["VendorName"];

//$ExpenseHeadID=$AssaignVendorInfos[0]["ExpenseHeadID"];
//$ExpenseHeadName=$AssaignVendorInfos[0]["ExpenseHeadName"];


if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");


    $Entity="AdvancedPaymentVendor";
    $EntityLower=strtolower($Entity);
    $EntityCaption="( Vendor ) Advanced Payment Management:  Project-( ".$CategoryName." ) Vendor-( ".$VendorName." )";


    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="AdvancedpaymentvendorID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>
