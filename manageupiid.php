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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUpi = $_POST['newUpi'] ?? '';
    $MPIN = $_POST['MPin'] ?? '';

    if (!empty($newUpi) && !empty($MPIN)) {
        // Optional: Add validation here if needed (already validated in HTML)
        
        try {
            $stmt = $pdo->prepare("UPDATE bankcustomers SET upiID = :newUpi WHERE AccountNumber = :AccountNumber");
            $stmt->execute([
                ':newUpi' => $newUpi,
                ':AccountNumber' => $AccountNumber
            ]);
	  
          
            echo "<script>alert('UPI ID updated successfully!'); window.location.href='';</script>";
            exit;
        } catch (PDOException $e) {
            die("Database update error: " . $e->getMessage());
        }
    } else {
        echo "<script>alert('Please fill all fields correctly.');</script>";
    }
}
?>


<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <title>Manage UPI ID</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    rel="stylesheet"/>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fff;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            padding: 10px;
            margin-top: 30px;
            color: #555;
        }
   </style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
</head>
<body class="bg-[#002855] min-h-screen flex flex-col">
  <header style="background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Left Logo" style="height: 80px; width: 80px;">
    </div>

    <h1 style="margin: 0; font-size: 24px;">                               </h1>

    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
    </div>
</header>

 
  <main class="flex-grow p-6 max-w-3xl mx-auto w-full">
    <section class="bg-[#483d8b] p-4 rounded-md mb-6 flex items-center space-x-4">
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
      <button style="margin-centre: 20px; background-color: #4682b4; color: white; padding: 5px 80px; border: none; border-radius: 5px;"><a href=".php">Profile</a></button>
      <button style="margin-centre: 20px; background-color: #4682b4; color: white; padding: 5px 70px; border: none; border-radius: 5px;"><a href="setting.php">Settings</a></button>
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
      <div class="text-white">
        <p class="font-bold text-base">
          <h2 class="text-xl font-semibold text-white">Hello, <?php echo htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']); ?> 👋</h2>
        </p>

        
      </div>
    </section>

    <section class="bg-[#000039] rounded-md p-6 shadow-md">
      <h2 class="text-[#6a5acd] font-bold text-xl mb-4">Manage Your UPI ID</h2>

      <form class="space-y-6" id="upiForm" method="POST" action="">
        <div>
          <label for="currentUpi" class="block text-[#006db0] font-semibold mb-1"
            >Current UPI ID</label
          >
          <input
            type="text"
            id="currentUpi"
            name="currentUpi"
            value="<?php echo htmlspecialchars($user['upiID']);?>"
            readonly
            class="w-full border border-gray-300 rounded-md p-2 bg-gray-100 cursor-not-allowed"
          />
        </div>

        <div>
          <label for="newUpi" class="block text-[#006db0] font-semibold mb-1"
            >New UPI ID</label
          >
          <input
            type="text"
            id="newUpi"
            name="newUpi"
            placeholder="Enter new UPI ID"
            class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-[#0582ca]"
            required
            pattern="^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+$"
            title="Enter a valid UPI ID format (e.g. username@bank)"
          />
        </div>

        <div>
          <label for="MPIN" class="block text-[#006db0] font-semibold mb-1"
            >MPIN</label
          >
          <input
            type="password"
            id="MPin"
            name="MPin"
            placeholder="Enter your MPIN"
            class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-[#0582ca]"
            required
            minlength="4"
            maxlength="6"
          />
        </div>

        <div class="flex justify-between items-center mt-4">
    <button type="submit" style="background-color: #6a5acd; color: white; padding: 10px 20px; border: none; border-radius: 5px;">
        Update UPI ID
    </button>
    
    <a href="dashboard.php">
        <button type="button" style="background-color: #6a5acd; color: white; padding: 10px 20px; border: none; border-radius: 5px;">
            <i class="fas fa-home text-xl"></i>
            <span class="text-base">Home</span>
        </button>
    </a>
</div>

 </form>
    </section>
  </main>

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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById("upiForm");
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

    // Form validation (OPTIONAL - you can remove if PHP is validating)
    form.addEventListener("submit", (e) => {
      const newUpi = form.newUpi.value.trim();
      const mPin = form.MPin.value.trim();

      if (!newUpi || !mPin) {
        alert("Please fill in all fields.");
        e.preventDefault();  // prevent form submission
      }
    });
});
</script>



</body>
</html>