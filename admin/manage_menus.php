<?php
include('../config/db.php');
include('includes/header.php');

// 1. Naya Button ADD karne ki logic (Dropdown ke saath)
if(isset($_POST['add_menu'])) {
    $name = mysqli_real_escape_string($conn, $_POST['new_name']);
    $link = mysqli_real_escape_string($conn, $_POST['new_link']);
    $order = (int)$_POST['menu_order'];
    
    mysqli_query($conn, "INSERT INTO navbar_menus (menu_name, menu_link, menu_order) VALUES ('$name', '$link', '$order')");
    echo "<script>alert('New Button Added!'); window.location='manage_menus.php';</script>";
}

// 2. Button DELETE karne ki logic
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM navbar_menus WHERE id=$id");
    echo "<script>alert('Button Deleted!'); window.location='manage_menus.php';</script>";
}

// 3. Purane Buttons UPDATE karne ki logic
if(isset($_POST['update_menu'])) {
    foreach($_POST['menus'] as $id => $data) {
        $name = mysqli_real_escape_string($conn, $data['name']);
        $link = mysqli_real_escape_string($conn, $data['link']);
        $order = (int)$data['order'];
        mysqli_query($conn, "UPDATE navbar_menus SET menu_name='$name', menu_link='$link', menu_order='$order' WHERE id=$id");
    }
    echo "<script>alert('Navbar Updated!'); window.location='manage_menus.php';</script>";
}
?>

<div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); font-family: sans-serif;">
    
    <h2 style="color: #2c3e50; border-bottom: 2px solid #f4f4f4; padding-bottom: 10px;">🔗 Manage Navbar Buttons</h2>

    <!-- SECTION 1: ADD NEW BUTTON FORM -->
    <fieldset style="border: 1px solid #ddd; padding: 20px; margin-bottom: 30px; border-radius: 8px; background: #fafafa;">
        <legend style="font-weight: bold; color: #008060; padding: 0 10px;">🚀 Add New Menu Button</legend>
        <form method="POST" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end;">
            
            <div style="flex: 1; min-width: 200px;">
                <label style="font-weight: 600; display: block; margin-bottom: 5px;">Button Name:</label>
                <input type="text" name="new_name" placeholder="e.g. Our Story" required style="padding: 10px; width: 100%; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <div style="flex: 1; min-width: 250px;">
                <label style="font-weight: 600; display: block; margin-bottom: 5px;">Link To Page:</label>
                <select name="new_link" required style="padding: 10px; width: 100%; border: 1px solid #ccc; border-radius: 4px;">
                    <option value="">-- Select Page --</option>
                    <optgroup label="Main Pages">
                        <option value="index.php">Home Page</option>
                        <option value="catalog.php">All Products</option>
                        <option value="about.php">About Us</option>
                        <option value="contact.php">Contact Us</option>
                    </optgroup>
                    <optgroup label="User Account">
                        <option value="login.php">Login</option>
                        <option value="register.php">Register</option>
                        <option value="cart.php">Cart</option>
                    </optgroup>
                </select>
            </div>

            <div style="width: 80px;">
                <label style="font-weight: 600; display: block; margin-bottom: 5px;">Order:</label>
                <input type="number" name="menu_order" value="0" style="padding: 10px; width: 100%; border: 1px solid #ccc; border-radius: 4px;">
            </div>

            <button type="submit" name="add_menu" style="background: #008060; color: white; border: none; padding: 11px 25px; cursor: pointer; border-radius: 4px; font-weight: bold;">+ Add</button>
        </form>
    </fieldset>

    <!-- SECTION 2: UPDATE / DELETE EXISTING BUTTONS -->
    <form method="POST">
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background: #f4f4f4; text-align: left;">
                    <th style="padding: 12px; border-bottom: 2px solid #ddd;">Name</th>
                    <th style="padding: 12px; border-bottom: 2px solid #ddd;">Link</th>
                    <th style="padding: 12px; border-bottom: 2px solid #ddd;">Order</th>
                    <th style="padding: 12px; border-bottom: 2px solid #ddd; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM navbar_menus ORDER BY menu_order ASC");
                if(mysqli_num_rows($res) > 0) {
                    while($row = mysqli_fetch_assoc($res)) {
                ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 10px;">
                        <input type="text" name="menus[<?php echo $row['id']; ?>][name]" value="<?php echo $row['menu_name']; ?>" style="width: 90%; padding: 8px; border: 1px solid #eee;">
                    </td>
                    <td style="padding: 10px;">
                        <input type="text" name="menus[<?php echo $row['id']; ?>][link]" value="<?php echo $row['menu_link']; ?>" style="width: 90%; padding: 8px; border: 1px solid #eee;">
                    </td>
                    <td style="padding: 10px;">
                        <input type="number" name="menus[<?php echo $row['id']; ?>][order]" value="<?php echo $row['menu_order']; ?>" style="width: 60px; padding: 8px; border: 1px solid #eee;">
                    </td>
                    <td style="padding: 10px; text-align: center;">
                        <a href="manage_menus.php?delete=<?php echo $row['id']; ?>" 
                           style="color: #e74c3c; text-decoration: none; font-weight: bold;" 
                           onclick="return confirm('Kya aap ye button delete karna chahte hain?')">❌ Delete</a>
                    </td>
                </tr>
                <?php 
                    } 
                } else {
                    echo "<tr><td colspan='4' style='padding: 20px; text-align: center; color: #999;'>No buttons found. Please add one!</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
        <div style="margin-top: 20px; display: flex; gap: 10px;">
            <button type="submit" name="update_menu" style="background: #2c3e50; color: white; padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold;">Save Changes</button>
            <a href="manage_menus.php" style="padding: 12px 25px; background: #eee; color: #333; text-decoration: none; border-radius: 5px; font-weight: bold;">Refresh List</a>
        </div>
    </form>
</div>