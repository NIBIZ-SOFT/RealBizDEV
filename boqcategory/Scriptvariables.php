<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="boqcategory";
    $EntityLower=strtolower($Entity);
    $EntityCaption="BOQ Category";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="BoqCategoryID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>