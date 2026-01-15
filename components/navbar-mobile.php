<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    .mobile-nav-container { font-family: 'Quicksand', sans-serif; }
    
    /* Transisi Menu Mobile */
    #mobile-menu {
        transition: max-height 0.4s ease-in-out, opacity 0.4s ease-in-out;
        max-height: 0;
        opacity: 0;
        overflow: hidden;
    }
    #mobile-menu.open {
        max-height: 400px; /* Sesuaikan tinggi maksimal konten */
        opacity: 1;
    }
</style>

<div class="md:hidden block mobile-nav-container relative z-50">
    
    <nav class="flex justify-between items-center px-5 py-3 bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50 border-b border-slate-100">
        
        <div class="w-24">
            <img src="assets/image/logojarun.png" alt="Logo" class="w-full object-contain">
        </div>

        <button onclick="toggleMobileMenu()" class="text-[#0E5941] focus:outline-none p-2 rounded-lg hover:bg-green-50 transition">
            <svg id="icon-menu" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            
            <svg id="icon-close" class="w-7 h-7 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </nav>

    <div id="mobile-menu" class="bg-white shadow-xl absolute w-full left-0 top-full border-t border-slate-100">
        <div class="flex flex-col p-6 space-y-4">
            
            <a href="#event-section" onclick="toggleMobileMenu()" class="flex items-center gap-3 text-[#0E5941] font-bold text-lg hover:bg-green-50 p-2 rounded-lg transition">
                <span class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-sm">🎉</span>
                Event
            </a>
            
            <a href="#leaderboard" onclick="toggleMobileMenu()" class="flex items-center gap-3 text-[#0E5941] font-bold text-lg hover:bg-green-50 p-2 rounded-lg transition">
                <span class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center text-sm">🏆</span>
                Leaderboard
            </a>
            
            <a href="#menfess" onclick="toggleMobileMenu()" class="flex items-center gap-3 text-[#0E5941] font-bold text-lg hover:bg-green-50 p-2 rounded-lg transition">
                <span class="w-8 h-8 rounded-full bg-pink-100 flex items-center justify-center text-sm">💌</span>
                Menfess
            </a>

            <div class="border-t border-slate-100 my-2"></div>

            <button class="w-full bg-[#17FFB2] hover:bg-green-400 text-[#0E5941] font-bold py-3 px-4 rounded-xl flex items-center justify-center gap-3 shadow-md transition active:scale-95">
                <div class="bg-white/50 border border-[#0E5941] rounded p-1 w-8 h-6 flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-[#0E5941] text-xs"></i>
                </div>
                <span>Pesan Tiket Sekarang</span>
            </button>

        </div>
    </div>

</div>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const iconMenu = document.getElementById('icon-menu');
        const iconClose = document.getElementById('icon-close');

        // Toggle Class 'open' untuk animasi
        if (menu.classList.contains('open')) {
            // Tutup Menu
            menu.classList.remove('open');
            iconMenu.classList.remove('hidden');
            iconClose.classList.add('hidden');
        } else {
            // Buka Menu
            menu.classList.add('open');
            iconMenu.classList.add('hidden');
            iconClose.classList.remove('hidden');
        }
    }
</script>
