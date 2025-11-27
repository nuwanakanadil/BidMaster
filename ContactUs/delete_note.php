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

// Validate input
if ($id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid note ID']);
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

// Prepare and execute delete
$stmt = $conn->prepare("DELETE FROM notes WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    $stmt->close();
    closeDBConnection($conn);
    echo json_encode(['success' => true, 'message' => 'Note deleted successfully']);
} else {
    $error = $conn->error;
    $stmt->close();
    closeDBConnection($conn);
    echo json_encode(['success' => false, 'error' => 'Error deleting note: ' . $error]);
}
?>