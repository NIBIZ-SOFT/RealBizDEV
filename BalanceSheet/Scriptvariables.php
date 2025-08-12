<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="BalanceSheet";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Balance Sheet Particulars";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="BalanceSheetID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>