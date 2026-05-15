<?php
include('config/db.php');
include('includes/header.php');

// URL se ID uthayen (e.g. product_details.php?id=1)
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
    $product = mysqli_fetch_assoc($result);

    if(!$product) {
        die("<h2 style='text-align:center; padding:50px;'>Product not found!</h2>");
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<div style="max-width: 1100px; margin: 40px auto; padding: 20px; font-family: 'Inter', sans-serif;">
    <div style="display: flex; flex-wrap: wrap; gap: 40px; background: #fff; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05);">
        
        <!-- Left Section: Product Image -->
        <div style="flex: 1; min-width: 300px; text-align: center; background: #f9f9f9; border-radius: 10px; padding: 20px; display: flex; align-items: center; justify-content: center;">
            <img src="assets/uploads/<?php echo $product['image']; ?>" 
                 style="max-width: 100%; max-height: 400px; border-radius: 8px; object-fit: contain;" 
                 alt="<?php echo $product['name']; ?>">
        </div>

        <!-- Right Section: Product Info -->
        <div style="flex: 1; min-width: 300px;">
            <nav style="margin-bottom: 20px; font-size: 0.9rem; color: #888;">
                <a href="index.php" style="color: #888; text-decoration: none;">Home</a> / Product Details
            </nav>

            <h1 style="font-size: 2.5rem; color: #222; margin-bottom: 10px;"><?php echo $product['name']; ?></h1>
            
            <p style="font-size: 1.8rem; color: #008060; font-weight: bold; margin-bottom: 20px;">
                Rs. <?php echo number_format($product['price']); ?>/-
            </p>

            <div style="border-top: 1px solid #eee; border-bottom: 1px solid #eee; padding: 20px 0; margin-bottom: 25px;">
                <h4 style="margin-bottom: 10px; color: #555;">Description:</h4>
                <p style="line-height: 1.6; color: #666;">
                    <?php echo nl2br($product['description']); ?>
                </p>
            </div>

            <!-- Action Buttons -->
            <div style="display: flex; gap: 15px;">
                
                <!-- NEW FUNCTIONAL ADD TO CART BUTTON -->
                <a href="add_to_cart.php?id=<?php echo $product['id']; ?>" 
                   style="flex: 1; background: #222; color: white; padding: 15px; text-align: center; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s;">
                   ADD TO CART
                </a>
                
                <!-- WhatsApp Order Button -->
                <a href="https://wa.me/923XXXXXXXXX?text=I want to order: <?php echo $product['name']; ?>" 
                   target="_blank"
                   style="flex: 1; background: #25D366; color: white; padding: 15px; text-align: center; text-decoration: none; border-radius: 5px; font-weight: bold; transition: 0.3s;">
                    ORDER ON WHATSAPP
                </a>
            </div>

            <div style="margin-top: 30px; display: flex; align-items: center; gap: 10px; color: #444; font-size: 0.9rem;">
                <span style="font-size: 1.2rem;">🚚</span>
                <span>Fast delivery across Pakistan | Quality Guaranteed</span>
            </div>
        </div>

    </div>
</div>

<?php include('includes/footer.php'); ?>