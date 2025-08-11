<?php


if ( isset( $_POST["AdvancepaidcontructorID"] ) ){

    $Where="AdvancepaidcontructorID={$_POST["AdvancepaidcontructorID"]}";

    $TheEntityName=SQL_InsertUpdate(
        $Entity="advancepaidcontructor",
        $TheEntityNameData=array(
            "AdvancepaidcontructorIsActive"=>1,
        ),
        $Where
    );

    echo json_encode( $_POST["AdvancepaidcontructorID"] );

}


