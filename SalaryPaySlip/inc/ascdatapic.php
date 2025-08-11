<?php

$ddata1=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-1' and UserID='$UID' order by AttendanceID asc");
$Thisddata1=mysql_fetch_assoc($ddata1);
$Clate1=str_replace("-", "", $Thisddata1['latetime']);
if(!$Clate1>0){
  $Absent1=1;	
}else{
  $late1=str_replace("-", "", $Thisddata1['latetime']);
}



$ddata2=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-2' and UserID='$UID' order by AttendanceID asc");
$Thisddata2=mysql_fetch_assoc($ddata2);
$Clate2=str_replace("-", "", $Thisddata2['latetime']);
if(!$Clate2>0){
   $Absent2=1;	
}else{
  $late2=str_replace("-", "", $Thisddata2['latetime']);
}




$ddata3=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-3' and UserID='$UID' order by AttendanceID asc");
$Thisddata3=mysql_fetch_assoc($ddata3);
$Clate3=str_replace("-", "", $Thisddata3['latetime']);
if(!$Clate3>0){
   $Absent3=1;	
}else{
  $late3=str_replace("-", "", $Thisddata3['latetime']);
}



$ddata4=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-4' and UserID='$UID' order by AttendanceID asc");
$Thisddata4=mysql_fetch_assoc($ddata4);
$Clate4=str_replace("-", "", $Thisddata4['latetime']);
if(!$Clate4>0){
   $Absent4=1;	
}else{
  $late4=str_replace("-", "", $Thisddata4['latetime']);
}


$ddata5=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-5' and UserID='$UID' order by AttendanceID asc");
$Thisddata5=mysql_fetch_assoc($ddata5);
$Clate5=str_replace("-", "", $Thisddata5['latetime']);
if(!$Clate5>0){
   $Absent5=1;	
}else{
  $late5=str_replace("-", "", $Thisddata5['latetime']);
}



$ddata6=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-6' and UserID='$UID' order by AttendanceID asc");
$Thisddata6=mysql_fetch_assoc($ddata6);
$Clate6=str_replace("-", "", $Thisddata6['latetime']);
if(!$Clate6>0){
   $Absent6=1;	
}else{
  $late6=str_replace("-", "", $Thisddata6['latetime']);
}


$ddata7=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-7' and UserID='$UID' order by AttendanceID asc");
$Thisddata7=mysql_fetch_assoc($ddata7);
$Clate7=str_replace("-", "", $Thisddata7['latetime']);
if(!$Clate7>0){
   $Absent7=1;	
}else{
  $late7=str_replace("-", "", $Thisddata7['latetime']);
}


$ddata8=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-8' and UserID='$UID' order by AttendanceID asc");
$Thisddata8=mysql_fetch_assoc($ddata8);
$Clate8=str_replace("-", "", $Thisddata8['latetime']);
if(!$Clate8>0){
   $Absent8=1;	
}else{
  $late8=str_replace("-", "", $Thisddata8['latetime']);
}


$ddata9=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-9' and UserID='$UID' order by AttendanceID asc");
$Thisddata9=mysql_fetch_assoc($ddata9);
$Clate9=str_replace("-", "", $Thisddata9['latetime']);
if(!$Clate9>0){
   $Absent9=1;	
}else{
  $late9=str_replace("-", "", $Thisddata9['latetime']);
}



$ddata10=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-10' and UserID='$UID' order by AttendanceID asc");
$Thisddata10=mysql_fetch_assoc($ddata10);
$Clate10=str_replace("-", "", $Thisddata10['latetime']);
if(!$Clate10>0){
   $Absent10=1;	
}else{
  $late10=str_replace("-", "", $Thisddata10['latetime']);
}


$ddata11=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-11' and UserID='$UID' order by AttendanceID asc");
$Thisddata11=mysql_fetch_assoc($ddata11);
$Clate11=str_replace("-", "", $Thisddata11['latetime']);
if(!$Clate11>0){
   $Absent11=1;	
}else{
  $late11=str_replace("-", "", $Thisddata11['latetime']);
}


$ddata12=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-12' and UserID='$UID' order by AttendanceID asc");
$Thisddata12=mysql_fetch_assoc($ddata12);
$Clate12=str_replace("-", "", $Thisddata12['latetime']);
if(!$Clate12>0){
   $Absent12=1;	
}else{
  $late12=str_replace("-", "", $Thisddata12['latetime']);
}


$ddata13=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-13' and UserID='$UID' order by AttendanceID asc");
$Thisddata13=mysql_fetch_assoc($ddata13);
$Clate13=str_replace("-", "", $Thisddata13['latetime']);
if(!$Clate13>0){
   $Absent13=1;	
}else{
  $late13=str_replace("-", "", $Thisddata13['latetime']);
}



$ddata14=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-14' and UserID='$UID' order by AttendanceID asc");
$Thisddata14=mysql_fetch_assoc($ddata14);
$Clate14=str_replace("-", "", $Thisddata14['latetime']);
if(!$Clate14>0){
   $Absent14=1;	
}else{
  $late14=str_replace("-", "", $Thisddata14['latetime']);
}



$ddata15=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-15' and UserID='$UID' order by AttendanceID asc");
$Thisddata15=mysql_fetch_assoc($ddata15);
$Clate15=str_replace("-", "", $Thisddata15['latetime']);
if(!$Clate15>0){
   $Absent15=1;	
}else{
  $late15=str_replace("-", "", $Thisddata15['latetime']);
}


$ddata16=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-16' and UserID='$UID' order by AttendanceID asc");
$Thisddata16=mysql_fetch_assoc($ddata16);
$Clate16=str_replace("-", "", $Thisddata16['latetime']);
if(!$Clate16>0){
   $Absent16=1;	
}else{
  $late16=str_replace("-", "", $Thisddata16['latetime']);
}


$ddata17=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-17' and UserID='$UID' order by AttendanceID asc");
$Thisddata17=mysql_fetch_assoc($ddata17);
$Clate17=str_replace("-", "", $Thisddata17['latetime']);
if(!$Clate17>0){
   $Absent17=1;
}else{
   $late17=str_replace("-", "", $Thisddata17['latetime']);	
}


$ddata18=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-18' and UserID='$UID' order by AttendanceID asc");
$Thisddata18=mysql_fetch_assoc($ddata18);
$Clate18=str_replace("-", "", $Thisddata18['latetime']);
if(!$Clate18>0){
  $Absent18=1;
}else{
  $late18=str_replace("-", "", $Thisddata18['latetime']);	
}



$ddata19=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-19' and UserID='$UID' order by AttendanceID asc");
$Thisddata19=mysql_fetch_assoc($ddata19);
$Clate19=str_replace("-", "", $Thisddata19['latetime']);
if(!$Clate19>0){
   $Absent19=1;	
}else{
  $late19=str_replace("-", "", $Thisddata19['latetime']);
}



$ddata20=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-20' and UserID='$UID' order by AttendanceID asc");
$Thisddata20=mysql_fetch_assoc($ddata20);
$Clate20=str_replace("-", "", $Thisddata20['latetime']);
if(!$Clate20>0){
   $Absent20=1;	
}else{
  $late20=str_replace("-", "", $Thisddata20['latetime']);
}


$ddata21=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-21' and UserID='$UID' order by AttendanceID asc");
$Thisddata21=mysql_fetch_assoc($ddata21);
$Clate21=str_replace("-", "", $Thisddata21['latetime']);
if(!$Clate21>0){
   $Absent21=1;	
}else{
  $late21=str_replace("-", "", $Thisddata21['latetime']);
}



$ddata22=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-22' and UserID='$UID' order by AttendanceID asc");
$Thisddata22=mysql_fetch_assoc($ddata22);
$Clate22=str_replace("-", "", $Thisddata22['latetime']);
if(!$Clate22>0){
   $Absent22=1;	
}else{
  $late22=str_replace("-", "", $Thisddata22['latetime']);
}


$ddata23=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-23' and UserID='$UID' order by AttendanceID asc");
$Thisddata23=mysql_fetch_assoc($ddata23);
$Clate23=str_replace("-", "", $Thisddata23['latetime']);
if(!$Clate23>0){
   $Absent23=1;	
}else{
  $late23=str_replace("-", "", $Thisddata23['latetime']);
}


$ddata24=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-24' and UserID='$UID' order by AttendanceID asc");
$Thisddata24=mysql_fetch_assoc($ddata24);
$Clate24=str_replace("-", "", $Thisddata24['latetime']);
if(!$Clate24>0){
   $Absent24=1;	
}else{
  $late24=str_replace("-", "", $Thisddata24['latetime']);
}


$ddata25=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-25' and UserID='$UID' order by AttendanceID asc");
$Thisddata25=mysql_fetch_assoc($ddata25);
$Clate25=str_replace("-", "", $Thisddata25['latetime']);
if(!$Clate25>0){
   $Absent25=1;	
}else{
  $late25=str_replace("-", "", $Thisddata25['latetime']);
}



$ddata26=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-26' and UserID='$UID' order by AttendanceID asc");
$Thisddata26=mysql_fetch_assoc($ddata26);
$Clate26=str_replace("-", "", $Thisddata26['latetime']);
if(!$Clate26>0){
   $Absent26=1;	
}else{
  $late26=str_replace("-", "", $Thisddata26['latetime']);
}


$ddata27=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-27' and UserID='$UID' order by AttendanceID asc");
$Thisddata27=mysql_fetch_assoc($ddata27);
$Clate27=str_replace("-", "", $Thisddata27['latetime']);
if(!$Clate27>0){
   $Absent27=1;	
}else{
  $late27=str_replace("-", "", $Thisddata27['latetime']);
}


$ddata28=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-28' and UserID='$UID' order by AttendanceID asc");
$Thisddata28=mysql_fetch_assoc($ddata28);
$Clate28=str_replace("-", "", $Thisddata28['latetime']);
if(!$Clate28>0){
   $Absent28=1;	
}else{
  $late28=str_replace("-", "", $Thisddata28['latetime']);
}


$ddata29=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-29' and UserID='$UID' order by AttendanceID asc");
$Thisddata29=mysql_fetch_assoc($ddata29);
$Clate29=str_replace("-", "", $Thisddata29['latetime']);
if(!$Clate29>0){
   $Absent29=1;	
}else{
  $late29=str_replace("-", "", $Thisddata29['latetime']);
}


$ddata30=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-30' and UserID='$UID' order by AttendanceID asc");
$Thisddata30=mysql_fetch_assoc($ddata30);
$Clate30=str_replace("-", "", $Thisddata30['latetime']);
if(!$Clate30>0){
   $Absent30=1;	
}else{
  $late30=str_replace("-", "", $Thisddata30['latetime']);
}


$ddata31=mysql_query("select DISTINCT InDate,latetime from tblattendance where MONTH(InDate)='$mi' and YEAR(InDate)='$yi' and InDate='2016-10-31' and UserID='$UID' order by AttendanceID asc");
$Thisddata31=mysql_fetch_assoc($ddata31);
$Clate31=str_replace("-", "", $Thisddata31['latetime']);
if(!$Clate31>0){
   $Absent31=1;	
}else{
  $late31=str_replace("-", "", $Thisddata31['latetime']);
}

$AbsentDay=$Absent1+$Absent2+$Absent3+$Absent4+$Absent5+$Absent6+$Absent7+$Absent8+$Absent9+$Absent10+$Absent11+$Absent12+$Absent13+$Absent14+$Absent15+$Absent16+$Absent17+$Absent18+$Absent19+$Absent20+$Absent21+$Absent22+$Absent23+$Absent24+$Absent25+$Absent26+$Absent27+$Absent28+$Absent29+$Absent30+$Absent31;
$LateTimeMin=$late1+$late2+$late3+$late4+$late5+$late6+$late7+$late8+$late9+$late10+$late11+$late12+$late13+$late14+$late15+$late16+$late17+$late18+$late19+$late20+$late21+$late22+$late23+$late24+$late25+$late26+$late27+$late28+$late29+$late30+$late31;



