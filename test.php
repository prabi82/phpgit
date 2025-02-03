<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>PHP Test Page</h1>";
echo "<p>PHP is working if you can see this message.</p>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<pre>";
print_r($_SERVER);
echo "</pre>";
?> 