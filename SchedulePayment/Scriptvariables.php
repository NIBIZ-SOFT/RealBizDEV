<?

	if ($_SESSION["UserID"]==1)Header("Location:index.php?Theme=default&Base=System&Script=login");

    $Entity="SchedulePayment";
    $EntityLower=strtolower($Entity);
    $EntityCaption="Schedule Payment Management";
    $EntityCaptionLower=strtolower($EntityCaption);
    $OrderByValue="SchedulePaymentID";
	// Check the value in the InsertUpdate Action Page for detect is the value is taken or not
    $UniqueField = "{$Entity}ID";


?>