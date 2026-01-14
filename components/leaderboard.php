<?php
if (!isset($pdo)) { include 'db/koneksi.php'; }

// QUERY: Mengambil Top Creator
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

<style>
    /* CSS WARISAN DARI EVENT SECTION */
    .font-fun { font-family: 'Fredoka', sans-serif; }
    
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* Animasi Melayang (Float) */
    @keyframes float-avatar {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    .animate-float-avatar { animation: float-avatar 4s ease-in-out infinite; }
    .animate-float-avatar-delay { animation: float-avatar 4s ease-in-out infinite; animation-delay: 2s; }

    /* Glass Effect untuk Card */
    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.5);
    }
</style>

<section id="leaderboard" class="py-20 relative overflow-hidden bg-white">
    
    <div class="absolute inset-0 opacity-[0.4]" 
         style="background-image: radial-gradient(#17FFB2 2px, transparent 2px); background-size: 24px 24px;">
    </div>


    <div class="container mx-auto px-4 relative z-10 max-w-5xl">
        
        <div class="text-center mb-10">
            <div class="inline-block relative">
                <span class="absolute -inset-1 bg-yellow-300 rounded-full blur opacity-50"></span>
                <span class="relative inline-block py-1 px-4 rounded-full bg-white border-2 border-slate-900 text-slate-900 text-xs font-bold tracking-widest uppercase shadow-sm mb-4">
                    🏆 Hall of Fame
                </span>
            </div>
            
            <h2 class="text-5xl md:text-7xl font-black font-fun tracking-wide text-transparent bg-clip-text bg-gradient-to-b from-slate-700 to-slate-900 drop-shadow-sm">
                SULTAN <span class="text-[#0E5941]">JAR'UN</span>
            </h2>
            <p class="text-slate-500 font-fun text-lg mt-2">
                Top Creator Paling Rajin Minggu Ini! 🔥
            </p>
        </div>

        <div class="relative w-full mb-16">
            
            <button onclick="scrollPodium('left')" class="absolute left-2 md:-left-8 top-1/2 -translate-y-1/2 z-40 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg border-2 border-slate-100 text-slate-700 hover:bg-[#17FFB2] hover:text-[#0E5941] hover:border-[#0E5941] transition active:scale-90">
                <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <button onclick="scrollPodium('right')" class="absolute right-2 md:-right-8 top-1/2 -translate-y-1/2 z-40 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg border-2 border-slate-100 text-slate-700 hover:bg-[#17FFB2] hover:text-[#0E5941] hover:border-[#0E5941] transition active:scale-90">
                <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div id="podium-scroll" class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar px-[15vw] md:px-[30%] py-12 items-center">
                
                <?php if(isset($top3[1])): $u2 = formatUsername($top3[1]['nama_peserta']); ?>
                <div class="snap-center shrink-0 w-[70vw] md:w-[280px] relative group transform transition-transform duration-300 scale-95 hover:scale-100">
                    <div class="bg-white rounded-[2rem] border-b-8 border-slate-200 p-6 flex flex-col items-center shadow-lg relative overflow-hidden h-[300px] justify-between">
                        
                        <div class="absolute top-4 left-4 bg-slate-200 text-slate-600 px-3 py-1 font-fun font-bold rounded-full text-xs">#2</div>

                        <div class="relative w-24 h-24 rounded-full p-1 bg-slate-100 border-2 border-slate-300 mt-4 animate-float-avatar-delay">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u2 ?>" class="w-full h-full rounded-full bg-white object-cover">
                        </div>
                        
                        <div class="text-center w-full mt-2">
                            <h3 class="font-fun font-bold text-xl text-slate-800 truncate w-full"><?= $u2 ?></h3>
                            <p class="text-[#0E5941] font-bold text-sm"><?= $top3[1]['jumlah_video'] ?> Video</p>
                        </div>
                        
                        <a href="https://tiktok.com/<?= $u2 ?>" target="_blank" class="w-full py-2 bg-slate-100 text-slate-500 font-fun font-bold rounded-xl text-xs hover:bg-slate-200 transition text-center">
                            Lihat Profil
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($top3[0])): $u1 = formatUsername($top3[0]['nama_peserta']); ?>
                <div id="card-juara-1" class="snap-center shrink-0 w-[75vw] md:w-[320px] relative group transform transition-transform duration-300 scale-105 z-20">
                    
                    <div class="absolute -top-12 left-1/2 -translate-x-1/2 text-6xl animate-bounce drop-shadow-md z-30">👑</div>
                    
                    <div class="rounded-[2.5rem] border-b-8 p-6 flex flex-col items-center shadow-2xl shadow-green-200 relative overflow-hidden h-[360px] justify-between"
                         style="background: linear-gradient(135deg, #17FFB2, #0E5941); border-color: #064e3b;">
                        
                        <div class="absolute inset-0 z-0 opacity-10" style="background-image: radial-gradient(white 2px, transparent 2px); background-size: 20px 20px;"></div>

                        <div class="absolute top-0 right-0 bg-yellow-400 text-slate-900 px-6 py-2 font-fun font-black rounded-bl-2xl text-lg shadow-md z-10">MVP</div>

                        <div class="relative w-32 h-32 rounded-full p-2 bg-white/20 backdrop-blur-md border-2 border-white/50 mt-4 shadow-lg animate-float-avatar z-10">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u1 ?>" class="w-full h-full rounded-full bg-white object-cover">
                        </div>
                        
                        <div class="text-center w-full mt-2 relative z-10">
                            <h3 class="font-fun font-black text-3xl text-white truncate w-full drop-shadow-md"><?= $u1 ?></h3>
                            <div class="inline-block bg-white/20 backdrop-blur-sm px-4 py-1 rounded-full mt-1 border border-white/30">
                                <span class="text-white font-bold text-sm">🔥 <?= $top3[0]['jumlah_video'] ?> Video Valid</span>
                            </div>
                        </div>
                        
                        <a href="https://tiktok.com/<?= $u1 ?>" target="_blank" class="relative z-10 w-full py-3 bg-white text-[#0E5941] font-fun font-black rounded-xl text-sm shadow-lg hover:scale-105 transition text-center">
                            KUNJUNGI SULTAN
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($top3[2])): $u3 = formatUsername($top3[2]['nama_peserta']); ?>
                <div class="snap-center shrink-0 w-[70vw] md:w-[280px] relative group transform transition-transform duration-300 scale-95 hover:scale-100">
                    <div class="bg-white rounded-[2rem] border-b-8 border-orange-200 p-6 flex flex-col items-center shadow-lg relative overflow-hidden h-[300px] justify-between">
                        
                        <div class="absolute top-4 left-4 bg-orange-100 text-orange-600 px-3 py-1 font-fun font-bold rounded-full text-xs">#3</div>

                        <div class="relative w-24 h-24 rounded-full p-1 bg-orange-50 border-2 border-orange-200 mt-4 animate-float-avatar-delay">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u3 ?>" class="w-full h-full rounded-full bg-white object-cover">
                        </div>
                        
                        <div class="text-center w-full mt-2">
                            <h3 class="font-fun font-bold text-xl text-slate-800 truncate w-full"><?= $u3 ?></h3>
                            <p class="text-orange-500 font-bold text-sm"><?= $top3[2]['jumlah_video'] ?> Video</p>
                        </div>
                        
                        <a href="https://tiktok.com/<?= $u3 ?>" target="_blank" class="w-full py-2 bg-orange-50 text-orange-600 font-fun font-bold rounded-xl text-xs hover:bg-orange-100 transition text-center">
                            Lihat Profil
                        </a>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>

        <?php if(count($sisanya) > 0): ?>
        <div class="max-w-2xl mx-auto bg-white rounded-3xl border-2 border-slate-100 p-6 shadow-xl relative overflow-hidden">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-10 h-10 rounded-full bg-slate-900 flex items-center justify-center text-xl shadow-lg transform -rotate-6">🚀</div>
                <h4 class="font-fun font-bold text-xl text-slate-800">
                    Pengejar Top Global
                </h4>
            </div>

            <div class="space-y-3">
                <?php foreach($sisanya as $i => $row): $uname = formatUsername($row['nama_peserta']); ?>
                <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-transparent hover:border-[#17FFB2] hover:bg-white hover:shadow-md transition duration-300 group cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="w-8 font-fun font-black text-2xl text-slate-300 text-center group-hover:text-[#0E5941] transition"><?= $i + 4 ?></div>
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-slate-200 group-hover:scale-110 transition">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $uname ?>" class="w-full h-full bg-white">
                        </div>
                        <div class="flex flex-col">
                            <span class="font-fun font-bold text-slate-700 group-hover:text-[#0E5941]"><?= $uname ?></span>
                            <a href="https://tiktok.com/<?= $uname ?>" target="_blank" class="text-[10px] font-bold text-slate-400 group-hover:text-[#17FFB2] flex items-center gap-1">
                                Kunjungi <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                    <div class="font-fun font-black text-xl text-slate-300 group-hover:text-[#0E5941]">
                        <?= $row['jumlah_video'] ?>
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
        const scrollAmount = window.innerWidth < 768 ? window.innerWidth * 0.75 : 320; 
        
        if (direction === 'left') {
            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        } else {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }

    // Auto Center Juara 1
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
