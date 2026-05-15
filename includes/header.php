<?php 
// Session start taaki login user ka naam nazar aa sakay
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Aapke table name 'site_settings' ke mutabiq data nikalna
$settings_res = mysqli_query($conn, "SELECT * FROM site_settings LIMIT 1");
$set = mysqli_fetch_assoc($settings_res);
?>

<header style="background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 15px 5%; display: flex; justify-content: space-between; align-items: center; font-family: 'Segoe UI', sans-serif;">
    
    <!-- 1. LOGO SECTION -->
    <div class="logo">
        <a href="index.php" style="text-decoration: none; display: flex; align-items: center; gap: 10px;">
            <?php if(!empty($set['logo_file']) && file_exists('assets/uploads/' . $set['logo_file'])): ?>
                <img src="assets/uploads/<?php echo $set['logo_file']; ?>" alt="Logo" style="height: 45px;">
            <?php else: ?>
                <span style="color: #008060; font-size: 24px; font-weight: bold; letter-spacing: 1px;">
                    <?php echo isset($set['site_name']) ? $set['site_name'] : 'MY STORE'; ?>
                </span>
            <?php endif; ?>
        </a>
    </div>

    <!-- 2. DYNAMIC NAVIGATION -->
    <nav style="display: flex; gap: 30px;">
        <?php
        // Database se buttons uthana
        $menu_query = mysqli_query($conn, "SELECT * FROM navbar_menus ORDER BY menu_order ASC");
        
        if($menu_query) {
            while($menu = mysqli_fetch_assoc($menu_query)) {
                // Admin Panel aur Register ko yahan se filter kar rahe hain taaki nazar na ayein
                $m_name = strtolower($menu['menu_name']);
                if($m_name == 'admin panel' || $m_name == 'register') {
                    continue; 
                }
                echo '<a href="'.$menu['menu_link'].'" style="text-decoration: none; color: #333; font-weight: 500; font-size: 16px; transition: 0.3s;">'.$menu['menu_name'].'</a>';
            }
        }
        ?>
    </nav>

    <!-- 3. USER ACTIONS (Cart khatam, sirf User info aur Logout) -->
    <div class="user-actions" style="display: flex; align-items: center; gap: 15px;">
        <?php if(isset($_SESSION['user_name'])): ?>
            <span style="color: #666; font-size: 14px; background: #f0f2f5; padding: 6px 15px; border-radius: 20px; border: 1px solid #e0e0e0;">
                👤 <?php echo $_SESSION['user_name']; ?>
            </span>
            <a href="logout.php" style="text-decoration: none; color: #d32f2f; font-weight: bold; font-size: 14px; border-left: 1px solid #ddd; padding-left: 15px;">Logout</a>
        <?php endif; ?>
    </div>
</header>