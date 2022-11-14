<?php
include_once 'utils.php';

function setKeyHwid($key, $hwid)
{
    global $db;

    $key_sec = fix_string($key);
    $hwid_sec = fix_string($hwid);

    $query = "UPDATE `keys` SET `hwid` = '{$hwid_sec}' WHERE `key` = '{$key_sec}' LIMIT 1";
    mysqli_query($db, $query);
}

function setKeyEnd($key, $endtime)
{
    global $db;

    $key_sec = fix_string($key);
    $endtime_sec = fix_string($endtime);

    $query = "UPDATE `keys` SET `subscribeend` = '{$endtime_sec}', `status` = 'activated' WHERE `key` = '{$key_sec}' LIMIT 1";
    mysqli_query($db, $query);
}

function expireKey($key)
{
    global $db;

    $key_sec = fix_string($key);

    $query = "UPDATE `keys` SET `status` = 'ended' WHERE `key` = '{$key_sec}' LIMIT 1";
    mysqli_query($db, $query);
}

function setFirstIp($key)
{
    global $db;

    $key_sec = fix_string($key);
    $ip = $_SERVER['REMOTE_ADDR'];

    $query = "UPDATE `keys` SET `firstip` = '{$ip}' WHERE `key` = '{$key_sec}' LIMIT 1";
    mysqli_query($db, $query);
}

function setLastIp($key)
{
    global $db;

    $key_sec = fix_string($key);
    $ip = $_SERVER['REMOTE_ADDR'];

    $query = "UPDATE `keys` SET `lastip` = '{$ip}' WHERE `key` = '{$key_sec}' LIMIT 1";
    mysqli_query($db, $query);
}

function makeToken($key, $hwid)
{
    $utc_time = gmdate("d/m Hi");
    $time = "date(" . $utc_time . ")";

    $token_buffer = $key . $hwid . $time;
    $token_md5 = md5($token_buffer);
    $token_base64 = base64_encode($token_md5);
    return $token_base64;
}

function encryptRequest($input)
{
    $key = 'c5IcvhwIPeTsiNboVnw3i6rUN73JpFjj';
    $inputLen = strlen($input);
    $keyLen = strlen($key);

    if ($inputLen <= $keyLen) {
        return $input ^ $key;
    }

    for ($i = 0; $i < $inputLen; ++$i) {
        $input[$i] = $input[$i] ^ $key[$i % $keyLen];
    }
    return $input;
}
