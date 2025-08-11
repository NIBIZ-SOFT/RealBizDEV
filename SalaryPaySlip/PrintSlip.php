
<?php

$SID=$_GET['SalaryID'];
$SalaryHUP=mysql_query("select * from tblsalary where SalaryID='$SID'");
$ThisSalaryHUP=mysql_fetch_assoc($SalaryHUP);
$UserID=$ThisSalaryHUP['UserID'];
$SalaryID=$ThisSalaryHUP['SalaryID'];

$YearName=$ThisSalaryHUP['YearName'];
$MonthName=$ThisSalaryHUP['MonthName'];
$LoanPaid=$ThisSalaryHUP['LoanPaid'];

$BasicSalary=$ThisSalaryHUP['BasicSalary'];
$HouseRent=$ThisSalaryHUP['HouseRent'];
$TravellingAllow=$ThisSalaryHUP['TravellingAllow'];
$MedicalAllow=$ThisSalaryHUP['MedicalAllow'];
$FoodAllow=$ThisSalaryHUP['FoodAllow'];
$MobileAllow=$ThisSalaryHUP['MobileAllow'];
$Donation=$ThisSalaryHUP['Donation'];
$Loan=$ThisSalaryHUP['Loan'];

$TotalEarning=$BasicSalary+$HouseRent+$TravellingAllow+$MedicalAllow+$FoodAllow+$MobileAllow+$Donation+$Loan;


$Tax=$ThisSalaryHUP['Tax'];
$ProvidentFund=$ThisSalaryHUP['ProvidentFund'];
$SecurityDeposit=$ThisSalaryHUP['SecurityDeposit'];


$Lhistory=mysql_query("select sum(Loan) as TotalLoan,sum(LoanPaid) as PaidLoan from tblsalary where UserID='$UserID'");
$ThisLhistory=mysql_fetch_assoc($Lhistory);
$PLoan=$ThisLhistory['PaidLoan'];
$TLoan=$ThisLhistory['TotalLoan'];
$CLoan=$TLoan-$LoanPaid;


$TotalDeduction=$Tax+$ProvidentFund+$SecurityDeposit+$LoanPaid;

$TotalSalary=$TotalEarning-$TotalDeduction;


$udata=mysql_query("SELECT * from tbluser where UserID='$UserID'");
$thisudata=mysql_fetch_assoc($udata);

  $MainContent.=' 
  
<style>
th, td {
    border-bottom: 1px solid #ddd;
}
</style>
  
  <table style="width:50%;margin:0 auto; text-align:center" border="1">
	      <tr>
		     <td>Employee Name</td>
		     <td>'.$thisudata['FullName'].'</td>
		  </tr>
	   
	      <tr>
		     <td>Month And Year</td>
		     <td>'.$MonthName.' - '.$YearName.'</td>
		  </tr>
		  
	      <tr>
		     <td>Branch Name</td>
		     <td>'.$thisudata['BranchName'].'</td>
		  </tr>		      
		  
		  <tr>
		     <td>Department</td>
		     <td>'.$thisudata['Department'].'</td>
		  </tr>		      
		  
		  <tr>
		     <td>Designation</td>
		     <td>'.$thisudata['Designation'].'</td>
		  </tr>			

		  <tr>
		     <td>Job Status</td>
		     <td>'.$thisudata['JobStatus'].'</td>
		  </tr>	
  </table>
  
  <table style="width:80%;margin:0 auto; border:1px solid black">
     <tr>
	    <td colspan="2"><h4>Earning Section</h4></td>
	    <td colspan="2"><h4>Deduction Section</h4></td>
	 </tr>
	 
	 <tr>
	   <td>Basic Salary</td>
	   <td>'.$BasicSalary.'</td>
	   <td>Provident Fund</td>
	   <td>'.$ProvidentFund.'</td>
	 </tr>
	 
	 
	 <tr>
	   <td>House Rent </td>
	   <td>'.$HouseRent.'</td>
	   <td>Security Deposit</td>
	   <td>'.$SecurityDeposit.'</td>
	 </tr>
	 
	 
	 <tr>
	   <td>Travelling Allowance</td>
	   <td>'.$TravellingAllow.'</td>
	   <td>Tax</td>
	   <td>'.$Tax.'</td>
	 </tr>
	 
	 
	 <tr>
	   <td>Medical Allowance</td>
	   <td>'.$MedicalAllow.'</td>
	   <td>Loan Paid Amount</td>
	   <td>'.$LoanPaid.' <br/>
	   <span style="color:red">'.$_GET['EM'].'</span></td>
	 </tr>
	 
	 
	 <tr>
	   <td>Food Allowance</td>
	   <td>'.$FoodAllow.'</td>
	   <td></td>
	   <td></td>
	 </tr>
	 
	 <tr>
	   <td>Mobile Allowance</td>
	   <td>'.$MobileAllow.'</td>
	   <td></td>
	   <td></td>
	 </tr>	

	 <tr>
	   <td>Donation</td>
	   <td>'.$Donation.'</td>
	   <td></td>
	   <td></td>
	 </tr>	
	 
	 <tr>
	   <td>More Loan/Advance</td>
	   <td>'.$Loan.'</td>
	   <td></td>
	   <td></td>
	 </tr>	 
	 
	 
	 <tr>
	   <td><h4>Total Earning Salary</h4></td>
	   <td><h4>'.$TotalEarning.'</h4></td>
	   <td><h4>Total Deduction Salary</h4></td>
	   <td><h4>'.$TotalDeduction.'</h4></td>
	 </tr>	
	 
	 <tr>
	   <td colspan="4" style="text-align:center">
	   <h2>
	      Total Salary: '.$TotalSalary.'
	   </h2>
	   </td>
	 </tr>
	 
  </table>
   
';

?>




<script>
    window.print();
</script>
