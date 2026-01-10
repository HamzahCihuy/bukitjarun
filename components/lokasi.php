<link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&family=Kalam:wght@400;700&display=swap" rel="stylesheet">

<style>
    /* Font Custom (Sama seperti section sebelumnya) */
    .font-marker { font-family: 'Permanent Marker', cursive; }
    .font-kalam { font-family: 'Kalam', cursive; }

    /* Animasi Pin Memantul */
    @keyframes bounce-pin {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    .animate-pin {
        animation: bounce-pin 2s infinite ease-in-out;
    }
</style>

<section id="lokasi" class="relative w-full py-24 px-4 bg-white overflow-hidden">
    
    <div class="absolute bottom-0 left-0 text-green-800/5 pointer-events-none">
        <svg width="400" height="200" viewBox="0 0 400 200" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 200L125.5 84.5L218.5 155.5L400 45L400 200H0Z" fill="currentColor"/>
        </svg>
    </div>
    <div class="absolute top-20 left-20 text-green-800/5 pointer-events-none">
        <svg width="100" height="100" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 21H21M4 21L12 4L20 21M6 17L8.5 12M18 17L15.5 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <div class="container mx-auto max-w-6xl relative z-10">
        <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
            
            <div class="w-full lg:w-1/2 text-center lg:text-left">
                
                <div class="inline-flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm border border-green-100 mb-6 animate-pulse">
                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                    <span class="text-xs font-bold text-[#0E5941] tracking-wider uppercase">Kab. Tasikmalaya, Pancatengah</span>
                </div>

                <h2 class="text-5xl md:text-6xl font-black text-[#1a4d2e] mb-4 font-marker leading-tight drop-shadow-sm">
                    YUK, OTW KE <br>
                    <span class="text-[#17FFB2] text-stroke-green">BUKIT JAR'UN!</span> 🗺️
                </h2>

                <p class="text-slate-600 text-lg md:text-xl font-kalam mb-8 leading-relaxed">
                    Wisata alam (tahap pengembangan) di <b>Kp. Jati Jaya, Desa Cikawung</b>. Menyuguhkan view Tebing & Sungai Letter S. <br>
                    <span class="bg-yellow-100 text-yellow-800 px-1 font-bold">TIKET MASUK GRATIS (No Pungli)!</span> Nikmati Camping, Rakit, & Mancing sepuasnya.
                </p>
                 <div class="mt-8 p-6 bg-[#064e3b] text-[#17FFB2] rounded-xl shadow-xl relative overflow-hidden transform rotate-1 border-2 border-white/20">
                    <div class="absolute -right-4 -top-8 text-9xl text-white/5 font-serif select-none">"</div>
                    <h3 class="font-black text-xl mb-1 tracking-wide">AKSES OFF-ROAD FRIENDLY!</h3>
                    <p class="text-sm text-green-100 font-medium">Lebih seru pakai motor/mobil tipe off-road untuk pengalaman maksimal.</p>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-green-50 hover:shadow-md transition text-left group">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-xl mb-2 group-hover:scale-110 transition">🚗</div>
                        <h4 class="font-bold text-[#1a4d2e]">Akses Kendaraan</h4>
                        <p class="text-xs text-slate-500">Motor/Mobil (Trail Rec.)</p>
                    </div>
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-green-50 hover:shadow-md transition text-left group">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-xl mb-2 group-hover:scale-110 transition">🥾</div>
                        <h4 class="font-bold text-[#1a4d2e]">Tanpa Mendaki</h4>
                        <p class="text-xs text-slate-500">No Track (Sampai Lokasi)</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="https://goo.gl/maps/placeholder-link" target="_blank" class="flex items-center justify-center gap-3 px-8 py-4 bg-[#17FFB2] hover:bg-[#14532d] text-white font-bold rounded-xl shadow-lg shadow-green-900/20 transition transform hover:-translate-y-1">
                        <span>Buka Google Maps</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </a>
                </div>
            </div>

            <div class="w-full lg:w-1/2 relative">
                
                <div class="relative bg-white p-2 md:p-4 rounded-3xl shadow-2xl transform rotate-2 hover:rotate-0 transition duration-500 z-20">
                    
                    <div class="absolute -left-3 top-1/4 w-6 h-6 bg-slate-100 rounded-full border border-slate-300 shadow-inner z-30"></div>
                    <div class="absolute -left-3 top-2/4 w-6 h-6 bg-slate-100 rounded-full border border-slate-300 shadow-inner z-30"></div>
                    <div class="absolute -left-3 top-3/4 w-6 h-6 bg-slate-100 rounded-full border border-slate-300 shadow-inner z-30"></div>

                    <div class="relative w-full h-[350px] md:h-[450px] rounded-2xl overflow-hidden border border-slate-200">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.9123059325693!2d108.321108275004!3d-7.692560292324721!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e65e91d7e3b3997%3A0xed6ebfd5410ae905!2sPuncak%20Jar'un%20Jati%20Jaya!5e0!3m2!1sid!2sid!4v1767943369741!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" 
                            width="100%" 
                            height="100%" 
                            style="border:0;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            class="grayscale-0 transition duration-700">
                        </iframe>
                        
                        <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>
                        
                        <div class="absolute bottom-4 left-4 bg-white/90 backdrop-blur px-4 py-2 rounded-lg shadow-lg flex items-center gap-2">
                            <span class="w-3 h-3 bg-green-500 rounded-full animate-ping"></span>
                            <span class="text-sm font-bold text-slate-800">Bukit Jar'un</span>
                        </div>
                    </div>
                </div>

                <div class="absolute -top-10 -right-4 z-30 animate-pin pointer-events-none drop-shadow-2xl">
                    <img src="https://img.icons8.com/3d-fluency/94/map-marker.png" alt="Pin Lokasi" class="w-20 h-20 md:w-24 md:h-24">
                </div>

                <div class="absolute top-10 -right-6 w-full h-full bg-[#1a4d2e] rounded-3xl transform -rotate-3 -z-10 opacity-20"></div>

            </div>

        </div>
    </div>
    
</section>
<?php include 'components/wave-white-top.php'; ?>