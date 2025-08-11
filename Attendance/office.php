<?php 

for($in=0;$in<=23;$in++)
{
  $insertHTML.='
   <option>'.$in.'</option>
  ';
} 

for($out=0;$out<=60;$out++)
{
  $logoutHTML.='
   <option>'.$out.'</option>
  ';
}
$MainContent.='
   <style>
.attendance {
	background-color: #F5F5F5;
	width: 91%;
}
.attendance p {
	font-size: 17px;
	padding-left: 7px;
	padding-top: 14px;
	margin: 0px;
}
</style>

<div class="container">
  <div class="attendance">
     <p>Mange Attendance Office Time set<p>
  </div>

  <table>
    <tr>
	   <td> 
           <td> <input type="checkbox" name="Friday" value="1" />Friday </td>		
           <td><input type="checkbox" name="Saturday" value="1"/>Saturday </td>		
           <td><input type="checkbox" name="Sunday" value="1" />Sunday </td>		
           <td><input type="checkbox" name="Sunday" value="1" />Sunday </td>		
           <td><input type="checkbox" name="Tuesday" value="1" />Tuesday </td>		
           <td><input type="checkbox" name="Wednesday" value="1" />Wednesday </td>		
           <td><input type="checkbox" name="Thursday" value="1" />Thursday </td>		
	</tr>    



	<tr>
	   <td colspan="7"> Employe Name  <br/>
	   		<select name="InsertHour">
			   '.$insertHTML.'
			</select>		
	   </td>
	</tr>   

	<tr>
	   <td colspan="7"> Ofice Time set(Hour-Secnod)  <br/>
	   		<select name="InsertHour" style="max-width: 53px;">
			   '.$insertHTML.'
			</select>		
			<select name="InsertSecnod" style="max-width: 53px;">
			   '.$logoutHTML.'
			</select>	
	   </td>
	</tr>
	
  </table>
  
</div>  
';