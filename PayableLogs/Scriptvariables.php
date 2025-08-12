<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="PayableLogs";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Workers Payable Manage";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="PayableLogsID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>