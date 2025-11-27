<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', 'dEnEtH1080##$con');
    define('DB_NAME', 'bidmaster_db');

    function getDBConnection() {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Set charset to utf8
        $conn->set_charset("utf8");
        
        return $conn;
    }

    function closeDBConnection($conn) {
        if ($conn) {
            $conn->close();
        }
    }
?>