<?php

$fromDate = isset($_POST['FromDate']) ? $_POST['FromDate'] : null;
$toDate = isset($_POST['ToDate']) ? $_POST['ToDate'] : null;
$projectID = isset($_POST['ProjectID']) ? $_POST['ProjectID'] : null;
$workerID = isset($_POST['WorkerID']) ? $_POST['WorkerID'] : null;

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);


if (!empty($fromDate) && !empty($toDate) && empty($projectID) && empty($workerID)) {
    $workAttendanceData = SQL_Select("workersattendance", "date BETWEEN '{$fromDate}' AND  '{$toDate}' order by WorkersattendanceID ASC");
} elseif (!empty($fromDate) && !empty($toDate) && !empty($projectID) && empty($workerID)) {
    $workAttendanceData = SQL_Select("workersattendance", "ProjectID='{$projectID}' and date BETWEEN '{$fromDate}' AND  '{$toDate}' order by WorkersattendanceID ASC");
} elseif (!empty($fromDate) && !empty($toDate) && empty($projectID) && !empty($workerID)) {
    $workAttendanceData = SQL_Select("workersattendance", "worker_id='{$workerID}' and date BETWEEN '{$fromDate}' AND  '{$toDate}' order by WorkersattendanceID ASC");
} elseif (!empty($fromDate) && !empty($toDate) && !empty($projectID) && !empty($workerID)) {
    $workAttendanceData = SQL_Select("workersattendance", "ProjectID='{$projectID}' and worker_id='{$workerID}' and date BETWEEN '{$fromDate}' AND  '{$toDate}' order by WorkersattendanceID ASC");
} else {
    $workAttendanceData = [];
}

$groupedData = [];
foreach ($workAttendanceData as $row) {
    $groupedData[$row["worker_id"]][] = $row;
}


$MainContent = '
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Worker Report</title>
  <style>
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }
    .page {
      width: 99%;
      height: 297mm;
      
      margin: 0 auto;
    }
    .invoice {
      height: 90mm; 
      page-break-inside: avoid;
      margin-bottom: 5mm;
      border: 1px solid #000;
      padding: 5px;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .logo {
      height: 60px;
    }
    .company-info {
      flex-grow: 1;
      text-align: center;
    }
    .project-infos {
      font-size: 12px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 12px;
    }
    table th, table td {
      border: 1px solid #000;
      padding: 5px;
      text-align: center;
    }
    .sign-section {
      display: flex;
      justify-content: space-between;
      margin-top: 10px;
    }
    .sign-box {
      text-align: center;
    }
    .sign-box span {
      display: inline-block;
      border-top: 1px solid #000;
      width: 100px;
      margin-top: 10px;
    }

    .project-info {
      display: flex;
      margin: 8px 0;
      justify-content: space-between;
    }


    .no-print button{
      color: #000;
      background-color: #0080ffff;
      padding: 10px;
    }
    @media print {
      .no-print {
        display: none;
      }
    }
  </style>
</head>
<body>
<div class="no-print" style="padding:10px; text-align:right;">
  <button onclick="window.print()">🖨️ Print</button>
</div>
';

$invoiceCounter = 0;
$MainContent .= '<div class="page">';

foreach ($groupedData as $workerID => $records) {
    $GetWorkerName = SQL_Select("Workers", "WorkersID={$workerID}", "", true);
    $workerTotal = 0;

    $MainContent .= '
    <div class="invoice">
      <div class="header">
        <img src="./upload/' . $Settings["logo"] . '" class="logo" alt="Logo">
        <div class="company-info">
          <div style="font-weight: bold; font-size: 36px;">' . $Settings["CompanyName"] . '</div>
          <div style="font-size: 12px;">' . $Settings["Address"] . '</div>
        </div>
        <div style="font-size: 14px;">Date: ' . date("d M Y") . '</div>
      </div>';

$MainContent .= '     
      <div class="project-info">
';
$MainContent .= '

      <div class="project-infos">
        <div style="font-size: 18px;">Worker Name:' . $GetWorkerName["name"] . ' <br>Worker ID:' . $workerID . ' </div>
     
      </div>';

$MainContent .= '
      <div class="project-infos mt-3">
        <div style="font-size: 18px; margin-left: 152px;">Payment Date:' . $fromDate . 'to' .$toDate . ' </div>
      </div>';  
      
      
if (isset($_POST['ProjectID']) && $_POST['ProjectID']) {
  $projectIDs = $_POST['ProjectID'];
  $GetProjectName =SQL_Select("Category","CategoryID={$projectIDs}","",true);
  $MainContent .= '
      <div class="project-infos">
        <div style="font-size: 18px;">Project Name:' . $GetProjectName["Name"] . ' <br> Project Location: ' . $GetProjectName["ProjectLoactionName"] . '</div>
        
      </div>';
} // if end here


$MainContent .= '     
      </div>';

$MainContent .= '
      <table>
        <thead>
          <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Hours</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody>';
    $sl = 1;
    foreach ($records as $rec) {
        $MainContent .= '
          <tr>
            <td>' . $sl++ . '</td>
            <td>' . $rec["date"] . '</td>
            <td>' . $rec["work_hours"] . '</td>
            <td>' . number_format($rec["amount"], 2) . '</td>
          </tr>';
        $workerTotal += floatval($rec["amount"]);
    }
    $MainContent .= '
        </tbody>
        <tfoot>
          <tr>
            <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
            <td><strong>' . number_format($workerTotal, 2) . '</strong></td>
          </tr>
        </tfoot>
      </table>

      <div class="sign-section">
        <div class="sign-box"><span></span><br>Worker Sign</div>
        <div class="sign-box"><span></span><br>Authority Sign</div>
      </div>
    </div>
    ';

    $invoiceCounter++;

    if ($invoiceCounter % 3 == 0) {
        $MainContent .= '</div><div class="page">';
    }
}

$MainContent .= '</div></body></html>';



?>
