<?php
$Settings = SQL_Select("Settings", "SettingsID = 1", "", true);

$FromDate    = $_POST["FromDate"];
$ToDate      = $_POST["ToDate"];
$CategoryID  = $_POST["CategoryID"];
$VendorID    = $_POST["VendorID"];

if (empty($ToDate)) {
    $ToDate = date("Y-m-d");
}

// Vendors
if (!empty($VendorID)) {
    $Vendors = SQL_Select("vendor where VendorID = $VendorID");
} else {
    $Vendors = SQL_Select("vendor"); // all vendors
}

// Categories
if (!empty($CategoryID)) {
    $Categories = SQL_Select("category where CategoryID = $CategoryID");
} else {
    $Categories = SQL_Select("category"); // all categories
}

$MainContent = '
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Ledger Report</title>
    <style>
        .m-b-30{ margin-bottom: 30px; }
        .m-t-30{ margin-top: 30px; }
        .table-bordered th, .table-bordered td { border: 1px solid rgba(0,0,0,.3) !important; }
        .company-name{ border-bottom: 1px solid rgba(0,0,0,.3); }
        .btn-group { width: 95%; margin: 20px auto; text-align: right; }
    </style>
</head>
<body>

<div style=" float: right; margin-top: 20px; margin-right: 20px; ">
    <button class="btn btn-primary" onclick="window.print()">Print</button>
    <button class="btn btn-danger" onclick="generatePDF()">Download PDF</button>
</div>

<div id="report-content">
<div style="width: 95%; margin: auto">
    <p style="font-size: 16px">Printing Date & Time: '.date('F j-y, h:i:sa').'</p>
</div>
';
        $MainContent .= '
        <div style="width: 95%; margin: auto">
            <div style="padding: 10px 0px;" class="text-center company-name">
                <img style="width: 127px;position: relative;float: left;" src="./upload/' . $Settings["logo"] . '" alt="">
                <h3 style="font-weight: bold">'.$Settings["CompanyName"].'</h3>
                <p style="font-size: 18px;">'.$Settings["Address"].'</p>
                <p style="font-size: 18px;">Project Name - '.$ProjectName.'</p>
                <p style="font-size: 18px;"><strong>Period:</strong> '.date("d-m-Y", strtotime($FromDate)).' to '.date("d-m-Y", strtotime($ToDate)).'</p>
            </div>

            <div class="projectName text-center m-b-30 m-t-30">
                <h4 style="font-weight: bold;">'.$VendorName.' loan ac Ledger</h4>
            </div>

            <table class="table table-bordered" style="margin-bottom: 30px;">
                <tbody>
                    <tr style="text-align: center;">
                        <th>SL</th>
                        <th style="width: 124px">Date</th>
                        <th>Head Of Account Name</th>
                        <th>Description</th>
                        <th>VoucherType</th>
                        <th>Voucher No</th>
                        <th>Vendor Name</th>
                        <th>Credit</th>
                        <th>Debit</th>
                    </tr>';
foreach ($Vendors as $vendor) {
    $VendorID   = $vendor["VendorID"];
    $VendorName = $vendor["VendorName"];

    foreach ($Categories as $category) {
        $CategoryID  = $category["CategoryID"];
        $ProjectName = $category["Name"];

        // Build where
        $where = "VendorID = '{$VendorID}'";
        if (!empty($CategoryID)) {
            $where .= " AND ProjectID = '{$CategoryID}'";
        }
        if (!empty($FromDate) && !empty($ToDate)) {
            $where .= " AND Date BETWEEN '{$FromDate}' AND '{$ToDate}'";
        }

        $transactions = SQL_Select("transaction", $where);

        $sl = 1;
        $TotalCredit = 0;
        $TotalDebit = 0;

        foreach($transactions as $row){

            if ($row["VoucherType"] == "JV" && $row["dr"] > 0) continue;

            $Credit = BangladeshiCurencyFormat($row["cr"]);
            $Debit  = BangladeshiCurencyFormat($row["dr"]);

            $TotalCredit += $row["cr"];
            $TotalDebit  += $row["dr"];

            $VendorNameRow = "";
            if($row["VendorID"]){
                $VendorRow = SQL_Select("vendor where VendorID = {$row["VendorID"]}", "", "", true);
                $VendorNameRow = $VendorRow["VendorName"];
            }

            $MainContent .= '
                <tr>
                    <td style="text-align: center">'.$sl.'</td>
                    <td style="text-align: center">'.date('d-m-Y', strtotime($row["Date"])).'</td>
                    <td>'.$row["HeadOfAccountName"].'</td>
                    <td>'.$row["Description"].'</td>
                    <td style="text-align: center">'.$row["VoucherType"].'</td>
                    <td style="text-align: center">'.$row["VoucherNo"].'</td>
                    <td>'.$VendorNameRow.'</td>
                    <td style="text-align: right;">'.$Credit.'</td>
                    <td style="text-align: right;">'.$Debit.'</td>
                </tr>';
            $sl++;
        }

        // Totals

    }
}
        $MainContent .= '
                <tr>
                    <th colspan="7" style="text-align: right;">Total</th>
                    <th style="text-align: right;">'.BangladeshiCurencyFormat($TotalCredit).'</th>
                    <th style="text-align: right;">'.BangladeshiCurencyFormat($TotalDebit).'</th>
                </tr>
                <tr>
                    <th colspan="7" style="text-align: right;">Balance</th>
                    <th colspan="2" style="text-align: right;">'.BangladeshiCurencyFormat($TotalCredit-$TotalDebit).'</th>
                </tr>
            </tbody>
        </table>
        </div>';
$MainContent .= '
</div> <!-- end of report-content -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script>
    function generatePDF() {
        const element = document.getElementById("report-content");
        const opt = {
            margin: 0.5,
            filename: "Voucher_Report_'.date("d_m_Y").'.pdf",
            image: { type: "jpeg", quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: "in", format: "a4", orientation: "portrait" }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>

</body>
</html>';

?>
