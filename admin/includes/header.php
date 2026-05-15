<?php
include('auth_check.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <style>
        body { margin: 0; font-family: 'Segoe UI', sans-serif; background: #f4f7f6; }
        .main-content { margin-left: 250px; padding: 30px; min-height: 100vh; }
        table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px 15px; border-bottom: 1px solid #eee; text-align: left; }
        th { background: #f8f9fa; color: #333; }
    </style>
</head>
<body>

<?php include('sidebar.php'); ?>

<div class="main-content">