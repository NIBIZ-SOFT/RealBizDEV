<?php


if(isset($_POST['att_submit'])){
	$UserID=$_POST['UserID'];
	
	$checktime=mysql_query("select * from tbluser where UserID='$UserID'");
	$checktimereport=mysql_fetch_assoc($checktime);
	
	
	$FridayInTime=strtotime($checktimereport['FridayInTime']);
	$SaturdayInTime=strtotime($checktimereport['SaturdayInTime']);
	$SundayInTime=strtotime($checktimereport['SundayInTime']);
	$MondayInTime=strtotime($checktimereport['MondayInTime']);
	$ThursdayInTime=strtotime($checktimereport['ThursdayInTime']);
	$WednesdayInTime=strtotime($checktimereport['WednesdayInTime']);
	$TuesdayInTime=strtotime($checktimereport['TuesdayInTime']);

	
	$FridayOutTime=strtotime($checktimereport['FridayOutTime']);
	$SaturdayOutTime=strtotime($checktimereport['SaturdayOutTime']);
	$SundayOutTime=strtotime($checktimereport['SundayOutTime']);
	$MondayOutTime=strtotime($checktimereport['MondayOutTime']);
	$ThursdayOutTime=strtotime($checktimereport['ThursdayOutTime']);
	$WednesdayOutTime=strtotime($checktimereport['WednesdayOutTime']);
	$TuesdayOutTime=strtotime($checktimereport['TuesdayOutTime']);
	
	
    $insertday=$_POST['insertday'];
    $outday=$_POST['outday'];

	$InH=$checktimereport['IntimeH'];
	$InS=$checktimereport['IntimeS'];
	
	$InsertDate=$_POST['InsertDate'];
	$InsertHour=$_POST['InsertHour'];
	$InsertSecnod=$_POST['InsertSecnod'];
	$attinsertintime=strtotime($InsertHour.':'.$InsertSecnod);
	
	if($insertday!='Friday'){
	   	if($insertday!='Saturday'){
		    if($insertday!='Sunday'){
			  	if($insertday!='Monday'){
			  	    if($insertday!='Tuesday'){
					 	if($insertday!='Wednesday'){
						 	if($insertday!='Thursday'){
							 echo "no data match";	
							}else{
							  $clate=($TuesdayInTime-$attinsertintime)/60;	
							}	
						}else{
						  $clate=($WednesdayInTime-$attinsertintime)/60;	
						}	
					}else{
					  $clate=($ThursdayInTime-$attinsertintime)/60;	
					}	
				}else{
				   $clate=($MondayInTime-$attinsertintime)/60;	
				}	
			}else{
			   $clate=($SundayInTime-$attinsertintime)/60;	
			}
		}else{
		  $clate=($SaturdayInTime-$attinsertintime)/60;
		}
	}else{
       $clate=($FridayInTime-$attinsertintime)/60;
	}


	
    $latehour=$InH-$InsertHour;
	$lateSecnod=$InS-$InsertSecnod;
	$LTime=$latehour.':'.$lateSecnod;

	$logoutDate=$_POST['logoutDate'];
	$logoutHour=$_POST['logoutHour'];
	$logoutSecnod=$_POST['logoutSecnod'];
	$attlogouttime=strtotime($logoutHour.':'.$logoutSecnod);

	if($outday!='Friday'){
	   	if($outday!='Saturday'){
		    if($outday!='Sunday'){
			  	if($outday!='Monday'){
			  	    if($outday!='Tuesday'){
					 	if($outday!='Wednesday'){
						 	if($outday!='Thursday'){
							   $oearly="No Enrty";	
							}else{
							  $oearly=($TuesdayOutTime-$attlogouttime)/60;	
							}	
						}else{
						  $oearly=($WednesdayOutTime-$attlogouttime)/60;	
						}	
					}else{
					  $oearly=($ThursdayOutTime-$attlogouttime)/60;	
					}	
				}else{
				   $oearly=($MondayOutTime-$attlogouttime)/60;	
				}	
			}else{
			   $oearly=($SundayOutTime-$attlogouttime)/60;	
			}
		}else{
		  $oearly=($SaturdayOutTime-$attlogouttime)/60;
		}
	}else{
        $oearly=($FridayOutTime-$attlogouttime)/60;
	}
	
	
	$InTime=$InsertDate.' '.$InsertHour.':'.$InsertSecnod; 
	$OutTime=$logoutDate.' '.$logoutHour.':'.$logoutSecnod;

	$UpdateId=$_POST['upid'];

	
	$ins=mysql_query("UPDATE tblattendance SET UserID='$UserID',InDate='$InsertDate',InHour='$InsertHour',InSecond='$InsertSecnod',latetime='$clate',insertday='$insertday',LoginTime='$InTime',OutDate='$logoutDate',OutHour='$logoutHour',OutSecond='$logoutSecnod',outday='$outday',Logout='$OutTime',earlyleaving='$oearly' WHERE AttendanceID='$UpdateId'");
	
	
   // $ins=mysql_query("insert into tblattendance(UserID,LoginTime,Logout,latehour,lateSecnod,latetime,earlyleaving,InDate,InHour,InSecond,OutDate,OutHour,OutSecond,insertday,outday)
	//value('$UserID','$InTime','$OutTime','$latehour','$lateSecnod','$clate','$oearly','$InsertDate','$InsertHour','$InsertSecnod','$logoutDate','$logoutHour','$logoutSecnod','$insertday','$outday')");
   

   if($ins){
		header("location:index.php?Theme=default&Base=Attendance&Script=report");
    }else{
	    header("location:index.php?Theme=default&Base=Attendance&Script=index");
	}
	
}

