<?php
include('../config/db.php'); 
include('includes/header.php'); // Is mein auth_check aur sidebar pehle se hai

// Status Update karne ki logic (Agar aap order status change karna chahen)
if(isset($_GET['complete_id'])) {
    $id = (int)$_GET['complete_id'];
    mysqli_query($conn, "UPDATE orders SET status='delivered' WHERE id = $id");
    echo "<script>window.location='view_orders.php';</script>";
}
?>

<div style="padding: 20px;">
    <h1 style="color: #333;">🛒 Customer Orders</h1>
    <hr style="border:0; border-top:1px solid #eee; margin-bottom:25px;">

    <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8f9fa;">
                <tr>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #eee; color: #5c5f62;">Order ID</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #eee; color: #5c5f62;">Customer Name</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #eee; color: #5c5f62;">Total Amount</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #eee; color: #5c5f62;">Status</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #eee; color: #5c5f62;">Order Date</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #eee; color: #5c5f62;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Users table ke sath JOIN taaki customer ka naam nazar aaye
                $query = "SELECT orders.*, users.name as customer_name 
                          FROM orders 
                          LEFT JOIN users ON orders.user_id = users.id 
                          ORDER BY orders.id DESC";
                
                $res = mysqli_query($conn, $query);

                if(mysqli_num_rows($res) > 0) {
                    while($row = mysqli_fetch_assoc($res)) {
                        $status_color = ($row['status'] == 'pending') ? '#996600' : '#008060';
                        $status_bg = ($row['status'] == 'pending') ? '#ffebcc' : '#e3f1df';
                        ?>
                        <tr>
                            <td style="padding: 15px; border-bottom: 1px solid #eee; font-weight: bold;">#<?php echo $row['id']; ?></td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee;"><?php echo $row['customer_name'] ?? 'Guest'; ?></td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee; font-weight: bold; color: #008060;">Rs. <?php echo number_format($row['total']); ?></td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee;">
                                <span style="background: <?php echo $status_bg; ?>; color: <?php echo $status_color; ?>; padding: 5px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">
                                    <?php echo $row['status']; ?>
                                </span>
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee; color: #666;">
                                <?php echo date('d M Y, h:i A', strtotime($row['order_date'])); ?>
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee;">
                                <?php if($row['status'] == 'pending'): ?>
                                    <a href="view_orders.php?complete_id=<?php echo $row['id']; ?>" 
                                       style="background: #008060; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 0.85rem;"
                                       onclick="return confirm('Mark this order as delivered?')">Mark Delivered</a>
                                <?php else: ?>
                                    <span style="color: #888; font-size: 0.85rem;">Completed</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6' style='padding: 40px; text-align: center; color: #999;'>Abhi tak koi order nahi aaya.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</div> <!-- Main-content closing -->
</body>
</html>