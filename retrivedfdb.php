<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

// Database connection parameters
$dsn = 'mysql:host=localhost;dbname=Bankdata';
$db_user = 'root';
$db_pass = 'MYsql3@pro';

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=localhost;port=3308;dbname=bankdata", "root", "MYsql3@pro");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve user data
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $_SESSION['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Display user information
        echo "Welcome, " . htmlspecialchars($user['username']) . "!";
        // You can also display other user information here
    } else {
        echo "User  not found.";
    }

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>