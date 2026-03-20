document.addEventListener("DOMContentLoaded", function () {
    const galleryImages = document.querySelectorAll(".gallery-img");
    const modalImage = document.getElementById("modalImage");
    const modalPetName = document.getElementById("modalPetName");
    const modalPetStatus = document.getElementById("modalPetStatus");
    const modalPetDescription = document.getElementById("modalPetDescription");

    galleryImages.forEach((image) => {
        image.addEventListener("click", function () {
            if (modalImage) {
                modalImage.src = this.src;
                modalImage.alt = this.alt;
            }

            if (modalPetName) {
                modalPetName.textContent = this.dataset.title;
            }

            if (modalPetStatus) {
                modalPetStatus.textContent = "Status: " + this.dataset.statusText;
            }

            if (modalPetDescription) {
                modalPetDescription.textContent = this.dataset.description;
            }
        });
    });

    const filterButtons = document.querySelectorAll(".filter-btn");
    const galleryItems = document.querySelectorAll(".gallery-item");

    filterButtons.forEach((button) => {
        button.addEventListener("click", function () {
            const filterValue = this.dataset.filter;

            filterButtons.forEach((btn) => {
                btn.classList.remove("btn-dark");
                btn.classList.add("btn-outline-dark");
            });

            this.classList.remove("btn-outline-dark");
            this.classList.add("btn-dark");

            galleryItems.forEach((item) => {
                if (filterValue === "all" || item.dataset.status === filterValue) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });
    });

    const petImageInput = document.getElementById("petImage");
    const imagePreview = document.getElementById("imagePreview");
    const fileError = document.getElementById("fileError");
    const petForm = document.getElementById("petForm");

    if (petImageInput) {
        petImageInput.addEventListener("change", function () {
            const file = this.files[0];

            if (!file) {
                if (imagePreview) {
                    imagePreview.src = "";
                    imagePreview.classList.add("d-none");
                }

                if (fileError) {
                    fileError.textContent = "";
                }
                return;
            }

            const validTypes = ["image/jpeg", "image/png", "image/webp"];

            if (!validTypes.includes(file.type)) {
                if (fileError) {
                    fileError.textContent = "Please upload a valid image file (JPG, JPEG, PNG, or WEBP).";
                }

                this.value = "";

                if (imagePreview) {
                    imagePreview.src = "";
                    imagePreview.classList.add("d-none");
                }
                return;
            }

            if (fileError) {
                fileError.textContent = "";
            }

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

    if (petForm) {
        petForm.addEventListener("submit", function (event) {
            if (!petForm.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
        });
    }
});