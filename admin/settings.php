<?php
include('../config/db.php');
include('includes/header.php');

// Database se purana data nikalna
$res = mysqli_query($conn, "SELECT * FROM site_settings WHERE id = 1");
$settings = mysqli_fetch_assoc($res);

if(isset($_POST['update_settings'])) {
    $name = mysqli_real_escape_string($conn, $_POST['site_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $loc = mysqli_real_escape_string($conn, $_POST['location']);
    $about = mysqli_real_escape_string($conn, $_POST['about']);
    $footer = mysqli_real_escape_string($conn, $_POST['footer']);

    // Logo Upload Logic
    if(!empty($_FILES['logo_img']['name'])) {
        $logo_name = time() . "_" . $_FILES['logo_img']['name'];
        $target = "../assets/uploads/" . $logo_name;
        
        if(move_uploaded_file($_FILES['logo_img']['tmp_name'], $target)) {
            mysqli_query($conn, "UPDATE site_settings SET logo_file='$logo_name' WHERE id=1");
        }
    }

    // Baqi settings update karein
    $sql = "UPDATE site_settings SET 
            site_name='$name', contact_email='$email', contact_phone='$phone', 
            location='$loc', about_text='$about', footer_text='$footer' 
            WHERE id=1";

    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Settings Updated Successfully!'); window.location='settings.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<div style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h2 style="color: #333; border-bottom: 2px solid #008060; padding-bottom: 10px;">⚙️ Website Configuration</h2>
    
    <!-- Form mein enctype add karna lazmi hai image upload ke liye -->
    <form method="POST" enctype="multipart/form-data" style="margin-top: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div>
                <label>Website Name / Logo Text</label>
                <input type="text" name="site_name" value="<?php echo $settings['site_name']; ?>" style="width:100%; padding:10px; margin-top:5px; border:1px solid #ddd; border-radius:5px;">
            </div>
            
            <div>
                <label>Update Logo Image</label>
                <input type="file" name="logo_img" style="width:100%; padding:7px; margin-top:5px; border:1px solid #ddd; border-radius:5px;">
                <p style="font-size: 11px; color: #666;">Current: <?php echo $settings['logo_file']; ?></p>
            </div>

            <div>
                <label>Contact Email</label>
                <input type="email" name="email" value="<?php echo $settings['contact_email']; ?>" style="width:100%; padding:10px; margin-top:5px; border:1px solid #ddd; border-radius:5px;">
            </div>

            <div>
                <label>Contact Phone</label>
                <input type="text" name="phone" value="<?php echo $settings['contact_phone']; ?>" style="width:100%; padding:10px; margin-top:5px; border:1px solid #ddd; border-radius:5px;">
            </div>
        </div>

        <div style="margin-top: 20px;">
            <label>Location</label>
            <input type="text" name="location" value="<?php echo $settings['location']; ?>" style="width:100%; padding:10px; margin-top:5px; border:1px solid #ddd; border-radius:5px;">
        </div>

        <div style="margin-top: 20px;">
            <label>About Us Page Content</label>
            <textarea name="about" style="width:100%; padding:10px; height:100px; margin-top:5px; border:1px solid #ddd; border-radius:5px;"><?php echo $settings['about_text']; ?></textarea>
        </div>

        <div style="margin-top: 20px;">
            <label>Footer Copyright Text</label>
            <input type="text" name="footer" value="<?php echo $settings['footer_text']; ?>" style="width:100%; padding:10px; margin-top:5px; border:1px solid #ddd; border-radius:5px;">
        </div>

        <button type="submit" name="update_settings" style="margin-top: 25px; background: #008060; color: white; border: none; padding: 12px 30px; border-radius: 5px; cursor: pointer; font-weight: bold;">Update All Settings</button>
    </form>
</div>

</div> <!-- Main Content End -->
</body>
</html>