<?php

$data=$_GET['data'];
$thisdata=SQL_Select("user","UserID='$data' and taxstatus='Active'","",true,"","",false,"");

if($thisdata){
echo '<input type="text" name="Tax" required  value="'.$thisdata['Tax'].'" />';
}else{
 echo '<input type="text" name="Tax" required readonly  />';
}