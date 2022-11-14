<?php
include_once 'utils.php';

function generateNewKeys($key, $username, $cheatid, $days)
{
    global $db;

    $username_sec = fix_string($username);
    $cheatid_sec = fix_string($cheatid);
    $key_sec = fix_string($key);
    $days_sec = fix_string($days);

    $query = "INSERT INTO `keys` (`key`, `status`, `subscribe`, `cheat`, `creator`) VALUES ('{$key_sec}', 'waiting', '{$days_sec}', '{$cheatid_sec}', '{$username_sec}')";
    mysqli_query($db, $query);
}

function banKey($key, $reason)
{
    global $db;

    $key_sec = fix_string($key);
    $reason_sec = fix_string($reason);

    $query = "UPDATE `keys` SET `status` = 'banned' WHERE `key` = '{$key_sec}' LIMIT 1";
    mysqli_query($db, $query);

    $query = "UPDATE `keys` SET `banreason` = '{$reason_sec}' WHERE `key` = '{$key_sec}' LIMIT 1";
    mysqli_query($db, $query);

    return true;
}

function unbanKey($key)
{
    global $db;

    $key_sec = fix_string($key);

    $query = "UPDATE `keys` SET `status` = 'activated' WHERE `key` = '{$key_sec}' LIMIT 1";
    mysqli_query($db, $query);

    $query = "UPDATE `keys` SET `banreason` = '' WHERE `key` = '{$key_sec}' LIMIT 1";
    mysqli_query($db, $query);

    return true;
}

function deleteKey($key_id)
{
    global $db;

    $id_sec = fix_string($key_id);

    $query = "DELETE FROM `keys` WHERE `id` = '{$id_sec}' LIMIT 1";
    mysqli_query($db, $query);
}

function resetHwidOnKey($key)
{
    global $db;

    $key_sec = fix_string($key);

    $query = "UPDATE `keys` SET `hwid` = '' WHERE `key` = '{$key_sec}' LIMIT 1";
    mysqli_query($db, $query);
}

function addDaysForAllKeys($key, $time)
{
    global $db;

    $key_sec = fix_string($key);
    $time_sec = fix_string($time);

    $key_info = getKeyInfo($key_sec);

    if ($key_info['subscribeend'] != NULL || $key_info['subscribeend'] <= time()) {
        $subscribtion_endtime_new = $key_info['subscribeend'] + ($time_sec * 86400);

        $query = "UPDATE `keys` SET 'subscribeend' = '{$subscribtion_endtime_new}'";
        mysqli_query($db, $query);
    }
}

function getAllKeysByUsername($username)
{
    global $db;

    $username_sec = fix_string($username);

    $query = "SELECT * FROM `keys` WHERE `creator` = '{$username_sec}'";

    $result = mysqli_query($db, $query);
    $keys = mysqli_fetch_assoc($result);

    return $keys;
}

function getAllKeys()
{
    global $db;

    $query = "SELECT * FROM `keys` WHERE 1";

    $result = mysqli_query($db, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
    return $array;
}

function getKeyInfo($key)
{
    global $db;

    $key_sec = fix_string($key);

    $query = "SELECT * FROM `keys` WHERE `key` = '{$key_sec}'";

    $result = mysqli_query($db, $query);
    $keyinfo = mysqli_fetch_assoc($result);

    return $keyinfo;
}

function getKeyData($key)
{
    global $db;

    $key_sec = fix_string($key);

    $query = "SELECT * FROM `keys` WHERE `key` = '{$key_sec}'";

    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row != null) {
        return $row;
    }
    if ($row == null) {
        return false;
    }
}

function getActivatedKeysCount()
{
    global $db;


    $query = "SELECT count(*) FROM `keys` WHERE `status` = 'activated'";

    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_row($result);

    return $row[0];
}

function getKeysCount()
{
    global $db;


    $query = "SELECT count(*) FROM `keys`";

    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_row($result);

    return $row[0];
}
