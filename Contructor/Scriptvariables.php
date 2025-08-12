<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Contructor";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Contructor";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="ContructorID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>