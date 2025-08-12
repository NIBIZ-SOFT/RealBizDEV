<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="BankCash";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Bank & Cash";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="AccountTitle";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>