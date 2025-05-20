<?php
$connect = mysqli_connect("localhost", "root", "MYsql3@pro", "bankdata");

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>
