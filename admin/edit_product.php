<?php
include('../config/db.php');
include('includes/header.php');

$id = $_GET['id'];
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id = $id"));

if(isset($_POST['update_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['pname']);
    $price = $_POST['price'];
    $cat_id = $_POST['cat_id'];
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    
    // Agar nayi image upload ki jaye
    if($_FILES['pimg']['name'] != "") {
        $image = $_FILES['pimg']['name'];
        move_uploaded_file($_FILES['pimg']['tmp_name'], "../assets/uploads/".$image);
    } else {
        $image = $product['image']; // Purani image hi rehne dein
    }

    $sql = "UPDATE products SET name='$name', price='$price', category_id='$cat_id', description='$desc', image='$image' WHERE id=$id";
    
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Product Updated!'); window.location='manage_products.php';</script>";
    }
}
?>

<div style="max-width: 600px; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h2>✏️ Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Product Name</label>
        <input type="text" name="pname" value="<?php echo $product['name']; ?>" required style="width:100%; padding:10px; margin:10px 0;">

        <label>Category</label>
        <select name="cat_id" required style="width:100%; padding:10px; margin:10px 0;">
            <?php
            $cats = mysqli_query($conn, "SELECT * FROM categories");
            while($c = mysqli_fetch_assoc($cats)) {
                $selected = ($c['id'] == $product['category_id']) ? "selected" : "";
                echo "<option value='{$c['id']}' $selected>{$c['name']}</option>";
            }
            ?>
        </select>

        <label>Price</label>
        <input type="number" name="price" value="<?php echo $product['price']; ?>" required style="width:100%; padding:10px; margin:10px 0;">

        <label>Description</label>
        <textarea name="desc" style="width:100%; padding:10px; margin:10px 0; height:100px;"><?php echo $product['description']; ?></textarea>

        <label>Current Image:</label><br>
        <img src="../assets/uploads/<?php echo $product['image']; ?>" width="100" style="margin-bottom:10px;"><br>
        <input type="file" name="pimg">
        
        <button type="submit" name="update_product" style="width:100%; background:#008060; color:white; padding:12px; border:none; margin-top:20px; border-radius:5px; cursor:pointer; font-weight:bold;">Update Product</button>
    </form>
</div>