<?php
session_start(); 

$servername = "localhost"; 
$userName = "root"; 
$userPass = "pass"; 
$database = "bankdata"; 

$connectQuery = mysqli_connect($servername, $userName, $userPass, $database);

$firstName = $_SESSION['FirstName'] ?? 'User';
$lastName = $_SESSION['LastName'] ?? '';

if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
} else {
    $selectQuery = "SELECT * FROM bankcustomers ORDER BY CustomerID ASC";
    $result = mysqli_query($connectQuery, $selectQuery);
    if (mysqli_num_rows($result) > 0) {
        // Results found
    } else {
        $msg = "No Record found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Record board</title>
    <style>
        body {
	 background: url(images/back2.png);
         background-repeat: no-repeat;
         background-attachment: fixed;
         background-size: cover;

            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #fff;
        }
.navbar {
    background-color: #21abcd;
    padding: 10px 200px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #ccc;
    width: 175.5%;
    box-sizing: border-box;
}
        .navbar .menu a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
        }
        .main {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px;
        }
	.footer {
            text-align: center;
            font-size: 12px;
            padding: 10px;
            margin-top: 30px;
            color: #555;
        }
	 
   </style>	
</head>
<body>
<header style="width: 170%; background-color: #0892d0; color: white; padding: 40px; position: relative; text-align: center;">
    <div style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Left Logo" style="height: 80px; width: 80px;">
    </div>

    <h1 style="margin: 0; font-size: 24px;">Admin Dashboard</h1>

    <div style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%);">
        <img src="images/logoofbank.png" alt="Right Logo" style="height: 80px; width: 80px;">
    </div>
</header>
<div class="navbar">
    <div><strong> Admin Dashboard</strong></div>
    <div class="menu">
	<button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;"><a href="logout2.php">Logout</a></button>
        <button style="margin-left: 20px; background-color: #4682b4; color: white; padding: 5px 10px; border: none; border-radius: 5px;"><a href="home.php">Home</a></button>
    </div>
</div>
    <h1>Bank customers List</h1>
    <?php if(isset($msg)) echo $msg; ?>
    <table border="1px" style="width:70px; line-height:30px;">
        <thead>
            <tr>
                <th>Sr NO:</th>
                <th>FirstName</th>
                <th>LastName</th>
                <th>DateOfBirth</th>
                <th>Age</th>

                <th>Email</th>
                <th>PhoneNumber</th>
                <th>Address</th>
                <th>City</th>

                <th>State</th>
                <th>PinCode</th>
                <th>AccountNumber</th>
                <th>MPIN</th>

                <th>SecurityQuestion1</th>
                <th>SecurityAnswer1</th>
                <th>SecurityQuestion2</th>
                <th>SecurityAnswer2</th>

                <th>PANCardNo</th>
                <th>AadhaarNo</th>
                <th>ElectricityBill</th>
                <th>CreditCardNumber</th>
                <th>AccountType</th>
                <th>AccountBalance</th>

            </tr>
        </thead>
        <tbody>
           <?php
                while($row = mysqli_fetch_assoc($result)){?>
                <tr>
			<td><?php echo $row['CustomerID']; ?></td>
                    	<td><?php echo $row['FirstName']; ?></td>
		    	<td><?php echo $row['LastName']; ?></td>
                    	<td><?php echo $row['DateOfBirth']; ?></td>
			<td><?php echo $row['Age']; ?></td>
			<td><?php echo $row['Email']; ?></td>
			<td><?php echo $row['PhoneNumber']; ?></td>
			<td><?php echo $row['Address']; ?></td>
			<td><?php echo $row['City']; ?></td>
			<td><?php echo $row['State']; ?></td>
			<td><?php echo $row['PinCode']; ?></td>
			<td><?php echo $row['AccountNumber']; ?></td>
			<td><?php echo $row['MPIN']; ?></td>
			<td><?php echo $row['SecurityQuestion1']; ?></td>
			<td><?php echo $row['SecurityAnswer1']; ?></td>
			<td><?php echo $row['SecurityQuestion2']; ?></td>
			<td><?php echo $row['SecurityAnswer2']; ?></td>
			<td><?php echo $row['PANCardNo']; ?></td>
			<td><?php echo $row['AadhaarNo']; ?></td>
			<td><?php echo $row['ElectricityBill']; ?></td>
			<td><?php echo $row['CreditCardNumber']; ?></td>
			<td><?php echo $row['AccountType']; ?></td>
			<td><?php echo $row['AccountBalance']; ?></td>

            
                </tr>
            <?php } ?>
        </tbody>
    </table>
<br>
<br>
<div class="footer">
    • Implemented OTP-based login and mandatory password changes every 365 days<br>
    • Remind customers not to share OTPs, passwords, or user information.<br>
    • Options to Lock or Unlock access and profile password changes.<br>
</div>

<!-- Footer -->
<footer style="width: 100%; background-color: #0892d0; color: white; text-align: center; padding: 40px;">
    <div class="text-center">
        <a href="privacy.php" class="block text-white mb-2">🔒 Privacy Policy</a>
        <p class="flex justify-center items-center gap-2 text-white text-lg">
            <img src="images/envelope-solid.svg" alt="Email Icon" class="w-5 h-5">
            <a href="mailto:customercare@akolajantabank.com" class="hover:underline">customercare@akolajantabank.com</a>
        </p>
    </div>
</footer>
</body>
</html>