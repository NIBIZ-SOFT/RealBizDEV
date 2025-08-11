<?
include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";



// DataGrid
$MainContent .= CTL_Datagrid(
    $Entity,
    $ColumnName = array("HeadOfAccountName","BillPhase","BillDate", "Date", "VoucherNo", "BillNo", "dr", "cr"),
    $ColumnTitle = array("Head Of Account Name","Bill Phase","Bill Date", "Date", "Voucher No","MR / BillNo", "dr", "cr"),
    $ColumnAlign = array("left","left", "left", "left", "left", "left", "left","left", "left"),
    $ColumnType = array("text","text", "date", "date", "text", "text","text", "text"),
    $Rows = SQL_Select("journalvoucher where VendorID={$VendorID} and ProjectID={$CategoryID} and JournalVoucherIsDisplay=0  ORDER BY VoucherNo desc"),
    $SearchHTML = "" . CTL_InputText($Name = "FreeText", "", "", 26, $Class = "DataGridSearchBox") . " ",
    $ActionLinks = false,
    $SearchPanel = true,
    $ControlPanel = false,
    $EntityAlias = "" . $EntityCaption . "",
    $AddButton = false

);

$JVINfo = SQL_Select("journalvoucher where VendorID={$VendorID} and ProjectID={$CategoryID} and JournalVoucherIsDisplay=0  and cr>0   ORDER BY VoucherNo desc","","");

$sl = 1;
$totalDr=0;
foreach($JVINfo as $ThisJVINfo){
    $AdvancePaidContructors = SQL_Select("transaction where VendorID={$VendorID} and ProjectID={$CategoryID} and HeadOfAccountID={$ThisJVINfo["HeadOfAccountID"]} and dr>0  ORDER BY TransactionID desc");


    foreach ($AdvancePaidContructors as $AdvancePaidContructor) {

        $tr .= '
            <tr> 
                <td>' . $sl . '</td>
                <td>' . HumanReadAbleDateFormat($AdvancePaidContructor["Date"]) . '</td>
                <td>' . $AdvancePaidContructor["HeadOfAccountName"] . '</td>
                <td>' . $AdvancePaidContructor["BillNo"] . '</td>
                <td>' . $AdvancePaidContructor["VoucherNo"] . '</td>
                <td>' . $AdvancePaidContructor["BankCashName"] . '</td>
                <td>' . BangladeshiCurencyFormat($AdvancePaidContructor["dr"]) . '</td>
                
            </tr>
        ';
        $sl++;

        $totalDr +=$AdvancePaidContructor["dr"];

    }

}


$dr=0;
$cr=0;
foreach ($Rows as $Row){
    if ($Row["dr"] > 0){
        $dr +=$Row["dr"];
    }else{
        $cr +=$Row["cr"];
    }
}


$DueOrAdvanceAmount = $totalDr - $dr;
if($DueOrAdvanceAmount>=0){
    $TTile = "Total Advance Amount";
}else{
    $TTile = "Total Due Amount";
}

$MainContent .= '

<table class="table table-bordered table-striped table-hover data-table">
      <tbody>
        
      </tbody>
      
      <tbody>
      
        <tr>            
            <td colspan="6" style="text-align: right;font-weight: bold"> Total Bill Amount=</td>
            <td width="30px">  ' . BangladeshiCurencyFormat($dr) . '</td>
            <td width="30px">  ' . BangladeshiCurencyFormat($cr) . ' </td>
            
        </tr>
        <tr>            
            <td colspan="6" style="text-align: right;font-weight: bold"> '.$TTile.' =</td>
            <td colspan="2" width="30px">  ' . BangladeshiCurencyFormat($totalDr-$dr) . '</td>
            
            
        </tr>
        
      </tbody>
    </table>

';


$MainContent .= '<div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-th-list"></i>
            </span>				
            <h5>' . $EntityCaption . '</h5>
        </div>
       	
	</div>';


$MainContent .= '

<table class="table table-bordered table-striped table-hover data-table">
      <tbody>
        <tr class="DataGrid_Title_Table_Bar">
          <td class="DataGrid_ColumnTitle_Row_Serial_Cell">SL.No</td>
         
          <td class="DataGrid_ColumnTitle_Row_Serial_Cell">Payment Date</td>
          <td class="DataGrid_ColumnTitle_Row_Serial_Cell">Head Of Account Name</td>
          <td class="DataGrid_ColumnTitle_Row_Serial_Cell">Bill No</td>
          <td class="DataGrid_ColumnTitle_Row_Serial_Cell">Voucher No</td>
          <td class="DataGrid_ColumnTitle_Row_Serial_Cell">Made Of Payment</td>
          <td class="DataGrid_ColumnTitle_Row_Serial_Cell">Dr.</td>
          
          
        </tr>
      </tbody>
      
      <tbody>
      
      '.$tr.'
 
        <tr>            
            <td colspan="6" style="text-align: right;font-weight: bold"> Total Paid Amount=</td>
            <td>  ' . BangladeshiCurencyFormat($totalDr) . ' /-</td>
            
        </tr>
      </tbody>
    </table>

';



?>


