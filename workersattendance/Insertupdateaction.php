<?php

include "./script/" . $_REQUEST["Base"] . "/Scriptvariables.php";

$ErrorUserInput = array();
$ErrorUserInput["_Error"] = false;

$worker_ids = isset($_POST["worker_id"]) ? $_POST["worker_id"] : array();
$statuses   = isset($_POST["status"]) ? $_POST["status"] : array();
$hours      = isset($_POST["work_hours"]) ? $_POST["work_hours"] : array();
$amounts    = isset($_POST["amount"]) ? $_POST["amount"] : array();
$remarks    = isset($_POST["remarks"]) ? $_POST["remarks"] : array();
$att_ids    = isset($_POST["WorkersattendanceID"]) ? $_POST["WorkersattendanceID"] : array();
$att_uuids  = isset($_POST["WorkersattendanceUUID"]) ? $_POST["WorkersattendanceUUID"] : array();
$date       = isset($_POST["date"]) ? addslashes($_POST["date"]) : date("Y-m-d");
$ProjectID       = isset($_POST["ProjectID"]) ? addslashes($_POST["ProjectID"]): "";

$UpdateMode = false;
foreach ($att_ids as $id) {
    if (!empty($id) && intval($id) > 0) {
        $UpdateMode = true;
        break;
    }
}

for ($i = 0; $i < count($worker_ids); $i++) {

    $worker_id = addslashes($worker_ids[$i]);
    $status    = isset($statuses[$i]) ? addslashes($statuses[$i]) : '';
    $work_hr   = isset($hours[$i]) ? addslashes($hours[$i]) : '0';
    $amount    = isset($amounts[$i]) ? addslashes($amounts[$i]) : '0';
    // Checkbox 'remarks' may not be set if unchecked, so:
    $remark    = isset($remarks[$i]) && $remarks[$i] === 'paid' ? 'paid' : 'unpaid';

    $att_id   = isset($att_ids[$i]) ? intval($att_ids[$i]) : 0;
    $att_uuid = isset($att_uuids[$i]) ? addslashes($att_uuids[$i]) : '';

    $Where = "";

    if ($UpdateMode && $att_id > 0 && $att_uuid != '') {
        // Update existing attendance
        $Where = "{$Entity}ID = {$att_id} AND {$Entity}UUID = '{$att_uuid}'";
    } else {
        // Insert mode: prevent duplicate entries
        $CheckAttendance = SQL_Select($Entity, "worker_id = '{$worker_id}' AND date = '{$date}'");
        if (count($CheckAttendance) > 0) {
            // Duplicate found - skip insert for this worker
            continue;
        }
    }

    // Insert or update attendance record
    SQL_InsertUpdate(
        $Entity,
        array(
            "worker_id"         => $worker_id,
            "ProjectID"         => $ProjectID,
            "date"              => $date,
            "status"            => $status,
            "work_hours"        => $work_hr,
            "amount"            => $amount,
            "remarks"           => $remark,
            "{$Entity}IsActive" => 1,
        ),
        $Where
    );

    // Update PayableLogs table accordingly
    $CheckPayable = SQL_Select("PayableLogs", "worker_id = '{$worker_id}' AND date = '{$date}'");
    $PayableWhere = "";
    if (count($CheckPayable) > 0) {
        $PayableWhere = "PayableLogsID = " . intval($CheckPayable[0]["PayableLogsID"]);
    }

    SQL_InsertUpdate(
        "PayableLogs",
        array(
            "worker_id"            => $worker_id,
            "date"                 => $date,
            "wage_per_day"         => $amount,
            "status"               => $remark,
            "is_generated"         => 1,
            "payable_logsIsActive" => 1,
        ),
        $PayableWhere
    );
}

// Success message + redirect
$MainContent .= "
    " . CTL_Window(
        "Attendance Management",
        "The operation completed successfully.<br><br>
        The {$EntityCaptionLower} information has been stored.<br><br>
        Please click <a href=\"" . ApplicationURL($_REQUEST["Base"], "Manage") . "\">here</a> to proceed.",
        300
    ) . "
    <script>
        window.location = '" . ApplicationURL($_REQUEST["Base"], "Manage") . "';
    </script>
";

?>
