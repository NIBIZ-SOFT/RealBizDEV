<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="ChequeManager";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Cheque Manager";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="BankName";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>