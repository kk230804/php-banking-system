<?php
// deposit.php

$pin = $_GET['pin'] ?? '';

$message = '';
$currentBalance = 0;

try {
    $conn = new PDO("mysql:host=localhost;dbname=bankdata", "root", "pass");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get current balance
    $stmt = $conn->prepare("SELECT 
        SUM(CASE WHEN Type = 'Deposit' THEN Amount ELSE 0 END) -
        SUM(CASE WHEN Type = 'Withdrawal' THEN Amount ELSE 0 END) AS Balance
        FROM bank WHERE AccountNumber = ?");
    $stmt->execute([$pin]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentBalance = $result['Balance'] ?? 0;

    // Handle deposit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $amount = $_POST['amount'] ?? '';
        if (!$amount || !is_numeric($amount) || $amount <= 0) {
            $message = "<p class='text-red-600 font-semibold text-center mt-4'>Enter a valid deposit amount.</p>";
        } else {
            $stmt = $conn->prepare("INSERT INTO bank (AccountNumber, Date, Type, Amount) VALUES (?, NOW(), 'Deposit', ?)");
            $stmt->execute([$pin, $amount]);

            $currentBalance += $amount;
            $message = "<p class='text-green-600 font-semibold text-center mt-4'>Rs. $amount Deposited Successfully!</p>";
        }
    }
} catch (PDOException $e) {
    $message = "<p class='text-red-600 font-semibold text-center mt-4'>Error: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Deposit - Bank App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-cover bg-center" style="background-image: url('images/back2.png');">

    <!-- ✅ Custom Header -->
    <div class="bg-blue-900 text-white py-4 flex justify-between items-center px-6">
        <img src="images/logo-left.png" alt="Bank Logo Left" class="w-20 h-20">
        <h1 class="text-3xl font-bold text-center flex-grow -ml-20">BANKING APPLICATION - DEPOSIT</h1>
        <img src="images/logo-right.png" alt="Bank Logo Right" class="w-20 h-20">
    </div>

    <!-- ✅ Deposit Form -->
    <div class="flex justify-center items-center min-h-[calc(100vh-160px)] px-4">
        <form method="POST" class="bg-white bg-opacity-90 shadow-lg p-8 rounded-xl w-full max-w-md text-center">
            <h2 class="text-xl font-semibold mb-2 text-blue-800">Current Balance</h2>
            <p class="text-2xl font-bold mb-6 text-green-700">Rs. <?= number_format($currentBalance, 2) ?></p>

            <h2 class="text-xl font-semibold mb-4 text-blue-800">Enter Amount to Deposit</h2>
            <input type="number" name="amount" placeholder="Enter amount" class="w-full px-4 py-2 mb-4 border border-gray-300 rounded-md text-center text-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>

            <div class="flex justify-center space-x-4">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Deposit</button>
                <a href="transactions.php?pin=<?= htmlspecialchars($pin) ?>" class="bg-gray-600 text-white px-6 py-2 rounded hover:bg-gray-800 transition">Back</a>
            </div>

            <?= $message ?>
        </form>
    </div>

    <!-- ✅ Custom Footer -->
    <footer class="bg-blue-900 text-white text-center py-4 mt-10">
        <a href="#" class="underline">Privacy Policy</a> |
        <span class="ml-2"><i class="fa fa-envelope"></i> support@bankapp.com</span>
    </footer>

</body>
</html>
