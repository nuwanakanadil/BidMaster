<?php

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

        // Parameters for the query
        $params = array($username, $email, $user_message);

        // Execute the query
        $stmt = sqlsrv_query($conn, $sql, $params);

        // Check if the query was successful
        if ($stmt === false) {
            die(print_r(sqlsrv_errors(), true));  // If there's an error, display it
        } else {
            echo "<script>alert('Feedback submitted successfully!');
            window.location.href = './ContactUs';
            </script>";
        }

        // Free statement and close the connection
        sqlsrv_free_stmt($stmt);
        sqlsrv_close($conn);
    }
?>
