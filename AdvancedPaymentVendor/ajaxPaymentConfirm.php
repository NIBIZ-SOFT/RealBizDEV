<?php


if ( isset( $_POST["AdvancepaidvendorID"] ) ){

    $Where="AdvancepaidvendorID={$_POST["AdvancepaidvendorID"]}";

    $TheEntityName=SQL_InsertUpdate(
        $Entity="Advancepaidvendor",
        $TheEntityNameData=array(
            "AdvancepaidvendorIsActive"=>1,
        ),
        $Where
    );

    echo json_encode( $_POST["AdvancepaidvendorID"] );

}


