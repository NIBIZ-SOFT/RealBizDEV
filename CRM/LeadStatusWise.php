<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 5/2/2019
 * Time: 3:09 PM
 */

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

$FromDate = $_REQUEST["FromDate"];
$ToDate = $_REQUEST["ToDate"];

//Type=LeadsStatus


if (!empty($_REQUEST["FromDate"]) and !empty($_REQUEST["ToDate"])) {


//    all Project
        $sl=1;
        if($_REQUEST["Type"]=="LeadsStatus"){
            // $CRMJunk = SQL_Select("CRM","LeadsStatus ='{$_REQUEST["LeadsStatus"]}'  and LeadsStatus='Fake' ");
            // $CRMBooked = SQL_Select("CRM","LeadsStatus ='{$_REQUEST["LeadsStatus"]}'  and LeadsStatus='Booked' ");
            // $CRMFollowUp = SQL_Select("CRM","LeadsStatus ='{$_REQUEST["LeadsStatus"]}'  and LeadsStatus='Follow Up' ");

            $CRMList = SQL_Select("CRM","LeadsStatus ='{$_REQUEST["LeadsStatus"]}' and Date BETWEEN '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}'");
            $TitleText = "Lead Status Wise Report";

        }       
        
        if($_REQUEST["Type"]=="LeadSource"){
            $CRMList = SQL_Select("CRM","LeadSource ='{$_REQUEST["LeadSource"]}' and Date BETWEEN '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}'");
            $TitleText = "Lead Source Wise Report";

        }
        
        if($_REQUEST["Type"]=="AssignedUser"){
            $CRMList = SQL_Select("CRM","AssignTo ='{$_REQUEST["AssignTo"]}' and Date BETWEEN '{$_REQUEST["FromDate"]}' and '{$_REQUEST["ToDate"]}'");
            $TitleText = "Assigned User Wise Report";
        
            
        }
        
        foreach($CRMList as $ThisCRMList){
            
            $CRMCall = SQL_Select("CRMDetails","CRMID ={$ThisCRMList["CRMID"]} and CRMType='Call' ");
            $CRMMeeting = SQL_Select("CRMDetails","CRMID ={$ThisCRMList["CRMID"]} and CRMType='Meeting' ");
            
            $TotalCall = $TotalCall + count($CRMCall);
            $TotalMeeting = $TotalMeeting + count($CRMMeeting);
            
            $trHtml .= '
                <tr>
                    <td class="text-center">' . $sl . '.</td>
                    <td class="text-left">' . $ThisCRMList["CustomerName"] . '</td>
                    <td class="text-center">' . $ThisCRMList["LeadsStatus"] . '</td>
                    <td class="text-center">' . $ThisCRMList["LeadSource"] . '</td>
                    <td class="text-center">' . $ThisCRMList["Phone"] . '</td>
                    <td class="text-center">' . $ThisCRMList["Date"] . '</td>
                    <td class="text-center">' . count($CRMCall) . '</td>
                    <td class="text-center">' . count($CRMMeeting) . '</td>
                    <td class="text-center">' . $ThisCRMList["AssignToName"] . '</td>

                </tr>
            ';
        
            $sl++;
        }


}

// } else {

//     header("location: index.php?Theme=default&Base=Report&Script=Manage");
// }


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
        <p class="text-right">From: '.$FromDate.' To:  '.$ToDate.'</p>
        
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

            </tr>

        </thead>

        <tbody>
              
            ' . $trHtml . '
             
            
        </tbody>

    </table>

</div>';
