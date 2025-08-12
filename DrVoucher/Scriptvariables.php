<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="DrVoucher";
    $EntityLower=strtolower($Entity);
    $EntityCaption="DrVoucher";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="DrVoucherID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>