<?php
session_start();

// Check if user is logged in
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

    $accountNumber = $_SESSION['AccountNumber'];

    // Fetch current user data
    $stmt = $pdo->prepare("SELECT PhoneNumber, Email, MPIN, Address FROM bankcustomers WHERE AccountNumber = :AccountNumber");
    $stmt->execute([':AccountNumber' => $accountNumber]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $phone = $_POST['PhoneNumber'];
    $email = $_POST['Email'];
    $mpin = $_POST['MPIN'];
    $address = $_POST['Address'];

    try {
        $updateStmt = $pdo->prepare("UPDATE bankcustomers 
            SET PhoneNumber = :PhoneNumber, Email = :Email, MPIN = :MPIN, Address = :Address 
            WHERE AccountNumber = :AccountNumber");

        $updateStmt->execute([
            ':PhoneNumber' => $phone,
            ':Email' => $email,
            ':MPIN' => $mpin,
            ':Address' => $address,
            ':AccountNumber' => $accountNumber
        ]);

        echo "<script>alert('✅ Profile updated successfully.'); window.location.href='profile.php';</script>";
        exit;

    } catch (PDOException $e) {
        echo "<script>alert('❌ Error updating profile: " . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Profile</title>
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
<body>
<div class="navbar">
  <div class="text-white font-bold text-lg">       </div>
  <div class="menu flex items-center">
    <a href="dashboard.php">
      <button class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
        <i class="fas fa-home"></i> Home
      </button>
    </a>
  </div>
</div>

<main class="bg-gradient-to-r from-[#003366] to-[#00204a] min-h-screen flex items-center justify-center p-6">

<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
    <h2 class="text-2xl font-bold text-center text-[#003366] mb-6">Edit Profile</h2>

    <form method="POST" action="">

        <div class="mb-4">
            <label for="PhoneNumber" class="block text-[#003366] font-medium mb-2">Phone Number</label>
            <input type="tel" id="PhoneNumber" name="PhoneNumber" class="form-input" required value="<?php echo htmlspecialchars($user['PhoneNumber']); ?>">
        </div>

        <div class="mb-4 relative">
            <label for="MPIN" class="block text-[#003366] font-medium mb-2">MPIN</label>
            <input type="password" id="MPIN" name="MPIN" class="form-input pr-10" required value="<?php echo htmlspecialchars($user['MPIN']); ?>">
            <span id="toggleMpin" class="absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500">
                <i class="far fa-eye"></i>
            </span>
        </div>

        <div class="mb-4">
            <label for="Email" class="block text-[#003366] font-medium mb-2">Email</label>
            <input type="email" id="Email" name="Email" class="form-input" required value="<?php echo htmlspecialchars($user['Email']); ?>">
        </div>

        <div class="mb-4">
            <label for="Address" class="block text-[#003366] font-medium mb-2">Address</label>
            <textarea id="Address" name="Address" rows="3" class="form-input"><?php echo htmlspecialchars($user['Address']); ?></textarea>
        </div>

        <div class="flex justify-between mt-6">
    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded">
        Save Changes
    </button>
    <a href="profile.php" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded text-center">
        Cancel
    </a>
</div>

    </form>
</div>
</main>
<!-- Footer -->
<footer class="bg-[#0892d0] text-white text-center p-6 mt-auto">
  <a href="privacy.php" class="block text-white mb-2 hover:underline">🔒 Privacy Policy</a>
  <p class="flex justify-center items-center gap-2">
    <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
    <a href="mailto:customercare@akolajantabank.com" class="hover:underline">customercare@akolajantabank.com</a>
  </p>
</footer>
<script>
    const mpinInput = document.getElementById('MPIN');
    const toggleMpin = document.getElementById('toggleMpin');

    toggleMpin.addEventListener('click', () => {
        const isPassword = mpinInput.type === 'password';
        mpinInput.type = isPassword ? 'text' : 'password';
        toggleMpin.innerHTML = `<i class="far fa-eye${isPassword ? '-slash' : ''}"></i>`;
    });
</script>

 

</body>
</html>
