<?php

$data=$_GET['data'];
$thisdata=SQL_Select("user","UserID='$data' and pffundstatus='Active'","",true,"","",false,"");

if($thisdata){
echo '<input type="text" name="PFund" required  value="'.$thisdata['PFund'].'" />';
}else{
 echo '<input type="text" name="PFund" required readonly  />';
}