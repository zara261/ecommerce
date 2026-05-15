<?php
include('config/db.php');
include('includes/header.php');
include('includes/functions.php');

$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$cat_filter = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : '';

$query = "SELECT * FROM products WHERE 1=1";

if ($search != '') {
    $query .= " AND name LIKE '%$search%'";
}

// Check karein ke column exist karta hai ya nahi (safety check)
if ($cat_filter != '') {
    $query .= " AND category_id = '$cat_filter'";
}

$query .= " ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<div style="max-width: 1200px; margin: 20px auto; padding: 0 20px;">
    
    <!-- SEARCH BAR -->
    <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-bottom: 30px;">
        <form action="index.php" method="GET" style="display: flex; gap: 10px;">
            <input type="text" name="search" placeholder="Search products..." value="<?php echo $search; ?>" style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 5px;">
            <button type="submit" style="background: #008060; color: white; border: none; padding: 0 25px; border-radius: 5px; cursor: pointer; font-weight: bold;">Search</button>
        </form>
    </div>

    <!-- CATEGORY FILTER -->
    <div style="margin-bottom: 30px; display: flex; gap: 10px; flex-wrap: wrap;">
        <span style="font-weight: bold;">Categories:</span>
        <a href="index.php" style="text-decoration:none; color:<?php echo ($cat_filter=='')?'#008060':'#666'; ?>;">All</a>
        <?php
        $cats = mysqli_query($conn, "SELECT * FROM categories");
        while($cat = mysqli_fetch_assoc($cats)) {
            $color = ($cat_filter == $cat['id']) ? '#008060' : '#666';
            echo " | <a href='index.php?cat={$cat['id']}' style='text-decoration:none; color:$color; font-weight:bold;'>{$cat['name']}</a>";
        }
        ?>
    </div>

    <!-- PRODUCT GRID -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 25px;">
        <?php
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid #f0f0f0;">
                    <img src="assets/uploads/<?php echo $row['image']; ?>" style="width: 100%; height: 200px; object-fit: contain; padding: 10px;">
                    <div style="padding: 15px;">
                        <h3 style="margin: 0; font-size: 1.1rem; height: 45px; overflow: hidden;"><?php echo $row['name']; ?></h3>
                        <p style="color: #008060; font-weight: bold; font-size: 1.2rem; margin: 10px 0;">Rs. <?php echo number_format($row['price']); ?></p>
                        
                        <a href="product_details.php?id=<?php echo $row['id']; ?>" style="display: block; text-align: center; background: #f4f4f4; color: #333; padding: 8px; text-decoration: none; border-radius: 5px; margin-bottom: 5px;">View Details</a>
                        
                        <a href="add_to_cart.php?id=<?php echo $row['id']; ?>" style="display: block; text-align: center; background: #008060; color: white; padding: 8px; text-decoration: none; border-radius: 5px; font-weight: bold;">🛒 Add to Cart</a>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<h2>No products found.</h2>";
        }
        ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>