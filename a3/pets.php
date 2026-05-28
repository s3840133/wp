<?php
$pageTitle = "PetConnect | Browse Pets";

include "includes/db_connect.inc";

$sql = "SELECT 
            pet_id,
            name,
            species,
            breed,
            age_years,
            age_months,
            gender,
            size,
            image_path,
            adoption_fee,
            status
        FROM pets
        ORDER BY created_at DESC";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("SQL error: " . mysqli_error($conn));
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="container py-5">

    <h1 class="mb-4">Browse Pets</h1>

    <?php if ($result && mysqli_num_rows($result) > 0): ?>

        <div class="row g-4">

            <?php while ($pet = mysqli_fetch_assoc($result)): ?>

                <div class="col-sm-6 col-md-4 col-lg-3">

                    <div class="card h-100 shadow-sm pet-card">

                        <?php if (!empty($pet['image_path'])): ?>
                            <img
                                src="assets/images/pets/<?= htmlspecialchars($pet['image_path']) ?>"
                                alt="<?= htmlspecialchars($pet['name']) ?>"
                                class="card-img-top pet-card-img"
                            >
                        <?php else: ?>
                            <div class="bg-secondary text-white text-center p-5">
                                No image
                            </div>
                        <?php endif; ?>

                        <div class="card-body text-center">

                            <h5 class="card-title">
                                <?= htmlspecialchars($pet['name']) ?>
                            </h5>

                            <p class="card-text">
                                <?= htmlspecialchars($pet['species']) ?>
                                <?php if (!empty($pet['breed'])): ?>
                                    | <?= htmlspecialchars($pet['breed']) ?>
                                <?php endif; ?>
                            </p>

                            <p class="card-text">
                                <strong>Status:</strong>
                                <?= htmlspecialchars($pet['status']) ?>
                            </p>

                            <p class="card-text">
                                <strong>Age:</strong>
                                <?= htmlspecialchars($pet['age_years'] ?? 0) ?> years,
                                <?= htmlspecialchars($pet['age_months'] ?? 0) ?> months
                            </p>

                            <p class="card-text">
                                <strong>Fee:</strong>
                                $<?= htmlspecialchars($pet['adoption_fee']) ?>
                            </p>

                            <a href="details.php?id=<?= htmlspecialchars($pet['pet_id']) ?>"
                               class="btn btn-primary">
                                View Details
                            </a>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    <?php else: ?>

        <div class="alert alert-info">
            No pets are currently available.
        </div>

    <?php endif; ?>

</main>

<?php include "includes/footer.inc"; ?>