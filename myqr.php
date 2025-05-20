<?php
session_start(); // MANDATORY to access $_SESSION

// Database config
$host = "localhost";
$user = "root";
$password = "pass";
$database = "bankdata";

// DB connection
$dsn = 'mysql:host=localhost;dbname=bankdata;charset=utf8mb4';
$db_user = 'root';
$db_pass = 'pass';

try {
    $pdo = new PDO($dsn, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (!empty($_SESSION['AccountNumber'])) {
        $AccountNumber = $_SESSION['AccountNumber'];
        $stmt = $pdo->prepare("SELECT * FROM bankcustomers WHERE AccountNumber = :AccountNumber");
        $stmt->execute([':AccountNumber' => $AccountNumber]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $user = null; // No session account number
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>User Dashboard - Show My QR</title>
  
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  
  <script>
    function showQR() {
      document.getElementById("dashboard").classList.add("hidden");
      document.getElementById("qrSection").classList.remove("hidden");
    }
    function backToDashboard() {
      document.getElementById("qrSection").classList.add("hidden");
      document.getElementById("dashboard").classList.remove("hidden");
    }
    function toggleDropdown() {
      const menu = document.getElementById("dropdownMenu");
      menu.classList.toggle("hidden");
    }
  </script>
  
  <style>
    .footer {
      text-align: center;
      font-size: 12px;
      padding: 10px;
      margin-top: 30px;
      color: #555;
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
  </style>
</head>

<body class="bg-[#002855]">

<!-- Header -->
<header style="background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
  <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
    <img src="images/logoofbank.png" alt="Left Logo" style="height: 80px; width: 80px;">
  </div>
  <h1 style="margin: 0; font-size: 24px;">User Dashboard</h1>
  <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
    <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
  </div>
</header>

<!-- Dashboard Content -->
<div id="dashboard">

  <div class="navbar">
    <div class="flex items-center space-x-4">
      <button
        id="profileButton"
        class="w-10 h-10 rounded-full bg-teal-600 flex items-center justify-center text-white text-lg font-semibold focus:outline-none"
        aria-haspopup="true"
        aria-expanded="false"
        aria-label="Open profile menu">
        <img src="images/circle-user-solid.svg" alt="Profile Icon" class="w-6 h-6">
      </button>
    </div>

    <div>
      <a href="dashboard.php" class="ml-4 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">Home</a>
      <button onclick="showQR()" class="ml-4 bg-blue-900 hover:bg-green-700 text-white py-2 px-4 rounded">Show My QR</button>
    </div>
  </div>

  <div class="text-center mt-12 text-white">
    <h2 class="text-2xl mb-4">Welcome, <?php echo htmlspecialchars($user['FirstName'] ?? 'User'); ?>!</h2>
    <p class="text-lg">Manage your account, view transactions, and much more.</p>
  </div>

</div>

<!-- QR Section -->
<section class="hidden min-h-screen flex flex-col items-center justify-center bg-[#002855] p-4" id="qrSection">
  <h2 class="text-white text-xl font-semibold mb-6">Your UPI QR Code</h2>
  
  <img alt="Placeholder image of a UPI QR code" class="w-72 h-72 mb-6" 
    src="https://storage.googleapis.com/a1aa/image/046b6a18-e995-4da2-3d75-35b8663e81b0.jpg"
    width="300" height="300"/>
    
  <button onclick="backToDashboard()" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded">
    Back to Dashboard
  </button>
</section>

<!-- Footer Notes -->
<br><br><br><br><br><br><br><br><br>
<div class="footer">
  • Implemented OTP-based login and mandatory password changes every 365 days<br>
  • Remind customers not to share OTPs, passwords, or user information.<br>
  • Options to Lock or Unlock access and profile password changes.<br>
</div>

<!-- Footer Contact -->
<footer style="width: 100%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
  <div class="text-center">
    <a href="privacy.php" class="block text-white mb-2">Privacy Policy</a>
    <p class="flex justify-center items-center gap-2 text-white text-lg">
      <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
      <a href="mailto:customercare@akolajantabank.com" class="hover:underline">customercare@akolajantabank.com</a>
    </p>
  </div>
</footer>

<!-- Profile and Notification Modals -->
<div
    id="profileModal"
    class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50"
    role="dialog"
    aria-modal="true">
    <div id="profileModalContent" class="bg-white rounded-md shadow-lg w-64 p-6 text-center space-y-3" style="background-color: #e0f7fa; border: 2px solid #0892d0;">
      <h2 class="text-lg font-semibold mb-2">Profile Menu</h2>
      <button class="block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mb-2"><a href="home.php">Home</a></button>
      <button class="block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mb-2"><a href="profile.php">Profile</a></button>
      <button class="block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mb-2"><a href="setting.php">Settings</a></button>
      <button id="openNotiBtn" class="block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mb-2">Notifications</button>
      <button class="block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mb-2"><a href="privacy.php">Privacy</a></button>
      <button class="block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mb-2"><a href="help.php">Help</a></button>
      <button class="block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mb-2"><a href="logout1.php">Logout</a></button>
    </div>
</div>

<div
    id="notificationModal"
    class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50"
    role="dialog"
    aria-modal="true">
    <div id="notificationModalContent" class="bg-white rounded-md shadow-lg w-64 p-6 text-center space-y-3" style="background-color: #e0f7fa; border: 2px solid #0892d0;">
      <h2 class="text-lg font-semibold mb-2">Notifications 🔔</h2>
      <h4 class="text-lg font-semibold mb-2">You have no notifications for now</h4>
    </div>
</div>

</body>
</html>