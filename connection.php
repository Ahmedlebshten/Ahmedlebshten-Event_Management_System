<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'event_registration';

$connection = mysqli_connect($host, $user, $pass, $dbname);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>