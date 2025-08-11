<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="UsedStock";
    $EntityLower=strtolower($Entity);
    $EntityCaption="UsedStock";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="UsedStockID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>