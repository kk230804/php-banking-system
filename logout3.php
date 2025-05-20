<?php
session_start();

// Make sure AccountNumber is set
if (!isset($_SESSION['AccountNumber'])) {
    echo "You're not logged in!";
    header("Location: login.php");
    exit;
}

// 🛠 Update these with your correct DB credentials
$host = 'localhost';
$port = '3306'; // change to 3306 if not using custom port
$dbname = 'bankdata';
$username = 'root';
$password = 'pass'; // ← this MUST match your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $AccountNumber = $_SESSION['AccountNumber'];
    $stmt = $pdo->prepare("SELECT * FROM bankcustomers WHERE AccountNumber = :AccountNumber");
    $stmt->execute([':AccountNumber' => $AccountNumber]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Optional: Store name before session_destroy()
    $_SESSION['logout_name'] = $user['FirstName'] ?? 'Guest';
   


} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Optional: destroy session
session_destroy();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log Out from Bank</title>
    <style>
        body {
            background: url(images/back1.png) no-repeat fixed;
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
            color: #fff;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            padding: 10px;
            margin-top: 30px;
            color: #555;
        }
        button a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
<header style="width: 95%; background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Left Logo" style="height: 80px; width: 80px;">
    </div>
    <h1 style="margin: 0; font-size: 24px;">User Logged Out Page</h1>
    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
    </div>
</header>

<div class="navbar">
    <div><strong>
        <?php
        if ($user) {
            echo htmlspecialchars($user['FirstName']) . ' logged out';
        } elseif ($logoutName) {
            echo htmlspecialchars($logoutName) . ' logged out';
        } else {
            echo "User logged out";
        }
        ?>
    </strong></div>
    <div class="menu">
        <button style="margin-left: 20px; background-color: #4682b4; padding: 5px 10px; border: none; border-radius: 5px;">
            <a href="logout.php">Back</a>
        </button>
        <button style="margin-left: 20px; background-color: #4682b4; padding: 5px 10px; border: none; border-radius: 5px;">
            <a href="home.php">Home</a>
        </button>
    </div>
</div>

<main class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h2 class="text-xl mb-4 font-semibold">Hello,
        <?php
        if ($user) {
            echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']);
        } elseif ($logoutName) {
            echo htmlspecialchars($logoutName);
        } else {
            echo "Guest";
        }
        ?> 👋
    </h2>
    <p class="mb-6">You are successfully logged out.</p>
    <p class="mb-6">Thank you for banking with us.</p>
    <p class="mb-6">Have a nice day!!</p>
</main>

<br><br><br><br><br><br><br><br><br><br><br><br>

<div class="footer">
    • Implemented OTP-based login and mandatory password changes every 365 days<br>
    • Remind customers not to share OTPs, passwords, or user information.<br>
    • Options to Lock or Unlock access and profile password changes.<br>
</div>

<footer style="width: 95%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
    <a href="privacy.php" style="color: white;">Privacy policy</a> |
    Email: customercare@akolajantabank.com
</footer>
</body>
</html>
