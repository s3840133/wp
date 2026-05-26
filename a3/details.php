<?php
$pageTitle = "PetConnect | Pet Details";
include "includes/db_connect.inc";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: pets.php");
    exit;
}

$pet_id = (int) $_GET['id'];

$sql = "SELECT 
            pet_id,
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
            status,
            created_at
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

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="container my-5">

    <div class="row g-5">

        <div class="col-md-6">
            <?php if (!empty($pet['image_path'])): ?>
                <img src="assets/images/pets/<?= htmlspecialchars($pet['image_path']) ?>"
                     class="img-fluid rounded shadow detail-img gallery-img"
                     alt="<?= htmlspecialchars($pet['name']) ?>"
                     data-bs-toggle="modal"
                     data-bs-target="#imageModal"
                     data-img="assets/images/pets/<?= htmlspecialchars($pet['image_path']) ?>"
                     data-title="<?= htmlspecialchars($pet['name']) ?>">
            <?php else: ?>
                <div class="alert alert-secondary">
                    No image available.
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h1><?= htmlspecialchars($pet['name']) ?></h1>

            <p class="text-muted">
                <?= htmlspecialchars($pet['species']) ?>
                <?php if (!empty($pet['breed'])): ?>
                    - <?= htmlspecialchars($pet['breed']) ?>
                <?php endif; ?>
            </p>

            <p>
                <strong>Age:</strong>
                <?= htmlspecialchars($pet['age_years'] ?? '0') ?> years,
                <?= htmlspecialchars($pet['age_months'] ?? '0') ?> months
            </p>

            <p><strong>Gender:</strong> <?= htmlspecialchars($pet['gender']) ?></p>
            <p><strong>Size:</strong> <?= htmlspecialchars($pet['size']) ?></p>
            <p><strong>Status:</strong> <?= htmlspecialchars($pet['status']) ?></p>
            <p><strong>Adoption Fee:</strong> $<?= htmlspecialchars($pet['adoption_fee']) ?></p>

            <hr>

            <h3>Description</h3>
            <p><?= nl2br(htmlspecialchars($pet['description'])) ?></p>

            <h3>Health Information</h3>
            <p>
                <?= !empty($pet['health_info'])
                    ? nl2br(htmlspecialchars($pet['health_info']))
                    : "No health information provided." ?>
            </p>

            <hr>

            <h3>Contact Owner</h3>
            <p>Owner details will be available after login and ownership features are added.</p>

        </div>
    </div>

</main>

<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle" class="modal-title">Pet Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid rounded" alt="Pet preview">
            </div>
        </div>
    </div>
</div>

<?php include "includes/footer.inc"; ?>