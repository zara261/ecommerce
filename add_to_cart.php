<?php
session_start();
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Agar cart pehle se nahi bana to bana lo
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    
    // Product ID ko cart mein save karein
    if(!in_array($id, $_SESSION['cart'])) {
        array_push($_SESSION['cart'], $id);
    }
    
    header("Location: cart.php");
    exit();
}
?>