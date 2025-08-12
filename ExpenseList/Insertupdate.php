<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

	$RefNumber=RefNo();
    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"{$Entity}Name"=>"",
		"{$Entity}Image"=>"",
		"{$Entity}Date"=>"",
		          
       "{$Entity}IsActive"=>1
	);

	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"])&&!isset($_REQUEST["DeleteConfirm"])){
	    $UpdateMode=true;
	    $FormTitle="Update $EntityCaption";
	    $ButtonCaption="Update";
	    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction", $Entity."ID={$_REQUEST[$Entity."ID"]}&".$Entity."UUID={$_REQUEST[$Entity."UUID"]}");
		if($UpdateMode&&!isset($_POST["".$Entity."ID"]))$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy="{$Entity}{$OrderByValue}", $SingleRow=true);
	}




$MainContent.="

			<script type=\"text/javascript\">
					function TotalPrice(){
					        document.frm.PaidAmount.value =document.frm.TotalAmount.value;
					}
					function TotalDue(){
					        document.frm.DueAmount.value = document.frm.TotalAmount.value - document.frm.PaidAmount.value;
					}
			</script>

		<fieldset>
			<legend>Input Area</legend>

			<form id=\"myForm\" name=\"frm\" action=\"{$ActionURL}\" method=\"post\">
				<div id=\"form_box\">
				<table>
					<tr class=\"ThemeDataTD\">
		              <td align=\"left\">
					  <b> Account :</b><br>
					  	".AccountType($TheEntityName["ExpenseListAccountType"])."<br><br>

						<b>Expense Head :</b><br>

		                ".ExpenseHead($Name="Name", $ValueSelected=$TheEntityName["{$Entity}Name"], $Where="", $PrependBlankOption=false)."
		                <br><br>
		                <b>Paid To :</b> <br>
		                <input type=\"text\" value=\"{$TheEntityName["{$Entity}PaidTo"]}\" name=\"PaidTo\" size=\"30\">
		                <br><br>
		                <input type=\"hidden\" value=\"{$RefNumber}\" name=\"RefNo\" size=\"30\">
		              </td>
			      <td width=\"30\">
		              </td>
			      <td width=\"200\">
				<b>Description :</b> <br>
		                <textarea  name=\"Description\" cols=\"40\" rows=\"8\">{$TheEntityName["{$Entity}Description"]}</textarea>
   					  </td>
			      <td width=\"30\">
		              </td>
		              <td>
					  <b>Total Amount :</b>
					  <br>
		                <input  onkeyup=\"TotalPrice();TotalDue();\" type=\"text\" value=\"{$TheEntityName["{$Entity}TotalAmount"]}\" name=\"TotalAmount\" size=\"20\">
						<br><br>
					
					   <b>Payment Date :</b><br>
					   <input style=\"cursor:Pointer\" id=\"PaidDate\" value=\"{$TheEntityName["{$Entity}Date"]}\" name=\"PaidDate\" size=\"10\" class=\"Date\" type=\"text\">
		                	
   					  </td>
		            </tr>
		            
					<tr>
						<td colspan=\"2\">

						    <b>Show Print Preview :</b>
						    <input type=\"radio\" name=\"PrintPreview\" value=\"1\"> Yes
						    &nbsp;&nbsp;
						    <input type=\"radio\" name=\"PrintPreview\" value=\"0\" checked=\"1\"> No
						    <br>

						</td>
					</tr>
					<tr>
						<td colspan=\"2\">
							<input class=\"SubmitButton\"  type=\"submit\" name=\"button\" id=\"submitter\" value=\"  Update/Insert  \" class=\"Diagnostic\" />
						</td>
					</tr>

				</table>
				</div>
			</form>

		</fieldset>
		<br>
	";

?>