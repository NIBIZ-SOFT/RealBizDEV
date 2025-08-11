<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Department";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Department Name Manage";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="DepartmentID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>