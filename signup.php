<?php
session_start();

// Database connection
$dsn = 'mysql:host=localhost;dbname=bankdata;charset=utf8mb4';
$db_user = 'root';
$db_pass = 'pass';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



try {
    $conn = new PDO($dsn, $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

function generateUniqueCustomerID($pdo) {
    $baseNumber = 000;
    $stmt = $pdo->query("SELECT COUNT(*) FROM bankcustomers");
    $count = $stmt->fetchColumn();
    $newCustomerID = $baseNumber + $count;
    $CustomerID =$newCustomerID;
    return $CustomerID;
}


function generateUniqueAccountNumber($pdo) {
    $baseNumber = 10000;
    $stmt = $pdo->query("SELECT COUNT(*) FROM bankcustomers");
    $count = $stmt->fetchColumn();
    $newAccountNumberNumeric = $baseNumber + $count;
    $accountNumber = "ACC" . $newAccountNumberNumeric;
    return $accountNumber;
}

// Handle AJAX: Get Cities
if (isset($_POST['getCities'])) {
    $state = $_POST['state'];
    $stmt = $conn->prepare("SELECT cities.name AS city FROM cities JOIN states ON cities.state_id = states.id WHERE states.name = ? ORDER BY cities.name");
    $stmt->execute([$state]);
    echo "<option value=''>Select City</option>";
    while ($row = $stmt->fetch()) {
        echo "<option value='" . $row['city'] . "'>" . $row['city'] . "</option>";
    }
    exit;
}

// Handle AJAX: Get Pincode
if (isset($_POST['getPincode'])) {
    $city = $_POST['city'];
    $stmt = $conn->prepare("SELECT pincode FROM cities WHERE name = ?");
    $stmt->execute([$city]);
    $row = $stmt->fetch();
    echo $row ? $row['pincode'] : '';
    exit;
}

$page = 'signup';

// Handle Form Submissions
if (isset($_POST['submit_signup'])) {
    // Save signup form data
    $FirstName = $_POST['FirstName'];
    $MiddleName = $_POST['MiddleName'];
    $LastName = $_POST['LastName'];
    $PhoneNumber = $_POST['phone'];
    $CustomerID = generateUniqueCustomerID($conn);
    $AccountNumber = generateUniqueAccountNumber($conn);
    $DateOfBirth = $_POST['DateOfBirth'];
    $Age = $_POST['Age'];
    $Address = $_POST['Address'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $PinCode = $_POST['pincode'];
    $Email = $_POST['Email'];
    $MPIN = $_POST['MPIN'];
    

    $stmt = $conn->prepare("INSERT INTO bankcustomers (CustomerID, FirstName, MiddleName, LastName, PhoneNumber, AccountNumber, DateOfBirth, Age, Address, state, city, PinCode, Email, MPIN) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$CustomerID, $FirstName, $MiddleName, $LastName, $PhoneNumber, $AccountNumber, $DateOfBirth, $Age, $Address, $state, $city, $PinCode, $Email, $MPIN]);

    $_SESSION['AccountNumber'] = $AccountNumber;
    $page = 'documents';
}

if (isset($_POST['submit_documents'])) {
    $PANCardNo = $_POST['PANCardNo'] ?? '';
    $AadhaarNo = $_POST['AadhaarNo'] ?? '';
    $ElectricityBill = $_POST['ElectricityBill'] ?? '';
    $PassportPhoto = $_POST['PassportPhoto'] ?? '';

    $AccountNumber = $_SESSION['AccountNumber'] ?? null;

    if ($AccountNumber) {
        $stmt = $conn->prepare("UPDATE bankcustomers SET PANCardNo = ?, AadhaarNo = ?, ElectricityBill = ?, PassportPhoto = ? WHERE AccountNumber = ?");
        $stmt->execute([$PANCardNo, $AadhaarNo, $ElectricityBill, $PassportPhoto, $AccountNumber]);
        
        $page = 'security'; // Move to security page
    }
}

if (isset($_POST['submit_security'])) {
    $SecurityQuestion1 = $_POST['SecurityQuestion1'];
    $SecurityAnswer1 = $_POST['SecurityAnswer1'];
    $SecurityQuestion2 = $_POST['SecurityQuestion2'];
    $SecurityAnswer2 = $_POST['SecurityAnswer2'];
    $AccountType = $_POST['AccountType'];
    $AccountBalance = $_POST['AccountBalance'];

    $AccountNumber = $_SESSION['AccountNumber'] ?? null;

    if ($AccountNumber) {
        $stmt = $conn->prepare("UPDATE bankcustomers SET 
            SecurityQuestion1 = ?, 
            SecurityAnswer1 = ?, 
            SecurityQuestion2 = ?, 
            SecurityAnswer2 = ?, 
            AccountType = ?, 
            AccountBalance = ?
            WHERE AccountNumber = ?");
        $stmt->execute([$SecurityQuestion1, $SecurityAnswer1, $SecurityQuestion2, $SecurityAnswer2, $AccountType, $AccountBalance, $AccountNumber]);

        echo "<script>alert('Signup completed successfully!'); window.location.href='show.php';</script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup Form</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background-image: url('images/back2.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }
        .form-container {
            width: 400px;
            background: rgba(255,255,255,1);
            padding: 50px;
            margin: 50px auto;
            border-radius: 20px;
            box-shadow: 0 0 15px #00000050;
        }
        .form-container input, .form-container select {
            width: 95%;
            padding: 10px;
            margin-top: 10px;
        }
        .form-container button {
            margin-top: 15px;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            cursor: pointer;
        }
        .navbar {
            background-color: #21abcd;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
        }
        .navbar .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<header style="background-color: #0892d0; color: white; width: 100%; padding: 40px; position: relative; text-align: center;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
    <img alt="Left corner image" class="h-20 w-20" src="images/logoofbank.png"/>
   </div>
   <h1 class="text-xl font-bold text-center"><strong>
    Home page</strong>
   </h1>
   <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
    <img alt="Right corner image" class="h-20 w-20" src="images/logoofbank.png"/>
   </div>
</header>
<div class="navbar">
    <div><strong>User Sign up Page</strong></div>
    <div class="menu">
        <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;"><a href="home.php">Home</a></button>
    </div>
</div>

<?php if ($page == 'signup') { ?>
<!-- signup form -->
<div class="form-container">

    <form method="POST" id="signupForm">
	
        <input type="text" name="FirstName" placeholder="First Name" required>
        <input type="text" name="MiddleName" placeholder="Middle Name">
        <input type="text" name="LastName" placeholder="Last Name" required>
        <input type="date" name="DateOfBirth" id="dob" required>
        <input type="number" name="Age" id="age" placeholder="Age" readonly>
	<input type="text" name="Address" placeholder="Address" required>
        <input type="email" name="Email" placeholder="Email" required>
        <input type="tel" name="phone" placeholder="Phone Number" pattern="[0-9]{10}" maxlength="10" required>

        <select name="state" id="state" required>
            <option value="">Select State</option>
            <?php
            $states = $conn->query("SELECT name FROM states ORDER BY name");
            foreach ($states as $row) {
                echo "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";
            }
            ?>
        </select>

        <select name="city" id="city" required>
            <option value="">Select City</option>
        </select>

        <input type="text" name="pincode" id="pincode" placeholder="Pincode" readonly>
        <input type="password" name="MPIN" placeholder="MPIN" maxlength="6" required>

        <button type="submit" name="submit_signup">Submit</button>
    </form>
</div>

<script>
// Calculate Age
document.getElementById("dob").addEventListener("change", function () {
    let dob = new Date(this.value);
    let today = new Date();
    let age = today.getFullYear() - dob.getFullYear();
    let m = today.getMonth() - dob.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
        age--;
    }
    document.getElementById("age").value = age;
});

// Load cities
document.getElementById("state").addEventListener("change", function () {
    let state = this.value;
    let formData = new FormData();
    formData.append("getCities", true);
    formData.append("state", state);

    fetch(window.location.href, {
        method: "POST",
        body: formData
    }).then(res => res.text())
      .then(data => {
          document.getElementById("city").innerHTML = data;
          document.getElementById("pincode").value = '';
      });
});

// Load pincode
document.getElementById("city").addEventListener("change", function () {
    let city = this.value;
    let formData = new FormData();
    formData.append("getPincode", true);
    formData.append("city", city);

    fetch(window.location.href, {
        method: "POST",
        body: formData
    }).then(res => res.text())
      .then(data => {
          document.getElementById("pincode").value = data;
      });
});
</script>

<?php } elseif ($page == 'documents') { ?>
<!-- documents page form -->
<main class="flex flex-col items-center py-8">
<div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg relative">
<form action="" class="space-y-4 relative z-10" method="post">
  <div>
    <label class="block text-gray-700">Aadhaar Number</label>
    <input class="w-full p-2 border border-gray-300 rounded" name="AadhaarNo" type="text" maxlength="12" pattern="\d{12}" required placeholder="Enter 12-digit Aadhaar number" />
  </div>

  <div>
    <label class="block text-gray-700">Electricity Bill Number</label>
    <input class="w-full p-2 border border-gray-300 rounded" name="ElectricityBill" type="text" maxlength="12" required placeholder="Enter electricity bill number" />
  </div>

  <div>
    <label class="block text-gray-700">PAN Card Number</label>
    <input class="w-full p-2 border border-gray-300 rounded" name="PANCardNo" type="text" maxlength="10" pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}" required placeholder="ABCDE1234F" />
  </div>

  <div>
    <label class="block text-gray-700" for="PassportPhoto">Passport Photo</label>
    <input class="w-full p-2 border border-gray-300 rounded"
           id="PassportPhoto" name="PassportPhoto"
           type="file" accept="image/*" required />
  </div>

  <div class="text-center">
    <button class="bg-blue-500 text-white px-4 py-2 rounded" type="submit" name="submit_documents">
      Submit
    </button>
  </div>
</form>
</div>
</main>

<?php } elseif ($page == 'security') { ?>
<!-- security questions page form -->
<main class="flex flex-col items-center py-8">
<div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg relative">
<form action="" class="space-y-4 relative z-10" method="post">

  <div>
    <label for="security-question-1" class="block text-sm font-medium text-gray-700 mb-1">
      Security Question 1 
      <span class="text-blue-500 cursor-pointer" data-tippy-content="Choose your first security question.">
        ⓘ
      </span>
    </label>
   <select class="w-full p-2 border border-gray-300 rounded" id="SecurityQuestion1" name="SecurityQuestion1" required>
      <option value="">Select a question</option>
      <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
      <option value="What was the name of your first pet?">What was the name of your first pet?</option>
      <option value="What was the name of your elementary school?">What was the name of your elementary school?</option>
      <option value="What is your favorite book?">What is your favorite book?</option>
      <option value="What is your favorite movie?">What is your favorite movie?</option>
      <option value="What was the make of your first car?">What was the make of your first car?</option>
      <option value="What city were you born in?">What city were you born in?</option>
      <option value="What is your favorite food?">What is your favorite food?</option>
      <option value="What is your pet's name?">What is your pet's name?</option>
      <option value="What is your favourite dessert?">What is your favourite dessert?</option>
      <option value="What is your favourite fruit?">What is your favourite fruit?</option>
      <option value="What is your favourite hobby?">What is your favourite hobby?</option>
      <option value="What is your favourite sport?">What is your favourite sport?</option>
      <option value="What is your favourite place?">What is your favourite place?</option>
      <option value="What is your favourite season?">What is your favourite season?</option>
      <option value="What is your favourite ice cream flavour?">What is your favourite ice cream flavour?</option>
      <option value="What is your favourite dish?">What is your favourite dish?</option>
      <option value="What was your first car?">What was your first car?</option>
      <option value="What is your favourite festival?">What is your favourite festival?</option>
      <option value="What is your hometown?">What is your hometown?</option>
    </select>
  </div>

  <div>
    <label class="block text-gray-700">Security Answer 1</label>
    <input class="w-full p-2 border border-gray-300 rounded" name="SecurityAnswer1" type="text" required placeholder="Enter answer to first question" />
  </div>

  <div>
    <label for="security-question-2" class="block text-sm font-medium text-gray-700 mb-1">
      Security Question 2 
      <span class="text-blue-500 cursor-pointer" data-tippy-content="Choose a different security question.">
        ⓘ
      </span>
    </label>
    <select class="w-full p-2 border border-gray-300 rounded" id="SecurityQuestion1" name="SecurityQuestion1" required>
      <option value="">Select a question</option>
      <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
      <option value="What was the name of your first pet?">What was the name of your first pet?</option>
      <option value="What was the name of your elementary school?">What was the name of your elementary school?</option>
      <option value="What is your favorite book?">What is your favorite book?</option>
      <option value="What is your favorite movie?">What is your favorite movie?</option>
      <option value="What was the make of your first car?">What was the make of your first car?</option>
      <option value="What city were you born in?">What city were you born in?</option>
      <option value="What is your favorite food?">What is your favorite food?</option>
      <option value="What is your pet's name?">What is your pet's name?</option>
      <option value="What is your favourite dessert?">What is your favourite dessert?</option>
      <option value="What is your favourite fruit?">What is your favourite fruit?</option>
      <option value="What is your favourite hobby?">What is your favourite hobby?</option>
      <option value="What is your favourite sport?">What is your favourite sport?</option>
      <option value="What is your favourite place?">What is your favourite place?</option>
      <option value="What is your favourite season?">What is your favourite season?</option>
      <option value="What is your favourite ice cream flavour?">What is your favourite ice cream flavour?</option>
      <option value="What is your favourite dish?">What is your favourite dish?</option>
      <option value="What was your first car?">What was your first car?</option>
      <option value="What is your favourite festival?">What is your favourite festival?</option>
      <option value="What is your hometown?">What is your hometown?</option>
    </select>
  </div>

  <div>
    <label class="block text-gray-700">Security Answer 2</label>
    <input class="w-full p-2 border border-gray-300 rounded" name="SecurityAnswer2" type="text" required placeholder="Enter answer to second question" />
  </div>
<script>
  // Activate tooltips
  tippy('[data-tippy-content]', {
    animation: 'scale',
    theme: 'light',
    delay: [100, 100]
  });

  // Prevent duplicate security questions
  const q1 = document.getElementById('security-question-1');
  const q2 = document.getElementById('security-question-2');

  function syncQuestions() {
    const selectedQ1 = q1.value;
    const optionsQ2 = q2.options;

    for (let i = 0; i < optionsQ2.length; i++) {
      if (optionsQ2[i].value === selectedQ1 && selectedQ1 !== "") {
        optionsQ2[i].disabled = true;
      } else {
        optionsQ2[i].disabled = false;
      }
    }
  }

  q1.addEventListener('change', syncQuestions);
  q2.addEventListener('change', syncQuestions);
</script>               

  <div>
    <label class="block text-gray-700">Account Type</label>
    <select name="AccountType" class="w-full p-2 border border-gray-300 rounded" required>
        <option value="">Select account type</option>
        <option value="Savings">Savings</option>
        <option value="Current">Current</option>
        <option value="Fixed Deposit">Fixed Deposit</option>
    </select>
  </div>

  <div>
    <label class="block text-gray-700">Deposit Amount</label>
    <input class="w-full p-2 border border-gray-300 rounded" name="AccountBalance" type="number" min="0" required placeholder="Enter initial deposit amount" />
  </div>

  <div class="text-center">
    <button class="bg-green-500 text-white px-4 py-2 rounded" type="submit" name="submit_security">
      Complete Signup
    </button>
  </div>
</form>
</div>
</main>

<?php } ?>
<br>
<br>
<br>
<div style="text-align: center; font-size: 12px;">
    • Implemented OTP-based login and mandatory password changes every 365 days<br>
    • Remind customers not to share OTPs, passwords, or user information.<br>
    • Options to Lock or Unlock access and profile password changes.<br>
</div>
<footer style="width: 100%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
	  <div class="text-center">
    <a href="privacy.php" class="block text-white mb-2">Privacy policy</a>
    
    <p class="flex justify-center items-center gap-2 text-white text-lg">
      <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
      <a href="https://mail.google.com" class="hover:underline">customercare@akolajantabank.com</a>
    </p>
</div>
</footer>


</body>
</html>

