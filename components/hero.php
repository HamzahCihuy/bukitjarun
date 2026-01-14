<?php
// 1. INCLUDE KONEKSI
include_once __DIR__ . '/../db/koneksi.php';

// 2. CEK VARIABEL KONEKSI
if (!isset($pdo) && isset($conn)) {
    $pdo = $conn;
}
if (!isset($pdo)) {
    die("Error: Variabel \$pdo tidak ditemukan di hero.php");
}

// 3. AMBIL DATA GAMBAR DARI DATABASE
$stmt = $pdo->query("SELECT image FROM hero_slides WHERE is_active = 1 ORDER BY urutan ASC");
$slides = $stmt->fetchAll(PDO::FETCH_COLUMN);

// Fallback jika database kosong
if (empty($slides)) {
    // Pastikan gambar ini ada di folder 'assets/image/'
    $slides = ['default_banner.jpg']; 
}
?>

<section class="relative overflow-hidden">
  <div
    id="carouselContent"
    class="relative bg-cover bg-center pt-40 pb-40 transition-all duration-700 ease-in-out"
    style="min-height: 600px; background-image: url('<?= htmlspecialchars($slides[0]) ?>');"
>
        <img src="assets/svg/top.svg" class="absolute top-0 left-0 w-full z-20 pointer-events-none" alt="wave top">

        <button onclick="changeSlide(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-[#17FFB2] hover:text-black text-white px-4 py-4 rounded-full z-40 transition-all backdrop-blur-sm border border-white/20 group">
            <i class="fas fa-chevron-left group-hover:scale-125 transition-transform"></i>
        </button>

        <button onclick="changeSlide(1)" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-[#17FFB2] hover:text-black text-white px-4 py-4 rounded-full z-40 transition-all backdrop-blur-sm border border-white/20 group">
            <i class="fas fa-chevron-right group-hover:scale-125 transition-transform"></i>
        </button>

        <div id="dotContainer" class="absolute bottom-16 left-1/2 -translate-x-1/2 z-30 flex gap-3"></div>

        <svg class="absolute bottom-0 left-0 w-full z-20 pointer-events-none h-auto" preserveAspectRatio="none" viewBox="0 0 1498 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_12_2)">
                <path d="M1580.57 -36.788C1572.54 -16.3837 1450.8 22.5854 1000.19 44C516.222 67 -37.5902 93.5833 -254 104L1580.57 104L1580.57 -36.788Z" fill="#17FFB2"/>
                <path d="M-38.6451 -18.8628C-32.0935 -3.66508 67.2855 25.3602 435.141 41.3103C830.23 58.4414 1282.33 78.2414 1459 86L-38.6451 86L-38.6451 -18.8628Z" fill="#17FFB2"/>
            </g>
            <defs>
                <clipPath id="clip0_12_2">
                    <rect width="1498" height="48" fill="white" transform="matrix(-1 0 0 -1 1498 48)"/>
                </clipPath>
            </defs>
        </svg>

    </div>
</section>

<script>
    const images = <?= json_encode($slides) ?>;
    
    // PERBAIKAN DI SINI: Pastikan sesuai nama folder kamu 'image' (tanpa s)
    const pathPrefix = ''; 
    
    let currentIndex = 0;
    const carouselContent = document.getElementById('carouselContent');
    const dotContainer = document.getElementById('dotContainer');
    let slideInterval;

    function initSlider() {
        dotContainer.innerHTML = '';
        images.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.className = `w-3 h-3 rounded-full transition-all duration-300 ${index === 0 ? 'bg-[#17FFB2] w-8' : 'bg-white/50 hover:bg-white'}`;
            dot.onclick = () => goToSlide(index);
            dotContainer.appendChild(dot);
        });
        startAutoSlide();
    }

    function showSlide(index) {
        if (index >= images.length) currentIndex = 0;
        else if (index < 0) currentIndex = images.length - 1;
        else currentIndex = index;

        const imgUrl = pathPrefix + images[currentIndex];
        
        const tempImg = new Image();
        tempImg.onload = () => {
             carouselContent.style.backgroundImage = `url('${imgUrl}')`;
        };
        // Tambahkan Error Handling sederhana di Console
        tempImg.onerror = () => {
             console.error("Gagal memuat gambar:", imgUrl);
        };
        tempImg.src = imgUrl;

        const dots = dotContainer.children;
        if(dots.length > 0) {
            for (let i = 0; i < dots.length; i++) {
                if (i === currentIndex) {
                    dots[i].className = 'w-3 h-3 rounded-full transition-all duration-300 bg-[#17FFB2] w-8';
                } else {
                    dots[i].className = 'w-3 h-3 rounded-full transition-all duration-300 bg-white/50 hover:bg-white';
                }
            }
        }
    }

    function changeSlide(direction) {
        stopAutoSlide();
        showSlide(currentIndex + direction);
        startAutoSlide();
    }

    function goToSlide(index) {
        stopAutoSlide();
        showSlide(index);
        startAutoSlide();
    }

    function startAutoSlide() {
        slideInterval = setInterval(() => {
            showSlide(currentIndex + 1);
        }, 5000);
    }

    function stopAutoSlide() {
        clearInterval(slideInterval);
    }

    document.addEventListener('DOMContentLoaded', initSlider);
</script>


