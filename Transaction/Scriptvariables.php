<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");

	$Entity="Transaction";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Transaction";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="TransactionID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>