<?php

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

$date = $_GET['date'];
$project = $_GET['ProjectID'];

$workersAttendance = SQL_Select("workersattendance where date='$date' AND ProjectID='$project'");

$MainContent = '<!DOCTYPE html><html><head><meta charset="UTF-8">
<title>Worker Payment Invoices</title>
<style>
    * { box-sizing: border-box; }
    body { margin: 0; padding: 10px; font-family: Arial, sans-serif; font-size: 11px; }
    
    .invoice-page {
        height: 7.5cm;
        display: flex;
        flex-direction: column;
        width: 95%;
        margin: 0 auto;
        border: 1px solid #000;
        padding: 8px;
        box-sizing: border-box;
        margin-bottom: 0.5cm;
        page-break-inside: avoid;
        justify-content: space-between;
    }
    .header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    .logo { height: 45px; text-align: center; line-height: 45px; font-size: 10px; }
    .company-info { text-align: center; line-height: 1.2; }
    .date { font-size: 14px; }
    table { width: 100%; border-collapse: collapse; margin-top: 6px; }
    th, td {
        border: 1px solid #000;
        padding: 4px;
        text-align: center;
        font-size: 14px;
        font-weight: 700;
    }
    .project-info {
        margin-top: 4px;
        font-size: 13px;
        font-weight: bold;
    }
    .sign-section { display: flex; justify-content: space-between; margin-top: 10px; }
    .sign-box { text-align: center; }
    .sign-line { margin-top: 25px; border-top: 1px solid #000; width: 100px; margin-left: auto; margin-right: auto; }
    @media print {
        body { margin: 0; }
        .invoice-page { 
            page-break-inside: avoid; 
            page-break-after: auto;
            break-inside: avoid; /* for modern browsers */
        }
    }
</style>
</head><body>
';

$counter = 0;
foreach ($workersAttendance as $row) {
    $MainContent .= '<div class="invoice-page">';
    $GetWorkerName =SQL_Select("Workers","WorkersID={$row["worker_id"]}","",true);
    $GetProjectName =SQL_Select("Category","CategoryID={$row["ProjectID"]}","",true);


    $MainContent .= '<div class="header">
            <div class="logo"><img src="./upload/' . $Settings["logo"] . '" class="logo-img" alt="Logo"></div>
            <div class="company-info">
                <span style="font-size: 30px;"><strong>' . $Settings["CompanyName"] . '</strong></span><br>
                ' . $Settings["Address"] . '<br>
            </div>
            <div class="date"><strong>Print Date:</strong> ' . date('F j, Y h:i A') . '</div>
        </div>
        <table style="width: 100%; border-collapse: collapse; margin-top: 6px; font-size: 13px; font-weight: bold;">
            <tr>
                <td style="border: 1px solid #000; padding: 4px;">Project Name: ' . $GetProjectName["Name"] . '</td>
                <td style="border: 1px solid #000; padding: 4px;">Location: ' . $GetProjectName["ProjectLoactionName"] . '</td>
                <td style="border: 1px solid #000; padding: 4px;">Payment Date: ' . date("F j, Y", strtotime($row["date"])) . '</td>
            </tr>
        </table>
        <table>
            <thead>
                <tr>
                    <th>Worker Name</th>
                    <th>Work Hour</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>' . $GetWorkerName["name"] . '</td>
                    <td>' . $row["work_hours"] . '</td>
                    <td>' . $row["amount"] . '</td>
                </tr>
            </tbody>
        </table>

        <div class="sign-section">
            <div class="sign-box">
                <div class="sign-line"></div>
                Worker Sign
            </div>
            <div class="sign-box">
                <div class="sign-line"></div>
                Authority Sign
            </div>
        </div>';

    $MainContent .= '</div>'; 
    $counter++;
}

$MainContent .= '</body></html>';
