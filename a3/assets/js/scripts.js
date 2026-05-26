document.addEventListener("DOMContentLoaded", function () {

    // Gallery category filter
    const categoryFilter = document.getElementById("categoryFilter");
    const galleryItems = document.querySelectorAll(".gallery-item");

    if (categoryFilter) {
        categoryFilter.addEventListener("change", function () {
            const selectedCategory = categoryFilter.value;

            galleryItems.forEach(function (item) {
                const itemCategory = item.dataset.category;

                if (selectedCategory === "all" || itemCategory === selectedCategory) {
                    item.style.display = "block";
                } else {
                    item.style.display = "none";
                }
            });
        });
    }

    // Gallery image modal
    const imageModal = document.getElementById("imageModal");

    if (imageModal) {
        imageModal.addEventListener("show.bs.modal", function (event) {
            const clickedImage = event.relatedTarget;
            const imageSrc = clickedImage.getAttribute("data-img");
            const imageTitle = clickedImage.getAttribute("data-title");

            const modalImage = document.getElementById("modalImage");
            const modalTitle = document.getElementById("modalTitle");

            modalImage.src = imageSrc;
            modalTitle.textContent = imageTitle;
        });
    }

});