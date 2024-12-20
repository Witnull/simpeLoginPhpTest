<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = ""; // Replace with your MySQL password
$dbname = "lamp_users";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit();
}
?>
