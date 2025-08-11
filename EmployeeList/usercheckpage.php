<?php

$data=$_GET['data'];

$UserData=SQL_Select("user","UserName='$data'","",true,"","",false,"");
if($UserData){
 echo "<input type=\"text\" class=\"DatePicker form-control\" onchange=\"usernamecheck(this.value)\" required id=\"UserName\" name=\"UserName\" value=\"{$TheEntityName["UserName"]}\"/><span style=\"color: red; position: absolute; padding-top: 0px;\"> --<span style=\"color:green\">{$data}</span>--  Already Token</span>";
}else{
 echo "<input type=\"text\" class=\"DatePicker form-control\" onchange=\"usernamecheck(this.value)\" required id=\"UserName\" name=\"UserName\" value=\"{$data}\"/>";
}
