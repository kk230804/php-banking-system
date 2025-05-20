<?php
// config.php

$host = 'localhost';
$db   = 'bankdata';
$user = 'root';
$pass = 'pass'; // agar password set kiya ho to yahan likh
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo "Database Connection Failed: " . $e->getMessage();
    exit;
}
?>
