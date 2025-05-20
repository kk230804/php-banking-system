<?php
session_start();
$error = '';

// Database connection parameters
$dsn = 'mysql:host=localhost;dbname=Bankdata';
$db_user = 'root';
$db_pass = 'MYsql3@pro';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $AccountNumber = $_POST['AccountNumber'] ?? '';
    $MPIN = $_POST['MPIN'] ?? '';
    $captcha = $_POST['captcha'] ?? '';

    // Simple captcha check (real one should be dynamic)
    if (strtolower($captcha) !== 'abc123') {
        $error = "Invalid captcha!";
    } else {
        try {
            // Create a new PDO instance
            $pdo = new PDO("mysql:host=localhost;port=3308;dbname=bankdata", "root", "MYsql3@pro");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Check if the user already exists
            $stmt = $pdo->prepare("SELECT * FROM users WHERE AccountNumber = :AccountNumber");
            $stmt->execute([':AccountNumber' => $AccountNumber]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // User exists, check password
                if (password_verify($password, $user['password'])) {
                    // Password is correct, log the user in
                    $_SESSION['loggedin'] = true;
                    $_SESSION['AccountNumber'] = $AccountNumber; // Store AccountNumber in session
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $error = "Incorrect password!";
                }
            } else {
                // User does not exist, insert new user
                $stmt = $pdo->prepare("INSERT INTO users (AccountNumber, password, captcha) VALUES (:AccountNumber, :password, :captcha)");
                $stmt->execute([
                    ':AccountNumber' => $AccountNumber,
                    ':password' => password_hash($password, PASSWORD_DEFAULT), // Hash the password
                    ':captcha' => $captcha
                ]);

                // Log the user in after registration
                $_SESSION['loggedin'] = true;
                $_SESSION['AccountNumber'] = $AccountNumber; // Store AccountNumber in session
                header("Location: dashboard.php");
                exit;
            }

        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>