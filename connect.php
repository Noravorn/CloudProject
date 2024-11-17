<?php
// Database configuration
$host = 'db-mysql-instance.czuq6imooyep.us-east-1.rds.amazonaws.com'; // RDS endpoint
$dbname = 'Cloud_Project_BloodBank'; // Database name
$username = 'admin'; // Database username
$password = 'password'; // Database password

// Create a connection
try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);

    // Set PDO attributes for better error handling
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    //echo "Connected to AWS RDS MySQL successfully!";
} catch (PDOException $e) {
    // Handle connection error
    echo "Connection failed: " . $e->getMessage();
}
?>