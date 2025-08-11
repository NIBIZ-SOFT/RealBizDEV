<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="ContraVoucher";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Contra Voucher";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="ContraVoucherID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>