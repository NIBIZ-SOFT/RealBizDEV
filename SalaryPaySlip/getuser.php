<?php 

for($y=2016;$y<=3025;$y++)
{
  $yearHTML.='
   <option>'.$y.'</option>
  ';
}

$insertHTML.='
  <option>January</option>
  <option>February</option>
  <option>March</option>
  <option>April</option>
  <option>May</option>
  <option>June</option>
  <option>July</option>
  <option>August</option>
  <option>September</option>
  <option>October</option>
  <option>November</option>
  <option>December</option>
';



$MainContent.='
<style>
.footer {
	width: 76%;
	margin-left: 265px;
	display: none;
}
</style>
';

echo $q = intval($_GET['q']);


$MainContent.='
  <table>
     <tr>
	    <td>Earning salery</td>
	    <td>Deduction salery</td>
	 </tr>
	 
	 
	 

	 
	 	 
     <tr>
	    <td>
		   Basic Salary <br/>
		  <input type="text" value="'.$q.'"/>
		</td>	  

		<td>
		   Provident Fund <br/>
		  <input type="text" value=""/>
		</td>
	 </tr>
	 
  
     <tr>
	    <td>
		   Dearness Allowance <br/>
		  <input type="text" value=""/>
		</td>	  

		<td>
		   Security Deposit<br/>
		  <input type="text" value=""/>
		</td>
	 </tr>
	   
     <tr>
	    <td>
		   Houes Allowance <br/>
		  <input type="text" value=""/>
		</td>	  

		<td>
		   Security Deposit<br/>
		  <input type="text" value=""/>
		</td>
	 </tr>


     <tr>
	    <td colspan="2">
            <span class="set_title">Month And Year  Name</span> <br/>
			<select name="MonthName" style="max-width: 124px;">
			   '.$insertHTML.'
			</select>
			<select name="YearName" style="max-width: 90px;">
			   '.$yearHTML.'
			</select>	
		</td>
	 </tr>	 

	 <tr>
	    <td colspan="2">
           <input type="submit" name="att_submit" value="Get Data" class="att_btnpage" />	  
		</td>
	 </tr>
	 
	 
  </table>
';