<?php

$FridayInTime=$_REQUEST['FridayInTime'];
$friTime=explode(":",$FridayInTime);
$FridayInHour=$friTime[0];
$FridayInMin=$friTime[1];

$FridayOutTime=$_REQUEST['FridayOutTime'];
$friOTime=explode(":",$FridayOutTime);
$FridayOutHour=$friOTime[0];
$FridayOutMin=$friOTime[1];



$SaturdayInTime=$_REQUEST['SaturdayInTime'];
$SatTime=explode(":",$SaturdayInTime);
$SaturdayInHour=$SatTime[0];
$SaturdayInMin=$SatTime[1];

$SaturdayOutTime=$_REQUEST['SaturdayOutTime'];
$SatOTime=explode(":",$SaturdayOutTime);
$SaturdayOutHour=$SatOTime[0];
$SaturdayOutMin=$SatOTime[1];




$SundayInTime=$_REQUEST['SundayInTime'];
$SunTime=explode(":",$SundayInTime);
$SundayInHour=$SunTime[0];
$SundayInMin=$SunTime[1];

$SundayOutTime=$_REQUEST['SundayOutTime'];
$SunOTime=explode(":",$SundayOutTime);
$SundayOutHour=$SunOTime[0];
$SundayOutMin=$SunOTime[1];




$MondayInTime=$_REQUEST['MondayInTime'];
$MonTime=explode(":",$MondayInTime);
$MondayInHour=$MonTime[0];
$MondayInMin=$MonTime[1];

$MondayOutTime=$_REQUEST['MondayOutTime'];
$MonOTime=explode(":",$MondayOutTime);
$MondayOutHour=$MonOTime[0];
$MondayOutMin=$MonOTime[1];



$ThursdayInTime=$_REQUEST['ThursdayInTime'];
$ThuTime=explode(":",$ThursdayInTime);
$ThursdayInHour=$ThuTime[0];
$ThursdayInMin=$ThuTime[1];

$ThursdayOutTime=$_REQUEST['ThursdayOutTime'];
$ThuOTime=explode(":",$ThursdayOutTime);
$ThursdayOutHour=$ThuOTime[0];
$ThursdayOutMin=$ThuOTime[1];




$WednesdayInTime=$_REQUEST['WednesdayInTime'];
$WedTime=explode(":",$WednesdayInTime);
$WednesdayInHour=$WedTime[0];
$WednesdayInMin=$WedTime[1];

$WednesdayOutTime=$_REQUEST['WednesdayOutTime'];
$WedOTime=explode(":",$WednesdayOutTime);
$WednesdayOutHour=$WedOTime[0];
$WednesdayOutMin=$WedOTime[1];



$TuesdayInTime=$_REQUEST['TuesdayInTime'];
$TueTime=explode(":",$TuesdayInTime);
$TuesdayInHour=$TueTime[0];
$TuesdayInMin=$TueTime[1];

$TuesdayOutTime=$_REQUEST['TuesdayOutTime'];
$TueOTime=explode(":",$TuesdayOutTime);
$TuesdayOutHour=$TueOTime[0];
$TuesdayOutMin=$TueOTime[1];







// give the data dase fields name and the post value name
$Where="UserID = {$_REQUEST['UserID']}";
$TheEntityName=SQL_InsertUpdate(
$Entity="User",
$TheEntityNameData=array(
                                                                                              
"FridayInTime"=>$_POST["FridayInTime"],
"FridayOutTime"=>$_POST["FridayOutTime"],
"FridayInHour"=>$FridayInHour,
"FridayInMin"=>$FridayInMin,
"FridayOutHour"=>$FridayOutHour,
"FridayOutMin"=>$FridayOutMin,
"FridayStatus"=>$_POST["FridayStatus"],


"SaturdayInTime"=>$_POST["SaturdayInTime"],
"SaturdayOutTime"=>$_POST["SaturdayOutTime"],
"SaturdayInHour"=>$SaturdayInHour,
"SaturdayInMin"=>$SaturdayInMin,
"SaturdayOutHour"=>$SaturdayOutHour,
"SaturdayOutMin"=>$SaturdayOutMin,
"SaturdayStatus"=>$_POST["SaturdayStatus"],


"SundayInTime"=>$_POST["SundayInTime"],
"SundayOutTime"=>$_POST["SundayOutTime"],
"SundayInHour"=>$SundayInHour,
"SundayInMin"=>$SundayInMin,
"SundayOutHour"=>$SundayOutHour,
"SundayOutMin"=>$SundayOutMin,
"SundayStatus"=>$_POST["SundayStatus"],


"MondayInTime"=>$_POST["MondayInTime"],
"MondayOutTime"=>$_POST["MondayOutTime"],
"MondayInHour"=>$MondayInHour,
"MondayInMin"=>$MondayInMin,
"MondayOutHour"=>$MondayOutHour,
"MondayOutMin"=>$MondayOutMin,
"MondayStatus"=>$_POST["MondayStatus"],


"ThursdayInTime"=>$_POST["ThursdayInTime"],
"ThursdayOutTime"=>$_POST["ThursdayOutTime"],
"ThursdayInHour"=>$ThursdayInHour,
"ThursdayInMin"=>$ThursdayInMin,
"ThursdayOutHour"=>$ThursdayOutHour,
"ThursdayOutMin"=>$ThursdayOutMin,
"ThursdayStatus"=>$_POST["ThursdayStatus"],



"WednesdayInTime"=>$_POST["WednesdayInTime"],
"WednesdayOutTime"=>$_POST["WednesdayOutTime"],
"WednesdayInHour"=>$WednesdayInHour,
"WednesdayInMin"=>$WednesdayInMin,
"WednesdayOutHour"=>$WednesdayOutHour,
"WednesdayOutMin"=>$WednesdayOutMin,
"WednesdayStatus"=>$_POST["WednesdayStatus"],


"TuesdayInTime"=>$_POST["TuesdayInTime"],
"TuesdayOutTime"=>$_POST["TuesdayOutTime"],
"TuesdayInHour"=>$TuesdayInHour,
"TuesdayInMin"=>$TuesdayInMin,
"TuesdayOutHour"=>$TuesdayOutHour,
"TuesdayOutMin"=>$TuesdayOutMin,
"TuesdayStatus"=>$_POST["TuesdayStatus"],

),
$Where
);

$MainContent.="
	".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
	 <br>
	 The $EntityCaptionLower information has been stored.<br>
	 <br>
	 Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","home&rr=1")."\">here</a> to proceed.",300)."
	 <script language=\"JavaScript\" >
	       window.location='".ApplicationURL("{$_REQUEST["Base"]}","home&rr=1")."';
	 </script>
     ";