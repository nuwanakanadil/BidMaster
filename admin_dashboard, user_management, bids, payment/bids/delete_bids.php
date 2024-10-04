<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $conn = new mysqli('localhost', 'root', '', 'auctionsystem');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM bids WHERE bid_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Bid with ID $id has been deleted.";
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
}
?>