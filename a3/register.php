<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "PetConnect | Register";

include "includes/db_connect.inc";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $phone = trim($_POST["phone"]);
    $location = trim($_POST["location"]);

    if (
        empty($username) ||
        empty($email) ||
        empty($password) ||
        empty($confirm_password)
    ) {
        $error = "Please fill in all required fields.";
    }

    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    }

    else {

        $check_sql = "SELECT user_id FROM users WHERE email = ? OR username = ?";

        $check_stmt = mysqli_prepare($conn, $check_sql);

        mysqli_stmt_bind_param($check_stmt, "ss", $email, $username);

        mysqli_stmt_execute($check_stmt);

        $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $error = "Username or email already exists.";
        }

        else {

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_sql = "INSERT INTO users 
                (username, email, password, phone, location)
                VALUES (?, ?, ?, ?, ?)";

            $insert_stmt = mysqli_prepare($conn, $insert_sql);

            mysqli_stmt_bind_param(
                $insert_stmt,
                "sssss",
                $username,
                $email,
                $hashed_password,
                $phone,
                $location
            );

            if (mysqli_stmt_execute($insert_stmt)) {

                $_SESSION["flash_message"] = "Registration successful. Please login.";
                $_SESSION["flash_type"] = "success";

                header("Location: login.php");
                exit;
            }

            else {
                $error = "Something went wrong.";
            }
        }
    }
}

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card bg-dark text-light border-0 shadow-lg">

                <div class="card-body p-5">

                    <h1 class="mb-4 text-center">Register</h1>

                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Username *</label>
                            <input type="text"
                                   name="username"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password *</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password *</label>
                            <input type="password"
                                   name="confirm_password"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text"
                                   name="phone"
                                   class="form-control">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Location</label>
                            <input type="text"
                                   name="location"
                                   class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Create Account
                        </button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</main>

<?php include "includes/footer.inc"; ?>