<?php
include('config/db.php');
include('includes/header.php');

if(isset($_POST['register'])) {
    // Form se username hi le rahe hain, lekin SQL mein hum isay 'name' wale khane mein dalenge
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Password hashing
    $plain_password = $_POST['password'];
    $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

    // TABDEELI YAHAN HAI: Hum 'username' ki jagah 'name' column use kar rahe hain
    $query = "INSERT INTO users (name, email, pass) VALUES ('$username', '$email', '$hashed_password')";
    
    if(mysqli_query($conn, $query)) {
        echo "<script>
                alert('Account Created Successfully!');
                window.location='login.php';
              </script>";
    } else {
        echo "<div style='color:red; text-align:center; padding:10px;'><b>Error:</b> " . mysqli_error($conn) . "</div>";
    }
}
?>

<div style="max-width: 450px; margin: 60px auto; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); font-family: sans-serif;">
    <h2 style="text-align: center; color: #2c3e50; margin-bottom: 25px;">Create Your Account</h2>
    
    <form method="POST">
        <div style="margin-bottom: 15px;">
            <label style="display:block; font-weight:600; margin-bottom:5px;">Full Name</label>
            <input type="text" name="username" placeholder="Enter your full name" required 
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 15px;">
            <label style="display:block; font-weight:600; margin-bottom:5px;">Email Address</label>
            <input type="email" name="email" placeholder="example@mail.com" required 
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display:block; font-weight:600; margin-bottom:5px;">Password</label>
            <input type="password" name="password" placeholder="Create a strong password" required 
                   style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;">
        </div>

        <button type="submit" name="register" 
                style="width: 100%; background: #008060; color: white; border: none; padding: 14px; border-radius: 6px; cursor: pointer; font-size: 16px; font-weight: bold;">
            Sign Up
        </button>
    </form>

    <p style="text-align: center; margin-top: 20px; color: #666;">
        Already have an account? <a href="login.php" style="color: #008060; text-decoration: none; font-weight: 600;">Login here</a>
    </p>
</div>