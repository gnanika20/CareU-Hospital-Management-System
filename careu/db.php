<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "careu_db";
#new is used to create an object
#mysqli is is a built-in PHP class used to work with MySQL databases
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

?>