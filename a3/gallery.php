<?php
$pageTitle = "PetConnect | Gallery";
include "includes/db_connect.inc";

$sql = "SELECT pet_id, name, species, status, image_path 
        FROM pets 
        ORDER BY created_at DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="container my-5">

    <section class="text-center mb-4">
        <h1>Pet Gallery</h1>
        <p class="lead">Browse pets by category and view larger previews.</p>
    </section>

    <div class="mb-4">
        <label for="categoryFilter" class="form-label">Filter by species</label>
        <select id="categoryFilter" class="form-select">
            <option value="all">All</option>
            <option value="Dog">Dog</option>
            <option value="Cat">Cat</option>
            <option value="Rabbit">Rabbit</option>
            <option value="Bird">Bird</option>
        </select>
    </div>

    <div class="row g-4">
        <?php while ($pet = mysqli_fetch_assoc($result)): ?>
            <div class="col-sm-6 col-md-4 col-lg-3 gallery-item"
                 data-category="<?= htmlspecialchars($pet['species']) ?>">

                <div class="card h-100 shadow-sm">
                    <img src="assets/images/pets/<?= htmlspecialchars($pet['image_path']) ?>"
                         class="card-img-top gallery-img"
                         alt="<?= htmlspecialchars($pet['name']) ?>"
                         data-bs-toggle="modal"
                         data-bs-target="#imageModal"
                         data-img="assets/images/pets/<?= htmlspecialchars($pet['image_path']) ?>"
                         data-title="<?= htmlspecialchars($pet['name']) ?>">

                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($pet['name']) ?></h5>
                        <p class="card-text">
                            <?= htmlspecialchars($pet['species']) ?> |
                            <?= htmlspecialchars($pet['status']) ?>
                        </p>
                        <a href="details.php?id=<?= $pet['pet_id'] ?>" class="btn btn-outline-primary btn-sm">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
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