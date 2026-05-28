<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "PetConnect | Pet Details";

include "includes/db_connect.inc";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: pets.php");
    exit;
}

$pet_id = (int) $_GET["id"];

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

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="container py-5">

    <div class="row">

        <div class="col-lg-5 mb-4">

            <?php if (!empty($pet["image_path"])) : ?>

                <img
                    src="assets/images/pets/<?= htmlspecialchars($pet['image_path']) ?>"
                    alt="<?= htmlspecialchars($pet['name']) ?>"
                    class="img-fluid rounded shadow"
                >

            <?php else : ?>

                <div class="bg-secondary text-white text-center p-5 rounded">
                    No Image Available
                </div>

            <?php endif; ?>

        </div>

        <div class="col-lg-7">

            <h1 class="mb-3">
                <?= htmlspecialchars($pet["name"]) ?>
            </h1>

            <div class="mb-4">

                <span class="badge bg-primary">
                    <?= htmlspecialchars($pet["species"]) ?>
                </span>

                <?php if (!empty($pet["breed"])) : ?>
                    <span class="badge bg-secondary">
                        <?= htmlspecialchars($pet["breed"]) ?>
                    </span>
                <?php endif; ?>

                <span class="badge bg-success">
                    <?= htmlspecialchars($pet["status"]) ?>
                </span>

            </div>

            <div class="row mb-4">

                <div class="col-md-6 mb-3">
                    <strong>Gender:</strong><br>
                    <?= htmlspecialchars($pet["gender"]) ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Size:</strong><br>
                    <?= htmlspecialchars($pet["size"]) ?>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Age:</strong><br>
                    <?= htmlspecialchars($pet["age_years"]) ?> years,
                    <?= htmlspecialchars($pet["age_months"]) ?> months
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Adoption Fee:</strong><br>
                    $<?= htmlspecialchars($pet["adoption_fee"]) ?>
                </div>

            </div>

            <div class="mb-4">

                <h4>Description</h4>

                <p>
                    <?= nl2br(htmlspecialchars($pet["description"])) ?>
                </p>

            </div>

            <div class="mb-4">

                <h4>Health Information</h4>

                <p>
                    <?= nl2br(htmlspecialchars($pet["health_info"])) ?>
                </p>

            </div>

            <div class="mb-4">

                <h4>Contact Owner</h4>

                <p>
                    Please login to contact the owner regarding adoption.
                </p>

            </div>

            <?php if (
                isset($_SESSION["user_id"]) &&
                (int)$_SESSION["user_id"] === (int)$pet["user_id"]
            ) : ?>

                <hr>

                <div class="d-flex gap-2">

                    <a href="edit.php?id=<?= htmlspecialchars($pet['pet_id']) ?>"
                       class="btn btn-warning">
                        Edit Pet
                    </a>

                    <a href="delete_pet.php?id=<?= htmlspecialchars($pet['pet_id']) ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Are you sure you want to delete this pet?');">
                        Delete Pet
                    </a>

                </div>

            <?php endif; ?>

        </div>

    </div>

</main>

<?php include "includes/footer.inc"; ?>