<?php
include_once 'utils.php';

function createNewLog($message, $key, $hwid)
{
    global $db;

    $message_sec = fix_string($message);
    $key_sec = fix_string($key);
    $hwid_sec = fix_string($hwid);
    $ip = $_SERVER['REMOTE_ADDR'];

    $query = "INSERT INTO `logs` (`hwid`, `key`, `message`, `ip`) VALUES ('{$hwid_sec}', '{$key_sec}', '{$message_sec}', '{$ip}')";

    return mysqli_query($db, $query);
}

function getAllLogs()
{
    global $db;

    $query = "SELECT * FROM `logs` WHERE 1";

    $result = mysqli_query($db, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
    return $array;
}