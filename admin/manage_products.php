<?php
include('../config/db.php'); 
include('includes/header.php'); 

// Delete Product Logic
if(isset($_GET['del_id'])) {
    $id = (int)$_GET['del_id'];
    $img_res = mysqli_query($conn, "SELECT image FROM products WHERE id = $id");
    $img_data = mysqli_fetch_assoc($img_res);
    if($img_data) { @unlink("../assets/uploads/" . $img_data['image']); }
    
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    echo "<script>window.location='manage_products.php';</script>";
}
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2>📦 Product Management</h2>
    <a href="add_product.php" style="background: #008060; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">+ Add New Product</a>
</div>

<table>
    <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th style="text-align: center;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $q = "SELECT p.*, c.name as cat_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC";
        $res = mysqli_query($conn, $q);
        while($row = mysqli_fetch_assoc($res)) {
            ?>
            <tr>
                <td><img src="../assets/uploads/<?php echo $row['image']; ?>" width="50" height="50" style="object-fit:cover; border-radius: 4px; border: 1px solid #ddd;"></td>
                <td style="font-weight: 500;"><?php echo $row['name']; ?></td>
                <td style="color: #666;"><?php echo $row['cat_name'] ?? 'General'; ?></td>
                <td style="color: #008060; font-weight: bold;">Rs. <?php echo number_format($row['price']); ?></td>
                <td style="text-align: center;">
                    <!-- Edit Button -->
                    <a href="edit_product.php?id=<?php echo $row['id']; ?>" style="color: #008060; text-decoration: none; font-weight: bold; margin-right: 15px; border: 1px solid #008060; padding: 5px 10px; border-radius: 4px; font-size: 0.9rem;">✏️ Edit</a>
                    
                    <!-- Delete Button -->
                    <a href="manage_products.php?del_id=<?php echo $row['id']; ?>" style="color: #d82c0d; text-decoration: none; font-weight: bold; border: 1px solid #d82c0d; padding: 5px 10px; border-radius: 4px; font-size: 0.9rem;" onclick="return confirm('Are you sure you want to delete this product?')">❌ Delete</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

</div> <!-- main-content end closure from header.php -->
</body>
</html>