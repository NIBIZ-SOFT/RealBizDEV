<?php

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);
$CrVoucher = SQL_Select("CrVoucher where CrVoucherID={$_REQUEST["ID"]}");
$amount = $CrVoucher[0]["Amount"];
$voucherName = "CREDIT";

$BankGLCode = SQL_Select("bankcash", "BankCashID={$CrVoucher[0]["BankCashID"]}", "", true);
$ExpenseGLCode = SQL_Select("expensehead", "ExpenseHeadID={$CrVoucher[0]["HeadOfAccountID"]}", "", true);

$productName = isset($CrVoucher[0]["ProductsID"]) ? SQL_Select("products", "ProductsID={$CrVoucher[0]["ProductsID"]}", "", true)["FlatType"] : '';
$ActualTerm = isset($CrVoucher[0]["SalesID"]) ? SQL_Select("actualsalsepayment", "SalesID={$CrVoucher[0]["SalesID"]}", "", true)["Term"] : '';
$isDisplay = $CrVoucher[0]["IsDisplay"] == 1 ? "Paid" : "Unpaid";

$customerInfo = SQL_Select("Customer", "CustomerID={$CrVoucher[0]["CustomerID"]}", "", true);

$productInfo = SQL_Select("products", "ProductsID={$CrVoucher[0]["ProductsID"]}", "", true);

$actualpaymentInfo = SQL_Select("actualsalsepayment", "MRRNO={$_REQUEST["ID"]}", "", true);

$userInfo = SQL_Select("User", "UserID={$actualpaymentInfo['UserIDInserted']}", "", true);
$Name = $userInfo['NameFirst'];

$saleInfo = SQL_Select("Sales", "SalesID={$CrVoucher[0]["SalesID"]}", "", true);
$Discount = $saleInfo['Discount'];
$Quantity = $saleInfo['Quantity'];
$productPrice = $productInfo['NetSalesPrice'];

$TotalAmount = ($productPrice * $Quantity) - $Discount;


$FlatType = $productInfo['FlatType'];
$FlatSize = $productInfo['FlatSize'];


$MainContent .= '
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Money Receipt (Customer & Office Copy)</title>
  <style>
    @page { size: A4; margin: 0; }
    body { margin: 0; font-family: Arial, sans-serif; font-size: 12px; }
    .page { width: 210mm; height: 297mm; }
    .copy {
      width: 100%;
      height: 148.5mm; /* half of A4 */
      padding: 8mm;
      box-sizing: border-box;
      border-bottom: 1px dashed #000;
      position: relative;
    }
    .header { display: flex; align-items: center; margin-bottom: 6px; }
    .logo {  height: 80px; width: 80px; text-align: center; line-height: 80px; font-size: 10px; font-weight: bold; margin-right: 10px; }
    .company { flex: 1; text-align: center; }
    .company h2 { margin: 0; font-size: 16px; }
    .company p { margin: 2px 0; font-size: 11px; }
    .title { text-align: center; font-size: 16px; font-weight: bold; margin: 6px 0; text-decoration: underline; }
    .copy-label { position: absolute; top: 5px; right: 10px; font-weight: bold; font-size: 12px; }

    table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
    td, th { border: 1px solid #000; padding: 4px; vertical-align: top; font-size: 12px; }
    th { background: #f2f2f2; text-align: center; }

    .signatures { margin-top: 45px; display: flex; justify-content: space-between; text-align: center; }
    .sign-box { width: 30%; }
    .print-btn {
      display: block;
      margin: 10px auto;
      padding: 8px 16px;
      background: #007bff;
      color: #fff;
      font-size: 14px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    @media print {
      .print-btn { display: none; }
    }
  </style>
</head>
<body>
 <button class="print-btn" onclick="window.print()">🖨 Print Receipt</button>
  <div class="page">

    <!-- ===== CUSTOMER COPY ===== -->
    <div class="copy">
      <div class="copy-label">Customer Copy</div>

      <div class="header">
        <div class="logo">
         <img src="./upload/' . $Settings["logo"] . '" class="logo-img" alt="Logo">
        </div>
        <div class="company">
          <h2>' . $Settings["CompanyName"] . '</h2>
          <p>' . $Settings["Address"] . '</p>
          <p>Email: ' . $Settings["Email"] . ' | Contact: ' . $Settings["Phone"] . '</p>
        </div>
      </div>

      <div class="title">MONEY RECEIPT</div>


      <table>
        <tr><td>Money Receipt No: ' . $_REQUEST["ID"] . '</td><td>Date: ' . $actualpaymentInfo['DateOfCollection'] . '</td></tr>
        <tr><td>Client Name & Code: ' . $CrVoucher[0]["CustomerName"] . ' ' . $CrVoucher[0]["CustomerID"] . '</td><td>Project Name: ' . $CrVoucher[0]["ProjectName"] . '</td></tr>
        <tr><td>Mobile Number: ' . $customerInfo['Phone'] . '</td><td>Shop No: ' . $FlatType . '</td></tr>
        <tr><td>Address: ' . $customerInfo['Address'] . '</td><td>Shop Size: ' . $FlatSize . '</td></tr>
        <tr><td>Mode of Transaction: ' . $actualpaymentInfo['ModeOfPayment'] . '</td><td>Total Amount: ' . BangladeshiCurencyFormat($TotalAmount) . '</td></tr>
        <tr><td colspan="2">In Words: ' . NumberToWordsNew($TotalAmount) . '</td></tr>
      </table>

      <table>
        <tr><td>Bank Name</td><td>' . $actualpaymentInfo['BankName'] . '</td></tr>
        <tr><td>Installment Type</td><td>' . $actualpaymentInfo['Term'] . '</td></tr>
      </table>

      <table>
        <tr><td>Received By</td><td>' . $Name . '</td></tr>
        <tr><td>Total Received Amount (in Words)</td><td>' . NumberToWordsNew($amount) . '</td></tr>
      </table>

      <table>
        <tr><th colspan="6">Payment Details</th></tr>
        <tr>
          <th>Date</th><th>Amount</th><th>Cheque Number</th>
          <th>Cheque Date</th><th>Cheque Status</th><th>Clearance Date</th>
        </tr>
        <tr>
          <td>' . $actualpaymentInfo['DateOfCollection'] . '</td><td>' . BangladeshiCurencyFormat($amount) . '</td><td>' . $actualpaymentInfo["ChequeNo"] . '</td><td>-</td><td>Cleared</td><td>05-09-2025</td>
        </tr>
      </table>

      <div class="signatures">
        <div class="sign-box">Authorized By</div>
        <div class="sign-box">Checked By</div>
        <div class="sign-box">Prepared By</div>
      </div>
    </div>

    
    <!-- ===== OFFICE COPY ===== -->
    <div class="copy">
      <div class="copy-label">Office Copy</div>

      <div class="header">
        <div class="logo">
         <img src="./upload/' . $Settings["logo"] . '" class="logo-img" alt="Logo">
        </div>
        <div class="company">
          <h2>' . $Settings["CompanyName"] . '</h2>
          <p>' . $Settings["Address"] . '</p>
          <p>Email: ' . $Settings["Email"] . ' | Contact: ' . $Settings["Phone"] . '</p>
        </div>
      </div>

      <div class="title">MONEY RECEIPT</div>


      <table>
        <tr><td>Money Receipt No: ' . $_REQUEST["ID"] . '</td><td>Date: ' . $actualpaymentInfo['DateOfCollection'] . '</td></tr>
        <tr><td>Client Name & Code: ' . $CrVoucher[0]["CustomerName"] . ' ' . $CrVoucher[0]["CustomerID"] . '</td><td>Project Name: ' . $CrVoucher[0]["ProjectName"] . '</td></tr>
        <tr><td>Mobile Number: ' . $customerInfo['Phone'] . '</td><td>Shop No: ' . $FlatType . '</td></tr>
        <tr><td>Address: ' . $customerInfo['Address'] . '</td><td>Shop Size: ' . $FlatSize . '</td></tr>
        <tr><td>Mode of Transaction: ' . $actualpaymentInfo['ModeOfPayment'] . '</td><td>Total Amount: ' . BangladeshiCurencyFormat($TotalAmount) . '</td></tr>
        <tr><td colspan="2">In Words: ' . NumberToWordsNew($TotalAmount) . '</td></tr>
      </table>

      <table>
        <tr><td>Bank Name</td><td>' . $actualpaymentInfo['BankName'] . '</td></tr>
        <tr><td>Installment Type</td><td>' . $actualpaymentInfo['Term'] . '</td></tr>
      </table>

      <table>
        <tr><td>Received By</td><td>' . $Name . '</td></tr>
        <tr><td>Total Received Amount (in Words)</td><td>' . NumberToWordsNew($amount) . '</td></tr>
      </table>

      <table>
        <tr><th colspan="6">Payment Details</th></tr>
        <tr>
          <th>Date</th><th>Amount</th><th>Cheque Number</th>
          <th>Cheque Date</th><th>Cheque Status</th><th>Clearance Date</th>
        </tr>
        <tr>
          <td>' . $actualpaymentInfo['DateOfCollection'] . '</td><td>' . BangladeshiCurencyFormat($amount) . '</td><td>' . $actualpaymentInfo["ChequeNo"] . '</td><td>-</td><td>Cleared</td><td>05-09-2025</td>
        </tr>
      </table>

      <div class="signatures">
        <div class="sign-box">Authorized By</div>
        <div class="sign-box">Checked By</div>
        <div class="sign-box">Prepared By</div>
      </div>
    </div>



  </div>
</body>
</html>


';
