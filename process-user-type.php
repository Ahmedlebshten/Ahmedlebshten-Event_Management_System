<?php
session_start();
require 'connection.php';

// Enable error reporting for debugging
// Remove or comment out in production
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input values
    $user_type = isset($_POST['user_type']) ? $_POST['user_type'] : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: try-again.php");
        exit();
    }

    // Check user type and prepare query accordingly
    if ($user_type === 'user' || $user_type === 'admin') {
        $is_admin = $user_type === 'admin' ? 1 : 0;

        // Prepared statement to prevent SQL injection
        $stmt = mysqli_prepare($connection, "SELECT * FROM users WHERE email = ? AND is_admin = ?");
        if ($stmt) {
            // Bind parameters: 's' for email (string), 'i' for is_admin (integer)
            mysqli_stmt_bind_param($stmt, 'si', $email, $is_admin);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                // Redirect based on user type
                if ($is_admin) {
                    header("Location: admin-panel.php");
                } else {
                    header("Location: home.html");
                }
                exit();
            } else {
                // Invalid credentials
                header("Location: try-again.php");
                exit();
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        } else {
            // Query preparation failed
            echo "Database error. Please try again later.";
            exit();
        }
    } else {
        // Invalid user type
        header("Location: try-again.php");
        exit();
    }
} else {
    // Handle invalid request method
    header("Location: try-again.php");
    exit();
}
