<?php
// Database credentials
$host = "localhost";
$user = "root";
$password = "";
$database = "petconnect";

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>