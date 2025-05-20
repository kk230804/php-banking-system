<?php
session_start();

// Replace these with your actual database credentials
$dsn = 'mysql:host=localhost;dbname=bankdata;charset=utf8mb4';
$db_user = 'root';
$db_pass = 'pass';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $AccountNumber = $_POST['AccountNumber'] ?? '';
    $MPIN = $_POST['MPIN'] ?? '';
    $captcha = $_POST['captcha'] ?? '';
    $SecurityQuestion1 = $_POST['SecurityQuestion1'] ?? '';
    $SecurityAnswer1 = $_POST['SecurityAnswer1'] ?? '';
    

    if (strtolower(trim($captcha)) !== 'abc123') {
        $error = "Invalid captcha!";
    } else {
        try {
    $pdo = new PDO($dsn, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch user by Account Number
    $stmt = $pdo->prepare("SELECT * FROM bankcustomers WHERE AccountNumber = :AccountNumber");
    $stmt->execute([':AccountNumber' => $AccountNumber]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if ($MPIN === $user['MPIN']) {

            if(strtolower($SecurityQuestion1) === strtolower($user['SecurityQuestion1']) && strtolower($SecurityAnswer1) === strtolower($user['SecurityAnswer1'])){
                // Success
                $_SESSION['AccountNumber'] = $AccountNumber;
                $_SESSION['loggedin'] = true;
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Incorrect security question or answer.";
            }

        } else {
            $error = "Incorrect MPIN!";
        }
    } else {
        $error = "Account not found!";
    }
} 
catch (PDOException $e) {
    $error = "Database error: " . $e->getMessage();
}
}}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bank Login</title>
    <style>
        body {
	 background: url(images/back2.png);
         background-repeat: no-repeat;
         background-attachment: fixed;
         background-size: cover;
            margin: 0;
            font-family: Arial, sans-serif;
          
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
        .main {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 40px 40px;
	    gap: 50px;
        }
        .login-box {
            background-color: #e0f4ff;
            padding: 30px;
            width: 320px;
            border-radius: 8px;
	    margin-top: 30px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-box input,
        .login-box select {
            width: 320px;
            padding: 8px;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
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
            background-color:  #4b0082;
        }
        .right-image {
            margin-left: 50px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            padding: 10px;
            margin-top: 30px;
            color: #555;
        }
        .error {
            color: red;
            font-size: 13px;
        }
        .signup-link {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>

 <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

</head>
<body>
<header style="background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Left Logo" style="height: 80px; width: 80px;">
    </div>

    <h1 style="margin: 0; font-size: 24px;">User Login Page</h1>

    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
    </div>
</header>
<div class="navbar">
    <div><strong>User Login Page</strong></div>
    <div class="menu">
        <a href="login.php">Accounts</a>
        <a href="login.php">Deposits</a>
        <a href="login.php">Payments</a>
        <a href="login.php">Cards</a>
        <a href="login.php">Loans</a>
        <a href="login.php">Investments</a>
        <a href="login.php">Insurance</a>
        <a href="login.php">Shop</a>
       <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;"><i class="fas fa-home text-xl"></i><span 	class="text-sm"><a href = "home.php">Home</a></span></button>
    </div>
</div>

<div class="main">
    <div class="login-box">
        <h2>Log In</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <input type="text" name="AccountNumber" placeholder="Account Number" required>
     <div style="position: relative;">
    <input type="password" name="MPIN" id="mpin" placeholder="MPIN" maxlength="6" required>
    <i id="toggleMPIN" class="fas fa-eye" onclick="toggleMPIN()" style="position: absolute; right: 10px; top: 35%; transform: translateY(-50%); cursor: pointer;"></i>

</div>



            <label for="SecurityQuestion1">Security Question 1</label>
            <select name="SecurityQuestion1" required>
                <option value="">Select a question</option>
                <option value="What is your mother?s middle name?">What is your mother?s middle name?</option>
                <option value="What is your pet?s name?">What is your pet?s name?</option>
                <option value="What was the name of your elementary school?">What was the name of your elementary school?</option>
	
                <option value="What is your favourite book?">What is your favourite book?</option>
                <option value="What is your favourite movie?">What is your favourite movie?</option>
                <option value="What is your favourite dessert?">What is your favourite dessert?</option>
                <option value="What is your favourite fruit?">What is your favourite fruit?</option>
                <option value="What was the make of your first car?">What was the make of your first car?</option>
                <option value="What city were you born in?">What city were you born in?</option>
                <option value="What is your favourite food?">What is your favourite food?</option>
		<option value="What is your favourite hobby?">What is your favourite hobby?</option>
		<option value="What is your favourite sport?">What is your favourite sport?</option>
		<option value="What is your favourite place?">What is your favourite place?</option>
		<option value="What is your favourite season?">What is your favourite season?</option>
		<option value="What is your favourite ice cream flavour?">What is your favourite ice cream flavour?</option>
		<option value="What is your favourite dish?">What is your favourite dish?</option>
		<option value="What was your first car?">What was your first car?</option>
		<option value="What is your favourite festival?">What is your favourite festival?</option>
		<option value="What is your hometown?">What is your hometown?</option>
            </select>

            <label for="SecurityAnswer1">Answer</label>
            <input type="text" name="SecurityAnswer1" id="SecurityAnswer1" required>

            <input type="text" name="captcha" placeholder="Captcha (hint: abc123)" required>

            <button type="submit"><a herf="home.php">LOG IN 🔐</a></button>
        </form>

        <div class="signup-link">
            New User? <a href="signup.php">Click here to Signup</a>
        </div>
    </div>

    <div class="right-image">
        <img src="images/Picture8.png" width="400" height="400" alt="Safe banking">
        <p><strong>Be safe and Happy Banking!</strong></p>
    </div>
</div>

<div style="text-align: center; font-size: 20px;">
    • Implemented OTP-based login and mandatory password changes every 365 days<br>
    • Remind customers not to share OTPs, passwords, or user information.<br>
    • Options to Lock or Unlock access and profile password changes.<br>
</div>
<br>
<br>
<br>


<!-- Footer -->
<footer style="width: 100%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
    <div class="text-center">
        <a href="privacy.php" class="block text-white mb-2">Privacy Policy</a>
        <p class="flex justify-center items-center gap-2 text-white text-lg">
            <img src="images/envelope-solid.svg" alt="Email Icon" class="w-4 h-4">
            <a href="mailto:customercare@akolajantabank.com" class="hover:underline">customercare@akolajantabank.com</a>
        </p>
    </div>
</footer>

<script>
const mpinInput = document.getElementById("mpin");
const toggleIcon = document.getElementById("toggleMPIN");

// Always show the eye icon once user types
mpinInput.addEventListener('input', function() {
    if (mpinInput.value.length > 0) {
        toggleIcon.style.display = "block";
    } else {
        toggleIcon.style.display = "none";
    }
});

// Toggle visibility
function toggleMPIN() {
    if (mpinInput.type === "password") {
        mpinInput.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
    } else {
        mpinInput.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
    }
}
</script>


</body>
</html>
