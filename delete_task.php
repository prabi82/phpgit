<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    
    if (!empty($id)) {
        deleteTask($pdo, $id);
    }
}

header('Location: index.php');
exit;
?> 