<?php

//$UserReport =  SQL_Select("user","UserIsActive=1 and UserID>2 and !QulificationsOn>0");
$UserReport =  SQL_Select("user","UserIsActive=1 and UserID>2");
foreach($UserReport as $ThisUserReport){
$Se_UserId=$ThisUserReport['UserID'];

$Data=SQL_Select("training","UserID=$Se_UserId","",true,"","",false,"");
if($Data){

}else{
	$OptionUserHTML.='
	<option value="'.$ThisUserReport['UserID'].'">'.$ThisUserReport['FullName'].'</option>	 
	';
}


}

	 
$MainContent.='

<div class="container Qulifications Training" style="background-color: rgb(200, 237, 218);width: 97%;padding: 17px;">
  <div class="panel panel-default">
     <div class="panel-heading">
	    <p style="font-size: 20px;margin-top: 16px;color: blueviolet;border-bottom: 1px solid black;padding-bottom: 11px;width: 25%;">Add Employee Training</p>
	</div>
<div class="qlifation_css">


  <div style="margin-bottom:20px; margin-top:20px">
  <button class="btn btn-success add-more" data-duplicate-add="Qulifications">+ Add Training</button>
  <button class="btn btn-danger add-more" data-duplicate-remove="Qulifications">- Remove ASC Wise Data</button>  
  </div>

       <form action="index.php?Theme=default&Base=Users&Script=TrainingInsert" method="post" >
		<table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="width: 50%;float: left; padding-bottom: 20px;">
			    <select class="UserID" name="UserID" required id="qulifications_id_check">
				  <option value="">Select Employee</option>
                 '.$OptionUserHTML.'
				</select>
			 </td>
			 	 
		      <td style="text-align: right;float: right;width: 50%;margin-top: -95px;">
			   <a href="index.php?Theme=default&Base=Users&Script=home&uc=4&ql=4" style="background-color: #e14d4d;color: white;padding: 8px 9px;font-size: 18px;border-radius: 8px;text-decoration: none;">All Employee Training List</a>
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