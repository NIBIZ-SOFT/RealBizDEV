<?
//	if ($_SESSION["UserID"]==1)Header("Location:index.php?TheScript.org&Theme=default&Base=System&Script=login");
    $Entity="ExpenseList";
    $EntityAlias="EL";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Expense List";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="Name";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "Name";


?>