<?php
// // Database configuration

$serverName = "DESKTOP-5LJO5BG\SQLEXPRESS";
$connectionOptions = array(
    "Database" => "AuctionSystem",
    "Uid" => "sithum",
    "PWD" => "sithum123"
);

// Establishes the connection

$conn = sqlsrv_connect($serverName,$connectionOptions);

// Check if the connection was successful

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
} else {
    
    //echo "Connection established.<br />";
}

?>