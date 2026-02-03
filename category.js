document.addEventListener("DOMContentLoaded", () => {

    const filter = document.getElementById("categoryFilter");
    const container = document.getElementById("categoryContainer");

    function sortCategories(order) {
        let cards = Array.from(container.querySelectorAll(".category-card"));

        cards.sort((a, b) => {
            let nameA = a.dataset.name.toLowerCase();
            let nameB = b.dataset.name.toLowerCase();

            if (order === "az") {
                return nameA.localeCompare(nameB);
            } else {
                return nameB.localeCompare(nameA);
            }
        });

        container.innerHTML = "";
        cards.forEach(card => container.appendChild(card));
    }

    // ⭐ Sort A–Z automatically when page loads
    filter.value = "az";
    sortCategories("az");

    // ⭐ Sort again when user changes filter
    filter.addEventListener("change", () => {
        sortCategories(filter.value);
    });

});
