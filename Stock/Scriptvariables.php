<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Stock";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Stock";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="StockID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>