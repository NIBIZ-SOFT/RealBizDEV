<? 

// User Name Option
/* 
$CsSalary=mysql_query("select sum(BasicSalary) as csalary from tbluser");
$RowCsSalary=mysql_fetch_assoc($CsSalary);
$CountSalary=$RowCsSalary[csalary];
if($CountSalary){
	echo "yes";
}else{
    echo "no";
} 
*/

	$UserReport =  SQL_Select("user","UserIsActive=1 and UserID>2 and !BasicSalary>0");
	foreach($UserReport as $ThisUserReport){
		$OptionUserHTML.='
			<option value="'.$ThisUserReport['UserID'].'">'.$ThisUserReport['FullName'].'</option>	 
		';
	}
	
	if($UserReport){
		//echo "yes";
	}else{
		$updateSetHTML.='
		 <style>
		  #slarytable{display:none}
		 </style>
		 
		 <table style="width: 48%;margin: 0 auto;background-color: whitesmoke;margin-top: 25px;">
		   <tr>
		      <td style="line-height: 30px;padding: 50px;">
			     <span style="font-size: 22px;color: red;">No! New Employee</span> <br/>
			     <span>Already All Employee Salary Set Succesfully</span><br/>
				 <span>when new employee add then Enable Salary Set Option</span> <br/>
				 <span style="font-size: 18px;color: green;">All Old Employee Salary Set list View <a href="index.php?Theme=default&Base=SalaryPaySlip&Script=home&rr=1">Click Here</span></a>
			  </td>
		   </tr>
		 </table>
		';
	}


// BranchReport Name Option
$BranchReport =  SQL_Select("branch","BranchIsActive=1");
foreach($BranchReport as $ThisBranchReport){
	$OptionBranchHTML.='
        <option value="'.$ThisBranchReport['BranchName'].'">'.$ThisBranchReport['BranchName'].'</option>	 
	';
}


// DeptReport Name Option
$DeptReport =  SQL_Select("department","DepartmentIsActive=1");
foreach($DeptReport as $ThisDeptReport){
	$OptionDeptHTML.='
        <option value="'.$ThisDeptReport['DepartmentName'].'">'.$ThisDeptReport['DepartmentName'].'</option>	 
	';
}


// DegiReport Name Option
$DegiReport =  SQL_Select("designation","DesignationIsActive=1");
foreach($DegiReport as $ThisDegiReport){
	$OptionDegiHTML.='
        <option value="'.$ThisDegiReport['DesignationName'].'">'.$ThisDegiReport['DesignationName'].'</option>	 
	';
}




$MainContent.='

<body  marginheight="0" marginwidth="0">

	<!--<div style="background-color:#EBEAD8;width:auto;height:30px;padding:5px;">
		<span style="color:blue;font-weight:bold;font-size:20px;font-family:arial;">N. I. Biz Soft Inventory Management System V 3.5<span>
	</div> -->
	<div class="TopBar">
		
	</div>
	<div class="TopBox" style="padding:10px;background-color:#E7F5F8;">
	
	
		<a href="index.php?Theme=default&Base=SalaryPaySlip&Script=home" style="text-decoration:none">
			<span class="TopButton home_salary_menu" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/Salary_home.png" align="left" style="margin-right: 25px;">
				 Salary Module<br> Home Page
			</span>
		</a>





<a href="index.php?Theme=default&Base=SalaryPaySlip&Script=ProvidentFund" style="text-decoration:none">
			<span class="TopButton Two" style="text-align:center">
			    
				<img height="32" width="48px" src="./theme/default/images/pf.png" align="left" style="margin-right: 25px;">
				Provident Fund <br/> Section
			</span>
		</a>



		<a href="index.php?Theme=default&Base=SalaryPaySlip&Script=EmployeeTax" style="text-decoration:none">
			<span class="TopButton Two" style="text-align:center">
			    
				<img height="32" width="48px" src="./theme/default/images/tax.png" align="left" style="margin-right: 25px;">
				Employee Tax <br/>Section
			</span>
		</a>



		<a href="index.php?Theme=default&Base=SalaryPaySlip&Script=EmployeeGratuity" style="text-decoration:none">
			<span class="TopButton Two" style="text-align:center">
			    
				<img height="32" width="48px" src="./theme/default/images/gf.png" align="left" style="margin-right: 25px;">
				Employee Gratuity <br/>Section
			</span>
		</a>


		<br/><br/>		
		
		
		<a href="index.php?Theme=default&Base=SalaryPaySlip&Script=home&c=1" style="text-decoration:none">
			<span class="TopButton One" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/set_salary.png" align="left" style="margin-right: 25px;">
				Employee  Salary <br>Set
			</span>
		</a>

		
		<a href="index.php?Theme=default&Base=SalaryPaySlip&Script=home&rr=1" style="text-decoration:none">
			<span class="TopButton list" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/ppt.png" align="left" style="margin-right: 25px;">
				Employee Salary<br> Set List Report
			</span>
		</a>
		
		
			
		<a href="index.php?Theme=default&Base=SalaryPaySlip&Script=index" style="text-decoration:none">
			<span class="TopButton Two" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/salary_list.png" align="left" style="margin-right: 25px;">
				Employee Salary <br/> pay slip
			</span>
		</a>

		
	</div>	
	
';


$loaddata=$_REQUEST['c'];
if($loaddata==1){
  //echo "slalry set";
   $MainContent.='
	<style>
	.One {
		background: -moz-linear-gradient(center top , #FFFFFF 5%, #28CF24 100%) repeat scroll 0 0 #FFFFFF;
	}
	 .row {
			margin-left:0px;
			*zoom: 1;
	 }
	</style>
	'.$updateSetHTML.'
	
	<form action="index.php?Theme=default&Base=SalaryPaySlip&Script=SalarySetUpdate" method="post"> 
    <table  style="width: 80%;margin: 0 auto;background-color: #E7F5F8; margin-top:20px" id="slarytable">	
	   <tr style="text-align:center;"> 
	     <td colspan="3" style="font-size: 19px;padding: 15px;background-color: #48CE3B;color: #110101;">Employee Salary Set</td>
	   </tr>
	
	   <tr>   
	     	<td style="padding-left: 32px;padding-top: 6px;">
		  		<div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Employee Name</label>
				  <div class="col-xs-10">
					<select onchange="employeenameselect(this.value)" class="form-control UserID" name="UserID" required>
					     <option value="">Select Employee Name</option>
                        '.$OptionUserHTML.'
				    </select>
				  </div>
				</div>
		  </td>
	   
	   
	   
		   <td>
		        <div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Basic Salary </label>
				  <div class="col-xs-10">
					<input class="form-control" name="BasicSalary" type="text" value="" id="example-text-input" required>
				  </div>
				</div>
		   </td>
		   <td>
		        <div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Provident Fund</label>
				  <div class="col-xs-10">
				    <span id="PFundShow">
                       <input type="text" name="PFund" readonly />
                    </span>
                    <!-- 
					<input class="form-control" type="text" name="PFund" value="" id="example-text-input">
				    -->
				  </div>
				</div>
		   </td>    		  
	   </tr>	
	
	
	
	
	   <tr>   
	     	<td style="padding-left: 32px;padding-top: 6px;">
		  		<div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Branch Name</label>
				  <div class="col-xs-10">
                    <span id="BranchNameview">
                       <input type="text" name="BranchName" readonly />
                    </span> 
                    <!--
					<select class="form-control" name="BranchName" required>
					    <option value="">Select Branch Name</option>
					    '.$OptionBranchHTML.'
					</select>
                    -->
				  </div>
				</div>
		  </td>
	   
	   
	   
		   <td>
		        <div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Donation</label>
				  <div class="col-xs-10">
					<input class="form-control" name="Donation" type="text" value="" id="example-text-input">
				  </div>
				</div>
		   </td>
		   
		   <td>
		        <div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Tax</label>
				  <div class="col-xs-10">
				    <span id="TaxPage">
                        <input type="text" name="Tax" readonly />
				    </span>
				    <!--
					<input class="form-control"  name="Tax" type="text" value="" id="example-text-input">
				    -->
				  </div>
				</div>
		   </td>    		  
	   </tr>	
	
	
	
	   <tr>   
	     	<td style="padding-left: 32px;padding-top: 6px;">
		  		<div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Department Name</label>
				  <div class="col-xs-10">
				    <span id="DepartmentNameShow">
                       <input type="text" name="Department" readonly />
                    </span> 
                    <!--
					<select class="form-control" name="Department" required>
				      <option value="">Select Department Name</option>
					  '.$OptionDeptHTML.'
					</select>
					-->
				  </div>
				</div>
		  </td>
	   
	  
		   <td>
		        <div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">House Rent</label>
				  <div class="col-xs-10">
					<input class="form-control" type="text" name="HouseRent" value="" id="example-text-input">
				  </div>
				</div>
		   </td>
		   
		   <td>   <!-- blank --> </td>
		   
    		  
	   </tr>
	   
		
	
	   <tr>   
	     	<td style="padding-left: 32px;padding-top: 6px;">
		  		<div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Designation Name</label>
				  <div class="col-xs-10">
					<span id="DesignationNameShow">
                       <input type="text" name="Designation" readonly />
                    </span> 
                    <!--
					<select class="form-control" name="Designation" required>
			           <option value="">Select Designation Name</option>
					    '.$OptionDegiHTML.'
					</select>
					-->
				  </div>
				</div>
		  </td>
	   
	   
		   
		   <td>
		        <div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Travelling Allowance</label>
				  <div class="col-xs-10">
					<input class="form-control" name="TravellingAllow" type="text" value="" id="example-text-input">
				  </div>
				</div>
		   </td> 
		    <td> <!-- blank --> </td>
    		  
	   </tr>
	   		
	
	   <tr>   
	     	<td style="padding-left: 32px;padding-top: 6px;">
		  		<div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Job Status</label>
				  <div class="col-xs-10">
				    <span id="JobStatusShow">
                       <input type="text" name="JobStatus" readonly />
                    </span> 
                    <!--
					<select class="form-control" name="JobStatus" required>
					    <option value="">Select Job Status</option>
					    <option>Reguler/Permanent</option>
						<option>Contractual</option>
					    <option>Part Time</option>
					    <option>Probationer</option>
					    <option>Service Staff</option>
					</select>
					-->
				  </div>
				</div>
		  </td>
	   
	   
		    <td>
		        <div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Medical Allowance</label>
				  <div class="col-xs-10">
					<input class="form-control" name="MedicalAllow" type="text" value="" id="example-text-input">
				  </div>
				</div>
		   </td>
		   
            <td> <!-- blank -->  </td> 
		   
	   </tr>
	   
	   
	   
	   
	   <tr>
	      <td> <!-- blank --> </td>
		   <td>
		        <div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Food Allowance</label>
				  <div class="col-xs-10">
					<input class="form-control" type="text" name="Food" value="" id="example-text-input">
				  </div>
				</div>
		   </td> 
		  <td> <!-- blank --> </td>
	   </tr>
	   
	   
	   
	   	<tr>
	      <td> <!-- blank --> </td>
		   <td>
		        <div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Mobile Allowance</label>
				  <div class="col-xs-10">
					<input class="form-control" type="text" name="Mobile" value="" id="example-text-input">
				  </div>
				</div>
		   </td>
		  <td> <!-- blank --> </td>
	   </tr>
	   
	   
	   
	   <tr style="text-align:center;"> 
	     <td colspan="3" style="font-size: 19px;padding: 1px;background-color: #48CE3B;color: white;">
		       <div class="form-group row">
				  <div class="offset-sm-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Save Salary</button>
				  </div>
				</div>
		 </td>
	   </tr>
		
  </table>
  </form>	
   ';
}elseif($loaddata==2){
  //echo "pay slip";
   $MainContent.='
	<style>
	.Two {
		background: -moz-linear-gradient(center top , #FFFFFF 5%, #28CF24 100%) repeat scroll 0 0 #FFFFFF;
	}
	</style>	
	';
}else{
  /*salry home page setting*/	
  $MainContent.='
     <style>
			.salary_home {
				width: 32%;
				margin: 0 auto;
			}
			.home_salary_menu {
				background: -moz-linear-gradient(center top , #FFFFFF 5%, #28CF24 100%) repeat scroll 0 0 #FFFFFF;
			}
	 </style>
     <div class="salary_home">
	     <h3>Welcome To Salary Module</h3>
		 <p>Set Employee Salary And Genarate Employee Monthly Salary here</p>
		 <img height="32" src="./theme/default/images/home.png" align="left" style="margin-right: 25px;">
	 </div>
  ';	
}




/* this section only report salry start*/
$CsSalary=mysql_query("select * from tbluser where UserIsActive=1 and UserID>2");
while($RowCsSalary=mysql_fetch_assoc($CsSalary)){
	
	$UserID=$RowCsSalary['UserID'];
	
	
	$BasicSalary=$RowCsSalary['BasicSalary'];
	$HouseRent=$RowCsSalary['HouseRent'];
	$TravellingAllow=$RowCsSalary['TravellingAllow'];
	$MedicalAllow=$RowCsSalary['MedicalAllow'];
	$Food=$RowCsSalary['Food'];
	$Mobile=$RowCsSalary['Mobile'];
	$Earning=$BasicSalary+$HouseRent+$TravellingAllow+$MedicalAllow+$Food+$Mobile;
    
	$Donation=$RowCsSalary['Donation'];

	$PFund=$RowCsSalary['PFund'];
    $PF=($BasicSalary*$PFund)/100;
		
    $Tax=$RowCsSalary['Tax'];
	$STAX=($BasicSalary*$Tax)/100;
	
	$Deduction=$Donation+$PF+$STAX;
	
	$TotalSalary=$Earning-$Deduction;


	
$slalryreportHTML.='
<tr>
  <th>'.$RowCsSalary['FullName'].'</th>
  <th>'.$RowCsSalary['BranchName'].'</th>
  <th>'.$RowCsSalary['Designation'].'</th>
  <th>'.$RowCsSalary['JobStatus'].'</th>
  <th>'.$Earning.'</th>
  <th>'.$Deduction.'</th>
  <th>'.$TotalSalary.'</th>
  <th><a href="index.php?Theme=default&Base=SalaryPaySlip&Script=home&RUUserID='.$UserID.'&ru=1">View</a></th>
</tr>
';
}

$UpdateEmployeeSalary=$_REQUEST['rr'];
if($UpdateEmployeeSalary==1){
$MainContent.='
   <style>
    .list {
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #28CF24 100%) repeat scroll 0 0 #FFFFFF;
     }
	 .salary_home{
		 display:none
	 }
	 .home_salary_menu{ background:none}
   </style>
  <div class="row-fluid">
     <div class="span12">
         <!-- block -->	
         <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left">Today <span style="color:green">'.$TDate.'</span> Attendance Report</div>
                <div class="pull-right"><span class="badge badge-info"><a style="color: white;font-size: 16px;" href="index.php?Theme=default&Base=Attendance&Script=index">Back To Page</a></span>
          </div>
         </div>
      <div class="block-content collapse in">
								
        <table class="table table-striped table-bordered" id="example1">
            <thead>
              <tr style="background-color: #119e11;color: white;">
		         <th>Empolye Name</th>
		         <th>Branch</th>
		         <th>Designation</th>
		         <th>Job Status</th>
                 <th>Earning Salery</th>
                 <th>Deduction Salery</th>
				 <th>Total Salary</th>                                              
                 <th>View</th>
               </tr>
            </thead>
            <tbody>
               '.$slalryreportHTML.'
            </tbody>
         </table>
       </div>
     </div>
  <!-- /block -->
  </div>
  </div>
  ';
}else{
	
}
/* this section only report salry end*/


/* this section only report salary update page start*/

$RowSalaryUp=$_REQUEST['ru'];
if($RowSalaryUp==1){
$MainContent.='
<style>
.salary_home{display:none}
.home_salary_menu{ background:none}
</style>
';
$UserReport =  SQL_Select("user","UserIsActive=1 and UserID>2");
foreach($UserReport as $ThisUserReport){
$RowOptionUserHTML.='
		<option value="'.$ThisUserReport['UserID'].'">'.$ThisUserReport['FullName'].'</option>	 
';
}	

$RUUserID=$_REQUEST['RUUserID'];
$RowSupdate=mysql_query("select * from tbluser where UserID=$RUUserID");
$ThisRowSupdate=mysql_fetch_assoc($RowSupdate);
	
$MainContent.='
	<style>
	.One {
		background: -moz-linear-gradient(center top , #FFFFFF 5%, #28CF24 100%) repeat scroll 0 0 #FFFFFF;
	}
	 .row {
			margin-left:0px;
			*zoom: 1;
	 }
	</style>
	<form action="index.php?Theme=default&Base=SalaryPaySlip&Script=SalarySetUpdate" method="post"> 
    <table  style="width: 80%;margin: 0 auto;background-color: #E7F5F8; margin-top:20px" id="slarytable">	
	   <tr style="text-align:center;"> 
	     <td colspan="3" style="font-size: 19px;padding: 15px;background-color: #B4D9EC;color: #fff;">Update Employee Salary Set</td>
	   </tr>
	
	   <tr>   
	     	<td style="padding-left: 32px;padding-top: 6px;">
		  		<div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Employee Name</label>
				  <div class="col-xs-10">
					<select class="form-control UserID" name="UserID" required>
					     <option value="'.$ThisRowSupdate['UserID'].'">'.$ThisRowSupdate['FullName'].'</option>
                        '.$RowOptionUserHTML.'
				    </select>
				  </div>
				</div>
		  </td>
	   
	   
	   
		   <td>
		        <div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Basic Salary </label>
				  <div class="col-xs-10">
					<input class="form-control" name="BasicSalary" type="text" value="'.$ThisRowSupdate['BasicSalary'].'" id="example-text-input" required>
				  </div>
				</div>
		   </td>
		   <td>
		        <div class="form-group row">				  <label for="example-text-input" class="col-xs-2 col-form-label">Provident Fund</label>				  <div class="col-xs-10">					<input class="form-control" type="text" name="PFund" value="'.$ThisRowSupdate['PFund'].'" id="example-text-input">				  </div>				</div>
		   </td>     		  
	   </tr>	
	
	
	
	
	   <tr>   
	     	<td style="padding-left: 32px;padding-top: 6px;">
		  		<div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Branch Name</label>
				  <div class="col-xs-10">
					<select class="form-control" name="BranchName" required>
					    <option value="'.$ThisRowSupdate['BranchName'].'">'.$ThisRowSupdate['BranchName'].'</option>
					    '.$OptionBranchHTML.'
					</select>
				  </div>
				</div>
		  </td>
	   
	   
	   
		   <td>
		        <div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Donation</label>
				  <div class="col-xs-10">
					<input class="form-control" name="Donation" type="text" value="'.$ThisRowSupdate['Donation'].'" id="example-text-input">
				  </div>
				</div>
		   </td>
		   <td>
		        <div class="form-group row">				  <label for="example-text-input" class="col-xs-2 col-form-label">Tax</label>				  <div class="col-xs-10">					<input class="form-control"  name="Tax" type="text" value="'.$ThisRowSupdate['Tax'].'" id="example-text-input">				  </div>				</div>
		   </td>     		  
	   </tr>	
	
	
	
	   <tr>   
	     	<td style="padding-left: 32px;padding-top: 6px;">
		  		<div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Department Name</label>
				  <div class="col-xs-10">
					<select class="form-control" name="Department" required>
				      <option value="'.$ThisRowSupdate['Department'].'">'.$ThisRowSupdate['Department'].'</option>
					  '.$OptionDeptHTML.'
					</select>
				  </div>
				</div>
		  </td>
	   
	   
	   
		   <td>
					<div class="form-group row">				  <label for="example-text-input" class="col-xs-2 col-form-label">House Rent</label>				  <div class="col-xs-10">					<input class="form-control" type="text" name="HouseRent" value="'.$ThisRowSupdate['HouseRent'].'" id="example-text-input">				  </div>				</div>
		   </td>
		   <td>
		   </td>     		  
	   </tr>
	   
		
	
	   <tr>   
	     	<td style="padding-left: 32px;padding-top: 6px;">
		  		<div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Designation Name</label>
				  <div class="col-xs-10">
					<select class="form-control" name="Designation" required>
			           <option value="'.$ThisRowSupdate['Designation'].'">'.$ThisRowSupdate['Designation'].'</option>
					    '.$OptionDegiHTML.'
					</select>
				  </div>
				</div>
		  </td>
	   
	   
	   
		   <td>		   		<div class="form-group row">				  <label for="example-text-input" class="col-xs-2 col-form-label">Travelling Allowance</label>				  <div class="col-xs-10">					<input class="form-control" name="TravellingAllow" type="text" value="'.$ThisRowSupdate['TravellingAllow'].'" id="example-text-input">				  </div>				</div>
		   </td>
		   <td>
		   </td>     		  
	   </tr>
	   		
	
	   <tr>   
	     	<td style="padding-left: 32px;padding-top: 6px;">
		  		<div class="form-group row">
				  <label for="example-text-input" class="col-xs-2 col-form-label">Job Status</label>
				  <div class="col-xs-10">
					<select class="form-control" name="JobStatus" required>
					    <option value="'.$ThisRowSupdate['JobStatus'].'">'.$ThisRowSupdate['JobStatus'].'</option>
					    <option>Reguler/Permanent</option>
						<option>Contractual</option>
					    <option>Part Time</option>
					    <option>Probationer</option>
					    <option>Service Staff</option>
					</select>
				  </div>
				</div>
		  </td>
	   
	   
	   
		   <td>
		        <div class="form-group row">				  <label for="example-text-input" class="col-xs-2 col-form-label">Medical Allowance</label>				  <div class="col-xs-10">					<input class="form-control" name="MedicalAllow" type="text" value="'.$ThisRowSupdate['MedicalAllow'].'" id="example-text-input">				  </div>				</div>
		   </td>
		   
		   <td>
		   </td>     		  
	   </tr>	   	   	   	   <tr>	      <td></td>	      <td>		        <div class="form-group row">				  <label for="example-text-input" class="col-xs-2 col-form-label">Mobile Allowance</label>				  <div class="col-xs-10">					<input class="form-control" type="text" name="Mobile" value="'.$ThisRowSupdate['Mobile'].'" id="example-text-input">				  </div>				</div>		  </td>	      <td></td>	   </tr>	   	   	   <tr>	      <td></td>	      <td>		        <div class="form-group row">				  <label for="example-text-input" class="col-xs-2 col-form-label">Food Allowance</label>				  <div class="col-xs-10">					<input class="form-control" type="text" name="Food" value="'.$ThisRowSupdate['Food'].'" id="example-text-input">				  </div>				</div>		  </td>	      <td></td>	   </tr>
	   
	   <tr style="text-align:center;"> 
	     <td colspan="3" style="font-size: 19px;padding: 1px;background-color: #ABD6E9;color: white;">
		       <div class="form-group row">
				  <div class="offset-sm-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Update Salary</button>
				  </div>
				</div>
		 </td>
	   </tr>
		
  </table>
  </form>	

';
}else{
	//echo 
}

/* this section only report salary update page end*/

$MainContent.='
</body>
';



 ?>