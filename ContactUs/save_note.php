<?php
require_once 'db_config.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Get form data
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    
    // Validate input
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: ContactUs.html?error=All fields are required");
        exit();
    }
    
    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ContactUs.html?error=Invalid email format");
        exit();
    }
    
    // Get database connection
    $conn = getDBConnection();
    
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO notes (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);
    
    // Execute the statement
    if ($stmt->execute()) {
        $stmt->close();
        closeDBConnection($conn);
        header("Location: ContactUs.html?success=Note saved successfully");
        exit();
    } else {
        $stmt->close();
        closeDBConnection($conn);
        header("Location: ContactUs.html?error=Error saving note: " . $conn->error);
        exit();
    }
} else {
    header("Location: ContactUs.html");
    exit();
}
?>