<?php
// Host will most probably be localhost
$host = "localhost";
// Enter the username
$username = "";
// Enter the password for username
$password = "";
// Enter the database name
$db_name = "pastebin_clone";
$link = new mysqli($host, $username, $password, $db_name);
if($link->connect_errno){
    die("ERROR: Could not connect. " . $link->connect_error);
}
?>
