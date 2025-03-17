<?php
// Include configuration for database credentials
require_once 'config.php';

try {
    // PDO connection
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    // Set error mode to exception for better error handling
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // In case of error, display an error message and stop execution
    die("Connection failed: " . $e->getMessage());
}
?>
