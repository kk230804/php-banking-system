<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "pass";
$dbname = "bankdata";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// DEFAULT values (important)
$card_number = "1234 5678 8901 2345";
$FirstName = "   ";
$expiry_date = "08/29";
$cvv = "862";

// Check if AccountNumber is set in session
if (isset($_SESSION['AccountNumber'])) {
    $AccountNumber = $_SESSION['AccountNumber'];

    // Fetch the card details safely
    $stmt = $conn->prepare("SELECT card_number, FirstName, LastName, expiry_date, cvv FROM bankcustomers WHERE AccountNumber = ?");
    $stmt->bind_param("s", $AccountNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $card_number = $row['card_number'];
        $FirstName = $row['FirstName'];
        $expiry_date = $row['expiry_date'];
        $cvv = $row['cvv'];
    }

    $stmt->close();
} else {
    echo "<script>alert('Account number not found. Please log in again.'); window.location.href='login.php';</script>";
    exit();
}

$conn->close();
?>
<html lang="en"> 
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1" name="viewport"/>
  <title>Virtual Debit Card</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
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
.footer {
            text-align: center;
            font-size: 12px;
            padding: 10px;
            margin-top: 30px;
            color: #555;
        }
 </style>
 </head>
 <body>

  <div class="navbar" style="background-color: #21abcd; padding: 10px 30px; display: flex; justify-content: space-between; align-items: center;">
    <div><strong>     </strong></div>
    <div class="menu flex items-center">
        
        <a href="dashboard.php">
            <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;">
                <i class="fas fa-home text-xl"></i>
                <span class="text-sm">Home</span>
            </button>
        </a>
    </div>
</div>


<main class="bg-gradient-to-r from-[#003366] to-[#00204a] min-h-screen flex flex-col items-center justify-center p-4">
  <section class="bg-white max-w-md w-full rounded-b-lg shadow-lg p-6">
   <div class="relative bg-gradient-to-r from-[#1e40af] to-[#2563eb] rounded-xl p-6 text-white font-sans">
    <div class="flex justify-between items-center mb-6">
     <div class="text-sm uppercase tracking-widest">
      Virtual Debit Card
     </div>
     <img alt="Visa logo on virtual debit card" class="h-6" src="https://storage.googleapis.com/a1aa/image/633bba39-3f11-42ef-3681-04f410d96d42.jpg" width="40" height="25"/>
    </div>
    <div class="text-xl tracking-widest mb-6 select-all">
     <?php echo htmlspecialchars($card_number); ?>
    </div>
    <div class="flex justify-between text-sm">
     <div>
      <div class="uppercase">Card Holder</div>
      <div class="font-semibold">
       <?php echo htmlspecialchars($FirstName); ?>
      </div>
     </div>
     <div>
      <div class="uppercase">Expires</div>
      <div class="font-semibold">
       <?php echo htmlspecialchars($expiry_date); ?>
      </div>
     </div>
     <div>
      <div class="uppercase">CVV</div>
      <div class="font-semibold">
       <?php echo htmlspecialchars($cvv); ?>
      </div>
     </div>
    </div>
   </div>
  </section></main>


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
