<?php
// Turn on all error reporting
error_reporting(-1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Basic HTML structure
?>
<!DOCTYPE html>
<html>
<head>
    <title>Debug Test</title>
</head>
<body>
    <h1>PHP Debug Test</h1>
    <?php
    // Test 1: Basic PHP
    echo "<h2>Test 1: Basic PHP Output</h2>";
    echo "If you can see this, PHP is working<br>";
    
    // Test 2: Error handling
    echo "<h2>Test 2: Error Handling</h2>";
    try {
        throw new Exception("Test exception");
    } catch (Exception $e) {
        echo "Exception caught: " . $e->getMessage() . "<br>";
    }
    
    // Test 3: Database connection
    echo "<h2>Test 3: Database Connection</h2>";
    try {
        require_once 'config/database.php';
        echo "Database file loaded<br>";
        if (isset($pdo)) {
            echo "Database connection successful<br>";
            // Test query
            $test = $pdo->query("SELECT 1");
            echo "Test query successful<br>";
        } else {
            echo "No database connection<br>";
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage() . "<br>";
    } catch (Exception $e) {
        echo "General error: " . $e->getMessage() . "<br>";
    }
    
    // Test 4: Session handling
    echo "<h2>Test 4: Session Handling</h2>";
    session_start();
    $_SESSION['test'] = 'test value';
    echo "Session value set. Current session data:<br>";
    print_r($_SESSION);
    
    // Test 5: File permissions
    echo "<h2>Test 5: File Permissions</h2>";
    $files = [
        'config/database.php',
        'includes/functions.php',
        'add_task.php',
        'index.php'
    ];
    
    foreach ($files as $file) {
        echo "$file: " . (file_exists($file) ? "Exists" : "Missing");
        if (file_exists($file)) {
            echo " (Readable: " . (is_readable($file) ? "Yes" : "No") . ")";
        }
        echo "<br>";
    }
    
    // Test 6: POST handling
    echo "<h2>Test 6: POST Form Test</h2>";
    ?>
    <form method="POST" action="debug.php">
        <input type="text" name="test_input" value="test">
        <input type="submit" value="Test POST">
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo "POST data received:<br>";
        print_r($_POST);
    }
    ?>
</body>
</html> 