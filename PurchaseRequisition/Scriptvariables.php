<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
    $Entity="PurchaseRequisition";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Purchase Requisition";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="PurchaseRequisitionID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>