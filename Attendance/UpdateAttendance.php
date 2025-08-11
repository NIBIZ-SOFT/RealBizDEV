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
	width: 60%;
	border-right: 0px solid black;
	margin: 0 auto;
	margin-left: 263px;
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
	width: 48%;
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

  
  
$update=$_GET['id'];
$udata=mysql_query("select * from tblattendance where AttendanceID='$update'");  
$udatareport=mysql_fetch_assoc($udata);
 
$cuser=$udatareport['UserID'];
$userdata=mysql_query("select * from tbluser where UserID='$cuser'");  
$userdatareport=mysql_fetch_assoc($userdata);

 
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
     <p>Mange Attendance<p>
  </div>
  
  <div class="att_btn">
     <p>Set Attendance Update Page</p>
	 
	 <form action="index.php?Theme=default&Base=Attendance&Script=UpdateAttendanceInsert" method="post">
	 <table>
	   <tr>
	     <td colspan="2">
		   <span class="set_title">Employee Name</span> <br/>
		   <select name="UserID">
		     <option value="'.$udatareport['UserID'].'">'.$userdatareport['FullName'].'</option>
		     '.$nameHtml.'
		   </select>
		 </td>
		</tr>
	   
	   <tr>
	     <td>
            <span class="set_title">Insert Time(Date - Hour - Secnod)</span> <br/>
		    <!--<input name="InsertDate" type="text" size="16" required id="insertdatetime" style="max-width: 87px;"/>-->
			<input type="text" value="'.$udatareport['InDate'].'" name="InsertDate" required id="datepicker" style="max-width: 87px;" >
			<select name="InsertHour" style="max-width: 53px;">
			   <option>'.$udatareport['InHour'].'</option>
			   '.$insertHTML.'
			</select>		
			<select name="InsertSecnod" style="max-width: 53px;">
			   <option>'.$udatareport['InSecond'].'</option>
			   '.$logoutHTML.'
			</select>	
           <input type="text" value="'.$udatareport['insertday'].'" name="insertday" id="alternate" size="30" style="max-width: 90px;">
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
			<input type="text" value="'.$udatareport['OutDate'].'" name="logoutDate"  id="outtimepicker" style="max-width: 87px;" >

			<select name="logoutHour" style="max-width: 53px;">
			   <option>'.$udatareport['OutHour'].'</option>
			   '.$insertHTML.'
			</select>		
			<select name="logoutSecnod" style="max-width: 53px;">
			   <option>'.$udatareport['OutSecond'].'</option>
			   '.$logoutHTML.'
			</select>
			<input type="text" value="'.$udatareport['outday'].'" name="outday" id="alternateout" size="30" style="max-width: 90px;">
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
		 
		   <input type="hidden" value="'.$_GET['fid'].'" name="fulld">
		   <input type="hidden" value="'.$_GET['sdata'].'" name="sdate">
		   
		   
		   <input type="hidden" value="'.$udatareport['AttendanceID'].'" name="upid">
           <input type="submit" name="att_submit" value="Update Data" class="att_btnpage" />
		 </td>
	   </tr>	   
	 </table>
     </form>
  </div>
  
</div>
                      
';