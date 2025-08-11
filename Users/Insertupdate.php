<?

	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";



    $UpdateMode=false;

    $FormTitle="Insert $EntityCaption";

    $ButtonCaption="Insert";

    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");



	// The default value of the input box will goes here according to how many fields we showing

    $TheEntityName=array(

       

		"UserName"=>"",

		"UserEmail"=>"",

		"UserPassword"=>"",

		"UserCategory"=>"",

		"PhoneHome"=>"",

		

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

	if($TheEntityName["UserPassword"]=="")

		$TheEntityName["UserPassword"]=RandomPassword();

	$Input=array();



			$Input[]=array("VariableName"=>"UserName","Caption"=>"Enroll Number","ControlHTML"=>CTL_InputText("UserName",$TheEntityName["UserName"],"", 30,"required"));
			$Input[]=array("VariableName"=>"UserName","Caption"=>"Name","ControlHTML"=>CTL_InputText("NameFirst",$TheEntityName["NameFirst"],"", 30,"required"));

			$Input[]=array("VariableName"=>"UserEmail","Caption"=>"Email","ControlHTML"=>CTL_InputText("UserEmail",$TheEntityName["UserEmail"],"", 30,"required"));

			$Input[]=array("VariableName"=>"UserPassword","Caption"=>"Password","ControlHTML"=>CTL_InputText("UserPassword",$TheEntityName["UserPassword"],"", 30,"required"));





			$Input[]=array("VariableName"=>"PhoneHome","Caption"=>"Phone","ControlHTML"=>CTL_InputText("PhoneHome",$TheEntityName["PhoneHome"],"", 30,"required"));
			//$Input[]=array("VariableName"=>"PhoneHome","Caption"=>"Team Leader","ControlHTML"=>CTL_InputRadioSet($VariableName="TeamLeader", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["TeamLeader"]));

            $GetUserList = SQL_Select("User","UserID!=1 and UserID!=2");
            $TeamMeberList = explode(",",$TheEntityName["TeamLeader"]);
            //print_r($TeamMeberList);
            //$TeamMeberList[] = $TheEntityName["TeamLeader"];
            foreach($GetUserList as $ThisGetUserList){

                if (in_array($ThisGetUserList["UserID"], $TeamMeberList)) {
                    $OpSelected="selected";
                } else {
                    $OpSelected="";
                }

                $SHTML.='
                    <option value="'.$ThisGetUserList["UserID"].'" '.$OpSelected.'>'.$ThisGetUserList["NameFirst"].'</option>
                ';

            }
            $Input[]=array("VariableName"=>"PhoneHome","Caption"=>"Team Members","ControlHTML"=>'

			        <input type="hidden" name="TeamLeader" id="TeamLeader" value="'.$TheEntityName["TeamLeader"].'">

                    <select style="height: 300px; width: 300px;" id="options" name="TeamMembers" onclick="processSelection(event)"  multiple>
                        '.$SHTML.'
                    </select>			
                    <script>
                        function processSelection(event) {
                            event.preventDefault(); // Prevent default form submission
                
                            let selectedOptions = document.getElementById("options").selectedOptions;
                            let values = Array.from(selectedOptions).map(option => option.value).join(",");
                
                            document.getElementById("TeamLeader").value = values; 
                            event.target.submit(); // Submit the form after processing values
                        }
                    </script>			
			
			
			');





			$Input[]=array("VariableName"=>"PhoneHome","Caption"=>"User Permission","ControlHTML"=>'

				Project'.CTL_InputRadioSet($VariableName="OptionCategory", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionCategory"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>
				
				Project Location'.CTL_InputRadioSet($VariableName="OptionProjectLocation", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionProjectLocation"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				

				Products '.CTL_InputRadioSet($VariableName="OptionProduct", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionProduct"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				Vendor '.CTL_InputRadioSet($VariableName="OptionVendor", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionVendor"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				Contructor '.CTL_InputRadioSet($VariableName="OptionContructor", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionContructor"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				Advance Payable '.CTL_InputRadioSet($VariableName="OptionAdvancePayable", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionAdvancePayable"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				Sales '.CTL_InputRadioSet($VariableName="OptionSales", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionSales"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				Purchase Requisition '.CTL_InputRadioSet($VariableName="OptionPurchaseRequisition", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionPurchaseRequisition"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				Purchase Confirm '.CTL_InputRadioSet($VariableName="OptionPurchaseConfirm", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionPurchaseConfirm"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

			    Purchase Order '.CTL_InputRadioSet($VariableName="OptionPurchase", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionPurchase"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				Customer '.CTL_InputRadioSet($VariableName="OptionCustomer", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionCustomer"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				Employee List '.CTL_InputRadioSet($VariableName="OptionEmployee", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionEmployee"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				Income Expense Type '.CTL_InputRadioSet($VariableName="OptionIncomeExpenseType", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionIncomeExpenseType"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				Income Expense Head '.CTL_InputRadioSet($VariableName="OptionIncomeExpenseHead", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionIncomeExpenseHead"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				Income Expense Head Balance '.CTL_InputRadioSet($VariableName="OptionIncomeExpenseHeadBalance", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionIncomeExpenseHeadBalance"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				

				Cheque Manager '.CTL_InputRadioSet($VariableName="OptionCheckManager", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionCheckManager"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				CRM '.CTL_InputRadioSet($VariableName="OptionClientInfo", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionClientInfo"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
				'.CTL_InputCheck("{$VariableName}ViewAllLeads", $TheEntityName["{$VariableName}ViewAllLeads"], $Title="", $Class="FormInputCheck", $Style="").' View All Leads 
                <hr>


				Bank Cash '.CTL_InputRadioSet($VariableName="OptionBankCash", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionBankCash"]).'<br>

				Initial Bank Cash '.CTL_InputRadioSet($VariableName="OptionInitialBankCash", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionInitialBankCash"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				Accounting/Transaction '.CTL_InputRadioSet($VariableName="OptionTransaction", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionTransaction"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

				Purchase Report '.CTL_InputRadioSet($VariableName="OptionReport", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionReport"]).'<br>

				

				Sales Report '.CTL_InputRadioSet($VariableName="OptionSalesReport", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionSalesReport"]).'<br>

				

				Settings '.CTL_InputRadioSet($VariableName="OptionSettings", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionSettings"]).'<br>
				
                <hr>
				Users '.CTL_InputRadioSet($VariableName="OptionUsers", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["OptionUsers"]).'<br>
				'.CTL_InputCheck("{$VariableName}View", $TheEntityName["{$VariableName}View"], $Title="", $Class="FormInputCheck", $Style="").' View
				'.CTL_InputCheck("{$VariableName}Add", $TheEntityName["{$VariableName}Add"], $Title="", $Class="FormInputCheck", $Style="").' Add
				'.CTL_InputCheck("{$VariableName}Edit", $TheEntityName["{$VariableName}Edit"], $Title="", $Class="FormInputCheck", $Style="").' Edit
				'.CTL_InputCheck("{$VariableName}Delete", $TheEntityName["{$VariableName}Delete"], $Title="", $Class="FormInputCheck", $Style="").' Delete
                <hr>

	

			');







            $Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);



	$MainContent.=FormInsertUpdate(

		$EntityName=$EntityLower,

		$FormTitle,

		$Input,

		$ButtonCaption,

		$ActionURL

	);

?>