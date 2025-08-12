<?php

include "./script/{$_REQUEST["Base"]}/Scriptvariables.php";

$UpdateMode = false;

if (isset($_REQUEST[$Entity . "ID"]) && isset($_REQUEST[$Entity . "UUID"])) $UpdateMode = true;

$ErrorUserInput["_Error"] = false;

if (!$UpdateMode) $_REQUEST["{$Entity}ID"] = 0;

// Check for duplicate BOQ Title for same ProjectID
$TheEntityName = SQL_Select(
    $Entity,
    $Where = "ProjectID = '" . intval($_POST["ProjectID"]) . "' AND BOQTitle = '" . addslashes($_POST["BOQTitle"]) . "' AND {$Entity}ID <> " . intval($_REQUEST[$Entity . "ID"])
);

if (count($TheEntityName) > 0) {
    $ErrorUserInput["_Error"] = true;
    $ErrorUserInput["_Message"] = "This BOQ Title already exists for the selected project.";
}

if ($ErrorUserInput["_Error"]) {
    include "./script/{$_REQUEST["Base"]}/Insertupdate.php";
} else {
    $Where = "";
    if ($UpdateMode) $Where = "{$Entity}ID = " . intval($_REQUEST[$Entity . "ID"]) . " AND {$Entity}UUID = '" . addslashes($_REQUEST[$Entity . "UUID"]) . "'";

    // Insert/Update into BOQ table
    $TheEntityName = SQL_InsertUpdate(
        $Entity,
        $TheEntityNameData = array(
            "ProjectID" => intval($_POST["ProjectID"]),
            "BOQTitle" => addslashes($_POST["BOQTitle"]),
            "DateInserted" => addslashes($_POST["DateInserted"]),
            "{$Entity}IsActive" => intval($_POST["{$Entity}IsActive"])
        ),
        $Where
    );

    $MainContent .= CTL_Window(
        $Title = "BOQ Management",
        "The operation completed successfully.<br><br>The {$EntityCaptionLower} information has been stored.<br><br>Please click <a href=\"" . ApplicationURL("{$_REQUEST["Base"]}", "Manage") . "\">here</a> to proceed.",
        300
    );

    $MainContent .= "<script language=\"JavaScript\">window.location='" . ApplicationURL("{$_REQUEST["Base"]}", "Manage") . "';</script>";
}

?>
