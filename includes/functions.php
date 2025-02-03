<?php
// Remove or comment out the debugLog function since it's already in index.php
// function debugLog($message, $data = null) { ... }

function getAllTasks($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        throw new Exception('Error getting tasks: ' . $e->getMessage());
    }
}

function consoleLog($message, $data = null) {
    $output = json_encode(['message' => $message, 'data' => $data]);
    echo "<script>console.log($output);</script>";
}

function addTask($pdo, $title, $description) {
    try {
        $sql = "INSERT INTO tasks (title, description) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$title, $description]);
        return $result;
    } catch (Exception $e) {
        throw new Exception('Error adding task: ' . $e->getMessage());
    }
}

function deleteTask($pdo, $id) {
    try {
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id]);
    } catch (Exception $e) {
        throw new Exception('Error deleting task: ' . $e->getMessage());
    }
}
?> 