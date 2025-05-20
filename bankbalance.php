<?php
// Mock user account data
$accounts = [
    "1234567890" => [
        "name" => "John Doe",
        "balance" => 5000.75
    ],
    "9876543210" => [
        "name" => "Jane Smith",
        "balance" => 10250.50
    ]
];

// Function to get account balance
function getAccountBalance($accountNumber, $accounts) {
    if (array_key_exists($accountNumber, $accounts)) {
        return $accounts[$accountNumber]['balance'];
    } else {
        return false;
    }
}

// Simulate getting account number (could be from form input)
$accountNumber = $_GET['account'] ?? null;

if ($accountNumber) {
    $balance = getAccountBalance($accountNumber, $accounts);
    
    if ($balance !== false) {
        echo "Account Number: " . htmlspecialchars($accountNumber) . "<br>";
        echo "Balance: $" . number_format($balance, 2);
    } else {
        echo "Account not found.";
    }
} else {
    echo "Please provide an account number.";
}
?>