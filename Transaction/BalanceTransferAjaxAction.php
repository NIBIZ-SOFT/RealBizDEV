<?php


// Get balance and other information
if ($_GET["id"]) {

    $id = $_POST["id"];

    $BankCashInformation = SQL_Select("Bankcash", "BankCashID={$id}");
    $CurrentBalance = $BankCashInformation[0]["CurrentBalance"];

    echo json_encode($CurrentBalance);
}

// Balance transfer

if ($_GET["transfer"]) {

    $formAccauntId = $_POST["formAccauntId"];

    $toAccauntId = $_POST["toAccauntId"];

    $TransferBalanceAmount = $_POST["TransferBalanceAmount"];


    $transferDate = $_POST["datepicker"];
    $transferDescription = $_POST["description"];


// Form accaunt
    $formAccauntBankCashInformation = SQL_Select("Bankcash", "BankCashID={$formAccauntId}");

// To accaunt
    $ToAccauntBankCashInformation = SQL_Select("Bankcash", "BankCashID={$toAccauntId}");


    // Bankcash table

    // Form accaunt reduce
    $CurrentBalanceFormAccaunt = $formAccauntBankCashInformation[0]["CurrentBalance"];
    $newBalanceFormAccaunt = (($CurrentBalanceFormAccaunt) - ($TransferBalanceAmount));
    // Update
    mysql_query("UPDATE tblbankcash SET CurrentBalance ={$newBalanceFormAccaunt} WHERE BankCashID = {$formAccauntId}");


    //To accaunt Add
    $CurrentBalanceToAccaunt = $ToAccauntBankCashInformation[0]["CurrentBalance"];
    $NewBalanceToAccaunt = (($CurrentBalanceToAccaunt) + ($TransferBalanceAmount));
    mysql_query("UPDATE tblbankcash SET CurrentBalance ={$NewBalanceToAccaunt} WHERE BankCashID = {$toAccauntId}");




    // Insert same information into transation table

    // data  Transfer form accaaunt


    /*
        mysql_query("INSERT INTO tbltransaction (BankCashID, BankCashName, Type, Amount, Description, Date,Balance , dr,cr)
    VALUES ('".$formAccauntId."','".$formAccauntBankCashInformation[0]["AccountTitle"]."','Balance Transfer DR','".$TransferBalanceAmount."','".$transferDescription."','".$transferDate."','".$newBalanceFormAccaunt."','".$TransferBalanceAmount."','0');");

    */


    $Where = "";

    SQL_InsertUpdate(
        $Entity = "Transaction",
        $TheEntityNameData = array(
            "BankCashID" => $formAccauntId,
            "BankCashName" => $formAccauntBankCashInformation[0]["AccountTitle"],
            "Type" => "Balance Transfer",
            "Amount" => $TransferBalanceAmount,
            "Description" => $transferDescription,

            "Date" => $transferDate,
            "dr" => $TransferBalanceAmount,
            "cr" => "0",
            "Balance" => $newBalanceFormAccaunt,
        ),
        $Where
    );


// Data to transfer accaunt


    SQL_InsertUpdate(
        $Entity = "Transaction",
        $TheEntityNameData = array(
            "BankCashID" => $toAccauntId,
            "BankCashName" => $ToAccauntBankCashInformation[0]["AccountTitle"],
            "Type" => "Balance Transfer",
            "Amount" => $TransferBalanceAmount,
            "Description" => $transferDescription,

            "Date" => $transferDate,
            "dr" => "0",
            "cr" => $TransferBalanceAmount,
            "Balance" => $NewBalanceToAccaunt,
        ),
        $Where
    );


    $data = "Success";
    echo json_encode($data);

}


?>