<?php 
require '../connection.php';
session_start();

// Check if the ID is set in the URL and is numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $event_id = (int) $_GET['id']; // Cast to integer for safety

    // Fetch event data from the database
    $query = "SELECT * FROM events WHERE id = $event_id";
    $result = mysqli_query($connection, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $event = mysqli_fetch_assoc($result);
    } else {
        echo "Event not found.";
        exit();
    }

    // Update event details when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = mysqli_real_escape_string($connection, $_POST['title']);
        $description = mysqli_real_escape_string($connection, $_POST['description']);
        $event_date = mysqli_real_escape_string($connection, $_POST['event_date']);

        // Update query
        $update_query = "UPDATE events SET title = '$title', description = '$description', event_date = '$event_date' WHERE id = $event_id";

        if (mysqli_query($connection, $update_query)) {
            header("Location: http://localhost/php-projects/Event%20Registration%20System/admin-panel.php");
            exit();
        } else {
            echo "Error updating event.";
        }
    }
} else {
    echo "Invalid event ID.";
    exit();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Event</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h2>Update Event</h2>
    <form method="POST" action="update.php?id=<?php echo htmlspecialchars($event_id); ?>">
        <div class="mb-3">
            <label for="title" class="form-label">Event Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($event['title']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" required><?php echo htmlspecialchars($event['description']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="event_date" class="form-label">Event Date</label>
            <input type="date" name="event_date" class="form-control" value="<?php echo htmlspecialchars($event['event_date']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Event</button>
        <a href="../admin-panel.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
