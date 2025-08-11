<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="InitialExpensehead";
    $EntityLower=strtolower($Entity);
    $EntityCaption="InitialExpensehead";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="InitialExpenseheadID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>