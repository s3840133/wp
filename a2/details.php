<?php
include 'includes/db_connect.inc';

$pageTitle = "PetConnect | Details";

if (!isset($_GET['id'])) {
    die("No pet selected.");
}

$pet_id = $_GET['id'];

$sql = "SELECT * FROM pets WHERE pet_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $pet_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    die("Pet not found.");
}

$pet = mysqli_fetch_assoc($result);

include 'includes/header.inc';
include 'includes/nav.inc';
?>

<main class="details-page">
    <section class="details-wrapper">

        <div class="row g-4 align-items-start">

            <div class="col-lg-5">
                <img src="assets/images/pets/<?php echo htmlspecialchars($pet['image_path']); ?>"
                     class="details-img"
                     alt="<?php echo htmlspecialchars($pet['name']); ?>">
            </div>

            <div class="col-lg-7">
                <h1 class="details-title">
                    <?php echo htmlspecialchars($pet['name']); ?>
                </h1>

                <div class="mb-3">
                    <span class="badge bg-primary"><?php echo htmlspecialchars($pet['species']); ?></span>
                    <span class="badge bg-danger"><?php echo htmlspecialchars($pet['status']); ?></span>
                </div>

                <table class="table details-table">
                    <tr>
                        <th>Breed:</th>
                        <td><?php echo htmlspecialchars($pet['breed']); ?></td>
                    </tr>
                    <tr>
                        <th>Age:</th>
                        <td><?php echo htmlspecialchars($pet['age_years']); ?> years, <?php echo htmlspecialchars($pet['age_months']); ?> months</td>
                    </tr>
                    <tr>
                        <th>Gender:</th>
                        <td><?php echo htmlspecialchars($pet['gender']); ?></td>
                    </tr>
                    <tr>
                        <th>Size:</th>
                        <td><?php echo htmlspecialchars($pet['size']); ?></td>
                    </tr>
                    <tr>
                        <th>Adoption Fee:</th>
                        <td><strong>$<?php echo number_format($pet['adoption_fee'], 2); ?></strong></td>
                    </tr>
                </table>

                <h2 class="details-subtitle">
                    <span class="material-icons align-middle">article</span>
                    Description
                </h2>

                <p class="details-text">
                    <?php echo htmlspecialchars($pet['description']); ?>
                </p>

                <h2 class="details-subtitle">
                    <span class="material-icons align-middle health-icon">health_and_safety</span>
                    Health Information
                </h2>

                <p class="details-text">
                    <?php echo htmlspecialchars($pet['health_info']); ?>
                </p>
            </div>

        </div>

    </section>
</main>

<?php include 'includes/footer.inc'; ?>