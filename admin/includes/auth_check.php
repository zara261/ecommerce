<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check karein ke admin session active hai ya nahi
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // Agar login nahi hai to admin folder se bahar nikal kar login.php par bhej do
    header("Location: ../login.php");
    exit();
}
?>