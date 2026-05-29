document.addEventListener("DOMContentLoaded", function () {

    const categoryFilter = document.getElementById("categoryFilter");
    const galleryItems = document.querySelectorAll(".gallery-item");

    if (categoryFilter) {
        categoryFilter.addEventListener("change", function () {
            const selectedCategory = categoryFilter.value;

            galleryItems.forEach(function (item) {
                if (selectedCategory === "all" || item.dataset.category === selectedCategory) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });
    }

    const imageModal = document.getElementById("imageModal");

    if (imageModal) {
        imageModal.addEventListener("show.bs.modal", function (event) {
            const clickedImage = event.relatedTarget;

            if (!clickedImage) return;

            const imageSrc = clickedImage.getAttribute("data-img");
            const imageTitle = clickedImage.getAttribute("data-title");

            const modalImage = document.getElementById("modalImage");
            const modalTitle = document.getElementById("modalTitle");

            if (modalImage && imageSrc) modalImage.src = imageSrc;
            if (modalTitle && imageTitle) modalTitle.textContent = imageTitle;
        });
    }

    const imageInput = document.querySelector('input[type="file"][name="image"]');

    if (imageInput) {
        imageInput.addEventListener("change", function () {
            const file = imageInput.files[0];

            if (!file) return;

            const allowedExtensions = ["jpg", "jpeg", "png", "gif", "webp"];
            const extension = file.name.toLowerCase().split(".").pop();

            if (!allowedExtensions.includes(extension)) {
                alert("Invalid file type. Please upload jpg, jpeg, png, gif, or webp only.");
                imageInput.value = "";
                return;
            }

            let preview = document.getElementById("imagePreview");

            if (!preview) {
                preview = document.createElement("img");
                preview.id = "imagePreview";
                preview.className = "img-fluid rounded mt-3";
                preview.style.maxHeight = "220px";
                imageInput.parentNode.appendChild(preview);
            }

            preview.src = URL.createObjectURL(file);
        });
    }

});