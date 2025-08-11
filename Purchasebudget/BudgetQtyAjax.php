<?php

if ($_POST["categoryId"] and $_POST["ExpenseId"] ){

    $categoryId=$_POST["categoryId"];
    $ExpenseId=$_POST["ExpenseId"];

    $data=SQL_Select($Entity="PurchaseBudget where CategoryID={$categoryId} and ExpenseHeadID={$ExpenseId}");

    $data=json_encode($data[0]);

    echo $data;


}





