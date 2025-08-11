<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="IncomeExpenseType";
    $EntityLower=strtolower($Entity);
    $EntityCaption="IncomeExpenseType";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="IncomeExpenseTypeID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>