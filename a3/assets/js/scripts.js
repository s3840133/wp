document.addEventListener("DOMContentLoaded", function () {

    // ===============================
    // GALLERY MODAL (CLICK IMAGE)
    // ===============================
    const galleryImages = document.querySelectorAll(".gallery-img");
    const modalImage = document.getElementById("modalImage");
    const modalTitle = document.getElementById("galleryModalLabel");

    galleryImages.forEach((image) => {
        image.addEventListener("click", function () {
            if (modalImage) {
                modalImage.src = this.src;
                modalImage.alt = this.alt;
            }

            if (modalTitle) {
                modalTitle.textContent = this.dataset.title;
            }
        });
    });

    // ===============================
    // DROPDOWN FILTER (GALLERY PAGE)
    // ===============================
    const statusFilter = document.getElementById("statusFilter");
    const galleryItems = document.querySelectorAll(".gallery-item");

    if (statusFilter) {
        statusFilter.addEventListener("change", function () {
            const filterValue = this.value;

            galleryItems.forEach(function (item) {
                if (filterValue === "all" || item.dataset.status === filterValue) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });
    }

    // ===============================
    // IMAGE UPLOAD PREVIEW (ADD PET)
    // ===============================
    const petImageInput = document.getElementById("petImage");
    const imagePreview = document.getElementById("imagePreview");
    const fileError = document.getElementById("fileError");

    if (petImageInput) {
        petImageInput.addEventListener("change", function () {
            const file = this.files[0];

            if (!file) {
                if (imagePreview) {
                    imagePreview.src = "";
                    imagePreview.classList.add("d-none");
                }
                if (fileError) fileError.textContent = "";
                return;
            }

            const validTypes = ["image/jpeg", "image/png", "image/webp", "image/gif"];

            if (!validTypes.includes(file.type)) {
                if (fileError) {
                    fileError.textContent = "Please upload a valid image (JPG, PNG, WEBP, GIF).";
                }

                this.value = "";

                if (imagePreview) {
                    imagePreview.src = "";
                    imagePreview.classList.add("d-none");
                }
                return;
            }

            if (fileError) fileError.textContent = "";

            const reader = new FileReader();
            reader.onload = function (event) {
                if (imagePreview) {
                    imagePreview.src = event.target.result;
                    imagePreview.classList.remove("d-none");
                }
            };
            reader.readAsDataURL(file);
        });
    }

    // ===============================
    // FORM VALIDATION (ADD PET)
    // ===============================
    const petForm = document.getElementById("petForm");

    if (petForm) {
        petForm.addEventListener("submit", function (event) {
            if (!petForm.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
    }

});