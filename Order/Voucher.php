<?php
function convertNumberToWords($number){
        //A function to convert numbers into Indian readable words with Cores, Lakhs and Thousands.
        $words = array(
        '0'=> '' ,'1'=> 'one' ,'2'=> 'two' ,'3' => 'three','4' => 'four','5' => 'five',
        '6' => 'six','7' => 'seven','8' => 'eight','9' => 'nine','10' => 'ten',
        '11' => 'eleven','12' => 'twelve','13' => 'thirteen','14' => 'fouteen','15' => 'fifteen',
        '16' => 'sixteen','17' => 'seventeen','18' => 'eighteen','19' => 'nineteen','20' => 'twenty',
        '30' => 'thirty','40' => 'fourty','50' => 'fifty','60' => 'sixty','70' => 'seventy',
        '80' => 'eighty','90' => 'ninty');
       
        //First find the length of the number
        $number_length = strlen($number);
        //Initialize an empty array
        $number_array = array(0,0,0,0,0,0,0,0,0);       
        $received_number_array = array();
       
        //Store all received numbers into an array
        for($i=0;$i<$number_length;$i++){    $received_number_array[$i] = substr($number,$i,1);    }

        //Populate the empty array with the numbers received - most critical operation
        for($i=9-$number_length,$j=0;$i<9;$i++,$j++){ $number_array[$i] = $received_number_array[$j]; }
        $number_to_words_string = "";       
        //Finding out whether it is teen ? and then multiplying by 10, example 17 is seventeen, so if 1 is preceeded with 7 multiply 1 by 10 and add 7 to it.
        for($i=0,$j=1;$i<9;$i++,$j++){
            if($i==0 || $i==2 || $i==4 || $i==7){
                if($number_array[$i]=="1"){
                    $number_array[$j] = 10+$number_array[$j];
                    $number_array[$i] = 0;
                }       
            }
        }
       
        $value = "";
        for($i=0;$i<9;$i++){
            if($i==0 || $i==2 || $i==4 || $i==7){    $value = $number_array[$i]*10; }
            else{ $value = $number_array[$i];    }           
            if($value!=0){ $number_to_words_string.= $words["$value"]." "; }
            if($i==1 && $value!=0){    $number_to_words_string.= "Crores "; }
            if($i==3 && $value!=0){    $number_to_words_string.= "Lakhs ";    }
            if($i==5 && $value!=0){    $number_to_words_string.= "Thousand "; }
            if($i==6 && $value!=0){    $number_to_words_string.= "Hundred "; }
        }
        if($number_length>9){ $number_to_words_string = "Sorry This does not support more than 99 Crores"; }
        return ucwords(strtolower("".$number_to_words_string)."");
    }

$Expense=SQL_Select($Entity="Order", $Where="OrderID='{$_REQUEST["RefNo"]}'","","True");

$Customer=SQL_Select($Entity="Customer", $Where="CustomerID='{$Expense["CustomerID"]}'","","True");


	switch($Expense['PaymentMethod']){
	 
	 case 'cash':
	  $PaymentMethodRowPrint='<tr><td align="right" colspan="3"><b>Paid Amount :</b></td>
	  <td>Tk. <i><u>'.$Expense['Price'].'</u></i></td></tr>'; 
	 
	 break;	 
	 case 'due':
	 $PaymentMethodRowPrint='
	 <tr><td align="right" colspan="3"><b>Paid Amount :</b></td>
	 <td> Tk. <i><u> '.$Expense['PaidAmount'].'</u></i></td></tr>	 
	 <tr><td align="right" colspan="3"><b>Due Amount :</b></td><td> Tk. <i><u>'.$Expense['DueAmount'].'</u></i></td></tr>
	 <tr><td align="right" colspan="3"><b>Due Date :</b></td><td><i><u>'.$Expense['DueDate'].'</u></i></td></tr>';
	 break;	 
	 case 'cheque':
	 $PaymentMethodRowPrint="<tr><td colspan='3' align='right'><b>Check No:</b></td>
	 <td>".$Expense["checkno"]."</td></tr><tr><td colspan='3' align='right'><b>Bank Name:</b></td>
	 <td>".$Expense["bankname"]."</td></tr><tr><td colspan='3' align='right'><b>Check Date:</b></td>
	 <td>".$Expense["CheckDate"]."</td></tr>";
	 break;	 
	 case 'card':
	 $PaymentMethodRowPrint="<tr><td colspan='3' align='right'><b>Card No:</b></td>
	 <td>".$Expense["cardno"]."</td></tr><tr><td colspan='3' align='right'><b>Card Name:</b></td>
	 <td>".$Expense["cardname"]."</td></tr><tr><td colspan='3' align='right'><b>Card Date:</b></td>
	 <td>".$Expense["cardDate"]."</td></tr>";
	 
	 break;
	
	
	}


$GetCompanyInfo=SQL_Select("Settings","SettingsID=1","","true");
/*$GetCompanyInfo=mysql_fetch_assoc(mysql_query("select * from `tblsettings` where SettingsID=1 "));
echo "select * from `tblsettings` where SettingsID=1 ";

print_r($GetCompanyInfo);
*/
$MainContent.="

	<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.1//EN\" \"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd\">
	<html>
	<head>
	<meta http-equiv=\"content-type\" content=\"text/html; charset=utf-8\" /><title>Invoice</title>
	<style type='text/css'>
	th{
		text-align:left;
		padding-left:5px;
	}
	td{
	  padding-left:5px;
	}
	
	</style>
	
	</head>
	<body>


	<fieldset>
		<legend>Ref No : {$_REQUEST["RefNo"]}</legend>

	<table width=\"800\" align=\"center\" border=\"0\" cellpadding='0' cellspacing='0'>
		<tr>
			<td>
				<table>
					<tr><th>Client Name:</th><td>".$Customer['CustomerName']."</td></tr>
					<tr><th>Address:</th><td>".$Customer['Address']."</td></tr>
					<tr><th>Phone:</th><td>".$Customer['Phone']."</td></tr>
					<tr><th>Date:</th><td>".$Expense['Date']."</td></tr>
				</table>
			</td>
		
		    <td align=\"right\">
	             {$GetCompanyInfo["Address"]}
			</td>
		</tr>
		<tr>
		    <td colspan='2'>
			
			<table cellpadding='0' cellspacing='0' border='1' width='100%'><tr><th width='60'>Product code</th><th>Name</th><th width='90'>Qty</th><th>Price</th></tr>";
			
			$productQuery=mysql_query("select * from `tblorderproducts` where OrderID='".$Expense['OrderID']."'");
				while($prdasoc=mysql_fetch_assoc($productQuery)){
					
					$prdName=mysql_fetch_assoc(mysql_query("select * from `tblproducts` where ProductsID='".$prdasoc['ProdID']."'"));
					
					$MainContent.='<tr>
					<td>'.$prdasoc['ProdID'].'</td>					
					<td>'.$prdName['ProductName'].'</td>
					<td>'.$prdasoc['Qty'].'</td>
					<td>'.$prdasoc['Price'].'</td>
					</tr>';
				
				}	
				
		$MainContent.="	 
		      
			  <tr><td colspan='3' align='right'><b>Total Amount :</b></td><td>Tk. <i><u>{$Expense["Price"]}</u></i></td></tr>
		      ".$PaymentMethodRowPrint."
			  
			  <tr><td colspan='4'><b>In word :</b> <u><i>".convertNumberToWords($Expense["Price"])."</i></u>&nbsp;&nbsp;Taka Only
		       </td></tr> 
		   </table>    
		    
		            
				
				
";

$MainContent.="			
				<div style='margin-left:50px; text-align:center; float:left; width:200px;'>
				<br />
				<br />
				<br />
				<hr/>
                Receive By
				</div>				
				
				<div style='margin-left:322px; text-align:center; float:left; width:200px;'>
				<br />
				<br />
				<br />
				<hr/>
                Office Authority
				</div>
				
			</td>
		</tr>
	</table>
	</fieldset>


	<center style='font-family:arial;font-size:12px;'>
		Developed by N.I Biz Soft Solutions. cell : 01712643138, email : info@nibizsoft.com
	</center>	
	
	<script language=\"JavaScript\">
			window.print();
			//window.close();
	</script>

</body>
</html>
";




?>