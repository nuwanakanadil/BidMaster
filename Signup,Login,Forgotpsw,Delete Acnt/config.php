<?php
// Database configuration

$serverName = "localhost"; // server
$username = "sithum"; // MySQL username
$password = "sithum123"; // MySQL password
$database = "AuctionSystem"; // Database name

// Establish the connection

$conn = new mysqli($serverName, $username, $password, $database);

// Check if the connection was successful

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    
    // echo "Connection established.<br />";
}

?>
