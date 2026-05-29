<?php
$pageTitle = "PetConnect | Browse Pets";

include "includes/db_connect.inc";

function getPetImage($imagePath) {
    if (!empty($imagePath) && file_exists(__DIR__ . "/assets/images/pets/" . $imagePath)) {
        return "assets/images/pets/" . htmlspecialchars($imagePath);
    }

    return "assets/images/banner.jpg";
}

$sql = "SELECT 
            pets.pet_id,
            pets.name,
            pets.species,
            pets.breed,
            pets.size,
            pets.adoption_fee,
            pets.image_path,
            users.username
        FROM pets
        LEFT JOIN users ON pets.user_id = users.user_id
        ORDER BY pets.created_at DESC";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("SQL error: " . mysqli_error($conn));
}

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="pets-page">

    <div class="pets-wrapper">

        <h1 class="pets-title">All Available Pets</h1>

        <div class="row align-items-start g-4">

            <div class="col-lg-4">
                <img src="assets/images/banner.jpg"
                     alt="Pets"
                     class="pets-banner shadow">
            </div>

            <div class="col-lg-8">

                <div class="table-responsive">

                    <table class="pets-table">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Species</th>
                                <th>Breed</th>
                                <th>Size</th>
                                <th>Fee ($)</th>
                                <th>Owner</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($pet = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <td>
                                        <a href="details.php?id=<?= htmlspecialchars($pet['pet_id']) ?>">
                                            <?= htmlspecialchars($pet['name']) ?>
                                        </a>
                                    </td>

                                    <td><?= htmlspecialchars($pet['species']) ?></td>
                                    <td><?= htmlspecialchars($pet['breed']) ?></td>
                                    <td><?= htmlspecialchars($pet['size']) ?></td>
                                    <td><?= htmlspecialchars($pet['adoption_fee']) ?></td>
                                    <td><?= htmlspecialchars($pet['username'] ?? 'Unknown') ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</main>

<?php include "includes/footer.inc"; ?>