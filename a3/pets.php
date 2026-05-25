<?php
include 'includes/db_connect.inc';

$pageTitle = "PetConnect | Browse Pets";

$sql = "SELECT * FROM pets WHERE status = ? ORDER BY name ASC";
$stmt = mysqli_prepare($conn, $sql);

$status = "Available";
mysqli_stmt_bind_param($stmt, "s", $status);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

include 'includes/header.inc';
include 'includes/nav.inc';
?>

<main class="pets-page">

    <section class="pets-wrapper">

        <h1 class="pets-title">All Available Pets</h1>

        <div class="row align-items-start g-4">

            <div class="col-lg-5">
                <img src="assets/images/banner.jpg"
                     class="img-fluid rounded pets-banner"
                     alt="Pets available">
            </div>

            <div class="col-lg-7">
                <div class="table-responsive">
                    <table class="table pets-table">

                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Species</th>
                                <th>Breed</th>
                                <th>Size</th>
                                <th>Fee ($)</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>
                                    <td>
                                        <a href="details.php?id=<?php echo $row['pet_id']; ?>">
                                            <?php echo htmlspecialchars($row['name']); ?>
                                        </a>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['species']); ?></td>
                                    <td><?php echo htmlspecialchars($row['breed']); ?></td>
                                    <td><?php echo htmlspecialchars($row['size']); ?></td>
                                    <td>$<?php echo number_format($row['adoption_fee'], 2); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>

    </section>

</main>

<?php include 'includes/footer.inc'; ?>