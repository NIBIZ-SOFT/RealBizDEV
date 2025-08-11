<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");


    if(isset($_REQUEST["ProductType"]))
        $_SESSION["ProductType"]=$_REQUEST["ProductType"];

    $Entity="Products";
    $EntityLower=strtolower($Entity);
    $EntityCaption="{$_SESSION["ProductType"]} Products";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="ProductsID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "ProductsID";


?>