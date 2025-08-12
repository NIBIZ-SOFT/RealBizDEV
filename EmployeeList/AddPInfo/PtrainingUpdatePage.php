<?php

$sqid=$_REQUEST['sqid'];
mysql_query("DELETE FROM tbltraining WHERE TrainingID=$sqid");



$TrainingUp=$_REQUEST['TrainingUp'];
$QReport =  SQL_Select("training","UserID=$TrainingUp order by TrainingID asc");
foreach($QReport as $ThisQReport){
	
$TupdateHTML.='
        <div class="">
          <div class="control-group input-group" style="margin-top:10px">
           <table style="width:100%; margin:0 auto">
		     <tr style="width: 100%;">
			    <td style="width: 25%;">
				  Course Name<br/>
                  <input type="hidden" name="TrainingID[]" value="'.$ThisQReport['TrainingID'].'" class="form-control" placeholder="Course Name" style="width:88%;">
                  <input type="text" name="CourseName[]" value="'.$ThisQReport['CourseName'].'" class="form-control" placeholder="Course Name" style="width:88%;">
				</td>
			    <td style="width: 16%;">
				  InstituteName<br/>
                  <input type="text" name="InstituteName[]" value="'.$ThisQReport['InstituteName'].'" class="form-control" placeholder="Institute Name" style="width:80%;">
				</td>	

				<td style="width: 16%;">
				  Course Duration<br/>
                  <input type="text" name="CourseDuration[]" value="'.$ThisQReport['CourseDuration'].'" class="form-control" placeholder="Course Duration" style="width:80%;">
				</td>

				<td style="width: 29%;">
				  Course Remarks<br/>
                  <input type="text" name="CourseRemarks[]" value="'.$ThisQReport['CourseRemarks'].'" class="form-control" placeholder="Remarks" style="width:80%;">
				</td>
				
				<td style="width: 48%;padding-left: 23px;float: left;margin-top: 23px;">
				   <a href="index.php?Theme=default&Base=Users&Script=home&tup=4&TrainingUp='.$ThisQReport['UserID'].'&sqid='.$ThisQReport['TrainingID'].'"  style="color: white;text-decoration: none;background-color: #d24444;padding: 6px 12px;border: 1px solid #d24444;border-radius: 6px;">- Drop</a>
				</td>
			 </tr>
		  </table>

          </div>
        </div>
';
}



$sqrow=mysql_query("select distinct UserID from tbltraining where UserID='$TrainingUp'");
$Thissqrow=mysql_fetch_array($sqrow);
$cuse=$Thissqrow['UserID'];

$Usersqrow=mysql_query("select * from tbluser where UserID='$cuse'");
$ThisUsersqrow=mysql_fetch_array($Usersqrow);





$UserReport =  SQL_Select("user","UserIsActive=1 and UserID>2");
foreach($UserReport as $ThisUserReport){
$Se_UserId=$ThisUserReport['UserID'];
 $OptionUserHTML.='
 <option value="'.$ThisUserReport['UserID'].'">'.$ThisUserReport['FullName'].'</option>	 
 ';
}
	
$MainContent.='


   <style>
   .trining{
	 background: -moz-linear-gradient(center top , #FFFFFF 5%, #2EEF52 100%) repeat scroll 0 0 #FFFFFF;
   }
   </style>

<div class="container Qulifications Training" style="background-color: rgb(200, 237, 218);width: 97%;padding: 17px;">
  <div class="panel panel-default">
     <div class="panel-heading">
	    <p style="font-size: 20px;margin-top: 16px;color: blueviolet;border-bottom: 1px solid black;padding-bottom: 11px;width: 40%;">Add Employee Training Update Page</p>
	</div>
<div class="qlifation_css">



	    <form action="index.php?Theme=default&Base=Users&Script=TrainingInsert" method="post" >	  
		<table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="width: 50%;float: left;">
			   Employee Name<br/>
			    <select name="UserID">
				  <option value="'.$cuse.'">'.$ThisUsersqrow['FullName'].'</option>
				</select>
			 </td>
			 
			 <td style="text-align: right;float: right;width: 50%;margin-top: -95px;">
			   <a href="index.php?Theme=default&Base=Users&Script=home&uc=4&ql=4" style="background-color: #e14d4d;color: white;padding: 8px 9px;font-size: 18px;border-radius: 8px;text-decoration: none;">All Employee Training List</a>
			 </td>
			 
		  </tr>
		</table>
	
	   '.$TupdateHTML.'
	   <table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="text-align: right;float: right;width: 50%;margin-top:0px;">
			   <input type="submit" name="Update_training" value="Update Training" style="background-color: snow;padding: 7px;font-size: 21px;border-radius: 6px;"/>
			 </td>
		  </tr>
		</table>	
	   </form>







  <div style="margin-bottom:20px; margin-top:20px">
  <button class="btn btn-success add-more" data-duplicate-add="Qulifications">+ Add Training</button>
  <button class="btn btn-danger add-more" data-duplicate-remove="Qulifications">- Remove ASC Wise Data</button>  
  </div>

       <form action="index.php?Theme=default&Base=Users&Script=TrainingInsert" method="post" >
		<table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="width: 50%;float: left; display:none">
			    <select name="UserID" required id="qulifications_id_check">
				  <option value="'.$cuse.'">'.$ThisUsersqrow['FullName'].'</option>
				</select>
			 </td>
		  </tr>
		</table>


  <div data-duplicate="Qulifications">
		  <table style="width:100%; margin:0 auto">
		     <tr style="width: 100%;">
			    <td style="width: 25%;">
                  <input type="text" name="CourseName[]" class="form-control" placeholder="Course Name" style="width:88%;">
				</td>
			    <td style="width: 16%;">
                  <input type="text" name="InstituteName[]" class="form-control" placeholder="Institute Name" style="width:80%;">
				</td>	

				<td style="width: 16%;">
                  <input type="text" name="CourseDuration[]" class="form-control" placeholder="Course Duration" style="width:80%;">
				</td>

				<td style="width: 33%;">
                  <input type="text" name="CourseRemarks[]" class="form-control" placeholder="Remarks" style="width:80%;">
				</td>
			
				<td style="padding-top: 10px;width: 48%;padding-left: 23px;">
				  <a class="btn btn-danger add-more" data-duplicate-remove="Qulifications"  style="margin-top: -10px;">Drop</a>
				</td>
			 </tr>
		  </table>
		
  </div>
  
  
  		 <table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="text-align: right;float: right;width: 50%;margin-top:10px;">
			   <input type="submit" name="save_training" value="Save Training" style="background-color: snow;padding: 7px;font-size: 21px;border-radius: 6px;"/>
			 </td>
		  </tr>
		</table>	
       </form>
</div>  <!-- end qlifation_css -->

</div>
</div>
';