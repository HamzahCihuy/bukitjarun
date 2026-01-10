const slides = [
    {bg: 'assets/image/banner1.png' },
    {bg: 'assets/image/banner2.png' },
    {bg: 'assets/image/banner3.png' },
    {bg: 'assets/image/banner4.png' }
];

let currentSlide = 0;

// Fungsi untuk membuat dots berdasarkan jumlah slide
function createDots() {
    const container = document.getElementById('dotContainer');
    container.innerHTML = ''; // Clear container
    slides.forEach((_, index) => {
        const dot = document.createElement('div');
        dot.className = `w-3 h-3 cursor-pointer transition-all duration-300 ${index === 0 ? 'bg-[#079969] w-8' : 'bg-white/50 hover:bg-white'}`;
        dot.onclick = () => goToSlide(index);
        container.appendChild(dot);
    });
}

function updateSlide(index) {
    const slide = slides[index];
    
    // Update Text dengan animasi sederhana
    const elements = ['slideTitle', 'slidePromo', 'slideBadge', 'slideSubtitle', 'slidePrice', 'slideDates'];
    elements.forEach(id => {
        const el = document.getElementById(id);
        el.style.opacity = 0;
        setTimeout(() => {
            el.textContent = slide[id.replace('slide', '').toLowerCase()];
            el.style.opacity = 1;
        }, 200);
    });

    // Update Background
    document.getElementById('carouselContent').style.backgroundImage =
        `linear-gradient(to right, rgba(255, 255, 255, 0.06) 0%, rgba(0,0,0,0.2) 100%), url('${slide.bg}')`;

    // Update Dots Active State
    const dots = document.querySelectorAll('#dotContainer div');
    dots.forEach((dot, i) => {
        if (i === index) {
            dot.classList.add('bg-[#079969]', 'w-8');
            dot.classList.remove('bg-white/50', 'w-3');
        } else {
            dot.classList.remove('bg-[#079969]', 'w-8');
            dot.classList.add('bg-white/50', 'w-3');
        }
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % slides.length;
    updateSlide(currentSlide);
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
    updateSlide(currentSlide);
}

function goToSlide(index) {
    currentSlide = index;
    updateSlide(currentSlide);
}

document.addEventListener('DOMContentLoaded', () => {
    createDots();
    updateSlide(0);
    // Auto slide setiap 5 detik
    let autoSlide = setInterval(nextSlide, 5000);

    // Stop auto slide saat user klik manual
    const buttons = document.querySelectorAll('button, #dotContainer div');
    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            clearInterval(autoSlide);
            autoSlide = setInterval(nextSlide, 5000);
        });
    });
});