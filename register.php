<?php
require 'connection.php';
require 'assets-url.php';


$registrationSuccess = false;
$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if form fields are set and sanitize them
    $username = isset($_POST['username']) ? mysqli_real_escape_string($connection, $_POST['username']) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($connection, $_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    // Validate fields
    if (empty($username) || empty($email) || empty($password)) {
        $error_message = "All Fields Are Required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid Email Format.";
    } else {
        // Check if username or email already exists
        $stmt_check = mysqli_prepare($connection, "SELECT id FROM users WHERE username = ? OR email = ?");
        if ($stmt_check) {
            mysqli_stmt_bind_param($stmt_check, 'ss', $username, $email);
            mysqli_stmt_execute($stmt_check);
            mysqli_stmt_store_result($stmt_check);

            if (mysqli_stmt_num_rows($stmt_check) > 0) {
                $error_message = "Username Or Email Already Exists.";
            } else {
                // If valid, hash the password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Insert the user into the database
                $stmt_insert = mysqli_prepare($connection, "INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
                if ($stmt_insert) {
                    mysqli_stmt_bind_param($stmt_insert, 'sss', $username, $hashed_password, $email);
                    if (mysqli_stmt_execute($stmt_insert)) {
                        $registrationSuccess = true;
                    } else {
                        $error_message = "Error: " . mysqli_error($connection);
                    }
                    // Close the insert statement
                    mysqli_stmt_close($stmt_insert);
                } else {
                    $error_message = "Database Error. Please Try Again Later.";
                }
            }
            // Close the check statement
            mysqli_stmt_close($stmt_check);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= url('style-register.css') ?>">
    <link rel="stylesheet" href="<?= url('style.css') ?>">
    <title>Register</title>
</head>

<body>
    <div class="form-container">
        <h2>Register</h2>

        <?php if ($registrationSuccess): ?>
            <div class="message success-message">
                Account created successfully! <a href="login.php">Login here</a>
            </div>
        <?php elseif (!empty($error_message)): ?>
            <div class="message error-message">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Register</button>
        </form>
    </div>
</body>

</html>