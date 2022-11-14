<?php
include_once 'utils.php';

function login($username, $password)
{
   global $db;

   $login = fix_string($username);
   $pass = fix_string($password);

   $query = "SELECT * FROM `users` WHERE `username` = '{$login}' and `password` = '{$pass}' LIMIT 1";

   $result = mysqli_query($db, $query);
   $row = mysqli_fetch_assoc($result);

   if ($row != null) {
      return true;
   }
   if ($row == null) {
      return false;
   }
}

function register($username, $password, $role, $owner)
{
   global $db;

   $login = fix_string($username);
   $pass = fix_string($password);
   $role_sec = fix_string($role);
   $owner_sec = fix_string($owner);

   $query = "SELECT * FROM `users` WHERE `username`='{$login}'";
   $row = mysqli_fetch_assoc(mysqli_query($db, $query));

   if (empty($row)) {
      $query = "INSERT INTO `users` (`username`, `password`, `role`, `owner`) VALUES ('{$login}', '{$pass}', '{$role_sec}', '{$owner_sec}')";
      mysqli_query($db, $query);
      return true;
   } else {
      return false;
   }
}

function getUserInfo($username)
{
   global $db;

   $login = fix_string($username);

   $query = "SELECT * FROM `users` WHERE `username` = '{$login}'";
   $result = mysqli_query($db, $query);
   $userinfo = mysqli_fetch_assoc($result);

   return $userinfo;
}

function deleteUser($username)
{
   global $db;

   $login = fix_string($username);

   $query = "DELETE FROM `users` WHERE `username` = '{$login}' LIMIT 1";
   mysqli_query($db, $query);
}

function getAllUsers()
{
   global $db;

   $query = "SELECT * FROM `users` WHERE 1";

   $result = mysqli_query($db, $query);

   while ($row = mysqli_fetch_assoc($result)) {
      $array[] = $row;
   }
   return $array;
}
