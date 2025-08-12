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


$Tax=$ThisSalaryHUP['Tax'];
$ProvidentFund=$ThisSalaryHUP['ProvidentFund'];
$SecurityDeposit=$ThisSalaryHUP['SecurityDeposit'];

$Lhistory=mysql_query("select sum(Loan) as TotalLoan,sum(LoanPaid) as PaidLoan from tblsalary where UserID='$UserID'");
$ThisLhistory=mysql_fetch_assoc($Lhistory);
$PLoan=$ThisLhistory['PaidLoan'];
$TLoan=$ThisLhistory['TotalLoan'];
$CLoan=$TLoan-$LoanPaid;

$udata=mysql_query("SELECT * from tbluser where UserID='$UserID'");
$thisudata=mysql_fetch_assoc($udata);

  $MainContent.=' 
  <style>
	.title {
		font-size: 19px;
		border-bottom: 1px solid black;
		padding-bottom: 10px;
		width: 70%;
	}
	.update_page {
	width: 80%;
	margin: 0 auto;
     }
	</style>
  <div class="update_page">
  <form action="index.php?Theme=default&Base=SalaryPaySlip&Script=updateinsert" method="post"> 
    
    <table style="margin-bottom: 22px;">
	   <tr>
	      <td>
		   <p style="font-size: 24px;background-color: #28c941;color: white;padding: 12px 4px;width: 658px;">Salery History Update Page</p>
		  </td>
	   </tr>
	</table>

	
	<table style="text-align:center;float: left;width: 37%;background-color: #808060;margin: 0px 0px 13px 1px;margin-bottom: 10px;border: 1px solid black;height: 101px;color: white;font-size: 18px;" border="1">	   
	      <tr>
		     <td><span class="e_title">Employee Name</span></td>
		     <td>'.$thisudata['FullName'].'</td>
		  </tr>
	   
	      <tr>
		     <td><span class="e_title">Month And Year</span></td>
		     <td>'.$MonthName.' - '.$YearName.'</td>
		  </tr>
		  
	      <tr>
		     <td><span class="e_title">Department</span></td>
		     <td>'.$thisudata['Department'].'</td>
		  </tr>		  
	   </table>
	
	
	
	<table>  
 
     <tr>
	    <td colspan="2"><p class="title">Earning salery</p></td>
	 </tr> 

	 
     <tr>
	    <td>
		   Basic Salary <br/>
		  <input type="hidden" name="YearName" value="'.$YearName.'"/>
		  <input type="hidden" name="MonthName" value="'.$MonthName.'"/>
		  
		  <input type="hidden" name="SalaryID" value="'.$SalaryID.'"/>
		  <input type="hidden" name="UserID" value="'.$UserID.'"/>
		  <input readonly type="text" name="BasicSalary" value="'.$BasicSalary.'"/>
		</td>	  

		
	     <td>
		   House Rent<br/>
		  <input type="text" name="HouseRent" value="'.$HouseRent.'"/>
		</td>

	    <td>
		   Travelling Allowance <br/>
		  <input type="text" name="TravellingAllow" value="'.$TravellingAllow.'"/>
		</td>		
	 </tr>
	 
     <tr>
	    <td>
		   Medical Allowance <br/>
		  <input type="text" name="MedicalAllow" value="'.$MedicalAllow.'"/>
		</td>
		
		<td>
		   Food Allowance <br/>
		  <input type="text" name="FoodAllow" value="'.$FoodAllow.'"/>
		</td>	  
	    <td>
		   Mobile Allowance <br/>
		  <input type="text" name="MobileAllow" value="'.$MobileAllow.'"/>
		</td>
		
	 </tr>
	 
	 <tr>
	    <td>
		   Donation <br/>
		  <input type="text" name="Donation" value="'.$Donation.'"/>
		</td>	    
		
		  <td colspan="2" style="padding-left: 72px;">
		     <span style="color:red;font-size:16px"><a href="">Total Loan/Advance ('.$TLoan.')</a></span> <br/> More Loan/Advance
             <input type="text" name="Loan" value="'.$Loan.'"/>			 
		 </td>			   	
	 </tr>
	 
	 
	 <tr>
	   <td colspan="2"><p class="title">Deduction salery</p></td>
	 </tr> 
  
     <tr>
		<td>
		   Provident Fund <br/>
		  <input readonly type="text" name="ProvidentFund" value="'.$ProvidentFund.'"/>
		</td>	  

		<td>
		   Security Deposit<br/>
		  <input readonly type="text" name="SecurityDeposit" value="'.$SecurityDeposit.'"/>
		</td>		
		
		<td>
		   Tax<br/>
		  <input readonly type="text" name="Tax" value="'.$Tax.'"/>
		</td>
	 </tr>
	 
	   
     <tr>
		<td>
		   Loan Paid Amount<br/>
		  <input  type="text" name="LoanPaid" value="'.$LoanPaid.'"/>
	      <span style="color:red">'.$_GET['EM'].'</span>
		</td>	  
	 </tr>
	 

	 <tr>
	    <td colspan="2">
           <input type="submit" name="salary_update" value="Update Data" class="att_btnpage" />	  
		</td>
	 </tr>
	 
	 
  </table>
  </form>
  </div>
';