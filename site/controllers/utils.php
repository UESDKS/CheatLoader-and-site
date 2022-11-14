<?php

function fix_string($string)
{
    global $db;

    $string = htmlspecialchars(mysqli_escape_string($db, $string));

    return $string;
}
