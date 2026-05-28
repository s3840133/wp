<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "PetConnect | Edit Pet";

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

$sql = "SELECT * FROM pets WHERE pet_id = ?";
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

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $species = trim($_POST["species"]);
    $breed = trim($_POST["breed"]);
    $age_years = trim($_POST["age_years"]);
    $age_months = trim($_POST["age_months"]);
    $gender = trim($_POST["gender"]);
    $size = trim($_POST["size"]);
    $description = trim($_POST["description"]);
    $health_info = trim($_POST["health_info"]);
    $adoption_fee = trim($_POST["adoption_fee"]);
    $status = trim($_POST["status"]);

    $image_name = $pet["image_path"];

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {

        $allowed = ["jpg", "jpeg", "png", "gif", "webp"];

        $file_name = $_FILES["image"]["name"];
        $file_tmp = $_FILES["image"]["tmp_name"];

        $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed)) {
            $error = "Invalid image type. Please upload jpg, jpeg, png, gif, or webp.";
        } else {

            $new_image_name = uniqid() . "." . $extension;
            $upload_path = __DIR__ . "/assets/images/pets/" . $new_image_name;

            if (!move_uploaded_file($file_tmp, $upload_path)) {
                die("Image upload failed.");
            }

            chmod($upload_path, 0644);

            if (!empty($pet["image_path"])) {
                $old_image_path = __DIR__ . "/assets/images/pets/" . $pet["image_path"];

                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }

            $image_name = $new_image_name;
        }
    }

    if (!isset($error)) {

        $update_sql = "UPDATE pets
                       SET name = ?,
                           species = ?,
                           breed = ?,
                           age_years = ?,
                           age_months = ?,
                           gender = ?,
                           size = ?,
                           description = ?,
                           health_info = ?,
                           image_path = ?,
                           adoption_fee = ?,
                           status = ?
                       WHERE pet_id = ? AND user_id = ?";

        $update_stmt = mysqli_prepare($conn, $update_sql);

        if (!$update_stmt) {
            die("SQL error: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param(
            $update_stmt,
            "sssissssssdsii",
            $name,
            $species,
            $breed,
            $age_years,
            $age_months,
            $gender,
            $size,
            $description,
            $health_info,
            $image_name,
            $adoption_fee,
            $status,
            $pet_id,
            $user_id
        );

        if (mysqli_stmt_execute($update_stmt)) {

            $_SESSION["flash_message"] = "Pet updated successfully!";
            $_SESSION["flash_type"] = "success";

            header("Location: details.php?id=" . $pet_id);
            exit;

        } else {
            $error = "Failed to update pet.";
        }
    }
}

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow-lg border-0">

                <div class="card-body p-5">

                    <h1 class="mb-4">Edit Pet</h1>

                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text"
                                       name="name"
                                       class="form-control"
                                       value="<?= htmlspecialchars($pet['name']) ?>"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Species</label>
                                <select name="species" class="form-control" required>
                                    <option value="Dog" <?= $pet['species'] === 'Dog' ? 'selected' : '' ?>>Dog</option>
                                    <option value="Cat" <?= $pet['species'] === 'Cat' ? 'selected' : '' ?>>Cat</option>
                                    <option value="Bird" <?= $pet['species'] === 'Bird' ? 'selected' : '' ?>>Bird</option>
                                    <option value="Rabbit" <?= $pet['species'] === 'Rabbit' ? 'selected' : '' ?>>Rabbit</option>
                                    <option value="Other" <?= $pet['species'] === 'Other' ? 'selected' : '' ?>>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Breed</label>
                                <input type="text"
                                       name="breed"
                                       class="form-control"
                                       value="<?= htmlspecialchars($pet['breed']) ?>">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Years</label>
                                <input type="number"
                                       name="age_years"
                                       class="form-control"
                                       value="<?= htmlspecialchars($pet['age_years']) ?>">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Months</label>
                                <input type="number"
                                       name="age_months"
                                       class="form-control"
                                       value="<?= htmlspecialchars($pet['age_months']) ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="Male" <?= $pet['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?= $pet['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
                                    <option value="Unknown" <?= $pet['gender'] === 'Unknown' ? 'selected' : '' ?>>Unknown</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Size</label>
                                <select name="size" class="form-control">
                                    <option value="Small" <?= $pet['size'] === 'Small' ? 'selected' : '' ?>>Small</option>
                                    <option value="Medium" <?= $pet['size'] === 'Medium' ? 'selected' : '' ?>>Medium</option>
                                    <option value="Large" <?= $pet['size'] === 'Large' ? 'selected' : '' ?>>Large</option>
                                    <option value="Extra Large" <?= $pet['size'] === 'Extra Large' ? 'selected' : '' ?>>Extra Large</option>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description"
                                          class="form-control"
                                          rows="4"
                                          required><?= htmlspecialchars($pet['description']) ?></textarea>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Health Info</label>
                                <textarea name="health_info"
                                          class="form-control"
                                          rows="3"><?= htmlspecialchars($pet['health_info']) ?></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Adoption Fee</label>
                                <input type="number"
                                       step="0.01"
                                       name="adoption_fee"
                                       class="form-control"
                                       value="<?= htmlspecialchars($pet['adoption_fee']) ?>">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="Available" <?= $pet['status'] === 'Available' ? 'selected' : '' ?>>Available</option>
                                    <option value="Pending" <?= $pet['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
                                    <option value="Adopted" <?= $pet['status'] === 'Adopted' ? 'selected' : '' ?>>Adopted</option>
                                </select>
                            </div>

                            <div class="col-12 mb-4">

                                <?php if (!empty($pet['image_path'])) : ?>
                                    <p class="mb-2">Current Image:</p>
                                    <img src="assets/images/pets/<?= htmlspecialchars($pet['image_path']) ?>"
                                         alt="<?= htmlspecialchars($pet['name']) ?>"
                                         class="img-fluid rounded mb-3"
                                         style="max-height: 200px;">
                                <?php endif; ?>

                                <label class="form-label">Replace Image</label>
                                <input type="file"
                                       name="image"
                                       class="form-control"
                                       accept=".jpg,.jpeg,.png,.gif,.webp">
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>

                        <a href="details.php?id=<?= htmlspecialchars($pet_id) ?>" class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>

                </div>
            </div>

        </div>

    </div>

</main>

<?php include "includes/footer.inc"; ?>