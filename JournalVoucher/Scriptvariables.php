<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="JournalVoucher";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Journal Voucher";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="JournalVoucherID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>