<?php
include('auth_check.php');
include('../config/db.php');

// Data Fetching for Stats
$total_products = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM products"));
$total_orders = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM orders"));
$total_categories = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM categories"));
$pending_orders = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM orders WHERE status='pending'"));

// Recent Orders Query
$recent_orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | My Store</title>
    <style>
        body { font-family: 'Inter', sans-serif; margin: 0; display: flex; background: #f4f6f8; color: #202223; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: #202223; color: white; height: 100vh; position: fixed; }
        .sidebar h2 { padding: 25px; text-align: center; border-bottom: 1px solid #333; margin: 0; font-size: 1.2rem; }
        .sidebar a { display: block; color: #b5b5b5; padding: 15px 25px; text-decoration: none; transition: 0.3s; }
        .sidebar a:hover, .sidebar a.active { background: #333; color: white; border-left: 4px solid #008060; }

        /* Main Content */
        .main { margin-left: 260px; padding: 40px; width: 100%; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        
        /* Stats Cards */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); border: 1px solid #e1e3e5; }
        .stat-card h3 { margin: 0; color: #6d7175; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-card p { margin: 10px 0 0; font-size: 2rem; font-weight: 700; color: #202223; }

        /* Table Style */
        .recent-box { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .recent-box h2 { margin-top: 0; font-size: 1.1rem; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 12px; background: #f8f9fa; color: #5c5f62; font-size: 0.85rem; }
        td { padding: 12px; border-bottom: 1px solid #f1f2f3; font-size: 0.9rem; }
        
        .status { padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: bold; }
        .status-pending { background: #ffebcc; color: #996600; }
        .status-delivered { background: #e3f1df; color: #008060; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="dashboard.php" class="active">📊 Dashboard</a>
    <a href="manage_products.php">📦 Products</a>
    <a href="manage_categories.php">📁 Categories</a>
    <a href="view_orders.php">🛒 Orders</a>
    <a href="../index.php" target="_blank" style="margin-top: 20px; border-top: 1px solid #333;">🌐 View Shop</a>
    <a href="../logout.php" style="color: #ff6b6b;">🚪 Logout</a>
</div>

<div class="main">
    <div class="header">
        <h1>Overview</h1>
        <p style="color: #6d7175;"><?php echo date('D, d M Y'); ?></p>
    </div>

    <!-- Stats Section -->
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Products</h3>
            <p><?php echo $total_products; ?></p>
        </div>
        <div class="stat-card">
            <h3>Categories</h3>
            <p><?php echo $total_categories; ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Orders</h3>
            <p><?php echo $total_orders; ?></p>
        </div>
        <div class="stat-card" style="border-left: 5px solid #ffbb00;">
            <h3>Pending Orders</h3>
            <p style="color: #b08d00;"><?php echo $pending_orders; ?></p>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="recent-box">
        <h2>Latest Orders</h2>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($recent_orders)): ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td>Rs. <?php echo number_format($row['total']); ?></td>
                    <td>
                        <span class="status status-<?php echo $row['status']; ?>">
                            <?php echo strtoupper($row['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('d M', strtotime($row['order_date'])); ?></td>
                    <td><a href="view_orders.php" style="color: #008060; text-decoration: none; font-weight: 600;">Details</a></td>
                </tr>
                <?php endwhile; ?>
                <?php if(mysqli_num_rows($recent_orders) == 0) echo "<tr><td colspan='5' style='text-align:center;'>No orders yet.</td></tr>"; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>