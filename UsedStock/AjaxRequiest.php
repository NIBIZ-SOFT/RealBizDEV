<?php

if (!empty($_POST["ProjectID"]) and !empty($_POST["HeadOfAccountID"])) {

    $StockDetails = SQL_Select("Stock where ProjectID={$_POST["ProjectID"]} and HeadOfAccountID={$_POST["HeadOfAccountID"]} and StockIsActive=1");

    $stockDetail["Qty"]=0;
    $stockDetail["Rate"]=0;
    $stockDetail["Value"]=0;
    $i=0;
    foreach ($StockDetails as $Stock) {
        $stockDetail["Qty"] += $Stock["Qty"];
        $totalRate += $Stock["Rate"];
        $stockDetail["Value"] += $Stock["Value"];
        $i++;
    }

    $stockDetail["Rate"] =$totalRate / $i;

    echo json_encode($stockDetail);

}