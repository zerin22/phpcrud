<?php
$hostname = "localhost";
$username = "root";
$password = "";
$db       = "phpcrud";

$conn = new mysqli($hostname, $username, $password, $db);

//cheking connection
if($conn->connect_error){
    die("Connection failed: " .$conn->connect_error);
}