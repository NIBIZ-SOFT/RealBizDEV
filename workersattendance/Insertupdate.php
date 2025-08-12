<?php

include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$FormTitle = "Manage Workers Attendance";
$ButtonCaption = "Submit";
$ActionURL = ApplicationURL("{$_REQUEST["Base"]}", "Insertupdateaction");

$date = isset($_GET["date"]) ? $_GET["date"] : "";
$project = isset($_GET["ProjectID"]) ? $_GET["ProjectID"] : "";
$FilterApplied = ($project !== "" && $date !== "");

$workers = $attendanceData = $payableData = [];

if ($FilterApplied) {
    $whereWorkers = "WorkersIsActive = 1 AND ProjectID = '$project'";
    $workers = SQL_Select("workers", $whereWorkers);

    $attendanceRows = SQL_Select("workersattendance", "date = '$date'");
    foreach ($attendanceRows as $row) {
        $attendanceData[$row["worker_id"]] = $row;
    }

    $payableRows = SQL_Select("PayableLogs", "date = '$date'");
    foreach ($payableRows as $row) {
        $payableData[$row["worker_id"]] = $row["status"];
    }
}

$MainContent = '

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    .form-check-inline .form-check-input {
        margin-top: 0.3rem;
    }
    .table td, .table th {
        vertical-align: middle !important;
    }
</style>
';

$MainContent .= '<form method="post" action="' . $ActionURL . '" enctype="multipart/form-data">';
$MainContent .= '<div class="card mb-4">';
$MainContent .= '<div class="card-header text-dark" style="background: #17a2b8;"><h5 class="mb-0">' . $FormTitle . '</h5></div>';
$MainContent .= '<div class="card-body">';

 
$MainContent .= '<div class="row mb-3 align-items-end">';
$MainContent .= '<div class="col-md-4">';
$MainContent .= '<label for="date" class="form-label">Date</label>';
$MainContent .= CTL_InputTextDate("date", $date, "", 30, "required class='form-control'");
$MainContent .= '</div>';
$MainContent .= '<div class="col-md-4">';
$MainContent .= '<label for="ProjectID" class="form-label">Project Name</label>';
$MainContent .= CCTL_ProductsCategory("ProjectID", $project, "Select Project", true, "required");
$MainContent .= '</div>';
$MainContent .= '<div class="col-md-2">';
$MainContent .= '<label class="form-label">&nbsp;</label>';
$MainContent .= '<button type="button" onclick="reloadWithDate()" class="btn btn-info">Go</button>
<a id="printBtn" href="#" class="btn btn-success">Print</a>
';
$MainContent .= '</div>';
$MainContent .= '<div class="col-md-6">';
$MainContent .= '<div class="form-check mt-4">';
$MainContent .= '<input type="checkbox" id="select_all_paid" class="form-check-input">';
$MainContent .= '<label for="select_all_paid" class="form-check-label">Select All (Paid/Unpaid)</label>';
$MainContent .= '</div></div>';
$MainContent .= '</div>';

$MainContent .= '<div class="table-responsive">';
$MainContent .= '<table class="table table-bordered">';
$MainContent .= '<thead class="table-light">';
$MainContent .= '<tr>
    <th>Worker</th>
    <th>Status</th>
    <th>Work Hours</th>
    <th>Amount</th>
    <th class="text-center">Paid/Unpaid</th>
</tr></thead><tbody>';

if (!$FilterApplied) {
    $MainContent .= '<tr><td colspan="5" class="text-center text-muted">Please select a date and project to view attendance data.</td></tr>';
} elseif (empty($workers)) {
    $MainContent .= '<tr><td colspan="5" class="text-center text-danger">No workers found for selected project.</td></tr>';
} else {
    foreach ($workers as $i => $worker) {
        $id = $worker["WorkersID"];
        $data = isset($attendanceData[$id]) ? $attendanceData[$id] : [];

        $status = isset($data["status"]) ? $data["status"] : "";
        $work_hours = (isset($data["work_hours"]) && $data["work_hours"] !== '' && $data["work_hours"] !== null)
            ? $data["work_hours"]
            : (isset($worker["work_hours"]) ? $worker["work_hours"] : '');

        $amount = (isset($data["amount"]) && $data["amount"] !== '' && $data["amount"] !== null)
            ? $data["amount"]
            : (isset($worker["daily_wage"]) ? $worker["daily_wage"] : '');

        $uuid = isset($data["WorkersattendanceUUID"]) ? $data["WorkersattendanceUUID"] : "";
        $attID = isset($data["WorkersattendanceID"]) ? $data["WorkersattendanceID"] : "";
        $paid = isset($payableData[$id]) && $payableData[$id] == "paid";

        $MainContent .= '<tr>';
        $MainContent .= '<input type="hidden" name="worker_id[' . $i . ']" value="' . $id . '">';
        $MainContent .= '<input type="hidden" name="WorkersattendanceID[' . $i . ']" value="' . $attID . '">';
        $MainContent .= '<input type="hidden" name="WorkersattendanceUUID[' . $i . ']" value="' . $uuid . '">';
        $MainContent .= '<td>' . htmlspecialchars($worker["name"]) . '</td>';

        $MainContent .= '<td>
            <div class="form-check form-check-inline">
                <input id="present[' . $i . ']" class="form-check-input" type="radio" name="status[' . $i . ']" value="present" ' . ($status == "present" ? "checked" : "") . ' checked>
                <label for="present[' . $i . ']" class="form-check-label">Present</label>
            </div>
            <div class="form-check form-check-inline">
                <input id="absent[' . $i . ']" class="form-check-input" type="radio" name="status[' . $i . ']" value="absent" ' . ($status == "absent" ? "checked" : "") . '>
                <label for="absent[' . $i . ']" class="form-check-label">Absent</label>
            </div>
            <div class="form-check form-check-inline">
                <input id="leave[' . $i . ']" class="form-check-input" type="radio" name="status[' . $i . ']" value="leave" ' . ($status == "leave" ? "checked" : "") . '>
                <label for="leave[' . $i . ']" class="form-check-label">Leave</label>
            </div>
        </td>';

        $MainContent .= '<td><input type="number" step="0.01" class="form-control work-hours" name="work_hours[' . $i . ']" value="' . $work_hours  . '" required></td>';
        $MainContent .= '<td><input type="number" step="0.01" class="form-control amount" name="amount[' . $i . ']" value="' . $amount . '" required></td>';
        $MainContent .= '<td class="text-center">
            <input type="checkbox" class="form-check-input paid_status" name="remarks[' . $i . ']" value="paid" ' . ($paid ? "checked" : "") . '>
        </td>';
        $MainContent .= '</tr>';
    }
}

$MainContent .= '</tbody></table></div>';
$MainContent .= '<div class="text-end mt-3"><button type="submit" class="btn btn-success">' . $ButtonCaption . '</button></div>';
$MainContent .= '</div></div>';
$MainContent .= '</form>';

// JavaScript
$MainContent .= '
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function reloadWithDate() {
    var selectedDate = document.getElementsByName("date")[0].value;
    var selectedProject = document.getElementsByName("ProjectID")[0].value;
    if (selectedDate && selectedProject) {
        window.location.href = "index.php?Theme=default&Base=workersattendance&Script=Manage&ActionNewworkersattendance=1&date=" + selectedDate + "&ProjectID=" + selectedProject;
    }
}

$(function () {
    $("#select_all_paid").on("change", function () {
        $(".paid_status").prop("checked", $(this).prop("checked"));
    });

    $("body").on("change", "input[type=radio]", function () {
        var val = $(this).val();
        var row = $(this).closest("tr");
        if (val === "absent" || val === "leave") {
            row.find(".paid_status").prop("checked", false);
            row.find(".work-hours").val("0.00");
            row.find(".amount").val("0.00");
        }
    });

    $(".paid_status").on("change", function () {
        if (!$(this).prop("checked")) {
            $("#select_all_paid").prop("checked", false);
        }
    });
});

$("#printBtn").on("click", function(e) {
    e.preventDefault();
    var selectedDate = document.getElementsByName("date")[0].value;
    var selectedProject = document.getElementsByName("ProjectID")[0].value;

    if (selectedDate && selectedProject) {
        var url = "index.php?Theme=default&Base=workersattendance&Script=Invoice&NoHeader&NoFooter";
        url += "&date=" + encodeURIComponent(selectedDate);
        url += "&ProjectID=" + encodeURIComponent(selectedProject);
        window.open(url, "_blank");
    } else {
        alert("Please select both Date and Project before printing.");
    }
});
</script>
';

// echo $MainContent;
?>
