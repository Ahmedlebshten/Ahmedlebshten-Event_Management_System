<?php
require '../connection.php';

session_start();

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($connection, $_POST['title']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $event_date = mysqli_real_escape_string($connection, $_POST['event_date']);

    // Insert the new event into the database
    $insert_query = "INSERT INTO events (title, description, event_date) VALUES ('$title', '$description', '$event_date')";
    
    if (mysqli_query($connection, $insert_query)) {
        // Redirect to the events page after successful insertion
        header("Location: http://localhost/php-projects/Event%20Registration%20System/admin-panel.php");
        exit();
    } else {
        echo "Error creating event: " . mysqli_error($connection);
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Create New Event</h2>
    <form method="POST" action="create.php">
        <div class="mb-3">
            <label for="title" class="form-label">Event Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="event_date" class="form-label">Event Date</label>
            <input type="date" name="event_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Create Event</button>
        <a href="events.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
