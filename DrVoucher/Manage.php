<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	SetFormvariable("RecordShowFrom", 1);
    SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
    SetFormvariable("SortBy", "Date");
    SetFormvariable("SortType", "DESC");

	if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	// Delete a data
	if(isset($_GET["DeleteConfirm"]))SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");

    $Where="1 = 1";
	if($_POST["FreeText"]!="")
		$Where.=" and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";


$MainContent .= '

        

        <form class="mb-3" name="frmDataGridSearchSaleinfo" 
        action="index.php?Theme=default&Base=DrVoucher&Script=import&NoHeader&NoFooter" method="post" 
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
		$ColumnName=array( "Image" , "ProjectName" , "Date" , "HeadOfAccountName" , "BillNo" , "VoucherNo", "BankCashName", "Amount"    ),
		$ColumnTitle=array( "Image","Project Name", "Date" , "Head Of Account Name" , "Bill No", "Voucher No",  "Made Of Payment",  "Amount"  ),
		$ColumnAlign=array( "left", "left", "left" , "left" , "left" , "left","left", "left"   ),
		$ColumnType=array( "imagelink","text", "Date" , "text" , "text" , "text","text", "text"   ),
		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
		$ActionLinks=true,
		$SearchPanel=true,
		$ControlPanel=true,
		$EntityAlias="".$EntityCaption."",

        $AddButton=true,
		$AdditionalLinkCaption=array("<span class='btn btn-success'><i class='icon-print icon-white'></i> Print</span><br>"),
		$AdditionalLinkField=array("VoucherNo"),
		$AdditionalLink=array(ApplicationURL("DrVoucher","Voucher&NoHeader&NoFooter&DrVoucherID="))


	);
?>

