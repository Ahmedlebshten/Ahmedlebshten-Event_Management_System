<?php
// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
  // Redirect to login or home if not an admin
  header("Location: login.php");
  exit;
}