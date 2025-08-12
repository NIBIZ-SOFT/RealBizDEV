<?php


$fd=$_GET['fulld'];
$GDate=$_GET['Date'];


$delete=$_GET['id'];
mysql_query("DELETE FROM tblattendance WHERE AttendanceID='$delete'");


$AttendanceReport = SQL_Select("attendance","UserID='$fd' and InDate='$GDate' order by AttendanceID DESC");
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
	
	 $fulld=$_GET['fulld'];
	 $SDate=$_GET['Date'];
	
	$timereportHTML.='
	   <tr>
		  <th>#'.$ThisAttendanceReport['AttendanceID'].'</th>
		  <th>'.$usernamereport['FullName'].'</th>
		  <th>'.$ThisAttendanceReport['LoginTime'].'</th>
		  <th>'.$ltime.'</th>
		  <th>'.$lshowreport.'</th>
		  <th>'.$Eshowreport.'</th>
		  <th><a href="index.php?Theme=default&Base=Attendance&Script=UpdateAttendance&id='.$ThisAttendanceReport['AttendanceID'].'&fid='.$fulld.'&sdata='.$SDate.'">Modify Attendance</a></th>
		  <th><a href="index.php?Theme=default&Base=Attendance&Script=PerEAttReport&fulld='.$fulld.'&Date='.$SDate.'&id='.$ThisAttendanceReport['AttendanceID'].'">Delete</a></th>
       </tr>
	';
}	
	
	
	
	$MainContent.='				
                   <div class="row-fluid">
                        <div class="span12">
                            <!-- block -->
							
							
                            <div class="block">
                                <div class="navbar navbar-inner block-header">
                                    <div class="muted pull-left" style="font-size: 18px;">
									<span style="color:green;font-size:18px">'.$usernamereport['FullName'].'</span>
									&nbsp; Attendance Report &nbsp;
									 Date: <span style="color:green;font-size:18px">'.$GDate.'</span> 
									 <br/> <br/>
									 <span style="color:blue;font-size:16px">Login Time:</span> 
									 <span style="color:black;font-size:16px">10.10 </span>
									 &nbsp;&nbsp;&nbsp;&nbsp;
									 <span style="color:blue;font-size:16px">Last Logout Time:</span> 
									 <span style="color:black;font-size:16px">2.00</span>
									 <br/> <br/>
									 </div>
									
                                    <div class="pull-right"><span class="badge badge-info"><a style="color: white;font-size: 16px;" href="index.php?Theme=default&Base=Attendance&Script=ReportAttendance">Back To Page</a></span>

                                    </div>
                                </div>
                                <div class="block-content collapse in">
								
                                    <table class="table table-striped table-bordered" id="example1">
                                        <thead>
                                            <tr>
												<th>Eentry SL</th>
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