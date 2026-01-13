<head>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;700&display=swap" rel="stylesheet">
</head>

<style>
    .font-fun {
        font-family: 'Fredoka', sans-serif;
    }
    
    #event-section .accordion-content {
        transition: max-height 0.4s ease-in-out, opacity 0.4s ease, transform 0.4s ease;
        max-height: 0;
        opacity: 0;
        transform: translateY(-10px);
        overflow: hidden;
        margin-top: 0px;
    }
    #event-section .accordion-item.active .accordion-content {
        opacity: 1;
        transform: translateY(0);
    }

    /* Animasi halus untuk background pattern */
    @keyframes slidePattern {
        from { background-position: 0 0; }
        to { background-position: 50px 0; }
    }
    .group:hover .bg-pattern-animate {
        animation: slidePattern 3s linear infinite;
    }
    @keyframes float-icon {
        0%, 100% { transform: translateY(0) rotate(12deg); }
        50% { transform: translateY(-15px) rotate(0deg); }
    }
    @keyframes float-icon-reverse {
        0%, 100% { transform: translateY(0) rotate(-12deg); }
        50% { transform: translateY(15px) rotate(0deg); }
    }
    
    .animate-float { animation: float-icon 4s ease-in-out infinite; }
    .animate-float-rev { animation: float-icon-reverse 5s ease-in-out infinite; }
</style>

<?php
// 1. KONEKSI DATABASE
include 'koneksi.php';

// 2. AMBIL DATA DARI TABEL EVENTS
// Diurutkan berdasarkan kolom 'urutan' agar kita bisa atur posisi di CMS
$stmt = $pdo->query("SELECT * FROM events ORDER BY urutan ASC");
$list_event = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section id="event-section" class="relative w-full py-16 px-4 overflow-hidden bg-[#17FFB2]">
    
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-green-600/10 pointer-events-none"></div>

    <div class="absolute inset-0 opacity-[0.07] pointer-events-none"
         style="background-image: radial-gradient(#064e3b 2px, transparent 2px); background-size: 20px 20px;">
    </div>

    <div class="absolute -top-20 -left-20 w-80 h-80 bg-yellow-300 rounded-full mix-blend-overlay filter blur-[80px] opacity-40 animate-pulse"></div>
    <div class="absolute top-1/2 -right-20 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-[80px] opacity-30"></div>

    <div class="max-w-2xl mx-auto relative z-10">
        
<div class="text-center mb-16 relative z-20">
    
    <div class="relative inline-block">
        <h2 class="text-6xl md:text-8xl font-black font-fun tracking-wide text-transparent bg-clip-text bg-gradient-to-b from-slate-700 to-slate-900 drop-shadow-sm">
            EVENT ! 
        </h2>

        <div class="absolute -top-6 -right-10 md:-right-14 w-12 h-12 md:w-16 md:h-16 animate-float">
            <img src="https://img.icons8.com/fluency/96/tiktok.png" 
                 alt="TikTok" 
                 class="w-full h-full object-contain filter drop-shadow-lg">
        </div>

        <div class="absolute -bottom-4 -left-10 md:-left-14 w-12 h-12 md:w-16 md:h-16 animate-float-rev">
            <img src="https://img.icons8.com/fluency/96/instagram-new.png" 
                 alt="Instagram" 
                 class="w-full h-full object-contain filter drop-shadow-lg">
        </div>
    </div>

<div class="mt-8 flex justify-center">
    <div class="bg-white/70 backdrop-blur-md border border-white/50 px-8 py-4 rounded-full shadow-sm transform transition duration-300 hover:-translate-y-1 hover:shadow-green-200/50 cursor-default">
        <p class="text-slate-700 font-bold text-lg md:text-xl font-fun flex items-center gap-2">
            
            <span class="relative px-2">
                <span class="absolute inset-0 bg-yellow-300 -skew-y-3 rounded-sm opacity-80"></span>
                <span class="relative text-slate-900 italic font-black">Ngonten</span>
            </span>
            
            <span>disini, dapetin</span>

            <span class="text-green-600 font-black underline decoration-wavy decoration-green-400 decoration-2 underline-offset-4">
                HADIAHNYA
            </span> 
            <span>🎁</span>
        </p>
    </div>
</div>
    
</div>

        <div class="flex flex-col space-y-6">
            <?php foreach($list_event as $row): ?>
            
            <div class="accordion-item group relative" onclick="handleEventClick(this)">
                
                <div class="relative z-20 flex items-center h-16 md:h-20 rounded-full shadow-lg cursor-pointer transform transition-transform duration-300 hover:scale-[1.02] hover:shadow-xl border-b-4 overflow-hidden"
                     style="background: linear-gradient(135deg, <?= $row['color_primary'] ?>, <?= $row['color_accent'] ?>); border-color: <?= $row['color_accent'] ?>;">
                    
                    <div class="absolute inset-0 z-0 opacity-[0.15] pointer-events-none bg-pattern-animate"
                         style="background-image: url('<?= $row['bg_pattern_img'] ?>'); 
                                background-size: 30px; 
                                background-repeat: space;">
                    </div>

                    <div class="absolute z-10 -left-2 md:-left-4 w-20 h-20 md:w-24 md:h-24 flex items-center justify-center filter drop-shadow-lg transition-transform duration-300 group-hover:rotate-12">
                        <img src="<?= $row['reward_img'] ?>" alt="Icon" class="w-full h-full object-contain">
                    </div>

                    <div class="relative z-10 flex-1 pl-20 md:pl-24 pr-4">
                        <h3 class="text-xl md:text-3xl text-white font-fun font-bold leading-none pt-1 drop-shadow-md tracking-wide">
                            <?= $row['title'] ?>
                        </h3>
                    </div>

                    <div class="relative z-10 pr-6 md:pr-8">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center shadow-md bg-white/20 backdrop-blur-sm border border-white/30">
                            <svg class="w-5 h-5 text-white transform transition-transform duration-300 accordion-icon font-bold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="accordion-content relative z-10 w-[95%] mx-auto -mt-6">
                    <div class="bg-white border-x-2 border-b-2 rounded-b-3xl p-6 pt-10 shadow-sm"
                         style="border-color: <?= $row['color_accent'] ?>;">
                        
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 mb-3">
                            <h4 class="text-slate-800 font-bold text-sm uppercase mb-1">🎯 Misi Kamu:</h4>
                            <p class="text-slate-600 font-medium leading-relaxed">
                                <?= $row['mission'] ?>
                            </p>
                        </div>

                        <div class="px-2">
                            <h4 class="text-xs text-slate-400 font-bold uppercase mb-2">Syarat & Ketentuan:</h4>
                            <ul class="space-y-2">
                                <?php 
                                    // LOGIKA BARU:
                                    // Karena di database 'syarat' disimpan sebagai 1 paragraf panjang
                                    // Kita pecah berdasarkan tombol ENTER (Baris baru)
                                    $syarat_items = explode(PHP_EOL, $row['syarat']); 
                                ?>
                                
                                <?php foreach($syarat_items as $syarat): ?>
                                    <?php if(trim($syarat) != ""): // Cek biar baris kosong tidak dicetak ?>
                                    <li class="flex items-start text-sm text-slate-600 font-medium">
                                        <svg class="w-4 h-4 mr-2 mt-0.5" style="color: <?= $row['color_accent'] ?>;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        <?= $syarat ?>
                                    </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <button class="mt-6 w-full text-white font-fun font-bold py-3 rounded-xl shadow-lg hover:opacity-90 transition-opacity"
                                style="background: linear-gradient(to right, <?= $row['color_primary'] ?>, <?= $row['color_accent'] ?>);">
                            Ambil Tantangan
                        </button>
                    </div>
                </div>

            </div>
            <?php endforeach; ?>
        </div> <div class="mt-20 pb-12 flex justify-center relative z-20">
    <div class="relative group cursor-pointer">
        
        <div class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-600 rounded-full blur opacity-40 group-hover:opacity-100 transition duration-500 group-hover:duration-200 animate-tilt"></div>
        
        <a href="./detail-event.php" class="relative block focus:outline-none" role="button">
            
            <span class="absolute inset-0 bg-slate-900 rounded-full translate-y-2 translate-x-0 transition-transform group-hover:translate-y-3 group-active:translate-y-0"></span>

            <span class="relative flex items-center justify-center px-10 py-5 bg-gradient-to-r from-slate-800 to-slate-900 rounded-full border-2 border-slate-700 transform transition-transform duration-100 -translate-y-1 group-hover:-translate-y-2 group-active:translate-y-1">
                
                <svg class="w-5 h-5 text-yellow-400 mr-2 animate-spin-slow opacity-0 group-hover:opacity-100 transition-opacity duration-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>

                <span class="text-3xl mr-3 filter drop-shadow-md transform transition-transform duration-300 group-hover:rotate-45 group-hover:scale-110 group-active:scale-90">
                    🚀
                </span>

                <div class="flex flex-col items-start">
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-widest leading-none mb-1 group-hover:text-yellow-300 transition-colors">Limited Slot</span>
                    <span class="text-2xl md:text-3xl font-black font-fun text-white tracking-wide leading-none group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-white group-hover:to-slate-300">
                      IKUTI EVENT
                    </span>
                </div>

                <svg class="w-6 h-6 text-white ml-4 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </span>
        </a>
    </div>

    <div class="absolute -bottom-4 left-0 right-0 text-center pointer-events-none">
        <span class="inline-block bg-yellow-300 text-slate-900 text-xs font-bold px-3 py-1 rounded-full transform rotate-3 animate-bounce shadow-sm border border-slate-900">
            🔥 Buruan Daftar!
        </span>
    </div>
</div>

<style>
    /* Animasi Aura Berdenyut */
    @keyframes tilt {
        0%, 50%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(1deg); }
        75% { transform: rotate(-1deg); }
    }
    .animate-tilt {
        animation: tilt 5s infinite linear;
    }
    
    /* Animasi Putar Lambat Bintang */
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 3s linear infinite;
    }
</style>

        </div> </section> 

<?php include 'components/wave-white-bottom.php'; ?>

<script>
    function handleEventClick(element) {
        const content = element.querySelector('.accordion-content');
        const icon = element.querySelector('.accordion-icon');
        const isActive = element.classList.contains('active');

        document.querySelectorAll('#event-section .accordion-item').forEach(item => {
            item.classList.remove('active');
            item.querySelector('.accordion-content').style.maxHeight = null;
            item.querySelector('.accordion-icon').style.transform = 'rotate(0deg)';
        });

        if (!isActive) {
            element.classList.add('active');
            content.style.maxHeight = (content.scrollHeight + 50) + "px"; 
            icon.style.transform = 'rotate(180deg)';

            setTimeout(() => {
                element.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'nearest' });
            }, 300);
        }
    }

</script>
