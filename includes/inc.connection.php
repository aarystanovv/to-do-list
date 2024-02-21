<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "todolistdb";

if (!$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
    die("Connection failed".mysqli_connect_error());
}