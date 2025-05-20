<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$db   = 'bankdata';
$user = 'root';
$pass = 'pass';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    $sql = "INSERT INTO bankcustomers (AccountNumber, FirstName, MiddleName, LastName, DateOfBirth, AccountBalance)
            VALUES (:acc, :fn, :mn, :ln, :dob, :bal)";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':acc' => '1009',
        ':fn'  => 'Sneha',
        ':mn'  => 'Raj',
        ':ln'  => 'Mehta',
        ':dob' => '1998-03-12',
        ':bal' => 6200.00
    ]);

    echo "<h3 style='color:green;'>✅ Sneha added — Age auto-calculated by trigger!</h3>";

} catch (PDOException $e) {
    echo "<h3 style='color:red;'>❌ Error: " . $e->getMessage() . "</h3>";
}
?>
