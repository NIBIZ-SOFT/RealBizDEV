<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

SetFormvariable("RecordShowFrom", 1);
SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
SetFormvariable("SortBy", "CRMID");
SetFormvariable("SortType", "DESC");

if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
// Delete a data
if(isset($_GET["DeleteConfirm"]))SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");



$UserPermission = SQL_Select("User", "UserID={$_SESSION["UserID"]}", "", "True");

//echo $UserPermission["TeamLeader"];

$Followup = "";
if($_REQUEST["TodaysFollowup"]=="Yes"){
    $Followup =" and NextCallDate= '".date("Y-m-d")."' ";

}

if ( $_SESSION["UserID"] != 2 and $UserPermission["OptionClientInfoViewAllLeads"]!=1) {
    if ($UserPermission["TeamLeader"] != "") {
        $TLList = explode(",", $UserPermission["TeamLeader"]);
        foreach ($TLList as $TL) {
            $TLHTML .= "  AssignTo ={$TL} or";
        }
        $TLHTML = " or ". substr($TLHTML, 0, strlen($TLHTML) - 2);
    }
    $Where ="(UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']} {$TLHTML}) {$Followup}";
}else{
    if($Followup=="")
        $Where="1 = 1";
    else
        $Where="NextCallDate= '".date("Y-m-d")."'";

    if($PendingFollowup!="")
        $Where=" {$PendingFollowup}";
}


if($_POST["FreeText"]!=""){
    if($_SESSION["UserID"] != 2 ) {

        if ($UserPermission["TeamLeader"] != "") {
            $TLList1 = explode(",", $UserPermission["TeamLeader"]);
            foreach ($TLList as $TL) {
                $TLHTML1 .= "  AssignTo ={$TL} or";
            }
            $TLHTML1 = " or ". substr($TLHTML1, 0, strlen($TLHTML1) - 2);
        }

        $Where = "(UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']} {$TLHTML1}) and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";

    }
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

//    if($UserPermission["TeamLeader"]!="" and $_POST["FreeText"]=="" ) {
//        $TLList = explode(",", $UserPermission["TeamLeader"]);
//        foreach ($TLList as $TL) {
//            $TLHTML .= "  AssignTo ={$TL} or";
//        }
//
//        $TLHTML = substr($TLHTML, 0, strlen($TLHTML) - 2);
//        $TLHTMLCounter="";
//        if ($Where != ""){
//            $Where .= " or " . $TLHTML;
//            $TLHTMLCounter = " or " . $TLHTML;
//        }else
//            $Where=$TLHTML;
//    }


//echo $Where;
$TDate = date('Y-m-d');

if($_SESSION["UserID"] == 2  or $UserPermission["OptionClientInfoViewAllLeads"]==1){
    $TotalLeads = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm"), MYSQL_ASSOC);
}else{
    //echo "SELECT SUM(CRMIsActive) as Total FROM tblcrm where (UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']} {$TLHTML})";
    $TotalLeads = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm where (UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']} {$TLHTMLCounter})"), MYSQL_ASSOC);
}

if($_SESSION["UserID"] == 2 or $UserPermission["OptionClientInfoViewAllLeads"]==1){
    $TotalTodaysLeads = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm where Date='{$TDate}'"), MYSQL_ASSOC);
    //echo "tt";
}else{
    //$TotalTodaysLeads = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm where DATE(DateInserted) = CURDATE() and (UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']})"), MYSQL_ASSOC);
    $TotalTodaysLeads = @mysql_fetch_array(mysql_query("SELECT SUM(CRMIsActive) as Total FROM tblcrm where Date='{$TDate}' and (UserIDInserted ={$_SESSION['UserID']} or AssignTo ={$_SESSION['UserID']}  {$TLHTMLCounter})"), MYSQL_ASSOC);
}

if($_SESSION["UserID"] == 2   or $UserPermission["OptionClientInfoViewAllLeads"]==1){
    $TotalMeeting = @mysql_fetch_array(mysql_query("SELECT SUM(CRMDetailsIsActive) as Total FROM tblcrmdetails where CRMType='Meeting' "), MYSQL_ASSOC);
    //$row["SellingPrice"];
}else{
    $TotalMeeting = @mysql_fetch_array(mysql_query("SELECT SUM(CRMDetailsIsActive) as Total FROM tblcrmdetails where CRMType='Meeting' and UserIDInserted ={$_SESSION['UserID']} {$TLHTMLCounter}"), MYSQL_ASSOC);
}


if($_SESSION["UserID"] == 2   or $UserPermission["OptionClientInfoViewAllLeads"]==1){
    $TotalFollowup = @mysql_num_rows(mysql_query("SELECT COUNT(CRMDetailsID) as Total FROM tblcrmdetails where CallDate='{$TDate}' GROUP BY CRMID"));

    $TotalFollowupRecord = $TotalFollowup + $TotalFollowup1["Total"];
}else{
    //$TotalFollowup = @mysql_fetch_array(mysql_query("SELECT SUM(CRMDetailsIsActive) as Total FROM tblcrmdetails where DATE(DateInserted) = CURDATE()  and UserIDInserted ={$_SESSION['UserID']}"), MYSQL_ASSOC);

    $TotalFollowup = @mysql_num_rows(mysql_query("SELECT COUNT(CRMDetailsID) as Total FROM tblcrmdetails where  CallDate='{$TDate}'  and UserIDInserted ={$_SESSION['UserID']} GROUP BY CRMID"));

    $TotalFollowupRecord = $TotalFollowup + $TotalFollowup1["Total"];
}

//echo $Where;

$MainContentvvv.='

    <div class="card">
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


$MainContent .= '
<div class="card mb-4">
    <div class="card-header bg-info text-white d-flex align-items-center">
        <i class="fas fa-th-list me-2"></i>
        <h5 class="mb-0">Leads Management</h5>
    </div>

    <div class="card-body">
        <div class="mb-3">
            <div class="d-flex flex-wrap gap-2 justify-content-start">
                <a href="./index.php?Theme=default&Base=CRM&Script=Manage&TodaysFollowup=Yes" class="btn btn-primary m-1">Today\'s Call</a>
                <a href="index.php?Theme=default&Base=CRM&Script=Manage&Notify=PendingFollowup" class="btn btn-success m-1">Pending Call</a>
                <a href="index.php?Theme=default&Base=CRM&Script=TodaysFollowup&NoHeader&NoFooter" class="btn btn-warning m-1">Today\'s Followup</a>';

if ($UserPermission["OptionClientInfoViewAllLeads"] == 1) {
    $MainContent .= '
                <a href="index.php?Theme=default&Base=CRM&Script=Report" class="btn btn-secondary m-1">CRM Reporting</a>
';
}

$MainContent .= '
            </div>
        </div>

        <hr>

        <form name="frmDataGridSearchSaleinfo" id="InsertDataFRM" action="index.php?Theme=default&Base=CRM&Script=import&Import=true" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="formFile" class="form-label">Upload Excel File</label>
                <input class="form-control" type="file" id="formFile" name="importFile">
            </div>
            <div class="d-flex flex-wrap gap-2">
                <input type="submit" class="btn btn-primary" name="btn" value="Import Leads">
                <a class="btn btn-success" href="./ImportLeads.csv">Download Sample File</a>
            </div>
        </form>
    </div>
</div>';


//echo $Where;
$MainContent.= '
    <style>
    .card-header {
        background-color: #17a2b8 !important;
    }
    .card-header h5{
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
// DataGrid
$MainContent.= CTL_Datagrid(
    $Entity,
    $ColumnName=array( "Title" , "CustomerName" , "LeadsStatus" , "LeadSource" , "Phone" , "ProjectName" , "Date"   ,"AssignToName"  ,"UserIDInserted"   ,"NextCallDate" ),
    $ColumnTitle=array( "Profession", "Customer Name" , "Leads Status" , "Lead Source" , "Phone" , "Project Name" , "Date", "Assign To"   ,"Assigned by"   ,"Next Call Date" ),
    $ColumnAlign=array( "left", "left" , "left" , "left" , "left" , "left" , "left"   , "left"   , "left"   , "left" ),
    $ColumnType=array( "text", "text" , "text" , "text" , "text" , "text" , "text" , "text"   ,"text" ,"text"),
    $Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
    $SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
    $ActionLinks=true,
    $SearchPanel=true,
    $ControlPanel=true,
    $EntityAlias="".$EntityCaption."",
    $AddButton=true,
    $AdditionalLinkCaption=array('<span class="btn btn-primary"  title="Manage Leads"><i class="fas fa-info-circle"></i></span>',
        '<span class="btn btn-success" title="Add Call"><i class="fas fa-headset"></i></span> ',
        '<span class="btn btn-success" title="Add Meeting"><i class="fas fa-handshake"></i></span><br>',
        '<div style="padding-top: 5px;"></div>
        <span class="btn btn-warning" title="Transfer To Customer Panel" ><i class="fas fa-user-check"></i></span><br><br>'
    ),
    $AdditionalLinkField=array("CRMID","CRMID","CRMID","CRMID"),
    $AdditionalLink=array(ApplicationURL("CRMDetails","Manage&CRMType=Call&CRMID="),
        ApplicationURL("CRMDetails","Manage&ActionNewCRMDetails=1&CRMType=Call&GotoCRM=Yes&CRMID="),
        ApplicationURL("CRMDetails","Manage&ActionNewCRMDetails=1&CRMType=Meeting&GotoCRM=Yes&CRMID="),
        ApplicationURL("Customer","Manage&ActionNewCustomer=1&CRMID="))
);






?>