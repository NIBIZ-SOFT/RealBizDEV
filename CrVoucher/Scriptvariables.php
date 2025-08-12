<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="CrVoucher";
    $EntityLower=strtolower($Entity);
    $EntityCaption="CrVoucher";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="CrVoucherID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>