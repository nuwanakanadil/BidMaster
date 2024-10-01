<?php
// Database connection (update these with your actual database credentials)
$serverName = "serverName";
$connectionOptions = array(
    "Database" => "your_database_name",
    "Uid" => "your_username",
    "PWD" => "your_password"
);

// Create connection
$conn = sqlsrv_connect($serverName, $connectionOptions);

if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Create the 'feedback' table if it doesn't exist
$createTableQuery = "
    IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='feedback' AND xtype='U')
    CREATE TABLE feedback (
        id INT PRIMARY KEY IDENTITY(1,1),
        name NVARCHAR(100),
        email NVARCHAR(100),
        message NVARCHAR(500)
    )
";
sqlsrv_query($conn, $createTableQuery);

// Handle form submissions
if (isset($_POST["submit"])) {

    // Assign user-entered values to PHP variables
    $username = $_POST["name"];
    $email = $_POST["email"];
    $user_message = $_POST["message"];

    // Validate form inputs (optional but recommended)
    if (empty($username) || empty($email) || empty($user_message)) {
        die("All fields are required.");
    }

    // Prepare SQL query to insert data into the 'feedback' table
    $sql = "INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)";
    $params = array($username, $email, $user_message);

    // Execute the query
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "<script>alert('Feedback submitted successfully!');
        window.location.href = './ContactUs';
        </script>";
    }

    // Free statement and close the connection
    sqlsrv_free_stmt($stmt);
}

// Handle deletion of feedback
if (isset($_POST["delete"])) {
    // Get the user's email to identify which record to delete
    $email = $_POST["email"];

    if (!empty($email)) {
        $deleteQuery = "DELETE FROM feedback WHERE email = ?";
        $params = array($email);

        // Execute the query
        $stmt = sqlsrv_query($conn, $deleteQuery, $params);

        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));
        } else {
            echo "<script>alert('Feedback deleted successfully!');
            window.location.href = './ContactUs';
            </script>";
        }

        // Free statement and close the connection
        sqlsrv_free_stmt($stmt);
    } else {
        echo "Please provide an email to delete the feedback.";
    }
}

// Close the database connection
sqlsrv_close($conn);
?>
