<?php
session_start();
if (!isset($_SESSION['AccountNumber'])) {
    header("Location: login.php");
    exit();
}
$accountNumber = $_SESSION['AccountNumber'];
$message = "";

// Database connection using PDO
try {
    $pdo = new PDO("mysql:host=localhost;dbname=bankdata", "root", "pass");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Also connecting via MySQLi to fetch user info
$conn = new mysqli("localhost", "root", "pass", "bankdata");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user info
$userInfoSql = "SELECT FirstName, LastName, CustomerHistory FROM bankcustomers WHERE AccountNumber = ?";
$userInfoStmt = $conn->prepare($userInfoSql);
$userInfoStmt->bind_param("s", $accountNumber);
$userInfoStmt->execute();
$userResult = $userInfoStmt->get_result();
$user = $userResult->fetch_assoc();

$fullName = $user ? htmlspecialchars(($user['FirstName'] ?? '') . ' ' . ($user['LastName'] ?? '')) : 'Guest';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=bankdata", "root", "pass");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch Mutual Funds
    $stmtMF = $pdo->query("SELECT * FROM mutual_funds");
    $mutualFunds = $stmtMF->fetchAll(PDO::FETCH_ASSOC);

    // Fetch Fixed Deposits
    $stmtFD = $pdo->query("SELECT * FROM fixed_deposits");
    $fixedDeposits = $stmtFD->fetchAll(PDO::FETCH_ASSOC);

    // Handle Investment Submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invest_type'])) {
        $investmentType = $_POST['invest_type'];
        $referenceId = $_POST['reference_id'];
        $amount = $_POST['amount'];

        $insert = $pdo->prepare("INSERT INTO user_investments (account_number, investment_type, reference_id, amount) VALUES (?, ?, ?, ?)");
        $insert->execute([$accountNumber, $investmentType, $referenceId, $amount]);

        echo "<script>alert('Investment successful!'); window.location.href='investment.php';</script>";
        exit();
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Investments</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
 <style>
        .navbar {
            background-color: #21abcd;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body class="bg-[#002855]">
  <header style="background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Left Logo" style="height: 80px; width: 80px;">
    </div>

    <h1 style="margin: 0; font-size: 24px;">                               </h1>

    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
    </div>
</header>

<header class="navbar">
    <h2>Hello, <?= $fullName ?> 👋</h2>
    <div class="menu">
        <a href="dashboard.php">
            <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 12px 20px; font-size: 18px; border: none; border-radius: 8px;">
                <i class="fas fa-home" style="font-size: 20px; margin-right: 5px;"></i> Home
            </button>
        </a>
    </div>
</header>

  <div class="p-6 max-w-7xl mx-auto">
        <!-- Mutual Funds -->
        <h2 class="text-xl text-white font-bold mt-4">Mutual Funds</h2>
        <table class="w-full mt-2 bg-white shadow rounded">
            <thead class="bg-blue-100">
                <tr><th class="p-2">Fund Name</th><th>Category</th><th>NAV</th><th>1Y Return</th><th>Expense Ratio</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php foreach ($mutualFunds as $fund): ?>
                <tr class="text-center border-b">
                    <td class="p-2"><?= htmlspecialchars($fund['FundName']) ?></td>
                    <td><?= htmlspecialchars($fund['Category']) ?></td>
                    <td>₹<?= number_format($fund['NAV'], 2) ?></td>
                    <td><?= $fund['Return1Y'] ?>%</td>
                    <td><?= $fund['ExpenseRatio'] ?>%</td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="invest_type" value="Mutual Fund">
                            <input type="hidden" name="reference_id" value="<?= $fund['FundID'] ?>">
                            <input type="number" name="amount" placeholder="Amount" required class="border p-1 w-24">
                            <button type="submit" class="bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700">Invest</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Fixed Deposits -->
        <h2 class="text-xl text-white font-bold mt-8">Fixed Deposits</h2>
        <table class="w-full mt-2 bg-white shadow rounded">
            <thead class="bg-blue-100">
                <tr><th class="p-2">Tenure</th><th>Interest Rate</th><th>Minimum Amount</th><th>Action</th></tr>
            </thead>
            <tbody>
                <?php foreach ($fixedDeposits as $fd): ?>
                <tr class="text-center border-b">
                    <td class="p-2"><?= $fd['Tenure'] ?></td>
                    <td><?= $fd['InterestRate'] ?>%</td>
                    <td>₹<?= number_format($fd['MinAmount'], 2) ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="invest_type" value="Fixed Deposit">
                            <input type="hidden" name="reference_id" value="<?= $fd['FDID'] ?>">
                            <input type="number" name="amount" placeholder="Amount" required class="border p-1 w-24">
                            <button type="submit" class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700">Invest</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Other Investment Options -->
        <div class="mt-10 bg-white p-4 rounded shadow">
            <h2 class="text-xl font-bold mb-2">Other Investment Options</h2>
            <ul class="list-disc list-inside text-gray-700">
                <li><strong>Stock Trading:</strong> Invest in stocks and ETFs with our integrated trading platform.</li>
                <li><strong>Bonds & Gold:</strong> Safe options with steady returns over time.</li>
                <li><strong>ULIPs:</strong> Insurance-linked investment plans that combine protection and savings.</li>
            </ul>
        </div>

        <!-- Investment Calculators -->
        <div class="mt-10 grid grid-cols-2 gap-6">
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-bold">SIP Calculator</h3>
                <form oninput="sipResult.value = Math.round(monthly.value * (((1 + rate.value/100) ** (years.value * 12) - 1) / (rate.value/100)) * (1 + rate.value/100))">
                    Monthly Investment: <input type="number" id="monthly" value="1500" class="border w-full p-1">
                    <br>Rate (%): <input type="number" id="rate" value="5" class="border w-full p-1">
                    <br>Years: <input type="number" id="years" value="2" class="border w-full p-1">
                    <br><b>Future Value:</b> ₹<output name="sipResult">0</output>
                </form>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-bold">FD Calculator</h3>
                <form oninput="fdResult.value = Math.round(fdAmt.value * (1 + (fdRate.value/100 * fdYears.value)))">
                    Amount: <input type="number" id="fdAmt" value="10000" class="border w-full p-1">
                    <br>Rate (%): <input type="number" id="fdRate" value="5" class="border w-full p-1">
                    <br>Years: <input type="number" id="fdYears" value="2" class="border w-full p-1">
                    <br><b>Maturity Amount:</b> ₹<output name="fdResult">0</output>
                </form>
            </div>
        </div>
    </div>

<br>
 <footer style="width: 100%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
    <div class="text-center">
        <a href="privacy.php" class="block text-white mb-2"> Privacy Policy</a>
        <p class="flex justify-center items-center gap-2 text-white text-lg">
            <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
            <a href="mailto:customercare@akolajantabank.com" class="hover:underline">customercare@akolajantabank.com</a>
        </p>
    </div>
</footer>

  <script>
    function calculateSIP() {
      const amount = parseFloat(document.getElementById('sipAmount').value);
      const rate = parseFloat(document.getElementById('sipReturn').value) / 100 / 12;
      const years = parseFloat(document.getElementById('sipYears').value);
      const months = years * 12;
      const futureValue = amount * (((Math.pow(1 + rate, months)) - 1) * (1 + rate)) / rate;
      document.getElementById('sipResult').innerText = `Future Value: ₹${futureValue.toFixed(2)}`;
    }

    function calculateFD() {
      const principal = parseFloat(document.getElementById('fdPrincipal').value);
      const rate = parseFloat(document.getElementById('fdRate').value) / 100;
      const time = parseFloat(document.getElementById('fdTime').value);
      const maturity = principal * Math.pow(1 + rate, time);
      document.getElementById('fdResult').innerText = `Maturity Amount: ₹${maturity.toFixed(2)}`;
    }
  </script>
</body>
</html>
