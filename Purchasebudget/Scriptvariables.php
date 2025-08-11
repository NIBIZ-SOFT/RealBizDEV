<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Purchasebudget";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Purchasebudget";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="PurchasebudgetID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>