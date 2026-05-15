<?php
include('../config/db.php');
include('includes/header.php');

if(isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['pname']);
    $price = $_POST['price'];
    $cat_id = $_POST['cat_id'];
    $desc = mysqli_real_escape_string($conn, $_POST['desc']);
    
    $image = $_FILES['pimg']['name'];
    $tmp = $_FILES['pimg']['tmp_name'];
    move_uploaded_file($tmp, "../assets/uploads/".$image);

    $sql = "INSERT INTO products (name, price, category_id, description, image) VALUES ('$name', '$price', '$cat_id', '$desc', '$image')";
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Product Added!'); window.location='manage_products.php';</script>";
    }
}
?>

<h2>➕ Add New Product</h2>
<form method="POST" enctype="multipart/form-data" style="max-width: 500px; background: white; padding: 20px; border-radius: 8px;">
    <label>Product Name</label><br>
    <input type="text" name="pname" required style="width:100%; margin:10px 0; padding:8px;"><br>
    
    <label>Category</label><br>
    <select name="cat_id" required style="width:100%; margin:10px 0; padding:8px;">
        <?php
        $cats = mysqli_query($conn, "SELECT * FROM categories");
        while($c = mysqli_fetch_assoc($cats)) {
            echo "<option value='{$c['id']}'>{$c['name']}</option>";
        }
        ?>
    </select><br>

    <label>Price</label><br>
    <input type="number" name="price" required style="width:100%; margin:10px 0; padding:8px;"><br>

    <label>Description</label><br>
    <textarea name="desc" style="width:100%; margin:10px 0; padding:8px;"></textarea><br>

    <label>Product Image</label><br>
    <input type="file" name="pimg" required style="margin:10px 0;"><br><br>

    <button type="submit" name="add_product" style="width:100%; background:#008060; color:white; padding:10px; border:none; cursor:pointer;">Save Product</button>
</form>

</div> <!-- main-content end -->
</body>
</html>