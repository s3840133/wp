<?php
$pageTitle = "PetConnect | Home";
include "includes/db_connect.inc";

$sql = "SELECT pet_id, name, species, breed, image_path, description, created_at 
        FROM pets 
        ORDER BY created_at DESC 
        LIMIT 4";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$pets = [];
while ($row = mysqli_fetch_assoc($result)) {
    $pets[] = $row;
}

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="container my-5">

    <section class="text-center mb-5">
        <h1 class="display-5 fw-bold">Welcome to PetConnect</h1>
        <p class="lead">Find loving pets waiting for their forever home.</p>
    </section>

    <?php if (!empty($pets)): ?>
        <section class="mb-5">
            <div id="petCarousel" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-indicators">
                    <?php foreach ($pets as $index => $pet): ?>
                        <button type="button"
                                data-bs-target="#petCarousel"
                                data-bs-slide-to="<?= $index ?>"
                                class="<?= $index === 0 ? 'active' : '' ?>">
                        </button>
                    <?php endforeach; ?>
                </div>

                <div class="carousel-inner rounded shadow">
                    <?php foreach ($pets as $index => $pet): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img src="assets/images/pets/<?= htmlspecialchars($pet['image_path']) ?>"
                                 class="d-block w-100 carousel-img"
                                 alt="<?= htmlspecialchars($pet['name']) ?>">
                            <div class="carousel-caption d-none d-md-block">
                                <h5><?= htmlspecialchars($pet['name']) ?></h5>
                                <p><?= htmlspecialchars($pet['species']) ?> - <?= htmlspecialchars($pet['breed']) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#petCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#petCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>

            </div>
        </section>

        <section>
            <h2 class="mb-4">Latest Pets</h2>

            <div class="row g-4">
                <?php foreach ($pets as $pet): ?>
                    <div class="col-md-6 col-lg-3">
                        <div class="card h-100 shadow-sm">
                            <img src="assets/images/pets/<?= htmlspecialchars($pet['image_path']) ?>"
                                 class="card-img-top pet-card-img"
                                 alt="<?= htmlspecialchars($pet['name']) ?>">

                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($pet['name']) ?></h5>
                                <p class="card-text">
                                    <?= htmlspecialchars($pet['species']) ?> -
                                    <?= htmlspecialchars($pet['breed']) ?>
                                </p>
                                <a href="details.php?id=<?= $pet['pet_id'] ?>" class="btn btn-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php else: ?>
        <p>No pets found.</p>
    <?php endif; ?>

</main>

<?php include "includes/footer.inc"; ?>