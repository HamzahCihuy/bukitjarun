<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Voucher Resmi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Share+Tech+Mono&family=Libre+Barcode+128&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --neon-green: #17FFB2;
            --dark-green: #064E3B;
            --gold: #FCD34D;
        }
        body {
            background-color: #022c22;
            background-image: 
                radial-gradient(at 0% 0%, hsla(153,91%,48%,1) 0, transparent 50%), 
                radial-gradient(at 100% 100%, hsla(153,91%,48%,1) 0, transparent 50%);
            font-family: 'Fredoka', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Desain Tiket Sobek */
        .ticket-container {
            filter: drop-shadow(0 20px 30px rgba(0,0,0,0.5));
            animation: slideUp 0.8s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .ticket-wrapper {
            background: #ffffff;
            position: relative;
            clip-path: polygon(
                20px 0, 100% 0, 100% 100%, 20px 100%, 
                0 100%, 0 0
            ); 
            /* Masking bulat untuk efek sobekan tiket (Notches) */
            --mask: radial-gradient(12px at 12px 50%, #0000 98%, #000) 50% / 100% 40px repeat-y;
            -webkit-mask: var(--mask); 
            mask: var(--mask);
        }
        
        /* Garis Hologram Emas */
        .hologram-strip {
            background: linear-gradient(135deg, #FCD34D 0%, #F59E0B 20%, #FFFBEB 40%, #F59E0B 60%, #FCD34D 100%);
            background-size: 200% 200%;
            animation: shine 3s linear infinite;
        }

        /* Font Barcode */
        .barcode {
            font-family: 'Libre Barcode 128', cursive;
            font-size: 4rem;
            line-height: 1;
            transform: scaleY(1.5);
        }

        /* Font Kode Unik */
        .tech-font { font-family: 'Share Tech Mono', monospace; }

        /* Dekorasi Kelapa */
        .palm-pattern {
            background-image: url('https://img.icons8.com/ios-filled/100/16a34a/palm-tree.png');
            background-size: 60px;
            opacity: 0.05;
        }

        @keyframes shine { 
            0% { background-position: 200% center; }
            100% { background-position: -200% center; }
        }
        @keyframes slideUp {
            from { transform: translateY(100px) rotate(-5deg); opacity: 0; }
            to { transform: translateY(0) rotate(0); opacity: 1; }
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #17FFB2;
            animation: fall linear forwards;
        }
        @keyframes fall {
            to { transform: translateY(100vh) rotate(720deg); }
        }
    </style>
</head>
<body class="relative">

    <?php
    // Ambil Data dari URL
    $nama = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Peserta';
    $kode = isset($_GET['code']) ? htmlspecialchars($_GET['code']) : 'TIKET-ERROR';
    $misi = isset($_GET['mission']) ? htmlspecialchars($_GET['mission']) : 'Misi Umum';
    $tanggal = date("d F Y");
    ?>

    <div id="confetti-container" class="absolute inset-0 pointer-events-none z-0"></div>

    <div class="relative z-10 p-4 w-full max-w-4xl">
        
        <div class="text-center mb-8">
            <h1 class="text-white text-3xl font-black tracking-widest uppercase drop-shadow-lg">Official Reward Ticket</h1>
            <p class="text-green-300 text-sm tracking-wide">VERIFIED BY AI SYSTEM</p>
        </div>

        <div class="ticket-container w-full">
            <div class="flex flex-col md:flex-row bg-white rounded-3xl overflow-hidden relative min-h-[400px]">
                
                <div class="w-full md:w-[35%] bg-green-900 relative overflow-hidden flex items-center justify-center p-6 group">
                    <div class="absolute inset-0 palm-pattern"></div>
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/60"></div>
                    
                    <div class="relative z-10 text-center transform transition duration-700 group-hover:scale-110 group-hover:rotate-6">
                        <img src="https://img.icons8.com/color/480/coconut.png" alt="Coconut" class="w-40 h-40 mx-auto drop-shadow-2xl filter brightness-110">
                        <div class="mt-4 border-2 border-[#17FFB2] text-[#17FFB2] px-4 py-1 rounded-full text-xs font-bold tracking-widest uppercase bg-black/20 backdrop-blur-sm">
                            Premium Reward
                        </div>
                    </div>

                    <div class="absolute left-0 top-0 bottom-0 w-3 hologram-strip"></div>
                </div>

                <div class="w-full md:w-[65%] p-8 md:p-10 relative bg-[#fffcf5]">
                    <div class="absolute right-[-20px] bottom-[-20px] opacity-10 pointer-events-none">
                        <img src="https://img.icons8.com/color/480/palm-tree.png" class="w-64 h-64 grayscale">
                    </div>

                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">EVENT WISATA ALAM</p>
                            <h2 class="text-3xl font-black text-green-900 leading-none"><?= $misi ?></h2>
                        </div>
                        <div class="text-right">
                            <p class="text-xs font-bold text-gray-400 uppercase">ISSUED DATE</p>
                            <p class="text-green-800 font-bold"><?= $tanggal ?></p>
                        </div>
                    </div>

                    <div class="w-full border-b-2 border-dashed border-gray-300 my-6"></div>

                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase mb-1">PEMILIK VOUCHER</p>
                            <p class="text-xl font-bold text-green-900 capitalize truncate"><?= $nama ?></p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase mb-1">STATUS</p>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full animate-pulse"></span>
                                VERIFIED VALID
                            </span>
                        </div>
                    </div>

                    <div class="bg-gray-900 rounded-2xl p-6 text-center relative overflow-hidden shadow-inner border border-gray-700">
                        <div class="absolute inset-0 opacity-20" style="background-image: repeating-linear-gradient(45deg, #000 0, #000 10px, #222 10px, #222 20px);"></div>
                        
                        <p class="text-gray-400 text-[10px] uppercase tracking-[0.3em] mb-2 relative z-10">KODE UNIK PENUKARAN</p>
                        <h3 class="text-4xl md:text-5xl text-[#17FFB2] tech-font font-bold tracking-wider relative z-10 drop-shadow-[0_0_10px_rgba(23,255,178,0.5)]">
                            <?= $kode ?>
                        </h3>
                    </div>

                    <div class="mt-6 text-center opacity-60">
                        <div class="barcode text-black">123456789</div>
                        <p class="text-[10px] tracking-widest mt-[-10px]">SCAN VERIFICATION ONLY</p>
                    </div>

                </div>

                <div class="absolute left-[35%] top-[-10px] w-6 h-6 bg-[#022c22] rounded-full"></div>
                <div class="absolute left-[35%] bottom-[-10px] w-6 h-6 bg-[#022c22] rounded-full"></div>
            </div>
            
            <div class="mt-8 flex justify-center gap-4">
                <button onclick="window.print()" class="px-8 py-3 bg-white text-green-900 font-bold rounded-full shadow-lg hover:bg-gray-100 transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Simpan / Cetak
                </button>
                <a href="index.php" class="px-8 py-3 bg-[#17FFB2] text-green-900 font-bold rounded-full shadow-lg hover:brightness-110 transition">
                    Selesai
                </a>
            </div>

        </div>
    </div>

    <script>
        function createConfetti() {
            const container = document.getElementById('confetti-container');
            const colors = ['#17FFB2', '#FCD34D', '#FFFFFF'];
            
            for(let i=0; i<50; i++) {
                const conf = document.createElement('div');
                conf.classList.add('confetti');
                conf.style.left = Math.random() * 100 + 'vw';
                conf.style.animationDuration = (Math.random() * 3 + 2) + 's';
                conf.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                container.appendChild(conf);
            }
        }
        createConfetti();
    </script>
</body>
</html>