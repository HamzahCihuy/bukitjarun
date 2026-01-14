<?php
// MOCK DATA (Sesuaikan dengan data database kamu nanti)
if(!isset($nama_peserta)) $nama_peserta = "Hamzah Pro";
if(!isset($kode_unik)) $kode_unik = "JARUN-X7B9"; // Tetap butuh ini untuk QR Code
if(!isset($username_tiktok)) $username_tiktok = "@hamzah.adventurer"; // Data Baru
if(!isset($misi)) $misi = "Selfie dengan Tenda";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket VIP - Bukit Jar'un</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700;900&family=Bebas+Neue&family=Permanent+Marker&display=swap" rel="stylesheet">

    <style>
        .font-bebas { font-family: 'Bebas Neue', sans-serif; }
        .font-marker { font-family: 'Permanent Marker', cursive; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        
        /* Area Preview (Hidden) */
        #ticket-container {
            position: fixed;
            top: -9999px;
            left: 0;
            width: 1080px; /* 9:16 HD */
            height: 1920px;
            background: #020617; /* Slate 950 */
            z-index: 9999;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div id="ticket-container" class="relative overflow-hidden flex flex-col items-center pt-20 pb-20">

        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1478131143081-80f7f84ca84d?q=80&w=1080&auto=format&fit=crop" 
                 class="w-full h-full object-cover filter brightness-[0.4] contrast-125 grayscale-[30%]">
        </div>

        <div class="absolute inset-0 z-0 bg-gradient-to-t from-[#0E5941] via-transparent to-black/80 opacity-90"></div>
        <div class="absolute inset-0 z-0 bg-gradient-to-b from-transparent via-[#17FFB2]/10 to-transparent mix-blend-overlay"></div>

        <div class="absolute top-20 right-10 text-9xl opacity-60 animate-pulse mix-blend-screen">✨</div>
        <div class="absolute bottom-40 left-[-50px] w-96 h-96 bg-[#17FFB2] rounded-full blur-[150px] opacity-20"></div>

        <div class="relative z-10 w-full px-12 text-center">
            <div class="inline-flex items-center gap-3 border border-[#17FFB2]/50 bg-[#17FFB2]/10 px-8 py-3 rounded-full backdrop-blur-md mb-6">
                <span class="w-4 h-4 rounded-full bg-[#17FFB2] shadow-[0_0_10px_#17FFB2]"></span>
                <span class="text-[#17FFB2] text-2xl font-bold tracking-[0.3em] font-outfit uppercase">Official Access Pass</span>
            </div>
            <h1 class="text-white text-[160px] leading-[0.85] font-bebas drop-shadow-[0_20px_40px_rgba(0,0,0,0.8)]">
                BUKIT<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-[#17FFB2] to-yellow-300">JAR'UN</span>
            </h1>
        </div>

        <div class="relative z-10 w-[900px] mt-16 bg-white/5 backdrop-blur-2xl border border-white/20 rounded-[80px] p-12 shadow-[0_50px_100px_-20px_rgba(0,0,0,0.7)] flex flex-col items-center overflow-hidden group">
            
            <div class="absolute -top-[500px] -left-[500px] w-[2000px] h-[2000px] bg-gradient-to-r from-transparent via-white/10 to-transparent rotate-45 transform translate-x-[-100%] animate-[shimmer_3s_infinite]"></div>

            <div class="absolute top-0 right-0 bg-yellow-400 text-black text-4xl font-black px-12 py-4 rounded-bl-[60px] font-outfit tracking-tighter">
                VIP CAMPER
            </div>

            <div class="relative mt-8 mb-8">
                <div class="absolute inset-0 bg-gradient-to-r from-[#17FFB2] to-yellow-400 rounded-full blur-xl opacity-70"></div>
                <div class="w-72 h-72 rounded-full p-2 bg-gradient-to-br from-white to-white/20 relative z-10">
                    <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=<?= urlencode($nama_peserta) ?>&backgroundColor=b6e3f4" 
                         class="w-full h-full rounded-full bg-slate-800 object-cover border-4 border-black">
                </div>
                <div class="absolute bottom-4 right-4 bg-blue-500 text-white w-20 h-20 flex items-center justify-center rounded-full border-4 border-black shadow-lg z-20 text-4xl">
                    ✓
                </div>
            </div>

            <h2 class="text-white text-7xl font-black font-outfit text-center leading-tight mb-2">
                <?= htmlspecialchars($nama_peserta) ?>
            </h2>
            
            <div class="flex items-center gap-4 bg-black/40 px-8 py-4 rounded-2xl border border-white/10 mt-4 mb-10">
                <svg class="w-10 h-10 text-white fill-current" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                <span class="text-[#17FFB2] text-4xl font-bold font-outfit tracking-wide">
                    <?= htmlspecialchars($username_tiktok) ?>
                </span>
            </div>

            <div class="w-full border-t-4 border-dashed border-white/20 my-6"></div>

            <div class="w-full flex justify-between items-center text-left px-4">
                <div>
                    <p class="text-slate-400 text-2xl font-bold uppercase mb-2">Mission</p>
                    <p class="text-white text-3xl font-marker max-w-[500px] leading-snug">
                        "<?= htmlspecialchars($misi) ?>"
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-slate-400 text-2xl font-bold uppercase mb-2">Date</p>
                    <p class="text-yellow-300 text-5xl font-bebas"><?= date('d M Y') ?></p>
                </div>
            </div>

        </div>

        <div class="mt-auto relative z-10 flex flex-col items-center gap-6">
            <div class="bg-white p-5 rounded-[40px] shadow-[0_0_50px_rgba(23,255,178,0.3)]">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= htmlspecialchars($kode_unik) ?>" class="w-40 h-40 mix-blend-multiply">
            </div>
            <div class="text-center">
                <p class="text-[#17FFB2] text-3xl font-bold tracking-[0.5em] opacity-80 font-bebas">SCAN ME AT ENTRANCE</p>
            </div>
        </div>

    </div>

    <div class="w-full max-w-md mx-auto p-8 bg-white rounded-[40px] shadow-2xl border border-slate-100 text-center relative z-10">
        
        <div class="w-20 h-20 mx-auto bg-gradient-to-tr from-black to-slate-800 rounded-2xl flex items-center justify-center text-4xl shadow-xl shadow-slate-400/50 mb-6 text-white rotate-3">
            🎫
        </div>
        
        <h3 class="text-3xl font-black text-slate-900 mb-3 font-outfit">Tiket Sultan Siap!</h3>
        <p class="text-slate-500 text-base mb-8 leading-relaxed">
            Tiket eksklusif atas nama <b class="text-slate-800"><?= htmlspecialchars($username_tiktok) ?></b> sudah jadi. Download dan pamerin di Story sekarang! 🔥
        </p>

        <button onclick="downloadStory()" id="btn-download-story" 
                class="w-full py-5 bg-[#0E5941] text-white rounded-2xl font-bold text-lg shadow-xl shadow-green-900/20 hover:bg-[#093d2c] hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3 group relative overflow-hidden">
            <div class="absolute inset-0 bg-white/20 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
            <span class="relative z-10">🚀 Download Tiket Story</span>
            <svg id="icon-dl" class="w-6 h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            <svg id="icon-loading" class="w-6 h-6 animate-spin hidden relative z-10" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </button>
        
        <p class="text-xs text-slate-400 mt-4 font-bold tracking-wide uppercase">High Quality .PNG • 1080x1920</p>
    </div>

    <script>
        function downloadStory() {
            const btn = document.getElementById('btn-download-story');
            const iconDl = document.getElementById('icon-dl');
            const iconLoad = document.getElementById('icon-loading');
            const container = document.getElementById('ticket-container');

            // UI Loading State
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

            // Beri jeda sedikit agar font terload sempurna
            setTimeout(() => {
                html2canvas(container, options).then(canvas => {
                    const image = canvas.toDataURL("image/png");
                    const link = document.createElement('a');
                    link.download = 'Tiket-Jarun-<?= str_replace(["@", " "], "", $username_tiktok) ?>.png';
                    link.href = image;
                    link.click();

                    // Reset UI
                    btn.disabled = false;
                    btn.classList.remove('opacity-80', 'cursor-not-allowed');
                    iconDl.classList.remove('hidden');
                    iconLoad.classList.add('hidden');
                    
                }).catch(err => {
                    console.error(err);
                    alert('Gagal generate gambar. Coba lagi ya!');
                    btn.disabled = false;
                    iconDl.classList.remove('hidden');
                    iconLoad.classList.add('hidden');
                });
            }, 500);
        }
    </script>
</body>
</html>
