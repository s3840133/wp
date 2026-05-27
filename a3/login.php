<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "PetConnect | Login";

include "includes/db_connect.inc";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        $error = "Please enter your email and password.";
    } else {

        $sql = "SELECT user_id, username, email, password 
                FROM users 
                WHERE email = ?";

        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            die("SQL error: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {

            if (password_verify($password, $user["password"])) {

                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["username"] = $user["username"];

                $_SESSION["flash_message"] = "Welcome back, " . $user["username"] . "!";
                $_SESSION["flash_type"] = "success";

                header("Location: index.php");
                exit;

            } else {
                $error = "Incorrect email or password.";
            }

        } else {
            $error = "Incorrect email or password.";
        }
    }
}

include "includes/header.inc";
include "includes/nav.inc";
?>

<main class="container py-5">

    <div class="row justify-content-center">
        <div class="col-lg-5">

            <div class="card bg-dark text-light border-0 shadow-lg">
                <div class="card-body p-5">

                    <h1 class="mb-4 text-center">Login</h1>

                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Login
                        </button>

                    </form>

                    <p class="mt-3 text-center">
                        Don't have an account?
                        <a href="register.php">Register here</a>
                    </p>

                </div>
            </div>

        </div>
    </div>

</main>

<?php include "includes/footer.inc"; ?>