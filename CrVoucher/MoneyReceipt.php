<?php

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);
$CrVoucher = SQL_Select("CrVoucher where CrVoucherID={$_REQUEST["ID"]}");
$amount = $CrVoucher[0]["Amount"];
$voucherName = "CREDIT";

$BankGLCode = SQL_Select("bankcash","BankCashID={$CrVoucher[0]["BankCashID"]}","",true);
$ExpenseGLCode = SQL_Select("expensehead","ExpenseHeadID={$CrVoucher[0]["HeadOfAccountID"]}","",true);

$productName = isset($CrVoucher[0]["ProductsID"]) ? SQL_Select("products","ProductsID={$CrVoucher[0]["ProductsID"]}","",true)["FlatType"] : '';
$ActualTerm = isset($CrVoucher[0]["SalesID"]) ? SQL_Select("actualsalsepayment","SalesID={$CrVoucher[0]["SalesID"]}","",true)["Term"] : '';
$isDisplay = $CrVoucher[0]["IsDisplay"] == 1 ? "Paid" : "Unpaid";

$MainContent .= '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Money Receipt</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
  <style>
    .stamp {
      position: absolute;
      bottom: 180px;
      left: 30%;
      opacity: 0.08;
      transform: rotate(-18deg);
      width: 320px;
    }
    .logo-img {
      max-height: 80px;
    }
  </style>
</head>
<body class="bg-light">

<div class="container my-5">
  <div class="bg-white border rounded shadow-sm p-4 position-relative">

    <!-- Header -->
    <div class="row align-items-center mb-3">
      <div class="col-md-3 text-left">
        <img src="./upload/' . $Settings["logo"] . '" class="logo-img" alt="Logo">
      </div>
      <div class="col-md-9 text-center">
        <h4 class="font-weight-bold mb-1">'.$Settings["CompanyName"].'</h4>
        <p class="text-muted mb-0">'.$Settings["Address"].'</p>
      </div>
    </div>

    <div class="text-center mb-4">
      <h5 class="text-decoration-underline font-weight-bold">MONEY RECEIPT</h5>
    </div>

    <!-- Voucher Info -->
    <div class="row mb-3">
      <div class="col-md-6"><strong>Voucher No:</strong> ' . $CrVoucher[0]["BillNo"] . '</div>
      <div class="col-md-6 text-md-right"><strong>Printed:</strong> '.date('F j, Y h:i A').'</div>
    </div>

    <!-- Customer -->
    <p class="mb-3"><strong>Received with thanks from:</strong><br>' . $CrVoucher[0]["CustomerName"] . '</p>

    <!-- Product Info -->
    <div class="row mb-3">
      <div class="col-md-6"><strong>Property Name:</strong> ' . $productName . '</div>
      <div class="col-md-6 text-md-right"><strong>Term:</strong> ' . $ActualTerm . '</div>
    </div>

    <!-- Particulars -->
    <p class="mb-3"><strong>Particulars:</strong><br>' . $CrVoucher[0]["Description"] . '</p>

    <!-- Payment Info -->
    <div class="row mb-3">
      <div class="col-md-4"><strong>Via:</strong> ' . $CrVoucher[0]["BankCashName"] . '</div>
      <div class="col-md-4"><strong>Date:</strong> ' . $CrVoucher[0]["Date"] . '</div>
      <div class="col-md-4"><strong>Status:</strong> ' . $isDisplay . '</div>
    </div>

    <!-- Amount -->
    <div class="row mb-4">
      <div class="col-md-6">
        <div class=""><span class="border border-warning rounded p-2 bg-warning text-dark font-weight-bold">Tk. ' . BangladeshiCurencyFormat($amount) . '/-</span>
          
        </div>
      </div>
      <div class="col-md-6 text-md-right">
        <div class="border border-secondary rounded p-2 text-dark">
          ' . NumberToWordsNew($amount) . '
        </div>
      </div>
    </div>

    <!-- Signatures -->
    <div class="row mt-5">
      <div class="col-md-6 text-center">
        <hr style="border-top: 1px solid #000; width: 200px;">
        <small>Authorised Signature</small>
      </div>
      <div class="col-md-6 text-center">
        <hr style="border-top: 1px solid #000; width: 200px;">
        <small>Customer Signature</small>
      </div>
    </div>

    <!-- Stamp -->
    <img src="./upload/' . $Settings["logo"] . '" class="stamp" alt="Stamp">

    <!-- Footer Note -->
    <div class="text-center mt-4">
      <small class="text-muted">This is a system-generated receipt. No signature is required if verified digitally.</small>
    </div>

  </div>
</div>

</body>
</html>';
