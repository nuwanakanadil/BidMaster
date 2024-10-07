<?php
// Database configuration
$servername = "localhost";
$username = "root"; // your database username
$password = ""; // your database password
$dbname = "auctionsystem"; // Updated to your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$input_username = trim($_POST['username']);
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Validate form data
if (empty($input_username) || empty($new_password) || empty($confirm_password)) {
    die("All fields are required.");
}

if ($new_password !== $confirm_password) {
    die("Passwords do not match.");
}

// Ensure session_username is defined (assuming this comes from a logged-in session)
session_start();
if (isset($_SESSION['username'])) {
    $session_username = $_SESSION['username']; // Fetch from session
} else {
    die("You must be logged in to change the password.");
}

// Check if username exists and the session user is trying to update their own password
$stmt = $conn->prepare("SELECT admin_id FROM admin WHERE username = ?");
$stmt->bind_param("s", $input_username); // Use prepared statement to avoid SQL injection
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0 && $input_username === $session_username) {
    // Username exists, proceed with password update
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash the password

    // Update the password and set the updated_at timestamp in the database
    $stmt = $conn->prepare("UPDATE admin SET password_hash = ?, updated_at = CURRENT_TIMESTAMP WHERE username = ?");
    $stmt->bind_param("ss", $hashed_password, $input_username); // Bind parameters securely

    if ($stmt->execute()) {
        echo "Password updated successfully.";
        // Log the user out after the password update for security
        session_destroy();
        // Redirect to the login page
        header("Location: ../login_admin/admin_login.html");
        exit(); // Ensure the script stops executing after the redirect
    } else {
        echo "Error updating password: " . $stmt->error;
    }
} else {
    echo "Invalid username or you don't have permission to change this password.";
}

// Close connections
$stmt->close();
$conn->close();
?>
