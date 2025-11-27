<?php
require_once 'db_config.php';

// Set header for JSON response
header('Content-Type: application/json');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    exit();
}

// Get POST data
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

// Validate input
if ($id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid note ID']);
    exit();
}

if (empty($name) || empty($email) || empty($message)) {
    echo json_encode(['success' => false, 'error' => 'All fields are required']);
    exit();
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'error' => 'Invalid email format']);
    exit();
}

// Get database connection
$conn = getDBConnection();

// Check if note exists
$checkStmt = $conn->prepare("SELECT id FROM notes WHERE id = ?");
$checkStmt->bind_param("i", $id);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows === 0) {
    $checkStmt->close();
    closeDBConnection($conn);
    echo json_encode(['success' => false, 'error' => 'Note not found']);
    exit();
}
$checkStmt->close();

// Prepare & execute update
$stmt = $conn->prepare("UPDATE notes SET name = ?, email = ?, message = ? WHERE id = ?");
$stmt->bind_param("sssi", $name, $email, $message, $id);

if ($stmt->execute()) {
    $stmt->close();
    closeDBConnection($conn);
    echo json_encode(['success' => true, 'message' => 'Note updated successfully']);
} else {
    $error = $conn->error;
    $stmt->close();
    closeDBConnection($conn);
    echo json_encode(['success' => false, 'error' => 'Error updating note: ' . $error]);
}
?>