<?php
session_start();
if (!isset($_SESSION['AccountNumber'])) {
    header("Location: login.php");
    exit;
}

$AccountNumber = $_SESSION['AccountNumber'];
$fullName = 'Customer';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=bankdata", "root", "pass");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT FirstName, LastName FROM bankcustomers WHERE AccountNumber = ?");
    $stmt->execute([$AccountNumber]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) $fullName = htmlspecialchars($user['FirstName'] . ' ' . $user['LastName']);
} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage());
}

$conn = new mysqli("localhost", "root", "pass", "bankdata");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') $message = addPolicy($conn, $AccountNumber);
    elseif ($action === 'pay') $message = payPremium($conn);
    elseif ($action === 'cancel') $message = cancelPolicy($conn);
    elseif ($action === 'update') $message = updatePolicy($conn);
}

function generatePolicyId($conn) {
    do {
        $id = 'POL' . rand(100000, 999999);
        $stmt = $conn->prepare("SELECT policy_id FROM insurance_policies WHERE policy_id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->store_result();
    } while ($stmt->num_rows > 0);
    return $id;
}

function addPolicy($conn, $acc) {
    $id = generatePolicyId($conn);
    $type = $_POST['policy_type'] ?? '';
    $amt = floatval($_POST['premium_amount'] ?? 0);
    $due = $_POST['due_date'] ?? '';
    if (!$type || !$amt || !$due) return "<div class='msg error'>Please fill all fields.</div>";
    $stmt = $conn->prepare("INSERT INTO insurance_policies (policy_id, customer_id, policy_type, premium_amount, due_date, status) VALUES (?, ?, ?, ?, ?, 'Active')");
    $stmt->bind_param("sssds", $id, $acc, $type, $amt, $due);
    return $stmt->execute() ? "<div class='msg success'>Policy Added (ID: $id)</div>" : "<div class='msg error'>Error: {$stmt->error}</div>";
}

function payPremium($conn) {
    $id = $_POST['policy_id'] ?? '';
    if (!$id) return "<div class='msg error'>Please enter Policy ID.</div>";
    $stmt = $conn->prepare("UPDATE insurance_policies SET due_date = DATE_ADD(due_date, INTERVAL 1 YEAR) WHERE policy_id = ?");
    $stmt->bind_param("s", $id);
    return $stmt->execute() ? "<div class='msg success'>Premium Paid. Due Date Extended</div>" : "<div class='msg error'>Error: {$stmt->error}</div>";
}

function cancelPolicy($conn) {
    $id = $_POST['policy_id'] ?? '';
    if (!$id) return "<div class='msg error'>Please enter Policy ID.</div>";
    $stmt = $conn->prepare("UPDATE insurance_policies SET status = 'Cancelled' WHERE policy_id = ?");
    $stmt->bind_param("s", $id);
    return $stmt->execute() ? "<div class='msg success'>Policy Cancelled</div>" : "<div class='msg error'>Error: {$stmt->error}</div>";
}

function updatePolicy($conn) {
    $id = $_POST['policy_id'] ?? '';
    $amount = floatval($_POST['new_premium'] ?? 0);
    if (!$id || !$amount) return "<div class='msg error'>Please enter all details.</div>";
    $stmt = $conn->prepare("UPDATE insurance_policies SET premium_amount = ? WHERE policy_id = ?");
    $stmt->bind_param("ds", $amount, $id);
    return $stmt->execute() ? "<div class='msg success'>Premium Updated</div>" : "<div class='msg error'>Error: {$stmt->error}</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <title> Insurance service </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #002855;
            color: #fff;
        }
        h2 {
            color: #f8f9fa;
        }
        table {
   	 margin: 0 auto; /* Center horizontally */
    	 width: 80%;
    	 border-radius: 8px;
    	 border-collapse: collapse;
   	 background: #fff;
   	 padding: 40px;
   	 color: #333;
   	 box-shadow: 0 0 10px rgba(0,0,0,0.1);
	}

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #2c3e50;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .navbar {
            background-color: #21abcd;
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
	.navbar .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
        }
       
        .footer {
            text-align: center;
            font-size: 12px;
            padding: 10px;
            margin-top: 30px;
            color: #bbb;
        }

	.container {
    width: 80%;
    max-width: 900px;
    margin: 40px auto;
    padding: 30px;
    background: #f9f9f9;
    color: #333;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
}

.container h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #002855;
}

form {
    margin-bottom: 25px;
}

input[type="text"],
input[type="number"],
input[type="date"],
select {
    width: 100%;
    padding: 10px;
    margin-top: 6px;
    margin-bottom: 16px;
    border: 1px solid #ccc;
    border-radius: 6px;
}

button {
    padding: 12px;
    font-size: 16px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.msg.success {
    background-color: #d4edda;
    color: #155724;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: 1px solid #c3e6cb;
}

.msg.error {
    background-color: #f8d7da;
    color: #721c24;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 6px;
    border: 1px solid #f5c6cb;
}
	

    </style>
</head>

    <script>
        function updatePremium() {
            const type = document.getElementById("policy_type").value;
            const premiumMap = {
                "Life Insurance": 8000,
                "Health Insurance": 6000,
                "Vehicle Insurance": 4000,
                "Travel Insurance": 2500
            };
            document.getElementById("premium_amount").value = premiumMap[type] || '';
        }
    </script>
</head>
<body>

<header style="background-color: #0892d0; color: white; padding: 40px; text-align: center; position: relative;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Left Logo" style="height: 80px; width: 80px;">
    </div>

    <h1 style="margin: 0;">Insurance </h1>

    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
    </div>
</header>

<div class="navbar">
    <h2>Hello, <?= $fullName ?> 👋</h2>
	<div class="menu">
    <a href="dashboard.php">
            <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 12px 20px; font-size: 18px; border: none; border-radius: 8px;">
    <i class="fas fa-home" style="font-size: 20px; margin-right: 5px;"></i>
    Home
</button>

        </a></div>
</div>

<div class="container">
    <h2 class="mb-4">Manage Your Insurance Policies</h2>

    <?= $message ?>

    <!-- Add Policy Form -->
    <form method="POST" class="mb-4">
        <input type="hidden" name="action" value="add">
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Policy Type</label>
                <select name="policy_type" id="policy_type" class="form-select" required onchange="updatePremium()">
                    <option value="">Select</option>
                    <option value="Life Insurance">Life Insurance</option>
                    <option value="Health Insurance">Health Insurance</option>
                    <option value="Vehicle Insurance">Vehicle Insurance</option>
                    <option value="Travel Insurance">Travel Insurance</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Premium Amount (₹)</label>
                <input type="number" name="premium_amount" id="premium_amount" class="form-control" readonly required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Add Policy</button>
    </form>

    <!-- Pay Premium Form -->
    <form method="POST" class="mb-4">
        <input type="hidden" name="action" value="pay">
        <div class="mb-3">
            <label class="form-label">Policy ID</label>
            <input type="text" name="policy_id" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Pay Premium</button>
    </form>

    <!-- Cancel Policy Form -->
    <form method="POST" class="mb-4">
        <input type="hidden" name="action" value="cancel">
        <div class="mb-3">
            <label class="form-label">Policy ID</label>
            <input type="text" name="policy_id" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-danger w-100">Cancel Policy</button>
    </form>

    <!-- Update Premium Form -->
    <form method="POST" class="mb-4">
        <input type="hidden" name="action" value="update">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Policy ID</label>
                <input type="text" name="policy_id" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">New Premium Amount (₹)</label>
                <input type="number" name="new_premium" class="form-control" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Premium</button>
    </form>

    <!-- Policy Table -->
    <?php
    $res = $conn->query("SELECT * FROM insurance_policies WHERE customer_id = '$AccountNumber'");
    if ($res->num_rows > 0) {
        echo "<h2>Your Policies</h2><table><tr><th>Policy ID</th><th>Type</th><th>Premium</th><th>Due Date</th><th>Status</th></tr>";
        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                <td>{$row['policy_id']}</td>
                <td>{$row['policy_type']}</td>
                <td>₹{$row['premium_amount']}</td>
                <td>{$row['due_date']}</td>
                <td>{$row['status']}</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No policies found.</p>";
    }
    ?>
</div>

<div class="footer">
    • Implemented OTP-based login and mandatory password changes every 365 days<br>
    • Remind customers not to share OTPs, passwords, or user information.<br>
    • Options to Lock or Unlock access and profile password changes.<br>
</div>


<!-- Footer -->
<footer style="width: 100%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
    <div class="text-center">
        <a href="privacy.php" class="block text-white mb-2">Privacy Policy</a>
        <p class="flex justify-center items-center gap-2 text-white text-lg">
            <img src="images/envelope-solid.svg" alt="Email Icon" class="w-3 h-3">
            <a href="mailto:customercare@akolajantabank.com" class="hover:underline">customercare@akolajantabank.com</a>
        </p>
    </div>
</footer>

<script>
function updatePremium() {
    const type = document.getElementById('policy_type').value;
    const premiumInput = document.getElementById('premium_amount');
    const premiums = {
        "Life Insurance": 5000,
        "Health Insurance": 3000,
        "Vehicle Insurance": 2000,
        "Travel Insurance": 1000
    };
    premiumInput.value = premiums[type] || '';
}
</script>

</body>
</html>
