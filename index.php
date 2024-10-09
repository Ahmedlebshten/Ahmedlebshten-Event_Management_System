<?php
require 'assets-url.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= url('style-index.css') ?>">
    <title>User Type Selection</title>
</head>

<body>
    <form id="user_form" method="POST" action="process-user-type.php" onsubmit="handleSubmit(event)">
        <label for="user_type">Choose User Type:</label>
        <select id="user_type" name="user_type" onchange="handleUserTypeChange()" required>
            <option value="" disabled selected>Select an option</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>

        <!-- this field is shown only if user selected admin -->
        <div id="admin_email" style="display: none;">
            <label for="email">Enter Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter email">
        </div>

        <button type="submit">Submit</button>
    </form>



    <script src="<?= url('script.js') ?>"></script>
</body>

</html>