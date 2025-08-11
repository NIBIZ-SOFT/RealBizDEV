<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
    $FormTitle="Insert $EntityCaption";
    $ButtonCaption="Insert";
    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction");

	// The default value of the input box will goes here according to how many fields we showing
    $TheEntityName=array(
       
		"ProjectID"=>"",
		"ExpenseHeadID"=>"",
		"Description"=>"",
		"BudgetDate"=>"",
		
       "{$Entity}IsActive"=>1
	);

	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"])&&!isset($_REQUEST["DeleteConfirm"])){
	    $UpdateMode=true;
	    $FormTitle="Update $EntityCaption";
	    $ButtonCaption="Update";
	    $ActionURL=ApplicationURL("{$_REQUEST["Base"]}","Insertupdateaction", $Entity."ID={$_REQUEST[$Entity."ID"]}&".$Entity."UUID={$_REQUEST[$Entity."UUID"]}");
		if($UpdateMode&&!isset($_POST["".$Entity."ID"]))$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'", $OrderBy="{$OrderByValue}", $SingleRow=true);
	}


//	echo "<pre>";
//	print_r($TheEntityName);
//	die();

	// Input sytem display goes here
	        $Input=array();

            $Input[]=array("VariableName"=>"CategoryID","Caption"=>"Projects's Name","ControlHTML"=>CCTL_ProductsCategory($Name="CategoryID", $TheEntityName["CategoryID"] , $Where="", $PrependBlankOption=true, "required" ));

            $Input[] = array("VariableName" => "ExpenseId", "Caption" => "Expense Head ", "ControlHTML" => GetExpenseID($Name = "ExpenseHeadID", $TheEntityName["ExpenseHeadID"], $Where = "", $PrependBlankOption = true));

            $Input[]=array("VariableName"=>"BudgetQuantity","Caption"=>"Budget Quantity","ControlHTML"=>CTL_InputText("BudgetQty",$TheEntityName["BudgetQty"],"", 30,"required"));

            $Input[]=array("VariableName"=>"Description","Caption"=>"Description","ControlHTML"=>CTL_InputText("Description",$TheEntityName["Description"],"", 30,"not required"));

            $Input[]=array("VariableName"=>"BudgetDate","Caption"=>"BudgetDate","ControlHTML"=>CTL_InputTextDate("BudgetDate",$TheEntityName["BudgetDate"],"", 30,"required date"));
			
            $Input[]=array("VariableName"=>"IsActive", "Caption"=>"Active?", "ControlHTML"=>CTL_InputRadioSet($VariableName="{$Entity}IsActive", $Captions=array("Yes", "No"), $Values=array(1, 0), $CurrentValue=$TheEntityName["{$Entity}IsActive"]), "Required"=>false);

            $MainContent.=FormInsertUpdate(
                $EntityName=$EntityLower,
                $FormTitle,
                $Input,
                $ButtonCaption,
                $ActionURL
            );



            $MainContent.='
            
                <script> 
                    $(document).on("submit","form",function(e) {
                        var mainThis=$(this);
                        
                        var CategoryIdDOM=mainThis.find("select[name=CategoryID]");
                        var ExpenseHeadIdDOM=mainThis.find("select[name=ExpenseHeadID]");
                        var BudgetQtyDOM=mainThis.find("input[name=BudgetQty]");
                        var BudgetDateDOM=mainThis.find("input[name=BudgetDate]");
                        
                        
                        Validateion(CategoryIdDOM);
                        Validateion(ExpenseHeadIdDOM);
                        Validateion(BudgetQtyDOM);
                        Validateion(BudgetDateDOM);
                        
                        
                        function Validateion(DOM) {
                            
                             if ( DOM.val() ==""){
                                DOM.css("border","1px solid red");
                                e.preventDefault();
                                
                            } else{
                                 DOM.css("border","1px solid rgba(0,0,0,.1)");
                            }  
                          
                        }
                         
                        
                    });
                </script>
            
            ';



?>