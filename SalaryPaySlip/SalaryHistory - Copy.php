<?php
 $UID=$_GET['UserId'];
 $mi=$_GET['MI'];
 $yi=$_GET['YI'];
 
 
$LhistoryPaid=mysql_query("select * from tblsalary where UserID='$UID' and MonthName='$mi' and YearName='$yi'");
$ThisLhistoryPaid=mysql_fetch_assoc($LhistoryPaid);
$LoanPaid=$ThisLhistoryPaid['LoanPaid'];
$SalaryID=$ThisLhistoryPaid['SalaryID'];
 
 
$Lhistory=mysql_query("select sum(Loan) as TotalLoan,sum(LoanPaid) as PaidLoan from tblsalary where UserID='$UID'");
$ThisLhistory=mysql_fetch_assoc($Lhistory);
$PLoan=$ThisLhistory['PaidLoan'];
$TLoan=$ThisLhistory['TotalLoan'];
$CLoan=$TLoan-$PLoan;
 
 
$udata=mysql_query("SELECT * from tbluser where UserID='$UID'");
$thisudata=mysql_fetch_assoc($udata);

$Salarydata=mysql_query("SELECT * from tblsalary where UserID='$UID' and MonthName='$mi' and YearName='$yi'");
$ThisSalarydata=mysql_fetch_assoc($Salarydata);
$BasicSalary=$ThisSalarydata['BasicSalary'];
$HouseRent=$ThisSalarydata['HouseRent'];
$TravellingAllow=$ThisSalarydata['TravellingAllow'];
$MedicalAllow=$ThisSalarydata['MedicalAllow'];
$FoodAllow=$ThisSalarydata['FoodAllow'];
$MobileAllow=$ThisSalarydata['MobileAllow'];
$Donation=$ThisSalarydata['Donation'];


$Tax=$ThisSalarydata['Tax'];
$ProvidentFund=$ThisSalarydata['ProvidentFund'];
$SecurityDeposit=$ThisSalarydata['SecurityDeposit'];

$TEarning=$BasicSalary+$HouseRent+$TravellingAllow+$MedicalAllow+$FoodAllow+$MobileAllow+$Donation+$CLoan;
$TDeduction=$Tax+$ProvidentFund+$LoanPaid+$SecurityDeposit;

$NetSalary=$TEarning-$TDeduction;

 
include("inc/ascdatapic.php");
 

$tdata=mysql_query("SELECT * from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and UserID='$UID'");
while($thistdata=mysql_fetch_assoc($tdata)){
?>

<?php
$thistdata['UserID'];
$AsDate=$thistdata['InDate'];
?>

<?php }?>



<?php

$MainContent.='
<style>
.SalaryPaySlip {
	background-color: #F5F5F5;
	width: 91%;
}
.SalaryPaySlip p {
	font-size: 17px;
	padding-left: 7px;
	padding-top: 14px;
	margin: 0px;
}
.main_box {
	width: 100%;
}
.box_left {
	width: 15%;
	float: left;
	background-color: beige;
	margin-top: 14px;
	margin-left: 3px;
}
.box_right {
	float: left;
	width: 74%;
	margin-left: 23px;
	margin-bottom: 88px;
}
.head {
	background-color: #35b735;
	color: white;
}
</style>
';


$MainContent.='
<div class="container">
  
  <div class="SalaryPaySlip">
     <p>Mange Pay Slip Datils History Report<p>
  </div>
  
  <div class="main_box">
     <div class="box_left">
	     <p style="font-size: 18px;border-bottom: 1px solid #5E8D9C;padding-bottom: 7px;color: orangered;margin-top: 9px;">Attendance Summary</p>
	    <table border="1" style="width: 100%;text-align: center;">
		  <tr>
		    <td>Absent</td>
		    <td>'.$AbsentDay.' Day</td>
		  </tr>
		  
		  <tr>
		    <td>Holiday</td>
		    <td>10</td>
		  </tr>		

		  <tr>
		    <td>Present</td>
		    <td>10</td>
		  </tr>
		  
		  <tr>
		    <td>Leave</td>
		    <td>10</td>
		  </tr>	

		  <tr>
		    <td>Late</td>
		    <td>'.$LateTimeMin.' Min</td>
		  </tr>
		  
		  <tr>
		    <td>OverTime</td>
		    <td>10</td>
		  </tr>
		  
		  <tr>
		    <td>Early Leaving</td>
		    <td>10</td>
		  </tr>
		  
		</table>
	 </div>
     <div class="box_right">
	   <p style="text-align: center;font-size: 20px;border-bottom: 1px solid black;padding-bottom: 13px;width: 22%;margin: 0 auto;margin-top: 15px;margin-bottom: 18px;">Montly salary Report</p>
	   
	   
	   <table style="text-align:center;float: left;width: 37%;background-color: beige;margin: 0px 0px 13px 1px;" border="1">	   
	      <tr>
		     <td><span class="e_title">Employee Name</span></td>
		     <td>'.$thisudata['FullName'].'</td>
		  </tr>
	   
	      <tr>
		     <td><span class="e_title">Month And Year</span></td>
		     <td>'.$mi.' - '.$yi.'</td>
		  </tr>
		  
	      <tr>
		     <td><span class="e_title">Department</span></td>
		     <td>'.$thisudata['Department'].'</td>
		  </tr>		  
	   </table>


	   
	   <table style="float: right;margin-top: 30px;">	   
	      <tr>
		     <td><a href="index.php?Theme=default&Base=SalaryPaySlip&Script=update&SalaryID='.$SalaryID.'" style="background-color: #412AD7;color: white;border-radius: 3px;padding: 4px 12px;font-size: 19px;margin-right: 17px;">Modify This Data</a></td>
		     <td><a href="" style="background-color: green;color: white;border-radius: 3px;padding: 2px 12px;font-size: 19px;margin-right: 17px;">Get Pay Slip</a></td>
		     <td><a href="index.php?Theme=default&Base=SalaryPaySlip&Script=index" style="background-color: green;color: white;border-radius: 3px;padding: 2px 12px;font-size: 19px;margin-right: 0px;">Back The Page</a></td>
		  </tr>		  
	   </table>	
	   
	   <table style="float: right;margin-top: 10px;">	   
	      <tr>
		     <!--<td><a href="index.php?Theme=default&Base=SalaryPaySlip&Script=update&SalaryID='.$SalaryID.'" style="background-color: #412AD7;color: white;border-radius: 3px;padding: 4px 12px;font-size: 19px;margin-right: 0px;">Modify This Data</a></td>-->
		  </tr>		  
	   </table>
	   
	   
	   
	   <table style="width: 51%;text-align: center;float: right;margin-top: 43px;" border="1">
	   
	      <tr class="head">
              <td colspan="2"  style="font-size: 22px;padding: 8px;color: #090c00;"><span>Deduction Salary</span></td>
		  </tr>	    


		  <tr class="head" style="background-color: yellowgreen;color: blue;font-size: 17px;">
		     <th><span class="head_data">Salary Head</span></th>
		     <th><span class="head_data">Amount</span></th>
		  </tr>
		  
	   
	      <tr>
		     <td><span class="head_sub_data">Provident Fund</span></th>
		     <td><span class="head_amt_data">'.$ProvidentFund.'</span></th>
		  </tr>
		  
		  
	   
	      <tr>
		     <td><span class="head_sub_data">Security Deposit</span></th>
		     <td><span class="head_amt_data">'.$SecurityDeposit.'</span></th>
		  </tr>
		  
		  
	   
	      <tr>
		     <td><span class="head_sub_data">Tax</span></th>
		     <td><span class="head_amt_data">'.$Tax.'</span></th>
		  </tr>
		  
		  
	   
	      <tr>
		     <td><span class="head_sub_data">Loan Paid</span></th>
		     <td><span class="head_amt_data">'.$LoanPaid.'</span></th>
		  </tr>
		  
		  <tr style="background-color: aquamarine;font-weight: 700;">
		     <td><span class="head_sub_data">Total Earning</span></th>
		     <td><span class="head_amt_data">'.$TDeduction.'</span></th>
		  </tr>
		  
	   </table>
	   
	   
	   <table style="width: 47%;margin-top: 14px;text-align: center;float: right;margin-right: 16px;" border="1">
	   
	   	  <tr class="head">
              <td colspan="2"  style="font-size: 22px;padding: 8px;color: #090c00;"><span>Earning Salary</span></td>
		  </tr>
	   
	   
	      <tr class="head" style="background-color: yellowgreen;color: blue;font-size: 17px;">
		     <th><span class="head_data">Salary Head</span></th>
		     <th><span class="head_data">Amount</span></th>
		  </tr>
		  
	   
	      <tr>
		     <td><span class="head_sub_data">Basic salary</span></th>
		     <td><span class="head_amt_data">'.$BasicSalary.'</span></th>
		  </tr>
		  
		  
	   
	      <tr>
		     <td><span class="head_sub_data">House Rent</span></th>
		     <td><span class="head_amt_data">'.$HouseRent.'</span></th>
		  </tr>
		  
		  
	   
	      <tr>
		     <td><span class="head_sub_data">Travelling Allowance</span></th>
		     <td><span class="head_amt_data">'.$TravellingAllow.'</span></th>
		  </tr>
		  
		  
	   
	      <tr>
		     <td><span class="head_sub_data">Medical Allowance</span></th>
		     <td><span class="head_amt_data">'.$MedicalAllow.'</span></th>
		  </tr>
		  
		  
	   
	      <tr>
		     <td><span class="head_sub_data">Food Allowance</span></th>
		     <td><span class="head_amt_data">'.$FoodAllow.'</span></th>
		  </tr>
		  
		  
	   
	      <tr>
		     <td><span class="head_sub_data">Mobile Allowance</span></th>
		     <td><span class="head_amt_data">'.$MobileAllow.'</span></th>
		  </tr>	     

		  <tr>
		     <td><span class="head_sub_data">Donation</span></th>
		     <td><span class="head_amt_data">'.$Donation.'</span></th>
		  </tr>		

		  <tr>
		     <td><span class="head_sub_data">Loan</span></th>
		     <td><span class="head_amt_data" style="color:green"> <span style="color:red"><a href="">Prev('.$TLoan.')</a> </span> <br/>'.$CLoan.'</span></th>
		  </tr>			

		  <tr style="background-color: aquamarine;font-weight: 700;">
		     <td><span class="head_sub_data">Total Earning</span></th>
		     <td><span class="head_amt_data">'.$TEarning.'</span></th>
		  </tr>	
		  
	   </table>
	   
	 
	   <table border="1" style="width: 100%;float: left;margin-top: 35px;background-color: #35B735;color: #021518;font-weight: 700;">
	     <tr style="width: 100%;">
		    <td style="width: 14%;padding-left: 9px;">Net Salary</td>
		    <td style="padding-left: 9px;">'.$NetSalary.' (Two T O H Taka)</td>
		 </tr>
	   </table>
	   
	   
	   
	   
	 </div>
  </div>
  
<div>  
 ';

