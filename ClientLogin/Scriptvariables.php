<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="User";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Client Login";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="UserName";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>