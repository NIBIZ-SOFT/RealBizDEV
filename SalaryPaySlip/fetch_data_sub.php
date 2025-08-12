<style>
.title {
	font-size: 19px;
	border-bottom: 1px solid black;
	padding-bottom: 10px;
	width: 70%;
}
</style>

<?php

if(isset($_POST['get_sub_option']))
{
 $datemonth = $_POST['get_sub_option'];
}

?>

 <?php
 $find=mysql_query("select * from tblsalary where MonthYear='$datemonth'");
 $row=mysql_fetch_assoc($find);
 echo $row['UserID'];
 ?>
 
   <!--<table border="1" style="width: 100%;text-align: center;">
		  <tr>
		    <td><?php// echo $datemonth; ?><?php //echo $dateyear; ?></td>
		    <td>10</td>
		  </tr>
		  
		  <tr>
		    <td>Holiday</td>
		    <td>10</td>
		  </tr>		

		  <tr>
		    <td>Present</td>
		    <td>10</td>
		  </tr>
		  
		  <tr>
		    <td>Leave</td>
		    <td>10</td>
		  </tr>	

		  <tr>
		    <td>Late</td>
		    <td>10</td>
		  </tr>
		  
		  <tr>
		    <td>OverTime</td>
		    <td>10</td>
		  </tr>
		  
		  <tr>
		    <td>Early Leaving</td>
		    <td>10</td>
		  </tr>
		  
		</table> -->



