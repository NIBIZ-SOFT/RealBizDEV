<?php
$Settings = SQL_Select("Settings", "SettingsID=1", "", true);

$FromDate   = isset($_REQUEST["FromDate"])   ? $_REQUEST["FromDate"]   : '0000-00-00';
$ToDate     = isset($_REQUEST["ToDate"])     ? $_REQUEST["ToDate"]     : '0000-00-00';
$CategoryID = isset($_REQUEST["CategoryID"]) ? intval($_REQUEST["CategoryID"]) : 0;

if ($FromDate != '0000-00-00' && $ToDate != '0000-00-00') {
    $Count = 0;
    $sl = 1;
    $trHtml = "";

    $TotalCrAmount = 0;
    $TotalDrAmount = 0;
    $TotalDueAmount = 0;
    $TotalFlatPrice = 0;
    $TotalShareQty = 0;

    $ProjectName = "All Seller";
    if ($CategoryID > 0) {
        $categoryData = SQL_Select("category", "CategoryID=" . $CategoryID);
        $ProjectName  = isset($categoryData[0]["Name"]) ? $categoryData[0]["Name"] : "Unknown Seller";
    }

    $salesCondition = "SalesDate BETWEEN '" . $FromDate . "' AND '" . $ToDate . "'";
    if ($CategoryID > 0) {
        $salesCondition .= " AND ProjectID=" . $CategoryID;
    }

    // sales
    $SalesList = SQL_Select("sales", $salesCondition . " ORDER BY SalesDate ASC");

    foreach ($SalesList as $Sales) {
        $SalesID    = $Sales["SalesID"];
        $ProductID  = $Sales["ProductID"];
        $CustomerID = $Sales["CustomerID"];
        $SaleProject = SQL_Select("category", "CategoryID=" . $Sales["ProjectID"], "", true);

        $Discount = isset($Sales["Discount"]) ? $Sales["Discount"] : 0;
        $ShareQty = isset($Sales["Quantity"]) ? $Sales["Quantity"] : 0;

        // Product
        $ProductDetails = SQL_Select("products", "ProductsID=" . $ProductID);

        $ProductName  = isset($ProductDetails[0]["FlatType"]) ? $ProductDetails[0]["FlatType"] : "-";
        $ProductPrice = isset($ProductDetails[0]["NetSalesPrice"]) ? $ProductDetails[0]["NetSalesPrice"] : 0;
        $subTotal = ($ProductPrice * $ShareQty) - $Discount;
        $SalLer = SQL_Select("SalerName", "SalerNameID=" . $Sales["SellerID"], "", true);
        $SellerName = isset($SalLer["Name"]) ? $SalLer["Name"] : "-";
        $SalesDate  = isset($Sales["SalesDate"]) ? $Sales["SalesDate"] : "-";
        $Division   = isset($Sales["Division"]) ? $Sales["Division"] : "-";

        if ($ProductID != $_REQUEST["ProductID"]) {
            continue;
        }
        // --- CrV
        $CrVouchers = SQL_Select(
            "CrVoucher",
            "Date BETWEEN '" . $FromDate . "' AND '" . $ToDate . "' 
             AND CrVoucherIsDisplay=0 
             AND ProductsID=" . $ProductID . " 
             AND CustomerID=" . $CustomerID . " 
             ORDER BY Date ASC"
        );
        $CrAmount = 0;
        $CrVoucherNos = array();
        $LastCrDate = "";
        foreach ($CrVouchers as $Cr) {
            $CrAmount += $Cr["Amount"];
            $CrVoucherNos[] = $Cr["CrVoucherID"];
            $LastCrDate = $Cr["Date"];
        }

        // --- DrT
        $DrAmount = 0;
        $DrVoucherNos = array();
        $DrVouchers = SQL_Select(
            "Transaction",
            "Date BETWEEN '" . $FromDate . "' AND '" . $ToDate . "' 
             AND CustomerID=" . $CustomerID . " 
             ORDER BY Date ASC"
        );
        foreach ($DrVouchers as $Dr) {
            $DrAmount += $Dr["dr"];
            $DrVoucherNos[] = $Dr["VoucherNo"];
        }

        // Sum
        $DueAmount = $subTotal - ($CrAmount - $DrAmount);
        $PercentCollection = ($subTotal > 0) ? (($CrAmount - $DrAmount) / $subTotal) * 100 : 0;

        $CustomerName  = GetCustomerName($CustomerID);
        $CustomerPhone = GetCustomerPhone($CustomerID);

        $trHtml .= "
        <tr style='text-align:center;'>
            <td>" . $sl . "<br>SID:" . $SalesID . "</td>
            <td>" . $SaleProject["Name"] . "</td>
            <td class='text-left'>" . $CustomerName . " - ID: " . $CustomerID . "<br>" . $CustomerPhone . "</td>
            <td class='text-left'>" . $SellerName . "</td>
            <td>" . $SalesDate . "</td>
            <td>" . $LastCrDate . "</td>
            <td>" . $Division . "</td>
            <td>" . $ProductName . "</td>
            <td class='text-right'>" . BangladeshiCurencyFormat($ProductPrice) . "/-</td>
            <td class='text-right'>" . $ShareQty . "</td>
            <td class='text-right'>" . BangladeshiCurencyFormat($Discount) . "/-</td>
            <td class='text-right'>" . BangladeshiCurencyFormat($subTotal) . "/-</td>
            <td class='text-right'>" . BangladeshiCurencyFormat($CrAmount) . "/-</td>
            <td class='text-right'>" . number_format($PercentCollection, 2) . "%</td>
            <td class='text-right'>" . BangladeshiCurencyFormat($DueAmount) . "/-</td>
            <td class='text-right'>" . BangladeshiCurencyFormat($CrAmount - $DrAmount) . "/-</td>
            <td class='text-right'>" . BangladeshiCurencyFormat($DrAmount) . "/-</td>
            <td class='text-right'>" . implode(', ', $CrVoucherNos) . "</td>
            <td class='text-right'>" . implode(', ', $DrVoucherNos) . "</td>
        </tr>";

        // Totals
        $TotalCrAmount += $CrAmount;
        $TotalDrAmount += $DrAmount;
        $TotalDueAmount += $DueAmount;
        $TotalFlatPrice += $subTotal;
        $TotalShareQty += $ShareQty;
        $sl++;
        $Count++;
    }
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

    <title>Package Name Wise Ledger Summary</title>


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
        <h4 style="font-weight: bold">Package Name Wise Ledger Summary </h4>
        <p class="text-right">From: ' . $FromDate . ' To:  ' . $ToDate . '</p>
    </div>
    
    <button class="btn btn-info" onclick="exportToCSV()">Export to CSV</button>
    <button class="btn btn-success" onclick="exportToExcel()">Export to Excel</button>
    <table style="font-size: 16px" id="myTable" class="mt-4 table table-bordered table-hover table-fixed table-sm">

        <thead>
            <tr>
                <th colspan="16" scope="col" class="text-center"><h6 style="font-weight: bold;">Customer
                        Information</h6></th>
            </tr>
            <tr style="text-align: center">
                <td>Serial No.</td>
                <td>Project</td>
                <td>Customer Name</td>
                <td>Seller Name</td>
                <td>Date Of Sales</td>
                <td>Pay Date</td>
                <td>Division</td>
                <td>Package Name</td>
                <td>Share Value</td>
                <td>Share QTY</td>
                <td>Discount</td>
                <td>Sub Total</td>
                <td>Total Collaction</td>
                <td>Percent of Collaction</td>
                <td>Total Due</td>
                <td>Balance</td>
                <td>Total DR</td>
                <td>CR Voucher No</td>
                <td>DR Voucher No</td>
            </tr>

        </thead>

        <tbody>
              
            ' . $trHtml . '
            
            <tr style="height: 35px;">
                <td colspan="7" class="text-left"></td>
                
            </tr>
                
           <tr style="font-weight: bold">
                <td colspan="8" class="text-right">Total =</td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalFlatPrice) . '</td>
                <td class="text-right">' . $TotalShareQty . '</td>
                <td></td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalFlatPrice) . '</</td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalCrAmount) . '</td>
                <td></td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalDueAmount) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalCrAmount - $TotalDrAmount) . '</td>
                <td class="text-right">' . BangladeshiCurencyFormat($TotalDrAmount) . '</td>
                <td colspan="2"></td>
            </tr>
             
            
        </tbody>

    </table>


    <div style="margin-top:50px; display:flex; justify-content:space-around; text-align:center;">
        <div style="padding:20px; width:200px;">
            <div style="border-top:1px solid #000; margin-top:40px;"></div>
            <span style="font-weight:bold;">AUTHORIZED BY</span>
        </div>
        <div style="padding:20px; width:200px;">
            <div style="border-top:1px solid #000; margin-top:40px;"></div>
            <span style="font-weight:bold;">CHECKED BY</span>
        </div>
        <div style="padding:20px; width:200px;">
            <div style="border-top:1px solid #000; margin-top:40px;"></div>
            <span style="font-weight:bold;">PREPARED BY</span>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
function exportToCSV() {
  let table = document.getElementById("myTable");
  let wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
  XLSX.writeFile(wb, "table_data.csv", { bookType: "csv" });
}

function exportToExcel() {
  let table = document.getElementById("myTable");
  let wb = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
  XLSX.writeFile(wb, "table_data.xlsx");
}
</script>

</div>';
