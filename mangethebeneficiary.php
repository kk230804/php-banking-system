<?php
session_start();

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

// ADD BENEFICIARY LOGIC
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $beneficiaryName = $_POST['beneficiaryName'] ?? '';
    $accountNumber = $_POST['accountNumber'] ?? '';
    $bankName = $_POST['bankname'] ?? '';
    $mobileNumber = $_POST['mobileNumber'] ?? '';

    if ($beneficiaryName && $accountNumber && $bankName && $mobileNumber) {
        try {
            $insert = $pdo->prepare("INSERT INTO beneficiaries (UserAccountNumber, BeneficiaryName, BeneficiaryAccountNumber, BankName, MobileNumber) 
                                     VALUES (:userAccountNumber, :beneficiaryName, :accountNumber, :bankName, :mobileNumber)");
            $insert->execute([
                ':userAccountNumber' => $AccountNumber,
                ':beneficiaryName' => $beneficiaryName,
                ':accountNumber' => $accountNumber,
                ':bankName' => $bankName,
                ':mobileNumber' => $mobileNumber,
            ]);
            // Success message or redirection
            echo "<script>alert('Beneficiary added successfully!'); window.location.href='dashboard.php';</script>";
            exit;
        } catch (PDOException $e) {
            die("Error adding beneficiary: " . $e->getMessage());
        }
    } else {
        echo "<script>alert('Please fill all fields!');</script>";
    }
}
?>

<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>
   Manage Beneficiary
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
 <style>
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
 <body class="bg-[#002855] min-h-screen flex items-center justify-center p-6">
 
 
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
  <div class="max-w-3xl w-full bg-[#000039] rounded-md p-6 shadow-lg">
   <h1 class="text-[#6a5acd] text-2xl font-semibold mb-6 text-center">
    Manage Beneficiary
   </h1>


   <form class="space-y-4 text-[#006db0]" method="POST">
    <div>
     <label class="block mb-1 font-medium" for="beneficiaryName">
      Beneficiary Name
     </label>
     <input class="w-full rounded-md border border-gray-300 p-2" id="beneficiaryName" name="beneficiaryName" placeholder="Enter beneficiary name" required type="text"/>
    </div>
    <div>
     <label class="block mb-1 font-medium" for="accountNumber">
      Beneficiary Account Number
     </label>
     <input class="w-full rounded-md border border-gray-300 p-2" id="accountNumber" name="accountNumber" placeholder="Enter beneficiary account number" required type="text"/>
    </div>
    <div>
     <label class="block mb-1 font-medium" for="bankname">
      Bank Name
     </label>
     <input class="w-full rounded-md border border-gray-300 p-2" id="bankname" name="bankname" placeholder="Enter Beneficiary Bank name" required type="text"/>
    </div>
    <div>
     <label class="block mb-1 font-medium" for="mobileNumber">
      Mobile Number
     </label>
     <input class="w-full rounded-md border border-gray-300 p-2" id="mobileNumber" name="mobileNumber" placeholder="Enter mobile number" maxlength="10" required type="tel"/>
    </div>
    <div class="flex justify-between">
     <button class="bg-[#6a5acd] text-white px-6 py-2 rounded-md text-base font-medium hover:bg-[#2446b0] transition" type="submit">
      Add Beneficiary
     </button>
     <a href="dashboard.php" class="bg-[#6a5acd] text-white px-6 py-2 rounded-md text-base font-medium flex items-center justify-center hover:bg-[#2446b0] transition">
      Back to Dashboard
     </a>
    </div>
</form>


 
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