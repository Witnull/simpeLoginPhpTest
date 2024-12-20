<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "simplelogin";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to prevent character encoding attacks
$conn->set_charset("utf8mb4");
?>
