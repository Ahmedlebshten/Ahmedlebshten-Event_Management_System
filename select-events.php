<?php
// Fetch events with error handling
$query = "SELECT * FROM events"; // Consider using LIMIT for pagination
$result = mysqli_query($connection, $query);

if (!$result || mysqli_num_rows($result) === 0) {
  $events = [];  // No events found
} else {
  $events = mysqli_fetch_all($result, MYSQLI_ASSOC);
}