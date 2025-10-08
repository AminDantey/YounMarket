<?php
$host = 'localhost';      // Database host
$db   = 'younmarket';  // Database name
$user = 'root';  // Database username
$pass = '';  // Database password
$charset = 'utf8mb4';     // Character set

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Enable exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use real prepared statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Connection successful
} catch (PDOException $e) {
    // Handle connection error
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}
?>