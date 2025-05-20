<?php
session_start();

$host = "localhost";
$user = "root";
$password = "pass";
$database = "bankdata";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$AccountNumber = $_SESSION['AccountNumber'] ?? '';

$userInfoSql = "SELECT FirstName, LastName, CustomerHistory FROM bankcustomers WHERE AccountNumber = ?";
$userInfoStmt = $conn->prepare($userInfoSql);
$userInfoStmt->bind_param("s", $AccountNumber);
$userInfoStmt->execute();
$userResult = $userInfoStmt->get_result();
$user = $userResult->fetch_assoc();

$fullName = $user ? htmlspecialchars(($user['FirstName'] ?? '') . ' ' . ($user['LastName'] ?? '')) : 'Guest';
$customerHistoryCsv = $user['CustomerHistory'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mini Statement</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #002855;
            color: #fff;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        header {
            background-color: #0892d0;
            color: white;
            padding: 40px 20px;
            text-align: center;
            position: relative;
        }

        header img {
            height: 80px;
            width: 80px;
        }

        header div.left-logo {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        header div.right-logo {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        .navbar {
            background-color: #21abcd;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }

        .navbar .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
        }

        .navbar h2 {
            margin: 0;
            color: #fff;
        }

        .page-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h2 {
            color: #f8f9fa;
            text-align: center;
            margin: 20px 0;
        }

        table {
            width: 100%;
            border-radius: 8px;
            border-collapse: collapse;
            background: #fff;
            color: #333;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            padding: 10px;
            margin-top: 30px;
            color: #bbb;
        }

        footer {
            width: 100%;
            background-color: #0892d0;
            color: white;
            text-align: center;
            padding: 40px 20px;
        }

        footer a {
            color: white;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        footer img {
            width: 16px;
            height: 16px;
            vertical-align: middle;
        }
    </style>
</head>

<body>

<header>
    <div class="left-logo">
        <img src="images/logoofbank.png" alt="Left Logo">
    </div>
    <h1>Mini Statement</h1>
    <div class="right-logo">
        <img src="images/logoofbank.png" alt="Right Logo">
    </div>
</header>

<div class="navbar">
    <h2>Hello, <?= $fullName ?> 👋</h2>
    <div class="menu">
        <a href="dashboard.php">
            <button style="background-color: #4682b4; color: white; padding: 12px 20px; font-size: 18px; border: none; border-radius: 8px;">
                <i class="fas fa-home" style="margin-right: 5px;"></i>Home
            </button>
        </a>
    </div>
</div>

<div class="page-container">
    <h2>Mini Statement for Account: <?= htmlspecialchars($AccountNumber) ?></h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Amount (Rs)</th>
                <th>To Person</th>
                <th>Account Number</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if (!empty($customerHistoryCsv)) {
            $lines = explode("\n", trim($customerHistoryCsv));
            $firstLineSkipped = false;

            foreach ($lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;

                $fields = str_getcsv($line);
                if (!$firstLineSkipped) {
                    $firstLineSkipped = true;
                    continue;
                }

                $date = htmlspecialchars($fields[0] ?? '');
                $money = number_format((float)($fields[1] ?? 0), 2);
                $toperson = htmlspecialchars($fields[2] ?? '');
                $customerID = htmlspecialchars($fields[3] ?? '');

                echo "<tr>";
                echo "<td>$date</td>";
                echo "<td>Rs. $money</td>";
                echo "<td>$toperson</td>";
                echo "<td>$customerID</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No transactions found.</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <div class="footer">
        • Implemented OTP-based login and mandatory password changes every 365 days<br>
        • Remind customers not to share OTPs, passwords, or user information.<br>
        • Options to Lock or Unlock access and profile password changes.<br>
    </div>
</div>

<footer>
    <a href="privacy.php" class="block text-white mb-2">Privacy Policy</a>
    <p>
        <img src="images/envelope-solid.svg" alt="Email Icon">
        <a href="mailto:customercare@akolajantabank.com">customercare@akolajantabank.com</a>
    </p>
</footer>

</body>
</html>
