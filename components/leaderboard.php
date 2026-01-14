<?php
if (!isset($pdo)) { include 'db/koneksi.php'; }

// QUERY: Mengambil Top Players
$sql = "SELECT nama_peserta, COUNT(*) as jumlah_video 
        FROM tickets 
        GROUP BY nama_peserta 
        ORDER BY jumlah_video DESC, max(waktu_dibuat) ASC 
        LIMIT 10";

$stmt = $pdo->query($sql);
$champions = $stmt->fetchAll(PDO::FETCH_ASSOC);

function formatUsername($rawName) {
    $clean = trim($rawName);
    $clean = str_replace(' ', '_', $clean);
    if (substr($clean, 0, 1) !== '@') { return '@' . $clean; }
    return $clean;
}

$top3 = array_slice($champions, 0, 3);
$sisanya = array_slice($champions, 3);
?>

<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;600;700&family=VT323&display=swap" rel="stylesheet">

<style>
    .font-pixel { font-family: 'VT323', monospace; }
    .font-cute { font-family: 'Fredoka', sans-serif; }
    
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Efek Tombol Game (Hard Shadow) */
    .game-card {
        box-shadow: 6px 6px 0px 0px #1e293b; /* Slate-800 */
        transition: all 0.2s;
    }
    .game-card:active {
        transform: translate(4px, 4px);
        box-shadow: 2px 2px 0px 0px #1e293b;
    }
    
    /* Background Grid Bergerak */
    @keyframes moveGrid {
        0% { background-position: 0 0; }
        100% { background-position: 40px 40px; }
    }
    .bg-game-grid {
        background-image: linear-gradient(#cbd5e1 2px, transparent 2px), linear-gradient(90deg, #cbd5e1 2px, transparent 2px);
        background-size: 40px 40px;
        animation: moveGrid 4s linear infinite;
    }
</style>

<section id="leaderboard" class="py-20 relative overflow-hidden bg-[#f0f9ff]">
    
    <div class="absolute inset-0 bg-game-grid opacity-40 pointer-events-none"></div>
    
    <div class="absolute top-10 left-5 text-4xl animate-bounce">🍄</div>
    <div class="absolute bottom-20 right-5 text-4xl animate-pulse">⭐</div>
    <div class="absolute top-1/2 right-10 text-4xl animate-bounce" style="animation-delay: 1s;">🎮</div>

    <div class="container mx-auto px-4 relative z-10 max-w-5xl">
        
        <div class="text-center mb-10">
            <div class="inline-block bg-yellow-400 border-4 border-slate-900 px-6 py-2 rounded-full transform -rotate-2 mb-4 shadow-[4px_4px_0px_0px_rgba(30,41,59,1)]">
                <span class="font-pixel text-2xl font-bold text-slate-900 tracking-widest">TOP PLAYERS</span>
            </div>
            <h2 class="text-5xl md:text-6xl font-cute font-black text-slate-900 drop-shadow-md">
                HALL OF <span class="text-pink-500">FAME</span>
            </h2>
            <p class="font-pixel text-xl text-slate-500 mt-2">Level Tertinggi Minggu Ini! 🚀</p>
        </div>

        <div class="relative w-full mb-16">
            
            <button onclick="scrollPodium('left')" class="absolute left-2 md:-left-12 top-1/2 -translate-y-1/2 z-40 w-12 h-12 bg-white border-4 border-slate-900 rounded-full flex items-center justify-center shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] active:shadow-none active:translate-y-1 transition text-slate-900 hover:bg-yellow-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <button onclick="scrollPodium('right')" class="absolute right-2 md:-right-12 top-1/2 -translate-y-1/2 z-40 w-12 h-12 bg-white border-4 border-slate-900 rounded-full flex items-center justify-center shadow-[4px_4px_0px_0px_rgba(30,41,59,1)] active:shadow-none active:translate-y-1 transition text-slate-900 hover:bg-yellow-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="4" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div id="podium-scroll" class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar px-[15vw] md:px-[30%] py-8 items-center">
                
                <?php if(isset($top3[1])): $u2 = formatUsername($top3[1]['nama_peserta']); ?>
                <div class="snap-center shrink-0 w-[70vw] md:w-[280px] relative group transform transition-transform duration-300 scale-95 hover:scale-100">
                    <div class="game-card bg-white rounded-3xl border-4 border-slate-900 p-4 flex flex-col items-center relative overflow-hidden">
                        <div class="absolute top-0 left-0 bg-slate-200 text-slate-700 px-3 py-1 font-pixel font-bold rounded-br-xl border-b-4 border-r-4 border-slate-900 text-lg">RANK #2</div>
                        
                        <div class="w-20 h-20 bg-slate-200 rounded-2xl border-4 border-slate-900 mt-6 mb-2 overflow-hidden">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u2 ?>" class="w-full h-full object-cover">
                        </div>
                        
                        <h3 class="font-cute font-bold text-lg text-slate-900 truncate w-full text-center"><?= $u2 ?></h3>
                        
                        <div class="w-full bg-slate-100 rounded-xl border-2 border-slate-900 p-2 mt-2 flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-500">SCORE</span>
                            <span class="font-pixel text-xl text-slate-900"><?= $top3[1]['jumlah_video'] ?></span>
                        </div>
                        
                        <a href="https://tiktok.com/<?= $u2 ?>" target="_blank" class="mt-3 w-full bg-slate-900 text-white font-pixel py-1 text-center rounded hover:bg-slate-700 text-lg">VIEW</a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($top3[0])): $u1 = formatUsername($top3[0]['nama_peserta']); ?>
                <div id="card-juara-1" class="snap-center shrink-0 w-[75vw] md:w-[320px] relative group transform transition-transform duration-300 scale-100 z-20">
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 text-6xl animate-bounce drop-shadow-[4px_4px_0px_rgba(0,0,0,1)] z-30">👑</div>
                    
                    <div class="game-card bg-yellow-300 rounded-[2.5rem] border-4 border-slate-900 p-6 flex flex-col items-center relative overflow-hidden h-[380px] justify-between">
                        
                        <div class="absolute top-0 right-0 bg-red-500 text-white px-4 py-1 font-pixel font-bold rounded-bl-2xl border-b-4 border-l-4 border-slate-900 text-xl tracking-widest">MVP</div>
                        
                        <div class="w-32 h-32 bg-white rounded-full border-4 border-slate-900 mt-6 mb-2 overflow-hidden shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] relative">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u1 ?>" class="w-full h-full object-cover">
                            <div class="absolute bottom-0 w-full bg-slate-900 text-yellow-300 text-center text-[10px] font-bold py-0.5">KING</div>
                        </div>
                        
                        <h3 class="font-cute font-black text-2xl text-slate-900 truncate w-full text-center leading-none"><?= $u1 ?></h3>
                        
                        <div class="w-full bg-white rounded-2xl border-4 border-slate-900 p-3 mt-1 flex justify-between items-center shadow-sm">
                            <div class="flex flex-col text-left">
                                <span class="text-[10px] font-bold text-slate-400">TOTAL XP</span>
                                <span class="text-xs font-bold text-slate-800 uppercase">Video Valid</span>
                            </div>
                            <span class="font-pixel text-4xl text-green-600 leading-none"><?= $top3[0]['jumlah_video'] ?></span>
                        </div>
                        
                        <a href="https://tiktok.com/<?= $u1 ?>" target="_blank" class="w-full bg-blue-500 border-b-4 border-blue-700 text-white font-pixel py-2 text-center rounded-xl hover:bg-blue-400 hover:border-blue-600 transition text-xl active:border-b-0 active:translate-y-1">
                            VISIT PROFILE ➜
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($top3[2])): $u3 = formatUsername($top3[2]['nama_peserta']); ?>
                <div class="snap-center shrink-0 w-[70vw] md:w-[280px] relative group transform transition-transform duration-300 scale-95 hover:scale-100">
                    <div class="game-card bg-white rounded-3xl border-4 border-slate-900 p-4 flex flex-col items-center relative overflow-hidden">
                        <div class="absolute top-0 left-0 bg-orange-200 text-orange-800 px-3 py-1 font-pixel font-bold rounded-br-xl border-b-4 border-r-4 border-slate-900 text-lg">RANK #3</div>
                        
                        <div class="w-20 h-20 bg-orange-100 rounded-2xl border-4 border-slate-900 mt-6 mb-2 overflow-hidden">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u3 ?>" class="w-full h-full object-cover">
                        </div>
                        
                        <h3 class="font-cute font-bold text-lg text-slate-900 truncate w-full text-center"><?= $u3 ?></h3>
                        
                        <div class="w-full bg-slate-100 rounded-xl border-2 border-slate-900 p-2 mt-2 flex justify-between items-center">
                            <span class="text-xs font-bold text-slate-500">SCORE</span>
                            <span class="font-pixel text-xl text-slate-900"><?= $top3[2]['jumlah_video'] ?></span>
                        </div>
                        
                        <a href="https://tiktok.com/<?= $u3 ?>" target="_blank" class="mt-3 w-full bg-slate-900 text-white font-pixel py-1 text-center rounded hover:bg-slate-700 text-lg">VIEW</a>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>

        <?php if(count($sisanya) > 0): ?>
        <div class="max-w-2xl mx-auto bg-white border-4 border-slate-900 rounded-3xl p-6 shadow-[8px_8px_0px_0px_#1e293b]">
            <h4 class="font-pixel text-2xl text-slate-900 mb-4 flex items-center gap-2">
                <span class="text-3xl">📜</span> QUEST BOARD (Top 4-10)
            </h4>
            <div class="space-y-3">
                <?php foreach($sisanya as $i => $row): $uname = formatUsername($row['nama_peserta']); ?>
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border-2 border-slate-200 hover:border-slate-900 hover:bg-yellow-50 transition cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="w-8 font-pixel text-2xl text-slate-400 text-center">#<?= $i + 4 ?></div>
                        <div class="w-10 h-10 rounded-lg border-2 border-slate-900 overflow-hidden">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $uname ?>" class="w-full h-full bg-white">
                        </div>
                        <div class="flex flex-col">
                            <span class="font-cute font-bold text-slate-900"><?= $uname ?></span>
                            <a href="https://tiktok.com/<?= $uname ?>" target="_blank" class="text-[10px] font-bold text-blue-500 hover:underline">VISIT ></a>
                        </div>
                    </div>
                    <div class="font-pixel text-2xl text-slate-900">
                        <?= $row['jumlah_video'] ?> <span class="text-xs text-slate-400 font-sans">XP</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</section>

<script>
    function scrollPodium(direction) {
        const container = document.getElementById('podium-scroll');
        // Scroll sebesar lebar 1 kartu (termasuk gap)
        const scrollAmount = window.innerWidth < 768 ? window.innerWidth * 0.75 : 320; 
        
        if (direction === 'left') {
            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        } else {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }

    // Auto Center ke Juara 1 saat load
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById('podium-scroll');
        const cardJuara1 = document.getElementById('card-juara-1');
        
        if (container && cardJuara1) {
            setTimeout(() => {
                const scrollPos = cardJuara1.offsetLeft - (container.clientWidth / 2) + (cardJuara1.clientWidth / 2);
                container.scrollTo({ left: scrollPos, behavior: 'smooth' });
            }, 100);
        }
    });
</script>
