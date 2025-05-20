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

// Fetch user info
$userInfoSql = "SELECT FirstName, LastName FROM bankcustomers WHERE AccountNumber = ?";
$userInfoStmt = $conn->prepare($userInfoSql);
$userInfoStmt->bind_param("s", $AccountNumber);
$userInfoStmt->execute();
$userResult = $userInfoStmt->get_result();
$user = $userResult->fetch_assoc();

$fullName = $user ? htmlspecialchars(($user['FirstName'] ?? '') . ' ' . ($user['LastName'] ?? '')) : 'Guest';

$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $LoanType = $_POST['LoanType'] ?? '';
    $LoanAmount = $_POST['LoanAmount'] ?? '';
    $LoanTenure = $_POST['LoanTenure'] ?? '';
    $LoanStatus = 'Pending';
    $ITRNumber = $_POST['ITRNumber'] ?? '';
    $Profession = $_POST['Profession'] ?? '';
    $LoanReason = $_POST['LoanReason'] ?? '';

    $updateQuery = "UPDATE bankcustomers SET LoanType=?, LoanAmount=?, LoanTenure=?, LoanStatus=?, ITRNumber=?, Profession=?, LoanReason=? WHERE AccountNumber=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sdssssss", $LoanType, $LoanAmount, $LoanTenure, $LoanStatus, $ITRNumber, $Profession, $LoanReason, $AccountNumber);

    if ($stmt->execute()) {
        $successMessage = "Loan application submitted successfully!";
    } else {
        $successMessage = "Failed to submit loan application.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Loan Application</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #002855;
            color: white;
        }
        .form-container {
            background: white;
            color: black;
            padding: 30px;
            margin: 40px auto;
            border-radius: 8px;
            width: 60%;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background-color: #0892d0;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 6px;
            margin-top: 20px;
            cursor: pointer;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .navbar {
	    width: 100%;
            background-color: #21abcd;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar .menu a {
               width: 100%;

            text-decoration: none;
            color: #333;
        }
        footer {
            width: 100%;
            background-color: #0892d0;
            color: white;
            text-align: center;
            padding: 40px;
        }
        #emiDisplay {
            font-weight: bold;
            margin-top: 10px;
            color: green;
        }
    </style>
</head>

<body>

<header style="width: 100%; background-color: #0892d0; color: white; padding: 40px; text-align: center; position: relative;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Left Logo" style="height: 80px; width: 80px;">
    </div>
    <h1 style="margin: 0;">Loan Application</h1>
    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
    </div>
</header>

<div class="navbar">
    <h2>Hello, <?= $fullName ?> 👋</h2>
    <div class="menu">
        <a href="dashboard.php">
            <button><i class="fas fa-home"></i> Home</button>
        </a>
    </div>
</div>

<div class="form-container">
    <h2>Apply for a Loan</h2>

    <?php if ($successMessage): ?>
        <div class="success"><?= htmlspecialchars($successMessage) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="LoanType">Loan Type</label>
        <select name="LoanType" id="LoanType" required onchange="handleLoanTypeChange(this)">
            <option value="">-- Select --</option>
            <option value="Home">Home</option>
            <option value="Car">Car</option>
            <option value="Personal">Personal</option>
            <option value="Education">Education</option>
        </select>

        <label for="LoanAmount">Loan Amount</label>
        <input type="number" name="LoanAmount" id="LoanAmount" step="0.01" required>

        <label for="LoanTenure">Tenure (Years)</label>
        <input type="number" name="LoanTenure" id="LoanTenure" required>

        <div id="emiDisplay"></div>

        <div id="itr-section" style="display: none;">
            <label for="ITRNumber">ITR Number</label>
            <input type="text" name="ITRNumber" id="ITRNumber">
        </div>

        <label for="Profession">Profession</label>
        <select name="Profession" required>
            <option value="">-- Select --</option>
            <option value="Salaried">Salaried</option>
            <option value="Self-employed">Self-employed</option>
            <option value="Business">Business</option>
            <option value="Student">Student</option>
            <option value="Other">Other</option>
        </select>

        <label for="LoanReason">Reason for Loan</label>
        <textarea name="LoanReason" placeholder="E.g., Buying a car, college fees, etc."></textarea>

        <button type="submit">Apply for Loan</button>
    </form>
</div>

<!-- Footer -->
<footer style="width: 100%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
    <div class="text-center">
        <a href="privacy.php" class="block text-white mb-2"> Privacy Policy</a>
        <p class="flex justify-center items-center gap-2 text-white text-lg">
            <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
            <a href="mailto:customercare@akolajantabank.com" class="hover:underline">customercare@akolajantabank.com</a>
        </p>
    </div>
</footer>


<script>
    function handleLoanTypeChange(select) {
        const itrSection = document.getElementById("itr-section");
        itrSection.style.display = (select.value === "Home") ? "block" : "none";
    }

    function calculateEMI() {
        const amount = parseFloat(document.getElementById("LoanAmount").value);
        const tenure = parseFloat(document.getElementById("LoanTenure").value);
        const rate = 0.10 / 12; // 10% annual interest → monthly

        const emiDisplay = document.getElementById("emiDisplay");

        if (!isNaN(amount) && !isNaN(tenure) && tenure > 0) {
            const months = tenure * 12;
            const emi = (amount * rate * Math.pow(1 + rate, months)) / (Math.pow(1 + rate, months) - 1);
            const total = emi * months;

            emiDisplay.innerHTML = `
                Monthly EMI: ₹${emi.toFixed(2)}<br>
                Total Repayable Amount: ₹${total.toFixed(2)}
            `;
        } else {
            emiDisplay.innerHTML = "";
        }
    }

    window.onload = function () {
        document.getElementById("LoanAmount").addEventListener("input", calculateEMI);
        document.getElementById("LoanTenure").addEventListener("input", calculateEMI);
    };
</script>

</body>
</html>
