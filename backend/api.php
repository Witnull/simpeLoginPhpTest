<?php
session_start();
require 'db_config.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'login') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (!empty($username) && !empty($password)) {
            $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($user_id, $hashed_password);
            if ($stmt->fetch() && password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                echo json_encode(["status" => "success", "message" => "Login successful."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Invalid credentials."]);
            }
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid input."]);
        }
    } elseif ($action === 'register') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (!empty($username) && !empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed_password);
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Registration successful."]);
            } else {
                echo json_encode(["status" => "error", "message" => "User already exists."]);
            }
            $stmt->close();
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid input."]);
        }
    } elseif ($action === 'logout') {
        session_destroy();
        echo json_encode(["status" => "success", "message" => "Logged out."]);
    } elseif ($action === 'check_session') {
        if (isset($_SESSION['user_id'])) {
            echo json_encode(["status" => "success", "message" => "Session active."]);
        } else {
            echo json_encode(["status" => "error", "message" => "No active session."]);
        }
    }
}
$conn->close();
?>
