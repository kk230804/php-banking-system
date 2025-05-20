<?php
// Example balances (you can replace this with database balances)
$senderBalance = 5000;
$receiverBalance = 3000;

// Amount to transfer
$transferAmount = 1500;

// Function to send money
function sendMoney(&$senderBalance, &$receiverBalance, $transferAmount) {
    if ($transferAmount <= 0) {
        return "Invalid amount.";
    }

    if ($senderBalance < $transferAmount) {
        return "Insufficient funds.";
    }

    // Transfer process
    $senderBalance -= $transferAmount;
    $receiverBalance += $transferAmount;

    return "Money transferred successfully.";
}

// Call the function
$result = sendMoney($senderBalance, $receiverBalance, $transferAmount);

// Output
echo $result . "<br><br>";
echo "Sender balance: $" . $senderBalance . "<br>";
echo "Receiver balance: $" . $receiverBalance;
?>