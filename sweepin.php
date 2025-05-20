<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['AccountNumber'])) {
    header("Location: login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "pass", "bankdata");

$account_no = $_SESSION['AccountNumber'];
$message = "";
$balanceDisplay = "";

// Handle POST actions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0;
    $action = $_POST['action'];

    $res = $conn->query("SELECT AccountBalance FROM bankcustomers WHERE AccountNumber = '$account_no'");
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $balance = (float)$row['AccountBalance'];
        $date = date('Y-m-d');
        $desc = ucfirst($action) . " ₹$amount";

        if ($action === "withdraw") {
            if ($balance >= $amount) {
                $newBalance = $balance - $amount;
                $conn->query("UPDATE bankcustomers SET AccountBalance = $newBalance WHERE AccountNumber = '$account_no'");
                $conn->query("INSERT INTO transactions (AccountNumber, type, amount, date, description) VALUES ('$account_no', 'debit', $amount, '$date', '$desc')");
                $message = "✅ ₹$amount withdrawn successfully.";
            } else {
                $message = "❌ Insufficient balance!";
            }
        } elseif ($action === "credit") {
            $newBalance = $balance + $amount;
            $conn->query("UPDATE bankcustomers SET AccountBalance = $newBalance WHERE AccountNumber = '$account_no'");
            $conn->query("INSERT INTO transactions (AccountNumber, type, amount, date, description) VALUES ('$account_no', 'credit', $amount, '$date', '$desc')");
            $message = "✅ ₹$amount credited successfully.";
        } elseif ($action === "check_balance") {
            $balanceDisplay = "💰 Balance in account <strong>$account_no</strong>: ₹$balance";
        }
    } else {
        $message = "❌ Account not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Transaction Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body, html {
            background: url(images/back2.png) no-repeat fixed center;
            background-size: cover;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
        }
        .box {
            background: rgba(255, 255, 255, 0.95);
            max-width: 900px;
            margin: 2rem auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.1);
        }
        .scroll-table {
            overflow-x: auto;
        }
    </style>
</head>
<body>

<!-- Header -->
<header style="background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img alt="Left Logo" class="h-20 w-20" src="images/logoofbank.png" />
    </div>
    <h1 class="text-xl font-bold"><strong>Transaction Page</strong></h1>
    <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
        <img alt="Right Logo" class="h-20 w-20" src="images/logoofbank.png" />
    </div>
</header>

<!-- Navbar -->
<div class="navbar" style="background-color: #21abcd; padding: 10px 30px; display: flex; justify-content: space-between; align-items: center;">
    <div><strong>Transaction Services</strong></div>
    <div class="menu flex items-center">
        
        <a href="dashboard.php">
            <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;">
                <i class="fas fa-home text-xl"></i>
                <span class="text-sm">Home</span>
            </button>
        </a>
    </div>
</div>

<!-- Main Transaction Box -->
<div class="box">
    <?php if (!empty($message)) echo "<p class='text-center font-semibold text-green-700'>$message</p>"; ?>
    <?php if (!empty($balanceDisplay)) echo "<p class='text-center text-blue-800 font-semibold'>$balanceDisplay</p>"; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="font-semibold">Account Number:</label>
            <input type="text" name="account_no" value="<?= htmlspecialchars($account_no) ?>" readonly class="w-full border p-2 rounded bg-gray-100 cursor-not-allowed" />
        </div>

        <div>
            <label class="font-semibold">Amount (₹):</label>
            <input type="number" name="amount" min="1" class="w-full border p-2 rounded" />
        </div>

        <div class="flex flex-wrap gap-4">
            <button name="action" value="withdraw" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">💸 Withdraw</button>
            <button name="action" value="credit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">💰 Credit</button>
            <button name="action" value="check_balance" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded">📊 Check Balance</button>
        </div>
    </form>
</div>

<!-- Transaction History -->
<div class="box scroll-table">
    <h2 class="text-xl font-bold mb-3">📋 Your Recent Transactions</h2>
    <table class="min-w-full border-collapse border border-gray-300 text-sm">
        <thead class="bg-gray-200">
            <tr>
                <th class="border px-3 py-1">Type</th>
                <th class="border px-3 py-1">Amount</th>
                <th class="border px-3 py-1">Description</th>
                <th class="border px-3 py-1">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $txn = $conn->query("SELECT type, amount, description, date FROM transactions WHERE AccountNumber = '$account_no' ORDER BY id DESC LIMIT 50");
            while ($row = $txn->fetch_assoc()) {
                echo "<tr class='hover:bg-gray-100'>
                        <td class='border px-2 py-1'>{$row['type']}</td>
                        <td class='border px-2 py-1'>₹{$row['amount']}</td>
                        <td class='border px-2 py-1'>{$row['description']}</td>
                        <td class='border px-2 py-1'>{$row['date']}</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
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
