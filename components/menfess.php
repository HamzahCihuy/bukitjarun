<?php
if (!isset($pdo)) { include 'db/koneksi.php'; }

// Ambil 50 Menfess terbaru
$sql = "SELECT * FROM menfess ORDER BY waktu_dibuat DESC LIMIT 50";
$stmt = $pdo->query($sql);
$list_menfess = $stmt->fetchAll(PDO::FETCH_ASSOC);

$colors = [
    'bg-yellow-200' => 'Kuning',
    'bg-pink-200'   => 'Pink',
    'bg-blue-200'   => 'Biru',
    'bg-green-200'  => 'Hijau',
    'bg-purple-200' => 'Ungu'
];
?>

<link href="https://fonts.googleapis.com/css2?family=Indie+Flower&family=Patrick+Hand&display=swap" rel="stylesheet">

<style>
    .font-hand { font-family: 'Patrick Hand', cursive; }
    
    /* Scrollbar Text Vertikal (Tipis) */
    .pesan-scroll::-webkit-scrollbar { width: 4px; }
    .pesan-scroll::-webkit-scrollbar-track { background: rgba(0,0,0,0.05); }
    .pesan-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); border-radius: 10px; }
    
    /* Transisi Accordion Halus */
    #form-wrapper { transition: max-height 0.5s ease-in-out, opacity 0.5s ease-in-out; }

    /* HIDE SCROLLBAR BAWAAN */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<section id="menfess" class="py-20 relative bg-[#f8fafc]">
    
    <div class="absolute inset-0 opacity-10 pointer-events-none" 
         style="background-image: radial-gradient(#64748b 1px, transparent 1px); background-size: 20px 20px;">
    </div>

    <div class="container mx-auto px-4 relative z-10 max-w-7xl">

        <div class="text-center mb-8">
            <span class="bg-pink-100 text-pink-600 px-4 py-1 rounded-full text-xs font-bold uppercase tracking-widest border border-pink-200">
                💌 Papan Curhat
            </span>
            <h2 class="text-4xl md:text-6xl font-black font-fun text-slate-800 mt-4 mb-2">
                MENFESS <span class="text-pink-500">JAR'UN</span>
            </h2>
            <p class="text-slate-500 text-lg">
                Geser ke kanan untuk melihat curhatan lainnya! 👉
            </p>
        </div>

        <div class="max-w-md mx-auto mb-12 relative z-30">
            <button onclick="toggleForm()" id="btn-toggle-form" 
                    class="w-full bg-gradient-to-r from-pink-500 to-purple-500 text-white font-bold text-lg py-4 rounded-2xl shadow-lg shadow-pink-500/30 hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-2 group">
                <span class="text-2xl group-hover:rotate-12 transition-transform">✍️</span>
                <span>Tulis Pesan Rahasia</span>
                <svg id="chevron-icon" class="w-5 h-5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            <div id="form-wrapper" class="max-h-0 opacity-0 overflow-hidden mt-4">
                <div class="bg-white rounded-3xl p-6 shadow-2xl shadow-slate-200 border-2 border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-pink-400 to-purple-400"></div>
                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase">Dari (Boleh Samaran)</label>
                            <input type="text" id="mf-sender" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-700 focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-100 transition" placeholder="Contoh: Si Jaket Merah" maxlength="20">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase">Pesan Kamu</label>
                            <textarea id="mf-msg" rows="4" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-hand text-xl text-slate-700 focus:outline-none focus:border-pink-400 focus:ring-2 focus:ring-pink-100 transition resize-none leading-relaxed" placeholder="Tulis sesuatu yang manis... (Max 200 huruf)" maxlength="200"></textarea>
                            <div class="text-right text-xs text-slate-400 mt-1"><span id="char-count">0</span>/200</div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-400 uppercase mb-2 block">Warna Kertas</label>
                            <div class="flex gap-3 justify-center">
                                <?php foreach($colors as $cls => $name): ?>
                                <label class="cursor-pointer">
                                    <input type="radio" name="mf-color" value="<?= $cls ?>" class="peer sr-only" <?= $cls == 'bg-yellow-200' ? 'checked' : '' ?>>
                                    <div class="<?= $cls ?> w-10 h-10 rounded-full border-2 border-transparent peer-checked:border-slate-800 peer-checked:scale-110 transition shadow-sm hover:scale-105"></div>
                                </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <button onclick="kirimMenfess()" id="btn-kirim" class="w-full bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-slate-800 active:scale-95 transition shadow-lg flex justify-center items-center gap-2">
                            <span>Tempel Pesan 📌</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full relative group/slider">
            
            <button onclick="scrollMenfess('left')" class="absolute left-0 top-1/2 -translate-y-1/2 z-40 bg-white border border-slate-200 text-slate-700 p-3 rounded-full shadow-xl hover:bg-slate-50 active:scale-90 transition transform -translate-x-1/2 md:translate-x-0 hidden md:flex">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <div id="menfess-wall" class="flex flex-col flex-wrap content-start gap-4 md:gap-6 overflow-x-auto py-10 px-4 md:px-8 no-scrollbar scroll-smooth h-[550px] md:h-[750px]">
                
                <?php if(empty($list_menfess)): ?>
                    <div class="bg-white p-10 rounded-2xl border-2 border-dashed border-slate-300 text-center w-full md:w-[320px] mx-auto">
                        <p class="text-slate-400 font-bold">Belum ada curhatan. Jadilah yang pertama!</p>
                    </div>
                <?php endif; ?>

                <?php foreach($list_menfess as $row): $rot = rand(-2, 2); ?>
                <div class="relative group hover:z-50 transition-all duration-300 w-[280px] md:w-[320px] shrink-0" 
                     style="transform: rotate(<?= $rot ?>deg);">
                    
                    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 z-20 w-4 h-4 rounded-full bg-red-500 shadow-md border border-red-700"></div>
                    
                    <div class="<?= $row['warna'] ?> p-6 rounded-bl-[30px] rounded-br-md rounded-tr-md shadow-md border border-black/5 group-hover:scale-[1.02] group-hover:shadow-xl transition duration-300 relative min-h-[220px] md:min-h-[260px] flex flex-col justify-between">
                        
                        <div class="flex-1 mb-4">
                            <p class="font-hand text-xl md:text-2xl text-slate-800 leading-snug break-words max-h-[140px] overflow-y-auto pesan-scroll pr-2">
                                "<?= htmlspecialchars($row['pesan']) ?>"
                            </p>
                        </div>
                        
                        <div class="flex justify-between items-end border-t border-black/10 pt-3 mt-auto">
                            <div class="flex flex-col min-w-0">
                                <span class="text-[10px] uppercase font-bold text-black/40 tracking-wider">Dari</span>
                                <span class="font-bold text-sm text-slate-800 truncate max-w-[150px]">
                                    <?= htmlspecialchars($row['pengirim']) ?>
                                </span>
                            </div>
                            <span class="text-[10px] text-black/40 font-mono shrink-0 ml-2">
                                <?= date('d/m H:i', strtotime($row['waktu_dibuat'])) ?>
                            </span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <div class="w-4 h-full shrink-0"></div>
            </div>

            <button onclick="scrollMenfess('right')" class="absolute right-0 top-1/2 -translate-y-1/2 z-40 bg-white border border-slate-200 text-slate-700 p-3 rounded-full shadow-xl hover:bg-slate-50 active:scale-90 transition transform translate-x-1/2 md:translate-x-0 hidden md:flex">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>

        </div>

    </div>
</section>

<script>
    // --- 1. SCRIPT TOGGLE FORM ---
    function toggleForm() {
        const wrapper = document.getElementById('form-wrapper');
        const icon = document.getElementById('chevron-icon');

        if (wrapper.style.maxHeight) {
            wrapper.style.maxHeight = null;
            wrapper.classList.remove('opacity-100');
            wrapper.classList.add('opacity-0');
            icon.style.transform = 'rotate(0deg)';
        } else {
            wrapper.classList.remove('opacity-0');
            wrapper.classList.add('opacity-100');
            wrapper.style.maxHeight = wrapper.scrollHeight + "px";
            icon.style.transform = 'rotate(180deg)';
        }
    }

    // --- 2. SCRIPT SCROLL SLIDER MENFESS ---
    function scrollMenfess(direction) {
        const container = document.getElementById('menfess-wall');
        const cardWidth = 320 + 24; // Lebar Card (320) + Gap (24/6)
        
        if (direction === 'left') {
            container.scrollBy({ left: -cardWidth, behavior: 'smooth' });
        } else {
            container.scrollBy({ left: cardWidth, behavior: 'smooth' });
        }
    }

    // --- 3. SCRIPT KIRIM PESAN ---
    const txtArea = document.getElementById('mf-msg');
    const charCount = document.getElementById('char-count');
    txtArea.addEventListener('input', function() { charCount.innerText = this.value.length; });

    async function kirimMenfess() {
        const sender = document.getElementById('mf-sender').value;
        const msg = document.getElementById('mf-msg').value;
        const color = document.querySelector('input[name="mf-color"]:checked').value;
        const btn = document.getElementById('btn-kirim');

        if(!msg) { alert("Tulis pesan dulu dong!"); return; }

        btn.innerHTML = "Menempelkan..."; btn.disabled = true;

        try {
            const res = await fetch('api-save-menfess.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ pengirim: sender, pesan: msg, warna: color })
            });
            const data = await res.json();
            if(data.status === 'success') {
                alert("✨ Pesan berhasil ditempel!");
                location.reload(); 
            } else {
                alert("Gagal: " + data.msg);
                btn.innerHTML = "Tempel Pesan 📌"; btn.disabled = false;
            }
        } catch(e) {
            console.error(e); alert("Terjadi kesalahan sistem.");
            btn.innerHTML = "Tempel Pesan 📌"; btn.disabled = false;
        }
    }
</script>
