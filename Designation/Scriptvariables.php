<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Designation";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Designation Name Manage";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="DesignationID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>