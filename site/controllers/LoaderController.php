<?php
include_once 'utils.php';

function createNewLoader($name, $file)
{
    global $db;

    $name_sec = fix_string($name);
    $file_sec = fix_string($file);

    $query = "SELECT * FROM `loaders` WHERE `name` = '{$name_sec}'";
    $row = mysqli_fetch_assoc(mysqli_query($db, $query));

    if (empty($row)) {
        $query = "INSERT INTO `loaders` (`name`, `file`) VALUES ('{$name_sec}', '{$file_sec}')";
        mysqli_query($db, $query);
        return true;
    } else {
        return false;
    }
}

function getLoaderInfo($loader)
{
    global $db;

    $cheatid_sec = fix_string($loader);

    $query = "SELECT * FROM `loaders` WHERE `id` = '{$cheatid_sec}'";

    $result = mysqli_query($db, $query);
    $keyinfo = mysqli_fetch_assoc($result);

    return $keyinfo;
}

function getAllLoaders()
{
    global $db;

    $query = "SELECT * FROM `loaders` WHERE 1";

    $result = mysqli_query($db, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $array[] = $row;
    }
    return $array;
}

function setLoaderVersion($loaderid)
{
    global $db;


    $loaderInfo = getLoaderInfo($loaderid);

    $version = $loaderInfo['version'];
    $loaderVersion = $version + 1;

    $query = "UPDATE `loaders` SET `version` = '{$loaderVersion}' WHERE `id` = '{$loaderid}'";

    mysqli_query($db, $query);
    return;
}
