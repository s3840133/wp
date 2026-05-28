<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "PetConnect | Add Pet";

include "includes/db_connect.inc";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_SESSION["user_id"];

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

    $image_name = "";

    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {

        $allowed = ["jpg", "jpeg", "png", "gif", "webp"];

        $file_name = $_FILES["image"]["name"];
        $file_tmp = $_FILES["image"]["tmp_name"];

        $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if (!in_array($extension, $allowed)) {
            $error = "Invalid image type. Please upload jpg, jpeg, png, gif, or webp.";
        } else {

            $image_name = uniqid() . "." . $extension;

            $upload_path = __DIR__ . "/assets/images/pets/" . $image_name;

            if (!move_uploaded_file($file_tmp, $upload_path)) {
                die("Image upload failed. Check folder permissions.");
            }

            chmod($upload_path, 0644);
        }

    } else {
        $error = "Please upload a pet image.";
    }

    if (!isset($error)) {

        $sql = "INSERT INTO pets
            (
                user_id,
                name,
                species,
                breed,
                age_years,
                age_months,
                gender,
                size,
                description,
                health_info,
                image_path,
                adoption_fee,
                status
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            die("SQL error: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param(
            $stmt,
            "isssissssssds",
            $user_id,
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
            $status
        );

        if (mysqli_stmt_execute($stmt)) {

            $_SESSION["flash_message"] = "Pet added successfully!";
            $_SESSION["flash_type"] = "success";

            header("Location: pets.php");
            exit;

        } else {
            $error = "Error adding pet.";
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

                    <h1 class="mb-4">Add Pet</h1>

                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Species</label>
                                <select name="species" class="form-control" required>
                                    <option value="Dog">Dog</option>
                                    <option value="Cat">Cat</option>
                                    <option value="Bird">Bird</option>
                                    <option value="Rabbit">Rabbit</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Breed</label>
                                <input type="text" name="breed" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Years</label>
                                <input type="number" name="age_years" class="form-control" value="0">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Months</label>
                                <input type="number" name="age_months" class="form-control" value="0">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-control">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Unknown">Unknown</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Size</label>
                                <select name="size" class="form-control">
                                    <option value="Small">Small</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Large">Large</option>
                                    <option value="Extra Large">Extra Large</option>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="4" required></textarea>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Health Info</label>
                                <textarea name="health_info" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Adoption Fee</label>
                                <input type="number" step="0.01" name="adoption_fee" class="form-control" value="0.00">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-control">
                                    <option value="Available">Available</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Adopted">Adopted</option>
                                </select>
                            </div>

                            <div class="col-12 mb-4">
                                <label class="form-label">Pet Image</label>
                                <input type="file"
                                       name="image"
                                       class="form-control"
                                       accept=".jpg,.jpeg,.png,.gif,.webp"
                                       required>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Add Pet
                        </button>

                    </form>

                </div>
            </div>

        </div>

    </div>

</main>

<?php include "includes/footer.inc"; ?>