<?php
$dsn = 'mysql:host=localhost;dbname=bankdata;charset=utf8mb4';
$db_user = 'root';
$db_pass = 'pass';

try {
    $pdo = new PDO($dsn, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
