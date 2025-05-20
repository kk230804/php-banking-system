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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fund Transfer</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="max-w-lg mx-auto mt-10 p-5 bg-white shadow-md rounded-lg">
        <h1 class="text-2xl font-semibold text-center text-blue-600">Transfer Funds</h1>
        
        <!-- Step 1: Select Recipient -->
        <div id="step-1" class="mb-5">
            <label class="block text-gray-700">Select Recipient (Account Number):</label>
            <select id="recipient" class="w-full px-3 py-2 mt-2 border rounded-md">
                <option value="">Select Account</option>
                <?php
                    $stmt = $pdo->query("SELECT AccountNumber FROM bankcustomers WHERE AccountNumber LIKE 'AC%'");
                    while ($row = $stmt->fetch()) {
                        echo "<option value='" . $row['AccountNumber'] . "'>" . $row['AccountNumber'] . "</option>";
                    }
                ?>
            </select>
        </div>
        
        <!-- Step 2: Enter Amount -->
        <div id="step-2" class="mb-5 hidden">
            <label class="block text-gray-700">Amount (₹):</label>
            <input type="number" id="amount" class="w-full px-3 py-2 mt-2 border rounded-md" placeholder="Enter amount" min="1">
        </div>
        
        <!-- Step 3: Confirmation -->
        <div id="step-3" class="hidden">
            <h2 class="text-xl font-semibold text-center text-blue-600">Confirm Transfer</h2>
            <p><strong>From Account:</strong> <span id="from-account"></span></p>
            <p><strong>To Account:</strong> <span id="to-account"></span></p>
            <p><strong>Amount:</strong> ₹<span id="transfer-amount"></span></p>
            <button id="confirm-transfer" class="w-full bg-blue-600 text-white py-2 mt-4 rounded-md">Confirm Transfer</button>
        </div>
        
        <!-- Error/Success Message -->
        <div id="transfer-status" class="hidden text-center mt-5"></div>
    </div>

    <script>
        $(document).ready(function() {
            let fromAccount = "AC000123456"; // Example current account number for the sender
            
            // Step 1: Recipient selection
            $('#recipient').change(function() {
                let recipientAccount = $(this).val();
                if (recipientAccount) {
                    // Show step 2 (Amount input)
                    $('#step-2').removeClass('hidden');
                    $('#step-1').addClass('hidden');
                    $('#to-account').text(recipientAccount); // Set recipient account on confirmation page
                } else {
                    $('#step-2').addClass('hidden');
                    $('#step-1').removeClass('hidden');
                }
            });

            // Step 2: Amount input validation
            $('#amount').on('input', function() {
                let amount = $(this).val();
                if (amount > 0) {
                    // Show step 3 (Confirmation step)
                    $('#step-3').removeClass('hidden');
                    $('#transfer-amount').text(amount); // Set transfer amount on confirmation page
                } else {
                    $('#step-3').addClass('hidden');
                }
            });

            // Step 3: Confirm transfer
            $('#confirm-transfer').click(function() {
                let amount = $('#amount').val();
                let recipientAccount = $('#recipient').val();

                if (amount > 0 && recipientAccount) {
                    // AJAX request to process the transfer
                    $.ajax({
                        url: 'process_transfer.php',
                        method: 'POST',
                        data: {
                            fromAccount: fromAccount,
                            toAccount: recipientAccount,
                            amount: amount
                        },
                        success: function(response) {
                            $('#transfer-status').removeClass('hidden').text(response);
                            $('#step-3').addClass('hidden'); // Hide confirmation step
                        }
                    });
                } else {
                    $('#transfer-status').removeClass('hidden').text('Please fill in all the details.');
                }
            });
        });
    </script>

</body>
</html>
