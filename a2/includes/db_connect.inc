<?php
if ($_SERVER['SERVER_NAME'] == 'localhost') {
    // LOCAL (XAMPP)
    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "petconnect";
} else {
    // TITAN (JACOB5)
    $host = "talsprddb02.int.its.rmit.edu.au";
    $user = "S3840133";
    $password = "Ferdilance2202";
    $database = "S3840133";
}

// Create connection
$conn = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>