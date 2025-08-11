<?php

    //echo "purchase where CategoryID={$_POST["ProjectID"]} and  VendorID={$_POST["VendorID"]} and confirmRequisitonId={$_POST["RequisitionID"]} and PurchaseConfirmID='{$_POST["PurchaseID"]}' and Confirm='Confirm' ";

//if (!empty($_POST["ProjectID"]) and !empty($_POST["HeadOfAccountID"])  and !empty($_POST["VendorID"])  and !empty($_POST["RequisitionID"]) and !empty($_POST["PurchaseID"]) ){
if (!empty($_POST["ProjectID"]) and !empty($_POST["HeadOfAccountID"])  and !empty($_POST["VendorID"])  and  !empty($_POST["PurchaseID"]) ){


    //echo "purchase where CategoryID={$_POST["ProjectID"]} and  VendorID={$_POST["VendorID"]} and confirmRequisitonId={$_POST["RequisitionID"]} and PurchaseConfirmID='{$_POST["PurchaseID"]}' and Confirm='Confirm' ";

    //$ConfirmPurches=SQL_Select("purchase where CategoryID={$_POST["ProjectID"]} and  VendorID={$_POST["VendorID"]} and confirmRequisitonId={$_POST["RequisitionID"]} and PurchaseConfirmID='{$_POST["PurchaseID"]}' and Confirm='Confirm' ");
    $ConfirmPurches=SQL_Select("purchase where CategoryID={$_POST["ProjectID"]} and  VendorID={$_POST["VendorID"]} and PurchaseConfirmID='{$_POST["PurchaseID"]}' and Confirm='Confirm' ");

    $items=$ConfirmPurches[0]["Items"];

// ProjectID
// 18

// HeadOfAccountID
// 26

// VendorID
// 3

// RequisitionID
// 10

// PurchaseID
// POD25-00004


    //echo "select SUM(Qty) as TotalQty,SUM(Rate) as TotalRate,SUM(Value) as TotalValue from tblstock where HeadOfAccountID = {$_POST["HeadOfAccountID"]} and ProjectID={$_POST["ProjectID"]} and  VendorID={$_POST["VendorID"]} and RequisitionID={$_POST["RequisitionID"]} and PurchaseID='{$_POST["PurchaseID"]}'  ";

    $StockSQL = mysql_query("select SUM(Qty) as TotalQty,SUM(Rate) as TotalRate,SUM(Value) as TotalValue from tblstock where HeadOfAccountID = {$_POST["HeadOfAccountID"]} and ProjectID={$_POST["ProjectID"]} and  VendorID={$_POST["VendorID"]} and  PurchaseID='{$_POST["PurchaseID"]}'  ");
    $Stock = @mysql_fetch_array($StockSQL, MYSQL_ASSOC);


    $items=json_decode($items);
    //print_r($items);

    $requisitionDatas=[];
    foreach ($items as $item){
        if ($item->expenseHead==$_POST["HeadOfAccountID"]){
            $requisitionDatas["requisitionQty"]=$item->requisitionQty - $Stock["TotalQty"];
            $requisitionDatas["requisitionRate"]=$item->requisitionRate;
            $requisitionDatas["requisitionAmount"]=$item->requisitionAmount;

        }

    }

    echo json_encode($requisitionDatas);



}