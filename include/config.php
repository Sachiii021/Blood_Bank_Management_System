<?php

// Database configuration
$dbHost = 'localhost'; // If MySQL is running on the same server as Apache
$dbUsername = 'root'; // Default username for MySQL in XAMPP
$dbPassword = ''; // Default password for MySQL in XAMPP
$dbName = 'donatetheblood'; // Replace 'donatetheblood' with the name of your database

// Create a database connection
$connection = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

?>
