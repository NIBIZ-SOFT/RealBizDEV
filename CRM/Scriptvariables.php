<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="CRM";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Leads Management";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="CRMID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "Phone";


?>