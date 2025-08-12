<?php

$MainContent.='
<style>
.ui-datepicker .ui-datepicker-buttonpane button.ui-datepicker-current {
	float: left;
	background-color: green;
	color: white;
}
.row {
	margin-left:0px;
	*zoom: 1;
}
</style>



<body  marginheight="0" marginwidth="0">

	<div class="TopBar">	
	</div>
	
	<div class="TopBox" style="padding:10px;background-color:#E7F5F8;">
		
		<a href="index.php?Theme=default&Base=Attendance&Script=home" style="text-decoration:none">
			<span class="TopButton att_home" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/att_home.png" align="left" style="margin-right: 25px;">
				 Attendance Module<br> Home Page
			</span>
		</a>
		
		
		<a href="index.php?Theme=default&Base=Attendance&Script=home&at=2" style="text-decoration:none">
			<span class="TopButton home_two" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/patt.png" align="left" style="margin-right: 25px;">
				 Employee Attendance<br>Primary Insert
			</span>
		</a>
			
			
		<a href="index.php?Theme=default&Base=Attendance&Script=home&rr=1&at=1" style="text-decoration:none">
			<span class="TopButton home_one" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/alist.png" align="left" style="margin-right: 25px;">
				 Employee Attendance<br>Primary List
			</span>
		</a>
		

		<a href="index.php?Theme=default&Base=Attendance&Script=index" style="text-decoration:none">
			<span class="TopButton home_three" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/dailyatt.png" align="left" style="margin-right: 25px;">
				  Attendance<br>Dilay Insert
			</span>
		</a>
			
	 </div>	
	 
';	 
	 
	 
$UserReport =  SQL_Select("user","UserIsActive=1 and UserID>2 and !FridayInHour>0");
foreach($UserReport as $ThisUserReport){
$RowOptionUserHTML.='
		<option value="'.$ThisUserReport['UserID'].'">'.$ThisUserReport['FullName'].'</option>	 
';
}

if(!$UserReport){
	$MainContent.='
	  <style>
	    .insert{display:none}
	  </style>
	  
	    <style>
		  #slarytable{display:none}
	    </style>
		 
		 <table style="width: 53%;margin: 0 auto;background-color: whitesmoke;margin-top: 25px;" class="full_fill">
		   <tr>
		      <td style="line-height: 30px;padding: 50px;">
			     <span style="font-size: 22px;color: red;">No! New Attendance Primary Insert</span> <br/>
			     <span>Already All Employee Attendance Set Succesfully</span><br/>
				 <span>when new employee add then Enable Attendance Set Option</span> <br/>
				 <span style="font-size: 18px;color: green;">All Old Employee Attendance Set list View <a href="index.php?Theme=default&Base=Attendance&Script=home&rr=1&at=1">Click Here</span></a>
			  </td>
		   </tr>
		 </table>
	';
}


$RowAttUserReport =  SQL_Select("user","UserIsActive=1");


$MainContent.='
<div class="row-fluid insert">
  <!-- block -->
  <div class="block">
  <div class="navbar navbar-inner block-header">
     <div class="muted pull-left">Attendance Table History</div>
  </div>
  <div class="block-content collapse in">
    <div class="span12">
	
	   <form action="index.php?Theme=default&Base=Attendance&Script=insertUpdateAttendance" method="post" >
       <table class="table table-bordered">
		 <thead>
			<tr>
				<th colspan="4">
				Employee Name  <br/>
				<select class="UserID" name="UserID">
				  '.$RowOptionUserHTML.'
				</select>
				</th>
			</tr>	

			<tr>
				<th>Day</th>
				<th>In Time</th>
				<th>Out Time</th>
				<th>Holiday</th>
			</tr>
		 </thead>
         <tbody>
		 
		 
			<tr>
				<td>Friday</td>
				<td><input id="timepickerfrin" name="FridayInTime" type="text" class="form-control input-small" required></td>
				<td><input id="timepickerfrout" name="FridayOutTime" type="text" class="form-control input-small" required></td>
				<td>
				   <select name="FridayStatus" required>
				      <option value="">Select Holiday Satus</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>
			
		 
			<tr>
				<td>Saturday</td>
				<td><input id="SaturdayInTime" name="SaturdayInTime" required type="text" class="form-control input-small"></td>
				<td><input id="SaturdayOutTime" name="SaturdayOutTime" required type="text" class="form-control input-small"></td>
				<td>
				   <select name="SaturdayStatus" required>
				      <option value="">Select Holiday Satus</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>


			
			<tr>
				<td>Sunday</td>
				<td><input id="SundayInTime" name="SundayInTime" required type="text" class="form-control input-small"></td>
				<td><input id="SundayOutTime" name="SundayOutTime" required type="text" class="form-control input-small"></td>
				<td>
				   <select name="SundayStatus" required>
				      <option value="">Select Holiday Satus</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>


			
			<tr>
				<td>Monday</td>
				<td><input id="MondayInTime" name="MondayInTime" required type="text" class="form-control input-small"></td>
				<td><input id="MondayOutTime" name="MondayOutTime" required type="text" class="form-control input-small"></td>
				<td>
				   <select name="MondayStatus" required>
				      <option value="">Select Holiday Satus</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>


			
			<tr>
				<td>Thursday</td>
				<td><input id="ThursdayInTime" name="ThursdayInTime" required type="text" class="form-control input-small"></td>
				<td><input id="ThursdayOutTime" name="ThursdayOutTime" required type="text" class="form-control input-small"></td>
				<td>
				   <select name="ThursdayStatus" required>
				      <option value="">Select Holiday Satus</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>
			
			
			<tr>
				<td>Wednesday</td>
				<td><input id="WednesdayInTime" name="WednesdayInTime" required type="text" class="form-control input-small"></td>
				<td><input id="WednesdayOutTime" name="WednesdayOutTime" required type="text" class="form-control input-small"></td>
				<td>
				   <select name="WednesdayStatus" required>
				      <option value="">Select Holiday Satus</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>

			
			<tr>
				<td>Tuesday</td>
				<td><input id="TuesdayInTime" name="TuesdayInTime" required type="text" class="form-control input-small"></td>
				<td><input id="TuesdayOutTime" name="TuesdayOutTime" required type="text" class="form-control input-small"></td>
				<td>
				   <select name="TuesdayStatus" required>
				      <option value="">Select Holiday Satus</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>
			
			<tr>
			  <td colspan="4" style="text-align:right">
			     <div class="form-group row">
				  <div class="offset-sm-4 col-sm-8">
					<button type="submit" class="btn btn-primary">Save Parimay Attendance</button>
				  </div>
				</div>
			  </td>
			</tr>
			
		  </tbody>
	    </table>
		</form>
		
		
     </div>
   </div>
  </div>
<!-- /block -->
</div>
';

$UserAttReport =  SQL_Select("user","UserIsActive=1 and UserID>2");
foreach($UserAttReport as $ThisUserAttReport){
   $UserID=$ThisUserAttReport['UserID'];
   
   $TT=mysql_query("select * from tbluser where UserID=$UserID"); 
   $RowTT=mysql_fetch_assoc($TT);

   $TuesdayStatus=$RowTT['TuesdayStatus'];
   if($TuesdayStatus=='Yes'){
	   $TuOff='<span style="color:red">T</span>ue ';
   }
   
   $WednesdayStatus=$RowTT['WednesdayStatus'];
   if($WednesdayStatus=='Yes'){
	   $WOff='<span style="color:red">W</span>ed ';
   } 

   
   $ThursdayStatus=$RowTT['ThursdayStatus'];
   if($ThursdayStatus=='Yes'){
	   $ThuOff='<span style="color:red">T</span>hu ';
   }else{
	  $ThuOff=''; 
   } 

   
   $MondayStatus=$RowTT['MondayStatus'];
   if($MondayStatus=='Yes'){
	   $MonOff='<span style="color:red">M</span>on ';
   }
   
   
   
   
   $SundayStatus=$RowTT['SundayStatus'];
   if($SundayStatus=='Yes'){
	   $SunOff='<span style="color:red">S</span>un ';
   }else{
	   $SunOff='';
   }
   
   $SaturdayStatus=$RowTT['SaturdayStatus'];
   if($SaturdayStatus=='Yes'){
	   $SatOff='<span style="color:red">S</span>at ';
   }else{
	   $SatOff='';
   }
   
   $FridayStatus=$RowTT['FridayStatus'];
   if($FridayStatus=='Yes'){
	   $FriOff='<span style="color:red">F</span>ri ';
   }else{
	   $FriOff='';
   }
   
$AttreportHTML.='
   <tr>
      <th>'.$ThisUserAttReport['FullName'].'</th>
      <th>'.$ThisUserAttReport['BranchName'].'</th>
      <th>'.$ThisUserAttReport['Designation'].'</th>
      <th>'.$ThisUserAttReport['JobStatus'].'</th>
      <th>'.$TuOff.' '.$WOff.' '.$ThuOff.' '.$MonOff.' '.$SunOff.''.$SatOff.''.$FriOff.'</th>
      <th><a href="index.php?Theme=default&Base=Attendance&Script=home&UpUserID='.$UserID.'&rrup=1">Edit</a></th>
   </tr>
';
}

$AttList=$_REQUEST['rr'];
if($AttList==1){
$MainContent.='<style>.insert{display:none}</style>

   <style>
    .list {
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #28CF24 100%) repeat scroll 0 0 #FFFFFF;
		 }
	.home_one{
		background: -moz-linear-gradient(center top , #FFFFFF 5%, #42CC34 100%) repeat scroll 0 0 #FFFFFF;
	}
	.aa{
		background:none;
	}
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
                 <th>Off Day List </th>
                 <th>Edit</th>
               </tr>
            </thead>
            <tbody>
               '.$AttreportHTML.'
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


$rrup=$_REQUEST['rrup']; 
if($rrup==1){
$UpUserID=$_REQUEST['UpUserID'];
$UpAtt=mysql_query("select * from tbluser where UserID=$UpUserID"); 
$RowUpAtt=mysql_fetch_assoc($UpAtt);


$MainContent.='
<style>
.insert{display:none;}
</style>

<div class="row-fluid">
  <!-- block -->
  <div class="block">
  <div class="navbar navbar-inner block-header">
     <div class="muted pull-left">
	  <span style="color:blue; font-size:16px">Update Page </span>
	 <span style="color:green">'.$RowUpAtt['FullName'].'</span> Attendance Table History</div>
  </div>
  <div class="block-content collapse in">
    <div class="span12">
	
	   <form action="index.php?Theme=default&Base=Attendance&Script=insertUpdateAttendance" method="post" >
       <table class="table table-bordered">
		 <thead>
			<tr>
				<th colspan="4">
				Employee Name  <br/>
				<select class="UserID" name="UserID">
				  <option value="'.$RowUpAtt['UserID'].'">'.$RowUpAtt['FullName'].'</option>
				  '.$RowOptionUserHTML.'
				</select>
				</th>
			</tr>	

			<tr>
				<th>Day</th>
				<th>In Time</th>
				<th>Out Time</th>
				<th>Holiday</th>
			</tr>
		 </thead>
         <tbody>
		 
		 
			<tr>
				<td>Friday</td>
				<td><input id="timepickerfrin" value="'.$RowUpAtt['FridayInTime'].'" name="FridayInTime" type="text" class="form-control input-small" required></td>
				<td><input id="timepickerfrout" value="'.$RowUpAtt['FridayOutTime'].'" name="FridayOutTime" type="text" class="form-control input-small" required></td>
				<td>
				   <select name="FridayStatus" required>
				      <option value="'.$RowUpAtt['FridayStatus'].'">'.$RowUpAtt['FridayStatus'].'</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>
			
		 
			<tr>
				<td>Saturday</td>
				<td><input value="'.$RowUpAtt['SaturdayInTime'].'" id="SaturdayInTime" name="SaturdayInTime" required type="text" class="form-control input-small"></td>
				<td><input value="'.$RowUpAtt['SaturdayOutTime'].'" id="SaturdayOutTime" name="SaturdayOutTime" required type="text" class="form-control input-small"></td>
				<td>
				   <select name="SaturdayStatus" required>
				      <option value="'.$RowUpAtt['SaturdayStatus'].'">'.$RowUpAtt['SaturdayStatus'].'</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>


			
			<tr>
				<td>Sunday</td>
				<td><input value="'.$RowUpAtt['SundayInTime'].'" id="SundayInTime" name="SundayInTime" required type="text" class="form-control input-small"></td>
				<td><input value="'.$RowUpAtt['SundayOutTime'].'" id="SundayOutTime" name="SundayOutTime" required type="text" class="form-control input-small"></td>
				<td>
				   <select name="SundayStatus" required>
				      <option value="'.$RowUpAtt['SundayStatus'].'">'.$RowUpAtt['SundayStatus'].'</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>


			
			<tr>
				<td>Monday</td>
				<td><input value="'.$RowUpAtt['MondayInTime'].'" id="MondayInTime" name="MondayInTime" required type="text" class="form-control input-small"></td>
				<td><input value="'.$RowUpAtt['MondayOutTime'].'" id="MondayOutTime" name="MondayOutTime" required type="text" class="form-control input-small"></td>
				<td>
				   <select name="MondayStatus" required>
				      <option value="'.$RowUpAtt['MondayStatus'].'">'.$RowUpAtt['MondayStatus'].'</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>


			
			<tr>
				<td>Thursday</td>
				<td><input value="'.$RowUpAtt['ThursdayInTime'].'" id="ThursdayInTime" name="ThursdayInTime" required type="text" class="form-control input-small"></td>
				<td><input value="'.$RowUpAtt['ThursdayOutTime'].'" id="ThursdayOutTime" name="ThursdayOutTime" required type="text" class="form-control input-small"></td>
				<td>
				   <select name="ThursdayStatus" required>
				      <option value="'.$RowUpAtt['ThursdayStatus'].'">'.$RowUpAtt['ThursdayStatus'].'</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>
			
			
			<tr>
				<td>Wednesday</td>
				<td><input value="'.$RowUpAtt['WednesdayInTime'].'" id="WednesdayInTime" name="WednesdayInTime" required type="text" class="form-control input-small"></td>
				<td><input value="'.$RowUpAtt['WednesdayOutTime'].'" id="WednesdayOutTime" name="WednesdayOutTime" required type="text" class="form-control input-small"></td>
				<td>
				   <select name="WednesdayStatus" required>
				      <option value="'.$RowUpAtt['WednesdayStatus'].'">'.$RowUpAtt['WednesdayStatus'].'</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>

			
			<tr>
				<td>Tuesday</td>
				<td><input value="'.$RowUpAtt['TuesdayInTime'].'" id="TuesdayInTime" name="TuesdayInTime" required type="text" class="form-control input-small"></td>
				<td><input value="'.$RowUpAtt['TuesdayOutTime'].'" id="TuesdayOutTime" name="TuesdayOutTime" required type="text" class="form-control input-small"></td>
				<td>
				   <select name="TuesdayStatus" required>
				      <option value="'.$RowUpAtt['TuesdayStatus'].'">'.$RowUpAtt['TuesdayStatus'].'</option>
				      <option value="Yes">Holiday Yes</option>
				      <option value="No">Holiday No</option>
				   </select>
				</td>
			</tr>
			
			<tr>
			  <td colspan="4" style="text-align:right">
			     <div class="form-group row">
				  <div class="offset-sm-4 col-sm-8">
					<button type="submit" class="btn btn-primary">Update Parimay Attendance</button>
				  </div>
				</div>
			  </td>
			</tr>
			
		  </tbody>
	    </table>
		</form>
		
		
     </div>
   </div>
  </div>
<!-- /block -->
</div>
';	
}else{
	//echo 
}


$at=$_REQUEST['at'];

if($at==''){
$MainContent.='
<style>
.insert,.full_fill{display:none;}
.att_home{
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #42CC34 100%) repeat scroll 0 0 #FFFFFF;
}
.span12{
	width: 63%;
	float: right;
}

</style>
';
	
include("ReportAttendance.php");

  /*salry home page setting*/	
  $MainContent.='
     <style>
.salary_home {
	width: 44%;
	margin: 0 auto;
	float: right;
	margin-top: -100px;
}
			.home_salary_menu {
				background: -moz-linear-gradient(center top , #FFFFFF 5%, #28CF24 100%) repeat scroll 0 0 #FFFFFF;
			}
	 </style>
     <div class="salary_home">
	     <h3>Welcome To Attendance Module</h3>
		 <p>Set Employee Attendance And Genarate Employee Dilay Attendance Insert here</p>
		 <img height="32" src="./theme/default/images/attendanceonline1.png" align="left" style="margin-right: 25px;">
	 </div>
  ';	

	
}


if($at==2){
$MainContent.='
<style>
.home_two{
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #42CC34 100%) repeat scroll 0 0 #FFFFFF;
}
</style>
';	
}

if($at==3){
$MainContent.='
<style>
.home_three{
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #42CC34 100%) repeat scroll 0 0 #FFFFFF;
}
</style>
';	
}





if($at==1){
$MainContent.='
<style>
.home_one{
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #42CC34 100%) repeat scroll 0 0 #FFFFFF;
}
.full_fill{display:none}
</style>
';
}

$rrup=$_REQUEST['rrup'];
if($rrup==1){
$MainContent.='
<style>
.home_one{
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #42CC34 100%) repeat scroll 0 0 #FFFFFF;
}
.att_home{
	background:none;
}
.salary_home{
	display: none;
}
</style>
';	
}

$rrrr=$_REQUEST['rr'];
if($rrrr==1){
$MainContent.='
<style>
.home_one{
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #42CC34 100%) repeat scroll 0 0 #FFFFFF;
}
.att_home{
	background:none;
}
.salary_home{
	display: none;
}
</style>
';	
}


	 
$MainContent.='	 

<script type="text/javascript">
   $("#timepicker1").timepicker({dateFormat: "yy-mm-dd"});
   $("#timepickerfrin").timepicker({dateFormat: "yy-mm-dd"});
   $("#timepickerfrout").timepicker({dateFormat: "yy-mm-dd"});
   $("#SaturdayInTime").timepicker({dateFormat: "yy-mm-dd"});
   $("#SaturdayOutTime").timepicker({dateFormat: "yy-mm-dd"});
   $("#SundayInTime").timepicker({dateFormat: "yy-mm-dd"});
   $("#SundayOutTime").timepicker({dateFormat: "yy-mm-dd"});
   $("#MondayInTime").timepicker({dateFormat: "yy-mm-dd"});
   $("#MondayOutTime").timepicker({dateFormat: "yy-mm-dd"});
   $("#ThursdayInTime").timepicker({dateFormat: "yy-mm-dd"});
   $("#ThursdayOutTime").timepicker({dateFormat: "yy-mm-dd"});
   $("#WednesdayInTime").timepicker({dateFormat: "yy-mm-dd"});
   $("#WednesdayOutTime").timepicker({dateFormat: "yy-mm-dd"});
   $("#TuesdayInTime").timepicker({dateFormat: "yy-mm-dd"});
   $("#TuesdayOutTime").timepicker({dateFormat: "yy-mm-dd"});
</script>
</body>	 
';