<?php
session_start();

$adminUsername = "ADMIN";
$adminPassword = "123ADMIN";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredUsername = $_POST['UserName'];
    $enteredPassword = $_POST['PASSWORD'];

    if ($enteredUsername === $adminUsername && $enteredPassword === $adminPassword) {
        $_SESSION['Aloggedin'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Access denied! Incorrect username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <style>
      body {
    background: url(images/back2.png);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;

    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
  }
 
.main {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
}
 

        .navbar {
            background-color: #21abcd;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
        }
        .navbar .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
        }
         
        .login-box {
            background-color: #e0f4ff;
            padding: 30px;
            width: 320px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-box input,
        .login-box select {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-box button {
            width: 100%;
            background-color: #120a8f;
            color: white;
            padding: 10px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            border-radius: 5px;
        }
        .login-box button:hover {
            background-color: #4b0082;
        }
        .right-image {
            margin-left: 50px;
        }
         
        .error {
            color: red;
            font-size: 13px;
        }
          
    </style>
</head>
<body>
<header style="background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Left Logo" style="height: 80px; width: 80px;">
    </div>

    <h1 style="margin: 0; font-size: 24px;">Admin Login Page</h1>

    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
    </div>
</header>
 <div class="navbar">
    <div style="padding-left: 0; margin: 0;"><strong style="margin-left: 10px;">Admin Login Page</strong></div>
    <div class="menu" style=",argin-right: 0;">
        <button style="display: inline-block; background-color: #4682b4; color: white; padding: 10px 20px; border: none; border-radius: 0;"><a href="home.php">Home</a></button>
    </div>
</div>


<div class="main">
    <div class="login-box">
        <h2>Log In</h2>
        <form method="post">
            <input type="text" name="UserName" placeholder="User Name" required>
            <input type="text" name="PASSWORD" placeholder="PASSWORD" required>
            <button type="submit">LOG IN 🔐</button>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </form>
    </div>

     
    <div class="right-image">
        <img src="images\Picture6.png" width="300" height="300" alt="Safe banking">
        <p><strong>Be safe and Happy Banking!</strong></p>
    </div>
</div>
<br>

<div style="text-align: center; font-size: 20px;">
    • Implemented OTP-based login and mandatory password changes every 365 days<br>
    • Remind customers not to share OTPs, passwords, or user information.<br>
    • Options to Lock or Unlock access and profile password changes.<br>
</div>
<br>

<!-- Footer -->
<footer style="width: 100%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
    <div class="text-center">
        <a href="privacy.php" class="block text-white mb-2">Privacy Policy</a>
        <p class="flex justify-center items-center gap-2 text-white text-lg">
            <img src="images/envelope-solid.svg" alt="Email Icon" class="w-4 h-">
            <a href="mailto:customercare@akolajantabank.com" class="hover:underline">customercare@akolajantabank.com</a>
        </p>
    </div>
</footer>

</body>
</html>
