<?php
require 'connection.php';
require 'assets-url.php';

session_start();

$error_message = '';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Use prepared statements to avoid SQL injection
        $stmt = mysqli_prepare($connection, "SELECT * FROM users WHERE username = ?");
        if ($stmt) {
            // Bind parameters and execute statement
            mysqli_stmt_bind_param($stmt, 's', $username);  // 's' specifies the type (string)  mysqli_stmt_bind_param() binds the username (as a string) to the SQL query.
            mysqli_stmt_execute($stmt);

            // Get the result
            $result = mysqli_stmt_get_result($stmt);
            $user = mysqli_fetch_assoc($result);

            // Verify password and user existence
            if ($user && password_verify($password, $user['password'])) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);

                // Set session variables
                $_SESSION['user_id'] = $user['id'];  // Store the user's ID
                $_SESSION['is_admin'] = $user['is_admin'];  // Store whether the user is an admin

                // Redirect based on whether the user is an admin
                if ($user['is_admin'] == 1) {
                    header("Location: admin-panel.php");
                } else {
                    header("Location: events.php");
                }
                exit();
            } else {
                // Set error message if login fails
                $error_message = "Invalid Username Or Password.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        } else {
            // Handle statement preparation failure
            $error_message = "Database Query Failed.";
        }
    } else {
        $error_message = "All Fields Are Required.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= url('style-login.css') ?>">
    <link rel="stylesheet" href="<?= url('style.css') ?>">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <h2>Login</h2>

        <!-- Display error message if any -->
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>