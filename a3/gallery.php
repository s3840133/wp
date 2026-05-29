<?php
$pageTitle = "PetConnect | Gallery";

include "includes/db_connect.inc";

function getPetImage($imagePath) {
    if (!empty($imagePath) && file_exists(__DIR__ . "/assets/images/pets/" . $imagePath)) {
        return "assets/images/pets/" . htmlspecialchars($imagePath);
    }

    return "assets/images/banner.jpg";
}

$sql = "SELECT pet_id, name, species, status, image_path 
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

<main class="gallery-page">

    <div class="gallery-wrapper">

        <div class="gallery-top">

            <div>
                <h1 class="gallery-title">Pet Gallery</h1>
                <p class="text-light mb-0">
                    Browse pets by category and view larger previews.
                </p>
            </div>

            <div class="gallery-filter">
                <label for="categoryFilter">
                    <span class="material-icons align-middle">filter_list</span>
                    Filter by species
                </label>

                <select id="categoryFilter" class="form-select">
                    <option value="all">Show All</option>
                    <option value="Dog">Dogs</option>
                    <option value="Cat">Cats</option>
                    <option value="Rabbit">Rabbits</option>
                    <option value="Bird">Birds</option>
                </select>
            </div>

        </div>

        <div class="row g-4">

            <?php while ($pet = mysqli_fetch_assoc($result)): ?>

                <div class="col-sm-6 col-md-4 col-lg-3 gallery-item"
                     data-category="<?= htmlspecialchars($pet['species']) ?>">

                    <div class="card h-100 shadow-sm">

                        <img src="<?= getPetImage($pet['image_path']) ?>"
                             class="card-img-top gallery-img"
                             alt="<?= htmlspecialchars($pet['name']) ?>"
                             data-bs-toggle="modal"
                             data-bs-target="#imageModal"
                             data-img="<?= getPetImage($pet['image_path']) ?>"
                             data-title="<?= htmlspecialchars($pet['name']) ?>">

                        <div class="card-body text-center">

                            <h5 class="card-title">
                                <?= htmlspecialchars($pet['name']) ?>
                            </h5>

                            <p class="card-text">
                                <?= htmlspecialchars($pet['species']) ?> |
                                <?= htmlspecialchars($pet['status']) ?>
                            </p>

                            <a href="details.php?id=<?= htmlspecialchars($pet['pet_id']) ?>"
                               class="btn btn-outline-primary btn-sm">
                                View Details
                            </a>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

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