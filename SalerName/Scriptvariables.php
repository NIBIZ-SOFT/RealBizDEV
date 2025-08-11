<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="SalerName";
    $EntityLower=strtolower($Entity);
    $EntityCaption="SalerName";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="SalerNameID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>