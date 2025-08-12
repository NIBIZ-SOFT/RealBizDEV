<?
	include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

    $UpdateMode=false;
	if(isset($_REQUEST[$Entity."ID"])&&isset($_REQUEST[$Entity."UUID"]))$UpdateMode=true;

    $ErrorUserInput["_Error"]=false;

	if(!$UpdateMode)$_REQUEST["{$Entity}ID"]=0;
	//some change goes here
	$TheEntityName=SQL_Select($Entity="{$Entity}", $Where="{$UniqueField} = '{$_POST["{$UniqueField}"]}' AND {$Entity}ID <> {$_REQUEST[$Entity."ID"]}");
    if(count($TheEntityName)>0){
	    $ErrorUserInput["_Error"]=true;
	    $ErrorUserInput["_Message"]="This Value Already Taken.";
	    
	}

    if($ErrorUserInput["_Error"]){
        include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	}else{
	    $Where="";
	    if($UpdateMode)$Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'";

        $_POST["Attachment"]	=ProcessUpload("Attachment", $Application["UploadPath"]);

        $CCRM = SQL_Select("CRM","CRMID={$_SESSION["CRMID"]}","",true);

		// give the data dase fields name and the post value name
	    $TheEntityName=SQL_InsertUpdate(
	        $Entity="{$Entity}",
			$TheEntityNameData=array(
                                                                                              
        		"Type"=>$_POST["Type"],
        		"CallDate"=>$_POST["CallDate"],
        		"CallSummery"=>$_POST["CallSummery"],
        		"NextCallDate"=>$_POST["NextCallDate"],
        		"Responsible"=>$_POST["Responsible"],
        		"Location"=>$_POST["Location"],
        		"AttendPerson"=>$_POST["AttendPerson"],
        		"Attachment"=>$_POST["Attachment"],
        		"TaskName"=>$_POST["TaskName"],
        		"StartDate"=>$_POST["StartDate"],
        		"EndDate"=>$_POST["EndDate"],
        		"Progress"=>$_POST["Progress"],
        		"TaskStatus"=>$_POST["TaskStatus"],

        		"CRMType"=>$_REQUEST["CRMType"],


        		"CRMID"=>$_SESSION["CRMID"],
        		"{$Entity}IsDisplay"=>1,
        		
        		"AssignTo"=>$CCRM["AssignTo"],
        		"AssignToName"=>$CCRM["AssignToName"],        		
		
		        "{$Entity}IsActive"=>$_POST["{$Entity}IsActive"],
			),
			$Where
			);
			
        SQL_InsertUpdate(
	        $Entity="CRM",
			$TheEntityNameData=array(
        		"NextCallDate"=>$_POST["NextCallDate"],
			),
    			"CRMID={$_SESSION["CRMID"]}"
			);			
			
        if($_REQUEST["GotoCRM"]=="Yes"){
            $MainContent.="
                ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
                <br>
                The $EntityCaptionLower information has been stored.<br>
                <br>
                Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","Manage&CRMType={$_REQUEST["CRMType"]}")."\">here</a> to proceed.",300)."
                <script language=\"JavaScript\" >
                    window.location='".ApplicationURL("CRM","Manage")."';
                </script>
            ";
        }else
            $MainContent.="
                ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
                <br>
                The $EntityCaptionLower information has been stored.<br>
                <br>
                Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","Manage&CRMType={$_REQUEST["CRMType"]}")."\">here</a> to proceed.",300)."
                <script language=\"JavaScript\" >
                    window.location='".ApplicationURL("{$_REQUEST["Base"]}","Manage&CRMType={$_REQUEST["CRMType"]}")."';
                </script>
            ";
	}
?>