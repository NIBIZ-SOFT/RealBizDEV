<?

//NotAdmin();
	GetPermission("OptionUsers");
	
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	SetFormvariable("RecordShowFrom", 1);
    SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
    SetFormvariable("SortBy", "{$OrderByValue}");
    SetFormvariable("SortType", "DESC");

	if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	// Delete a data

    if(isset($_GET["DeleteConfirm"])){
        echo "
				<script language=\"javascript\">
				    
					function confirmSubmit(url){
						var agree=confirm(\"Are you sure you want to delete?\");
						if(agree){
							window.location=url;
						}
						else{
						    history.go(-1);
							return false ;
						}	
					}
					
					confirmSubmit('./index.php?Theme=default&Base=Users&Script=Manage&UserID={$_REQUEST["UserID"]}&UserUUID={$_REQUEST["UserUUID"]}&DeleteConfirmFinal');
				</script>        
        ";
        exit();

    }


    if(isset($_GET["DeleteConfirmFinal"]))
        SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");

    $Where="1 = 1 and UserID!=2 and UserID!=1";

	//if($_POST["FreeText"]!="")
	///	$Where.=" and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%' and UserID!=1";

    if($_GET["ShowAll"]=="" and $_REQUEST["PageNo"]==""){
        $_SESSION["ShowAll"]="";
    }

    if($_GET["ShowAll"]=="Yes"){
        $_SESSION["ShowAll"]="Yes";
    }

    if($_GET["ShowAll"]=="No"){
        $_SESSION["ShowAll"]="No";
    }


	if($_GET["ShowAll"]=="No" or $_SESSION["ShowAll"]=="No"){
		$Where=" 1=1 and UserID!=2 and UserID!=1 and {$Entity}IsActive<>1";
		//$Where=" 1=1 and UserID!=2 and UserID!=1 and {$Entity}IsActive<>1";
        $_SESSION["ShowAll"]="No";
	}
	else if($_GET["ShowAll"]=="Yes" or $_SESSION["ShowAll"]=="Yes"){
	   $Where="1 = 1 and UserID!=2 and UserID!=1 and {$Entity}IsActive<>0";
	   $_SESSION["ShowAll"]="Yes";
	}else{
		$Where="1 = 1 and UserID!=2 and UserID!=1 and {$Entity}IsActive<>0";
        $_SESSION["ShowAll"]="";

	}

	//echo $_SESSION["ShowAll"];

	if($_POST["FreeText"]!="")
		$Where=" {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%' and UserID!=1";


    $MainContent .= '
    	
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-th-list"></i>
                </span>				
                <h5>Action Buttons</h5>
            </div>
            <div class="widget-content">		

    			<a style="margin-top: 10px"   href="index.php?Theme=default&Base=Branch&Script=Manage" class="btn btn-primary" >Manage Branch</a>
    			<a style="margin-top: 10px"   href="index.php?Theme=default&Base=Department&Script=Manage" class="btn btn-info" >Manage Department</a>
    			<a  style="margin-top: 10px"  href="index.php?Theme=default&Base=Designation&Script=Manage" class="btn btn-success" >Designation</a>
    			<a  style="margin-top: 10px"  href="index.php?Theme=default&Base=Leave&Script=Manage" class="btn btn-success" >Leave Management</a>
    			<a  style="margin-top: 10px"  href="index.php?Theme=default&Base=Attendance&Script=home" class="btn btn-success" >Attendance Management</a>
    			<a  style="margin-top: 10px"  href="index.php?Theme=default&Base=SalaryPaySlip&Script=home" class="btn btn-success" >Salary Module</a>

            </div>	
    				
    	</div>   

    ';


   $MainContentsss.='
    <button><a href="index.php?Theme=default&Base=Users&Script=Manage&ShowAll=Yes" style="text-decoration:none;color:green">All Active Member</a></button>
    <button><a href="index.php?Theme=default&Base=Users&Script=Manage&ShowAll=No" style="text-decoration:none;color:red">All InActive Member</a></button>
   ';
		
		
	// DataGrid
	$MainContent.= CTL_Datagrid(
		$Entity,
		$ColumnName=array( "FullName" ,"UserID", "BranchName", "Department" ,"Designation" , "JobStatus" , "PhoneNo"   ,"{$Entity}IsActive" ),
		$ColumnTitle=array( "Full Name","Company ID","Branch Name", "Department"  ,"Designation" , "Job Status" , "Phone"   ,"IsActive" ),
		$ColumnAlign=array( "left", "left","left", "left" ,"left" , "left"   ,"left"   , "left" ),
		$ColumnType=array( "text", "text" , "text" ,"text" ,"text" ,"text" , "text"   ,"yes/no"),
		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
		$ActionLinks=true,
		$SearchPanel=true,
		$ControlPanel=true,
		$EntityAlias="".$EntityCaption."",
		$AddButton=true
	);
?>