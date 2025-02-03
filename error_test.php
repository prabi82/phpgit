<?php
// Set error logging
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error.log');
error_reporting(E_ALL);

// Try basic PHP
try {
    echo "Step 1: Basic PHP works\n";
    
    // Test file operations
    $logFile = dirname(__FILE__) . '/test.log';
    file_put_contents($logFile, "Test log entry\n");
    echo "Step 2: File operations work\n";
    
    // Test database connection
    $host = 'localhost';
    $dbname = 'omaniservers_phpgit';
    $username = 'omaniservers_phpgit';
    $password = '9EIt]Jj2vC;b';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "Step 3: Database connection works\n";
    
} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    echo "Error occurred. Check error.log for details.";
}
?> 