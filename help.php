<?php
session_start();
?>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Help Page
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
        body {
	 background: url(images/back2.png);
         background-repeat: no-repeat;
         background-attachment: fixed;
         background-size: cover;
            margin: 0;
            font-family: Arial, sans-serif;
          
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
    <div><strong>Help Page</strong></div>
    <div class="menu">
        <a href="login.php">Accounts</a>
        <a href="login.php">Deposits</a>
        <a href="login.php">Payments</a>
        <a href="login.php">Cards</a>
        <a href="login.php">Loans</a>
        <a href="login.php">Investments</a>
        <a href="login.php">Insurance</a>
        <a href="login.php">Shop</a>
        <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;"><i class="fas fa-home text-xl"></i>
      <span class="text-sm"><a href = "home.php">Home</a></span>
</button>
    </div>
</div>
  <main class="container mx-auto mt-6">
   <div class="text-center mb-6">
    <h2 class="text-3xl font-bold">
     Help
    </h2>
    <p class="text-lg">
     Find answers to your questions and get support
    </p>
   </div>
   <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white p-4 rounded shadow">
     <h4 class="font-bold mb-2">
      Frequently Asked Questions
     </h4>
     <ul class="list-disc list-inside">
      <li>
       <a class="text-blue-700" href="open.php">
        How to open a new account?
       </a>
      </li>
      <li>
       <a class="text-blue-700" href="interest.php">
        What are the interest rates?
       </a>
      </li>
      <li>
       <a class="text-blue-700" href="apply.php">
        How to apply for a loan?
       </a>
      </li>
      <li>
       <a class="text-blue-700" href="reset.php">
        How to reset my password?
       </a>
      </li>
      <li>
       <a class="text-blue-700" href="service.php">
        What are the service charges?
       </a>
      </li>
     </ul>
    </div>
    <div class="bg-white p-4 rounded shadow">
     <h4 class="font-bold mb-2">
      Contact Us
     </h4>
     <p>
      If you need further assistance, please contact our support team:
     </p>
     <ul class="list-disc list-inside">
      <li>
       Email:
       <a class="text-blue-700" href="https://mail.google.com">
        customercare@akolajantabank.com
       </a>
      </li>
      <li>
       Phone:
       <a class="text-blue-700" href="tel:+1234567890">
        +123 456 7890
       </a>
      </li>
      <li>
       Address: 123 Bank Street, Akola
      </li>
     </ul>
    </div>
   </div>
   <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <div class="bg-white p-4 rounded shadow">
     <h4 class="font-bold mb-2">
      Online Support
     </h4>
     <p>
      Chat with our support team for immediate assistance:
     </p>
     <button class="bg-blue-700 text-white font-bold py-2 px-4 rounded shadow mt-2"><a href="query.php">
      Send Query</a>
     </button>
    </div>
    <div class="bg-white p-4 rounded shadow">
     <h4 class="font-bold mb-2"> 
      Feedback 
     </h4>
     <p>
      We value your feedback. Please let us know how we can improve our services:
     </p>
     <button class="bg-blue-700 text-white font-bold py-2 px-4 rounded shadow mt-2"><a href="feedback.php">
      Give Feedback</a>
     </button>
    </div>
   </div>
  </main>

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
	<a href="privacy.php" class="block text-white mb-2">Privacy policy</a>
    
    <p class="flex justify-center items-center gap-2 text-white text-lg">
      <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
      <a href="https://mail.google.com" class="hover:underline">customercare@akolajantabank.com</a>
    </p>

</div>
</footer>
 </body>
</html>
