<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "PetConnect | Search";

include "includes/db_connect.inc";

function getPetImage($imagePath) {
    if (!empty($imagePath) && file_exists(__DIR__ . "/assets/images/pets/" . $imagePath)) {
        return "assets/images/pets/" . htmlspecialchars($imagePath);
    }

    return "assets/images/banner.jpg";
}

$search = "";

if (isset($_GET["query"])) {
    $search = trim($_GET["query"]);
}

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="container py-5">

    <h1 class="mb-4">Search Pets</h1>

    <form method="GET" action="search.php" class="mb-5">
        <div class="input-group">
            <input type="text"
                   name="query"
                   class="form-control"
                   placeholder="Search by name, species, breed or description"
                   value="<?= htmlspecialchars($search) ?>">

            <button type="submit" class="btn btn-primary">
                <span class="material-icons align-middle">search</span>
                Search
            </button>
        </div>
    </form>

    <?php if ($search !== ""): ?>

        <?php
        $search_term = "%" . $search . "%";

        $sql = "SELECT pet_id, name, species, breed, image_path, description, status
                FROM pets
                WHERE name LIKE ?
                   OR species LIKE ?
                   OR breed LIKE ?
                   OR description LIKE ?
                ORDER BY created_at DESC";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            die("SQL error: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param(
            $stmt,
            "ssss",
            $search_term,
            $search_term,
            $search_term,
            $search_term
        );

        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        ?>

        <h2 class="mb-4">Results for "<?= htmlspecialchars($search) ?>"</h2>

        <?php if ($result && mysqli_num_rows($result) > 0): ?>

            <div class="row g-4">

                <?php while ($pet = mysqli_fetch_assoc($result)): ?>

                    <div class="col-sm-6 col-md-4 col-lg-3">

                        <div class="card h-100 shadow-sm">

                            <img src="<?= getPetImage($pet['image_path']) ?>"
                                 class="card-img-top pet-card-img"
                                 alt="<?= htmlspecialchars($pet["name"]) ?>">

                            <div class="card-body text-center">

                                <h5 class="card-title">
                                    <?= htmlspecialchars($pet["name"]) ?>
                                </h5>

                                <p class="card-text">
                                    <?= htmlspecialchars($pet["species"]) ?>
                                    <?php if (!empty($pet["breed"])): ?>
                                        | <?= htmlspecialchars($pet["breed"]) ?>
                                    <?php endif; ?>
                                </p>

                                <p class="card-text">
                                    <strong>Status:</strong>
                                    <?= htmlspecialchars($pet["status"]) ?>
                                </p>

                                <a href="details.php?id=<?= htmlspecialchars($pet["pet_id"]) ?>"
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
                No pets matched your search.
            </div>

        <?php endif; ?>

    <?php else: ?>

        <div class="alert alert-secondary">
            Enter a search term to find pets.
        </div>

    <?php endif; ?>

</main>

<?php include "includes/footer.inc"; ?>