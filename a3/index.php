<?php
include 'includes/db_connect.inc';

$pageTitle = "PetConnect | Home";

$sql = "SELECT * FROM pets ORDER BY created_at DESC LIMIT 4";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include 'includes/header.inc';
include 'includes/nav.inc';
?>

<main class="p-0 m-0">

    <section class="container-fluid px-0 m-0 p-0">
        <div id="petCarousel" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#petCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#petCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#petCarousel" data-bs-slide-to="2"></button>
                <button type="button" data-bs-target="#petCarousel" data-bs-slide-to="3"></button>
            </div>

            <div class="carousel-inner rounded">
                <div class="carousel-item active">
                    <img src="assets/images/pets/1.jpg" class="d-block w-100" alt="Buddy">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Buddy</h3>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="assets/images/pets/2.jpg" class="d-block w-100" alt="Whiskers">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Whiskers</h3>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="assets/images/pets/3.jpg" class="d-block w-100" alt="Max">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Max</h3>
                    </div>
                </div>

                <div class="carousel-item">
                    <img src="assets/images/pets/4.jpg" class="d-block w-100" alt="Luna">
                    <div class="carousel-caption d-none d-md-block">
                        <h3>Luna</h3>
                    </div>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#petCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#petCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>

        </div>
    </section>

    <section class="pet-section">
        <div class="pets-heading mb-4">
            <h2>
                <span class="material-icons">favorite</span>
                Recently Added Pets
            </h2>
        </div>

        <div class="row g-4 justify-content-center">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm">

                        <img src="assets/images/pets/<?php echo htmlspecialchars($row['image_path']); ?>"
                             class="card-img-top"
                             alt="<?php echo htmlspecialchars($row['name']); ?>">

                        <div class="card-body">
                            <h3 class="h5 card-title">
                                <?php echo htmlspecialchars($row['name']); ?>
                            </h3>

                            <p class="pet-subtitle">
                                <?php echo htmlspecialchars($row['species']); ?> • <?php echo htmlspecialchars($row['breed']); ?>
                            </p>

                            <p class="card-text mb-1">
                                $<?php echo number_format($row['adoption_fee'], 2); ?>
                            </p>
                        </div>

                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

</main>

<?php include 'includes/footer.inc'; ?>