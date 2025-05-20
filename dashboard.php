<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// DB connection
$dsn = 'mysql:host=localhost;dbname=bankdata;charset=utf8mb4';
$db_user = 'root';
$db_pass = 'pass';
try {
    $pdo = new PDO($dsn, $db_user, $db_pass);
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
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
	 background: url(images/back1.png);
         background-repeat: no-repeat;
         background-attachment: fixed;
         background-size: cover;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fff;
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
            padding: 40px;
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
<body class="bg-gray-100">
<header style="background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Left Logo" style="height: 80px; width: 80px;">
    </div>

    <h1 style="margin: 0; font-size: 24px;">User Dashboard</h1>

    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
    </div>
</header>

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

  <!-- Modal overlay -->
  <div
    id="profileModal"
    class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50"
    role="dialog"
    aria-modal="true"
  >
    <div id="profileModalContent" class="bg-white rounded-md shadow-lg w-64 p-6 text-center space-y-3" style="background-color: #e0f7fa; border: 2px solid #0892d0;">
      <h2 class="text-lg font-semibold mb-2">Profile Menu</h2>
      <button style="margin-centre: 20px; background-color: #4682b4; color: white; padding: 5px 80px; border: none; border-radius: 5px;"><a href="home.php">Home</a></button>
      <button style="margin-centre: 20px; background-color: #4682b4; color: white; padding: 5px 80px; border: none; border-radius: 5px;"><a href="profile.php">Profile</a></button>
      <button style="margin-centre: 20px; background-color: #4682b4; color: white; padding: 5px 70px; border: none; border-radius: 5px;"><a href="settings.php">Settings</a></button>
      <button id="openNotiBtn" style="margin-centre: 20px; background-color: #4682b4; color: white; padding: 5px 60px; border: none; border-radius: 5px;">Notifications</button>
      <button style="margin-centre: 20px; background-color: #4682b4; color: white; padding: 5px 70px; border: none; border-radius: 5px;"><a href="privacy.php">Privacy</a></button>
      <button style="margin-centre: 20px; background-color: #4682b4; color: white; padding: 5px 80px; border: none; border-radius: 5px;"><a href="help.php">Help</a></button>
      <button style="margin-centre: 20px; background-color: #4682b4; color: white; padding: 5px 80px; border: none; border-radius: 5px;"><a href="logout1.php">Logout</a></button>
       
    </div>
  </div>

<div
    id="notificationModal"
    class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50"
    role="dialog"
    aria-modal="true">
	<div id="notificationModalContent" class="bg-white rounded-md shadow-lg w-64 p-6 text-center space-y-3" style="background-color: #e0f7fa; border: 2px solid #0892d0;">
      <h2 class="text-lg flex justify-center font-semibold mb-2">Notifications 🔔</h2>
      <h4 class="text-lg flex justify-center font-semibold mb-2">You have no notifications for now</h4>
</div>
  </div>

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
        <div>
            <h2 class="text-xl font-semibold text-white">Hello, <?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']); ?> 👋</h2>
            <p class="text-sm text-white">You are successfully logged in.</p>
        </div>
    </div>
</div>
</header>
     
 


    <!-- Section 1 -->
    <div class="mb-8"><br>
       <div class="flex justify-center">
    <button disabled class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded">
        Core Banking
    </button>
</div>
<br><br>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">

            <button class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded"><a href="mini.php">Mini Statement</a></button>
            <button class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded"><a href="fundtransfer.php">Fund Transfers</a></button>
            <button class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded"><a href="kyc.php">KYC</a></button>
            <button class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded"><a href="sweepin.php"> Sweep</a></button>
            <button class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded"><a href="debit.php">Debit Card </a></button>
<button class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded"><a href="loan.php">Loan</a></button>
            <button class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded"><a href="insurance.php">Insurance</a></button>
            <button class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium py-2 px-4 rounded"><a href="investment.php">Investment</a></button>
        </div>
    </div>

    <!-- Section 2 -->
    <div class="mb-8"><br>
        <div class="flex justify-center">
    <button disabled class="bg-green-100 hover:bg-green-200 text-green-700 font-medium py-2 px-4 rounded">UPI Services</button>
</div><br><br>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <button class="bg-green-100 hover:bg-green-200 text-green-700 font-medium py-2 px-4 rounded"><a href="myqr.php">Show My QR</a></button>
            <button class="bg-green-100 hover:bg-green-200 text-green-700 font-medium py-2 px-4 rounded"><a href="query.php">Raise Complaint</a></button>
            <button class="bg-green-100 hover:bg-green-200 text-green-700 font-medium py-2 px-4 rounded"><a href="manageupiid.php">Manage UPI ID</a></button>
            <button class="bg-green-100 hover:bg-green-200 text-green-700 font-medium py-2 px-4 rounded"><a href="mangethebeneficiary.php">Manage Beneficiary</a></button>
        </div>
    </div>

          

<br>
<br>
<div class="footer">
    • Implemented OTP-based login and mandatory password changes every 365 days<br>
    • Remind customers not to share OTPs, passwords, or user information.<br>
    • Options to Lock or Unlock access and profile password changes.<br>
</div>

<!-- Footer -->
<footer style="width: 100%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
    <div class="text-center">
        <a href="privacy.php" class="block text-white mb-2">Privacy Policy</a>
        <p class="flex justify-center items-center gap-2 text-white text-lg">
            <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
            <a href="mailto:customercare@akolajantabank.com" class="hover:underline">customercare@akolajantabank.com</a>
        </p>
    </div>
</footer>


<script defer>
  document.addEventListener('DOMContentLoaded', () => {
    const profileModal = document.getElementById('profileModal');
    const profileButton = document.getElementById('profileButton');
    const profileModalContent = document.getElementById('profileModalContent');

    const notificationModal = document.getElementById('notificationModal');
    const notificationButton = document.getElementById('openNotiBtn');
    const notificationModalContent = document.getElementById('notificationModalContent');

    // Profile Button Click
    profileButton.addEventListener('click', (e) => {
      e.stopPropagation();
      profileModal.classList.toggle('hidden');
      notificationModal.classList.add('hidden'); // Close Notification
    });

    // Notification Button Click
    notificationButton.addEventListener('click', (e) => {
      e.stopPropagation();
      notificationModal.classList.toggle('hidden');
      profileModal.classList.add('hidden'); // Close Profile
    });

    // Prevent clicks inside modals from closing them
    profileModalContent.addEventListener('click', (e) => {
      e.stopPropagation();
    });
    notificationModalContent.addEventListener('click', (e) => {
      e.stopPropagation();
    });

    // Click outside anywhere to close both
    window.addEventListener('click', () => {
      profileModal.classList.add('hidden');
      notificationModal.classList.add('hidden');
    });
  });
</script>



</body>
</html>
