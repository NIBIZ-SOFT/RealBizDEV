<?


	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";



    $UpdateMode=false;

    $FormTitle="Insert $EntityCaption";

    $ButtonCaption="Insert";

    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");



	// The default value of the input box will goes here according to how many fields we showing

    $TheEntityName=array(

       

		"Name"=>"",

		"Project"=>"",

		"MobileNo"=>"",

		"ContactPerson"=>"",

		"EMail"=>"",

		"Date"=>"",

		"Address"=>"",

		

       "{$Entity}IsActive"=>1

	);



	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"])&&!isset($_REQUEST["DeleteConfirm"])){

	    $UpdateMode=true;

	    $FormTitle="Update $EntityCaption";

	    $ButtonCaption="Update";

	    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction", $Entity."ID={$_REQUEST[$Entity."ID"]}&".$Entity."UUID={$_REQUEST[$Entity."UUID"]}");

		if($UpdateMode&&!isset($_POST["".$Entity."ID"]))$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy="{$OrderByValue}", $SingleRow=true);


	}


	if ($UpdateMode) {
		
			if ($_SESSION["UserName"] == 'admin') {

			}else{
				$MainContent .='
					<script>
						alert("You have no permision to any kind of action. ");
					</script>
					';
				header("location: index.php?Theme=default&Base=ClientInformation&Script=Manage");
			}
			

	}







	// Input sytem display goes here

	$Input=array();

                   

			$Input[]=array("VariableName"=>"Name","Caption"=>"Name","ControlHTML"=>CTL_InputText("Name",$TheEntityName["Name"],"", 30,"required"));

			$Input[]=array("VariableName"=>"Project","Caption"=>"Project","ControlHTML"=>CTL_InputText("Project",$TheEntityName["Project"],"", 30,"required"));

			$Input[]=array("VariableName"=>"MobileNo","Caption"=>"Mobile No","ControlHTML"=>CTL_InputText("MobileNo",$TheEntityName["MobileNo"],"", 30,"required"));

			$Input[]=array("VariableName"=>"Contact Person","Caption"=>"ContactPerson","ControlHTML"=>CTL_InputText("ContactPerson",$TheEntityName["ContactPerson"],"", 30,"required"));

			$Input[]=array("VariableName"=>"EMail","Caption"=>"EMail","ControlHTML"=>CTL_InputText("EMail",$TheEntityName["EMail"],"", 30,"required"));

			$Input[]=array("VariableName"=>"Source","Caption"=>"Source","ControlHTML"=>CTL_InputText("Source",$TheEntityName["Source"],"", 30,"required"));


			$Input[]=array("VariableName"=>"Date","Caption"=>"Date","ControlHTML"=>CTL_InputTextDate("Date",$TheEntityName["Date"],"", 30,"required date"));


			$Input[]=array("VariableName"=>"Address","Caption"=>"Address","ControlHTML"=>CTL_InputTextArea("Address",$TheEntityName["Address"],40, 3,"required"));

			$Input[]=array("VariableName"=>"Date","Caption"=>"Next Call Date","ControlHTML"=>CTL_InputTextDate("NextDateCall",$TheEntityName["NextDateCall"],"", 30,"required date"));

			$Input[]=array("VariableName"=>"Remarks","Caption"=>"Remarks Log","ControlHTML"=>CTL_InputTextArea("Remarks",$TheEntityName["Remarks"],40, 8,"required"));


			

            $Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);



	$MainContent.=FormInsertUpdate(

		$EntityName=$EntityLower,

		$FormTitle,

		$Input,

		$ButtonCaption,

		$ActionURL

	);

?>