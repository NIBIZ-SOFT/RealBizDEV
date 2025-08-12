<?php
/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 4/29/2019
 * Time: 11:47 AM
 */

$Settings = SQL_Select("Settings", "SettingsID=1", "", true);
if (!empty($_POST["FromDate"]) and !empty($_POST["ToDate"]) and !empty($_POST["FromDate1"]) and !empty($_POST["ToDate1"])) {

    $FromDate = $_REQUEST["FromDate"];
    $ToDate = $_REQUEST["ToDate"];

    $FromDate1 = $_REQUEST["FromDate1"];
    $ToDate1 = $_REQUEST["ToDate1"];

//    Profit/(Loss) for the year Start

    $ProfitLossForTheYear = NetProfitLoss('1-1-2014', $ToDate);

    $ProfitLossForTheYear1 = NetProfitLoss('1-1-2014', $ToDate1);

//    Profit/(Loss) for the year End

    $ParentHeads = SQL_Select("incomeexpensetype");

    foreach ($ParentHeads as $parentHead) {

        // Preliminary Expense
        if ($parentHead["Name"] == "Preliminary Expense") {
            $PreliminaryExpenseID = $parentHead["IncomeExpenseTypeID"];
        }

        // Advance , Deposites & Pre-Payments
        if ($parentHead["Name"] == "Advance, Deposite & Receivables") {
            $AdvanceDepositeReceivablesID = $parentHead["IncomeExpenseTypeID"];
        }


        //    Accaunt Payable
        if ($parentHead["Name"] == "Accaunt Payable") {
            $AccauntPayableID = $parentHead["IncomeExpenseTypeID"];
        }

        //    Short Term Loan
        if ($parentHead["Name"] == "Short Term Loan") {
            $ShortTermLoanID = $parentHead["IncomeExpenseTypeID"];
        }

        //  Advance Against Sales
        if ($parentHead["Name"] == "Advance Against Sales") {
            $AdvanceAgainstSalesID = $parentHead["IncomeExpenseTypeID"];
        }

        //  Other Payable
        if ($parentHead["Name"] == "Other Payable") {
            $OtherPayableID = $parentHead["IncomeExpenseTypeID"];
        }

        //  Advance Receive from Investor
        if ($parentHead["Name"] == "Advance Receive from Investor") {
            $AdvanceReceivefromInvestorID = $parentHead["IncomeExpenseTypeID"];
        }


//        Acquisition of Property, Plant & Equipment

        if ($parentHead["Name"] == "Property, Plant & Equipment") {
            $PropertyPlantEquipmentID = $parentHead["IncomeExpenseTypeID"];
        }

        //    Long Term Loan
        if ($parentHead["Name"] == "Long Term Loan") {
            $LongTermLoanID = $parentHead["IncomeExpenseTypeID"];
        }

        //    Paid Up Capital
        if ($parentHead["Name"] == "Paid Up Capital") {
            $PaidUpCapitalID = $parentHead["IncomeExpenseTypeID"];
        }
        //    Share Money Deposite
        if ($parentHead["Name"] == "Share Money Deposite") {
            $ShareMoneyDepositeID = $parentHead["IncomeExpenseTypeID"];
        }

    }


    //   Advance Deposite Receivables Start

    $AdvanceDepositeReceivablesChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$AdvanceDepositeReceivablesID}");

    $AdvanceDepositeReceivablesAmount = 0;
    $AdvanceDepositeReceivablesAmount1 = 0;

    $PreviousAdvanceDepositeReceivablesAmount=0;
    $PreviousAdvanceDepositeReceivablesAmount1=0;

    foreach ($AdvanceDepositeReceivablesChildDetails as $AdvanceDepositeReceivablesChildDetail) {
        $AdvanceDepositeReceivablesAmount += GetBalanceHeadOfAccountIDWithDate($AdvanceDepositeReceivablesChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate);

        $AdvanceDepositeReceivablesAmount1 += GetBalanceHeadOfAccountIDWithDate($AdvanceDepositeReceivablesChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate);


        $PreviousAdvanceDepositeReceivablesAmount += GetBalanceHeadOfAccountIDWithDate($AdvanceDepositeReceivablesChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate1);

        $PreviousAdvanceDepositeReceivablesAmount1 += GetBalanceHeadOfAccountIDWithDate($AdvanceDepositeReceivablesChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate1);


    }

    $curentAdvanceDepositeReceivablesAmount = $AdvanceDepositeReceivablesAmount - $AdvanceDepositeReceivablesAmount1;

    $curentAdvanceDepositeReceivablesAmount1 = $PreviousAdvanceDepositeReceivablesAmount - $PreviousAdvanceDepositeReceivablesAmount1;

//   Advance Deposite Receivables End


//    Inventories start
    $curentInventories = getInventoriesAgainstDate($FromDate) - getInventoriesAgainstDate($ToDate);

    $curentInventories1 = getInventoriesAgainstDate($FromDate1) - getInventoriesAgainstDate($ToDate1);

//    Inventories end


    //   Preliminary Expense Start

    $PreliminaryExpenseChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$PreliminaryExpenseID}");

    $PreliminaryExpenseAmount = 0;
    $PreliminaryExpenseAmount1 = 0;

    $PreviousPreliminaryExpenseAmount=0;
    $PreviousPreliminaryExpenseAmount1=0;

    foreach ($PreliminaryExpenseChildDetails as $PreliminaryExpenseChildDetail) {
        $PreliminaryExpenseAmount += GetBalanceHeadOfAccountIDWithDate($PreliminaryExpenseChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate);
        $PreliminaryExpenseAmount1 += GetBalanceHeadOfAccountIDWithDate($PreliminaryExpenseChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate);


        $PreviousPreliminaryExpenseAmount += GetBalanceHeadOfAccountIDWithDate($PreliminaryExpenseChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate1);
        $PreviousPreliminaryExpenseAmount1 += GetBalanceHeadOfAccountIDWithDate($PreliminaryExpenseChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate1);


    }

    $curentPreliminaryExpenseAmount = $PreliminaryExpenseAmount - $PreliminaryExpenseAmount1;

    $curentPreliminaryExpenseAmount1 = $PreviousPreliminaryExpenseAmount - $PreviousPreliminaryExpenseAmount1;

//   Preliminary Expense End


//    Accaunt Payable Start

    $AccauntPayableChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$AccauntPayableID}");

    $AccauntPayableAmount = 0;
    $AccauntPayableAmount1 = 0;

    $PreviousAccauntPayableAmount =0;
    $PreviousAccauntPayableAmount1 =0;


    foreach ($AccauntPayableChildDetails as $AccauntPayableChildDetail) {

        $AccauntPayableAmount += GetBalanceHeadOfAccountIDWithDate($AccauntPayableChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate);
        $AccauntPayableAmount1 += GetBalanceHeadOfAccountIDWithDate($AccauntPayableChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate);


        $PreviousAccauntPayableAmount += GetBalanceHeadOfAccountIDWithDate($AccauntPayableChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate1);
        $PreviousAccauntPayableAmount1 += GetBalanceHeadOfAccountIDWithDate($AccauntPayableChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate1);




    }
    $curentAccauntPayableAmount = $AccauntPayableAmount - $AccauntPayableAmount1;

    $curentAccauntPayableAmount1 = $PreviousAccauntPayableAmount - $PreviousAccauntPayableAmount1;

//    Accaunt Payable End

//    Short Term Loan Start

    $ShortTermLoanChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$ShortTermLoanID}");
    $ShortTermLoanAmount = 0;
    $ShortTermLoanAmount1 = 0;

    $PreviousShortTermLoanAmount=0;
    $PreviousShortTermLoanAmount1=0;

    foreach ($ShortTermLoanChildDetails as $ShortTermLoanChildDetail) {

        $ShortTermLoanAmount += GetBalanceHeadOfAccountIDWithDate($ShortTermLoanChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate);
        $ShortTermLoanAmount1 += GetBalanceHeadOfAccountIDWithDate($ShortTermLoanChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate);


        $PreviousShortTermLoanAmount += GetBalanceHeadOfAccountIDWithDate($ShortTermLoanChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate1);
        $PreviousShortTermLoanAmount1 += GetBalanceHeadOfAccountIDWithDate($ShortTermLoanChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate1);



    }

    $curentShortTearmLoane = $ShortTermLoanAmount - $ShortTermLoanAmount1;

    $curentShortTearmLoane1 = $PreviousShortTermLoanAmount - $PreviousShortTermLoanAmount1;

//    Short Term Loan End


//    Advance Against Sales Start

    $AdvanceAgainstSalesChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$AdvanceAgainstSalesID}");
    $AdvanceAgainstSalesAmount = 0;
    $AdvanceAgainstSalesAmount1 = 0;

    $PreviousAdvanceAgainstSalesAmount=0;
    $PreviousAdvanceAgainstSalesAmount1=0;

    foreach ($AdvanceAgainstSalesChildDetails as $AdvanceAgainstSalesChildDetail) {

        $AdvanceAgainstSalesAmount += GetBalanceHeadOfAccountIDWithDate($AdvanceAgainstSalesChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate);
        $AdvanceAgainstSalesAmount1 += GetBalanceHeadOfAccountIDWithDate($AdvanceAgainstSalesChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate);


        $PreviousAdvanceAgainstSalesAmount += GetBalanceHeadOfAccountIDWithDate($AdvanceAgainstSalesChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate1);
        $PreviousAdvanceAgainstSalesAmount1 += GetBalanceHeadOfAccountIDWithDate($AdvanceAgainstSalesChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate1);


    }

    $curentAdvanceAgainstSalesAmount = $AdvanceAgainstSalesAmount - $AdvanceAgainstSalesAmount1;

    $curentAdvanceAgainstSalesAmount1 = $PreviousAdvanceAgainstSalesAmount - $PreviousAdvanceAgainstSalesAmount1;

//    Advance Against Sales End


//    	Other Payable Start

    $OtherPayableChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$OtherPayableID}");
    $OtherPayableAmount = 0;
    $OtherPayableAmount1 = 0;

    $PreviousOtherPayableAmount=0;
    $PreviousOtherPayableAmount1=0;

    foreach ($OtherPayableChildDetails as $OtherPayableChildDetail) {

        $OtherPayableAmount += GetBalanceHeadOfAccountIDWithDate($OtherPayableChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate);
        $OtherPayableAmount1 += GetBalanceHeadOfAccountIDWithDate($OtherPayableChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate);

        $PreviousOtherPayableAmount += GetBalanceHeadOfAccountIDWithDate($OtherPayableChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate1);
        $PreviousOtherPayableAmount1 += GetBalanceHeadOfAccountIDWithDate($OtherPayableChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate1);


    }

    $curentOtherPayableAmount = $OtherPayableAmount - $OtherPayableAmount1;

    $curentOtherPayableAmount1 = $PreviousOtherPayableAmount - $PreviousOtherPayableAmount1;

//    	Other Payable End


//    	Advance Receive from Investor Start

    $AdvanceReceivefromInvestorChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$AdvanceReceivefromInvestorID}");
    $AdvanceReceivefromInvestorAmount = 0;
    $AdvanceReceivefromInvestorAmount1 = 0;

    $PreviousAdvanceReceivefromInvestorAmount=0;
    $PreviousAdvanceReceivefromInvestorAmount1=0;

    foreach ($AdvanceReceivefromInvestorChildDetails as $AdvanceReceivefromInvestorChildDetail) {

        $AdvanceReceivefromInvestorAmount += GetBalanceHeadOfAccountIDWithDate($AdvanceReceivefromInvestorChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate);
        $AdvanceReceivefromInvestorAmount1 += GetBalanceHeadOfAccountIDWithDate($AdvanceReceivefromInvestorChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate);

        $PreviousAdvanceReceivefromInvestorAmount += GetBalanceHeadOfAccountIDWithDate($AdvanceReceivefromInvestorChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate1);
        $PreviousAdvanceReceivefromInvestorAmount1 += GetBalanceHeadOfAccountIDWithDate($AdvanceReceivefromInvestorChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate1);


    }

    $currentAdvanceReceivefromInvestorAmount = $AdvanceReceivefromInvestorAmount - $AdvanceReceivefromInvestorAmount1;

    $currentAdvanceReceivefromInvestorAmount1 = $PreviousAdvanceReceivefromInvestorAmount - $PreviousAdvanceReceivefromInvestorAmount1;

//    	Advance Receive from Investor End


//    Net Cash used in Operating Actives Start


    $NetCashusedInOperatingActives= $ProfitLossForTheYear + $curentAdvanceDepositeReceivablesAmount
        + $curentInventories + $curentPreliminaryExpenseAmount + $curentAccauntPayableAmount + $curentShortTearmLoane + $curentAdvanceAgainstSalesAmount
        + $curentOtherPayableAmount + $currentAdvanceReceivefromInvestorAmount;


    $NetCashusedInOperatingActives1= $ProfitLossForTheYear1 + $curentAdvanceDepositeReceivablesAmount1
        + $curentInventories1 + $curentPreliminaryExpenseAmount1 + $curentAccauntPayableAmount1 + $curentShortTearmLoane1 + $curentAdvanceAgainstSalesAmount1
        + $curentOtherPayableAmount1 + $currentAdvanceReceivefromInvestorAmount1;




//    Net Cash used in Operating Actives End



//    	Acquisition of Property, Plant & Equipment Start

    $PropertyPlantEquipmentInvestorChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$PropertyPlantEquipmentID}");

    $PropertyPlantEquipmentInvestorAmount = 0;
    $PropertyPlantEquipmentInvestorAmount1 = 0;

    $PreviousPropertyPlantEquipmentInvestorAmount=0;
    $PreviousPropertyPlantEquipmentInvestorAmount1=0;

    foreach ($PropertyPlantEquipmentInvestorChildDetails as $PropertyPlantEquipmentInvestorChildDetail) {

        $PropertyPlantEquipmentInvestorAmount += GetBalanceHeadOfAccountIDWithDate($PropertyPlantEquipmentInvestorChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate);
        $PropertyPlantEquipmentInvestorAmount1 += GetBalanceHeadOfAccountIDWithDate($PropertyPlantEquipmentInvestorChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate);

        $PreviousPropertyPlantEquipmentInvestorAmount += GetBalanceHeadOfAccountIDWithDate($PropertyPlantEquipmentInvestorChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate1);
        $PreviousPropertyPlantEquipmentInvestorAmount1 += GetBalanceHeadOfAccountIDWithDate($PropertyPlantEquipmentInvestorChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate1);


    }

    $CurrentPropertyPlantEquipmentInvestorAmount = $PropertyPlantEquipmentInvestorAmount - $PropertyPlantEquipmentInvestorAmount1;

    $CurrentPropertyPlantEquipmentInvestorAmount1 = $PreviousPropertyPlantEquipmentInvestorAmount - $PreviousPropertyPlantEquipmentInvestorAmount1;

//    	Acquisition of Property, Plant & Equipment End


//    Net Cash used in Investing Actives Start
    $NetCashUsedInInvestingActives= $CurrentPropertyPlantEquipmentInvestorAmount;

//    Net Cash used in Investing Actives End


//    Paid up Capital Start
    $PaidUpCapitalChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$PaidUpCapitalID}");
    $IssuidSsubscribedAndPaidUpCapital = 0;
    $IssuidSsubscribedAndPaidUpCapital1 = 0;

    $PreviousIssuidSsubscribedAndPaidUpCapital=0;
    $PreviousIssuidSsubscribedAndPaidUpCapital1=0;

    foreach ($PaidUpCapitalChildDetails as $PaidUpCapitalChildDetail) {

        $IssuidSsubscribedAndPaidUpCapital += GetBalanceHeadOfAccountIDWithDate($PaidUpCapitalChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate);
        $IssuidSsubscribedAndPaidUpCapital1 += GetBalanceHeadOfAccountIDWithDate($PaidUpCapitalChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate);

        $PreviousIssuidSsubscribedAndPaidUpCapital += GetBalanceHeadOfAccountIDWithDate($PaidUpCapitalChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate1);
        $PreviousIssuidSsubscribedAndPaidUpCapital1 += GetBalanceHeadOfAccountIDWithDate($PaidUpCapitalChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate1);



    }

    $CurentIssuidSsubscribedAndPaidUpCapital = $IssuidSsubscribedAndPaidUpCapital - $IssuidSsubscribedAndPaidUpCapital1;

    $CurentIssuidSsubscribedAndPaidUpCapital1 = $PreviousIssuidSsubscribedAndPaidUpCapital - $PreviousIssuidSsubscribedAndPaidUpCapital1;


    //    Paid up Capital End



//    SHARE MONEY DEPOSIT Start

    $ShareMoneyDepositeChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$ShareMoneyDepositeID}");
    $ShareMoneyDepositeAmount = 0;
    $ShareMoneyDepositeAmount1 = 0;

    $PreviousShareMoneyDepositeAmount=0;
    $PreviousShareMoneyDepositeAmount1=0;

    foreach ($ShareMoneyDepositeChildDetails as $ShareMoneyDepositeChildDetail) {

        $ShareMoneyDepositeAmount += GetBalanceHeadOfAccountIDWithDate($ShareMoneyDepositeChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate);
        $ShareMoneyDepositeAmount1 += GetBalanceHeadOfAccountIDWithDate($ShareMoneyDepositeChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate);


        $PreviousShareMoneyDepositeAmount += GetBalanceHeadOfAccountIDWithDate($ShareMoneyDepositeChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate1);
        $PreviousShareMoneyDepositeAmount1 += GetBalanceHeadOfAccountIDWithDate($ShareMoneyDepositeChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate1);



    }


    $currentShareMoneyDepositeAmount = $ShareMoneyDepositeAmount - $ShareMoneyDepositeAmount1;

    $currentShareMoneyDepositeAmount1 = $PreviousShareMoneyDepositeAmount - $PreviousShareMoneyDepositeAmount1;

//    SHARE MONEY DEPOSIT End





//    Long Term Loan Start
    $LongTermLoanChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$LongTermLoanID}");
    $LongTermLoanAmount = 0;
    $LongTermLoanAmount1 = 0;

    $PreviousLongTermLoanAmount=0;
    $PreviousLongTermLoanAmount1=0;

    foreach ($LongTermLoanChildDetails as $LongTermLoanChildDetail) {

        $LongTermLoanAmount += GetBalanceHeadOfAccountIDWithDate($LongTermLoanChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate);
        $LongTermLoanAmount1 += GetBalanceHeadOfAccountIDWithDate($LongTermLoanChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate);


        $PreviousLongTermLoanAmount += GetBalanceHeadOfAccountIDWithDate($LongTermLoanChildDetail["ExpenseHeadID"], '1-1-2014', $ToDate1);
        $PreviousLongTermLoanAmount1 += GetBalanceHeadOfAccountIDWithDate($LongTermLoanChildDetail["ExpenseHeadID"], '1-1-2014', $FromDate1);


    }

    $currentLongTearmLoaneAmount = $LongTermLoanAmount - $LongTermLoanAmount1;

    $currentLongTearmLoaneAmount1 = $PreviousLongTermLoanAmount - $PreviousLongTermLoanAmount1;

//    Long Term Loan End

//    Net Cash used in Finance Actives Start

    $NetCashUsedInFinanceActives=  $CurentIssuidSsubscribedAndPaidUpCapital + $currentShareMoneyDepositeAmount + $currentLongTearmLoaneAmount;

    $NetCashUsedInFinanceActives1=  $CurentIssuidSsubscribedAndPaidUpCapital1 + $currentShareMoneyDepositeAmount1 + $currentLongTearmLoaneAmount1;

//    Net Cash used in Finance Actives Start


//    Cash inflow/(outflow) from total activities (A+B+C)Start

    $ABCAmount= $NetCashusedInOperatingActives + $NetCashUsedInInvestingActives + $NetCashUsedInFinanceActives;

    $ABCAmount1= $NetCashusedInOperatingActives1 + $NetCashUsedInInvestingActives1 + $NetCashUsedInFinanceActives1;

//    Cash inflow/(outflow) from total activities (A+B+C)  End



    //    BankCash area Start

    $BankCashes=SQL_Select("bankcash");


    $TotalBankCashAmount=0;
    $TotalBankCashAmount1=0;


    foreach ($BankCashes as $BankCash){

        $TotalBankCashAmount +=GET_BankCashAmountAgainstIDDate($BankCash["BankCashID"], '1-1-2014' , $FromDate );
        $TotalBankCashAmount1 +=GET_BankCashAmountAgainstIDDate($BankCash["BankCashID"], '1-1-2014' , $FromDate1 );


    }

//    BankCash area End


//    F. Closing Cash & Bank Balance (D+E) Start

    $ClosingAmount =  $ABCAmount + $TotalBankCashAmount;

    $ClosingAmount1 =  $ABCAmount1 + $TotalBankCashAmount1;

//    F. Opening Cash & Bank Balance (D+E) End


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

    <title>Cash Flow Statement</title>

    <style>
        .m-b-30{
            margin-bottom: 30px;
        }
        .m-t-30{
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
    <p style="font-size: 16px">Printing Date & Time: '.date('F j-y, h:i:sa').'</p>
</div>

<div style="width: 95%; margin: auto">

    <div style="padding: 10px 0px;" class="company-name row">
        <div  class="col-md-2 text-center">
            <img style="width: 70px;" src="./upload/' . $Settings["logo"] . '" alt="">
        </div>
        <div  class="col-md-9 text-center">
            <h3 style="font-weight: bold">'.$Settings["CompanyName"].'</h3>
            <p style="font-size: 18px;">'.$Settings["Address"].'</p>

        </div>

    </div>

    <div class="projectName text-center m-b-30 m-t-30">
        <h4 style="font-weight: bold">Cash Flow Statement</h4>
    </div>
    
   <table class="table table-bordered table-hover table-fixed table-sm">
        
          <thead>
                <tr>
                    <th scope="col" class="text-center"> <h4 style="font-weight: bold;">Particulars</h4></th>
                    <th  scope="col" class="text-center"> <h5>' . HumanReadAbleDateFormat($FromDate) . ' To ' . HumanReadAbleDateFormat($ToDate) . '</h5></th>
                    <th  scope="col" class="text-center"> <h5>' . HumanReadAbleDateFormat($FromDate1) . ' To ' . HumanReadAbleDateFormat($ToDate1) . '</h5></th>
                </tr>
                </thead>
                <thead>
                <tr>
                    <th style="font-size: 25px" scope="col">A. Cash flow from Operating actives:</th>
                    <th width="300px" class="text-right" scope="col">Tk</th>
                    <th width="300px"  class="text-right"  scope="col">TK</th>
                </tr>
                </thead>
        
                <tbody>
                    
                   <tr >
                        <td> Profit/(Loss) for the year </td>
                        <td class="text-right">' . BangladeshiCurencyFormat($ProfitLossForTheYear) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($ProfitLossForTheYear1) . '</td>
                        
                    </tr>
                    
                    <tr >
                        <td colspan="3"> Adjustment for:  </td>
                        
                    </tr>
                    
                    <tr >
                        <td> Depreciation </td>
                        <td class="text-right">' . BangladeshiCurencyFormat() . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat() . '</td>
                        
                    </tr>
                    
                    <tr style="font-weight: bold" >
                        <td colspan="3"> (Increse)/Decrease in Current Assets:  </td>
                        
                    </tr>
                    
                    <tr >
                        <td> Advance, Deposit & Receivable </td>
                        <td class="text-right">' . $curentAdvanceDepositeReceivablesAmount . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($curentAdvanceDepositeReceivablesAmount1) . '</td>
                        
                    </tr>
                    
                    <tr >
                        <td> Inventories </td>
                        <td class="text-right">' . $curentInventories . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($curentInventories1) . '</td>
                        
                    </tr>
                    
                    <tr >
                        <td> Preliminary expense </td>
                        <td class="text-right">' . BangladeshiCurencyFormat($curentPreliminaryExpenseAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($curentPreliminaryExpenseAmount1) . '</td>
                        
                    </tr>
                    
                    <tr style="font-weight: bold" >
                        <td colspan="3"> Increse/(Decrease) in Current Liabilites:  </td>
                        
                    </tr>
                    
                    <tr >
                        <td> Account Payable </td>
                        <td class="text-right">' . BangladeshiCurencyFormat($curentAccauntPayableAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($curentAccauntPayableAmount1) . '</td>
                        
                    </tr>
                    
                    <tr >
                        <td> Short Term Loan </td>
                        <td class="text-right">' . BangladeshiCurencyFormat($curentShortTearmLoane) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($curentShortTearmLoane1) . '</td>
                        
                    </tr>
                    
                    <tr >
                        <td> Advance Against Sales </td>
                        <td class="text-right">' . BangladeshiCurencyFormat($curentAdvanceAgainstSalesAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($curentAdvanceAgainstSalesAmount1) . '</td>
                        
                    </tr>
                    
                    <tr >
                        <td> Other Payable  </td>
                        <td class="text-right">' . BangladeshiCurencyFormat($curentOtherPayableAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($curentOtherPayableAmount1) . '</td>
                        
                    </tr>
                    
                    
                    <tr >
                        <td> Advance Receive from Investor</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($currentAdvanceReceivefromInvestorAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($currentAdvanceReceivefromInvestorAmount1) . '</td>
                        
                    </tr>
                    
                    <tr style="font-weight: bold" >
                        <td > Net Cash used in Operating Actives  </td>
                        <td class="text-right">' . BangladeshiCurencyFormat($NetCashusedInOperatingActives) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($NetCashusedInOperatingActives1) . '</td>
                        
                    </tr>
                   
                    <tr>
                        <th style="height: 40px" scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                       
                    </tr>
                
                    
                    
                    <tr>
                        <th colspan="3" style="font-size: 25px" scope="col">B. Cash flow from Investing actives:  (Increase) / Decrease </th>
                        
                    </tr>
                    
                    <tr >
                        <td>Acquisition of Property, Plant & Equipment</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($CurrentPropertyPlantEquipmentInvestorAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($CurrentPropertyPlantEquipmentInvestorAmount1) . '</td>
                        
                    </tr>
                    
                    <tr style="font-weight: bold" >
                        <td > Net Cash used in Investing Actives  </td>
                        <td class="text-right">' . BangladeshiCurencyFormat($NetCashUsedInInvestingActives) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($CurrentPropertyPlantEquipmentInvestorAmount1) . '</td>
                        
                    </tr>
                    <tr>
                        <th style="height: 40px" scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                       
                    </tr>
                    <tr>
                        <th colspan="3" style="font-size: 25px" scope="col">C. Cash flow from Financing actives:   Increase / (Decrease) </th>
                        
                    </tr>
                    
                    <tr >
                        <td> Paid Up Capital </td>
                        <td class="text-right">' . BangladeshiCurencyFormat($CurentIssuidSsubscribedAndPaidUpCapital) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($CurentIssuidSsubscribedAndPaidUpCapital1) . '</td>
                        
                    </tr>
                    
                    <tr >
                        <td> Share Money Deposit </td>
                        <td class="text-right">' . BangladeshiCurencyFormat($currentShareMoneyDepositeAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($currentShareMoneyDepositeAmount1) . '</td>
                        
                    </tr>
                    
                    <tr >
                        <td> Long Term Loan </td>
                        <td class="text-right">' . BangladeshiCurencyFormat($currentLongTearmLoaneAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($currentLongTearmLoaneAmount1) . '</td>
                        
                    </tr>
                    
                    <tr style="font-weight: bold" >
                        <td > Net Cash used in Finance Actives  </td>
                        <td class="text-right">' . BangladeshiCurencyFormat($NetCashUsedInFinanceActives) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($NetCashUsedInFinanceActives1) . '</td>
                        
                    </tr>
                    
                    <tr>
                        <th style="height: 40px" scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                       
                    </tr>
                    <tr style="font-size: 25px">
                        <th scope="col">D. Cash inflow/(outflow) from total activities (A+B+C) </th>
                        <th class="text-right" scope="col">'.BangladeshiCurencyFormat($ABCAmount).'</th>
                        <th class="text-right" scope="col">'.BangladeshiCurencyFormat($ABCAmount1).'</th>
                    </tr>
                    
                    <tr>
                        <th style="height: 40px" scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                       
                    </tr>
                    <tr style="font-size: 25px">
                        <th scope="col">E. Opening Cash & Bank Balance </th>
                        <th class="text-right" scope="col">'.BangladeshiCurencyFormat($TotalBankCashAmount).'</th>
                        <th  class="text-right"  scope="col">'.BangladeshiCurencyFormat($TotalBankCashAmount1).'</th>
                    </tr>
                    
                    <tr>
                        <th style="height: 40px" scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                       
                    </tr>
                    <tr style="font-size: 25px">
                        <th scope="col">F. Closing Cash & Bank Balance (D+E) </th>
                        <th class="text-right" scope="col">'.BangladeshiCurencyFormat($ClosingAmount).'</th>
                        <th  class="text-right"  scope="col">'.BangladeshiCurencyFormat($ClosingAmount1).'</th>
                    </tr>
                    
                    
                </tbody>
                
                
   </table>

</div>


<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>


';



