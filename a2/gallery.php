<?php
include 'includes/db_connect.inc';

$pageTitle = "PetConnect | Gallery";

$sql = "SELECT pet_id, name, species, breed, status, description, image_path, adoption_fee
        FROM pets
        ORDER BY created_at ASC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include 'includes/header.inc';
include 'includes/nav.inc';
?>

<main class="gallery-page">
    <section class="gallery-wrapper">

        <div class="gallery-top">
            <h1 class="gallery-title">Pet Gallery</h1>

            <div class="gallery-filter">
                <label for="statusFilter">
                    <span class="material-icons align-middle">filter_list</span>
                    Filter by Status:
                </label>

                <select id="statusFilter" class="form-select">
                    <option value="all">Show All</option>
                    <option value="available">Available</option>
                    <option value="pending">Pending</option>
                    <option value="adopted">Adopted</option>
                </select>
            </div>
        </div>

        <div class="row g-4">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col-sm-6 col-lg-3 gallery-item" data-status="<?php echo strtolower(htmlspecialchars($row['status'])); ?>">
                    <div class="card h-100 shadow-sm">

                        <img src="assets/images/pets/<?php echo htmlspecialchars($row['image_path']); ?>"
                             class="card-img-top gallery-img"
                             alt="<?php echo htmlspecialchars($row['name']); ?>"
                             data-bs-toggle="modal"
                             data-bs-target="#galleryModal"
                             data-title="<?php echo htmlspecialchars($row['name']); ?>"
                             data-status-text="<?php echo htmlspecialchars($row['status']); ?>"
                             data-description="<?php echo htmlspecialchars($row['description']); ?>">

                        <div class="card-body">
                            <h3 class="h5 card-title">
                                <?php echo htmlspecialchars($row['name']); ?>
                            </h3>

                            <p>
                                <span class="badge bg-primary">
                                    <?php echo htmlspecialchars($row['species']); ?>
                                </span>

                                <span class="badge bg-danger">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </span>
                            </p>

                            <p class="pet-subtitle">
                                <?php echo htmlspecialchars($row['breed']); ?>
                            </p>

                            <p class="card-text">
                                $<?php echo number_format($row['adoption_fee'], 2); ?>
                            </p>
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div>

    </section>
</main>

<div class="modal fade" id="galleryModal" tabindex="-1" aria-labelledby="galleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="modal-title fs-5" id="galleryModalLabel"></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center">
                <img src="" id="modalImage" class="img-fluid rounded mb-3" alt="Selected pet image">
            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.inc'; ?>