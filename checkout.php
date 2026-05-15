<?php
include('config/db.php');
include('includes/header.php');

// Agar cart khali hai to checkout nahi ho sakta
if(empty($_SESSION['cart'])) { header("Location: index.php"); exit(); }

if(isset($_POST['place_order'])) {
    // Agar user login nahi hai, to guest ya default user ID de sakte hain
    $user_id = $_SESSION['user_id'] ?? 1; 
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    
    // Calculate Total
    $total = 0;
    $ids = implode(',', $_SESSION['cart']);
    $res = mysqli_query($conn, "SELECT price FROM products WHERE id IN ($ids)");
    while($row = mysqli_fetch_assoc($res)) { $total += $row['price']; }

    // Save Order in Database
    $query = "INSERT INTO orders (user_id, total, status, address) VALUES ('$user_id', '$total', 'pending', '$address')";
    
    if(mysqli_query($conn, $query)) {
        unset($_SESSION['cart']); // Order ke baad cart khali kar dein
        echo "<script>alert('Order Placed Successfully!'); window.location='index.php';</script>";
    }
}
?>

<div style="max-width: 600px; margin: 40px auto; padding: 30px; background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
    <h2>Confirm Your Order</h2>
    <form method="POST">
        <label>Shipping Address:</label>
        <textarea name="address" rows="4" required style="width:100%; padding:10px; margin:10px 0; border:1px solid #ddd; border-radius:5px;" placeholder="House #, Street Name, City..."></textarea>
        
        <p style="font-size: 1.1rem; margin: 20px 0;">Payment Method: <strong>Cash on Delivery</strong></p>
        
        <button type="submit" name="place_order" style="width:100%; padding:15px; background:#008060; color:white; border:none; border-radius:5px; font-weight:bold; cursor:pointer;">
            PLACE ORDER NOW
        </button>
    </form>
</div>

<?php include('includes/footer.php'); ?>