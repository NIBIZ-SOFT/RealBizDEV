<?
	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");
	
	if($_SESSION["CRMID"]!="" and $_REQUEST["CRMID"]=="")
	    $_REQUEST["CRMID"] = $_SESSION["CRMID"];
	    
    $CRM = SQL_Select("CRM","CRMID={$_REQUEST["CRMID"]}","",true);
    
    $_SESSION["CRMID"]=$CRM["CRMID"];
	
    $Entity="CRMDetails";
    $EntityLower=strtolower($Entity);
    $EntityCaption="<span style=\"color:blue; font-size:14px;\">CRM Details - {$CRM["Title"]} - {$CRM["CustomerName"]} ({$CRM["Phone"]}) - {$CRM["ProjectName"]}</span>";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="CRMDetailsID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>