<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $host = 'localhost';
    $dbname = 'omaniservers_phpgit';
    $username = 'omaniservers_phpgit';
    $password = '9EIt]Jj2vC;b';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(Exception $e) {
    error_log("Database connection error: " . $e->getMessage());
    die("Database connection failed. Please check error logs.");
}
?> 