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
	float: left;
	width: 44%;
	border-right: 1px solid black;
}
.right_att {
	float: right;
	width: 50%;
}
.att_btn p {
	margin: 0px;
	font-size: 21px;
	padding: 23px 0px;
	border-bottom: 1px solid black;
	width: 85%;
	padding-bottom: 9px;
	margin-bottom: 24px;
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
</style>
';

  

 
for($in=0;$in<=23;$in++)
{
  $insertHTML.='
   <option>'.$in.'</option>
  ';
} 

for($out=0;$out<=60;$out++)
{
  $logoutHTML.='
   <option>'.$out.'</option>
  ';
}

$UserReport =  SQL_Select("user","UserIsActive=1 and UserID>1  order by UserID DESC limit 50");
foreach($UserReport as $ThisUserReport){
	$nameHtml.='
	   <option value="'.$ThisUserReport["UserID"].'">'.$ThisUserReport["FullName"].'</option>
	';
	
}

$MainContent.='
<div class="container">
  <div class="attendance">
     <p>Mange Attendance
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <a href="index.php?Theme=default&Base=upload_execl_file&Script=index">Import Data</a>
	    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <a href="index.php?Theme=default&Base=Attendance&Script=home">Back The Page</a>
	 <p>
  </div>
  
  <div class="att_btn">
     <p>Set Attendance</p>
	 
	 <form action="index.php?Theme=default&Base=Attendance&Script=att_insert" method="post">
	 <table>
	   <tr>
	     <td colspan="2">
		   <span class="set_title">Employee Name</span> <br/>
		   <select class="UserID" name="UserID">		     <option>Select Employee Name</option>
		     '.$nameHtml.'
		   </select>
		 </td>
		</tr>
	   
	   <tr>
	     <td>
            <span class="set_title">Insert Time(Date - Hour - Secnod)</span> <br/>
		    <!--<input name="InsertDate" type="text" size="16" required id="insertdatetime" style="max-width: 87px;"/>-->
			<input type="text" name="InsertDate" required id="datepicker" style="max-width: 87px;" >
			<select name="InsertHour" style="max-width: 53px;">
			   '.$insertHTML.'
			</select>		
			<select name="InsertSecnod" style="max-width: 53px;">
			   '.$logoutHTML.'
			</select>	
           <input type="text" name="insertday" id="alternate" size="30" style="max-width: 90px;">
			<!--
			<select style="max-width: 60px;">
			   <option>AM</option>
			   <option>PM</option>
			</select>
			-->
		 </td>
	   </tr>	   
	   
	   
	   <tr>
	     <td>
            <span class="set_title">Logout Time(Date - Hour - Second)</span> <br/>
		    <!--<input name="logoutDate" type="text" size="16" id="logoutdatetime" style="max-width: 87px;">-->
			<input type="text" name="logoutDate"  id="outtimepicker" style="max-width: 87px;" >

			<select name="logoutHour" style="max-width: 53px;">
			   '.$insertHTML.'
			</select>		
			<select name="logoutSecnod" style="max-width: 53px;">
			   '.$logoutHTML.'
			</select>
			<input type="text" name="outday" id="alternateout" size="30" style="max-width: 90px;">
			<!--
			<select style="max-width: 60px;">
			   <option>AM</option>
			   <option>PM</option>
			</select>
            -->
			
		 </td>
	   </tr>

	   <tr>
	     <td colspan="2">
           <input type="submit" name="att_submit" value="Save Data" class="att_btnpage" />
		 </td>
	   </tr>	   
	 </table>
     </form>
  </div>
  
  <div class="right_att">
  <div class="att_today">
     <a href="index.php?Theme=default&Base=Attendance&Script=ReportAttendance">View Today Attendance</a>
  </div>   
  
  <div class="all_view">
     <a href="index.php?Theme=default&Base=Attendance&Script=report">View All Attendance</a>
  </div>  
  
  
  <form action="index.php?Theme=default&Base=Attendance&Script=ReportAttendance" method="post">
  <div class="att_sub">
     View Specific Date Select <br/>
	 <input type="text" name="searchdate" id="searchdatewise" /><br/>
     <input type="submit" value="Search Data" class="att_btnpage" />
  </div>
  </form>
  
  </div>
  
  
</div>
                      
';