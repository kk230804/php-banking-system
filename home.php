<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <style>
        body, html {
	 background: url(images/back2.png);
         background-repeat: no-repeat;
         background-attachment: fixed;
         background-size: cover;

            height: 100%;
            margin: 0;
        }
        .content {
            min-height: calc(100vh - 16rem); /* Adjusting for header and footer height */
        }
        .scroll-panel {
         overflow-x: hidden;
         white-space: nowrap;
         width: 100%; /* allow full width */
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

       .scroll-panel img {
       display: inline-block;
       margin-right: 10px;
       height: 200px; /* adjust height */
       width: auto;   /* let width adjust automatically */
       }
    </style>
</head>
<body>

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
    <div><strong>Home page</strong></div>
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
      <span class="text-sm">Home</span>
    </button>

    </div>
</div>

<!-- Main Content -->
<div class="content flex flex-col items-center mt-10 flex-grow">
    <div class="flex flex-col md:flex-row justify-between items-center p-4 bg-white shadow-md w-full max-w-4xl">
        <div class="flex space-x-2 mb-4 md:mb-0">
            <button style="margin-left: 20px; background-color: #21395f; color: white; padding: 5px 10px; border: none; border-radius: 5px;"><a href="login.php">User Login</a></button>
            <button style="margin-left: 20px; background-color: #21395f; color: white; padding: 5px 10px; border: none; border-radius: 5px;"><a href="help.php">Help</a></button>
        </div>
       <div class="flex space-x-2 mb-4 md:mb-0 ml-4">
    <a href="admin1.php">
        <button style="background-color: #21395f; color: white; padding: 5px 10px; border: none; border-radius: 5px;">
            Admin Login
        </button>
    </a>
</div>
    </div>

<div class="flex flex-col items-center mt-10 w-full px-4">

<h1 class="text-4xl font-bold" style="font-family: 'Great Vibes', cursive;">Welcome</h1> 
<h1 class="text-xl font-bold">The Akola Janta Commercial Co-Op Bank Ltd,Akola Br. Murtizapur</strong></b></b></h1>
<h1 class="text-xl font-bold"><strong>दि अकोला जनता कर्मशियल को-ऑप बॅक लि, अकोला</strong></h1>

<main class="flex flex-col lg:flex-row w-full max-w-7xl mx-auto mt-4 px-4 space-x-0 lg:space-x-4">
  
  <!-- Left Sidebar: Banking + Services -->
  <aside class="w-full lg:w-1/4 space-y-4">
    <!-- Banking -->
    <div class="bg-white shadow p-4">
      <h3 class="font-bold text-lg mb-2">Banking</h3>
      <ul class="list-disc list-inside">
        <li><a class="text-blue-700 hover:underline" href="login.php">Personal Banking</a></li>
        <li><a class="text-blue-700 hover:underline" href="login.php">Business Banking</a></li>
        <li><a class="text-blue-700 hover:underline" href="login.php">Term Deposits</a></li>
        <li><a class="text-blue-700 hover:underline" href="login.php">Loans and Advances</a></li>
      </ul>
    </div>

    <!-- Services -->
    <div class="bg-white shadow p-4">
      <h3 class="font-bold text-lg mb-2">Services</h3>
      <ul class="list-disc list-inside">
        <li>RTGS / NEFT</li>
        <li>ATM Facility</li>
        <li>SMS Facility</li>
        <li>Lockers Facility</li>
        <li>Tax Payment</li>
        <li>PMSBY</li>
        <li>PMJJBY</li>
        <li>Internet Banking (View Only)</li>
        <li>Mobile Banking (IMPS)</li>
        <li>Unified Payment Interface (UPI)</li>
      </ul>
    </div>
  </aside>

  <!-- Middle Content: What's New + Images -->
  <section class="w-full lg:w-2/4 space-y-4 mt-4 lg:mt-0">
    <!-- What's New -->
    <div class="bg-white shadow p-4">
      <h3 class="font-bold text-lg mb-2">WHAT'S NEW</h3>
      <ul class="list-disc list-inside">
        <li>Shifting of our Naraina Branch <span class="text-red-500">New</span></li>
        <li>Deposit Insurance Scheme <span class="text-red-500">New</span></li>
        <li>Information on secured assets possessed under the SARFAESI Act, 2002 <span class="text-red-500">New</span></li>
        <li>Financial Statement - published in <span class="text-red-500">कौमी पत्रिका</span> for 2023-2024</li>
        <li>Unclaimed Deposits / Inoperative Accounts as on 31/03/2024</li>
      </ul>
    </div>

    <!-- Image Panel -->
   <div id="imageScroller" class="w-full overflow-x-auto whitespace-nowrap border border-gray-300 p-4">
  <div class="inline-flex space-x-4">
        <img src= "images\pic9.png" alt="Image 1" class="h-48" />
	<img src= "images\pic17.png"alt="Image 3" class="h-48" />
        <img src= "images\pic10.png"alt="Image 2" class="h-48" />
        <img src= "images\pic11.png" alt="Image 3" class="h-48" />
        <img src= "images\pic13.png"alt="Image 4" class="h-48" />
        <img src= "images\pic14.png"alt="Image 5" class="h-48" />
        <img src= "images\pic15.png"alt="Image 1" class="h-48" />
        <img src= "images\pic16.png" alt="Image 2" class="h-48" />
        <img src= "images\pic17.png"alt="Image 3" class="h-48" />
        <img src= "images\pic9.png"alt="Image 1" class="h-48" />
        <img src= "images\pic10.png"alt="Image 2" class="h-48" />
        <img src= "images\pic11.png"alt="Image 3" class="h-48" />
        <img src= "images\pic13.png"alt="Image 4" class="h-48" />
        <img src= "images\pic14.png"alt="Image 5" class="h-48" />
        <img src= "images\pic15.png" alt="Image 1" class="h-48" />
        <img src= "images\pic16.png"alt="Image 2" class="h-48" />
        <img src= "images\pic17.png" alt="Image 3" class="h-48" />

      </div>
    </div>
  </section>

  <!-- Right Sidebar: Information -->
  <aside class="w-full lg:w-1/4 space-y-4 mt-4 lg:mt-0">
    <!-- Information -->
    <div class="bg-white shadow p-4">
      <h3 class="font-bold text-lg mb-2">Information</h3>
      <ul class="list-disc list-inside">
        <li>Service Charges</li>
        <li>ATM Charges</li>
        <li>KYC Circular</li>
        <li>TDS Guidelines</li>
        <li>Inoperative A/c</li>
        <li>Aadhar Linking</li>
        <li>GST Registration</li>
      </ul>
    </div>
  </aside>
</main>

    </div>
</div>

<br><br><br><br>

<!-- Footer -->
<footer style="width: 100%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
  <div class="text-center">
    <a href="privacy.php" class="block text-white mb-2">Privacy policy</a>
    
    <p class="flex justify-center items-center gap-2 text-white text-lg">
      <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
      <a href="https://mail.google.com" class="hover:underline">customercare@akolajantabank.com</a>
    </p>
  </div>
</footer>


<script>
  document.addEventListener('DOMContentLoaded', () => {
    const scroller = document.getElementById('imageScroller');
    if (!scroller) return;

    let scrollSpeed = 1; // pixels per frame
    let scrollInterval;

    function startScrolling() {
      scrollInterval = setInterval(() => {
        scroller.scrollLeft += scrollSpeed;

        // Loop scroll when end is reached
        if (scroller.scrollLeft >= scroller.scrollWidth - scroller.clientWidth) {
          scroller.scrollLeft = 0;
        }
      }, 30); // lower = faster
    }

    function stopScrolling() {
      clearInterval(scrollInterval);
    }

    // Start scrolling on page load
    window.addEventListener('load', startScrolling);

    // Optional: pause on hover
    scroller.addEventListener('mouseover', stopScrolling);
    scroller.addEventListener('mouseout', startScrolling);
  }); // <--- you were missing this closing!
</script>


</body>
</html>








