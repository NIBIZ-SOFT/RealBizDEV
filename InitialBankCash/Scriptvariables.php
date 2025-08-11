<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="InitialBankCash";
    $EntityLower=strtolower($Entity);
    $EntityCaption="InitialBankCash";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="InitialBankCashID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>