<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Order";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Order List";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="OrderID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>