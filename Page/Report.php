<?

$CashInHand=SQL_Select("Order","");
$TotalCashInHand=0;
foreach($CashInHand as $ThisCashInHand){
	
	$TotalCashInHand= $TotalCashInHand + $ThisCashInHand["Price"];
	
}

$MainContent.='
	
	<div style="font-size:16px;padding:10px;">
		Cash In hand : '.$TotalCashInHand.'/= Tk.<br>
	</div>


';
	
	
?>