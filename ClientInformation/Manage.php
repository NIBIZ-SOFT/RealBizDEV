<?
	GetPermission("OptionClientInfo");
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	SetFormvariable("RecordShowFrom", 1);
    SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
    SetFormvariable("SortBy", "{$OrderByValue}");
    SetFormvariable("SortType", "DESC");

    $MainContent.= '
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-th-list"></i>
                </span>				
                <h5>Action Buttons</h5>
            </div>
            <div class="widget-content">		
                <a  class="btn btn-primary" href="./index.php?Theme=default&Base=ClientInformation&Script=Manage&TodaysFollowup=Yes">Todays Followup</a>
            </div>	
    	</div>    
    ';


	if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";

	// Delete a data
	if(isset($_GET["DeleteConfirm"])){
		SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");
			if ($_SESSION["UserName"] == 'admin') {
			}else{
				$MainContent .='
					<script>
						alert("You have no permision to any kind of action. ");
					</script>
					';
				header("location: index.php?Theme=default&Base=ClientInformation&Script=Manage");
			}
	}
	
	$Followup = "";
	if($_REQUEST["TodaysFollowup"]=="Yes"){
	    $Followup =" and NextDateCall= '".date("Y-m-d")."' ";
	    
	}

	if ( $_SESSION["UserEmail"] != 'admin@admin.com' ) {
		$Where ="UserIDInserted ={$_SESSION['UserID']} {$Followup}";
	}else{
	    if($Followup=="")
		    $Where="1 = 1";
		else    
		    $Where="NextDateCall= '".date("Y-m-d")."' ";
	}


	// DataGrid
	$MainContent.= CTL_Datagrid(

		$Entity,

		$ColumnName=array( "Name" , "Project" , "MobileNo" , "ContactPerson" , "EMail" , "Date" , "Address"  , "Source" , "Remarks"  , "NextDateCall"   ,"{$Entity}IsActive" ),

		$ColumnTitle=array( "Name", "Project" , "Mobile No" , "Contact Person" , "E-Mail" , "Date" , "Address" , "Source", "Remarks" , "Next Call"   ,"IsActive" ),

		$ColumnAlign=array( "left", "left" , "left", "left", "left" , "left" , "left" , "left" , "left"  , "left"   , "left" ),

		$ColumnType=array( "text", "text", "text" , "text" , "text" , "date" , "text" , "text" , "text"  , "date"   ,"yes/no"),

		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),

		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",

		$ActionLinks=true,

		$SearchPanel=true,

		$ControlPanel=true,

		$EntityAlias="".$EntityCaption."",

		$AddButton=true

	);



?>