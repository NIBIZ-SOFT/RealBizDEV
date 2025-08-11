<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="Leave";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Leave Mange Page";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="LeaveID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>