<?php
// Host will most probably be localhost
$host = "51.158.118.84";
// Enter the port number
$port = "33060";
// Enter the username
$username = "vrongmeal";
// Enter the password for username
$password = "password";
// Enter the database name
$db_name = "falsepastebin";
$link = new mysqli($host, $username, $password, $db_name, $port);
if($link->connect_errno){
    die("ERROR: Could not connect. " . $link->connect_error);
}
?>
