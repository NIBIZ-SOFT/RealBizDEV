<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Purchase";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Purchase";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="PurchaseID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>