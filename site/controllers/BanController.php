<?php
include_once 'utils.php';

function banHwid($hwid, $reason)
{
    global $db;

    $hwid_sec = fix_string($hwid);
    $reason_sec = fix_string($reason);


    $query = "SELECT * FROM `hwids` WHERE `hwid`='{$hwid_sec}'";
    $row = mysqli_fetch_assoc(mysqli_query($db, $query));

    if (empty($row)) {
        $query = "INSERT INTO `hwids` (`hwid`, `reason`) VALUES ('{$hwid_sec}', '{$reason_sec}')";
        mysqli_query($db, $query);
       return true;
    } else {
       return false;
    }
}

function unbanHwid($hwid)
{
    global $db;

    $hwid_sec = fix_string($hwid);

    $query = "DELETE FROM `hwids` WHERE `hwid` = '{$hwid_sec}' LIMIT 1";
    mysqli_query($db, $query);
}

function checkIfBanned($hwid)
{
    global $db;

    $hwid_sec = fix_string($hwid);

    $query = "SELECT * FROM `hwids` WHERE `hwid` = '{$hwid_sec}'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row != null) {
        return true;
    }
    if ($row == null) {
        return false;
    }
}

function getAllHwids()
{
    global $db;

    $query = "SELECT * FROM `hwids` WHERE 1";

    $result = mysqli_query($db, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
    return $array;
}
