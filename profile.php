<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

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

    if (!$user) {
        die('User not found.');
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Profile</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
  <style>
    .navbar {
      background-color: #21abcd;
      padding: 10px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .navbar .menu a {
      margin: 0 10px;
      text-decoration: none;
      color: #fff;
    }
    .form-input {
      width: 100%;
      border: 1px solid #d1d5db;
      border-radius: 0.375rem;
      padding: 0.5rem 0.75rem;
      outline: none;
    }
    .form-input:focus {
      border-color: #0f88c6;
      box-shadow: 0 0 0 2px rgba(15, 136, 198, 0.5);
    }
  </style>
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<div class="navbar">
  <div class="text-white font-bold text-lg">Bank Portal</div>
  <div class="menu flex items-center">
    <a href="dashboard.php">
      <button class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
        <i class="fas fa-home"></i> Home
      </button>
    </a>
  </div>
</div>

<!-- Profile Section -->
<section class="bg-gradient-to-r from-[#003366] to-[#00204a] min-h-screen flex flex-col items-center justify-center p-4">

  <!-- Header -->
  <header class="bg-[#0f88c6] w-full max-w-6xl p-4 text-white flex justify-between items-center rounded-t-lg">
    <h1 class="text-lg font-semibold">User Profile</h1>
    <a href="edit.php">
      <button class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded flex items-center">
        <i class="fas fa-edit mr-2"></i>Edit Profile
      </button>
    </a>
  </header>

  <!-- Profile Details -->
  <main class="bg-white w-full max-w-6xl rounded-b-lg shadow-lg p-6 overflow-auto max-h-[90vh]">
    <h2 class="text-[#003366] text-2xl font-semibold mb-6 text-center">Profile Details</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <!-- Left Column -->
      <div class="space-y-4 bg-gray-50 p-4 rounded-lg shadow">
        <div>
          <label class="block text-[#003366] font-medium mb-1">Account Number</label>
          <input type="text" value="<?php echo htmlspecialchars($user['AccountNumber']); ?>" class="form-input" disabled>
        </div>
        <div>
          <label class="block text-[#003366] font-medium mb-1">First Name</label>
          <input type="text" value="<?php echo htmlspecialchars($user['FirstName']); ?>" class="form-input" disabled>
        </div>
        <div>
          <label class="block text-[#003366] font-medium mb-1">Last Name</label>
          <input type="text" value="<?php echo htmlspecialchars($user['LastName']); ?>" class="form-input" disabled>
        </div>
        <div>
          <label class="block text-[#003366] font-medium mb-1">Email</label>
          <input type="email" value="<?php echo htmlspecialchars($user['Email']); ?>" class="form-input" disabled>
        </div>
        <div>
          <label class="block text-[#003366] font-medium mb-1">Phone Number</label>
          <input type="tel" value="<?php echo htmlspecialchars($user['PhoneNumber']); ?>" class="form-input" disabled>
        </div>
	<div>
          <label class="block text-[#003366] font-medium mb-1">Date of Birth</label>
          <input type="date" value="<?php echo htmlspecialchars($user['DateOfBirth']); ?>" class="form-input" disabled>
        </div>
      </div>

      <!-- Middle Column -->
      <div class="space-y-4 bg-gray-50 p-4 rounded-lg shadow">
	<div>
          <label class="block text-[#003366] font-medium mb-1">Account Type</label>
          <input type="text" value="<?php echo htmlspecialchars($user['AccountType']); ?>" class="form-input" disabled>
        </div>
	<div>
          <label class="block text-[#003366] font-medium mb-1">Account Balance</label>
          <input type="number" value="<?php echo htmlspecialchars($user['AccountBalance']); ?>" class="form-input" disabled>
        </div>
        <div>
          <label class="block text-[#003366] font-medium mb-1">Age</label>
          <input type="number" value="<?php echo htmlspecialchars($user['Age']); ?>" class="form-input" disabled>
        </div>
        <div>
          <label class="block text-[#003366] font-medium mb-1">Aadhar Number</label>
          <input type="text" value="<?php echo htmlspecialchars($user['AadhaarNo']); ?>" class="form-input" disabled>
        </div>
        <div>
          <label class="block text-[#003366] font-medium mb-1">UPI ID</label>
          <input type="text" value="<?php echo htmlspecialchars($user['upiID']); ?>" class="form-input" disabled>
        </div>
        <div>
          <label class="block text-[#003366] font-medium mb-1">Credit Card Number</label>
          <input type="text" value="<?php echo htmlspecialchars($user['CreditCardNumber']); ?>" class="form-input" disabled>
        </div>
      </div>

      <!-- Right Column -->
      <div class="space-y-4 bg-gray-50 p-4 rounded-lg shadow">
         
         
        <div>
          <label class="block text-[#003366] font-medium mb-1">Security Question 1</label>
          <input type="text" value="<?php echo htmlspecialchars($user['SecurityQuestion1']); ?>" class="form-input" disabled>
        </div>
	<div>
          <label for="securityAnswer1" class="block text-[#003366] font-medium mb-1">Security Answer 1</label>
          <input type="text" id="securityAnswer1" name="securityAnswer1" value="<?php echo htmlspecialchars($user['SecurityAnswer1']); ?>" class="form-input" disabled>
        </div>
        <div>
          <label class="block text-[#003366] font-medium mb-1">Security Question 2</label>
          <input type="text" value="<?php echo htmlspecialchars($user['SecurityQuestion2']); ?>" class="form-input" disabled>
        </div>
	<div>
          <label for="securityAnswer2" class="block text-[#003366] font-medium mb-1">Security Answer 2</label>
          <input type="text" id="securityAnswer2" name="securityAnswer2" value="<?php echo htmlspecialchars($user['SecurityAnswer2']); ?>" class="form-input" disabled>
        </div>
        <div>
          <label class="block text-[#003366] font-medium mb-1">Address</label>
          <textarea rows="1" class="form-input" disabled><?php echo htmlspecialchars($user['Address']); ?></textarea>
        </div>
	<div>
          <label class="block text-[#003366] font-medium mb-1">City</label>
          <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['City']); ?>" class="form-input" disabled>
        </div>
      </div>
    </div>

  </main>
</section>

<!-- Footer -->
<footer class="bg-[#0892d0] text-white text-center p-6 mt-auto">
  <a href="privacy.php" class="block text-white mb-2 hover:underline">🔒 Privacy Policy</a>
  <p class="flex justify-center items-center gap-2">
    <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
    <a href="mailto:customercare@akolajantabank.com" class="hover:underline">customercare@akolajantabank.com</a>
  </p>
</footer>

</body>
</html>
