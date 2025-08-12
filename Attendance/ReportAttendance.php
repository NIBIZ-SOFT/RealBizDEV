<?php

   $ss=$_REQUEST['Script'];
   if($ss=='home'){
	  $bodyclassHTML.='span6'; 
   }else{
	 $bodyclassHTML.='span12';  
   }



	if(isset($_POST['searchdate'])){
	   $TDate=$_POST['searchdate'];	
	}else{
	   $TDate=date('Y-m-d');
	}

	
	$Data=mysql_query("select DISTINCT UserID from tblattendance where InDate='$TDate' order by AttendanceID desc");
    while($ThisDataReport=mysql_fetch_array($Data)){
	   $CUID=$ThisDataReport['UserID'];
	   


	   
	   $username=mysql_query("select * from tbluser where UserID='$CUID'");
	   $usernamereport=mysql_fetch_assoc($username);
	   

		$IData=mysql_query("select * from tblattendance where UserID='$CUID' and InDate='$TDate' order by AttendanceID asc limit 1");
        $ThisIDataReport=mysql_fetch_assoc($IData);
		 	$latetime=$ThisIDataReport['latetime'];
			$latetimeshow=str_replace("-", "", $latetime);
			

			if($latetime>=0){
		    $lshowreport="<span style='color:green'>No Late</span>";
	        }else{
		    $lshowreport="Late <span style='color:red'>$latetimeshow</span> Minute" ;		
	        }


		
		$OData=mysql_query("select * from tblattendance where UserID='$CUID' and InDate='$TDate' order by AttendanceID DESC limit 1");
        $ThisODataReport=mysql_fetch_assoc($OData);
			$earlyleaving=$ThisODataReport['earlyleaving'];
			$earlyleavingtimeshow=str_replace("-", "", $earlyleaving);

			$cout=$ThisODataReport['OutDate'];
			if($cout!=''){
				$ltime=$ThisODataReport['Logout'];
			}else{
				$ltime="<span style='color:red'>Not Sing Out</span>";	
			}
			
			$earlyleaving=$ThisODataReport['earlyleaving'];
		    if($earlyleaving!="No Enrty"){
			   if($earlyleaving<=0){
				$Eshowreport="<span style='color:green'>Nice Day</span>";
			   }else{
				$Eshowreport="Early Leving <span style='color:red'>$earlyleavingtimeshow</span> Minute" ;		
			   }

			   }else{
				$Eshowreport="No Entry" ;
            }
	

	$timereportHTML.='
	   <tr>
		  <th>
		  <a href="index.php?Theme=default&Base=Attendance&Script=PerEAttReport&fulld='.$ThisDataReport['UserID'].'&Date='.$TDate.'">
		  '.$usernamereport['FullName'].'
		  </a>
		  </th>
		  <th>'.$ThisIDataReport['LoginTime'].'</th>
		  <th>'.$ltime.'</th>
		  <th>'.$lshowreport.'</th>
		  <th>'.$Eshowreport.'</th>
       </tr>
	';
	}
	
	$MainContent.='				
                   <div class="row-fluid">
                        <div class="'.$bodyclassHTML.'">
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
                                            <tr>
												<th>Empolye Name</th>
                                                <th>Login Time</th>                                              
                                                <th>Logout Time</th>
                                                <th>Late</th>
                                                <th>Early leaving</th>
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