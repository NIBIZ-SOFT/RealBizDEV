<?php

/**
 * Created by PhpStorm.
 * User: NiBiZ Soft
 * Date: 4/25/2019
 * Time: 1:47 PM
 */

// Input validation and sanitization
function validateDate($date) {
    if (empty($date)) {
        return false;
    }
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

// Initialize variables with default values
$FromDate = 0;
$ToDate = 0;
$FromDate1 = 0;
$ToDate1 = 0;

// Validate and sanitize input dates
if (!empty($_POST["FromDate"]) && !empty($_POST["ToDate"])) {
    if (validateDate($_POST["FromDate"]) && validateDate($_POST["ToDate"])) {
        $FromDate = mysqli_real_escape_string($connection, $_POST["FromDate"]);
        $ToDate = mysqli_real_escape_string($connection, $_POST["ToDate"]);
    } else {
        die("Invalid date format. Please use YYYY-MM-DD format.");
    }
}

if (!empty($_POST["FromDate1"]) && !empty($_POST["ToDate1"])) {
    if (validateDate($_POST["FromDate1"]) && validateDate($_POST["ToDate1"])) {
        $FromDate1 = mysqli_real_escape_string($connection, $_POST["FromDate1"]);
        $ToDate1 = mysqli_real_escape_string($connection, $_POST["ToDate1"]);
    } else {
        die("Invalid date format. Please use YYYY-MM-DD format.");
    }
}

// Error handling for database operations
$Settings = SQL_Select("Settings", "SettingsID=1", "", true);
if (!$Settings) {
    die("Error: Unable to retrieve settings. Please check database connection.");
}

$ParentHeads = SQL_Select("incomeexpensetype");
if (!$ParentHeads) {
    die("Error: Unable to retrieve income expense types. Please check database connection.");
}

foreach ($ParentHeads as $parentHead) {

    //    Expense Start
    if ($parentHead["Name"] == "Construction Material Purchases") {
        $ConstructionMaterialPurchasesID = 8;
    }

    if ($parentHead["Name"] == "Construction Labour Expenses") {
        $ConstructionLabourExpensesID = $parentHead["IncomeExpenseTypeID"];
    }
    if ($parentHead["Name"] == "Project Approval Expense") {
        $ProjectApprovalExpenseID = $parentHead["IncomeExpenseTypeID"];
    }
    if ($parentHead["Name"] == "Other Expense") {
        $OtherExpenseID = $parentHead["IncomeExpenseTypeID"];
    }


    if ($parentHead["Name"] == "Indirect Income") {
        $IndirectIncomeID = $parentHead["IncomeExpenseTypeID"];
    }

    if ($parentHead["Name"] == "Administrative Expense") {
        $AdministrativeExpenseID = $parentHead["IncomeExpenseTypeID"];
    }
    if ($parentHead["Name"] == "Financial Expense") {
        $FinancialExpenseID = $parentHead["IncomeExpenseTypeID"];
    }

    if ($parentHead["Name"] == "Provision & Tax Paid") {
        $ProvisionAndTaxPaidID = $parentHead["IncomeExpenseTypeID"];
    }



    //    Expense End

    //    Revenue Start

    if ($parentHead["Name"] == "Revenue") {
        $RevenueID = $parentHead["IncomeExpenseTypeID"];
    }

    //    Revenue End


}


//Cost of Revenue Start
if (!empty($FromDate) && !empty($ToDate)) {

    //    Revenue Start
    $RevenueHeadChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$RevenueID}");


    $TotalAmountOfRevenue = 0;

    foreach ($RevenueHeadChildDetails as $RevenueHeadChildDetail) {
        $RevenueTransactionDetails = SQL_Select("transaction where HeadOfAccountID={$RevenueHeadChildDetail["ExpenseHeadID"]} and Date BETWEEN '{$FromDate}' and '{$ToDate}' ");

        foreach ($RevenueTransactionDetails as $RevenueTransactionDetail) {

            $TotalAmountOfRevenue += $RevenueTransactionDetail["cr"] - $RevenueTransactionDetail["dr"];

            //if ($RevenueHeadChildDetail["ExpenseHeadIsType"] == 1){

            //  $TotalAmountOfRevenue += $RevenueTransactionDetail["dr"] - $RevenueTransactionDetail["cr"];
            //}else{
            //  $TotalAmountOfRevenue += $RevenueTransactionDetail["cr"] - $RevenueTransactionDetail["dr"];

            //}

        }
    }



    //    Revenue End


    //    Opening Construction Material start

    // Stock Balance

    $StockDetails = SQL_Select("stock", "Date BETWEEN '2016-01-01' AND  '{$FromDate}' ");
    $stockAmount = 0;
    foreach ($StockDetails as $StockDetail) {

        if ($StockDetail["StockIsActive"] == 1) {
            $stockAmount += $StockDetail["Value"];
        } else {
            continue;
        }
    }
    //    used Stock
    $UsedStockDetails = SQL_Select("usedstock", "Date BETWEEN '2016-01-01' AND  '{$FromDate}' ");
    $usedStockAmount = 0;
    foreach ($UsedStockDetails as $UsedStockDetail) {

        if ($UsedStockDetail["UsedStockIsActive"] == 1) {
            $usedStockAmount += $UsedStockDetail["Value"];
        } else {
            continue;
        }
    }

    $OpeningConstructionMaterialAmount = $stockAmount - $usedStockAmount;

    //   Opening Constraction material End



    //    Construction Material Purchase start

    $ConstructionMaterialHeadChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$ConstructionMaterialPurchasesID}");


    $TotalAmountOfConstructionMaterialPurchases = 0;

    foreach ($ConstructionMaterialHeadChildDetails as $ConstructionMaterialHeadChildDetail) {
        $ConstructionMaterialChildTransactionDetails = SQL_Select("transaction where HeadOfAccountID={$ConstructionMaterialHeadChildDetail["ExpenseHeadID"]} and Date BETWEEN '{$FromDate}' and '{$ToDate}' ");

        foreach ($ConstructionMaterialChildTransactionDetails as $ConstructionMaterialChildTransactionDetail) {

            if ($ConstructionMaterialHeadChildDetail["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfConstructionMaterialPurchases += $ConstructionMaterialChildTransactionDetail["dr"] - $ConstructionMaterialChildTransactionDetail["cr"];
            } else {
                $TotalAmountOfConstructionMaterialPurchases += $ConstructionMaterialChildTransactionDetail["cr"] - $ConstructionMaterialChildTransactionDetail["dr"];
            }
        }
    }

    //    Construction Material Purchase End


    //    Material Available For Used Start

    $MaterialAvailableForUsed = $OpeningConstructionMaterialAmount + $TotalAmountOfConstructionMaterialPurchases;

    //    Material Available For Used End



    //    Closing Construction Material Start

    // Stock Balance

    $ClosingStockDetails = SQL_Select("stock", "Date BETWEEN '2016-01-01' AND  '{$ToDate}' ");
    $ClosingStockAmount = 0;
    foreach ($ClosingStockDetails as $ClosingStockDetail) {

        if ($ClosingStockDetail["StockIsActive"] == 1) {
            $ClosingStockAmount += $ClosingStockDetail["Value"];
        } else {
            continue;
        }
    }
    //    used Stock
    $ClosingUsedStockDetails = SQL_Select("usedstock", "Date BETWEEN '2016-01-01' AND  '{$ToDate}' ");
    $ClosingUsedStockAmount = 0;
    foreach ($ClosingUsedStockDetails as $ClosingUsedStockDetail) {

        if ($ClosingUsedStockDetail["UsedStockIsActive"] == 1) {
            $ClosingUsedStockAmount += $ClosingUsedStockDetail["Value"];
        } else {
            continue;
        }
    }

    $ClosingConstructionMaterialAmount = $ClosingStockAmount - $ClosingUsedStockAmount;


    //    Closing Construction Material End



    //    Material Used During the Period Start

    $MaterialUsedDuringthePeriod = $MaterialAvailableForUsed - $ClosingConstructionMaterialAmount;

    //    Material Used During the Period End


    //    Construction Labour Expense Start


    $ConstructionLabourExpensesHeadDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$ConstructionLabourExpensesID}");


    $TotalAmountOfConstructionLabourExpenses = 0;
    foreach ($ConstructionLabourExpensesHeadDetails as $ConstructionLabourExpensesHeadDetail) {
        $ConstructionLabourExpensesTransactionDetails = SQL_Select("transaction where HeadOfAccountID={$ConstructionLabourExpensesHeadDetail["ExpenseHeadID"]} and Date BETWEEN '{$FromDate}' and '{$ToDate}' ");



        foreach ($ConstructionLabourExpensesTransactionDetails as $ConstructionLabourExpensesTransactionDetail) {

            if ($ConstructionLabourExpensesHeadDetail["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfConstructionLabourExpenses += $ConstructionLabourExpensesTransactionDetail["dr"] - $ConstructionLabourExpensesTransactionDetail["cr"];
            } else {
                $TotalAmountOfConstructionLabourExpenses += $ConstructionLabourExpensesTransactionDetail["cr"] - $ConstructionLabourExpensesTransactionDetail["dr"];
            }
        }
    }


    //    Construction Labour End


    //    Project Approval Expenses Start


    $ProjectApprovalExpenseHeadDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$ProjectApprovalExpenseID}");


    $TotalAmountOfProjectApprovalExpense = 0;
    foreach ($ProjectApprovalExpenseHeadDetails as $ProjectApprovalExpenseHeadDetail) {
        $ProjectApprovalExpenseTransactionDetails = SQL_Select("transaction where HeadOfAccountID={$ProjectApprovalExpenseHeadDetail["ExpenseHeadID"]} and Date BETWEEN '{$FromDate}' and '{$ToDate}' ");



        foreach ($ProjectApprovalExpenseTransactionDetails as $ProjectApprovalExpenseTransactionDetail) {

            if ($ProjectApprovalExpenseHeadDetail["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfProjectApprovalExpense += $ProjectApprovalExpenseTransactionDetail["dr"] - $ProjectApprovalExpenseTransactionDetail["cr"];
            } else {
                $TotalAmountOfProjectApprovalExpense += $ProjectApprovalExpenseTransactionDetail["cr"] - $ProjectApprovalExpenseTransactionDetail["dr"];
            }
        }
    }

    //    Project Approval Expenses End


    //    Other Expense Start


    $OtherExpenseHeadDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$OtherExpenseID}");


    $TotalAmountOfOtherExpense = 0;
    foreach ($OtherExpenseHeadDetails as $OtherExpenseHeadDetail) {
        $OtherExpenseHeadDetailTransactionDetails = SQL_Select("transaction where HeadOfAccountID={$OtherExpenseHeadDetail["ExpenseHeadID"]} and Date BETWEEN '{$FromDate}' and '{$ToDate}' ");



        foreach ($OtherExpenseHeadDetailTransactionDetails as $OtherExpenseHeadDetailTransactionDetail) {

            if ($OtherExpenseHeadDetail["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfOtherExpense += $OtherExpenseHeadDetailTransactionDetail["dr"] - $OtherExpenseHeadDetailTransactionDetail["cr"];
            } else {
                $TotalAmountOfOtherExpense += $OtherExpenseHeadDetailTransactionDetail["cr"] - $OtherExpenseHeadDetailTransactionDetail["dr"];
            }
        }
    }

    //    Other Expense End



    //    Total Cost Transferred to Work in Process Start

    $TotalCostTransferredtoWorkinProcess = $MaterialUsedDuringthePeriod + $TotalAmountOfConstructionLabourExpenses + $TotalAmountOfProjectApprovalExpense + $TotalAmountOfOtherExpense;

    //    Total Cost Transferred to Work in Process End



    //    Gross Profit Start

    $GrossProfitAmount = $TotalAmountOfRevenue - $TotalCostTransferredtoWorkinProcess;

    // Gross Profit End


    //    Indirect Income Start

    $IndirectIncomeHeadChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$IndirectIncomeID}");


    $TotalAmountOfIndirectIncome = 0;

    foreach ($IndirectIncomeHeadChildDetails as $IndirectIncomeHeadChildDetails) {
        $IndirectIncomeTransactionDetails = SQL_Select("transaction where HeadOfAccountID={$IndirectIncomeHeadChildDetails["ExpenseHeadID"]} and Date BETWEEN '{$FromDate}' and '{$ToDate}' ");

        foreach ($IndirectIncomeTransactionDetails as $IndirectIncomeTransactionDetail) {

            if ($IndirectIncomeHeadChildDetails["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfIndirectIncome += $IndirectIncomeTransactionDetail["dr"] - $IndirectIncomeTransactionDetail["cr"];
            } else {
                $TotalAmountOfIndirectIncome += $IndirectIncomeTransactionDetail["cr"] - $IndirectIncomeTransactionDetail["dr"];
            }
        }
    }

    //    Indirect Income End


    //    Income From Operation Start

    $IncomeFromOperationAmount = $GrossProfitAmount + $TotalAmountOfIndirectIncome;

    //    Income From Operation End


    //    Administration Expenses Start

    $AdministrativeExpenseHeadChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$AdministrativeExpenseID}");


    $TotalAmountOfAdministrativeExpense = 0;

    foreach ($AdministrativeExpenseHeadChildDetails as $AdministrativeExpenseHeadChildDetail) {
        $AdministrativeExpenseTransactionDetails = SQL_Select("transaction where HeadOfAccountID={$AdministrativeExpenseHeadChildDetail["ExpenseHeadID"]} and Date BETWEEN '{$FromDate}' and '{$ToDate}' ");

        foreach ($AdministrativeExpenseTransactionDetails as $AdministrativeExpenseTransactionDetail) {

            if ($AdministrativeExpenseHeadChildDetail["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfAdministrativeExpense += $AdministrativeExpenseTransactionDetail["dr"] - $AdministrativeExpenseTransactionDetail["cr"];
            } else {
                $TotalAmountOfAdministrativeExpense += $AdministrativeExpenseTransactionDetail["cr"] - $AdministrativeExpenseTransactionDetail["dr"];
            }
        }
    }

    //    Administration Expenses End


    //    Income Before Tax & Interest Start

    $IncomeBeforeTaxAndInterestAmount = $IncomeFromOperationAmount - $TotalAmountOfAdministrativeExpense;

    //    Income Before Tax & Interest End


    //    Financial Expense Start

    $FinancialExpenseHeadChildDetails = SQL_Select("expensehead where IncomeExpenseTypeID={$FinancialExpenseID}");


    $TotalAmountOfFinancialExpenseAmount = 0;

    foreach ($FinancialExpenseHeadChildDetails as $FinancialExpenseHeadChildDetail) {
        $FinancialExpenseTransactionDetails = SQL_Select("transaction where HeadOfAccountID={$FinancialExpenseHeadChildDetail["ExpenseHeadID"]} and Date BETWEEN '{$FromDate}' and '{$ToDate}' ");

        foreach ($FinancialExpenseTransactionDetails as $FinancialExpenseTransactionDetail) {

            if ($FinancialExpenseHeadChildDetail["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfFinancialExpenseAmount += $FinancialExpenseTransactionDetail["dr"] - $FinancialExpenseTransactionDetail["cr"];
            } else {
                $TotalAmountOfFinancialExpenseAmount += $FinancialExpenseTransactionDetail["cr"] - $FinancialExpenseTransactionDetail["dr"];
            }
        }
    }

    //    Financial Expense End


    //    Income After Tax & Interest Start

    $IncomeAfterTaxAndInterestAmount = $IncomeBeforeTaxAndInterestAmount - $TotalAmountOfFinancialExpenseAmount;

    //    Income After Tax & Interest End



}



// Right side

if (!empty($FromDate1) && !empty($ToDate1)) {


    //    Revenue Start
    //echo "<br>";
    //echo $RevenueID."<br>";
    $RevenueHeadChildDetails1 = SQL_Select("expensehead where IncomeExpenseTypeID={$RevenueID}");


    $TotalAmountOfRevenue1 = 0;

    foreach ($RevenueHeadChildDetails1 as $RevenueHeadChildDetail1) {

        //echo "tt = ".$RevenueHeadChildDetail1["ExpenseHeadID"];


        $RevenueTransactionDetails1 = SQL_Select("transaction where HeadOfAccountID={$RevenueHeadChildDetail1["ExpenseHeadID"]} and Date BETWEEN '{$FromDate1}' and '{$ToDate1}' ");

        foreach ($RevenueTransactionDetails1 as $RevenueTransactionDetail1) {

            //if ($RevenueHeadChildDetail1["ExpenseHeadIsType"] == 1){

            $TotalAmountOfRevenue1 += $RevenueTransactionDetail1["cr"] - $RevenueTransactionDetail1["dr"];
            //}else{
            //  $TotalAmountOfRevenue1 += $RevenueTransactionDetail1["cr"] - $RevenueTransactionDetail1["dr"];

            //}



        }
    }



    //    Revenue End




    //    Opening Construction Material start

    // Stock Balance

    $StockDetails1 = SQL_Select("stock", "Date BETWEEN '2016-01-01' AND  '{$FromDate1}' ");
    $stockAmount1 = 0;
    foreach ($StockDetails1 as $StockDetail1) {

        if ($StockDetail1["StockIsActive"] == 1) {
            $stockAmount1 += $StockDetail1["Value"];
        } else {
            continue;
        }
    }
    //    used Stock
    $UsedStockDetails1 = SQL_Select("usedstock", "Date BETWEEN '2016-01-01' AND  '{$FromDate1}' ");
    $usedStockAmount1 = 0;
    foreach ($UsedStockDetails1 as $UsedStockDetail1) {

        if ($UsedStockDetail1["UsedStockIsActive"] == 1) {
            $usedStockAmount1 += $UsedStockDetail1["Value"];
        } else {
            continue;
        }
    }

    $OpeningConstructionMaterialAmount1 = $stockAmount1 - $usedStockAmount1;

    //   Opening Constraction material End



    //    Construction Material Purchase start

    $ConstructionMaterialHeadChildDetails1 = SQL_Select("expensehead where IncomeExpenseTypeID={$ConstructionMaterialPurchasesID}");


    $TotalAmountOfConstructionMaterialPurchases1 = 0;

    foreach ($ConstructionMaterialHeadChildDetails1 as $ConstructionMaterialHeadChildDetail1) {
        $ConstructionMaterialChildTransactionDetails1 = SQL_Select("transaction where HeadOfAccountID={$ConstructionMaterialHeadChildDetail1["ExpenseHeadID"]} and Date BETWEEN '{$FromDate1}' and '{$ToDate1}' ");

        foreach ($ConstructionMaterialChildTransactionDetails1 as $ConstructionMaterialChildTransactionDetail1) {

            if ($ConstructionMaterialHeadChildDetail1["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfConstructionMaterialPurchases1 += $ConstructionMaterialChildTransactionDetail1["dr"] - $ConstructionMaterialChildTransactionDetail1["cr"];
            } else {
                $TotalAmountOfConstructionMaterialPurchases1 += $ConstructionMaterialChildTransactionDetail1["cr"] - $ConstructionMaterialChildTransactionDetail1["dr"];
            }
        }
    }

    //    Construction Material Purchase End


    //    Material Available For Used Start

    $MaterialAvailableForUsed1 = $OpeningConstructionMaterialAmount1 + $TotalAmountOfConstructionMaterialPurchases1;

    //    Material Available For Used End



    //    Closing Construction Material Start

    // Stock Balance

    $ClosingStockDetails1 = SQL_Select("stock", "Date BETWEEN '2016-01-01' AND  '{$ToDate1}' ");
    $ClosingStockAmount1 = 0;
    foreach ($ClosingStockDetails1 as $ClosingStockDetail1) {

        if ($ClosingStockDetail1["StockIsActive"] == 1) {
            $ClosingStockAmount1 += $ClosingStockDetail1["Value"];
        } else {
            continue;
        }
    }
    //    used Stock
    $ClosingUsedStockDetails1 = SQL_Select("usedstock", "Date BETWEEN '2016-01-01' AND  '{$ToDate1}' ");
    $ClosingUsedStockAmount1 = 0;
    foreach ($ClosingUsedStockDetails1 as $ClosingUsedStockDetail1) {

        if ($ClosingUsedStockDetail1["UsedStockIsActive"] == 1) {
            $ClosingUsedStockAmount1 += $ClosingUsedStockDetail1["Value"];
        } else {
            continue;
        }
    }

    $ClosingConstructionMaterialAmount1 = $ClosingStockAmount1 - $ClosingUsedStockAmount1;


    //    Closing Construction Material End



    //    Material Used During the Period Start

    $MaterialUsedDuringthePeriod1 = $MaterialAvailableForUsed1 - $ClosingConstructionMaterialAmount1;

    //    Material Used During the Period End


    //    Construction Labour Expense Start


    $ConstructionLabourExpensesHeadDetails1 = SQL_Select("expensehead where IncomeExpenseTypeID={$ConstructionLabourExpensesID}");


    $TotalAmountOfConstructionLabourExpenses1 = 0;
    foreach ($ConstructionLabourExpensesHeadDetails1 as $ConstructionLabourExpensesHeadDetail1) {
        $ConstructionLabourExpensesTransactionDetails1 = SQL_Select("transaction where HeadOfAccountID={$ConstructionLabourExpensesHeadDetail1["ExpenseHeadID"]} and Date BETWEEN '{$FromDate1}' and '{$ToDate1}' ");



        foreach ($ConstructionLabourExpensesTransactionDetails1 as $ConstructionLabourExpensesTransactionDetail1) {

            if ($ConstructionLabourExpensesHeadDetail1["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfConstructionLabourExpenses1 += $ConstructionLabourExpensesTransactionDetail1["dr"] - $ConstructionLabourExpensesTransactionDetail1["cr"];
            } else {
                $TotalAmountOfConstructionLabourExpenses1 += $ConstructionLabourExpensesTransactionDetail1["cr"] - $ConstructionLabourExpensesTransactionDetail1["dr"];
            }
        }
    }


    //    Construction Labour End


    //    Project Approval Expenses Start


    $ProjectApprovalExpenseHeadDetails1 = SQL_Select("expensehead where IncomeExpenseTypeID={$ProjectApprovalExpenseID}");


    $TotalAmountOfProjectApprovalExpense1 = 0;
    foreach ($ProjectApprovalExpenseHeadDetails1 as $ProjectApprovalExpenseHeadDetail1) {
        $ProjectApprovalExpenseTransactionDetails1 = SQL_Select("transaction where HeadOfAccountID={$ProjectApprovalExpenseHeadDetail1["ExpenseHeadID"]} and Date BETWEEN '{$FromDate1}' and '{$ToDate1}' ");

        foreach ($ProjectApprovalExpenseTransactionDetails1 as $ProjectApprovalExpenseTransactionDetail1) {

            if ($ProjectApprovalExpenseHeadDetail1["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfProjectApprovalExpense1 += $ProjectApprovalExpenseTransactionDetail1["dr"] - $ProjectApprovalExpenseTransactionDetail1["cr"];
            } else {
                $TotalAmountOfProjectApprovalExpense1 += $ProjectApprovalExpenseTransactionDetail1["cr"] - $ProjectApprovalExpenseTransactionDetail1["dr"];
            }
        }
    }

    //    Project Approval Expenses End


    //    Other Expense Start


    $OtherExpenseHeadDetails1 = SQL_Select("expensehead where IncomeExpenseTypeID={$OtherExpenseID}");


    $TotalAmountOfOtherExpense1 = 0;
    foreach ($OtherExpenseHeadDetails1 as $OtherExpenseHeadDetail1) {
        $OtherExpenseHeadDetailTransactionDetails1 = SQL_Select("transaction where HeadOfAccountID={$OtherExpenseHeadDetail1["ExpenseHeadID"]} and Date BETWEEN '{$FromDate1}' and '{$ToDate1}' ");



        foreach ($OtherExpenseHeadDetailTransactionDetails1 as $OtherExpenseHeadDetailTransactionDetail1) {

            if ($OtherExpenseHeadDetail1["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfOtherExpense1 += $OtherExpenseHeadDetailTransactionDetail1["dr"] - $OtherExpenseHeadDetailTransactionDetail1["cr"];
            } else {
                $TotalAmountOfOtherExpense1 += $OtherExpenseHeadDetailTransactionDetail1["cr"] - $OtherExpenseHeadDetailTransactionDetail1["dr"];
            }
        }
    }

    //    Other Expense End



    //    Total Cost Transferred to Work in Process Start

    $TotalCostTransferredtoWorkinProcess1 = $MaterialUsedDuringthePeriod1 + $TotalAmountOfConstructionLabourExpenses1 + $TotalAmountOfProjectApprovalExpense1 + $TotalAmountOfOtherExpense1;

    //    Total Cost Transferred to Work in Process End




    //    Gross Profit Start

    $GrossProfitAmount1 = $TotalAmountOfRevenue1 - $TotalCostTransferredtoWorkinProcess1;

    // Gross Profit End


    //    Indirect Income Start

    $IndirectIncomeHeadChildDetails1 = SQL_Select("expensehead where IncomeExpenseTypeID={$IndirectIncomeID}");


    $TotalAmountOfIndirectIncome1 = 0;

    foreach ($IndirectIncomeHeadChildDetails1 as $IndirectIncomeHeadChildDetails1) {
        $IndirectIncomeTransactionDetails1 = SQL_Select("transaction where HeadOfAccountID={$IndirectIncomeHeadChildDetails1["ExpenseHeadID"]} and Date BETWEEN '{$FromDate1}' and '{$ToDate1}' ");

        foreach ($IndirectIncomeTransactionDetails1 as $IndirectIncomeTransactionDetail1) {

            if ($IndirectIncomeHeadChildDetails1["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfIndirectIncome1 += $IndirectIncomeTransactionDetail1["dr"] - $IndirectIncomeTransactionDetail1["cr"];
            } else {
                $TotalAmountOfIndirectIncome1 += $IndirectIncomeTransactionDetail1["cr"] - $IndirectIncomeTransactionDetail1["dr"];
            }
        }
    }

    //    Indirect Income End


    //    Income From Operation Start

    $IncomeFromOperationAmount1 = $GrossProfitAmount1 + $TotalAmountOfIndirectIncome1;

    //    Income From Operation End


    //    Administration Expenses Start

    $AdministrativeExpenseHeadChildDetails1 = SQL_Select("expensehead where IncomeExpenseTypeID={$AdministrativeExpenseID}");


    $TotalAmountOfAdministrativeExpense1 = 0;

    foreach ($AdministrativeExpenseHeadChildDetails1 as $AdministrativeExpenseHeadChildDetail1) {
        $AdministrativeExpenseTransactionDetails1 = SQL_Select("transaction where HeadOfAccountID={$AdministrativeExpenseHeadChildDetail1["ExpenseHeadID"]} and Date BETWEEN '{$FromDate1}' and '{$ToDate1}' ");

        foreach ($AdministrativeExpenseTransactionDetails1 as $AdministrativeExpenseTransactionDetail1) {

            if ($AdministrativeExpenseHeadChildDetail1["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfAdministrativeExpense1 += $AdministrativeExpenseTransactionDetail1["dr"] - $AdministrativeExpenseTransactionDetail1["cr"];
            } else {
                $TotalAmountOfAdministrativeExpense1 += $AdministrativeExpenseTransactionDetail1["cr"] - $AdministrativeExpenseTransactionDetail1["dr"];
            }
        }
    }

    //    Administration Expenses End


    //    Income Before Tax & Interest Start

    $IncomeBeforeTaxAndInterestAmount1 = $IncomeFromOperationAmount1 - $TotalAmountOfAdministrativeExpense1;

    //    Income Before Tax & Interest End


    //    Financial Expense Start

    $FinancialExpenseHeadChildDetails1 = SQL_Select("expensehead where IncomeExpenseTypeID={$FinancialExpenseID}");


    $TotalAmountOfFinancialExpenseAmount1 = 0;

    foreach ($FinancialExpenseHeadChildDetails1 as $FinancialExpenseHeadChildDetail1) {
        $FinancialExpenseTransactionDetails1 = SQL_Select("transaction where HeadOfAccountID={$FinancialExpenseHeadChildDetail1["ExpenseHeadID"]} and Date BETWEEN '{$FromDate1}' and '{$ToDate1}' ");

        foreach ($FinancialExpenseTransactionDetails1 as $FinancialExpenseTransactionDetail1) {

            if ($FinancialExpenseHeadChildDetail1["ExpenseHeadIsType"] == 1) {

                $TotalAmountOfFinancialExpenseAmount1 += $FinancialExpenseTransactionDetail1["dr"] - $FinancialExpenseTransactionDetail1["cr"];
            } else {
                $TotalAmountOfFinancialExpenseAmount1 += $FinancialExpenseTransactionDetail1["cr"] - $FinancialExpenseTransactionDetail1["dr"];
            }
        }
    }

    //    Financial Expense End


    //    Income After Tax & Interest Start

    $IncomeAfterTaxAndInterestAmount1 = $IncomeBeforeTaxAndInterestAmount1 - $TotalAmountOfFinancialExpenseAmount1;

    //    Income After Tax & Interest End



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

    <title>Profit & Loss Account</title>

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
    <p style="font-size: 16px">Printing Date & Time: ' . date('F j-y, h:i:sa') . '</p>
</div>

<div style="width: 95%; margin: auto">

    <div style="padding: 10px 0px" class="company-name row">
        <div  class="col-md-2 text-center">
            <img height="70px" src="./upload/' . $Settings["logo"] . '" alt="">
        </div>
        <div  class="col-md-9 text-center">
            <h3 style="font-weight: bold">' . $Settings["CompanyName"] . '</h3>
            <p style="font-size: 18px;">' . $Settings["Address"] . '</p>

        </div>

    </div>

    <div class="projectName text-center m-b-30 m-t-30">
        <h4 style="font-weight: bold">Profit & Loss Account</h4>
    </div>
    
   <table class="table table-bordered table-hover table-fixed table-sm">
        
          <thead>
                <tr>
                    <th  scope="col" class="text-center"> <h5>Particulars</h5></th>
                    <th  scope="col" class="text-center"> <h5>' . HumanReadAbleDateFormat($FromDate) . ' To ' . HumanReadAbleDateFormat($ToDate) . '</h5></th>
                    <th  scope="col" class="text-center"> <h5>' . HumanReadAbleDateFormat($FromDate1) . ' To ' . HumanReadAbleDateFormat($ToDate1) . '</h5></th>
                </tr>
                </thead>
                <thead>
                <tr>
                    <th scope="col"></th>
                    <th width="300px" class="text-right" scope="col">Tk</th>
                    <th width="300px"  class="text-right"  scope="col">TK</th>
                </tr>
                </thead>
        
                <tbody>
                    <tr style="font-weight: bold">
                        <td>Revenue</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($TotalAmountOfRevenue) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($TotalAmountOfRevenue1) . '</td>
                        
                    </tr>
                    <tr>
                        <td>Cost Of Revenue</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($TotalCostTransferredtoWorkinProcess) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($TotalCostTransferredtoWorkinProcess1) . '</td>
                        
                    </tr>
                    <tr  style="font-weight: bold">
                        <td>Gross Profit</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($GrossProfitAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($GrossProfitAmount1) . '</td>
                        
                    </tr>
                    <tr>
                        <td>Indirect Income</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($TotalAmountOfIndirectIncome) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($TotalAmountOfIndirectIncome1) . '</td>
                        
                    </tr>
                    <tr style="font-weight: bold">
                        <td>Income From Operation</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($IncomeFromOperationAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($IncomeFromOperationAmount1) . '</td>
                        
                    </tr>
                    
                    <tr>
                        <td>Administration Expenses</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($TotalAmountOfAdministrativeExpense) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($TotalAmountOfAdministrativeExpense1) . '</td>
                        
                    </tr>
                    <tr  style="font-weight: bold">
                        <td>Income Before Tax & Interest</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($IncomeBeforeTaxAndInterestAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($IncomeBeforeTaxAndInterestAmount1) . '</td>
                        
                    </tr>
                    
                    <tr>
                        <td>Financial Expense</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($TotalAmountOfFinancialExpenseAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($TotalAmountOfFinancialExpenseAmount1) . '</td>
                        
                    </tr>
                    
                    <tr style="font-weight: bold">
                        <td>Income After Tax & Interest</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($IncomeAfterTaxAndInterestAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($IncomeAfterTaxAndInterestAmount1) . '</td>
                        
                    </tr>
                    
                    <tr>
                        <td>Provision & Tax Paid</td>
                        <td class="text-right">0</td>
                        <td class="text-right">0</td>
                        
                    </tr>
                    
                    
                    <tr style="font-weight: bold">
                        <td>Net Profit/ (Loss)</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($IncomeAfterTaxAndInterestAmount) . '</td>
                        <td class="text-right">' . BangladeshiCurencyFormat($IncomeAfterTaxAndInterestAmount1) . '</td>
                        
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
