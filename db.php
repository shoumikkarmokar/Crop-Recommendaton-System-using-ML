<?php
$servername = "localhost";
$username = "root";        // তোমার database username
$password = "";            // তোমার database password
$dbname = "u313075777_crop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Database Connected Successfully";
?>