<?php

$data=$_GET['data'];
$thisdata=SQL_Select("user","UserID='$data'","",true,"","",false,"");

echo '<input type="text" name="Department" required readonly value="'.$thisdata['Department'].'" />';