<?php
include('../config/db.php'); 
include('includes/header.php'); 

// Add Logic
if(isset($_POST['add_cat'])) {
    $name = mysqli_real_escape_string($conn, $_POST['cat_name']);
    mysqli_query($conn, "INSERT INTO categories (name, status) VALUES ('$name', 'active')");
    echo "<script>window.location='manage_categories.php';</script>";
}

// Delete Logic
if(isset($_GET['del_id'])) {
    $id = (int)$_GET['del_id'];
    mysqli_query($conn, "DELETE FROM categories WHERE id = $id");
    echo "<script>window.location='manage_categories.php';</script>";
}
?>

<div style="padding: 20px;">
    <h1 style="color: #333;">📁 Categories Management</h1>
    <hr style="border:0; border-top:1px solid #eee; margin-bottom:25px;">

    <!-- Add Category Form -->
    <div style="background: white; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; align-items: center; gap: 15px;">
        <form method="POST" style="display: flex; gap: 10px; width: 100%;">
            <input type="text" name="cat_name" placeholder="New Category Name (e.g. Laptops)" required 
                   style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 6px; max-width: 400px;">
            <button type="submit" name="add_cat" 
                    style="background: #008060; color: white; border: none; padding: 12px 25px; border-radius: 6px; cursor: pointer; font-weight: bold;">
                    + Add Category
            </button>
        </form>
    </div>

    <!-- Categories List Table -->
    <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8f9fa;">
                <tr>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #eee;">ID</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #eee;">Category Name</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #eee;">Status</th>
                    <th style="padding: 15px; text-align: left; border-bottom: 1px solid #eee;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM categories ORDER BY id DESC");
                if(mysqli_num_rows($res) > 0) {
                    while($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td style="padding: 15px; border-bottom: 1px solid #eee;">#<?php echo $row['id']; ?></td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee; font-weight: 500;"><?php echo $row['name']; ?></td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee;">
                                <span style="background: #e3f1df; color: #008060; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: bold;">
                                    <?php echo strtoupper($row['status']); ?>
                                </span>
                            </td>
                            <td style="padding: 15px; border-bottom: 1px solid #eee;">
                                <a href="manage_categories.php?del_id=<?php echo $row['id']; ?>" 
                                   style="color: #d82c0d; text-decoration: none; font-weight: bold;"
                                   onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='4' style='padding: 30px; text-align: center; color: #888;'>No categories found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</div> <!-- main-content closure -->
</body>
</html>