<?php
$sold_check=SQL_Select("products","ProductsIsActive='UnSold'");
$n=1;
foreach($sold_check as $This_sold_check){

$tprice=$total_price+=$This_sold_check['SellingPrice'];

$unsoldhtml.='
	 <tr>
            <td>'.$n.'</td>
	    <td>'.$This_sold_check['Category'].'</td>
	    <td>'.$This_sold_check['FlatNumber'].'</td>
	    <td>'.$This_sold_check['Brand'].'</td>
	    <td>'.$This_sold_check['Units'].'</td>
	    <td>'.$This_sold_check['PurchaseLatestPrice'].'</td>
	    <td>'.$This_sold_check['CarParking'].'</td>
	    <td>'.$This_sold_check['UtilityCharge'].'</td>
	    <td>'.$This_sold_check['SellingPrice'].'</td>
	    <td>'.$This_sold_check['ProductsDescription'].'</td>
            <td>'.$This_sold_check['ProductsIsActive'].'</td>
	 </tr>
';
$n++;
}


$MainContent.='
  <table style="width:100%;margin:0 auto" border="1">
     <tr>
	   <th colspan="11"><h3>UnSold Report View</h3></th>
	 </tr>
     <tr>
	    
            <th>SL</th>
            <th>Projects Name</th>
	    <th>Flat Number</th>
	    <th>Floor Number</th>
	    <th>Flat Size</th>
	    <th>Unit Price</th>
	    <th>Car Parking</th>
	    <th>Utility Charge</th>
	    <th>Selling Price</th>
	    <th>Description</th>
            <th>Status</th>
	 </tr>
	 '.$unsoldhtml.'

	 <tr>
            <td colspan="8" style="text-align:right"> <b>Total Expected Income From UnSold Flat</b> </td>
	    <td colspan="3"> <b>'.$tprice.' &nbsp; /=</b> </td>
	 </tr>

  </table>
'; 