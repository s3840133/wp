<?php
include 'includes/db_connect.inc';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: add.php");
    exit();
}

$name = trim($_POST['name']);
$species = trim($_POST['species']);
$breed = trim($_POST['breed']);
$age_years = (int) $_POST['age_years'];
$age_months = (int) $_POST['age_months'];
$gender = trim($_POST['gender']);
$size = trim($_POST['size']);
$adoption_fee = (float) $_POST['adoption_fee'];
$description = trim($_POST['description']);
$health_info = trim($_POST['health_info']);
$status = trim($_POST['status']);

$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    die("Image upload failed.");
}

$original_name = $_FILES['image']['name'];
$image_tmp = $_FILES['image']['tmp_name'];
$extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));

if (!in_array($extension, $allowed_extensions)) {
    die("Invalid image type. Only JPG, JPEG, PNG, GIF and WEBP are allowed.");
}

$new_image_name = uniqid("pet_", true) . "." . $extension;
$upload_path = "assets/images/pets/" . $new_image_name;

if (!move_uploaded_file($image_tmp, $upload_path)) {
    die("Could not save uploaded image.");
}

$sql = "INSERT INTO pets 
(name, species, breed, age_years, age_months, gender, size, adoption_fee, description, health_info, status, image_path, created_at)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sssiissdssss",
    $name,
    $species,
    $breed,
    $age_years,
    $age_months,
    $gender,
    $size,
    $adoption_fee,
    $description,
    $health_info,
    $status,
    $new_image_name
);

mysqli_stmt_execute($stmt);

header("Location: gallery.php");
exit();
?>