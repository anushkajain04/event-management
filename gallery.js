fetch("fetch_gallery.php")
    .then(res => res.text())
    .then(html => {
        document.getElementById("galleryContainer").innerHTML = html;
        initializeLightbox();
    });

function initializeLightbox() {
    const images = document.querySelectorAll('.gallery-img');
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightboxImg');
    const closeBtn = document.getElementById('closeBtn');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');

    let currentIndex = 0;

    images.forEach((img, index) => {
        img.addEventListener('click', () => {
            currentIndex = index;
            lightboxImg.src = img.src;
            lightbox.style.display = "flex";
        });
    });

    nextBtn.onclick = () => {
        currentIndex = (currentIndex + 1) % images.length;
        lightboxImg.src = images[currentIndex].src;
    };

    prevBtn.onclick = () => {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        lightboxImg.src = images[currentIndex].src;
    };

    closeBtn.onclick = () => lightbox.style.display = "none";

    lightbox.onclick = (e) => {
        if (e.target === lightbox) lightbox.style.display = "none";
    };
}
