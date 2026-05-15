<?php
session_start();
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $key = array_search($id, $_SESSION['cart']);
    if($key !== false) {
        unset($_SESSION['cart'][$key]);
    }
    // Array ko re-index karein
    $_SESSION['cart'] = array_values($_SESSION['cart']);
}
header("Location: cart.php");
?>