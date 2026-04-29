<?php
include 'includes/db_connect.inc';

$pageTitle = "PetConnect | Add Pet";

include 'includes/header.inc';
include 'includes/nav.inc';
?>

<main class="add-page">
    <div class="container d-flex justify-content-center">
        <div class="col-lg-7">

            <h1 class="add-title">
                <span class="material-icons">add_circle</span>
                Add a New Pet for Adoption
            </h1>

            <form method="POST" action="process_add.php" enctype="multipart/form-data" id="petForm" class="card p-4 shadow-lg">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Pet Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Species *</label>
                        <select name="species" class="form-select" required>
                            <option value="">Select species</option>
                            <option>Dog</option>
                            <option>Cat</option>
                            <option>Bird</option>
                            <option>Rabbit</option>
                            <option>Other</option>
                        </select>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Breed *</label>
                    <input type="text" name="breed" class="form-control" required>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Age Years *</label>
                        <input type="number" name="age_years" class="form-control" min="0" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Age Months *</label>
                        <input type="number" name="age_months" class="form-control" min="0" max="11" required>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label class="form-label">Gender *</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select gender</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Size *</label>
                        <select name="size" class="form-select" required>
                            <option value="">Select size</option>
                            <option>Small</option>
                            <option>Medium</option>
                            <option>Large</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Adoption Fee ($) *</label>
                        <input type="number" step="0.01" name="adoption_fee" class="form-control" min="0" required>
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Description *</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mt-3">
                    <label class="form-label">Health Information *</label>
                    <textarea name="health_info" class="form-control" rows="2" required></textarea>
                </div>

                <div class="mt-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="">Select status</option>
                        <option value="Available">Available</option>
                        <option value="Pending">Pending</option>
                        <option value="Adopted">Adopted</option>
                    </select>
                </div>

                <div class="mt-3">
                    <label class="form-label">Pet Photo *</label>
                    <input type="file" name="image" id="petImage" class="form-control" accept=".jpg,.jpeg,.png,.gif,.webp" required>
                    <small id="fileError" class="text-danger"></small>

                    <img id="imagePreview" class="img-fluid mt-3 d-none rounded" alt="Image preview">
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <span class="material-icons align-middle">add</span>
                        Add Pet
                    </button>

                    <a href="gallery.php" class="btn btn-danger">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</main>

<?php include 'includes/footer.inc'; ?>