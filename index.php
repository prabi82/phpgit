<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/database.php';
require_once 'includes/functions.php';

// Test database connection
try {
    $test = $pdo->query('SELECT 1');
    echo "<!-- Database connected successfully -->";
} catch (Exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}

try {
    $tasks = getAllTasks($pdo);
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Task Manager</h1>
        
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
                ?>
            </div>
        <?php endif; ?>

        <form action="add_task.php" method="POST">
            <input type="text" name="title" placeholder="Task Title" required>
            <textarea name="description" placeholder="Task Description"></textarea>
            <button type="submit">Add Task</button>
        </form>

        <div class="tasks">
            <?php foreach($tasks as $task): ?>
                <div class="task">
                    <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                    <p><?php echo htmlspecialchars($task['description']); ?></p>
                    <small>Created: <?php echo $task['created_at']; ?></small>
                    <form action="delete_task.php" method="POST" style="display: inline;">
                        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html> 