<?php
session_start();
?>

<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   How to Apply for a Loan
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
    <div><strong>    </strong></div>
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
<h1 style="width: 100%; background-color: #21395f; color: white; text-align: center; padding: 6px;">How to Apply for a Loan</h1>
 
  <main class="container mx-auto mt-6">
   <div class="text-center mb-6">
    <h2 class="text-3xl font-bold">
     How to Apply for a Loan
    </h2>

    <p class="text-lg">
     Follow these steps to apply for a loan with us
    </p>
   </div>
   <div class="bg-white p-6 rounded shadow">
    <h3 class="font-bold mb-4">
     Steps to Apply for a Loan
    </h3>
    <ol class="list-decimal list-inside space-y-2">
     <li>
      <strong>
       Check Eligibility:
      </strong>
      Ensure you meet the eligibility criteria for the loan you wish to apply for.
     </li>
     <li>
      <strong>
       Gather Documents:
      </strong>
      Collect all necessary documents such as ID proof, address proof, income proof, etc.
     </li>
     <li>
      <strong>
       Fill Application Form:
      </strong>
      Complete the loan application form available on our website or at the nearest branch.
     </li>
     <li>
      <strong>
       Submit Application:
      </strong>
      Submit the filled application form along with the required documents.
     </li>
     <li>
      <strong>
       Verification:
      </strong>
      Our team will verify your application and documents.
     </li>
     <li>
      <strong>
       Approval:
      </strong>
      Once verified, your loan application will be approved, and you will be notified.
     </li>
     <li>
      <strong>
       Disbursement:
      </strong>
      The loan amount will be disbursed to your account.
     </li>
    </ol>
   </div>
   <div class="bg-white p-6 rounded shadow mt-6">
    <h3 class="font-bold mb-4">
     Contact Us for Assistance
    </h3>
    <p>
     If you need any assistance during the loan application process, please contact our support team:
    </p>
    <ul class="list-disc list-inside">
     <li>
      Email:
      <a class="text-blue-700" href="mailto:customercare@akolajantabank.com">
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
