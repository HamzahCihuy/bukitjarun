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
    
    /* Scrollbar Horizontal Custom */
    .horizontal-scroll::-webkit-scrollbar { height: 12px; }
    .horizontal-scroll::-webkit-scrollbar-track { background: rgba(0,0,0,0.05); border-radius: 20px; margin: 0 20px; }
    .horizontal-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; border: 3px solid transparent; background-clip: content-box; }
    .horizontal-scroll::-webkit-scrollbar-thumb:hover { background-color: #94a3b8; }

    /* Scrollbar Text Vertikal (Tipis) */
    .pesan-scroll::-webkit-scrollbar { width: 4px; }
    .pesan-scroll::-webkit-scrollbar-track { background: rgba(0,0,0,0.05); }
    .pesan-scroll::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.2); border-radius: 10px; }
</style>

<section id="menfess" class="py-20 relative bg-[#f8fafc]">
    
    <div class="absolute inset-0 opacity-10 pointer-events-none" 
         style="background-image: radial-gradient(#64748b 1px, transparent 1px); background-size: 20px 20px;">
    </div>

    <div class="container mx-auto px-4 relative z-10 max-w-7xl">

        <div class="text-center mb-12">
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

        <div class="flex flex-col lg:flex-row gap-8 items-start">
            
            <div class="w-full lg:w-[350px] shrink-0 lg:sticky lg:top-24 z-30">
                <div class="bg-white rounded-3xl p-6 shadow-xl shadow-slate-200 border-2 border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-pink-400 to-purple-400"></div>
                    
                    <h3 class="font-bold text-xl text-slate-800 mb-4 font-fun">✍️ Tulis Pesan</h3>
                    
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
                            <div class="flex gap-3">
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

            <div class="w-full min-w-0">
                
                <div id="menfess-wall" class="flex flex-col flex-wrap content-start gap-4 md:gap-6 overflow-x-auto py-8 px-4 horizontal-scroll h-[500px] md:h-[600px]">
                    
                    <?php if(empty($list_menfess)): ?>
                        <div class="bg-white p-10 rounded-2xl border-2 border-dashed border-slate-300 text-center w-full md:w-[320px]">
                            <p class="text-slate-400 font-bold">Belum ada curhatan. Jadilah yang pertama!</p>
                        </div>
                    <?php endif; ?>

                    <?php foreach($list_menfess as $row): $rot = rand(-2, 2); ?>
                    
                    <div class="relative group hover:z-50 transition-all duration-300 w-[230px] md:w-[300px] shrink-0" 
                         style="transform: rotate(<?= $rot ?>deg);">
                        
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 z-20 w-3 h-3 md:w-4 md:h-4 rounded-full bg-red-500 shadow-md border border-red-700"></div>
                        <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 z-0 w-1 h-2 bg-black/20"></div>

                        <div class="<?= $row['warna'] ?> p-4 md:p-5 rounded-bl-3xl rounded-br-md rounded-tr-md shadow-md border border-black/5 group-hover:scale-[1.02] group-hover:shadow-xl transition duration-300 relative min-h-[180px] md:min-h-[220px] flex flex-col
