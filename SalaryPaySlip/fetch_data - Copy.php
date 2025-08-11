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
 while($row=mysql_fetch_array($find))
 {
	 $UserID=$row['UserID'];
	 $BasicSalary=$row['BasicSalary'];
	 $HouseRent=$row['HouseRent'];
	 $TravellingAllow=$row['TravellingAllow'];
	 $MedicalAllow=$row['MedicalAllow'];
	 $Food=$row['Food'];
	 $Mobile=$row['Mobile'];
	 $Donation=$row['Donation'];
	 $Loan=$row['Loan'];
	 $PF=$BasicSalary/50;
	 $SF=$BasicSalary/200;
?>	

  <form action="index.php?Theme=default&Base=SalaryPaySlip&Script=salaryinsert" method="post"> 
  <table>
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
	 </tr>
	 
	 
	 <tr>
	   <td colspan="2"><p class="title">Deduction salery</p></td>
	 </tr> 
  
     <tr>
		<td>
		   Provident Fund <br/>
		  <input type="text" name="ProvidentFund" value="<?php echo $PF; ?>"/>
		</td>	  

		<td>
		   Security Deposit<br/>
		  <input type="text" name="SecurityDeposit" value="<?php echo $SF; ?>"/>
		</td>
	 </tr>
	   

	 <tr>
	   <td colspan="2"><p class="title">Select Your Month And Name</p></td>
	 </tr>   
	   
     <tr>
	    <td colspan="2">
            <span class="set_title">Month And Year  Name</span> <br/>
			<select name="MonthName" style="max-width: 124px;">
			     <option value="1">January</option>
				  <option value="2">February</option>
				  <option value="3">March</option>
				  <option value="4">April</option>
				  <option value="5">May</option>
				  <option value="6">June</option>
				  <option value="7">July</option>
				  <option value="8">August</option>
				  <option value="9">September</option>
				  <option value="10">October</option>
				  <option value="11">November</option>
				  <option value="12">December</option>
			</select>
			<select name="YearName" style="max-width: 90px;">			
				   <option>2016</option>
				   <option>2017</option>
				   <option>2018</option>
				   <option>2019</option>
				   <option>2020</option>
				   <option>2021</option>
			</select>	
		</td>
	 </tr>	 

	 <tr>
	    <td colspan="2">
           <input type="submit" name="salary_submit" value="Get Data" class="att_btnpage" />	  
		</td>
	 </tr>
	 
	 
  </table>
  </form>
<?php }
 exit;
  } 
?>

