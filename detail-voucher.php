<?php
// Pastikan variabel ini ada (jika ini file mandiri, biarkan mock data ini. Jika include, hapus bagian ini)
if(!isset($nama_peserta)) $nama_peserta = "Hamzah Pro";
if(!isset($kode_unik)) $kode_unik = "JARUN-X7B9";
if(!isset($misi)) $misi = "Misi: Foto Selfie dengan Tenda";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Kamu - Bukit Jar'un</title>
    
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;700&family=Bebas+Neue&family=Permanent+Marker&display=swap" rel="stylesheet">

    <style>
        .font-bebas { font-family: 'Bebas Neue', sans-serif; }
        .font-marker { font-family: 'Permanent Marker', cursive; }
        .font-fun { font-family: 'Fredoka', sans-serif; }
        
        /* Area Preview (Sembunyikan dari layar tapi tetap dirender) */
        #ticket-container {
            position: fixed;
            top: -9999px; /* Lempar jauh ke atas */
            left: 0;
            width: 1080px; /* Resolusi HD Story 9:16 */
            height: 1920px;
            background: #0f172a;
            z-index: 9999;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div id="ticket-container" class="relative overflow-hidden text-center flex flex-col items-center justify-between pt-24 pb-24">

        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1523987355523-c7b5b0dd90a7?q=80&w=1080&auto=format&fit=crop" 
                 class="w-full h-full object-cover filter brightness-[0.6] contrast-125">
        </div>

        <div class="absolute inset-0 z-0 bg-gradient-to-b from-black/60 via-transparent to-[#0E5941]/90"></div>

        <div class="absolute top-10 right-10 text-8xl opacity-80 animate-pulse">✨</div>
        <div class="absolute top-40 left-10 text-6xl opacity-60">🏕️</div>
        <div class="absolute bottom-40 right-10 text-7xl opacity-80">🔥</div>

        <div class="relative z-10 w-full px-10 pt-10">
            <div class="inline-block border-2 border-[#17FFB2] text-[#17FFB2] px-6 py-2 rounded-full text-2xl font-bold tracking-[0.2em] mb-4 bg-black/20 backdrop-blur-md">
                OFFICIAL TICKET
            </div>
            <h1 class="text-[#17FFB2] text-[140px] leading-none font-bebas drop-shadow-[0_10px_10px_rgba(0,0,0,0.5)]">
                BUKIT JAR'UN
            </h1>
            <p class="text-white text-4xl font-marker mt-2 tracking-wider rotate-[-2deg]">
                The Ultimate Camping Experience! 🌲
            </p>
        </div>

        <div class="relative z-10 w-[850px] bg-white/10 backdrop-blur-xl border border-white/20 rounded-[60px] p-10 shadow-[0_30px_60px_rgba(0,0,0,0.5)] flex flex-col items-center mt-10">
            
            <div class="absolute -top-6 bg-red-600 text-white text-3xl font-bold px-10 py-3 rounded-full shadow-lg font-bebas tracking-widest border-2 border-white/50">
                VERIFIED PARTICIPANT ✅
            </div>

            <div class="w-64 h-64 rounded-full p-2 bg-gradient-to-tr from-[#17FFB2] to-yellow-400 mt-8 mb-6 shadow-2xl relative">
                <img src="https://api.dicebear.com/7.x/adventurer/svg?seed=<?= urlencode($nama_peserta) ?>&backgroundColor=b6e3f4" 
                     class="w-full h-full rounded-full bg-white object-cover">
                <div class="absolute bottom-0 right-0 bg-blue-600 text-white text-4xl p-4 rounded-full border-4 border-white shadow-lg">
                    🚀
                </div>
            </div>

            <h2 class="text-white text-6xl font-black font-fun mb-2 drop-shadow-md">
                <?= htmlspecialchars($nama_peserta) ?>
            </h2>
            <p class="text-[#17FFB2] text-3xl font-bold uppercase tracking-widest mb-10">
                Adventure Seeker
            </p>

            <div class="w-full h-1 bg-gradient-to-r from-transparent via-white/30 to-transparent mb-10"></div>

            <div class="grid grid-cols-2 gap-8 w-full text-left px-4">
                <div class="bg-black/20 p-6 rounded-3xl border border-white/10">
                    <p class="text-slate-300 text-xl font-bold uppercase mb-1">Kode Tiket</p>
                    <p class="text-yellow-400 text-5xl font-bebas tracking-wider"><?= htmlspecialchars($kode_unik) ?></p>
                </div>
                <div class="bg-black/20 p-6 rounded-3xl border border-white/10">
                    <p class="text-slate-300 text-xl font-bold uppercase mb-1">Tanggal</p>
                    <p class="text-white text-4xl font-bold font-fun"><?= date('d M Y') ?></p>
                </div>
            </div>

            <div class="mt-8 bg-[#17FFB2]/20 border border-[#17FFB2]/50 w-full py-6 rounded-3xl text-center">
                <p class="text-[#17FFB2] text-2xl font-bold">🎯 Misi Terkonfirmasi:</p>
                <p class="text-white text-3xl font-marker mt-2">"<?= htmlspecialchars(substr($misi, 0, 30)) ?>..."</p>
            </div>
        </div>

        <div class="relative z-10 mt-auto flex flex-col items-center">
            <div class="bg-white p-4 rounded-3xl mb-6 shadow-lg">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?= htmlspecialchars($kode_unik) ?>" class="w-32 h-32 opacity-90">
            </div>
            <p class="text-white text-3xl font-bold tracking-widest opacity-80">WWW.BUKITJARUN.COM</p>
            <p class="text-slate-400 text-xl mt-2">See you at the top! ⛰️</p>
        </div>

    </div>

    <div class="w-full max-w-md mx-auto p-6 bg-white rounded-3xl shadow-xl border border-slate-100 text-center relative z-10">
        <div class="mb-4 flex justify-center">
            <div class="w-20 h-20 bg-gradient-to-tr from-pink-500 to-orange-400 rounded-2xl flex items-center justify-center text-4xl shadow-lg text-white">
                📸
            </div>
        </div>
        
        <h3 class="text-2xl font-black text-slate-800 mb-2 font-fun">Pamerin Tiketmu!</h3>
        <p class="text-slate-500 text-sm mb-6">
            Download kartu resmi ini dan post di <b>Instagram/WhatsApp Story</b>. Tag temanmu biar mereka iri! 😜
        </p>

        <button onclick="downloadStory()" id="btn-download-story" 
                class="w-full py-4 bg-gradient-to-r from-pink-600 to-purple-600 text-white rounded-xl font-bold text-lg shadow-lg shadow-pink-500/30 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2">
            <span>✨ Download Story Card</span>
            <svg id="icon-dl" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            <svg id="icon-loading" class="w-6 h-6 animate-spin hidden" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        </button>
        
        <p class="text-xs text-slate-400 mt-3">*Tunggu sebentar saat proses generate gambar HD.</p>
    </div>

    <script>
        function downloadStory() {
            const btn = document.getElementById('btn-download-story');
            const iconDl = document.getElementById('icon-dl');
            const iconLoad = document.getElementById('icon-loading');
            const container = document.getElementById('ticket-container');

            // UI Loading
            btn.disabled = true;
            btn.classList.add('opacity-75');
            iconDl.classList.add('hidden');
            iconLoad.classList.remove('hidden');

            // Opsi html2canvas untuk kualitas HD
            const options = {
                scale: 1, 
                useCORS: true, // Penting agar gambar avatar/bg eksternal terender
                backgroundColor: null,
                logging: false
            };

            html2canvas(container, options).then(canvas => {
                const image = canvas.toDataURL("image/png");
                
                const link = document.createElement('a');
                link.download = 'Tiket-Jarun-<?= $kode_unik ?>.png';
                link.href = image;
                link.click();

                // Reset UI
                btn.disabled = false;
                btn.classList.remove('opacity-75');
                iconDl.classList.remove('hidden');
                iconLoad.classList.add('hidden');
                
            }).catch(err => {
                console.error(err);
                alert('Gagal generate gambar. Coba lagi ya!');
                btn.disabled = false;
                iconDl.classList.remove('hidden');
                iconLoad.classList.add('hidden');
            });
        }
    </script>
</body>
</html>
