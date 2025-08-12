<?
	GetPermission("OptionCustomer");
	
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	SetFormvariable("RecordShowFrom", 1);
    SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
    SetFormvariable("SortBy", "{$OrderByValue}");
    SetFormvariable("SortType", "DESC");
	$MainContents.="
		<img style=\"vertical-align: middle;width:35px;height:30px;\" src=\"./theme/default/images/customer.png\">&nbsp;&nbsp;&nbsp;<b style=\"font-size:16px;\">Customer</b>
	";	

	if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	// Delete a data
	if(isset($_GET["DeleteConfirm"]))SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");

    $Where="CustomerID!=5";
	if($_POST["FreeText"]!="")
		$Where.=" and CustomerID!=5 and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";

$MainContent .= '

        

        <form class="mb-3" name="frmDataGridSearchSaleinfo" 
        action="index.php?Theme=default&Base=Customer&Script=import&NoHeader&NoFooter" method="post" 
        enctype="multipart/form-data">
            <div class="mb-3">
                <label for="formFile" class="form-label">Upload Excel File</label>
                <input class="form-control" type="file" id="formFile" name="importFile">
            </div>
            <div class="d-flex flex-wrap gap-2">
                <input type="submit" class="btn btn-primary" name="btn" value="Import Leads">
                <a class="btn btn-success" href="./ImportLeads.csv">Download Sample File</a>
            </div>
        </form>
        <hr>
        ';

	// DataGrid
	$MainContent.= CTL_Datagrid(
		$Entity,
		$ColumnName=array( "Image" ,"CustomerID" ,"CustomerName" , "FathersOrHusbandName" , "Date" , "Phone" , "Whatsapp", "CustomerEmail" , "NID"),
		$ColumnTitle=array( "Image","Customer ID","Customer Name","Father's Or Husband Name", "Birth Date" , "Phone", "Whatsapp" , "Customer Email" ,"NID"),
		$ColumnAlign=array( "left","left","left","left", "left" , "left" , "left" , "left", "left" ),
		$ColumnType=array( "imagelink","text","text","text", "text" , "text" , "email" , "text", "text" ),
		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
		$ActionLinks=true,
		$SearchPanel=true,
		$ControlPanel=true,
		$EntityAlias="".$EntityCaption.""
//		$AddButton=true,
//		$AdditionalLinkCaption=array("Due Invoice","Adv Payment"),
//		$AdditionalLinkField=array("CustomerID","CustomerID"),
//		$AdditionalLink=array(ApplicationURL("Customer","AddPayment&Customer="),ApplicationURL("AdvancedPayment","Manage&CustomerID="))


    );
?>