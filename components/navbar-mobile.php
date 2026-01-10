<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">

<style>
    /* Font & Curve khusus Mobile */
    .mobile-nav-container { font-family: 'Quicksand', sans-serif; }
    .mobile-curve {
        border-top-left-radius: 50% 20px;
        border-top-right-radius: 50% 20px;
    }
</style>

<div class="md:hidden block mobile-nav-container">
    
    <nav class="flex justify-between items-center px-4 py-3 bg-white shadow-sm sticky top-0 z-50">
        <div class="w-28">
            <img src="assets/image/logojarun.png" alt="Logo" class="w-full object-contain">
        </div>
        <button class="bg-[#F8ED5B] hover:bg-yellow-300 text-[#004996] font-bold py-1.5 px-3 rounded-full flex items-center gap-2 shadow-sm transition-transform active:scale-95">
            <div class="bg-[#004996] text-white p-1 rounded flex items-center justify-center w-5 h-5">
                <i class="fas fa-ticket-alt text-[10px]"></i>
            </div>
            <span class="text-xs leading-tight text-left font-bold">Ikut<br>Event</span>
        </button>
    </nav>
</div>