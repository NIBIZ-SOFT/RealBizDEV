<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Customer";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Customer";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="CustomerID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>