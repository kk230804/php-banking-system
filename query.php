<?php
session_start();
$error = '';

// Database connection parameters
$dsn = 'mysql:host=localhost;dbname=customercare;charset=utf8mb4';
$db_user = 'root';
$db_pass = 'Hars81#86@AA';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecting form data
    $FirstName = $_POST['FirstName'] ?? '';
    $MiddleName = $_POST['MiddleName'] ?? '';
    $LastName = $_POST['LastName'] ?? '';
    $Email = $_POST['Email'] ?? '';
    $Query = $_POST['Query'] ?? '';

    try {
        $pdo = new PDO($dsn, $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if a record with the same name and email exists
        $stmt = $pdo->prepare("SELECT * FROM customercare WHERE FirstName = :FirstName AND MiddleName = :MiddleName AND LastName = :LastName AND Email = :Email");
        $stmt->execute([
            ':FirstName' => $FirstName,
            ':MiddleName' => $MiddleName,
            ':LastName' => $LastName,
            ':Email' => $Email
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Check if the same query already exists for this user
            $stmt = $pdo->prepare("SELECT * FROM customercare WHERE FirstName = :FirstName AND MiddleName = :MiddleName AND LastName = :LastName AND Email = :Email AND Query = :Query");
            $stmt->execute([
                ':FirstName' => $FirstName,
                ':MiddleName' => $MiddleName,
                ':LastName' => $LastName,
                ':Email' => $Email,
                ':Query' => $Query
            ]);
            $existingQuery = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$existingQuery) {
                // Insert the new query
                $stmt = $pdo->prepare("INSERT INTO customercare (FirstName, MiddleName, LastName, Email, Query) VALUES (:FirstName, :MiddleName, :LastName, :Email, :Query)");
                $stmt->execute([
                    ':FirstName' => $FirstName,
                    ':MiddleName' => $MiddleName,
                    ':LastName' => $LastName,
                    ':Email' => $Email,
                    ':Query' => $Query
                ]);
            }
        } else {
            // Insert new user and query
            $stmt = $pdo->prepare("INSERT INTO customercare (FirstName, MiddleName, LastName, Email, Query) VALUES (:FirstName, :MiddleName, :LastName, :Email, :Query)");
            $stmt->execute([
                ':FirstName' => $FirstName,
                ':MiddleName' => $MiddleName,
                ':LastName' => $LastName,
                ':Email' => $Email,
                ':Query' => $Query
            ]);
        }

        // Redirect or show success message
        header("Location: query1.php");
        exit;

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
}
?>


<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Start Chat
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
	<style>
	body {
	 background: url(images/back4.png);
         background-repeat: no-repeat;
         background-attachment: fixed;
         background-size: cover;
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
	.para{
            text-align: center;
            font-size: 18px;
            padding: 10px;
            margin-top: 30px;
            color: black;
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
 </style>
 
</head>
 <body class="bg-blue-100">
  <header style="background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Left Logo" style="height: 80px; width: 80px;">
    </div>

    <h1 style="margin: 0; font-size: 24px;">Help Desk</h1>

    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
    </div>
</header>
<div class="navbar">
    <div><strong>     </strong></div>
    <div class="menu">
        <a href="login.php">Accounts</a>
        <a href="login.php">Deposits</a>
        <a href="login.php">Payments</a>
        <a href="login.php">Cards</a>
        <a href="login.php">Loans</a>
        <a href="login.php">Investments</a>
        <a href="login.php">Insurance</a>
        <a href="login.php">Shop</a>
        <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;">
      <i class="fas fa-home text-xl"></i>
      <span class="text-sm"><a href = "help.php">Home</a></span>
    </button>

    </div>
</div>
<h1 style="width: 100%; background-color: #21395f; color: white; text-align: center; padding: 6px;">Send Query</h1>


  <main class="container mx-auto mt-6">
   <div class="text-center mb-6">
    <h2 class="text-3xl font-bold">
     Chat with Support
    </h2>
    <p class="text-lg">
     Our support team is here to help you. Please enter your details to start the chat.
    </p>
   </div>
   <div class="bg-white p-6 rounded shadow-md max-w-md mx-auto">
<form method="POST" action="query2.php">
  <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="FirstName">First Name</label>
    <input name="FirstName" id="FirstName" placeholder="First Name" required class="shadow appearance-none border rounded w-full py-2 px-3" />
  </div>
  <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="MiddleName">Middle Name</label>
    <input name="MiddleName" id="MiddleName" placeholder="Middle Name" class="shadow appearance-none border rounded w-full py-2 px-3" />
  </div>
  <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="LastName">Last Name</label>
    <input name="LastName" id="LastName" placeholder="Last Name" required class="shadow appearance-none border rounded w-full py-2 px-3" />
  </div>
  <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="Email">Email</label>
    <input name="Email" id="Email" type="email" placeholder="Your Email" required class="shadow appearance-none border rounded w-full py-2 px-3" />
  </div>
  <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2" for="Query">Your Query</label>
    <textarea name="Query" id="Query" rows="4" placeholder="Describe your issue" required class="shadow appearance-none border rounded w-full py-2 px-3"></textarea>
  </div>
  <div class="flex items-center justify-between">
    <button type="submit" class="bg-blue-700 text-white font-bold py-2 px-4 rounded">
      Send Query
    </button>

<button class="bg-green-100 hover:bg-green-200 text-green-700 font-medium py-2 px-4 rounded"><a href="query3.php">Raise Complaint</a></button> dashboard

  </div>
</form>

   </div>
  </main>
<br>
<div class="footer">
    • Implemented OTP-based login and mandatory password changes every 365 days<br>
    • Remind customers not to share OTPs, passwords, or user information.<br>
    • Options to Lock or Unlock access and profile password changes.<br>
</div>

<footer style="width: 100%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
    <div class="text-center">
    <a href="privacy.php" class="block text-white mb-2">Privacy policy</a>
    
    <p class="flex justify-center items-center gap-2 text-white text-lg">
      <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
      <a href="https://mail.google.com" class="hover:underline">customercare@akolajantabank.com</a>
    </p>
  </div>

</footer>

 </body>
</html>
