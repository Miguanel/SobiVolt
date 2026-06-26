document.addEventListener("DOMContentLoaded", function() {
    // --- LIGHTBOX ---
    const lightbox = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightbox-img");
    const lightboxCaption = document.getElementById("lightbox-caption"); 
    const galleryItems = document.querySelectorAll(".gallery-item img");
    const closeBtn = document.querySelector(".lightbox-close");

    galleryItems.forEach(img => {
        img.parentElement.addEventListener("click", function() {
            lightbox.style.display = "flex";
            lightboxImg.src = img.src;
            lightboxCaption.textContent = img.alt;
        });
    });

    closeBtn.addEventListener("click", function() {
        lightbox.style.display = "none";
    });

    lightbox.addEventListener("click", function(e) {
        if (e.target !== lightboxImg && e.target !== lightboxCaption) {
            lightbox.style.display = "none";
        }
    });
    
    // --- INTERSECTION OBSERVER (Animacje przy przewijaniu - w obie strony) ---
    if ('IntersectionObserver' in window) {
        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -50px 0px', 
            threshold: 0.05 
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Element wjeżdża na ekran - pokazujemy
                    entry.target.classList.add('is-visible');
                } else {
                    // Element znika z ekranu - chowamy z powrotem
                    entry.target.classList.remove('is-visible');
                }
            });
        }, observerOptions);

        const elementsToAnimate = document.querySelectorAll('.gallery-item, .animate-on-scroll');
        elementsToAnimate.forEach(el => {
            observer.observe(el);
        });
    } else {
        document.querySelectorAll('.animate-on-scroll, .gallery-item').forEach(el => {
            el.classList.add('is-visible');
        });
    }
});