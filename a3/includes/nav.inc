<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">

    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="index.php">
            <span class="material-icons align-middle">pets</span>
            PetConnect
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        <span class="material-icons align-middle">home</span>
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="pets.php">
                        <span class="material-icons align-middle">menu</span>
                        Browse Pets
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="gallery.php">
                        <span class="material-icons align-middle">photo_library</span>
                        Gallery
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="search.php">
                        <span class="material-icons align-middle">search</span>
                        Search
                    </a>
                </li>

                <?php if (isset($_SESSION['user_id'])) : ?>

                    <li class="nav-item">
                        <a class="nav-link" href="add.php">
                            <span class="material-icons align-middle">add_circle</span>
                            Add Pet
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

            <form class="d-flex me-3" action="search.php" method="GET">

                <input class="form-control me-2"
                       type="search"
                       name="query"
                       placeholder="Search pets">

                <button class="btn btn-light" type="submit">
                    <span class="material-icons align-middle">search</span>
                </button>

            </form>

            <?php if (isset($_SESSION['user_id'])) : ?>

                <span class="navbar-text text-light me-3">
                    Welcome, <?= htmlspecialchars($_SESSION['username']) ?>
                </span>

                <a href="logout.php" class="btn btn-outline-light">
                    <span class="material-icons align-middle">logout</span>
                    Logout
                </a>

            <?php else : ?>

                <a href="login.php" class="btn btn-outline-light me-2">
                    <span class="material-icons align-middle">login</span>
                    Login
                </a>

                <a href="register.php" class="btn btn-primary">
                    <span class="material-icons align-middle">person_add</span>
                    Register
                </a>

            <?php endif; ?>

        </div>

    </div>

</nav>