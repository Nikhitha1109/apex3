<?php
$host = "localhost";
$user = "root";
$pass = ""; // Leave empty if you're using XAMPP with no password
$dbname = "blog";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
