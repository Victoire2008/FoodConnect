<!-- resources/views/components/hero-slider.blade.php -->
<div class="hero-slider">
    <div class="slide active">
        <img src="/images/hero-food.jpeg" alt="Plat 1">
    </div>
    <div class="slide">
        <img src="/images/hero-food-2.jpg" alt="Plat 2">
    </div>
    
    <div class="slide">
        <img src="/images/hero-food-4.jpg" alt="Plat 4">
    </div>

    <div class="slide">
        <img src="/images/hero-food-5.jpg" alt="Plat 4">
    </div>

    <!-- Indicateurs (points) -->
    <div class="slider-dots">
        <span class="dot active" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
        <span class="dot" onclick="currentSlide(3)"></span>
        <span class="dot" onclick="currentSlide(4)"></span>
    </div>

    <!-- Flèches navigation (optionnel) -->
    <button class="slider-arrow prev" onclick="changeSlide(-1)">&#10094;</button>
    <button class="slider-arrow next" onclick="changeSlide(1)">&#10095;</button>
</div>

<style>
    .hero-slider {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .slide {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 1s ease-in-out;
    }

    .slide.active {
        opacity: 1;
        z-index: 1;
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Indicateurs (points) */
    .slider-dots {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 10px;
        z-index: 10;
    }

    .dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .dot:hover {
        background: rgba(255, 255, 255, 0.8);
    }

    .dot.active {
        background: white;
        width: 30px;
        border-radius: 6px;
    }

    /* Flèches de navigation */
    .slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0, 0, 0, 0.5);
        color: white;
        border: none;
        font-size: 24px;
        padding: 15px 20px;
        cursor: pointer;
        z-index: 10;
        transition: background 0.3s ease;
    }

    .slider-arrow:hover {
        background: rgba(0, 0, 0, 0.8);
    }

    .slider-arrow.prev {
        left: 20px;
    }

    .slider-arrow.next {
        right: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .slider-arrow {
            padding: 10px 15px;
            font-size: 18px;
        }

        .slider-arrow.prev {
            left: 10px;
        }

        .slider-arrow.next {
            right: 10px;
        }
    }


    .slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    animation: kenBurns 10s ease-in-out infinite alternate;
}

@keyframes kenBurns {
    0% {
        transform: scale(1) translate(0, 0);
    }
    100% {
        transform: scale(1.1) translate(-2%, -2%);
    }
}
</style>

<script>
    let currentSlideIndex = 1;
    let autoSlideInterval;

    // Défilement automatique toutes les 5 secondes
    function startAutoSlide() {
        autoSlideInterval = setInterval(() => {
            changeSlide(1);
        }, 5000);
    }

    function stopAutoSlide() {
        clearInterval(autoSlideInterval);
    }

    function changeSlide(direction) {
        stopAutoSlide();
        showSlide(currentSlideIndex += direction);
        startAutoSlide();
    }

    function currentSlide(n) {
        stopAutoSlide();
        showSlide(currentSlideIndex = n);
        startAutoSlide();
    }

    function showSlide(n) {
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.dot');

        if (n > slides.length) {
            currentSlideIndex = 1;
        }
        if (n < 1) {
            currentSlideIndex = slides.length;
        }

        // Retirer la classe active de toutes les slides et dots
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        // Ajouter la classe active à la slide et dot actuels
        slides[currentSlideIndex - 1].classList.add('active');
        dots[currentSlideIndex - 1].classList.add('active');
    }

    // Démarrer le défilement automatique au chargement
    document.addEventListener('DOMContentLoaded', () => {
        startAutoSlide();
    });

    // Pause au survol
    document.querySelector('.hero-slider')?.addEventListener('mouseenter', stopAutoSlide);
    document.querySelector('.hero-slider')?.addEventListener('mouseleave', startAutoSlide);
</script>