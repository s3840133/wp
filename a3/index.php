<?php

$pageTitle = "PetConnect | Home";

include "includes/db_connect.inc";

function getPetImage($imagePath) {
    if (!empty($imagePath) && file_exists(__DIR__ . "/assets/images/pets/" . $imagePath)) {
        return "assets/images/pets/" . htmlspecialchars($imagePath);
    }

    return "assets/images/banner.jpg";
}

$sql = "SELECT pets.*, users.username
        FROM pets
        LEFT JOIN users ON pets.user_id = users.user_id
        ORDER BY pets.created_at DESC
        LIMIT 5";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("SQL error: " . mysqli_error($conn));
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$pets = [];

while ($row = mysqli_fetch_assoc($result)) {
    $pets[] = $row;
}

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="container-fluid p-0">

    <div id="petCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">

        <div class="carousel-inner">

            <?php foreach ($pets as $index => $pet) : ?>

                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">

                    <img src="<?= getPetImage($pet['image_path']) ?>"
                         class="d-block w-100 hero-carousel-img"
                         alt="<?= htmlspecialchars($pet['name']) ?>">

                    <div class="carousel-caption hero-caption">

                        <h2><?= htmlspecialchars($pet['name']) ?></h2>

                        <a href="details.php?id=<?= htmlspecialchars($pet['pet_id']) ?>"
                           class="btn btn-light">
                            <span class="material-icons align-middle">visibility</span>
                            View Details
                        </a>

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

    <section class="pet-section">

        <div class="pets-heading">
            <h2>
                <span class="material-icons">favorite</span>
                Recently Added Pets
            </h2>
        </div>

        <div class="row g-4">

            <?php foreach ($pets as $pet) : ?>

                <div class="col-sm-6 col-md-4 col-lg-3">

                    <div class="card h-100 shadow-sm">

                        <img src="<?= getPetImage($pet['image_path']) ?>"
                             class="card-img-top pet-card-img"
                             alt="<?= htmlspecialchars($pet['name']) ?>">

                        <div class="card-body">

                            <h5 class="card-title">
                                <?= htmlspecialchars($pet['name']) ?>
                            </h5>

                            <p class="pet-subtitle">
                                <?= htmlspecialchars($pet['species']) ?>
                                <?php if (!empty($pet['breed'])) : ?>
                                    | <?= htmlspecialchars($pet['breed']) ?>
                                <?php endif; ?>
                            </p>

                            <p class="card-text">
                                $<?= htmlspecialchars($pet['adoption_fee']) ?>
                            </p>

                            <p class="pet-subtitle">
                                <?= htmlspecialchars($pet['username'] ?? 'Unknown') ?>
                            </p>

                            <a href="details.php?id=<?= htmlspecialchars($pet['pet_id']) ?>"
                               class="btn btn-primary btn-sm">
                                <span class="material-icons align-middle">visibility</span>
                                View Details
                            </a>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </section>

</main>

<?php include "includes/footer.inc"; ?>