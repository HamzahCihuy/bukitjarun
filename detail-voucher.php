<?php
// MOCK DATA (Sesuaikan dengan data database)
if(!isset($nama_peserta)) $nama_peserta = "Hamzah Pro";
if(!isset($kode_unik)) $kode_unik = "JARUN-CERT-001"; 
if(!isset($username_tiktok)) $username_tiktok = "@hamzah.adventurer"; 
if(!isset($misi)) $misi = "Konten Video Cinematic Alam";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Kreator - Bukit Jar'un</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Great+Vibes&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

    <style>
        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-script { font-family: 'Great Vibes', cursive; }
        .font-serif-play { font-family: 'Playfair Display', serif; }
        .font-sans-mont { font-family: 'Montserrat', sans-serif; }
        
        /* Area Preview (Hidden) */
        #cert-container {
            position: fixed;
            top: -9999px;
            left: 0;
            width: 1080px; /* 9:16 HD */
            height: 1920px;
            background: #0f172a;
            z-index: 9999;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div id="cert-container" class="relative overflow-hidden flex flex-col items-center pt-24 pb-24">

        <div class="absolute inset-0 z-0 bg-[#0a2f23]"> <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/black-scales.png');"></div>
            <div class="absolute top-0 left-0 w-full h-[800px] bg-gradient-to-b from-[#17FFB2]/10 to-transparent"></div>
            <div class="absolute bottom-0 right-0 w-[800px] h-[800px] bg-yellow-500/10 rounded-full blur-[150px]"></div>
        </div>

        <div class="absolute inset-8 border-[6px] border-[#d4af37] rounded-[50px] z-10 pointer-events-none"></div>
        <div class="absolute inset-10 border-[2px] border-[#d4af37]/50 rounded-[42px] z-10 pointer-events-none"></div>

        <div class="relative z-20 w-full px-16 text-center flex flex-col h-full items-center">
            
            <div class="mb-12">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-[#d4af37] rounded-full mb-6 shadow-[0_0_30px_#d4af37]">
                    <span class="text-5xl">🏆</span>
                </div>
                <h3 class="text-[#17FFB2] text-3xl font-bold tracking-[0.4em] font-sans-mont uppercase mb-2">Official Certificate</h3>
                <h1 class="text-white text-7xl font-cinzel font-black drop-shadow-md">
                    OF ACHIEVEMENT
                </h1>
            </div>

            <div class="w-full bg-white/5 backdrop-blur-sm border-y border-[#d4af37]/30 py-12 mb-10">
                <p class="text-slate-300 text-3xl font-serif-play italic mb-8">This certificate is proudly presented to</p>
                
                <div class="mx-auto w-56 h-56 p-1.5 rounded-full bg-gradient-to-tr from-[#d4af37] to-[#f3e5ab] shadow-2xl mb-8 relative">
                    <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=<?= urlencode($nama_peserta) ?>&backgroundColor=b6e3f4" 
                         class="w-full h-full rounded-full object-cover border-4 border-[#0a2f23]">
                    <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-[#0a2f23] text-[#d4af37] px-6 py-2 rounded-full border border-[#d4af37] text-2xl font-bold font-sans-mont whitespace-nowrap">
                        <?= $username_tiktok ?>
                    </div>
                </div>

                <h2 class="text-white text-[80px] font-script leading-tight px-4 mt-6 drop-shadow-[0_4px_4px_rgba(0,0,0,0.5)]">
                    <?= htmlspecialchars($nama_peserta) ?>
                </h2>
            </div>

            <div class="mb-12 space-y-4">
                <p class="text-slate-300 text-2xl font-serif-play tracking-wide">For successfully completing the mission and is hereby recognized as</p>
                
                <div class="relative inline-block py-6 px-12">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-[#d4af37]/20 to-transparent blur-xl"></div>
                    <h2 class="relative text-transparent bg-clip-text bg-gradient-to-r from-[#f3e5ab] via-[#d4af37] to-[#f3e5ab] text-[90px] font-cinzel font-black leading-[1.1] drop-shadow-sm uppercase">
                        KREATOR<br>PECINTA ALAM
                    </h2>
                </div>

                <p class="text-slate-300 text-2xl font-serif-play">at</p>
                <div class="flex items-center justify-center gap-4 text-white text-4xl font-bold font-sans-mont tracking-widest uppercase">
                    <span class="text-[#17FFB2]">🌲 Jar'un Camping Ground</span>
                </div>
            </div>

            <div class="mt-auto w-full grid grid-cols-3 items-end pb-12 px-8">
                
                <div class="text-left">
                    <p class="text-[#d4af37] text-xl font-bold uppercase mb-2 border-b border-[#d4af37]/50 inline-block pb-1">Date</p>
                    <p class="text-white text-3xl font-serif-play"><?= date('F d, Y') ?></p>
                </div>

                <div class="flex justify-center">
                    <div class="relative w-48 h-48 flex items-center justify-center">
                        <div class="absolute inset-0 border-4 border-[#d4af37] rounded-full border-dashed animate-[spin_10s_linear_infinite]"></div>
                        <div class="w-40 h-40 bg-[#d4af37] rounded-full flex items-center justify-center shadow-[0_0_30px_#d4af37] text-[#0a2f23] text-center font-cinzel font-bold text-sm leading-tight p-2">
                            <div class="border border-[#0a2f23] rounded-full w-full h-full flex items-center justify-center flex-col">
                                <span>OFFICIAL</span>
                                <span class="text-3xl block my-1">★</span>
                                <span>VERIFIED</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-right flex flex-col items-end">
                    <div class="w-48 h-20 mb-2 relative">
                         <p class="font-script text-5xl text-white opacity-80 rotate-[-10deg] absolute bottom-0 right-0">Admin Jar'un</p>
                    </div>
                    <p class="text-[#d4af37] text-xl font-bold uppercase border-t border-[#d4af37]/50 pt-2 inline-block">Authorized Signature</p>
                </div>

            </div>

        </div>

    </div>

    <div class="w-full max-w-md mx-auto p-8 bg-white rounded-[40px] shadow-2xl border border-slate-100 text-center relative z-10">
        
        <div class="w-20 h-20 mx-auto bg-gradient-to-tr from-yellow-500 to-yellow-300 rounded-full flex items-center justify-center text-4xl shadow-xl shadow-yellow-500/40 mb-6 text-white border-4 border-white">
            🏆
        </div>
        
        <h3 class="text-3xl font-black text-slate-900 mb-2 font-serif-play">Selamat, Kreator!</h3>
        <p class="text-slate-500 text-sm mb-6 leading-relaxed">
            Kamu resmi diakui sebagai <b>Kreator Pecinta Alam</b> di Bukit Jar'un. Unduh sertifikat ini dan pamerkan prestasimu! 🌲
        </p>

        <button onclick="downloadCert()" id="btn-download-cert" 
                class="w-full py-5 bg-[#0a2f23] text-[#d4af37] rounded-2xl font-bold text-lg shadow-xl hover:bg-[#062219] hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3 group relative overflow-hidden border border-[#d4af37]/30">
            <span class="relative z-10">✨ Unduh Sertifikat</span>
            <svg id="icon-dl" class="w-6 h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            <svg id="icon-loading" class="w-6 h-6 animate-spin hidden relative z-10" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </button>
        
        <p class="text-xs text-slate-400 mt-4 font-bold tracking-wide uppercase">Official Certificate • High Quality</p>
    </div>

    <script>
        function downloadCert() {
            const btn = document.getElementById('btn-download-cert');
            const iconDl = document.getElementById('icon-dl');
            const iconLoad = document.getElementById('icon-loading');
            const container = document.getElementById('cert-container');

            // UI Loading
            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');
            iconDl.classList.add('hidden');
            iconLoad.classList.remove('hidden');

            const options = {
                scale: 1, 
                useCORS: true, 
                backgroundColor: null,
                logging: false
            };

            // Jeda sedikit untuk load font
            setTimeout(() => {
                html2canvas(container, options).then(canvas => {
                    const image = canvas.toDataURL("image/png");
                    const link = document.createElement('a');
                    link.download = 'Sertifikat-Kreator-<?= str_replace(["@", " "], "", $username_tiktok) ?>.png';
                    link.href = image;
                    link.click();

                    // Reset
                    btn.disabled = false;
                    btn.classList.remove('opacity-80', 'cursor-not-allowed');
                    iconDl.classList.remove('hidden');
                    iconLoad.classList.add('hidden');
                    
                }).catch(err => {
                    console.error(err);
                    alert('Gagal membuat sertifikat. Coba lagi!');
                    btn.disabled = false;
                    iconDl.classList.remove('hidden');
                    iconLoad.classList.add('hidden');
                });
            }, 800); // 800ms delay agar aman
        }
    </script>
</body>
</html>
