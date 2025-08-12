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
	    
	    $MainContent.= '
	        <script>
	        
	            alert("Phone Number Already Inserted");
	        </script>
	    
	    ';	    
	    
	}

    if($_POST["ProjectID"]==""){
	    $ErrorUserInput["_Error"]=true;
	    $ErrorUserInput["_Message"]="Project Not Selected";
	    $MainContent.=  '
	        <script>
	        
	            alert("Project Not Selected");
	        </script>
	    
	    ';
    }
    
    
    if($ErrorUserInput["_Error"]){
        include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
	}else{
	    $Where="";
	    if($UpdateMode)$Where="{$Entity}ID = {$_REQUEST[$Entity."ID"]} AND {$Entity}UUID = '{$_REQUEST[$Entity."UUID"]}'";

        

		// give the data dase fields name and the post value name
	    $TheEntityName=SQL_InsertUpdate(
	        $Entity="{$Entity}",
			$TheEntityNameData=array(
                                                                                              
        		"Title"=>$_POST["Title"],
        		"CustomerName"=>$_POST["CustomerName"],
        		"LeadsStatus"=>$_POST["LeadsStatus"],
        		"LeadSource"=>$_POST["LeadSource"],
        		"Phone"=>$_POST["Phone"],
        		"ProjectName"=>GetProjectName($_POST["ProjectID"]),
        		"ProjectID"=>$_POST["ProjectID"],
        		"Description"=>$_POST["Description"],
        		"OrganizationName"=>$_POST["OrganizationName"],
        		"Email"=>$_POST["Email"],
        		"Date"=>$_POST["Date"],
        		"AssignTo"=>$_POST["AssignTo"],
        		"AssignToName"=>GetUserFName($_POST["AssignTo"]),

        		"CRMIsDisplay"=>1,
		
		        "{$Entity}IsActive"=>$_POST["{$Entity}IsActive"],
			),
			$Where
			);

            if($_REQUEST["CRMID"]!=""){
                SQL_InsertUpdate(
    	        "crmdetails",
    			$TheEntityNameData=array(
    
            		"AssignTo"=>$_POST["AssignTo"],
            		"AssignToName"=>GetUserFName($_POST["AssignTo"]),
    			),
    			"CRMID={$_REQUEST["CRMID"]}"
    			);
    			
            }


	    $MainContent.="
	        ".CTL_Window($Title="Application Setting Management", "The operation complete successfully and<br>
			<br>
			The $EntityCaptionLower information has been stored.<br>
			<br>
			Please click <a href=\"".ApplicationURL("{$_REQUEST["Base"]}","Manage")."\">here</a> to proceed.",300)."
	        <script language=\"JavaScript\" >
	            window.location='".ApplicationURL("{$_REQUEST["Base"]}","Manage")."';
	        </script>
		";
	}
?>