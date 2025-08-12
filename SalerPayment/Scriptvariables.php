<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="SalerPayment";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Saler Payment";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="Date";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>