<?php
require_once 'error_handler.php';

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";  // Empty password for XAMPP default MySQL root user
$dbname = "inv"; //palitan mo to depende sa name ng db mo sa phpmyadmin

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    handleDatabaseError($conn->connect_error);
}

// Set charset to ensure proper encoding
$conn->set_charset("utf8mb4");
?>