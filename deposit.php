<?php
// deposits.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Deposits</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cover bg-center" style="background-image: url('images/back2.png'); font-family: Arial, sans-serif;">

<!-- HEADER -->
<header class="bg-blue-900 text-white flex justify-between items-center p-4">
  <img src="images/banklogo.png" alt="Bank Logo" class="h-20 w-20">
  <h1 class="text-3xl font-bold text-center flex-1">My Online Bank</h1>
  <img src="images/banklogo2.png" alt="Bank Logo 2" class="h-20 w-20">
</header>

<!-- CONTENT -->
<div class="max-w-xl mx-auto mt-10 bg-white rounded-xl shadow-lg p-6">
  <h2 class="text-2xl font-semibold text-center text-blue-700 mb-4">Deposit Funds</h2>

  <form method="POST" action="" class="space-y-4">
    <div>
      <label for="account" class="block font-semibold mb-1">Account Number</label>
      <input type="text" id="account" name="account" class="w-full px-3 py-2 border rounded" required>
    </div>
    <div>
      <label for="amount" class="block font-semibold mb-1">Amount (INR)</label>
      <input type="number" id="amount" name="amount" class="w-full px-3 py-2 border rounded" required min="1">
    </div>
    <div class="text-center">
      <button type="submit" name="deposit" class="bg-blue-700 text-white px-5 py-2 rounded hover:bg-blue-800 transition">Deposit</button>
    </div>
  </form>

  <?php
  if (isset($_POST['deposit'])) {
    $account = htmlspecialchars($_POST['account']);
    $amount = floatval($_POST['amount']);
    echo "<p class='mt-4 text-green-600 font-semibold text-center'>Successfully deposited ₹" . number_format($amount, 2) . " into account $account.</p>";
  }
  ?>
</div>

<!-- FOOTER -->
<footer class="bg-blue-900 text-white text-center mt-10 py-4">
  <div class="flex justify-center space-x-4 items-center">
    <a href="#" class="underline hover:text-blue-300">Privacy Policy</a>
    <a href="mailto:support@mybank.com" class="flex items-center gap-1 hover:text-blue-300">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m0 0l-4 4m4-4l-4-4m12 0h4M16 12l4-4m0 8l-4-4" />
      </svg>
      support@mybank.com
    </a>
  </div>
</footer>

</body>
</html>
