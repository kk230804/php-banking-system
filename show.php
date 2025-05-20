<?php
session_start();

$servername = "localhost"; 
$userName = "root"; 
$userPass = "pass"; 
$database = "bankdata"; 

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$database", $userName, $userPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$user = null;

function generateUniqueAccountNumber($pdo) {
    $baseNumber = 100000;
    $stmt = $pdo->query("SELECT COUNT(*) FROM bankcustomers");
    $count = $stmt->fetchColumn();
    $newAccountNumberNumeric = $baseNumber + $count;
    $accountNumber = "ACC" . $newAccountNumberNumeric;
    return $accountNumber;
}

if (isset($_SESSION['AccountNumber'])) {
    $AccountNumber = $_SESSION['AccountNumber'];
    $stmt = $pdo->prepare("SELECT * FROM bankcustomers WHERE AccountNumber = :AccountNumber");
    $stmt->execute([':AccountNumber' => $AccountNumber]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $AccountNumber = generateUniqueAccountNumber($pdo);

    // Fetch user by Account Number
    $stmt = $pdo->prepare("SELECT * FROM bankcustomers WHERE AccountNumber = :AccountNumber");
    $stmt->execute([':AccountNumber' => $AccountNumber]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Record board</title>
    <style>
body {
    background: url(images/back2.png) no-repeat fixed;
    background-size: cover;
    margin: 0;
    font-family: Arial, sans-serif;
}

header, footer {
    width: 100%;
    background-color: #0892d0;
    color: white;
    text-align: center;
    padding: 40px;
    position: relative;
}

header img {
    height: 60px;
    width: 60px;
}

header div {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}

header div.left {
    left: 20px;
}

header div.right {
    right: 20px;
}

.navbar {
            background-color: #21abcd;
            padding: 10px 20px;
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

.container {
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    background-color: #4682b4;
    border-radius: 10px;
    color: white;
}

.main {
    background-color: #5ba4cf;
    margin-top: 20px;
    padding: 20px;
    border-radius: 10px;
}

table {
    width: 100%;
    background-color: white;
    color: black;
    border-radius: 10px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    text-align: left;
}

.footer {
    text-align: center;
    font-size: 12px;
    padding: 10px;
    margin-top: 30px;
    color: #bbb;
}
</style>


   </style>	
</head>
<body>
<header style="background-color: #0892d0; color: white; width: 1600px; padding: 40px; position: relative; text-align: center;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Left Logo" style="height: 80px; width: 80px;">
    </div>

    <h1 style="margin: 0; font-size: 24px;">User Sign up Page</h1>

    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
    </div>
</header>
<div class="navbar">
    <div><strong>User Sign up Page</strong></div>
    <div class="menu">
	<button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;"><a href="logout3.php">Logout</a></button>
        <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;"><a href="home.php">Home</a></button>
    </div>
</div>


 <main class="container mx-auto mt-6">
   <div class="text-center mb-6">
    <h2 class="text-3xl font-bold">
     Information
    </h2>
    <p class="text-lg">
     Note this for later uses.
    </p>
   </div>

   <div style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;">
    <h3 class="text-2xl font-bold mb-4">
      Account
    </h3>
    
	<table class="min-w-full bg-white">
     <thead>
      <tr>
       <td class="py-2 px-4 border-b">
       <strong> Name </strong>
       </td>
       <td class="py-2 px-4 border-b">
                  <?php echo isset($user['FirstName']) ? htmlspecialchars($user['FirstName']) : 'N/A'; ?>
<?php echo " "; echo isset($user['LastName']) ? htmlspecialchars($user['LastName']) : 'N/A'; ?>

       </td>
      </tr>


     </thead>

     <tbody>
      <tr>
       <td class="py-2 px-4 border-b">
          <strong>Date of Birth </strong>
       </td>
       <td class="py-2 px-4 border-b">
        <?php echo isset($user['DateOfBirth']) ? htmlspecialchars($user['DateOfBirth']) : 'N/A'; ?>
       </td>
      </tr>

      <tr>
       <td class="py-2 px-4 border-b">
        <strong> Age </strong>
       </td>
       <td class="py-2 px-4 border-b">
         <?php echo isset($user['Age'])? htmlspecialchars($user['Age']) : 'N/A'; ?>
       </td>
      </tr>

      <tr>
       <td class="py-2 px-4 border-b">
         <strong>Address </strong>
       </td>
       <td class="py-2 px-4 border-b">
        <?php echo isset($user['City'])? htmlspecialchars($user['City']) : 'N/A'; ?> 
	<?php echo isset($user['State'])? htmlspecialchars($user['State']) : 'N/A';  ?> 
	<?php echo isset($user['PinCode'])? htmlspecialchars($user['PinCode']) : 'N/A';  ?>
       </td>
      </tr>
<tr>
       <td class="py-2 px-4 border-b">
         <strong> Phone Number </strong>
       </td>
<td class="py-2 px-4 border-b">
<?php echo isset($user['PhoneNumber']) ? htmlspecialchars($user['PhoneNumber']) : 'N/A';  ?>
</td>
</tr>

     </tbody>
    </table>
   </div>
<br>
   <div style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;">
    <h3 class="text-2xl font-bold mb-4">
    Account Info
    </h3>

    <table class="min-w-full bg-white">
     <tbody>
      <tr>
       <td class="py-2 px-4 border-b">
         <strong>Account Number </strong>
       </td>
       <td class="py-2 px-4 border-b">
        <?php echo isset($user['AccountNumber']) ? htmlspecialchars($user['AccountNumber']) : 'N/A';  ?>
       </td>
      </tr>

      <tr>
       <td class="py-2 px-4 border-b">
        <strong> Account Type</strong>
       </td>
       <td class="py-2 px-4 border-b">
        <?php echo isset($user['AccountType']) ? htmlspecialchars($user['AccountType']) : 'N/A'; ?>
       </td>
      </tr>

      <tr>
       <td class="py-2 px-4 border-b">
        <strong> Account Balance </strong>
       </td>
       <td class="py-2 px-4 border-b">
       <?php echo isset($user['AccountBalance']) ? htmlspecialchars($user['AccountBalance']) : 'N/A';  ?>
       </td>
      </tr>

      <tr>
       <td class="py-2 px-4 border-b">
         <strong>Email</strong>
       </td>
       <td class="py-2 px-4 border-b">
         <?php echo isset($user['Email']) ? htmlspecialchars($user['Email']) : 'N/A';  ?>
       </td>
      </tr>
 
     </tbody>
    </table>
   </div>
<br>

</main>

<br>
<br>
<br>
<br>
<br>
<div style="text-align: center; font-size: 12px;">
    • Implemented OTP-based login and mandatory password changes every 365 days<br>
    • Remind customers not to share OTPs, passwords, or user information.<br>
    • Options to Lock or Unlock access and profile password changes.<br>
</div>
<footer style="width: 100%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
	<div class="text-center">
	<a href="privacy.php">Privacy policy</a>
     <p class="flex justify-center items-center gap-2 text-white text-lg">
      <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
      <a href="https://mail.google.com" class="hover:underline">customercare@akolajantabank.com</a>
    </p>
</div>
</footer>

</body>
</html>
