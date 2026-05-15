<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "shop_project";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Global function settings fetch krny k liye
function getSetting($conn, $key) {
    $sql = "SELECT setting_value FROM site_settings WHERE setting_name = '$key'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['setting_value'] ?? 'Default Value';
}
?>