<?php


session_start();

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'blood_donor_system';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

function clean($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($conn, $data);
    return $data;
}

function isLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit();
    }
}

function showSuccess($message) {
    return '<div class="message success">' . $message . '</div>';
}

function showError($message) {
    return '<div class="message error">' . $message . '</div>';
}
?>