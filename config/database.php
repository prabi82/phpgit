<?php
// Check if PDO is available
if (!extension_loaded('pdo')) {
    die('PDO extension is not installed/enabled. Please contact your hosting provider.');
}

if (!extension_loaded('pdo_mysql')) {
    die('PDO MySQL driver is not installed/enabled. Please contact your hosting provider.');
}

// Determine if we're on local or live environment
$isLocal = ($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false);

// Load the appropriate configuration file
if ($isLocal) {
    require_once __DIR__ . '/database.local.php';
} else {
    require_once __DIR__ . '/database.live.php';
}
?> 