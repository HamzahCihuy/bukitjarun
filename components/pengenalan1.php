<link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Kalam:wght@400;700&display=swap" rel="stylesheet">

<style>
    /* Animasi Monyet Melayang (Naik Turun Halus) */
    @keyframes float-monkey {
        0%, 100% { transform: translateY(0) rotate(-10deg); }
        50% { transform: translateY(-15px) rotate(-10deg); }
    }
    .animate-float-monkey {
        animation: float-monkey 3s ease-in-out infinite;
    }
</style>

<section class="relative w-full min-h-[80vh] flex items-center justify-center overflow-hidden bg-white">
    
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1533587851505-d119e13fa0d7?q=80&w=2070&auto=format&fit=crop" 
             alt="Background Alam" 
             class="w-full h-full object-cover opacity-[0.05] grayscale"> 
        <div class="absolute inset-0 bg-gradient-to-b from-white via-white/80 to-transparent"></div>
    </div>

    <div class="absolute top-0 right-0 w-80 h-80 bg-green-200 rounded-full mix-blend-multiply filter blur-[80px] opacity-30 animate-pulse"></div>
    <div class="absolute bottom-0 left-0 w-80 h-80 bg-yellow-200 rounded-full mix-blend-multiply filter blur-[80px] opacity-30"></div>

    <div class="relative z-10 container mx-auto px-6 text-center" style="margin-top:15px;">
        
        <div class="mb-6 inline-block animate-bounce">
            <div class="bg-[#1a4d2e] text-white px-6 py-2 rounded-full transform -rotate-3 shadow-xl border-4 border-[#17FFB2]">
                <span class="font-black text-xl md:text-2xl tracking-tighter font-sans">FREE HTM !</span>
            </div>
        </div>

        <h1 class="text-[#1a4d2e] text-5xl md:text-7xl font-black tracking-tight mb-2 drop-shadow-sm font-sans">
            BUKIT & SUNGAI
        </h1>
        
        <h2 class="text-[#17FFB2] text-7xl md:text-9xl mb-8 transform -rotate-2 drop-shadow-[2px_2px_0px_rgba(26,77,46,1)]" 
            style="font-family: 'Permanent Marker', cursive; -webkit-text-stroke: 2px #1a4d2e;">
            JAR'UN
        </h2>

        <div class="relative max-w-2xl mx-auto bg-green-50 border border-green-100 p-6 rounded-2xl mb-8 shadow-sm">
            
            <div class="absolute -top-16 -left-6 md:-left-12 w-24 md:w-40 animate-float-monkey pointer-events-none">
                <img src="assets/image/monyetjarun.png" 
                     alt="Monyet Jarun" 
                     class="w-full h-auto drop-shadow-xl">
            </div>

            <p class="text-slate-600 text-lg md:text-xl font-bold leading-relaxed relative z-10" style="font-family: 'Kalam', cursive;">
                "Nikmati keindahan tebing dan sungai tanpa lelah! <br>
                <span class="text-white bg-[#1a4d2e] px-2 py-0.5 rounded transform rotate-1 inline-block mx-1">NO TRACK!</span> 
                Cukup pakai Motor/Mobil sampai lokasi."
            </p>
        </div>

    </div>

    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none rotate-180 z-0">
        <svg class="relative block w-[calc(100%+1.3px)] h-[60px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" fill="#17FFB2"></path>
        </svg>
    </div>
</section>