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

<section id="leaderboard" class="py-24 relative overflow-hidden bg-white">
    
    <div class="absolute inset-0 opacity-[0.6]" 
         style="background-image: radial-gradient(#e2e8f0 2px, transparent 2px); background-size: 30px 30px;">
    </div>
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-yellow-200/40 rounded-full mix-blend-multiply filter blur-[100px] animate-pulse"></div>
    <div class="absolute bottom-0 right-1/4 w-[500px] h-[500px] bg-green-200/40 rounded-full mix-blend-multiply filter blur-[100px] animate-pulse" style="animation-delay: 2s;"></div>

    <div class="container mx-auto px-4 relative z-10 max-w-5xl">
        
        <div class="text-center mb-10 md:mb-20 space-y-3">
            <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-slate-50 border border-slate-200 text-slate-600 text-xs font-bold tracking-widest uppercase shadow-sm">
                🏆 Hall of Fame
            </span>
            <h2 class="text-5xl md:text-7xl font-black font-fun text-slate-800 tracking-tight drop-shadow-sm">
                SULTAN <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-500 to-amber-600">JAR'UN</span>
            </h2>
            <p class="text-slate-500 text-lg md:text-xl font-medium max-w-2xl mx-auto">
                Para penguasa konten yang paling rajin setor video! 🔥
            </p>
        </div>

        <div class="relative w-full md:hidden mb-12">
            
            <button onclick="scrollPodium('left')" class="absolute left-0 top-1/2 -translate-y-1/2 z-30 bg-white/80 backdrop-blur-sm border border-slate-200 text-slate-800 p-3 rounded-full shadow-lg hover:bg-slate-50 transition active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <button onclick="scrollPodium('right')" class="absolute right-0 top-1/2 -translate-y-1/2 z-30 bg-white/80 backdrop-blur-sm border border-slate-200 text-slate-800 p-3 rounded-full shadow-lg hover:bg-slate-50 transition active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div id="podium-scroll" class="flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar px-[12.5vw] py-4">
                
                <?php if(isset($top3[1])): $u2 = formatUsername($top3[1]['nama_peserta']); ?>
                <div class="snap-center w-[75vw] shrink-0 flex flex-col items-center group relative transform scale-95 opacity-80 transition-all duration-300 active-card">
                    <div class="relative mb-[-40px] z-20">
                        <div class="w-20 h-20 rounded-full p-1 bg-gradient-to-b from-slate-100 to-slate-300 shadow-xl">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u2 ?>&backgroundColor=e2e8f0" class="w-full h-full rounded-full object-cover bg-slate-50">
                        </div>
                        <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-slate-700 text-white text-[10px] font-black px-2 py-1 rounded-full border border-slate-200">#2</div>
                    </div>
                    <div class="w-full bg-gradient-to-b from-slate-100 via-slate-200 to-slate-300 rounded-[2rem] pt-12 pb-6 px-4 text-center shadow-lg border border-white/50">
                        <h3 class="text-slate-800 font-black text-lg font-fun truncate"><?= $u2 ?></h3>
                        <div class="text-slate-500 font-bold text-sm mb-2"><?= $top3[1]['jumlah_video'] ?> Video</div>
                        <a href="https://tiktok.com/<?= $u2 ?>" target="_blank" class="inline-block px-4 py-1 rounded-lg bg-white text-slate-700 text-xs font-bold">Profil ↗</a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($top3[0])): $u1 = formatUsername($top3[0]['nama_peserta']); ?>
                <div id="card-juara-1" class="snap-center w-[75vw] shrink-0 flex flex-col items-center z-20 group relative transform scale-100 transition-all duration-300 active-card">
                    <div class="text-5xl mb-[-15px] z-30 animate-bounce relative top-4">👑</div>
                    <div class="relative mb-[-50px] z-20">
                        <div class="w-28 h-28 rounded-full p-1.5 bg-gradient-to-b from-yellow-300 via-yellow-500 to-amber-600 shadow-2xl">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u1 ?>&backgroundColor=fef08a" class="w-full h-full rounded-full object-cover bg-yellow-50">
                        </div>
                        <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 bg-red-600 text-white text-xs font-black px-3 py-1 rounded-full border-2 border-yellow-300 whitespace-nowrap">#1 CHAMPION</div>
                    </div>
                    <div class="w-full bg-gradient-to-b from-yellow-400 via-amber-500 to-amber-600 rounded-[2.5rem] pt-16 pb-8 px-6 text-center shadow-xl border-t-2 border-yellow-300">
                        <h3 class="text-white font-black text-2xl font-fun truncate"><?= $u1 ?></h3>
                        <p class="text-yellow-100 text-xs font-bold tracking-widest uppercase mb-4">The King</p>
                        <div class="bg-black/20 rounded-xl py-2 px-4 mb-4 inline-block">
                            <span class="text-white font-black text-3xl"><?= $top3[0]['jumlah_video'] ?></span>
                            <span class="text-yellow-200 text-[10px] font-bold uppercase block">Video</span>
                        </div>
                        <a href="https://tiktok.com/<?= $u1 ?>" target="_blank" class="block w-full py-2 rounded-xl bg-white text-amber-600 font-bold text-sm">Kunjungi Sultan 👑</a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($top3[2])): $u3 = formatUsername($top3[2]['nama_peserta']); ?>
                <div class="snap-center w-[75vw] shrink-0 flex flex-col items-center group relative transform scale-95 opacity-80 transition-all duration-300 active-card">
                    <div class="relative mb-[-40px] z-20">
                        <div class="w-20 h-20 rounded-full p-1 bg-gradient-to-b from-orange-200 to-orange-400 shadow-xl">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u3 ?>&backgroundColor=ffedd5" class="w-full h-full rounded-full object-cover bg-orange-50">
                        </div>
                        <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-slate-700 text-white text-[10px] font-black px-2 py-1 rounded-full border border-orange-200">#3</div>
                    </div>
                    <div class="w-full bg-gradient-to-b from-orange-200 via-orange-300 to-orange-400 rounded-[2rem] pt-12 pb-6 px-4 text-center shadow-lg border border-white/50">
                        <h3 class="text-orange-900 font-black text-lg font-fun truncate"><?= $u3 ?></h3>
                        <div class="text-orange-800 font-bold text-sm mb-2"><?= $top3[2]['jumlah_video'] ?> Video</div>
                        <a href="https://tiktok.com/<?= $u3 ?>" target="_blank" class="inline-block px-4 py-1 rounded-lg bg-white text-orange-800 text-xs font-bold">Profil ↗</a>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>

        <div class="hidden md:flex flex-row items-end justify-center gap-8 mb-20">
            <?php if(isset($top3[1])): $u2 = formatUsername($top3[1]['nama_peserta']); ?>
            <div class="w-[30%] flex flex-col items-center group relative z-10">
                <div class="relative mb-[-40px] z-20 transition-transform duration-300 group-hover:-translate-y-2">
                    <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-b from-slate-100 to-slate-300 shadow-xl"><img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u2 ?>&backgroundColor=e2e8f0" class="w-full h-full rounded-full object-cover bg-slate-50"></div>
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-slate-700 text-white text-xs font-black px-3 py-1 rounded-full border-2 border-slate-200 shadow-md">JUARA 2</div>
                </div>
                <div class="w-full bg-gradient-to-b from-slate-100 via-slate-200 to-slate-300 rounded-[2rem] pt-14 pb-6 px-6 text-center shadow-2xl border border-white/50 relative overflow-hidden">
                    <h3 class="text-slate-800 font-black text-lg font-fun mb-1 truncate"><?= $u2 ?></h3>
                    <div class="bg-white/50 rounded-xl py-2 px-4 mb-4 inline-block"><span class="text-slate-800 font-black text-2xl"><?= $top3[1]['jumlah_video'] ?></span><span class="text-slate-500 text-xs font-bold uppercase ml-1">Video</span></div>
                    <a href="https://tiktok.com/<?= $u2 ?>" target="_blank" class="block w-full py-2 rounded-lg bg-white text-slate-700 text-xs font-bold hover:bg-slate-800 hover:text-white transition-colors shadow-sm">Lihat Profil ↗</a>
                </div>
            </div>
            <?php endif; ?>

            <?php if(isset($top3[0])): $u1 = formatUsername($top3[0]['nama_peserta']); ?>
            <div class="w-[35%] flex flex-col items-center z-20 -mt-12 group relative">
                <div class="text-6xl mb-[-10px] z-30 animate-bounce drop-shadow-lg relative top-4">👑</div>
                <div class="relative mb-[-50px] z-20 transition-transform duration-300 group-hover:-translate-y-3">
                    <div class="w-32 h-32 rounded-full p-1.5 bg-gradient-to-b from-yellow-300 via-yellow-500 to-amber-600 shadow-2xl"><img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u1 ?>&backgroundColor=fef08a" class="w-full h-full rounded-full object-cover bg-yellow-50"></div>
                    <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 bg-red-600 text-white text-sm font-black px-4 py-1.5 rounded-full border-2 border-yellow-300 shadow-lg">#1 CHAMPION</div>
                </div>
                <div class="w-full bg-gradient-to-b from-yellow-400 via-amber-500 to-amber-600 rounded-[2.5rem] pt-16 pb-8 px-8 text-center shadow-xl border-t-2 border-yellow-300">
                    <h3 class="text-white font-black text-2xl font-fun mb-1 truncate"><?= $u1 ?></h3>
                    <p class="text-yellow-100 text-xs font-bold uppercase tracking-[0.2em] mb-6">The King of Jar'un</p>
                    <div class="bg-black/20 rounded-2xl py-3 px-6 mb-6 backdrop-blur-sm border border-white/10"><span class="text-white font-black text-4xl block"><?= $top3[0]['jumlah_video'] ?></span><span class="text-yellow-200 text-xs font-bold uppercase tracking-wide">Video Valid</span></div>
                    <a href="https://tiktok.com/<?= $u1 ?>" target="_blank" class="block w-full py-3 rounded-xl bg-white text-amber-600 font-bold text-sm hover:bg-slate-900 hover:text-yellow-400">Kunjungi Profil 👑</a>
                </div>
            </div>
            <?php endif; ?>

            <?php if(isset($top3[2])): $u3 = formatUsername($top3[2]['nama_peserta']); ?>
            <div class="w-[30%] flex flex-col items-center group relative z-10">
                <div class="relative mb-[-40px] z-20 transition-transform duration-300 group-hover:-translate-y-2">
                    <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-b from-orange-200 to-orange-400 shadow-xl"><img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u3 ?>&backgroundColor=ffedd5" class="w-full h-full rounded-full object-cover bg-orange-50"></div>
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-slate-700 text-white text-xs font-black px-3 py-1 rounded-full border-2 border-orange-200 shadow-md">JUARA 3</div>
                </div>
                <div class="w-full bg-gradient-to-b from-orange-200 via-orange-300 to-orange-400 rounded-[2rem] pt-14 pb-6 px-6 text-center shadow-2xl border border-white/50 relative overflow-hidden">
                    <h3 class="text-orange-900 font-black text-lg font-fun mb-1 truncate"><?= $u3 ?></h3>
                    <div class="bg-white/40 rounded-xl py-2 px-4 mb-4 inline-block"><span class="text-orange-900 font-black text-2xl"><?= $top3[2]['jumlah_video'] ?></span><span class="text-orange-800/70 text-xs font-bold uppercase ml-1">Video</span></div>
                    <a href="https://tiktok.com/<?= $u3 ?>" target="_blank" class="block w-full py-2 rounded-lg bg-white text-orange-800 text-xs font-bold hover:bg-slate-800 hover:text-white transition-colors shadow-sm">Lihat Profil ↗</a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <?php if(count($sisanya) > 0): ?>
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 p-6 md:p-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-green-400 to-[#17FFB2]"></div>
                <h4 class="text-slate-800 font-bold text-lg mb-6 flex items-center gap-2">
                    <span class="bg-slate-100 p-2 rounded-lg text-xl">🚀</span> Pengejar Top Global
                </h4>
                <div class="space-y-3">
                    <?php foreach($sisanya as $i => $row): $uname = formatUsername($row['nama_peserta']); ?>
                    <div class="group flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-transparent hover:bg-green-50 hover:border-green-200 transition-all duration-300 hover:-translate-y-0.5 cursor-default">
                        <div class="flex items-center gap-4 overflow-hidden">
                            <div class="w-8 text-center font-black text-slate-300 group-hover:text-green-600 transition-colors text-lg"><?= $i + 4 ?></div>
                            <div class="w-10 h-10 rounded-full bg-white border border-slate-200 p-0.5 shrink-0 group-hover:scale-110 transition-transform">
                                <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $uname ?>" class="w-full h-full rounded-full bg-slate-100">
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span class="text-slate-800 font-bold text-sm truncate group-hover:text-green-700 transition-colors"><?= $uname ?></span>
                                <a href="https://tiktok.com/<?= $uname ?>" target="_blank" class="text-[10px] text-slate-400 hover:text-green-600 flex items-center gap-1">Lihat Profil <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg></a>
                            </div>
                        </div>
                        <div class="flex flex-col items-end shrink-0 pl-2">
                            <span class="text-slate-800 font-black text-lg leading-none group-hover:text-green-600 transition-colors"><?= $row['jumlah_video'] ?></span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase group-hover:text-green-600/70">Video</span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php elseif(empty($top3)): ?>
             <div class="text-center py-12 bg-slate-50 rounded-3xl border border-dashed border-slate-300">
                <div class="text-6xl mb-4 opacity-30 grayscale">👻</div>
                <h3 class="text-slate-800 font-bold text-xl mb-2">Belum ada Sultan!</h3>
                <p class="text-slate-500 text-sm max-w-xs mx-auto mb-6">Jadilah orang pertama yang menguasai leaderboard ini.</p>
                <a href="#event-section" class="inline-block bg-[#0E5941] text-white px-6 py-3 rounded-xl font-bold font-fun hover:bg-green-800 transition-colors shadow-lg shadow-green-900/20">Gass Upload Sekarang! 🚀</a>
             </div>
        <?php endif; ?>

    </div>
</section>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
    function scrollPodium(direction) {
        const container = document.getElementById('podium-scroll');
        const scrollAmount = container.clientWidth * 0.8; // Scroll sebesar 80% layar
        
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
            // Hitung posisi tengah: (Posisi Card 1) - (Setengah layar) + (Setengah Card)
            const scrollPos = cardJuara1.offsetLeft - (container.clientWidth / 2) + (cardJuara1.clientWidth / 2);
            container.scrollTo({ left: scrollPos, behavior: 'smooth' });
        }
    });
</script>
