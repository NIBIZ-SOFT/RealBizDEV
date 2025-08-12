<?php

if (isset($_POST["id"])){
    $id=$_POST["id"];
    $purchaseItems=SQL_Select("Purchaserequisition where (CategoryID=$id && Confirm='Confirm')");
    echo json_encode($purchaseItems);

}

if (isset( $_POST["categoryId"], $_POST["ConfirmId"] )){

    $categoryId=$_POST["categoryId"];
    $ConfirmId=$_POST["ConfirmId"];

    $RequisitionConfirmItems=SQL_Select("Purchaserequisition where (CategoryID=$categoryId and PurchaseRequisitionID= $ConfirmId  and Confirm='Confirm')");


    $ExpenseHeadName=[];
    $indexHead=0;
    foreach ($RequisitionConfirmItems as $purchaseItem){
        $OnlyItems=json_decode($purchaseItem["Items"]);
        foreach ($OnlyItems as $onlyItem){
            $ExpenseHeadName[$onlyItem->expenseHead]=GetExpenseHeadName($onlyItem->expenseHead);
        }
    }


    $ConfirmItemsRequisiton=SQL_Select("Purchaserequisition where (CategoryID=$categoryId  and Confirm='Confirm')");


//echo "<pre>";
    $confirmExpenseHead = [];
    foreach ($ConfirmItemsRequisiton as $requisitionConfirmItem) {
        $sss = json_decode($requisitionConfirmItem["Items"]);
        foreach ($sss as $ss) {
            $confirmExpenseHead[] = $ss->expenseHead;
        }

    }

    $TotalRequisitionQty = [];
    $requisitionRate = [];

    $i = 0;
    foreach ($ConfirmItemsRequisiton as $requisitionConfirmItem) {
        $sss = json_decode($requisitionConfirmItem["Items"]);


        foreach ($sss as $ss) {
            if ($ss->expenseHead == $confirmExpenseHead[$i]) {
                $TotalRequisitionQty[$ss->expenseHead] += $ss->requisitionQty;
            } else {
                $TotalRequisitionQty[$ss->expenseHead] += $ss->requisitionQty;
            }
            $requisitionRate[$ss->expenseHead] = $ss->requisitionRate;
            $i++;

        }

    }

    $PurchaseConfirmItems = SQL_Select("Purchase where (CategoryID=$categoryId and confirmRequisitonId=$ConfirmId  and Confirm='Confirm')");

    $PurchaseconfirmExpenseHead = [];
    foreach ($PurchaseConfirmItems as $PurchaseConfirmItem) {
        $PurchasesConfirms = json_decode($PurchaseConfirmItem["Items"]);
        foreach ($PurchasesConfirms as $purchasesConfirm) {

            $PurchaseconfirmExpenseHead[] = $purchasesConfirm->expenseHead;
        }

    }

    $TotalPurchaseQty = [];
    $PurchaseRequisitionRate = [];

    $indexPurchase = 0;
    foreach ($PurchaseConfirmItems as $PurchaseConfirmItem) {
        $PurchasesConfirms = json_decode($PurchaseConfirmItem["Items"]);

        foreach ($PurchasesConfirms as $purchasesConfirm) {
            if ($PurchaseconfirmExpenseHead[$indexPurchase] == $purchasesConfirm->expenseHead) {
                $TotalPurchaseQty[$purchasesConfirm->expenseHead]+=$purchasesConfirm->requisitionQty;
            }else{
                $TotalPurchaseQty[$purchasesConfirm->expenseHead]=$purchasesConfirm->requisitionQty;
            }
            $PurchaseRequisitionRate[$purchasesConfirm->expenseHead]=$purchasesConfirm->requisitionRate;

            $indexPurchase++;

        }
    }


    $ExpenseHeadNamePacket=[$ExpenseHeadName];


/*    Total confirm requisition  amount*/

    $confirmRequisitionItemsss=[$TotalRequisitionQty,$requisitionRate];

/*    Total confirm Purchase   amount*/

    $confirmPurchaseItemsssssss=[$TotalPurchaseQty,$PurchaseRequisitionRate];

    $result=array_merge($RequisitionConfirmItems,$ExpenseHeadNamePacket,$confirmRequisitionItemsss,$confirmPurchaseItemsssssss);

    echo json_encode($result);


}

?>










