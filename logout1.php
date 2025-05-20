<?php
session_start();

// DB connection
$dsn = 'mysql:host=localhost;dbname=bankdata;charset=utf8mb4';
$db_user = 'root';
$db_pass = 'pass';
try {
    $pdo = new PDO("mysql:host=localhost;port=3308;dbname=bankdata", "root", "MYsql3@pro");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $AccountNumber = $_SESSION['AccountNumber'];
    $stmt = $pdo->prepare("SELECT * FROM bankcustomers WHERE AccountNumber = :AccountNumber");
    $stmt->execute([':AccountNumber' => $AccountNumber]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>log out from bank</title>
    <style>
        body {
	 background: url(images/back1.png);
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
        .footer {
            text-align: center;
            font-size: 12px;
            padding: 10px;
            margin-top: 30px;
            color: #555;
        }
    </style>
</head>
<body >
<header style="width: 95%; background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Left Logo" style="height: 80px; width: 80px;">
    </div>

    <h1 style="margin: 0; font-size: 24px;">User Logged out page</h1>

    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
    </div>
</header>
<div class="navbar">
    <div><strong><?php echo htmlspecialchars($user['FirstName']); ?> loged out</strong></div>
    <div class="menu">
	 <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;"><a href="logout.php">back</a></button>
        <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;"><a href="home.php">Home</a></button>
    </div>
</div>

<main class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h2 class="text-xl mb-4 font-semibold">Hello, <?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']); ?> 👋</h2>
    <p class="mb-6">You are successfully logged out.</p>
    <p class="mb-6">Thnak you for banking with us.</p>
    <p class="mb-6">Have a nice day!!</p>
 
    </div>
</main>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<div class="footer">
    • Implemented OTP-based login and mandatory password changes every 365 days<br>
    • Remind customers not to share OTPs, passwords, or user information.<br>
    • Options to Lock or Unlock access and profile password changes.<br>
</div>
<footer style="width: 95%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
	<a href="privacy.php">Privacy policy</a>
    Email: customercare@akolajantabank.com
</footer>

</body>
</html>


 