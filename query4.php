<?php
session_start();

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

    <h1 style="margin: 0; font-size: 24px;">  </h1>

    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
    </div>
</header>
<div class="navbar">
    <div><strong>     </strong></div>
    <div class="menu">
        <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;"><a href="dashboard.php">Home</a></button>
    </div>
</div>
<h1 style="width: 100%; background-color: #21395f; color: white; text-align: center; padding: 6px;">  </h1>

<main class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h2 class="text-xl mb-4 font-semibold">
    Hello 👋
</h2>


    <p class="mb-6">Your query is send successfully.</p>
    <p class="mb-6">Thank you for banking with us.</p>
    <p class="mb-6">Have a nice day!!</p>
 
    </div>
</main>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>




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
 </body>
</html>

