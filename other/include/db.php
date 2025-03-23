<?php
// Database configuration
$host = 'localhost'; // Database host
$dbname = 'phar_db'; // Database name
$username = 'root';  // Database username
$password = '';      // Default password for XAMPP (leave empty if no password)

try {
    // Create a PDO instance to connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Set error mode to exception for better debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Optional: Uncomment the line below to confirm the connection
    echo "Database connection established.";
} catch (PDOException $e) {
    // Handle connection errors gracefully
    die("Database connection failed: " . $e->getMessage());
}
?>