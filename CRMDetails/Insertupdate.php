<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction&CRMType={$_REQUEST["CRMType"]}");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"Type"=>"",
		"CallDate"=>date('Y-m-d'),
		"CallSummery"=>"",
		"NextCallDate"=>"",
		"Responsible"=>"",
		"Location"=>"",
		"AttendPerson"=>"",
		"Attachment"=>"",
		"TaskName"=>"",
		"StartDate"=>"",
		"EndDate"=>"",
		"Progress"=>"",
		"TaskStatus"=>"",
		
       "{$Entity}IsActive"=>1
	);

	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"])&&!isset($_REQUEST["DeleteConfirm"])){
	    $UpdateMode=true;
	    $FormTitle="Update $EntityCaption";
	    $ButtonCaption="Update";
	    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction", $Entity."ID={$_REQUEST[$Entity."ID"]}&".$Entity."UUID={$_REQUEST[$Entity."UUID"]}&CRMType={$_REQUEST["CRMType"]}");
		if($UpdateMode&&!isset($_POST["".$Entity."ID"]))$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy="{$OrderByValue}", $SingleRow=true);
	}

	$Input=array();

// Submi & Update Button CSS    
$MainContent .= '
    <style>
        .btnCustom {
            padding: 10px 20px !important;
            font-size: 16px !important;
        }

        .customFromLabel {
            font-size: 16px !important;
            color: #333 !important;
        }
        .card-header {
            background-color: #17a2b8 !important;
        }
        .card-header h5{
            color: #fff !important;
            font-size: 20px !important;
            font-weight: 700 !important;
        }
        .card-header .mb-0 span{
            color: #fff !important;
            font-size: 20px !important;
            font-weight: 600 !important;
        }
    </style>

';


$MainContent .= '
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header  text-white" style="background: #17a2b8;">
        <h5 class="mb-0"  style="font-size: 20px;">'.$FormTitle.'</h5>
    </div>
    <div class="card-body">
        <form id="crmAddForm" action="' . $ActionURL . '" method="post" enctype="multipart/form-data">
            <div class="row g-3">
';

if ($_REQUEST["CRMType"] == "Call") {
    $MainContent .= '
        <div class="col-md-6">
            <label class="form-label customFromLabel">Call Date</label>
            ' . CTL_InputTextDate("CallDate", $TheEntityName["CallDate"], "", 30, "required") . '
        </div>
        
        <div class="col-md-6">
            <label class="form-label customFromLabel">Next Call Date</label>
            ' . CTL_InputTextDate("NextCallDate", $TheEntityName["NextCallDate"], "", 30, "required") . '
            <input type="hidden" name="GotoCRM" value="' . $_REQUEST["GotoCRM"] . '">
        </div>
        
        <div class="col-12">
            <label class="form-label customFromLabel">Call Summery</label>
            ' . CTL_InputTextArea("CallSummery", $TheEntityName["CallSummery"], 40, 8, "required") . '
        </div>
    ';
}

if ($_REQUEST["CRMType"] == "Meeting") {
    $MainContent .= '
        <div class="col-md-6">
            <label class="form-label customFromLabel">Meeting Date</label>
            ' . CTL_InputTextDate("CallDate", $TheEntityName["CallDate"], "", 30, "required") . '
        </div>
        
        <div class="col-md-6">
            <label class="form-label customFromLabel">Next Meeting Date</label>
            ' . CTL_InputTextDate("NextCallDate", $TheEntityName["NextCallDate"], "", 30, "required") . '
        </div>
        
        <div class="col-md-6">
            <label class="form-label customFromLabel">Responsible</label>
            ' . CTL_InputText("Responsible", $TheEntityName["Responsible"], "", 30, "") . '
        </div>
        
        <div class="col-md-6">
            <label class="form-label customFromLabel">Attend Person</label>
            ' . CTL_InputText("AttendPerson", $TheEntityName["AttendPerson"], "", 30, "") . '
            <input type="hidden" name="GotoCRM" value="' . $_REQUEST["GotoCRM"] . '">
        </div>
        
        <div class="col-12">
            <label class="form-label customFromLabel">Location</label>
            ' . CTL_InputTextArea("Location", $TheEntityName["Location"], 40, 2, "required") . '
        </div>
        
        <div class="col-12">
            <label class="form-label customFromLabel">Meeting Summery</label>
            ' . CTL_InputTextArea("CallSummery", $TheEntityName["CallSummery"], 40, 6, "required") . '
        </div>
        
    ';
}

if ($_REQUEST["CRMType"] == "Attachment") {
    $MainContent .= '
        <div class="col-12">
            <label class="form-label customFromLabel">Attachment Summery</label>
            ' . CTL_InputTextArea("CallSummery", $TheEntityName["CallSummery"], 40, 6, "") . '
        </div>
        <div class="col-md-6">
            <label class="form-label customFromLabel">Attachment</label>
            ' . CTL_ImageUpload("Attachment", $TheEntityName["Attachment"], true, "FormTextInput", 100, 0, true) . '
        </div>
    ';
}

if ($_REQUEST["CRMType"] == "Task") {
    $MainContent .= '
        <div class="col-md-6">
            <label class="form-label customFromLabel">Task Name</label>
            ' . CTL_InputText("TaskName", $TheEntityName["TaskName"], "", 30, "required") . '
        </div>
        <div class="col-md-6">
            <label class="form-label customFromLabel">Start Date</label>
            ' . CTL_InputTextDate("StartDate", $TheEntityName["StartDate"], "", 30, "required") . '
        </div>
        <div class="col-md-6">
            <label class="form-label customFromLabel">End Date</label>
            ' . CTL_InputTextDate("EndDate", $TheEntityName["EndDate"], "", 30, "required") . '
        </div>
        <div class="col-md-6">
            <label class="form-label customFromLabel">Progress (%)</label>
            ' . CTL_InputText("Progress", $TheEntityName["Progress"], "", 30, "") . '
        </div>
    ';
}

$MainContent .= '
            </div>
            <div class="col-12 ">
                <div class="text-end">
                    <button type="submit" class="btn btn-success btnCustom mt-4">'. $ButtonCaption .'</button>
                </div>
            </div>
            
        </form>
    </div>
</div>
';

                   
// 			$Input[]=array("VariableName"=>"Type","Caption"=>"Type","ControlHTML"=>CTL_InputText("Type",$TheEntityName["Type"],"", 30,"required"));
// 			$Input[]=array("VariableName"=>"CallDate","Caption"=>"Call Date","ControlHTML"=>CTL_InputText("CallDate",$TheEntityName["CallDate"],"", 30,"required"));
// 			$Input[]=array("VariableName"=>"CallSummery","Caption"=>"Call Summery","ControlHTML"=>CTL_InputTextArea("CallSummery",$TheEntityName["CallSummery"],40, 8,"required"));
// 			$Input[]=array("VariableName"=>"NextCallDate","Caption"=>"Next Call Date","ControlHTML"=>CTL_InputText("NextCallDate",$TheEntityName["NextCallDate"],"", 30,"required"));
// 			$Input[]=array("VariableName"=>"Responsible","Caption"=>"Responsible","ControlHTML"=>CTL_InputText("Responsible",$TheEntityName["Responsible"],"", 30,"required"));
// 			$Input[]=array("VariableName"=>"Location","Caption"=>"Location","ControlHTML"=>CTL_InputTextArea("Location",$TheEntityName["Location"],40, 8,"required"));
// 			$Input[]=array("VariableName"=>"AttendPerson","Caption"=>"Attend Person","ControlHTML"=>CTL_InputText("AttendPerson",$TheEntityName["AttendPerson"],"", 30,"required"));
// 			$Input[]=array("VariableName"=>"Attachment","Caption"=>"Attachment","ControlHTML"=>CTL_InputText("Attachment",$TheEntityName["Attachment"],"", 30,"required"));
// 			$Input[]=array("VariableName"=>"TaskName","Caption"=>"Task Name","ControlHTML"=>CTL_InputText("TaskName",$TheEntityName["TaskName"],"", 30,"required"));
// 			$Input[]=array("VariableName"=>"StartDate","Caption"=>"Start Date","ControlHTML"=>CTL_InputText("StartDate",$TheEntityName["StartDate"],"", 30,"required"));
// 			$Input[]=array("VariableName"=>"EndDate","Caption"=>"End Date","ControlHTML"=>CTL_InputText("EndDate",$TheEntityName["EndDate"],"", 30,"required"));
// 			$Input[]=array("VariableName"=>"Progress","Caption"=>"Progress","ControlHTML"=>CTL_InputText("Progress",$TheEntityName["Progress"],"", 30,"required"));
// 			$Input[]=array("VariableName"=>"TaskStatus","Caption"=>"Task Status","ControlHTML"=>CTL_InputText("TaskStatus",$TheEntityName["TaskStatus"],"", 30,"required"));
			
//             $Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);


    $MainContent.="
        <script>
        
            $(document).ready(function(){

                    // $('#CallDate').datepicker({
                    //     showSecond: false,
                    //     dateFormat: 'yy-mm-dd'
                    // });
                    $('#NextCallDate').datepicker({
                        showSecond: false,
                        dateFormat: 'yy-mm-dd'
                    });
                    
                    $('#CallDate').attr('readOnly','true');

            });        
                    
        </script>
    
    ";
    
    

?>