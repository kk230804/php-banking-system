<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "pass";
$dbname = "bankdata";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch any one AccountNumber from bankcustomers table
    $accountNumber = '';

    $sql = "SELECT AccountNumber FROM bankcustomers LIMIT 1"; // take any first account
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $accountNumber = $row['AccountNumber'];
    }

    if (!empty($accountNumber)) {
        // Get form data
        $fullName = $_POST['fullName'] ?? '';
        $dob = $_POST['dob'] ?? '';
        $address = $_POST['Address'] ?? '';
        $idProof = $_FILES['idProof']['name'] ?? '';
       

        // Insert into kyc_data
        $stmt = $conn->prepare("INSERT INTO kyc_data (AccountNumber, full_name, dob, address, id_proof) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $accountNumber, $fullName, $dob, $address, $idProof);

        if ($stmt->execute()) {
            $successMessage = "Your KYC is submitted successfully!";
        } else {
            $successMessage = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $successMessage = "No account number found in Main table.";
    }
}
?>

<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>KYC Verification</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body>

<!-- Header -->
<header style="background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img alt="Left Logo" class="h-20 w-20" src="images/logoofbank.png" />
    </div>
    <h1 class="text-xl font-bold"><strong>               </strong></h1>
    <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
        <img alt="Right Logo" class="h-20 w-20" src="images/logoofbank.png" />
    </div>
</header>

<!-- Navbar -->
<div class="navbar" style="background-color: #21abcd; padding: 10px 30px; display: flex; justify-content: space-between; align-items: center;">
    <div><strong>                  </strong></div>
    <div class="menu flex items-center">
        <a href="dashboard.php">
            <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;">
                <i class="fas fa-home text-xl"></i>
                <span class="text-sm">Home</span>
            </button>
        </a>
    </div>
</div>

<section class="bg-gradient-to-r from-[#003366] to-[#00204a] min-h-screen flex flex-col items-center justify-center p-4">
  <header class="bg-[#0f88c6] w-full max-w-md p-4 text-white text-center text-lg font-semibold rounded-t-lg">
    KYC Verification
  </header>

<main class="bg-white max-w-md w-full rounded-b-lg shadow-lg p-6">
    <h2 class="text-[#003366] text-xl font-semibold mb-6 text-center">Complete Your KYC</h2>

    <!-- Success message -->
    <?php if (!empty($successMessage)) : ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-center" role="alert">
            <?php echo $successMessage; ?>
        </div>
    <?php else : ?>
        <form class="space-y-4" method="POST" enctype="multipart/form-data">
          <div>
            <label for="fullName" class="block text-[#003366] font-medium mb-1">Full Name</label>
            <input type="text" id="fullName" name="fullName" placeholder="Enter your full name" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0f88c6]" />
          </div>

          <div>
            <label for="dob" class="block text-[#003366] font-medium mb-1">Date of Birth</label>
            <input type="date" id="dob" name="dob" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0f88c6]" />
          </div>

          <div>
            <label for="Address" class="block text-[#003366] font-medium mb-1">Address</label>
            <input type="text" id="Address" name="Address" placeholder="Enter your Address" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#0f88c6]" />
          </div>

          <div>
            <label for="idProof" class="block text-[#003366] font-medium mb-1">Upload ID Proof</label>
            <input type="file" id="idProof" name="idProof" accept=".jpg,.jpeg,.png,.pdf" required class="w-full text-sm text-gray-600" />
          </div>

          <div>
            <label for="addressProof" class="block text-[#003366] font-medium mb-1">Upload Address Proof</label>
            <input type="file" id="addressProof" name="addressProof" accept=".jpg,.jpeg,.png,.pdf" required class="w-full text-sm text-gray-600" />
          </div>

          <button type="submit" class="w-full bg-[#0f88c6] text-white py-2 rounded hover:bg-[#0b5e8a] transition-colors">
            Submit KYC
          </button>
        </form>
    <?php endif; ?>
</main>

</section>

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

</body>
</html>
