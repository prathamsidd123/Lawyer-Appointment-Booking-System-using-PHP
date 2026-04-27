<?php
// debug_login.php - Use this to find the error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Testing PHP execution...<br>";

// Test database connection
require_once 'config/db.php';
echo "Database connection file loaded...<br>";

if ($conn) {
    echo "Database connected successfully!";
} else {
    echo "Database connection failed!";
}
?>