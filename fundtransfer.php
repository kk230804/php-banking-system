<?php
session_start();
require_once('config.php');  // Your PDO connection file

$historyAccounts = [];
$accNum = $_SESSION['AccountNumber'] ?? null;

if ($accNum) {
    try {
        // Fetch CustomerHistory for the logged-in user
        $stmt = $pdo->prepare("SELECT CustomerHistory FROM bankcustomers WHERE AccountNumber = ?");
        $stmt->execute([$accNum]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && !empty($row['CustomerHistory'])) {
            $historyLines = explode("\n", $row['CustomerHistory']);
            $accountNumbers = [];

            foreach ($historyLines as $line) {
                $columns = str_getcsv($line);
                if (isset($columns[3])) {
                    $accountNumbers[] = trim($columns[3]);
                }
            }

            if (!empty($accountNumbers)) {
                $placeholders = str_repeat('?,', count($accountNumbers) - 1) . '?';
                $stmt = $pdo->prepare("SELECT AccountNumber, FirstName FROM bankcustomers WHERE AccountNumber IN ($placeholders)");
                $stmt->execute($accountNumbers);

                $historyAccounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Handle the form submission for transfer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fromAccount = trim($_SESSION['AccountNumber']);
    $toAccount = trim($_POST['toAccount']);
    $amount = (float) $_POST['amount'];
    $remarks = trim($_POST['remarks'] ?? '');

    if ($amount > 0 && !empty($toAccount)) {
        try {
            $pdo->beginTransaction();

            // Check if FromAccount exists and has sufficient balance
            $stmt = $pdo->prepare("SELECT AccountBalance FROM bankcustomers WHERE AccountNumber = ?");
            $stmt->execute([$fromAccount]);
            $sender = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$sender || $sender['AccountBalance'] < $amount) {
                throw new Exception("Insufficient balance or invalid account.");
            }

            // Deduct from sender
            $stmt = $pdo->prepare("UPDATE bankcustomers SET AccountBalance = AccountBalance - ? WHERE AccountNumber = ?");
            $stmt->execute([$amount, $fromAccount]);

            // Add to recipient
            $stmt = $pdo->prepare("UPDATE bankcustomers SET AccountBalance = AccountBalance + ? WHERE AccountNumber = ?");
            $stmt->execute([$amount, $toAccount]);

            // Insert into 'tran' table
            $stmt = $pdo->prepare("INSERT INTO tran (FromAccount, ToAccount, Amount, Remarks, Date) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$fromAccount, $toAccount, $amount, $remarks]);

            $pdo->commit();

            echo "<script>alert('Transfer Successful!'); window.location.href='transfer.php';</script>";
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            echo "<script>alert('Error: " . addslashes($e->getMessage()) . "'); window.location.href='transfer.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Invalid input. Please check your values.'); window.location.href='transfer.php';</script>";
        exit;
    }
}
?>

<!-- HTML Part Starts -->
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Fund Transfer</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

<style>
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

<body>
<!-- Header -->
<header style="background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img alt="Left Logo" class="h-20 w-20" src="images/logoofbank.png" />
    </div>
    <h1 class="text-xl font-bold"><strong>               </strong></h1>
    <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
        <img alt="Right Logo" class="h-20 w-20" src="images/logoofbank.png" />
    </div>
</header>
<div class="navbar">
    <div><strong></strong></div>
    <div class="menu flex items-center">
        <a href="dashboard.php">
            <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;">
                <i class="fas fa-home text-xl"></i> <span class="text-sm">Home</span>
            </button>
        </a>
    </div>
</div>

<section class="bg-gradient-to-r from-[#003366] to-[#00204a] min-h-screen flex flex-col items-center justify-center p-4">
  <header class="bg-[#0f88c6] w-full max-w-md p-4 text-white text-center text-lg font-semibold rounded-t-lg">
    Fund Transfer
  </header>

  <main class="bg-white max-w-md w-full rounded-b-lg shadow-lg p-6">
    <h2 class="text-[#003366] text-xl font-semibold mb-6 text-center">Transfer Funds</h2>

    <form class="space-y-4" method="POST" action="transfer.php">
      <div>
        <label for="fromAccount" class="block text-[#003366] font-medium mb-1">From Account Number</label>
        <input type="text" id="fromAccount" name="fromAccount" class="w-full border border-gray-300 rounded px-3 py-2" value="<?= htmlspecialchars($accNum) ?>" readonly />
      </div>

      <div>
        <label for="toAccount" class="block text-[#003366] font-medium mb-1">Select or Enter Beneficiary Account</label>
        <select id="toAccount" name="toAccount" class="w-full border border-gray-300 rounded px-3 py-2">
          <?php foreach ($historyAccounts as $account): ?>
            <option value="<?= htmlspecialchars($account['AccountNumber']) ?>">
              <?= htmlspecialchars($account['FirstName']) ?> (<?= htmlspecialchars($account['AccountNumber']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label for="amount" class="block text-[#003366] font-medium mb-1">Amount</label>
        <input type="number" id="amount" name="amount" placeholder="Enter amount" class="w-full border border-gray-300 rounded px-3 py-2" required />
      </div>

      <div>
        <label for="remarks" class="block text-[#003366] font-medium mb-1">Remarks</label>
        <input type="text" id="remarks" name="remarks" placeholder="Enter remarks (optional)" class="w-full border border-gray-300 rounded px-3 py-2" />
      </div>

      <button type="submit" class="w-full bg-[#0f88c6] text-white py-2 rounded hover:bg-[#0b5e8a] transition-colors">
        Transfer
      </button>
    </form>
  </main>
</section>

<footer class="w-full bg-[#0892d0] text-white text-center p-10">
    <a href="privacy.php" class="block text-white mb-2"> Privacy Policy</a>
    <p class="flex justify-center items-center gap-2">
        <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
        <a href="mailto:customercare@akolajantabank.com" class="hover:underline">customercare@akolajantabank.com</a>
    </p>
</footer>

<script>
new TomSelect("#toAccount", {
  create: function(input) {
    return { value: input, text: input }
  },
  persist: false,
  sortField: { field: "text", direction: "asc" },
  placeholder: 'Select or enter account number'
});
</script>

</body>
</html>
