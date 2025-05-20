<?php
// Database config
$host = 'localhost';
$db   = 'bankdata';
$user = 'root';
$pass = 'pass';
$charset = 'utf8mb4';

// Connect to DB
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}

// Get POST data
$fromAccount = $_POST['fromAccount'];
$toAccount = $_POST['toAccount'];
$amount = $_POST['amount'];

if ($amount <= 0) {
    echo "Invalid transfer amount.";
    exit;
}

try {
    // Start transaction
    $pdo->beginTransaction();

    // Check balance of sender
    $stmt = $pdo->prepare("SELECT AccountBalance FROM bankcustomers WHERE AccountNumber = ?");
    $stmt->execute([$fromAccount]);
    $fromUser = $stmt->fetch();

    // Check balance of receiver
    $stmt = $pdo->prepare("SELECT AccountBalance FROM bankcustomers WHERE AccountNumber = ?");
    $stmt->execute([$toAccount]);
    $toUser = $stmt->fetch();

    // Ensure sender has sufficient funds
    if (!$fromUser || $fromUser['AccountBalance'] < $amount) {
        throw new Exception("Insufficient funds.");
    }

    // Deduct from sender
    $stmt = $pdo->prepare("UPDATE bankcustomers SET AccountBalance = AccountBalance - ? WHERE AccountNumber = ?");
    $stmt->execute([$amount, $fromAccount]);

    // Add to recipient
    $stmt = $pdo->prepare("UPDATE bankcustomers SET AccountBalance = AccountBalance + ? WHERE AccountNumber = ?");
    $stmt->execute([$amount, $toAccount]);

    // Commit transaction
    $pdo->commit();

    echo "Fund transfer successful!";
} catch (Exception $e) {
    // Rollback transaction if error occurs
    $pdo->rollBack();
    echo "Transfer failed: " . $e->getMessage();
}
?>
