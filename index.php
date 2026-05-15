<?php 
include('config/db.php'); 
include('includes/header.php'); 
include('includes/functions.php'); // Price format ke liye

// Search Logic (Purani functionality)
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
?>

<!-- 1. HERO SECTION (New Feature) -->
<div style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'); background-size: cover; background-position: center; height: 450px; display: flex; flex-direction: column; justify-content: center; align-items: center; color: white; text-align: center; margin-bottom: 40px;">
    <h1 style="font-size: 3.5rem; margin-bottom: 10px; font-weight: bold; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Premium Tech Store</h1>
    <p style="font-size: 1.3rem; margin-bottom: 25px; max-width: 600px;">Discover the latest gadgets, from high-end laptops to flagship smartphones at best prices.</p>
    <a href="catalog.php" style="background: #008060; color: white; padding: 15px 40px; text-decoration: none; border-radius: 30px; font-weight: bold; font-size: 1.1rem; transition: 0.3s; box-shadow: 0 4px 15px rgba(0,128,96,0.3);">Explore Catalog</a>
</div>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">

    <!-- 2. SERVICE HIGHLIGHTS (New Feature) -->
    <div style="display: flex; justify-content: space-between; gap: 20px; margin-bottom: 60px; flex-wrap: wrap; text-align: center;">
        <div style="flex: 1; min-width: 250px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <div style="font-size: 40px; margin-bottom: 10px;">🚚</div>
            <h4 style="margin: 10px 0;">Free Shipping</h4>
            <p style="color: #666; font-size: 0.9rem;">On all orders over Rs. 50,000</p>
        </div>
        <div style="flex: 1; min-width: 250px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <div style="font-size: 40px; margin-bottom: 10px;">🛡️</div>
            <h4 style="margin: 10px 0;">Secure Payment</h4>
            <p style="color: #666; font-size: 0.9rem;">100% protected payments</p>
        </div>
        <div style="flex: 1; min-width: 250px; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <div style="font-size: 40px; margin-bottom: 10px;">🔄</div>
            <h4 style="margin: 10px 0;">Easy Returns</h4>
            <p style="color: #666; font-size: 0.9rem;">7-day money back guarantee</p>
        </div>
    </div>

    <!-- 3. SEARCH & SECTION TITLE -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid #008060; padding-bottom: 10px;">
        <h2 style="margin: 0; color: #333;">Featured Products</h2>
        
        <form action="index.php" method="GET" style="display: flex; gap: 5px;">
            <input type="text" name="search" placeholder="Search products..." value="<?php echo $search; ?>" style="padding: 8px 15px; border: 1px solid #ddd; border-radius: 20px; outline: none; width: 250px;">
            <button type="submit" style="background: #008060; color: white; border: none; padding: 8px 20px; border-radius: 20px; cursor: pointer;">Search</button>
        </form>
    </div>

    <!-- 4. PRODUCT GRID -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 30px; margin-bottom: 50px;">
        <?php
        // Query (Purani logic with Search support)
        $query = "SELECT * FROM products WHERE name LIKE '%$search%' ORDER BY id DESC LIMIT 8";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.08); transition: transform 0.3s;">
                    <img src="assets/uploads/<?php echo $row['image']; ?>" style="width: 100%; height: 200px; object-fit: cover;">
                    <div style="padding: 20px;">
                        <h3 style="margin: 0 0 10px 0; font-size: 1.2rem; color: #333;"><?php echo $row['name']; ?></h3>
                        <p style="color: #666; font-size: 0.9rem; height: 40px; overflow: hidden; margin-bottom: 15px;">
                            <?php echo substr($row['description'], 0, 60); ?>...
                        </p>
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 1.1rem; font-weight: bold; color: #008060;"><?php echo formatPrice($row['price']); ?></span>
                            <a href="product_details.php?id=<?php echo $row['id']; ?>" style="background: #2c3e50; color: white; padding: 7px 15px; text-decoration: none; border-radius: 5px; font-size: 0.8rem;">View Details</a>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p style='grid-column: 1/-1; text-align: center; padding: 50px; color: #999;'>No products found matching your search.</p>";
        }
        ?>
    </div>

    <!-- 5. CALL TO ACTION -->
    <div style="background: #f4f7f6; padding: 40px; border-radius: 15px; text-align: center; margin-bottom: 60px;">
        <h3>Want to see more?</h3>
        <p>Check out our full collection of gadgets and accessories.</p>
        <a href="catalog.php" style="color: #008060; font-weight: bold; text-decoration: none; border-bottom: 2px solid #008060;">View Full Catalog &rarr;</a>
    </div>

</div> <!-- Container End -->

<?php include('includes/footer.php'); ?>