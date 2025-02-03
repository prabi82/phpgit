<?php
// Start session before any output
session_start();

// Basic error display
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Create a log file in the same directory
$logFile = __DIR__ . '/task_debug.log';
file_put_contents($logFile, "\n=== New Request " . date('Y-m-d H:i:s') . " ===\n", FILE_APPEND);

function log_debug($message, $data = null) {
    global $logFile;
    $log = date('H:i:s') . " - $message";
    if ($data !== null) {
        $log .= ": " . print_r($data, true);
    }
    file_put_contents($logFile, $log . "\n", FILE_APPEND);
    echo $log . "<br>";
}

// Process form submission first
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require_once 'config/database.php';
        require_once 'includes/functions.php';
        
        // Log the POST data
        error_log('POST data received: ' . print_r($_POST, true));
        
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        if (empty($title)) {
            throw new Exception("Title is required");
        }
        
        // Test database connection
        $test = $pdo->query('SELECT 1');
        if (!$test) {
            throw new Exception("Database connection test failed");
        }
        
        // Try to add the task
        $result = addTask($pdo, $title, $description);
        
        if ($result) {
            $_SESSION['message'] = "Task '$title' was successfully added!";
            $_SESSION['message_type'] = 'success';
            // Redirect immediately after successful addition
            header('Location: index.php');
            exit;
        } else {
            throw new Exception("Failed to add task");
        }
        
    } catch (Exception $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
        $_SESSION['message_type'] = 'error';
        error_log("Task add error: " . $e->getMessage());
        header('Location: index.php');
        exit;
    }
}

// If we get here, it wasn't a POST request
header('Location: index.php');
exit;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Task</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <h1>Add Task Debug Page</h1>
    <?php
    try {
        log_debug("Request Method", $_SERVER['REQUEST_METHOD']);
        log_debug("POST Data", $_POST);
        
        // Check for POST request
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            throw new Exception("Not a POST request");
        }
        
        // Check required files
        $requiredFiles = [
            'config/database.php',
            'includes/functions.php'
        ];
        
        foreach ($requiredFiles as $file) {
            $fullPath = __DIR__ . '/' . $file;
            log_debug("Checking file", ['file' => $file, 'path' => $fullPath, 'exists' => file_exists($fullPath)]);
            
            if (!file_exists($fullPath)) {
                throw new Exception("Required file not found: $file");
            }
            require_once $fullPath;
        }
        
        // Start session
        log_debug("Session started", $_SESSION);
        
        // Get form data
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        log_debug("Form Data", [
            'title' => $title,
            'description' => $description
        ]);
        
        // Validate
        if (empty($title)) {
            throw new Exception("Title is required");
        }
        
        // Check database connection
        if (!isset($pdo)) {
            throw new Exception("Database connection failed");
        }
        log_debug("Database connected");
        
        // Test database connection
        $test = $pdo->query('SELECT 1');
        if (!$test) {
            throw new Exception("Database connection test failed");
        }
        
        // Try to add task
        $result = addTask($pdo, $title, $description);
        log_debug("Add task result", $result);
        
        if ($result) {
            $_SESSION['message'] = "Task '$title' was successfully added!";
            $_SESSION['message_type'] = 'success';
            echo "<div class='success'>Task added successfully! Redirecting...</div>";
            header("refresh:2;url=index.php");
        } else {
            throw new Exception("Failed to add task");
        }
        
    } catch (Exception $e) {
        $error = [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ];
        log_debug("ERROR", $error);
        echo "<div class='error'>Error: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
    ?>
    <p><a href="index.php">Return to Task List</a></p>
</body>
</html> 