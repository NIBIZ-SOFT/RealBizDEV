<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Assaignvendorcontroctur";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Assaign Contructor";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="assaignvendorcontrocturID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>