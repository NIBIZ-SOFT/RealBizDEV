<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	SetFormvariable("RecordShowFrom", 1);
    SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
    SetFormvariable("SortBy", "{$OrderByValue}");
    SetFormvariable("SortType", "DESC");

	if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	// Delete a data
	if(isset($_GET["DeleteConfirm"]))SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");

    //echo $_SESSION['UserID'];

//     $CCRM = SQL_Select("CRM");
    
//     foreach($CCRM as $ThisCCRM){
        
//         SQL_InsertUpdate(
// 	        "crmdetails",
// 			$TheEntityNameData=array(
//         		"AssignTo"=>$ThisCCRM["AssignTo"],
//         		"AssignToName"=>$ThisCCRM["AssignToName"],
// 			),
//     			"CRMID={$ThisCCRM["CRMID"]}"
// 		);			
			       
//     }

    $UserPermission = SQL_Select("User", "UserID={$_SESSION["UserID"]}", "", "True");


    $MainContent .= '
    	
        <div class="widget-box">
            <div class="widget-content mb-3">		

    			<a style="margin-top: 10px"   href="index.php?Theme=default&Base=CRMDetails&Script=Manage&CRMID='.$_REQUEST["CRMID"].'&CRMType=Call" class="btn btn-primary" >Manage Call</a>
    			<a style="margin-top: 10px"   href="index.php?Theme=default&Base=CRMDetails&Script=Manage&CRMID='.$_REQUEST["CRMID"].'&CRMType=Meeting" class="btn btn-info" >Manage Meeting</a>
    			<a  style="margin-top: 10px"  href="index.php?Theme=default&Base=CRMDetails&Script=Manage&CRMID='.$_REQUEST["CRMID"].'&CRMType=Attachment" class="btn btn-success" >Attachments</a>
    			<a  style="margin-top: 10px"  href="index.php?Theme=default&Base=CRMDetails&Script=Manage&CRMID='.$_REQUEST["CRMID"].'&CRMType=Task" class="btn btn-warning" >Manage Task</a>
    ';

    if($_REQUEST["CRMType"]=="Call" or $_REQUEST["CRMType"]=="Meeting")
        $MainContent .= '
        			<a  style="margin-top: 10px"  href="./index.php?Theme=default&Base=CRMDetails&Script=Manage&CRMType='.$_REQUEST["CRMType"].'&TodaysFollowup=Yes" class="btn btn-primary" >Todays Followup</a>
        ';
 
    $MainContent .= '
            </div>	
    				
    	</div>    
    	    
    ';
    

	$Followup = "";
	if($_REQUEST["TodaysFollowup"]=="Yes"){
	    $Followup =" and NextCallDate= '".date("Y-m-d")."' and CRMID = {$_SESSION["CRMID"]} ";
	    
	}

	if ( $_SESSION["UserID"] != 2 ) {
		$Where ="(UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']}) and CRMID = {$_SESSION["CRMID"]} {$Followup}";
	}else{
	    if($Followup=="")
		    $Where="CRMID = {$_SESSION["CRMID"]}";
		else    
		    $Where="NextCallDate= '".date("Y-m-d")."' and CRMID = {$_SESSION["CRMID"]}";
	}




//     $Where="CRMID = {$_SESSION["CRMID"]}";
// 	if($_POST["FreeText"]!="")
// 		$Where.=" and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";
		
		

		// DataGrid
	if($_REQUEST["CRMType"]=="Call"){
	    
		//$Where="(UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']}) and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";

	    $Where.=" and CRMType='Call'";

		$MainContent.= '
			<style>
			.card-header {
				background-color: #17a2b8 !important;
			}
			.card-header .text-white span{
				color: #fff !important;
				font-size: 20px !important;
				font-weight: 600 !important;
			}
			
			.widget-content a {
				padding: 7px 11px !important;
				font-size: 18px !important;
				margin-left: 7px !important;
			}
			</style>
		';

    	if($_REQUEST["Notify"]=="PendingFollowup")
            $Where = " NextCallDate <= DATE_ADD( CURDATE(), INTERVAL -3 DAY ) and NextCallDate!='' and CRMType='Call' ";
	    
        //echo $Where;
        if($UserPermission["OptionClientInfoViewAllLeads"]==1)        
            $Where = " CRMID = {$_SESSION["CRMID"]}  and CRMType='Call'"; 
        
    	$MainContent.= CTL_Datagrid(
    		$Entity,
    		$ColumnName=array( "CallDate" , "CallSummery" , "NextCallDate"  ),
    		$ColumnTitle=array( "Call Date" , "Call Summery" , "Next Call Date"),
    		$ColumnAlign=array( "left", "left" , "left" ),
    		$ColumnType=array( "text", "text" , "text" ),
    		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
    		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
    		$ActionLinks=true,
    		$SearchPanel=true,
    		$ControlPanel=true,
    		$EntityAlias="".$EntityCaption."",
    		$AddButton=true
    	);
	}
	
	
	if($_REQUEST["CRMType"]=="Meeting"){

		$MainContent.= '
			<style>
			.card-header {
				background-color: #17a2b8 !important;
			}
			.card-header .text-white span{
				color: #fff !important;
				font-size: 20px !important;
				font-weight: 600 !important;
			}
			.widget-content a {
				padding: 7px 11px !important;
				font-size: 18px !important;
				margin-left: 7px !important;
			}
			</style>
		';

	    $Where.=" and CRMType='Meeting'";
	    
    	if($_REQUEST["Notify"]=="PendingFollowup")
            $Where = " NextCallDate <= DATE_ADD( CURDATE(), INTERVAL -3 DAY ) and NextCallDate!=''  and CRMType='Meeting'";

        if($UserPermission["OptionClientInfoViewAllLeads"]==1)        
            $Where = "  CRMID = {$_SESSION["CRMID"]}  and CRMType='Meeting' "; 
	    

    	$MainContent.= CTL_Datagrid(
    		$Entity,
    		$ColumnName=array(  "CallDate" , "CallSummery" , "NextCallDate" , "Responsible" , "Location" , "AttendPerson"   ),
    		$ColumnTitle=array( "Meeting Date" , "Meeting Summery" , "Next Meeting Date" , "Responsible" , "Location" , "Attend Person" ),
    		$ColumnAlign=array( "left", "left" , "left" , "left" , "left" , "left" , "left"   ),
    		$ColumnType=array( "text", "text" , "text" , "text" , "text" , "text" , "text" ),
    		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
    		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
    		$ActionLinks=true,
    		$SearchPanel=true,
    		$ControlPanel=true,
    		$EntityAlias="".$EntityCaption."",
    		$AddButton=true
    	);	
	}	
    	
	if($_REQUEST["CRMType"]=="Attachment"){

		$MainContent.= '
			<style>
			.card-header {
				background-color: #17a2b8 !important;
			}
			.card-header .text-white span{
				color: #fff !important;
				font-size: 20px !important;
				font-weight: 600 !important;
			}
			.widget-content a {
				padding: 7px 11px !important;
				font-size: 18px !important;
				margin-left: 7px !important;
			}
			</style>
		';

	    $Where.=" and CRMType='Attachment'";

        if($UserPermission["OptionClientInfoViewAllLeads"]==1)        
            $Where = "  CRMID = {$_SESSION["CRMID"]}  and CRMType='Attachment' "; 


    	$MainContent.= CTL_Datagrid(
    		$Entity,
    		$ColumnName=array(  "CallSummery" , "Attachment" ),
    		$ColumnTitle=array(  "Attachment Summery" , "Attachment"  ),
    		$ColumnAlign=array( "left", "left"  ),
    		$ColumnType=array( "text", "imagelink"),
    		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
    		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
    		$ActionLinks=true,
    		$SearchPanel=true,
    		$ControlPanel=true,
    		$EntityAlias="".$EntityCaption."",
    		$AddButton=true
    	);	    	
	}
	
	
	if($_REQUEST["CRMType"]=="Task"){

		$MainContent.= '
			<style>
			.card-header {
				background-color: #17a2b8 !important;
			}
			.card-header .text-white span{
				color: #fff !important;
				font-size: 20px !important;
				font-weight: 600 !important;
			}
			.widget-content a {
				padding: 7px 11px !important;
				font-size: 18px !important;
				margin-left: 7px !important;
			}
			</style>
		';
	    
	    $Where.=" and CRMType='Task'";

    	if($_REQUEST["Notify"]=="PendingFollowup")
            $Where = " NextCallDate <= DATE_ADD( CURDATE(), INTERVAL -3 DAY ) and NextCallDate!=''  and CRMType='Task'";
	    
        if($UserPermission["OptionClientInfoViewAllLeads"]==1)        
            $Where = " CRMID = {$_SESSION["CRMID"]}  and CRMType='Task' "; 
	    
    	$MainContent.= CTL_Datagrid(
    		$Entity,
    		$ColumnName=array(  "TaskName" , "StartDate" , "EndDate" , "Progress"   ),
    		$ColumnTitle=array(  "Task Name" , "Start Date" ,  "End Date" , "Progress"  ),
    		$ColumnAlign=array(  "left" , "left" , "left" , "left" ),
    		$ColumnType=array( "text" , "text" , "text" , "text" ),
    		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
    		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
    		$ActionLinks=true,
    		$SearchPanel=true,
    		$ControlPanel=true,
    		$EntityAlias="".$EntityCaption."",
    		$AddButton=true
    	);		
    	
	}
	
	
?>