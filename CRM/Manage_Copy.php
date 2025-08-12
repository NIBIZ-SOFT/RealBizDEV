<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	SetFormvariable("RecordShowFrom", 1);
    SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
    SetFormvariable("SortBy", "CRMID");
    SetFormvariable("SortType", "DESC");

	if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	// Delete a data
	if(isset($_GET["DeleteConfirm"]))SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");




//     $Where="1 = 1";
// 	if($_POST["FreeText"]!="")
// 		$Where.=" and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";

    
    $UserPermission = SQL_Select("User", "UserID={$_SESSION["UserID"]}", "", "True");


	$Followup = "";
	if($_REQUEST["TodaysFollowup"]=="Yes"){
	    $Followup =" and NextCallDate= '".date("Y-m-d")."' ";
	    
	}

	if ( $_SESSION["UserID"] != 2 and $UserPermission["OptionClientInfoViewAllLeads"]!=1) {
		$Where ="(UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']}) {$Followup}";
	}else{
	    if($Followup=="")
		    $Where="1 = 1";
		else    
		    $Where="NextCallDate= '".date("Y-m-d")."'";
		    
		if($PendingFollowup!="")    
		    $Where=" {$PendingFollowup}";
	}


	if($_POST["FreeText"]!=""){
	    if($_SESSION["UserID"] != 2 )
		    $Where="(UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']}) and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";
	}
	
	
	if($_POST["FreeText"]!=""){
	    if($_SESSION["UserID"] == 2 or $UserPermission["OptionClientInfoViewAllLeads"]==1)
		    $Where=" {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";

	}
	
	if($_SESSION["UserID"] != 2 ){
        $PendingFollowup="";
    	if($_REQUEST["Notify"]=="PendingFollowup")
            $Where = " NextCallDate <= DATE_ADD( CURDATE(), INTERVAL -1 DAY ) and NextCallDate!='' and (UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']})";
	}
	
	if($_SESSION["UserID"] == 2  or $UserPermission["OptionClientInfoViewAllLeads"]==1){
        $PendingFollowup="";
    	if($_REQUEST["Notify"]=="PendingFollowup")
            $Where = " NextCallDate <= DATE_ADD( CURDATE(), INTERVAL -1 DAY ) and NextCallDate!=''";
	}



	
    //echo $Where;
    $TDate = date('Y-m-d');

    if($_SESSION["UserID"] == 2  or $UserPermission["OptionClientInfoViewAllLeads"]==1){
        $TotalLeads = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm"), MYSQL_ASSOC);
    }else{
        $TotalLeads = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm where (UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']})"), MYSQL_ASSOC);
    }
    
    if($_SESSION["UserID"] == 2 or $UserPermission["OptionClientInfoViewAllLeads"]==1){
        $TotalTodaysLeads = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm where Date='{$TDate}'"), MYSQL_ASSOC);
        //echo "tt";
    }else{
        //$TotalTodaysLeads = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm where DATE(DateInserted) = CURDATE() and (UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']})"), MYSQL_ASSOC);
        $TotalTodaysLeads = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm where Date='{$TDate}' and (UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']})"), MYSQL_ASSOC);
    }

    if($_SESSION["UserID"] == 2   or $UserPermission["OptionClientInfoViewAllLeads"]==1){
        $TotalMeeting = @mysql_fetch_array(mysql_query("SELECT SUM(CRMDetailsIsActive) as Total FROM tblcrmdetails where CRMType='Meeting' "), MYSQL_ASSOC);
        //$row["SellingPrice"];
    }else{
        $TotalMeeting = @mysql_fetch_array(mysql_query("SELECT SUM(CRMDetailsIsActive) as Total FROM tblcrmdetails where CRMType='Meeting' and UserIDInserted ={$_SESSION['UserID']}"), MYSQL_ASSOC);
    }
    
    
    if($_SESSION["UserID"] == 2   or $UserPermission["OptionClientInfoViewAllLeads"]==1){
        $TotalFollowup = @mysql_num_rows(mysql_query("SELECT COUNT(CRMDetailsID) as Total FROM tblcrmdetails where CallDate='{$TDate}' GROUP BY CRMID"));
        //$TotalFollowup1 = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm where Date='{$TDate}'"), MYSQL_ASSOC);
        // $TotalFollowup = @mysql_num_rows(mysql_query("SELECT COUNT(CRMDetailsID) as Total FROM tblcrmdetails where DATE(DateInserted) = CURDATE() GROUP BY CRMID"));
        // $TotalFollowup1 = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm where DATE(DateInserted) = CURDATE()"), MYSQL_ASSOC);
        //echo $TotalFollowup;
        
        //print_r($TotalFollowup);
        $TotalFollowupRecord = $TotalFollowup + $TotalFollowup1["Total"];
    }else{
        //$TotalFollowup = @mysql_fetch_array(mysql_query("SELECT SUM(CRMDetailsIsActive) as Total FROM tblcrmdetails where DATE(DateInserted) = CURDATE()  and UserIDInserted ={$_SESSION['UserID']}"), MYSQL_ASSOC);

        $TotalFollowup = @mysql_num_rows(mysql_query("SELECT COUNT(CRMDetailsID) as Total FROM tblcrmdetails where  CallDate='{$TDate}'  and UserIDInserted ={$_SESSION['UserID']} GROUP BY CRMID"));
        //$TotalFollowup1 = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm where  Date='{$TDate}'  and UserIDInserted ={$_SESSION['UserID']}"), MYSQL_ASSOC);
        // $TotalFollowup = @mysql_num_rows(mysql_query("SELECT COUNT(CRMDetailsID) as Total FROM tblcrmdetails where DATE(DateInserted) = CURDATE()  and UserIDInserted ={$_SESSION['UserID']} GROUP BY CRMID"));
        // $TotalFollowup1 = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm where DATE(DateInserted) = CURDATE() and UserIDInserted ={$_SESSION['UserID']}"), MYSQL_ASSOC);
        //echo $TotalFollowup;
        
        //print_r($TotalFollowup);
        $TotalFollowupRecord = $TotalFollowup + $TotalFollowup1["Total"];
    }


    //echo $Where;

$MainContent.='

    <div class="row-fluid">
        <!-- block -->
        <div class="block">
            <div class="navbar navbar-inner block-header">
                <div class="muted pull-left">CRM Dashboard</div>
                <div class="pull-right">

                </div>
            </div>
            <div class="block-content collapse in">
                <div class="span3">
                    <div class="chart" data-percent="'.$TotalLeads["Total"].'">'.$TotalLeads["Total"].'</div>
                    <div class="chart-bottom-heading"><span class="label label-info">Total Leads</span>

                    </div>
                </div>
                <div class="span3">
                    <div class="chart" data-percent="'.$TotalTodaysLeads["Total"].'">'.$TotalTodaysLeads["Total"].'</div>
                    <div class="chart-bottom-heading"><span class="label label-info">Today\'s Leads</span>

                    </div>
                </div>
                <div class="span3">
                    <div class="chart" data-percent="'.$TotalMeeting["Total"].'">'.$TotalMeeting["Total"].'</div>
                    <div class="chart-bottom-heading"><span class="label label-info">Today\'s Meeting</span>

                    </div>
                </div>
                <div class="span3">
                    <div class="chart" data-percent="'.$TotalFollowupRecord.'">'.$TotalFollowupRecord.'</div>
                    <div class="chart-bottom-heading"><span class="label label-info">Today\'s Followup</span>

                    </div>
                </div>
            </div>
        </div>
        <!-- /block -->
    </div>

';


    $MainContent.= '
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-th-list"></i>
                </span>				
                <h5>Action Buttons</h5>
            </div>
            <div class="widget-content">		
                <a  class="btn btn-primary" href="./index.php?Theme=default&Base=CRM&Script=Manage&TodaysFollowup=Yes">Todays Call</a>

                &nbsp; | &nbsp; 
                <a  class="btn btn-primary" href="index.php?Theme=default&Base=CRM&Script=Manage&Notify=PendingFollowup">Pending Call</a>

    ';


if (  $UserPermission["OptionClientInfoViewAllLeads"]==1)                

    $MainContent.= '
                &nbsp; | &nbsp; 
                <a  class="btn btn-primary" href="index.php?Theme=default&Base=CRM&Script=TodaysFollowup&NoHeader&NoFooter">Todays Followup</a>
                &nbsp; | &nbsp; 
                <a  class="btn btn-primary" href="index.php?Theme=default&Base=CRM&Script=Report">CRM Reporting</a>
    ';

    $MainContent.= '
    
                <hr>
        		<form name="frmDataGridSearchSaleinfo" id="InsertDataFRM" action="index.php?Theme=default&Base=CRM&Script=import&Import=true" method="post" enctype="multipart/form-data">		
                        Upload Excel File: <input type="file" name="file">    
						<input type="submit" class="btn btn-primary" name="btn" value="Import Leads" class="btn btn-primary"> 
                        &nbsp; | &nbsp; 
                        <a  class="btn btn-success" href="./ImportLeads.csv">Download Sample File</a>
        		</form>
            </div>	
    	</div>    
    ';

    //echo $Where;

	// DataGrid
	$MainContent.= CTL_Datagrid(
		$Entity,
		$ColumnName=array( "CRMID" , "Title" , "CustomerName" , "LeadsStatus" , "LeadSource" , "Phone" , "ProjectName" , "Date"   ,"AssignToName"   ,"NextCallDate" ),
		$ColumnTitle=array( "CRM ID","Profession", "Customer Name" , "Leads Status" , "Lead Source" , "Phone" , "Project Name" , "Date", "Assign To"   ,"Next Call Date" ),
		$ColumnAlign=array( "left","left", "left" , "left" , "left" , "left" , "left" , "left"   , "left"   , "left" ),
		$ColumnType=array( "text","text", "text" , "text" , "text" , "text" , "text" , "text" , "text"   ,"text"),
		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
		$ActionLinks=true,
		$SearchPanel=true,
		$ControlPanel=true,
		$EntityAlias="".$EntityCaption."",
		$AddButton=true,
		$AdditionalLinkCaption=array('<span class="btn btn-primary"  title="Manage Leads"><i class="fas fa-info-circle"></i></span>','<span class="btn btn-success" title="Add Call"><i class="fas fa-headset"></i></span> '
        ,'<span class="btn btn-success" title="Add Meeting"><i class="fas fa-handshake"></i></span><br>'
        ,'<div style="padding-top: 5px;"></div><span class="btn btn-warning" title="Transfer To Customer Panel" ><i class="fas fa-user-check"></i></span><br><br>'

        ),
		$AdditionalLinkField=array("CRMID","CRMID","CRMID","CRMID"),
		$AdditionalLink=array(ApplicationURL("CRMDetails","Manage&CRMType=Call&CRMID="),ApplicationURL("CRMDetails","Manage&ActionNewCRMDetails=1&CRMType=Call&GotoCRM=Yes&CRMID="),ApplicationURL("CRMDetails","Manage&ActionNewCRMDetails=1&CRMType=Meeting&GotoCRM=Yes&CRMID="),ApplicationURL("Customer","Manage&ActionNewCustomer=1&CRMID="))
		
	);
	
	
	
	
	
	
?>