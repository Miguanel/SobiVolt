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
    
    // --- INTERSECTION OBSERVER (Animacje przy przewijaniu) ---
    if ('IntersectionObserver' in window) {
        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -50px 0px', // Animacja startuje 50px przed dolną krawędzią ekranu
            threshold: 0.05 // Wystarczy, że 5% elementu jest widoczne, by animacja ruszyła
        };

        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    // Przerywamy obserwację po pojawieniu się, by nie migało przy szybkim scrollowaniu
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Złapanie wszystkich elementów do ożywienia w jedną listę
        const elementsToAnimate = document.querySelectorAll('.gallery-item, .animate-on-scroll');
        elementsToAnimate.forEach(el => {
            observer.observe(el);
        });
    } else {
        // Gdyby stara przeglądarka nie wspierała tego mechanizmu, pokaż wszystko od razu
        document.querySelectorAll('.animate-on-scroll, .gallery-item').forEach(el => {
            el.classList.add('is-visible');
        });
    }
});