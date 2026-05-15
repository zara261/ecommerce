<?php
include('config/db.php');
include('includes/header.php');
?>

<div style="max-width: 1000px; margin: 40px auto; padding: 20px;">
    <h2>🛒 Your Shopping Cart</h2>
    <hr>

    <?php if(!empty($_SESSION['cart'])): ?>
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: white; border-radius: 8px; overflow: hidden;">
            <tr style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                <th style="padding: 15px; text-align: left;">Product</th>
                <th style="padding: 15px; text-align: left;">Price</th>
                <th style="padding: 15px; text-align: left;">Action</th>
            </tr>
            <?php
            $total = 0;
            $ids = implode(',', $_SESSION['cart']);
            $query = "SELECT * FROM products WHERE id IN ($ids)";
            $res = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($res)):
                $total += $row['price'];
            ?>
            <tr style="border-bottom: 1px solid #eee;">
                <td style="padding: 15px; display: flex; align-items: center; gap: 15px;">
                    <img src="assets/uploads/<?php echo $row['image']; ?>" width="50">
                    <span><?php echo $row['name']; ?></span>
                </td>
                <td style="padding: 15px;">Rs. <?php echo number_format($row['price']); ?></td>
                <td style="padding: 15px;">
                    <a href="remove_item.php?id=<?php echo $row['id']; ?>" style="color: red; text-decoration: none;">Remove</a>
                </td>
            </tr>
            <?php endwhile; ?>
            <tr style="font-size: 1.2rem; font-weight: bold; background: #f9f9f9;">
                <td style="padding: 15px; text-align: right;">Total:</td>
                <td colspan="2" style="padding: 15px; color: #008060;">Rs. <?php echo number_format($total); ?></td>
            </tr>
        </table>

        <div style="margin-top: 30px; text-align: right;">
            <a href="index.php" style="padding: 12px 25px; background: #eee; text-decoration: none; border-radius: 5px; color: #333; margin-right: 10px;">Continue Shopping</a>
            <a href="checkout.php" style="padding: 12px 35px; background: #008060; text-decoration: none; border-radius: 5px; color: white; font-weight: bold;">Proceed to Checkout →</a>
        </div>

    <?php else: ?>
        <div style="text-align: center; padding: 50px;">
            <h3 style="color: #888;">Your cart is empty!</h3>
            <a href="index.php" style="color: #008060;">Go shopping now</a>
        </div>
    <?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>