	
<?php



    $UserData =  SQL_Select("user","taxstatus='InActive' || taxstatus=''");
    foreach($UserData as $ThisUserData){
    
    $BasicSalary=$ThisUserData['BasicSalary'];
      iF($BasicSalary<16000){

      }else{
      $userHTML.='
        <option value="'.$ThisUserData['UserID'].'">'.$ThisUserData['FullName'].'</option>
      ';
      }
    }





  if(isset($_POST['username'])){

            $username=$_POST['username'];

            $Where="UserID=$username";
            $TheEntityName=SQL_InsertUpdate(
            $Entity="user",
            $TheEntityNameData=array(                                                                                             
              "taxsetupdate"=>$_POST["taxsetupdate"],
              "taxstatus"=>$_POST["taxstatus"],
            ),
            $Where
            );

      
      }



    $Data = SQL_Select("user","taxstatus='Active'");
    foreach($Data as $ThisData){
      $taxhtml.='
          <tr>
          <td> '.$ThisData['FullName'].'    </td>
          <td> '.$ThisData['UserID'].'  </td>
          <td> '.$ThisData['BranchName'].'  </td>
          <td> '.$ThisData['Department'].'  </td>
          <td> '.$ThisData['Designation'].' </td>
          <td> '.$ThisData['BasicSalary'].' </td>
          <td> '.$ThisData['Tax'].' </td>
          <td> '.$ThisData['taxsetupdate'].' </td>
          <td>
           <a style="color:blue">'.$ThisData['taxstatus'].'</a> /
           <a  href="index.php?Theme=default&Base=SalaryPaySlip&Script=EmployeeTax&upid='.$ThisData['UserID'].'" style="cursor:pointer;color:green">View</a>
          </td>
          </tr>
      ';
  
    }




   /*  update page */

   $update=$_GET['upid'];     
   if($update){


  $SingleData=SQL_Select("user","UserID='$update'","",true,"","",false,"");


        /* update PF section */
   $actionhtnl.='
        <form action="index.php?Theme=default&Base=SalaryPaySlip&Script=EmployeeTax" method="post">
        <table style="text-align:center; width:70%;
         margin:0 auto;margin-top:20px; ">
          <tr>
             <td>
                Empolyee Name <br/>
                <input type="text" readonly required value="'.$SingleData['FullName'].'" />
                <input type="hidden" readonly required value="'.$SingleData['UserID'].'" name="username" id="username" class="username" />
             </td>
             <td>
                 Setup Date<br/>
                <input type="text" required value="'.$SingleData['taxsetupdate'].'" name="taxsetupdate" id="taxsetupdate" class="taxsetupdate" />
             </td>
             <td>
                Setup Satus<br/>
                <select name="taxstatus" required>
                   <option value="'.$SingleData['taxstatus'].'">Setup '.$SingleData['taxstatus'].'</option>
                   <option value="Active">Setup Active</option>
                   <option value="InActive">Setup InActive</option>
                </select>                     
             </td>
              <td>
                <input type="submit" value="Update" Class="btn btn-primary" name="submit" style="    margin-top: 11px;" />
             </td>
          </tr>
        </table>
        </form> 
   ';


    $backhtml.='<span class="badge badge-info"><a style="color: white;font-size: 16px;" href="index.php?Theme=default&Base=SalaryPaySlip&Script=EmployeeTax">Back To Page</a></span>';
    $headhtml.='<span style="color:green"><b>'.$SingleData['FullName'].'</b> Tax Update Section</span>';

   }else{

   $actionhtnl.='

  
        <form action="" method="post">
        <table style="text-align:center; width:70%;
         margin:0 auto;margin-top:20px; ">
          <tr>
             <td style="padding-bottom: 12px;">
                Empolyee Name <br/>
                <select class="UserID" name="username" required>
                   <option value="0">Select Empolyee Name</option>
                   '.$userHTML.'
                </select>

             </td>
             <td>
                Setup Date<br/>
                <input type="text" required name="taxsetupdate" id="taxsetupdate" class="taxsetupdate" />
             </td>
             <td>
                 Setup Satus<br/>
                <select name="taxstatus" required>
                   <option value="InActive">Setup InActive</option>
                   <option value="Active">Setup Active</option>
                </select>                     
             </td>
              <td>
                <input type="submit" value="Submit" Class="btn btn-primary" name="submit" style="    margin-top: 11px;" />
             </td>
          </tr>
        </table>
        </form> 
   ';

    $backhtml.='<span class="badge badge-info"><a style="color: white;font-size: 16px;" href="index.php?Theme=default&Base=SalaryPaySlip&Script=home">Back To Page</a></span>';
    $headhtml.='<span style="color:blue">Empolyee Tax Set Section</span>';
   }


    $MainContent.='	

    <style>
	.block-header div {
	padding-top: 10px;
	color: blue;
	font-size: 19px;
    }
	</style>

   <div class="row-fluid" id="rc">
        <div class="span12">
            <!-- block -->
			
			
            <div class="block">
               
                <div class="navbar navbar-inner block-header">               
                    <div class="muted pull-left">
                       '.$headhtml.'
				          	</div>

                    <div class="pull-right">
                        '.$backhtml.'
                    </div>
                </div>





                '.$actionhtnl.'





                <div class="block-content collapse in">
				
                    <table class="table table-striped table-bordered" id="example1">
                        <thead style="background-color:#B4D9EC;color: black;">
                            <tr>
              								<th>E.Name</th>
                              <th>E.Id</th>
              								<th>B.Name</th>
              								<th>Department</th>
              								<th>Designation</th>
              								<th>Salary</th>
              								<th>Tax Amt</th>
                              <th>Tax SD</th>
                              <th style="text-align:center">Status</th>                                              
                            </tr>
                        </thead>
                        <tbody>
							'              .$taxhtml.'
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /block -->
        </div>
		</div>

';