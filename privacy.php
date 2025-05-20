<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Privacy Policy</title>
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
<body >
<!-- Header -->
<header style="background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
   <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
    <img alt="Left corner image" class="h-20 w-20" src="images\logoofbank.png"/>
   </div>
   <h1 class="text-xl font-bold text-center"><strong>
    Home page</strong>
   </h1>
   <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
    <img alt="Right corner image" class="h-20 w-20" src="images\logoofbank.png"/>
   </div>
  </header>

<div class="navbar">
    <div><strong>Privacy Policy</strong></div>
    <div class="menu">
        <a href="login.php">Accounts</a>
        <a href="login.php">Deposits</a>
        <a href="login.php">Payments</a>
        <a href="login.php">Cards</a>
        <a href="login.php">Loans</a>
        <a href="login.php">Investments</a>
        <a href="login.php">Insurance</a>
        <a href="login.php">Shop</a>
        <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;"><a href="home.php">Home</a></button>
    </div>
</div>
<h1 style="width: 100%; background-color: #21395f; color: white; text-align: center; padding: 6px;">Privacy Policy</h1>
<p class="para">

	The purpose of this Privacy Policy is to put on record The Akola Janata Commercial Co-operative Bank Ltd., Akola bank’s ( AJCCB ) commitment in ensuring privacy and confidentiality of customer information.
</p>

<p class="para">
	In the course of using this Website or products and services offered by AJCCB, AJCCB may become privy to the personal information of its customer including information that is of confidential nature.
</p>

<p class="para" >
	We may also share your information, without obtaining your prior written consent, with government agencies mandated under the law to obtain information for the purpose of verification of identity, or for prevention, detection, investigation including cyber incidents, prosecution, and punishment of offences, or where disclosure is necessary for compliance of a legal obligation. Any information may be required to be disclosed to any third party by us by an order under the law for the time being in force.
</p>
<p class="para" >
	The commitment to customers' privacy and confidentiality is clearly evident in the bank’s Security Policy.
</p>
<p class="para" >	The information & material on this website is intended for general understanding of AJCCB and to help the public to get exposure to information about the Bank and various products and services offered by the Bank.
</p>
<p class="para" >
	The Bank may, from time to time change this policy.
</p>
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
