<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Workers";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Workers Management";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="WorkersID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>