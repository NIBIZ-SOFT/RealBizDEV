<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="AdvancedPaymentVendor";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Advanced Payment Management ( ".GetCustomerName($_REQUEST["CustomerID"])." )";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="AdvancedPaymentID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>
