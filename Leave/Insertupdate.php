<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"EmployeeName"=>"",
		"Problem"=>"",
		"StartDate"=>"",
		"EndDate"=>"",
		
       "{$Entity}IsActive"=>1
	);

	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"])&&!isset($_REQUEST["DeleteConfirm"])){
	    $UpdateMode=true;
	    $FormTitle="Update $EntityCaption";
	    $ButtonCaption="Update";
	    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction", $Entity."ID={$_REQUEST[$Entity."ID"]}&".$Entity."UUID={$_REQUEST[$Entity."UUID"]}");
		if($UpdateMode&&!isset($_POST["".$Entity."ID"]))$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy="{$OrderByValue}", $SingleRow=true);
	}

	// Input sytem display goes here
	$Input=array();
                   
			//$Input[]=array("VariableName"=>"StartDate","Caption"=>"Start Date","ControlHTML"=>CTL_InputText("StartDate",$TheEntityName["StartDate"],"", 30,"required"));
			//$Input[]=array("VariableName"=>"EndDate","Caption"=>"End Date","ControlHTML"=>CTL_InputText("EndDate",$TheEntityName["EndDate"],"", 30,"required"));
			

			if($TheEntityName["LeaveStatus"]=='Approved' and $_SESSION["UserID"]!=="2"){
			    
				$Input[]=array("VariableName"=>"EmployeeName","Caption"=>"Employee Name","ControlHTML"=>CTL_InputText("EmployeeName",$TheEntityName["EmployeeName"],"", 30,"required","","readonly"));
				
				//$Input[]=array("VariableName"=>"EmployeeName","Caption"=>"Employee Name","ControlHTML"=>CCTL_CountryLookup($Name="EmployeeName", $TheEntityName["EmployeeName"], $Where="", $PrependBlankOption=false));
				
				
			    $Input[]=array("VariableName"=>"TypeLeave","Caption"=>"Type of Leave","ControlHTML"=>CTL_InputText("TypeLeave",$TheEntityName["TypeLeave"],"", 30,"required","","readonly"));						
			    //$Input[]=array("VariableName"=>"TypeLeave","Caption"=>"Type of Leave","ControlHTML"=>DP_TypeLeave("TypeLeave",$TheEntityName["TypeLeave"]));			
			    $Input[]=array("VariableName"=>"Problem","Caption"=>"Leave Reason","ControlHTML"=>CTL_InputTextArea("Problem",$TheEntityName["Problem"],40, 8,"required","","readonly"));

				$Input[]=array("VariableName"=>"StartDate","Caption"=>"Start Date","ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"leavestartdataNOUSE\" readonly name=\"StartDate\" value=\"{$TheEntityName["StartDate"]}\"/>");
			    $Input[]=array("VariableName"=>"EndDate","Caption"=>"End Date","ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"datepickerNOUSE\" readonly name=\"EndDate\" value=\"{$TheEntityName["EndDate"]}\"/>");			   	
			}else{
			
			
			    //$Input[]=array("VariableName"=>"EmployeeName","Caption"=>"Employee Name","ControlHTML"=>CTL_InputText("EmployeeName",$TheEntityName["EmployeeName"],"", 30,"required"));
				if($_SESSION["UserID"]==2)
				    $Input[]=array("VariableName"=>"CompnayId","Caption"=>"Employee Name","ControlHTML"=>MMSA_EmployeeName($Name="CompnayId", $TheEntityName["CompnayId"], $Where="", $PrependBlankOption=false));


				
			    $Input[]=array("VariableName"=>"TypeLeave","Caption"=>"Type of Leave","ControlHTML"=>DP_TypeLeave("TypeLeave",$TheEntityName["TypeLeave"]));			
			    $Input[]=array("VariableName"=>"Problem","Caption"=>"Leave Reason","ControlHTML"=>CTL_InputTextArea("Problem",$TheEntityName["Problem"],40, 8,"required"));
			   	$Input[]=array("VariableName"=>"StartDate","Caption"=>"Start Date","ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"leavestartdata\" name=\"StartDate\" value=\"{$TheEntityName["StartDate"]}\"/>");
			    $Input[]=array("VariableName"=>"EndDate","Caption"=>"End Date","ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"datepicker\" name=\"EndDate\" value=\"{$TheEntityName["EndDate"]}\"/>");			   	
			}
			
			 $datea=$TheEntityName["StartDate"];
			 $dateb=$TheEntityName["EndDate"];
			
			
			
			if($_SESSION["UserID"]=="2"){
				
			}else{
				$ls=$TheEntityName["LeaveStatus"];
				if($ls=="Cancel"){
				   $m="<span style=\"color:red\">Cancel Your Request</span>";
			       //$Input[]=array("VariableName"=>"StartDate","Caption"=>"Start Date","ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"leavestartdata\" name=\"StartDate\" value=\"{$TheEntityName["StartDate"]}\"/>");
			       //$Input[]=array("VariableName"=>"EndDate","Caption"=>"End Date","ControlHTML"=>"<input type=\"text\" class=\"DatePicker form-control\" id=\"datepicker\" name=\"EndDate\" value=\"{$TheEntityName["EndDate"]}\"/>");			   
				}elseif($ls=="Approved"){
				    $datea=$TheEntityName["StartDate"];
			        $dateb=$TheEntityName["EndDate"];
					$date1=date_create($datea);
			        $date2=date_create($dateb);
			        $diff=date_diff($date1,$date2);
			        $m=$diff->format("%R%a days Approved Leave");
					$Input[]=array("VariableName"=>"", "DefaultValue"=>"Return", "Caption"=>"", "ControlHTML"=>"<p>Leave Start Date <br/>  From {$datea} To {$dateb} </p>");
				}
			}
			
			$Input[]=array("VariableName"=>"", "DefaultValue"=>"Return", "Caption"=>"", "ControlHTML"=>"<p>{$m}</p>");

			
			if($UpdateMode){
			if($TheEntityName["LeaveStatus"]=='' and $_SESSION["UserID"]!=="2"){
			  $Input[]=array("VariableName"=>"", "DefaultValue"=>"Return", "Caption"=>"", "ControlHTML"=>"<p style='text-align:center'>Your leave application on processing <br/> Thank You !!!</p>");
			}
			}
			
			
			

			if($_SESSION["UserID"]=="2"){
			  $Input[]=array("VariableName"=>"LeaveStatus", "Caption"=>"Leave?", "ControlHTML"=>CTL_InputRadioSet($VariableName="LeaveStatus", $Captions=array("Approved", "Cancel"), $Values=array("Approved", "Cancel"), $CurrentValue=$TheEntityName["LeaveStatus"]), "Required"=>false);
			}



		   //$Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);

			
			
	$MainContent.=FormInsertUpdate(
		$EntityName=$EntityLower,
		$FormTitle,
		$Input,
		$ButtonCaption,
		$ActionURL
	);
?>