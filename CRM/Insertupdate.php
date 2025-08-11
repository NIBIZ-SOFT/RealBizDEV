<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"Title"=>"",
		"CustomerName"=>"",
		"LeadsStatus"=>"",
		"LeadSource"=>"",
		"Phone"=>"",
		"ProjectName"=>"",
		"Description"=>"",
		"OrganizationName"=>"",
		"Email"=>"",
		"Date"=>date('Y-m-d'),
		
       "{$Entity}IsActive"=>1
	);

	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"])&&!isset($_REQUEST["DeleteConfirm"])){
	    $UpdateMode=true;
	    $FormTitle="Update $EntityCaption";
	    $ButtonCaption="Update";
	    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction", $Entity."ID={$_REQUEST[$Entity."ID"]}&".$Entity."UUID={$_REQUEST[$Entity."UUID"]}");
		if($UpdateMode&&!isset($_POST["".$Entity."ID"]))$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy="{$OrderByValue}", $SingleRow=true);
	}
	
	$Input=array();

$MainContent .= '
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header text-dark" style="background: #17a2b8;">
        <h5 class="mb-0" style="font-size: 20px;">'. $FormTitle .'</h5>
    </div>
    <div class="card-body">
        <form id="crmAddForm" action="' . $ActionURL . '" method="post" enctype="multipart/form-data">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Profession</label>
                    ' . CTL_InputText("Title", $TheEntityName["Title"], "", 30, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Customer Name</label>
                    ' . CTL_InputText("CustomerName", $TheEntityName["CustomerName"], "", 30, "required") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lead Status</label>
                    ' . CommaSeperated("LeadsStatus", $Settings["LeadsStatus"], $TheEntityName["LeadsStatus"], "required") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lead Source</label>
                    ' . CommaSeperated("LeadSource", $Settings["LeadSource"], $TheEntityName["LeadSource"], "required") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input type="tel" id="Phone" name="Phone" value="' . $TheEntityName["Phone"] . '" size="30" class="form-control form-control-lg" maxlength="11" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Project Name</label>
                    ' . CCTL_ProductsCategory("ProjectID", $TheEntityName["ProjectID"], "", true, "required") . '
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    ' . CTL_InputTextArea("Description", $TheEntityName["Description"], 40, 8, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Organization Name</label>
                    ' . CTL_InputText("OrganizationName", $TheEntityName["OrganizationName"], "", 30, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    ' . CTL_InputText("Email", $TheEntityName["Email"], "", 30, "") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Assign To User</label>
                    ' . CCTL_UserList("AssignTo", $TheEntityName["AssignTo"], "", true, "required") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Date</label>
                    ' . CTL_InputTextDate("Date", $TheEntityName["Date"], "", 30, "required") . '
                </div>

                <div class="col-md-6">
                    <label class="form-label">Active?</label>
                    ' . CTL_InputRadioSet("{$Entity}IsActive", array("Yes", "No"), array(1, 0), $TheEntityName["{$Entity}IsActive"]) . '
                </div>

                <div class="col-md-12">
                    <div class="text-end">
                        <button type="submit" class="btn btn-success  mt-4">Submit</button>
                    </div>
                </div>

            </div>

            
        </form>
    </div>
</div>
';


    // $MainContent.='
    //     <div style="border:1px solid red;">Property Not Selected</div>
    // ';
	// $MainContent.=FormInsertUpdate(
	// 	$EntityName=$EntityLower,
	// 	$FormTitle,
	// 	$Input,
	// 	$ButtonCaption,
	// 	$ActionURL
	// );
	
	$MainContent.='
	    <script>
	
            $(\'#basic_validate\').submit(function(e){
                //alert(\'Form has submitted\'); //REMOVE - ONLY FOR EXAMPLE

                if($("#LeadsStatus").val()==""){
                    $("#LeadsStatus").css("border", "1px solid red");
                    return false;
                }else if($("#LeadSource").val()==""){
                    $("#LeadSource").css("border", "1px solid red");
                    return false;

                }else if($("#Phone").val().length != 11){
                    $("#Phone").css("border", "1px solid red");
                    return false;

                }else if($(".ProjectNameClass").val()==""){
                    $(".ProjectNameClass").css("border", "1px solid red");
                    return false;

                }else if($("#Date").val()==""){
                    $("#Date").css("border", "1px solid red");
                    return false;
                }
                else if($(".FormComboBox_AssignedUser").val()==""){
                    $(".FormComboBox_AssignedUser").css("border", "1px solid red");
                    return false;
                }else
                    return true;
                
                
                
            });	
            
	    </script>
	    
	
	';




?>