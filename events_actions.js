const overlay = document.getElementById("modalOverlay");
const modal = document.getElementById("modalBox");

document.addEventListener("click", e => {
    const card = e.target.closest(".event-card");
    if (!card) return;

    const eventId = card.dataset.id;

    if (e.target.classList.contains("edit-btn")) {
        loadModal("edit_event.php", eventId);
    }

    if (e.target.classList.contains("delete-btn")) {
        loadModal("delete_event.php", eventId);
    }

    if (e.target.classList.contains("upload-btn")) {
        loadModal("upload_photos.php", eventId);
    }
});

function loadModal(url, id) {
    fetch(`${url}?id=${id}`)
        .then(res => res.text())
        .then(html => {
            modal.innerHTML = html;
            overlay.classList.remove("hidden");
        });
}

overlay.onclick = e => {
    if (e.target === overlay) overlay.classList.add("hidden");
};
