<?php
echo "Hello, world!";

ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "Testing error visibility";

// Force an error to check
echo $undefinedVariable;
?>

