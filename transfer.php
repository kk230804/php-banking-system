<?php
session_start();
require_once('config.php');  // Your database connection file

$message = '';  // 🧠 Important: Define it first

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the data from the form
    $fromAccount = $_POST['fromAccount'] ?? null;
    $toAccount = $_POST['toAccount'] ?? null;
    $amount = $_POST['amount'] ?? 0;
    $remarks = $_POST['remarks'] ?? '';

    // Validate the inputs
    if (empty($fromAccount) || empty($toAccount) || $amount <= 0) {
        $message = "⚠️ Invalid input! Ensure all fields are filled correctly.";
    } else {
        $numericFromAccount = preg_replace('/[^0-9]/', '', $fromAccount);
        $numericToAccount = preg_replace('/[^0-9]/', '', $toAccount);

        try {
            // Check accounts
            $stmt = $pdo->prepare("SELECT AccountNumber, AccountBalance FROM bankcustomers WHERE AccountNumber = ?");
            $stmt->execute([$fromAccount]);
            $fromAccountData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$fromAccountData) {
                $message = "❌ From Account not found!";
            } else {
                $stmt = $pdo->prepare("SELECT AccountNumber, AccountBalance FROM bankcustomers WHERE AccountNumber = ?");
                $stmt->execute([$toAccount]);
                $toAccountData = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$toAccountData) {
                    $message = "❌ To Account not found!";
                } else {
                    if ($fromAccountData['AccountBalance'] < $amount) {
                        $message = "⚠️ Insufficient balance!";
                    } else {
                        $pdo->beginTransaction();

                        $stmt = $pdo->prepare("UPDATE bankcustomers SET AccountBalance = AccountBalance - ? WHERE AccountNumber = ?");
                        $stmt->execute([$amount, $fromAccount]);

                        $stmt = $pdo->prepare("UPDATE bankcustomers SET AccountBalance = AccountBalance + ? WHERE AccountNumber = ?");
                        $stmt->execute([$amount, $toAccount]);

                        $stmt = $pdo->prepare("INSERT INTO tran (FromAccount, ToAccount, Amount, Remarks, Date) VALUES (?, ?, ?, ?, NOW())");
                        $stmt->execute([$numericFromAccount, $numericToAccount, $amount, $remarks]);

                        $pdo->commit();
                        $message = "✅ Transfer successful!";
                    }
                }
            }
        } catch (PDOException $e) {
            $pdo->rollBack();
            $message = "❌ Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fund Transfer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-900 to-blue-700 min-h-screen flex flex-col">

<!-- Header -->
<header class="bg-[#0f88c6] text-white text-center text-lg font-semibold p-4">
<div class="flex justify-between items-center p-4">
    <a href="dashboard.php">
            <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;">
                <i class="fas fa-home text-xl"></i> <span class="text-sm">Home</span>
        </button>
    </a>
</div>
    
</header>

<!-- Main Content -->
<main class="flex-grow flex flex-col items-center justify-center p-4">
    <?php if (!empty($message)): ?>
        <div class="mb-4 p-3 rounded text-center <?= strpos($message, '✅') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>
    <!-- (your form goes here later if needed) -->
</main>

<!-- Footer -->
<footer class="bg-[#0892d0] text-white text-center p-4">
    <a href="privacy.php" class="block text-white mb-2">Privacy Policy</a>
    <p class="flex justify-center items-center gap-2">
        <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
        <a href="mailto:customercare@akolajantabank.com" class="hover:underline">customercare@akolajantabank.com</a>
    </p>
</footer>

</body>

</html>