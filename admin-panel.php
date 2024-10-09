<?php
session_start();   // allowing you to access session variables
require 'connection.php';
require 'auth.php';
require 'select-admins.php';
require 'select-events.php';
require 'crud-url.php';
?>




<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

  <div class="container">
    <!-- Admin Info Section -->
    <?php if ($admin_info): ?>
      <div class="alert alert-info mt-3">
        <h4>Admin Information</h4>
        <p><strong>Name:</strong> <?= htmlspecialchars($admin_info['username']) ?></p>     <!-- We use htmlspecialchars() to safely output the data, preventing XSS (Cross-Site Scripting) attacks. -->
        <p><strong>Email:</strong> <?= htmlspecialchars($admin_info['email']) ?></p>
      </div>
    <?php else: ?>
      <div class="alert alert-warning mt-3">
        <p>No admin found.</p>
      </div>
    <?php endif; ?>

    <!-- Events Section -->
    <h3 class="mt-4">Upcoming Events</h3>
    <a href="<?= url('create.php')?>" class="btn btn-success mb-3">Create New Event</a>

    <?php if (count($events) > 0): ?>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Event Date</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($events as $event): ?>
            <tr>
              <td><?= htmlspecialchars($event['id']) ?></td>
              <td><?= htmlspecialchars($event['title']) ?></td>
              <td><?= htmlspecialchars($event['description']) ?></td>
              <td><?= htmlspecialchars($event['event_date']) ?></td>
              <td>
                <a href="<?= url('update.php?id=' . $event['id']) ?>" class="btn btn-primary">Edit</a>
                <a href="<?= url('delete.php?id=' . $event['id']) ?>" onclick="return confirm('Are You Sure?');" class="btn btn-danger">Delete</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <a style="text-decoration:none" href="logout.php">Logout</a>
    <?php else: ?>
      <div class="alert alert-info">
        <p>No events available.</p>
      </div>
    <?php endif; ?>
  </div>



  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>