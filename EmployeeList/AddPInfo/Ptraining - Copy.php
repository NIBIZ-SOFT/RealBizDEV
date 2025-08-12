<?php

$UserReport =  SQL_Select("user","UserIsActive=1 and UserID>2");
foreach($UserReport as $ThisUserReport){
$Se_UserId=$ThisUserReport['UserID'];
 $OptionUserHTML.='
 <option value="'.$ThisUserReport['UserID'].'">'.$ThisUserReport['FullName'].'</option>	 
 ';
}	
$MainContent.='
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<div class="container Training" style="background-color: springgreen;width: 97%;padding: 17px;">
  <div class="panel panel-default">
    <div class="panel-heading">
	    <p style="font-size: 20px;margin-top: 16px;color: blueviolet;border-bottom: 1px solid black;padding-bottom: 11px;width: 25%;">Add Employee Training</p>
	</div>
    <div class="panel-body">
       <form action="index.php?Theme=default&Base=Users&Script=TrainingInsert" method="post" >
		  
		<table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="width: 50%;float: left;">
			   Employee Name<br/>
			    <select name="UserID">
				  <option value="">Select Employee</option>
                 '.$OptionUserHTML.'
				</select>
			 </td>
		     <td style="text-align: right;float: right;width: 50%;margin-top: -95px;">
			   <a href="index.php?Theme=default&Base=Users&Script=home&uc=4&ql=4" style="background-color: #e14d4d;color: white;padding: 8px 9px;font-size: 18px;border-radius: 8px;text-decoration: none;">All Employee Training List</a>
			 </td>
		  </tr>
		</table>
		
      	<div class="input-group control-group after-add-more">
		  <table style="width:100%; margin:0 auto">
		     <tr style="width: 100%;">
			    <td style="width: 25%;">
				  Course Name<br/>
                  <input type="text" name="CourseName[]" class="form-control" placeholder="Course Name" style="width:88%;">
				</td>
			    <td style="width: 16%;">
				  InstituteName<br/>
                  <input type="text" name="InstituteName[]" class="form-control" placeholder="Institute Name" style="width:80%;">
				</td>	

				<td style="width: 16%;">
				  Course Duration<br/>
                  <input type="text" name="CourseDuration[]" class="form-control" placeholder="Course Duration" style="width:80%;">
				</td>

				<td style="width: 33%;">
				  Course Remarks<br/>
                  <input type="text" name="CourseRemarks[]" class="form-control" placeholder="Remarks" style="width:80%;">
				</td>
			
				<td style="padding-top: 10px;width: 48%;padding-left: 23px;">
				 <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i>+ Add</button>
				</td>
			 </tr>
		  </table>
        </div>
		
	   <table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="text-align: right;float: right;width: 50%;margin-top:0px;">
			   <input type="submit" name="save_training" value="Save Training" style="background-color: snow;padding: 7px;font-size: 21px;border-radius: 6px;"/>
			 </td>
		  </tr>
		</table>
		
        </form>


        <!-- Copy Fields -->

        <div class="copy hide">
          <div class="control-group input-group" style="margin-top:10px">
		 
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

				<td style="padding-top:0px;width: 48%;padding-left: 22px;">
                 <button class="btn btn-danger remove" type="button" style="margin-top: -9px;"><i class="glyphicon glyphicon-remove"></i>- Drop</button>
				</td>			
			 </tr>
		  </table>
		  
				
          </div>
        </div>


    </div>

  </div>

</div>


<script type="text/javascript">


    $(document).ready(function() {


      $(".add-more").click(function(){ 

          var html = $(".copy").html();

          $(".after-add-more").after(html);

      });


      $("body").on("click",".remove",function(){ 

          $(this).parents(".control-group").remove();

      });


    });
	
	
</script>
';