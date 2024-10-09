<?php
// Fetch admin info with proper error handling
$admin_query = "SELECT * FROM users WHERE is_admin = 1 LIMIT 1";
$admin_result = mysqli_query($connection, $admin_query);

if (!$admin_result || mysqli_num_rows($admin_result) === 0) {
  $admin_info = null;  // No admin found
} else {
  $admin_info = mysqli_fetch_assoc($admin_result);
}