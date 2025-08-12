<?
if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
$Entity="BOQ";
$EntityLower=strtolower($Entity);
$EntityCaption="BOQ Management";
$EntityCaptionLower=strtolower($EntityCaption);
$OrderByValue="BoqID";

?>