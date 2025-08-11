<?php
$MainContent.='
<style>
.attendance {
	background-color: #F5F5F5;
	width: 91%;
}
.attendance p {
	font-size: 17px;
	padding-left: 7px;
	padding-top: 14px;
	margin: 0px;
}
.att_btn {
	width: 24%;
	border-right: 1px solid black;
	margin-bottom: 0px;
	margin-left: 51px;
	margin-top: 25px;
}
.right_att {
	float: right;
	width: 68%;
	border-left: 1px solid black;
	padding-left: 41px;
}
.att_btn p {
	margin: 0px;
	font-size: 18px;
	padding: 23px 0px;
	border-bottom: 1px solid black;
	width: 74%;
	padding-bottom: 9px;
	margin-bottom: 33px;
}
.att_today {
	margin-bottom: 50px;
	margin-top: 35px;
}
.att_today a {
	background-color: brown;
	color: white;
	padding: 4px 5px;
	font-size: 21px;
	text-decoration: none;
}
.att_sub{}
.set_title{}
.att_btnpage {
	background-color: #444459;
	color: white;
	border: 1px solid #444459;
	padding: 2px 3px;
	font-size: 17px;
}
.all_view {
	margin-bottom: 54px;
}
.all_view a {
	background-color: #483b3b;
	color: white;
	padding: 4px 5px;
	font-size: 21px;
	text-decoration: none;
}

#select_box{}
#new_select {
	margin-top: -125px;
}
</style>
';



 
$UserReport =  SQL_Select("user","UserIsActive=1 and UserID>1  order by UserID DESC");
foreach($UserReport as $ThisUserReport){
	$nameHtml.='
	   <option value="'.$ThisUserReport["UserID"].'">'.$ThisUserReport["FullName"].'</option>
	';
	
}

$mytime=date('Y-m');
$UserReportSalary =  SQL_Select("salary","MonthYear='$mytime' order by SalaryID DESC");
foreach($UserReportSalary as $ThisUserReportSalary){
	
	$uid=$ThisUserReportSalary['UserID'];
	$mn=$ThisUserReportSalary['MonthName'];
	$yn=$ThisUserReportSalary['YearName'];
	$SalaryID=$ThisUserReportSalary['SalaryID'];
	
	$timereportHTML.='
	   <tr>
		  <th>'.$ThisUserReportSalary['UserID'].'</th>
		  <th>'.$ThisUserReportSalary['BasicSalary'].'</th>
		  <th>'.$ThisUserReportSalary['MonthName'].'</th>
		  <th><a href="index.php?Theme=default&Base=SalaryPaySlip&Script=SalaryHistory&UserId='.$uid.'&MI='.$mn.'&YI='.$yn.'">View Details</a></th>
		  <th><a href="index.php?Theme=default&Base=SalaryPaySlip&Script=update&SalaryID='.$SalaryID.'">Modify</a></th>
		  <th><a href="index.php?Theme=default&Base=Attendance&Script=report&id='.$ThisAttendanceReport['AttendanceID'].'">Delete</a></th>
     </tr>
';
}
	
	
	
$MainContent.='
<div class="container">
  <div class="attendance">
     <p>Mange Pay Slip<p>
  </div>
  <h4 style="text-align: center;color: #000;font-size: 17px;background-color:;width: 44%;margin: 0 auto;margin-top: 19px;padding: 9px;font-weight: 500;">'.$_GET['MS'].'</h4>
  
  <div class="att_btn">
     <p>Employee Salary Pay Slip</p>
	 
	 
	 
	 <table>
	   <tr>
	     <td>
		   <span class="set_title">Employee Name</span> <br/>
			 <center>
			<div id="select_box">
			 <select class="UserID" onchange="fetch_select(this.value);">
			  <option>Select Employee Name</option>
				  '.$nameHtml.'
			 </select>
               
			  <!-- 
			   <script type="text/javascript">
				$(function() {
					$(".date-picker").datepicker( {
						changeMonth: true,
						changeYear: true,
						showButtonPanel: true,
						dateFormat: "yy-m",
						onClose: function(dateText, inst) { 
							$(this).datepicker("setDate", new Date(inst.selectedYear, inst.selectedMonth, 1));
						}
					});
				});
				</script>
		    <br/>
			<span class="set_title">Select Your Month And Name</span><br/>	
			<input name="startDate" id="startDate" class="date-picker" onchange="fetch_select_sub(this.value);" />
			-->
			</div> 
			</center>	
             <!--
             <div id="att_summary" style="position: absolute;left: 314px;top: 350px;width: 16%;">
			   <span id="month"></span>-<span id="year"></span> 
			 </div>	
             -->
			 
		 </td>

	 
		</tr>
	   
	 </table>
   
  </div>
  
  
 
  <div class="right_att">
   <div id="new_select">
                       <div class="row-fluid">
                        <div class="span10">
                            <!-- block -->					
                           <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">This Mont Employee Salary Report</div>
                                    <div class="pull-right"><span class="badge badge-info"><a style="color: white;font-size: 16px;" href="index.php?Theme=default&Base=SalaryPaySlip&Script=home">Back To Page</a></span>

                                    </div>
                                </div>
                                <div class="block-content collapse in">
								
                                    <table class="table table-striped table-bordered" id="example1">
                                        <thead>
                                            <tr>
												<th>Empolye Name</th>
                                                <th>Basic Salery</th>                                              
                                                <th>Month</th>
                                                <th>View Details</th>
                                                <th>Modify</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											'.$timereportHTML.'
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /block -->
                        </div>
						</div>
   </div> 
  </div>
  
  
  
</div>
                      
';






