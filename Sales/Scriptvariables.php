<?


	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Sales";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Sales";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="SalesID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>