<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 5/2/2019
 * Time: 3:09 PM
 */

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

        $sl=1;
        $TitleText = "Todays Followup";

        
        date_default_timezone_set("Asia/Dhaka");
        $TDate = date('Y-m-d');

        $UserPermission = SQL_Select("User", "UserID={$_SESSION["UserID"]}", "", "True");

        //print_r($UserPermission);
        //echo $UserPermission["TeamLeader"];
        if ($UserPermission["TeamLeader"] != "") {
            $TLList1 = explode(",", $UserPermission["TeamLeader"]);
            //echo count($TLList1);
            if (count($TLList1) > 1) {
                foreach ($TLList1 as $TL) {
                    $TLHTML1 .= "  AssignTo ={$TL} or";
                }
                $TLHTML1 = " or " . substr($TLHTML1, 0, strlen($TLHTML1) - 2);
            }else{
                if($UserPermission["TeamLeader"]>0)
                    $TLHTML1 =  " or AssignTo ={$UserPermission["TeamLeader"]}";
            }
        }


        //$Where = "(UserIDInserted ={$_SESSION['UserID']} or ) and {$_REQUEST["SearchCombo"]} LIKE '%{$_POST["FreeText"]}%'";

        //$TLHTML1 = "";
        //echo $TLHTML1;

        //$CRMList = SQL_Select("CRMDetails","DATE(DateInserted) = CURDATE()");
        $CRMList = SQL_Select("CRMDetails","(AssignTo ={$_SESSION['UserID']} {$TLHTML1}) and CallDate='{$TDate}' group by CRMID");

        foreach($CRMList as $ThisCRMList){

            $CRMData = SQL_Select("CRM","CRMID = {$ThisCRMList["CRMID"]}","",true);

            $CRMCall = SQL_Select("CRMDetails","CRMID ={$ThisCRMList["CRMID"]} and CRMType='Call' ");
            $CRMMeeting = SQL_Select("CRMDetails","CRMID ={$ThisCRMList["CRMID"]} and CRMType='Meeting' ");
            
            $TotalCall = $TotalCall + count($CRMCall);
            $TotalMeeting = $TotalMeeting + count($CRMMeeting);
            
            $trHtml .= '
                <tr>
                    <td class="text-center">' . $sl . '.</td>
                    <td class="text-left">' . $CRMData["CustomerName"] . '</td>
                    <td class="text-center">' . $CRMData["LeadsStatus"] . '</td>
                    <td class="text-center">' . $CRMData["LeadSource"] . '</td>
                    <td class="text-center">' . $CRMData["Phone"] . '</td>
                    <td class="text-center">' . date_format(date_create($ThisCRMList["NextCallDate"]),"Y-m-d") . '</td>
                    <td class="text-center">' . count($CRMCall) . '</td>
                    <td class="text-center">' . count($CRMMeeting) . '</td>
                    <td class="text-center">' . $ThisCRMList["AssignToName"] . '
                    </td>
                    <td class="text-center">
                        <a href="./index.php?Theme=default&Base=CRMDetails&Script=Manage&ActionNewCRMDetails=1&CRMType=Call&GotoCRM=Yes&CRMID='.$ThisCRMList["CRMID"].'"><span class="btn btn-success" title="Add Call">Add Call</span> </a>                    
                    </td>

                </tr>
            ';
        
            $sl++;
        }        
        

$MainContent .= '

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Project Wise Report CRM</title>

    <style>
        .m-b-30 {
            margin-bottom: 30px;
        }

        .m-t-30 {
            margin-top: 30px;
        }
        
          .table-bordered th, .table-bordered td {
                border: 1px solid rgba(0,0,0,.3) !important;
          }
          
          .company-name{
            border-bottom: 1px solid rgba(0,0,0,.3);
          }

    </style>
</head>
<body>


<div style="width: 95%; margin: auto">
    <p style="font-size: 16px">Printing Date & Time: ' . date('F j-y, h:i:sa') . '</p>
</div>
<div style="width: 95%; margin: auto">

    <div style="padding: 10px 0px;" class="company-name row">
        <div class="col-md-2 text-center">
            <img height="70px" src="./upload/' . $Settings["logo"] . '" alt="">
        </div>
        <div class="col-md-9 text-center">
            <h3 style="font-weight: bold">' . $Settings["CompanyName"] . '</h3>
            <p style="font-size: 18px;">' . $Settings["Address"] . '</p>

        </div>

    </div>

    <div class="projectName text-center m-b-30 m-t-30">
        <h4 style="font-weight: bold">'.$TitleText.'</h4>

        Total Client : '.($sl-1).' &nbsp;&nbsp;|&nbsp;&nbsp; Total Call : '.$TotalCall.' &nbsp;&nbsp;|&nbsp;&nbsp; Total Meeting : '.$TotalMeeting.' 
    </div>
    
    
    <table style="font-size: 16px" class="table table-bordered table-hover table-fixed table-sm">

        <thead>
            <tr>
                <th colspan="17" scope="col" class="text-center"><h6 style="font-weight: bold;">'.GetProjectName($_REQUEST["CategoryID"]).'</h6></th>
            </tr>
            <tr style="text-align: center">
                <td>Serial No.</td>
                <td>Client Name</td>
                <td>Lead Status</td>
                <td>Lead Source</td>
                <td>Contact Number</td>
                <td>Date</td>
                <td>Total Call</td>
                <td>Total Meeting</td>
                <td>Assigned User</td>
                <td>Option</td>

            </tr>

        </thead>

        <tbody>
              
            ' . $trHtml . '
             
            
        </tbody>

    </table>

</div>';
