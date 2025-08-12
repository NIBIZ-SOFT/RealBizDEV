<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Category";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Projects";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="Name";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "Name";


?>