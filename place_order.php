<?php
include('config/db.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    // Total calculation
    $total = 0;
    if(!empty($_SESSION['cart'])) {
        $ids = implode(',', $_SESSION['cart']);
        $res = mysqli_query($conn, "SELECT SUM(price) as total_price FROM products WHERE id IN ($ids)");
        $row = mysqli_fetch_assoc($res);
        $total = $row['total_price'];
    }

    // Aapke table ke mutabiq Query (user_id ko abhi NULL ya 0 rakh rahe hain agar login system user side pe nahi hai)
    $query = "INSERT INTO orders (user_id, total, status) VALUES (NULL, '$total', 'pending')";
    
    if(mysqli_query($conn, $query)) {
        // Order details (Name/Address) save karne ke liye aapko shayad aik 'order_items' table ki zaroorat paregi 
        // Lekin abhi ke liye hum order confirm kar rahe hain
        unset($_SESSION['cart']);
        echo "<div style='text-align:center; padding:50px;'>
                <h1>Order Placed!</h1>
                <p>Thank you for shopping with us.</p>
                <a href='index.php'>Return to Home</a>
              </div>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>