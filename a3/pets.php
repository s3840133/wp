<?php
$pageTitle = "PetConnect | Pets";
include "includes/db_connect.inc";

$sql = "SELECT pet_id, name, species, breed, age_years, age_months, gender, size, status 
        FROM pets 
        ORDER BY name ASC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="container my-5">

    <div class="row align-items-start">
        <div class="col-md-5 mb-4">
            <img src="assets/images/banner.jpg" class="img-fluid rounded shadow" alt="Pets banner">
        </div>

        <div class="col-md-7">
            <h1 class="mb-4">Browse Pets</h1>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Species</th>
                        <th>Breed</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Status</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php while ($pet = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <a href="details.php?id=<?= $pet['pet_id'] ?>" class="pet-link">
                                    <?= htmlspecialchars($pet['name']) ?>
                                </a>
                            </td>
                            <td><?= htmlspecialchars($pet['species']) ?></td>
                            <td><?= htmlspecialchars($pet['breed']) ?></td>
                            <td>
                                <?= htmlspecialchars($pet['age_years']) ?> years,
                                <?= htmlspecialchars($pet['age_months']) ?> months
                            </td>
                            <td><?= htmlspecialchars($pet['gender']) ?></td>
                            <td><?= htmlspecialchars($pet['status']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

<?php include "includes/footer.inc"; ?>