<?php
require '../connection.php';
session_start();

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Delete query
    $delete_query = "DELETE FROM events WHERE id = $event_id";

    if (mysqli_query($connection, $delete_query)) {
        header("Location: http://localhost/php-projects/Event%20Registration%20System/admin-panel.php");
        exit();
    } else {
        echo "Error deleting event.";
    }
} else {
    echo "Invalid event ID.";
    exit();
}
?>
