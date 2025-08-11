<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="ClientInformation";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Client Information";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="ClientInformationID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>