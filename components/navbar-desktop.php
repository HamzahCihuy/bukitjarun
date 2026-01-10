<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* Font Default */
    nav { font-family: 'Quicksand', sans-serif; }
    
    /* Hover Link */
    .nav-link { @apply flex items-center gap-1 text-[#004996] font-bold text-lg hover:text-blue-500 transition-colors; }

    /* --- LOGIKA TAMPILAN (CSS MANUAL) --- */
    /* Secara default: TAMPIL (Block) */
    .desktop-only-nav {
        display: block !important;
    }

    /* Khusus Layar HP (max-width 768px): SEMBUNYI */
    @media (max-width: 768px) {
        .desktop-only-nav {
            display: none !important;
        }
    }
</style>

<nav class="desktop-only-nav bg-white z-40 pt-6 pb-6 shadow-[0_4px_20px_rgba(0,0,0,0.05)] relative">
    <div class="container mx-auto px-8">
        
        <div class="grid grid-cols-3 items-center mb-8">
            
            <div class="flex gap-2 text-sm font-bold justify-start">
                <button class="text-gray-400 hover:text-[#004996] transition-colors">EN</button>
                <span class="text-gray-300">|</span>
                <button class="text-[#004996]">ID</button>
            </div>

            <div class="flex justify-center">
                <img src="assets/image/logojarun.png" alt="Logo" class="h-14 object-contain">
            </div>

            <div class="flex items-center justify-end gap-3 text-right">
                <div>
                    <div class="text-[#004996] font-bold text-sm">Cerah Berawan</div>
                    <div class="text-gray-500 text-xs font-bold">26.2°C</div>
                </div>
                <i class="fas fa-cloud-sun text-gray-400 text-3xl"></i>
            </div>
        </div>

        <div class="relative flex justify-center items-center">
            
            <div class="flex gap-10 lg:gap-16 items-start">
                <a href="#" class="group flex flex-col items-center gap-1">
                    <span class="text-[#0E5941] font-bold text-lg group-hover:text-blue-500 transition-colors">Aktivitas</span>
                    <i class="fas fa-caret-down text-[#0E5941] opacity-0 group-hover:opacity-100 transition-opacity"></i>
                </a>

                <a href="#" class="group flex flex-col items-center gap-1">
                    <span class="text-[#0E5941] font-bold text-lg group-hover:text-blue-500 transition-colors text-center">Rencanakan<br>Kunjungan</span>
                    <i class="fas fa-caret-down text-[#0E5941] -mt-1"></i>
                </a>

                <a href="#" class="group flex flex-col items-center gap-1">
                    <span class="text-[#0E5941] font-bold text-lg group-hover:text-blue-500 transition-colors text-center">Wahana dan<br>Atraksi</span>
                    <i class="fas fa-caret-down text-[#0E5941]"></i>
                </a>

                <a href="#" class="group flex flex-col items-center gap-1">
                    <span class="text-[#0E5941] font-bold text-lg group-hover:text-blue-500 transition-colors text-center">Tiket dan<br>Paket</span>
                </a>
            </div>

            <div class="absolute right-0 top-1/2 -translate-y-1/2">
                <button class="bg-[#17FFB2] hover:bg-yellow-300 text-[#0E5941] font-bold py-2 px-6 rounded-[20px] flex items-center gap-3 shadow-md transition-transform hover:scale-105">
                    <div class="bg-transparent border-2 border-[#0E5941] rounded p-0.5 w-8 h-6 flex items-center justify-center relative">
                        <i class="fas fa-ticket-alt text-[#0E5941] text-sm"></i>
                    </div>
                    <span class="text-base leading-tight text-left">Pesan<br>Tiket</span>
                </button>
            </div>
            
        </div>
    </div>
</nav>