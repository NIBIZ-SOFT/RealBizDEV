<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"VendorName"=>"",
		"VendorDescription"=>"",
		"Date"=>"",
		"Address"=>"",
		"VendorWebSite"=>"",
		"VendorPhone"=>"",
		"VendorEmail"=>"",
		
       "{$Entity}IsActive"=>1
	);

	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"])&&!isset($_REQUEST["DeleteConfirm"])){
	    $UpdateMode=true;
	    $FormTitle="Update $EntityCaption";
	    $ButtonCaption="Update";
	    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction", $Entity."ID={$_REQUEST[$Entity."ID"]}&".$Entity."UUID={$_REQUEST[$Entity."UUID"]}");
		if($UpdateMode&&!isset($_POST["".$Entity."ID"]))$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy="{$OrderByValue}", $SingleRow=true);
	}

	$PreviousDUE = SQL_Select("SchedulePayment","Amount!='' and TotalPayment!=''");
    $PreviousDUEAmount=0;
	foreach ($PreviousDUE as $ThisPreviousDUE){
	    //echo $ThisPreviousDUE["TotalPayment"]."<br>";
	    if($ThisPreviousDUE["Amount"]>$ThisPreviousDUE["TotalPayment"] and $ThisPreviousDUE["SchedulePaymentID"]!=$_REQUEST[$Entity."ID"])
	        $PreviousDUEAmount =$ThisPreviousDUE["Amount"]-$ThisPreviousDUE["TotalPayment"]+$PreviousDUEAmount;
    }

    $PropetyInfo=SQL_Select("Sales","SalesID={$_SESSION["SalesID"]}","",true);


    if($_REQUEST["ActionNewSchedulePayment"]==1)
        $PreviousDUEAmount=0;


// Input sytem display goes here
	$Input=array();


    $Input[]=array("VariableName"=>"VendorName","Caption"=>"Title","ControlHTML"=>CTL_InputText("Title",$TheEntityName["Title"],"", 30,"required"));
    $Input[]=array("VariableName"=>"VendorName","Caption"=>"Amount","ControlHTML"=>CTL_InputText("Amount",$TheEntityName["Amount"],"", 30,"required"));
    //$Input[]=array("VariableName"=>"VendorName","Caption"=>"Total Paid Amount","ControlHTML"=>CTL_InputText("TotalPayment",$TheEntityName["TotalPayment"],"", 30,"required"));
    $Input[]=array("VariableName"=>"VendorName","Caption"=>"Previous Due","ControlHTML"=>"{$PreviousDUEAmount}");
    $Input[]=array("VariableName"=>"VendorName","Caption"=>"Total Paid Amount","ControlHTML"=>"{$TheEntityName["TotalPayment"]}");

    //$Input[]=array("VariableName"=>"VendorDescription","Caption"=>"Amount","ControlHTML"=>CTL_InputTextArea("Amount",$TheEntityName["Amount"],40, 8,"required"));
    $Input[]=array("VariableName"=>"Date","Caption"=>"Due Date","ControlHTML"=>CTL_InputTextDate("Date",$TheEntityName["Date"],"", 30,"required date"));
    //$Input[]=array("VariableName"=>"Address","Caption"=>"Address","ControlHTML"=>CTL_InputTextArea("Address",$TheEntityName["Address"],40, 8,"required"));

    //$Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);

	$MainContent.=FormInsertUpdate(
		$EntityName=$EntityLower,
		$FormTitle." for - {$PropetyInfo["CustomerName"]} || {$PropetyInfo["ProjectName"]}",
		$Input,
		$ButtonCaption,
		$ActionURL
	);


	if($_REQUEST["TrxID"]=="Yes"){
        $PaymentID = $TheEntityName["PaymentID"];
    }else{
        $PaymentID = $TheEntityName["SchedulePaymentID"];
    }


    // Payment Transaction Section
    if($_REQUEST["ActionNewSchedulePayment"]!=1) {


        // Input sytem display goes here
        $Input = array();

        $Input[] = array("VariableName" => "BankCashID", "Caption" => "Account", "ControlHTML" => CCTL_BankCash($Name = "BankCashID", $TheEntityName["BankCashID"], $Where = "", $PrependBlankOption = false));//CTL_InputText("BankCashID",$TheEntityName["BankCashID"],"", 30,"required"));

        $Input[] = array("VariableName" => "VendorName", "Caption" => "Payment Note", "ControlHTML" => CTL_InputText("PaymentNote", $TheEntityName["PaymentNote"], "", 30, "required"));
        $Input[] = array("VariableName" => "VendorName", "Caption" => "Payment", "ControlHTML" => CTL_InputText("PaymentMade", $TheEntityName["PaymentMade"], "", 30, "required"));
        //$Input[]=array("VariableName"=>"VendorDescription","Caption"=>"Amount","ControlHTML"=>CTL_InputTextArea("Amount",$TheEntityName["Amount"],40, 8,"required"));
        $Input[] = array("VariableName" => "Date", "Caption" => "Payment Date", "ControlHTML" => CTL_InputTextDate("PaymentDate", $TheEntityName["PaymentDate"], "", 30, "required date") . '
            <input type="hidden" value="Yes" name="Transaction">
            <input type="hidden" value="' . $PaymentID . '" name="PaymentID">
            <input type="hidden" value="' . $_REQUEST["TrxID"] . '" name="TrxID">
        
        ');
        //$Input[]=array("VariableName"=>"Address","Caption"=>"Address","ControlHTML"=>CTL_InputTextArea("Address",$TheEntityName["Address"],40, 8,"required"));

        //$Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);

        $MainContent .= FormInsertUpdate(
            $EntityName = $EntityLower,
            "Schedule Payment Transaction",
            $Input,
            $ButtonCaption,
            $ActionURL
        );

        if ($_REQUEST["ActionNewSchedulePayment"] != 1) {
            $TraxLog = SQL_Select("SchedulePayment", "PaymentID={$TheEntityName["SchedulePaymentID"]}");
            $i = 1;
            foreach ($TraxLog as $ThisTrxLog) {

                //                    <td align="center"><a href="' . ApplicationURL("SchedulePayment", "Insertupdate&TrxID=Yes&SchedulePaymentID={$ThisTrxLog["SchedulePaymentID"]}&SchedulePaymentUUID={$ThisTrxLog["SchedulePaymentUUID"]}") . '">EDIT</a> </td>

                $HTML .= '
                      <tr class="DataGrid_DataRow_Odd" >
                        <td align="center">' . $i . ' </td>
                        <td class="DataGrid_DataCell" align="left">' . $ThisTrxLog["BankCashName"] . '</td>
                        <td class="DataGrid_DataCell" align="left">' . $ThisTrxLog["PaymentNote"] . '</td>
                        <td class="DataGrid_DataCell" align="left">' . $ThisTrxLog["PaymentMade"] . '</td>
                        <td class="DataGrid_DataCell" align="left">' . $ThisTrxLog["PaymentDate"] . '</td>
                      </tr>
            
            ';
                $i++;
            }
        }

        //                    <td class="DataGrid_ColumnTitle_Row_Action_Cell">&nbsp;Options&nbsp;</td>

        $MainContent .= '
                <form name="frmDataGridSchedulePayment" action="" method="post" enctype="multipart form/data">
                  <table border="0" cellspacing="0" class="table table-bordered table-striped table-hover data-table">
                    <tbody>
                      <tr class="DataGrid_Title_Table_Bar" valign="middle">
                        <td class="DataGrid_ColumnTitle_Row_Serial_Cell">NO.</td>
                        <td width="">Account</td>
                        <td width="">Note</td>
                        <td width="">Amount</td>
                        <td width="">Date</td>
                      </tr>
                      
                      ' . $HTML . '
    
                      
                    </tbody>
                  </table>
                </form>
        
        
        
        ';

    }


    /*
    $Where = "PaymentID={$TheEntityName["SchedulePaymentID"]}";
    // DataGrid
    $MainContent.= CTL_Datagrid(
        $Entity,
        $ColumnName=array( "PaymentNote" ,"PaymentMade" , "PaymentDate"  ),
        $ColumnTitle=array( "Note","Amount", "Date"  ),
        $ColumnAlign=array( "left","left","left"  ),
        $ColumnType=array( "text","text","date" ),
        $Rows=SQL_Select("SchedulePayment", $Where ,  $OrderBy="SchedulePaymentID", $SingleRow=false, $RecordShowFrom=$_REQUEST["RecordShowFrom"], $RecordShowUpTo=$Application["DatagridRowsDefault"], $Debug=false),
        $SearchHTML="".CTL_InputText($Name="FreeText","","",26, $Class="DataGridSearchBox")." ",
        $ActionLinks=true,
        $SearchPanel=true,
        $ControlPanel=true,
        $EntityAlias="Schedule Payment Transaction List",
        $AddButton=false
    //        $AdditionalLinkCaption=array("Adv Payment<br>"),
    //		$AdditionalLinkField=array("VendorID"),
    //		$AdditionalLink=array(ApplicationURL("AdvancedPaymentVendor","Manage&VendorID="))
    );

    */


	?>