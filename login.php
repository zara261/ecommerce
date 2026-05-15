<?php
include('config/db.php'); 

if(isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['user']);
    $password = $_POST['pass']; 

    $query = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        $db_password = $user_data['pass'];

        // Check 1: Agar password Hash hai (jo $ se shuru hota hai)
        if (strpos($db_password, '$2y$') === 0) {
            $is_valid = password_verify($password, $db_password);
        } 
        // Check 2: Agar password purana/plain text hai
        else {
            $is_valid = ($password === $db_password);
        }

        if($is_valid) {
            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['user_name'] = $user_data['name'];
            $_SESSION['user_role'] = $user_data['role'];

            if($user_data['role'] == 'admin') {
                $_SESSION['admin_logged_in'] = true;
                header("Location: admin/index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            $error = "Password ghalat hai!";
        }
    } else {
        $error = "Account nahi mila! Email check karein.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | My Store</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.1); width: 100%; max-width: 380px; text-align: center; }
        input { width: 100%; padding: 14px; margin-bottom: 15px; border: 1px solid #dddfe2; border-radius: 6px; box-sizing: border-box; }
        button { width: 100%; padding: 14px; background: #008060; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .reg-link { display: block; margin-bottom: 20px; padding: 10px; background: #e6f3f0; color: #008060; text-decoration: none; border-radius: 6px; font-weight: 600; }
    </style>
</head>
<body>

<div class="login-card">
    <!-- Register Option (Login ke andar sabse upar) -->
    <a href="register.php" class="reg-link">New User? Create Account Here</a>

    <h2>Login</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    
    <form method="POST">
        <input type="email" name="user" placeholder="Email Address" required>
        <input type="password" name="pass" placeholder="Password" required>
        <button name="login" type="submit">Login</button>
    </form>
    
    <a href="index.php" style="display:block; margin-top:20px; color:#666; text-decoration:none;">← Back to Shop</a>
</div>

</body>
</html>