<nav class="navbar navbar-expand-lg">
    <div class="container-fluid px-3 d-flex align-items-center">

        <!-- Logo -->
        <a class="navbar-brand fw-bold me-4" href="index.php">
            <span class="material-icons align-middle">pets</span>
            PetConnect
        </a>

        <!-- Toggle (mobile) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav Links -->
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link <?php if($pageTitle == 'PetConnect | Home') echo 'active'; ?>" href="index.php">
                        <span class="material-icons nav-icon">home</span>
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php if($pageTitle == 'PetConnect | Browse Pets') echo 'active'; ?>" href="pets.php">
                        <span class="material-icons nav-icon">menu</span>
                        Browse Pets
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php if($pageTitle == 'PetConnect | Gallery') echo 'active'; ?>" href="gallery.php">
                        <span class="material-icons nav-icon">photo_library</span>
                        Gallery
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?php if($pageTitle == 'PetConnect | Add Pet') echo 'active'; ?>" href="add.php">
                        <span class="material-icons nav-icon">add_circle</span>
                        Add Pet
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>