<?

GetPermission("OptionSales");	

$Refund=SQL_Select("Refund","1=1 order by RefundID DESC limit 10");

foreach($Refund as $ThisRefund){
	$HTML.='
	
				<tr>
					<td>'.GetProductName($ThisRefund["ProductID"]).'</td>
					<td>'.$ThisRefund["Qty"].'</td>
					<td>'.$ThisRefund["Price"].'</td>
					<td>'.$ThisRefund["RefundNote"].'</td>
					<td>
						<a href="index.php?Theme=default&Base=Sales&Script=Invoice&TempNumber='.$ThisRefund["TempNumber"].'&NoHeader&NoFooter">View Invoice</a>
					</td>					
				</tr>	
	
	';
}

$MainContent.='

<center>
	<h1> Sales Return </h1>
</center>


<div class="block">
	<div class="navbar navbar-inner block-header">
		<div class="muted pull-left">Sales Return List</div>
		<div class="pull-right"><a href="'.ApplicationURL("Sales","SalesReturn").'"><i class="icon-chevron-right"></i>Make Sales Return</a>

		</div>
	</div>
	<div class="block-content collapse in">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Product\'s Name</th>
					<th>Qty</th>
					<th>Price</th>
					<th>Refund Note</th>
					<th>
						Option
					</th>
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