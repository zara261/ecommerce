<?php
include('../config/db.php'); 
include('includes/header.php'); // Is mein pehle se auth_check aur sidebar mojood hai

// Stats nikalne ke liye queries
$product_count = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM products"));
$category_count = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM categories"));
$order_count = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM orders"));
$pending_orders = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM orders WHERE status='pending'"));
?>

<div style="padding: 20px;">
    <h1 style="margin-bottom: 30px; color: #333;">📊 Dashboard Overview</h1>

    <!-- Stats Cards Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 40px;">
        
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #008060;">
            <h3 style="margin: 0; color: #666; font-size: 0.9rem;">TOTAL PRODUCTS</h3>
            <p style="font-size: 2rem; font-weight: bold; margin: 10px 0 0; color: #222;"><?php echo $product_count; ?></p>
        </div>

        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #2196F3;">
            <h3 style="margin: 0; color: #666; font-size: 0.9rem;">CATEGORIES</h3>
            <p style="font-size: 2rem; font-weight: bold; margin: 10px 0 0; color: #222;"><?php echo $category_count; ?></p>
        </div>

        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #FF9800;">
            <h3 style="margin: 0; color: #666; font-size: 0.9rem;">TOTAL ORDERS</h3>
            <p style="font-size: 2rem; font-weight: bold; margin: 10px 0 0; color: #222;"><?php echo $order_count; ?></p>
        </div>

        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border-top: 4px solid #f44336;">
            <h3 style="margin: 0; color: #666; font-size: 0.9rem;">PENDING ORDERS</h3>
            <p style="font-size: 2rem; font-weight: bold; margin: 10px 0 0; color: #f44336;"><?php echo $pending_orders; ?></p>
        </div>

    </div>

    <!-- Quick Actions -->
    <div style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 style="margin-top: 0; font-size: 1.2rem; color: #333;">🚀 Quick Actions</h2>
        <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="add_product.php" style="background: #008060; color: white; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: 600;">+ Add New Product</a>
            <a href="manage_categories.php" style="background: #222; color: white; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: 600;">📁 Manage Categories</a>
            <a href="view_orders.php" style="background: #eee; color: #333; padding: 12px 25px; text-decoration: none; border-radius: 6px; font-weight: 600;">🛒 View Orders</a>
        </div>
    </div>

</div>

<!-- Footer close tags (jo header mein open reh gaye thay) -->
</div> 
</body>
</html>