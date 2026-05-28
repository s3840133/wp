<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "includes/db_connect.inc";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: pets.php");
    exit;
}

$pet_id = (int) $_GET["id"];
$user_id = (int) $_SESSION["user_id"];

$sql = "SELECT pet_id, user_id, image_path 
        FROM pets 
        WHERE pet_id = ?";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("SQL error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $pet_id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: pets.php");
    exit;
}

$pet = mysqli_fetch_assoc($result);

if ((int)$pet["user_id"] !== $user_id) {
    header("Location: details.php?id=" . $pet_id);
    exit;
}

if (!empty($pet["image_path"])) {
    $image_path = __DIR__ . "/assets/images/pets/" . $pet["image_path"];

    if (file_exists($image_path)) {
        unlink($image_path);
    }
}

$delete_sql = "DELETE FROM pets 
               WHERE pet_id = ? AND user_id = ?";

$delete_stmt = mysqli_prepare($conn, $delete_sql);

if (!$delete_stmt) {
    die("SQL error: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($delete_stmt, "ii", $pet_id, $user_id);

if (mysqli_stmt_execute($delete_stmt)) {
    $_SESSION["flash_message"] = "Pet deleted successfully.";
    $_SESSION["flash_type"] = "success";
}

header("Location: pets.php");
exit;