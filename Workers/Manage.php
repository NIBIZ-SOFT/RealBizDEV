<?

// $opt = SQL_Select("workersattendance");
// if (!empty($opt)) {
//    echo "<table border='1' cellpadding='6' cellspacing='0'>";

//    echo "<tr>";
//    foreach (array_keys($opt[0]) as $column) {
//        echo "<th>" . htmlspecialchars($column) . "</th>";
//    }
//    echo "</tr>";

//    foreach ($opt as $row) {
//        echo "<tr>";
//        foreach ($row as $cell) {
//            echo "<td>" . htmlspecialchars($cell) . "</td>";
//        }
//        echo "</tr>";
//    }

//    echo "</table>";
// } else {
//    echo "⚠️No Data";
// }
// die();


	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	SetFormvariable("RecordShowFrom", 1);
    SetFormvariable("RecordShowUpTo", $Application["DatagridRowsDefault"]);
    SetFormvariable("SortBy", "{$OrderByValue}");
    SetFormvariable("SortType", "ASC");

	if(isset($_REQUEST["ActionNew{$Entity}"]))include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	// Delete a data
	if(isset($_GET["DeleteConfirm"]))SQL_Delete($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'");

    $Where="1 = 1";
	if($_POST["FreeText"]!="")
		$Where.=" and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";

	// DataGrid
	$MainContent.= CTL_Datagrid(
		$Entity,
		$ColumnName=array( "ProjectID" , "name" , "phone" , "nid" , "address" , "join_date" , "daily_wage" ,"work_hours"  ,"{$Entity}IsActive" ),
		$ColumnTitle=array( "Project's Name", "Name", "Phone" , "NID" , "Address" , "Join Date" , "Per Day Salary" ,"Work Hours"  ,"IsActive" ),
		$ColumnAlign=array( "left", "left", "left" , "left" , "left" , "left" , "left"   , "left" , "left" ),
		$ColumnType=array( "text","text", "text" , "text" , "text" , "text" , "text"  , "text" ,"yes/no" ),
		$Rows=SQL_Select($Entity="{$Entity}", $Where ,  $OrderBy="{$_REQUEST["SortBy"]} {$_REQUEST["SortType"]}", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
		$SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
		$ActionLinks=true,
		$SearchPanel=true,
		$ControlPanel=true,
		$EntityAlias="".$EntityCaption."",
		$AddButton=true
	);
?>