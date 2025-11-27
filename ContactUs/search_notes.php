<?php
require_once 'db_config.php';

// Set header for JSON response
header('Content-Type: application/json');

// Check if username is provided
if (!isset($_GET['username']) || empty(trim($_GET['username']))) {
    echo json_encode([]);
    exit();
}

$username = trim($_GET['username']);

// Get database connection
$conn = getDBConnection();

// Prepare and execute query
$stmt = $conn->prepare("SELECT id, name, email, message, created_at FROM notes WHERE name LIKE ? ORDER BY created_at DESC");
$searchParam = "%" . $username . "%";
$stmt->bind_param("s", $searchParam);
$stmt->execute();
$result = $stmt->get_result();

// Fetch all notes
$notes = [];
while ($row = $result->fetch_assoc()) {
    $notes[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'email' => $row['email'],
        'message' => $row['message'],
        'created_at' => $row['created_at']
    ];
}

// Close connection
$stmt->close();
closeDBConnection($conn);

// Return JSON response
echo json_encode($notes);
?>