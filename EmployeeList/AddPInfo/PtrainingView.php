<?php

$qrow=mysql_query("select distinct UserID from tbltraining");
while($Thisqrow=mysql_fetch_array($qrow)){
	$UserID=$Thisqrow['UserID'];
	$Data=mysql_query("select * from tbluser where UserID='$UserID' ");
    $ThisData=mysql_fetch_assoc($Data);
	
$TTLreportHTML.='
  <tr>
     <th>'.$ThisData['FullName'].'</th>
     <th>'.$ThisData['PhoneNo'].'</th>
     <th>'.$ThisData['Email'].'</th>
     <th><a href="index.php?Theme=default&Base=Users&Script=home&tup=4&TrainingUp='.$Thisqrow['UserID'].'">View Details</a></th>
  </tr>
';
}

 $MainContent.='
   <style>
   .trining{
	 background: -moz-linear-gradient(center top , #FFFFFF 5%, #2EEF52 100%) repeat scroll 0 0 #FFFFFF;
   }
   </style>
  <div class="row-fluid">
     <div class="span12">
         <!-- block -->	
         <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left btn btn-info">All Employee Training List Report</div>
                <div class="pull-right"><span class="badge badge-info"><a style="color: white;font-size: 16px;" href="index.php?Theme=default&Base=Users&Script=home">Back To Page</a></span>
          </div>
         </div>
      <div class="block-content collapse in">
								
        <table class="table table-striped table-bordered" id="example1">
            <thead>
              <tr style="background-color: #119e11;color: white;">
		         <th>Empolye Name</th>                                             
		         <th>Phone Number</th>                                             
		         <th>Email</th>                                             
                 <th>View Details</th>
               </tr>
            </thead>
            <tbody>
               '.$TTLreportHTML.'
            </tbody>
         </table>
       </div>
     </div>
  <!-- /block -->
  </div>
  </div>
  ';
