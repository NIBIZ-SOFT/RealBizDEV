
<style>
.title {
	font-size: 19px;
	border-bottom: 1px solid black;
	padding-bottom: 10px;
	width: 70%;
}
</style>

<?php
if(isset($_POST['get_option']))
{
 $UserID = $_POST['get_option'];
 $find=mysql_query("select * from tbluser where UserID='$UserID'");
 $row=mysql_fetch_assoc($find);

	 $UserID=$row['UserID'];
	 $BasicSalary=$row['BasicSalary'];
	 $HouseRent=$row['HouseRent'];
	 $TravellingAllow=$row['TravellingAllow'];
	 $MedicalAllow=$row['MedicalAllow'];
	 $Food=$row['Food'];
	 $Mobile=$row['Mobile'];
	 $Donation=$row['Donation'];
	 $PFund=$row['PFund'];
	 $Tax=$row['Tax'];
	 $PF=($BasicSalary*$PFund)/100;
	 $STAX=($BasicSalary*$Tax)/100;
	 $SF=$BasicSalary/200;
	 
	 
	$Lhistory=mysql_query("select sum(Loan) as TotalLoan,sum(LoanPaid) as PaidLoan from tblsalary where UserID='$UserID'");
    $ThisLhistory=mysql_fetch_assoc($Lhistory);
	$PLoan=$ThisLhistory['PaidLoan'];
	$TLoan=$ThisLhistory['TotalLoan'];
	$CLoan=$TLoan-$PLoan;
	if(!$TLoan>0){
	   $LM="<span style='color:green'>No Loan</span>";
	}else{
	   $LM="<span style='color:blue'>Alreay Your Loan Or advance = </span>".$CLoan. " TK";
	}
}	 
?>	

  <form action="index.php?Theme=default&Base=SalaryPaySlip&Script=salaryinsert" method="post"> 
  
  <table>
     
  	 <tr>
	   <td colspan="2"><p class="title">Select Your Month And Name</p></td>
	 </tr>   
	   
     <tr>
	    <td colspan="2">
            <span class="set_title">Month And Year  Name</span> <br/>
			
			<select name="MonthName" style="max-width: 124px;" required>
			     <option value="">Select Month</option>
			     <option value="01">January</option>
				  <option value="02">February</option>
				  <option value="03">March</option>
				  <option value="04">April</option>
				  <option value="05">May</option>
				  <option value="06">June</option>
				  <option value="07">July</option>
				  <option value="08">August</option>
				  <option value="09">September</option>
				  <option value="10">October</option>
				  <option value="11">November</option>
				  <option value="12">December</option>
			</select>
			<select name="YearName" style="max-width: 95px;" required>			
				   <option value="">Select Year</option>
				   <option value="2016">2016</option>
				   <option value="2017">2017</option>
				   <option value="2018">2018</option>
				   <option value="2019">2019</option>
				   <option value="2020">2020</option>
				   <option value="2021">2021</option>
			</select>	
		</td> 
	 </tr>	 
		
  
     <tr>
	    <td colspan="2"><p class="title">Earning salery</p></td>
	 </tr> 

	 
     <tr>
	    <td>
		   Basic Salary <br/>
		  <input type="hidden" name="UserID" value="<?php echo $UserID;?>"/>
		  <input type="text" name="BasicSalary" value="<?php echo $BasicSalary;?>"/>
		</td>	  

		
	     <td>
		   House Rent<br/>
		  <input type="text" name="HouseRent" value="<?php echo $HouseRent;?>"/>
		</td>

	    <td>
		   Travelling Allowance <br/>
		  <input type="text" name="TravellingAllow" value="<?php echo $TravellingAllow;?>"/>
		</td>		
	 </tr>
	 
     <tr>
	    <td>
		   Medical Allowance <br/>
		  <input type="text" name="MedicalAllow" value="<?php echo $MedicalAllow;?>"/>
		</td>
		
		<td>
		   Food Allowance <br/>
		  <input type="text" name="FoodAllow" value="<?php echo $Food;?>"/>
		</td>	  
	    <td>
		   Mobile Allowance <br/>
		  <input type="text" name="MobileAllow" value="<?php echo $Mobile;?>"/>
		</td>
		
	 </tr>
	 
	 <tr>
	    <td>
		   Donation <br/>
		  <input type="text" name="Donation" value="<?php echo $Donation;?>"/>
		</td>	    
		
		  <td colspan="2" style="padding-left: 72px;">
		     <span style="color:red;font-size:16px"><?php echo $LM;?></span> <br/> More Loan Or Advance
             <input type="text" name="Loan"/>			 
		 </td>			   	
	 </tr>
	 
	 
	 <tr>
	   <td colspan="2"><p class="title">Deduction salery</p></td>
	 </tr> 
  
     <tr>
		<td>
		   Provident Fund <br/>
		  <input readonly type="text" name="ProvidentFund" value="<?php echo $PF; ?>"/>
		</td>	  

		<td>
		   Security Deposit<br/>
		  <input readonly type="text" name="SecurityDeposit" value="<?php echo $SF; ?>"/>
		</td>		
		
		<td>
		   Tax<br/>
		  <input readonly type="text" name="Tax" value="<?php echo $STAX; ?>"/>
		</td>
	 </tr>
	 
	   
     <tr>
		<td>
		   Loan Paid Amount<br/>
		  <input  type="text" name="LoanPaid"/>
		</td>	  
	 </tr>
	 

	 <tr>
	    <td colspan="2">
           <input type="submit" name="salary_submit" value="Get Data" class="att_btnpage" />	  
		</td>
	 </tr>
	 
	 
  </table>
  </form>
		
