<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Employee";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Employee Management";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="Name";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>