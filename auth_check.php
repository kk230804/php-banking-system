<?php
session_start();
if (!isset($_SESSION['AccountNumber'])) {
    header("Location: login.php");
    exit;
}
?>
