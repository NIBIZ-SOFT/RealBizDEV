<?php

$delete=$_GET['id'];
mysql_query("DELETE FROM tblattendance WHERE AttendanceID='$delete'");



$sdate=$_POST['searchdate'];
if($sdate){
  $todaydate=$_POST['searchdate'];	
}else{
  $todaydate=date("Y-m-d");	
}

$AttendanceReport = SQL_Select("attendance","InDate='$todaydate' order by AttendanceID");
foreach($AttendanceReport as $ThisAttendanceReport){
	
	$latehour=$ThisAttendanceReport['InHour'];
	$lateSecond=$ThisAttendanceReport['InSecond'];
	$Lhour=$ThisAttendanceReport['latehour'];
	$latetime=$ThisAttendanceReport['latetime'];
	$earlyleaving=$ThisAttendanceReport['earlyleaving'];
	$latetimeshow=str_replace("-", "", $latetime);
	$earlyleavingtimeshow=str_replace("-", "", $earlyleaving);
	
	$UserID=$ThisAttendanceReport['UserID'];
	$username=mysql_query("select * from tbluser where UserID='$UserID'");
	$usernamereport=mysql_fetch_assoc($username);
	
	$IntimeH=$usernamereport['IntimeH'];
	$IntimeS=$usernamereport['IntimeS'];
	
	if($latetime>=0){
		$lshowreport="<span style='color:green'>No Late</span>";
	}else{
		$lshowreport="Late <span style='color:red'>$latetimeshow</span> Minute" ;		
	}
	
	if($earlyleaving!="No Enrty"){
		if($earlyleaving<=0){
			$Eshowreport="<span style='color:green'>Nice Day</span>";
		}else{
			$Eshowreport="Early Leving <span style='color:red'>$earlyleavingtimeshow</span> Minute" ;		
		}

	}else{
		$Eshowreport="No Entry" ;
    }

	
	$cout=$ThisAttendanceReport['OutDate'];
	if($cout!=''){
		$ltime=$ThisAttendanceReport['Logout'];
	}else{
	  	$ltime="<span style='color:red'>Not Sing Out</span>";	
	}
	
	
	
	$timereportHTML.='
	   <tr>
		  <th>'.$usernamereport['FullName'].'</th>
		  <th>'.$ThisAttendanceReport['LoginTime'].'</th>
		  <th>'.$ltime.'</th>
		  <th>'.$lshowreport.'</th>
		  <th>'.$Eshowreport.'</th>
		  <th><a href="index.php?Theme=default&Base=Attendance&Script=updatepage&id='.$ThisAttendanceReport['AttendanceID'].'">Modify Attendance</a></th>
		  <th><a href="index.php?Theme=default&Base=Attendance&Script=report&id='.$ThisAttendanceReport['AttendanceID'].'">Delete</a></th>
       </tr>
	';
}	
	
	
	
	$MainContent.='				
                   <div class="row-fluid">
                        <div class="span12">
                            <!-- block -->
							
							
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left">Today <span style="color:green">'.$todaydate.'</span> Attendance Report</div>
                                    <div class="pull-right"><span class="badge badge-info"><a style="color: white;font-size: 16px;" href="index.php?Theme=default&Base=Attendance&Script=index">Back To Page</a></span>

                                    </div>
                                </div>
                                <div class="block-content collapse in">
								
                                    <table class="table table-striped table-bordered" id="example1">
                                        <thead>
                                            <tr>
												<th>Empolye Name</th>
                                                <th>Login Time</th>                                              
                                                <th>Logout Time</th>
                                                <th>Late</th>
                                                <th>Early leaving</th>
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
				
	';