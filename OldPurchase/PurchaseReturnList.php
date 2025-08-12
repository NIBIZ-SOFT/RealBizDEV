<?

GetPermission("OptionSales");	

$Refund=SQL_Select("PurchaseRefund","1=1 order by PurchaseRefundID DESC limit 10");

foreach($Refund as $ThisRefund){
	$HTML.='
	
				<tr>
					<td>'.GetProductName($ThisRefund["ProductID"]).'</td>
					<td>'.$ThisRefund["Qty"].'</td>
					<td>'.$ThisRefund["Price"].'</td>
					<td>'.$ThisRefund["Reason"].'</td>
					<td>
						<a href="index.php?Theme=default&Base=Purchase&Script=Voucher&TempNumber='.$ThisRefund["TempNumber"].'&NoHeader&NoFooter">View Invoice</a>
					</td>					
				</tr>	
	
	';
}

$MainContent.='

<center>
	<h1> Purchase Return </h1>
</center>


<div class="block">
	<div class="navbar navbar-inner block-header">
		<div class="muted pull-left">Purchase Return List</div>
		<div class="pull-right"><a href="'.ApplicationURL("Purchase","PurchaseReturn").'"><i class="icon-chevron-right"></i>Make Purchase Return</a>

		</div>
	</div>
	<div class="block-content collapse in">
		<table class="table table-striped">
			<thead>
				<tr>
					<td><b>Product\'s Name</b></td>
					<td><b>Qty</b></td>
					<td><b>Price</b></td>
					<td><b>Refund Note</b></td>
					<td>
						<b>Option</b>
					</td>
				</tr>
			</thead>
			<tbody>
				'.$HTML.'
				
			</tbody>
		</table>
	</div>
</div>


';


	
?>