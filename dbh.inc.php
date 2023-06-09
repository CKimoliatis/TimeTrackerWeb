<?php

$serverName = "localhost";
$dbUsername = "root";
$dbPssword = "";
$dbName = "timetracker";

$conn = mysqli_connect($serverName, $dbUsername, $dbPssword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}