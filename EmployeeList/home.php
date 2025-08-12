<?php

$MainContent.='
<body  marginheight="0" marginwidth="0">
	<div class="TopBar">	
	</div>
	
	<div class="TopBox" style="padding:10px;background-color:#E7F5F8;">
		

		
		<a href="index.php?Theme=default&Base=Branch&Script=Manage" style="text-decoration:none">
			<span class="TopButton" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/branch.png" align="left" style="margin-right: 25px;">
				 Employee Section<br>Branch Name Manage
			</span>
		</a>
		
		
		<a href="index.php?Theme=default&Base=Department&Script=Manage" style="text-decoration:none">
			<span class="TopButton" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/ppt.png" align="left" style="margin-right: 25px;">
				 Employee Section<br>Department Manage
			</span>
		</a>		
		
		
		
		<a href="index.php?Theme=default&Base=Designation&Script=Manage" style="text-decoration:none">
			<span class="TopButton" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/Community Help.png" align="left" style="margin-right: 25px;">
				 Employee Section<br>Designation Manage
			</span>
		</a>		
			
	</div>
';



$MainContent.='
<body  marginheight="0" marginwidth="0">
	<div class="TopBar">	
	</div>
	
	<div class="TopBox" style="padding:10px;background-color:#E7F5F8;">
		
		<!--
		<a href="index.php?Theme=default&Base=Users&Script=home" style="text-decoration:none">
			<span class="TopButton att_home" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">
				<img height="32" src="./theme/default/images/Users_Group.png" align="left" style="margin-right: 25px;">
				 HRM Module<br> Home Page
			</span>
		</a>
        -->
		
		
		<a href="index.php?Theme=default&Base=Users&Script=Manage" style="text-decoration:none">
			<span class="TopButton att_home" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/ss.png" align="left" style="margin-right: 25px;">
				 Employee Section<br>Personal Details
			</span>
		</a>
		
		
		<a href="index.php?Theme=default&Base=Users&Script=home&uc=2" style="text-decoration:none">
			<span class="TopButton quli" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/alist.png" align="left" style="margin-right: 25px;">
				 Employee Section<br>Qulifications
			</span>
		</a>		
		
		
		
		<a href="index.php?Theme=default&Base=Users&Script=home&uc=4" style="text-decoration:none">
			<span class="TopButton trining" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/order.png" align="left" style="margin-right: 25px;">
				 Employee Section<br>Tranning
			</span>
		</a>		
		
		
		<a href="index.php?Theme=default&Base=Users&Script=home&uc=3" style="text-decoration:none">
			<span class="TopButton ref_home" style="text-align:center">
			    
				<!--<img height="32" src="./theme/default/images/packing.png">-->
				<img height="32" src="./theme/default/images/patt.png" align="left" style="margin-right: 25px;">
				 Employee Section<br>Reference
			</span>
		</a>	
	</div>
';


$UserCheckReport=$_REQUEST['uc'];
if($UserCheckReport==''){
  //echo "Home page";	
}elseif($UserCheckReport==1){
  echo "personal details";	
}elseif($UserCheckReport==2){
 // echo "Qulifications";
 
//$UserReport =  SQL_Select("user","UserIsActive=1 and UserID>2 and !QulificationsOn>0");
$UserReport =  SQL_Select("user","UserIsActive=1 and UserID>2");
foreach($UserReport as $ThisUserReport){
$Se_UserId=$ThisUserReport['UserID'];

$Data=SQL_Select("qulifications","UserID=$Se_UserId","",true,"","",false,"");
if($Data){

}else{
	$OptionUserHTML.='
	<option value="'.$ThisUserReport['UserID'].'">'.$ThisUserReport['FullName'].'</option>	 
	';
}


}




$DegreeReport =  SQL_Select("adddegree","AdddegreeIsActive=1");
foreach($DegreeReport as $ThisDegreeReport){
	$OptiondegreeHTML.='
	<option value="'.$ThisDegreeReport['DegreeName'].'">'.$ThisDegreeReport['DegreeName'].'</option>	 
	';
}


	 
$MainContent.='

<style>
.quli{
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #2EEF52 100%) repeat scroll 0 0 #FFFFFF;
}
</style>

<div class="container Qulifications" style="background-color: rgb(200, 237, 218);width: 97%;padding: 17px;">
  <div class="panel panel-default">
     <div class="panel-heading">
	    <p style="font-size: 20px;margin-top: 16px;color: blueviolet;border-bottom: 1px solid black;padding-bottom: 11px;width: 25%;">Add Employee Qulifications</p>
	</div>
<div class="qlifation_css">


  <div style="margin-bottom:20px; margin-top:20px">
  <button class="btn btn-success add-more" data-duplicate-add="Qulifications">+ Add Qulifications</button>
  <button class="btn btn-danger add-more" data-duplicate-remove="Qulifications">- Remove ASC Wise Data</button>

  <!-- <a class="btn btn-info" href="index.php?Theme=default&Base=Adddegree&Script=Manage">Add Degree</a> -->
 
  </div>

      <form action="index.php?Theme=default&Base=Users&Script=QulificationsInsert" method="post" >  
		<table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="width: 50%;float: left;padding-bottom: 20px;">
			    <select class="UserID" name="UserID" required id="qulifications_id_check">
			        <option value="">Select Employee</option>
                    '.$OptionUserHTML.'
				</select>
			 </td>
			 	 
		     <td style="text-align: right;float: right;width: 50%;margin-top: -95px;">
			   <a href="index.php?Theme=default&Base=Users&Script=home&ql=1" style="background-color: #e14d4d;color: white;padding: 8px 9px;font-size: 18px;border-radius: 8px;text-decoration: none;">All Employee Qulifications List</a>
			 </td>
		  </tr>
		</table>


  <div data-duplicate="Qulifications">
		<table style="width:100%; margin:0 auto">
		<tr style="width: 100%;">
		<td style="width: 25%;padding-bottom: 12px;">
		
		
		<input type="text" name="CourseName[]" class="form-control" placeholder="Degree" style="width:88%;">
		


		
		
		
		</td>
		<td style="width: 16%;">
		<input type="text" name="CourseDuration[]" class="form-control" placeholder="Department/Group" style="width:80%;">
		</td>
		<td style="width: 13%;">
		<input type="text" name="PassingYear[]" class="form-control" placeholder="Passing Year" style="width:73%">
		</td>
		<td style="width: 20%;">
		<input type="text" name="Board_University[]" class="form-control" placeholder="Board/University" style="width: 87%;">      
		</td>
		<td style="width: 7%;">
		<input type="text" name="Result[]" class="form-control" placeholder="result" style="width:97%">
		</td>

		<td style="padding-top:0px;width: 48%;padding-left: 23px;">
             <a class="btn btn-danger add-more" data-duplicate-remove="Qulifications"  style="margin-top: -10px;">Drop</a>
		</td>
		</tr>
		</table>	
  </div>
  
  
  		 <table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="text-align: right;float: right;width: 50%;margin-top:10px;">
			   <input type="submit" name="save_Qulifications" value="Save Qulifications" style="background-color: snow;padding: 7px;font-size: 21px;border-radius: 6px;"/>
			 </td>
		  </tr>
		</table>	
       </form>
</div>  <!-- end qlifation_css -->

</div>
</div>
';
 
}elseif($UserCheckReport==3){
  //echo "referance";

$UserReport =  SQL_Select("user","UserIsActive=1 and UserID>2");
foreach($UserReport as $ThisUserReport){
$Se_UserId=$ThisUserReport['UserID'];
 $OptionUserHTML.='
 <option value="'.$ThisUserReport['UserID'].'">'.$ThisUserReport['FullName'].'</option>	 
 ';
}	   
  
$MainContent.='
<style>
.ref_home{
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #2EEF52 100%) repeat scroll 0 0 #FFFFFF;
}
</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<div class="container Qulifications" style="background-color: rgb(200, 237, 218);width: 97%;padding: 17px;">
  <div class="panel panel-default">
    <div class="panel-heading">
	    <p style="font-size: 20px;margin-top: 16px;color: blueviolet;border-bottom: 1px solid black;padding-bottom: 11px;width: 25%;">Add Employee Referance</p>
	</div>
    <div class="panel-body">
       <form action="index.php?Theme=default&Base=Users&Script=ReferanceInsert" method="post" >
		  
		<table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="width: 50%;float: left;">
			   Employee Name<br/>
			    <select class="UserID" name="UserID">
				  <option value="">Select Employee</option>
                 '.$OptionUserHTML.'
				</select>
			 </td>
		     <td style="text-align: right;float: right;width: 50%;margin-top: -95px;">
			   <a href="index.php?Theme=default&Base=Users&Script=home&ql=2" style="background-color: #e14d4d;color: white;padding: 8px 9px;font-size: 18px;border-radius: 8px;text-decoration: none;">All Employee Referance List</a>
			 </td>
		  </tr>
		</table>
		
      	<div class="input-group control-group after-add-more">
		  <table style="width:100%; margin:0 auto">
		     <tr style="width: 100%;">
			    <td style="width: 25%;">
				  Referance Name <br/>
                  <input type="text" name="ReferanceName[]" class="form-control" placeholder="" style="width:88%;">
				</td>
			    <td style="width: 16%;">
				  Phone Number<br/>
                  <input type="text" name="PhoneNumber[]" class="form-control" placeholder="" style="width:80%;">
				</td>	

				<td style="width: 16%;">
				  Email<br/>
                  <input type="text" name="Email[]" class="form-control" placeholder="" style="width:80%;">
				</td>
			    <td style="width: 14%;">
				 Referance Type<br/>
				 <select name="ReferanceType[]" style="width: 99%;">
				    <option>Education Reference</option>
				    <option>Professional Reference</option>
				    <option>Family Reference</option>
				    <option>Others Reference</option>
				 </select>
				</td>
			    <td style="width: 20%;">
				  Full Daitals<br/>
				  <textarea name="ReferanceFullDaitals[]" style="width: 100%; height:24px"></textarea>
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
			   <input type="submit" name="save_ref" value="Save Referance" style="background-color: snow;padding: 7px;font-size: 21px;border-radius: 6px;"/>
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
                  <input type="text" name="ReferanceName[]" class="form-control" placeholder="Course Name" style="width:88%;">
				</td>
			    <td style="width: 16%;">
                  <input type="text" name="PhoneNumber[]" class="form-control" placeholder="Course Duration" style="width:80%;">
				</td>	

				<td style="width: 16%;">
                  <input type="text" name="Email[]" class="form-control" placeholder="Course Duration" style="width:80%;">
				</td>
			    <td style="width: 14%;">
				 <select name="ReferanceType[]" style="width: 99%;">
				    <option>Education Reference</option>
				    <option>Professional Reference</option>
				    <option>Family Reference</option>
				    <option>Others Reference</option>
				 </select>
				</td>
			    <td style="width: 20%;">
				  <textarea name="ReferanceFullDaitals[]" style="width: 100%; height:24px"></textarea>
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
  
}elseif($UserCheckReport==4){
  $MainContent.='
   <style>
   .trining{
	 background: -moz-linear-gradient(center top , #FFFFFF 5%, #2EEF52 100%) repeat scroll 0 0 #FFFFFF;
   }
   </style>
  ';
  include("AddPInfo/Ptraining.php");  
}
else{
  echo "last Page";	
}



$qrow=mysql_query("select distinct UserID from tblqulifications");
while($Thisqrow=mysql_fetch_array($qrow)){
	$UserID=$Thisqrow['UserID'];
	$Data=mysql_query("select * from tbluser where UserID='$UserID' ");
    $ThisData=mysql_fetch_assoc($Data);
	
$QLreportHTML.='
  <tr>
     <th>'.$ThisData['FullName'].'</th>
	 <th>#'.$ThisData['UserID'].'</th>
     <th>'.$ThisData['PhoneNo'].'</th>
     <th>'.$ThisData['Email'].'</th>
     <th><a href="index.php?Theme=default&Base=Users&Script=home&qlc=1&qlu='.$Thisqrow['UserID'].'">View Details</a></th>
  </tr>
';
}




$ql=$_REQUEST['ql'];
if($ql==1){
 $MainContent.='
   <style>
    .list {
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #28CF24 100%) repeat scroll 0 0 #FFFFFF;
     }
	.quli {
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #2EEF52 100%) repeat scroll 0 0 #FFFFFF;
     } 	 
   </style>
  <div class="row-fluid">
     <div class="span12">
         <!-- block -->	
         <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left">Qualifications <span style="color:green"></span>Report</div>
                <div class="pull-right"><span class="badge badge-info"><a style="color: white;font-size: 16px;" href="index.php?Theme=default&Base=Users&Script=home">Back To Page</a></span>
          </div>
         </div>
      <div class="block-content collapse in">
								
        <table class="table table-striped table-bordered" id="example1">
            <thead>
              <tr style="background-color: #119e11;color: white;">
		         <th>Empolye Name</th> 
                 <th>Company ID</th>				 
		         <th>Phone Number</th>                                             
		         <th>Email</th>                                             
                 <th>View Details</th>
               </tr>
            </thead>
            <tbody>
               '.$QLreportHTML.'
            </tbody>
         </table>
       </div>
     </div>
  <!-- /block -->
  </div>
  </div>
  ';
}


if($ql==4){
	
 $MainContent.='
   <style>	
    .Training{
		display:none;
    }
   </style>
  ';
 include("AddPInfo/PtrainingView.php");  	
}








$qlc=$_REQUEST['qlc'];
if($qlc==1){

$sqid=$_REQUEST['sqid'];
mysql_query("DELETE FROM tblqulifications WHERE QulificationsID=$sqid");


$qlu=$_REQUEST['qlu'];
$QReport =  SQL_Select("qulifications","UserID=$qlu order by QulificationsID asc");
foreach($QReport as $ThisQReport){
	
$QupdateHTML.='
        <div class="">
          <div class="control-group input-group" style="margin-top:10px">
           <table style="width:100%; margin:0 auto">
		     <tr style="width: 100%;">
			    <td style="width: 25%;">
                  <input type="hidden" name="QulificationsID[]" value="'.$ThisQReport['QulificationsID'].'" class="form-control" placeholder="Degree" style="width:88%;">
                  <input type="text" readonly name="CourseNameU[]" value="'.$ThisQReport['CourseName'].'" class="form-control" placeholder="Department/Group" style="width:88%;">
				</td>
			    <td style="width: 16%;">
                  <input type="text" name="CourseDurationU[]" value="'.$ThisQReport['CourseDuration'].'" class="form-control" placeholder="Course Duration" style="width:80%;">
				</td>
			    <td style="width: 13%;">
		         <input type="text" name="PassingYearU[]" value="'.$ThisQReport['PassingYear'].'"  class="form-control" placeholder="Passing Year" style="width:73%">
				</td>
			    <td style="width: 20%;">
				<input type="text" name="Board_UniversityU[]" value="'.$ThisQReport['Board_University'].'"  class="form-control" placeholder="Board/University" style="width: 87%;">      
				</td>
			    <td style="width: 7%;">
		          <input type="text" name="ResultU[]" value="'.$ThisQReport['Result'].'" class="form-control" placeholder="result" style="width:97%">
				</td>
				
				<td style="width: 48%;padding-left: 23px;float: left;margin-top: 5px;">
				   <a href="index.php?Theme=default&Base=Users&Script=home&qlc=1&qlu='.$ThisQReport['UserID'].'&sqid='.$ThisQReport['QulificationsID'].'"  class="btn btn-danger add-more">Drop</a>
				</td>
			 </tr>
		  </table>

          </div>
        </div>
';
}

$sqrow=mysql_query("select distinct UserID from tblqulifications where UserID=$qlu");
$Thissqrow=mysql_fetch_array($sqrow);
$cuse=$Thissqrow['UserID'];

$Usersqrow=mysql_query("select * from tbluser where UserID=$cuse");
$ThisUsersqrow=mysql_fetch_array($Usersqrow);



$DegreeReport =  SQL_Select("adddegree","AdddegreeIsActive=1");
foreach($DegreeReport as $ThisDegreeReport){
	$OptiondegreeHTML.='
	<option value="'.$ThisDegreeReport['DegreeName'].'">'.$ThisDegreeReport['DegreeName'].'</option>	 
	';
}


$MainContent.='

<style>
.quli{
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #2EEF52 100%) repeat scroll 0 0 #FFFFFF;
}
</style>

<div class="container Qulifications" style="background-color: rgb(200, 237, 218);width: 97%;padding: 17px;">
  <div class="panel panel-default">
     <div class="panel-heading">
	    <p style="font-size: 20px;margin-top: 16px;color: blueviolet;border-bottom: 1px solid black;padding-bottom: 11px;width: 45%;">Add Employee Qulifications Update Page</p>
	</div>
		
	
<div class="qlifation_css">


  <div style="margin-bottom:20px; margin-top:20px">
  <button class="btn btn-success add-more" data-duplicate-add="Qulifications">+ Add Qulifications</button>
  <button class="btn btn-danger add-more" data-duplicate-remove="Qulifications">- Remove ASC Wise Data</button>  
  </div>

       <form action="index.php?Theme=default&Base=Users&Script=QulificationsUpdate" method="post" >
		<table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="width: 50%;float: left;padding-bottom: 20px;">
			    <select class="UserID" name="UserID">
				  <option value="'.$cuse.'">'.$ThisUsersqrow['FullName'].'</option>
				</select>
			 </td>
		     <td style="text-align: right;float: right;width: 50%;margin-top: -95px;">
			   <a href="index.php?Theme=default&Base=Users&Script=home&ql=1" style="background-color: #e14d4d;color: white;padding: 8px 9px;font-size: 18px;border-radius: 8px;text-decoration: none;">All Employee Qulifications List</a>
			 </td>
		  </tr>
		</table>

    
	    '.$QupdateHTML.'
		
		
  <div data-duplicate="Qulifications">
		<table style="width:100%; margin:0 auto">
		<tr style="width: 100%;">
		<td style="width: 25%; padding-bottom: 12px;">
		
		
		<input type="text" name="CourseName[]" class="form-control" placeholder="Degree" style="width:88%;">
		
		

		
		</td>
		<td style="width: 16%;">
		<input type="text" name="CourseDuration[]" class="form-control" placeholder="Department/Group" style="width:80%;">
		</td>
		<td style="width: 13%;">
		<input type="text" name="PassingYear[]" class="form-control" placeholder="Passing Year" style="width:73%">
		</td>
		<td style="width: 20%;">
		<input type="text" name="Board_University[]" class="form-control" placeholder="Board/University" style="width: 87%;">      
		</td>
		<td style="width: 7%;">
		<input type="text" name="Result[]" class="form-control" placeholder="result" style="width:97%">
		</td>

		<td style="padding-top:0px;width: 48%;padding-left: 23px;">
             <a class="btn btn-danger add-more" data-duplicate-remove="Qulifications"  style="margin-top: -10px;">Drop</a>
		</td>
		</tr>
		</table>	
  </div>
  
  
  		 <table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="text-align: right;float: right;width: 50%;margin-top:10px;">
			   <input type="submit" name="update_Qulifications" value="Update Qulifications" style="background-color: snow;padding: 7px;font-size: 21px;border-radius: 6px;"/>
			 </td>
		  </tr>
		</table>	
       </form>
</div>  <!-- end qlifation_css -->

</div>
</div>
';
 	
}


if($ql==2){
 //echo "yes";
/* 
$Rrow=mysql_query("select * from tblreferance group by UserID");
while($ThisRrow=mysql_fetch_array($Rrow)){
$RreportHTML.='
  <tr>
     <th>'.$ThisRrow['ReferanceName'].'</th>
     <th>'.$ThisRrow['PhoneNumber'].'</th>
     <th>'.$ThisRrow['Email'].'</th>
     <th>'.$ThisRrow['ReferanceType'].'</th>
     <th><a href="index.php?Theme=default&Base=Users&Script=home&rud=1&rupdate='.$ThisRrow['UserID'].'">Edit</a></th>
  </tr>
';
}
*/

$qrow=mysql_query("select distinct UserID from tblreferance");
while($Thisqrow=mysql_fetch_array($qrow)){
	$UserID=$Thisqrow['UserID'];
	$Data=mysql_query("select * from tbluser where UserID='$UserID' ");
    $ThisData=mysql_fetch_assoc($Data);
	
$RreportHTML.='
  <tr>
     <th>'.$ThisData['FullName'].'</th>
     <th>'.$ThisData['PhoneNo'].'</th>
     <th>'.$ThisData['Email'].'</th>
     <th><a href="index.php?Theme=default&Base=Users&Script=home&rud=1&rupdate='.$Thisqrow['UserID'].'">View Details</a></th>
  </tr>
';
}


 
 $MainContent.='
   <style>
    .list {
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #28CF24 100%) repeat scroll 0 0 #FFFFFF;
     }
	.ref_home {
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #2EEF52 100%) repeat scroll 0 0 #FFFFFF;
     } 	 
   </style>
  <div class="row-fluid">
     <div class="span12">
         <!-- block -->	
         <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left btn btn-info">All Employee Referance List Report</div>
                <div class="pull-right"><span class="badge badge-info"><a style="color: white;font-size: 16px;" href="index.php?Theme=default&Base=Users&Script=home">Back To Page</a></span>
          </div>
         </div>
      <div class="block-content collapse in">
								
        <table class="table table-striped table-bordered" id="example1">
            <thead>
              <tr style="background-color: #119e11;color: white;">
		         <th>Referance Name</th>                                             
		         <th>Phone Number</th>                                             
		         <th>Email</th>                                             
                 <th>View Details</th>
               </tr>
            </thead>
            <tbody>
               '.$RreportHTML.'
            </tbody>
         </table>
       </div>
     </div>
  <!-- /block -->
  </div>
  </div>
  '; 
}



$rud=$_REQUEST['rud'];
if($rud==1){
	
//echo "Yes";

$sqid=$_REQUEST['sqid'];
mysql_query("DELETE FROM tblreferance WHERE ReferanceID=$sqid");


$rupdate=$_REQUEST['rupdate'];
$QReport =  SQL_Select("referance","UserID=$rupdate");
foreach($QReport as $ThisQReport){
$RupdateHTML.='
        <div class="">
          <div class="control-group input-group" style="margin-top:10px">
		 
		 <table style="width:100%; margin:0 auto">
		     <tr style="width: 100%;">
			    <td style="width: 25%;">
				  Referance Name <br/>
                  <input type="hidden" name="ReferanceID[]" value="'.$ThisQReport['ReferanceID'].'" class="form-control" placeholder="" style="width:88%;">
                  <input type="text" name="ReferanceName[]" value="'.$ThisQReport['ReferanceName'].'" class="form-control" placeholder="" style="width:88%;">
				</td>
			    <td style="width: 16%;">
				  Phone Number<br/>
                  <input type="text" name="PhoneNumber[]" value="'.$ThisQReport['PhoneNumber'].'"  class="form-control" placeholder="" style="width:80%;">
				</td>	

				<td style="width: 16%;">
				  Email<br/>
                  <input type="text" name="Email[]"  value="'.$ThisQReport['Email'].'"  class="form-control" placeholder="" style="width:80%;">
				</td>
			    <td style="width: 14%;">
				 Referance Type<br/>
				 <select name="ReferanceType[]" style="width: 99%;">
				    <option>'.$ThisQReport['ReferanceType'].'</option>
				    <option>Education Reference</option>
				    <option>Professional Reference</option>
				    <option>Family Reference</option>
				    <option>Others Reference</option>
				 </select>
				</td>
			    <td style="width: 20%;">
				  Full Daitals<br/>
				  <!--<input type="text" name="ReferanceFullDaitals[]"  value="'.$ThisQReport['ReferanceFullDaitals'].'"  class="form-control" placeholder="" style="width:96%;height: 127px;""> -->
				  <textarea name="ReferanceFullDaitals[]" style="width: 100%; height:24px">'.$ThisQReport['ReferanceFullDaitals'].'</textarea>
				</td>

				<td style="padding-top:0px;width: 48%;padding-left: 22px;">
                 <button class="btn btn-danger remove" type="button" style="margin-top: -9px;"><i class="glyphicon glyphicon-remove"></i>- Drop</button>
				</td>			
			 </tr>
		  </table>

          </div>
        </div>
';
}


$sqrow=mysql_query("select distinct UserID from tblreferance where UserID=$rupdate");
$Thissqrow=mysql_fetch_array($sqrow);
$cuse=$Thissqrow['UserID'];

$Usersqrow=mysql_query("select * from tbluser where UserID=$cuse");
$ThisUsersqrow=mysql_fetch_array($Usersqrow);


$MainContent.='
<style>
.ref_home {
	background: -moz-linear-gradient(center top , #FFFFFF 5%, #2EEF52 100%) repeat scroll 0 0 #FFFFFF;
}
</style>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<div class="container Qulifications" style="background-color: rgb(200, 237, 218);width: 97%;padding: 17px;">
  <div class="panel panel-default">
    <div class="panel-heading">
	    <p style="font-size: 20px;margin-top: 16px;color: blueviolet;border-bottom: 1px solid black;padding-bottom: 11px;width: 42%;">Add Employee Referance Update Page</p>
	</div>
    <div class="panel-body">
       <form action="index.php?Theme=default&Base=Users&Script=ReferanceUpdate" method="post" >
		  
		<table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="width: 50%;float: left;">
			   Employee Name<br/>
			    <select class="UserID" name="UserID">
				  <option value="'.$cuse.'">'.$ThisUsersqrow['FullName'].'</option>
				</select>
			 </td>
		     <td style="text-align: right;float: right;width: 50%;margin-top: -95px;">
			   <a href="index.php?Theme=default&Base=Users&Script=home&ql=2" style="background-color: #e14d4d;color: white;padding: 8px 9px;font-size: 18px;border-radius: 8px;text-decoration: none;">All Employee Referance List</a>
			 </td>
		  </tr>
		</table>
		
		
		<!--
      	<div class="input-group control-group after-add-more">
		  <table style="width:100%; margin:0 auto">
		     <tr style="width: 100%;">
			    <td style="width: 25%;">
				  Referance Name <br/>
                  <input type="text" name="ReferanceName[]" class="form-control"  style="width:88%;">
				</td>
			    <td style="width: 16%;">
				  Phone Number<br/>
                  <input type="text" name="PhoneNumber[]" class="form-control"  style="width:80%;">
				</td>	

				<td style="width: 16%;">
				  Email<br/>
                  <input type="text" name="Email[]" class="form-control"  style="width:80%;">
				</td>
			    <td style="width: 14%;">
				 Referance Type<br/>
				 <select name="ReferanceType[]" style="width: 99%;">
				    <option>Education Reference</option>
				    <option>Professional Reference</option>
				    <option>Family Reference</option>
				    <option>Others Reference</option>
				 </select>
				</td>
			    <td style="width: 20%;">
				  Full Daitals<br/>
				  <input type="text" name="ReferanceFullDaitals[]"  value="'.$ThisQReport['ReferanceFullDaitals'].'"  class="form-control" placeholder="" style="width:96%;height: 127px;"">
				</td>

				
				<td style="padding-top: 10px;width: 48%;padding-left: 23px;">
				 <button class="btn btn-success add-more" type="button"><i class="glyphicon glyphicon-plus"></i>+ Add</button>
				</td>
			 </tr>
		  </table>
        </div>
		-->
		'.$RupdateHTML.'
		
				
	     <table style="width: 100%;">
		  <tr style="width: 100%;">
		     <td style="text-align: right;float: right;width: 50%;margin-top:0px;">
			   <input type="submit" name="update_ref" value="Update Referance" style="background-color: snow;padding: 7px;font-size: 21px;border-radius: 6px;"/>
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
				  Referance Name <br/>
                  <input type="text" name="ReferanceName[]" class="form-control" placeholder="" style="width:88%;">
				</td>
			    <td style="width: 16%;">
				  Phone Number<br/>
                  <input type="text" name="PhoneNumber[]" class="form-control" placeholder="" style="width:80%;">
				</td>	

				<td style="width: 16%;">
				  Email<br/>
                  <input type="text" name="Email[]" class="form-control" placeholder="" style="width:80%;">
				</td>
			    <td style="width: 14%;">
				 Referance Type<br/>
				 <select name="ReferanceType[]" style="width: 99%;">
				    <option>Education Reference</option>
				    <option>Professional Reference</option>
				    <option>Family Reference</option>
				    <option>Others Reference</option>
				 </select>
				</td>
			    <td style="width: 20%;">
				  Full Daitals<br/>
				  <textarea name="ReferanceFullDaitals[]" style="width: 100%;"></textarea>
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
}


$tup=$_REQUEST['tup'];
if($tup==4){
 $MainContent.='
   <style>	
   </style>
  ';
 include("AddPInfo/PtrainingUpdatePage.php");  	
	
}




$MainContent.='	
</body>	
';