<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid px-3">

            <a class="navbar-brand fw-bold me-4" href="index.php">
                <span class="material-icons align-middle">pets</span>
                PetConnect
            </a>

            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" aria-controls="navMenu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">
                        <a class="nav-link <?php if (($pageTitle ?? '') == 'PetConnect | Home') echo 'active'; ?>" href="index.php">
                            <span class="material-icons nav-icon">home</span>
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php if (($pageTitle ?? '') == 'PetConnect | Browse Pets') echo 'active'; ?>" href="pets.php">
                            <span class="material-icons nav-icon">menu</span>
                            Browse Pets
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php if (($pageTitle ?? '') == 'PetConnect | Gallery') echo 'active'; ?>" href="gallery.php">
                            <span class="material-icons nav-icon">photo_library</span>
                            Gallery
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link <?php if (($pageTitle ?? '') == 'PetConnect | Search') echo 'active'; ?>" href="search.php">
                            <span class="material-icons nav-icon">search</span>
                            Search
                        </a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if (($pageTitle ?? '') == 'PetConnect | Add Pet') echo 'active'; ?>" href="add.php">
                                <span class="material-icons nav-icon">add_circle</span>
                                Add Pet
                            </a>
                        </li>
                    <?php } ?>
                </ul>

                <form class="d-flex me-lg-3 mb-2 mb-lg-0" action="search.php" method="get" role="search">
                    <input class="form-control form-control-sm me-2" type="search" name="q" placeholder="Search pets" aria-label="Search">
                    <button class="btn btn-light btn-sm d-flex align-items-center" type="submit" aria-label="Search">
                        <span class="material-icons nav-icon">search</span>
                    </button>
                </form>

                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <li class="nav-item">
                            <span class="nav-link">
                                <span class="material-icons nav-icon">account_circle</span>
                                <?php echo htmlspecialchars($_SESSION['username'] ?? 'Account'); ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <span class="material-icons nav-icon">logout</span>
                                Logout
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if (($pageTitle ?? '') == 'PetConnect | Login') echo 'active'; ?>" href="login.php">
                                <span class="material-icons nav-icon">login</span>
                                Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if (($pageTitle ?? '') == 'PetConnect | Register') echo 'active'; ?>" href="register.php">
                                <span class="material-icons nav-icon">person_add</span>
                                Register
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
</header>
