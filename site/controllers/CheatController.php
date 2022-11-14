<?php
include_once 'utils.php';

function сreateNewCheat($username, $cheatname, $dllname, $processname, $isUsermode, $injection_type)
{
    global $db;

    $cheatname_sec = fix_string($cheatname);
    $username_sec = fix_string($username);
    $dllname_sec = fix_string($dllname);
    $processname_sec = fix_string($processname);
    $isExternal_sec = fix_string($isUsermode);
    $injection_type_sec = fix_string($injection_type);

    $query = "SELECT * FROM `cheats` WHERE `name` = '{$cheatname_sec}'";
    $row = mysqli_fetch_assoc(mysqli_query($db, $query));

    if (empty($row)) {
        $query = "INSERT INTO `cheats` (`name`, `status`, `filename`, `process`, `external`, `injection`, `creator`) VALUES ('{$cheatname_sec}', 'undetected', '{$dllname_sec}', '{$processname_sec}', '{$isExternal_sec}', '{$injection_type_sec}', '{$username_sec}')";
        mysqli_query($db, $query);
        return true;
    } else {
        return false;
    }
}

function getAllCheats()
{
    global $db;

    $query = "SELECT * FROM `cheats` WHERE 1";

    $result = mysqli_query($db, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
    return $array;
}

function freezeCheat($cheatid)
{
    global $db;

    $cheatid_sec = fix_string($cheatid);
    $query = "UPDATE `cheats` SET `status` = 'freezed' WHERE `id` = '{$cheatid_sec}'";
    mysqli_query($db, $query);
}

function unfreezeCheat($cheatid)
{
    global $db;

    $cheatid_sec = fix_string($cheatid);
    $query = "UPDATE `cheats` SET `status` = 'undetected' WHERE `id` = '{$cheatid_sec}'";
    mysqli_query($db, $query);
}

function deleteCheat($cheatid)
{
    global $db;

    $cheatid_sec = fix_string($cheatid);
    $query = "DELETE FROM `cheats` WHERE `id` = '{$cheatid_sec}'";
    mysqli_query($db, $query);
}

function getCheatInfo($cheatid)
{
    global $db;

    $cheatid_sec = fix_string($cheatid);

    $query = "SELECT * FROM `cheats` WHERE `id` = '{$cheatid_sec}'";

    $result = mysqli_query($db, $query);
    $keyinfo = mysqli_fetch_assoc($result);

    return $keyinfo;
}

function getCheatsCount()
{
    global $db;


    $query = "SELECT count(*) FROM `cheats`";

    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_row($result);

    return $row[0];
}
