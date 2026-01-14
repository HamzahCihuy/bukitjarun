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
    /* Custom Scrollbar Hide */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* Animasi Shimmer untuk Kartu Juara 1 */
    @keyframes shimmer {
        0% { transform: translateX(-150%) rotate(45deg); }
        100% { transform: translateX(150%) rotate(45deg); }
    }
    .shimmer-effect::after {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to right, transparent, rgba(255,255,255,0.4), transparent);
        transform: skewX(-20deg) translateX(-150%);
        animation: shimmer 3s infinite;
    }
</style>

<section id="leaderboard" class="py-20 relative overflow-hidden bg-slate-50">
    
    <div class="absolute inset-0 opacity-10 pointer-events-none" 
         style="background-image: url('https://www.transparenttextures.com/patterns/confetti.png');">
    </div>
    
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-64 h-64 bg-yellow-400 rounded-full blur-[100px] opacity-20 animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-64 h-64 bg-purple-500 rounded-full blur-[100px] opacity-20 animate-pulse"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 max-w-5xl">
        
        <div class="text-center mb-10 md:mb-16 space-y-2">
            <span class="inline-block py-1 px-4 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white text-xs font-bold tracking-widest uppercase shadow-lg mb-2">
                🏆 Hall of Fame
            </span>
            <h2 class="text-5xl md:text-7xl font-black font-fun text-slate-900 tracking-tight drop-shadow-sm">
                SULTAN <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-500 to-amber-600">JAR'UN</span>
            </h2>
            <p class="text-slate-500 font-medium">Top Creator Paling Rajin Minggu Ini!</p>
        </div>

        <div class="relative w-full md:hidden mb-12">
            
            <button onclick="scrollPodium('left')" class="absolute left-2 top-1/2 -translate-y-1/2 z-40 bg-white border border-slate-200 text-slate-800 p-3 rounded-full shadow-xl active:scale-90 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button onclick="scrollPodium('right')" class="absolute right-2 top-1/2 -translate-y-1/2 z-40 bg-white border border-slate-200 text-slate-800 p-3 rounded-full shadow-xl active:scale-90 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div id="podium-scroll" class="flex gap-4 overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar px-[15vw] py-8 items-center">
                
                <?php if(isset($top3[1])): $u2 = formatUsername($top3[1]['nama_peserta']); ?>
                <div class="snap-center w-[70vw] shrink-0 relative flex flex-col group">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 text-3xl z-30">🥈</div>
                    
                    <div class="bg-gradient-to-b from-white to-slate-100 rounded-3xl border-[3px] border-slate-300 p-6 flex flex-col items-center shadow-[0_10px_30px_rgba(148,163,184,0.4)] relative overflow-hidden h-[320px] justify-between">
                        
                        <div class="relative w-20 h-20 rounded-full p-1 bg-slate-300 mb-2">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u2 ?>" class="w-full h-full rounded-full bg-white object-cover">
                            <div class="absolute -bottom-2 inset-x-0 mx-auto w-max bg-slate-600 text-white text-[10px] font-black px-2 py-0.5 rounded-md">JUARA 2</div>
                        </div>

                        <div class="text-center w-full">
                            <h3 class="font-black text-slate-800 text-lg truncate w-full mb-1"><?= $u2 ?></h3>
                            <div class="inline-block bg-slate-200 px-3 py-1 rounded-lg">
                                <span class="font-bold text-slate-600 text-sm"><?= $top3[1]['jumlah_video'] ?> Video</span>
                            </div>
                        </div>

                        <a href="https://tiktok.com/<?= $u2 ?>" class="w-full py-2 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl text-xs hover:bg-slate-50 transition text-center shadow-sm">
                            Lihat Profil
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($top3[0])): $u1 = formatUsername($top3[0]['nama_peserta']); ?>
                <div id="card-juara-1" class="snap-center w-[70vw] shrink-0 relative flex flex-col group">
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 text-5xl z-30 animate-bounce drop-shadow-md">👑</div>
                    
                    <div class="bg-gradient-to-b from-yellow-50 to-white rounded-3xl border-[4px] border-yellow-400 p-6 flex flex-col items-center shadow-[0_0_30px_rgba(250,204,21,0.5)] relative overflow-hidden h-[320px] justify-between shimmer-effect">
                        
                        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/confetti.png')]"></div>

                        <div class="relative w-24 h-24 rounded-full p-1 bg-yellow-400 mb-2 shadow-lg">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u1 ?>" class="w-full h-full rounded-full bg-white object-cover">
                            <div class="absolute -bottom-3 inset-x-0 mx-auto w-max bg-red-600 text-white text-xs font-black px-3 py-1 rounded-md shadow-md border border-yellow-300">#1 KING</div>
                        </div>

                        <div class="text-center w-full z-10">
                            <h3 class="font-black text-slate-900 text-xl truncate w-full mb-1"><?= $u1 ?></h3>
                            <div class="inline-block bg-yellow-100 border border-yellow-300 px-4 py-1 rounded-lg shadow-sm">
                                <span class="font-black text-yellow-700 text-lg"><?= $top3[0]['jumlah_video'] ?> Video</span>
                            </div>
                        </div>

                        <a href="https://tiktok.com/<?= $u1 ?>" class="w-full py-3 bg-gradient-to-r from-yellow-400 to-amber-500 text-white font-black rounded-xl text-sm shadow-lg hover:scale-105 transition text-center z-10">
                            KUNJUNGI SULTAN
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($top3[2])): $u3 = formatUsername($top3[2]['nama_peserta']); ?>
                <div class="snap-center w-[70vw] shrink-0 relative flex flex-col group">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2 text-3xl z-30">🥉</div>
                    
                    <div class="bg-gradient-to-b from-white to-orange-50 rounded-3xl border-[3px] border-orange-300 p-6 flex flex-col items-center shadow-[0_10px_30px_rgba(251,146,60,0.3)] relative overflow-hidden h-[320px] justify-between">
                        
                        <div class="relative w-20 h-20 rounded-full p-1 bg-orange-300 mb-2">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u3 ?>" class="w-full h-full rounded-full bg-white object-cover">
                            <div class="absolute -bottom-2 inset-x-0 mx-auto w-max bg-orange-700 text-white text-[10px] font-black px-2 py-0.5 rounded-md">JUARA 3</div>
                        </div>

                        <div class="text-center w-full">
                            <h3 class="font-black text-slate-800 text-lg truncate w-full mb-1"><?= $u3 ?></h3>
                            <div class="inline-block bg-orange-100 px-3 py-1 rounded-lg">
                                <span class="font-bold text-orange-800 text-sm"><?= $top3[2]['jumlah_video'] ?> Video</span>
                            </div>
                        </div>

                        <a href="https://tiktok.com/<?= $u3 ?>" class="w-full py-2 bg-white border border-orange-200 text-orange-800 font-bold rounded-xl text-xs hover:bg-orange-50 transition text-center shadow-sm">
                            Lihat Profil
                        </a>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>

        <div class="hidden md:flex w-full flex-row items-end justify-center gap-6 mb-20">
            
            <?php if(isset($top3[1])): $u2 = formatUsername($top3[1]['nama_peserta']); ?>
            <div class="w-[30%] flex flex-col items-center group relative z-10 hover:-translate-y-2 transition-transform duration-300">
                <div class="relative mb-[-40px] z-20">
                    <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-b from-slate-100 to-slate-300 shadow-xl ring-4 ring-white"><img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u2 ?>" class="w-full h-full rounded-full object-cover bg-white"></div>
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-slate-700 text-white text-xs font-black px-3 py-1 rounded-full shadow-md">JUARA 2</div>
                </div>
                <div class="w-full bg-white rounded-[2rem] pt-14 pb-6 px-6 text-center shadow-2xl border border-slate-100 relative overflow-hidden">
                    <h3 class="text-slate-800 font-black text-lg font-fun mb-1 truncate"><?= $u2 ?></h3>
                    <div class="bg-slate-100 rounded-xl py-2 px-4 mb-4 inline-block"><span class="text-slate-800 font-black text-2xl"><?= $top3[1]['jumlah_video'] ?></span> <span class="text-slate-500 text-xs">Video</span></div>
                    <a href="https://tiktok.com/<?= $u2 ?>" target="_blank" class="block w-full py-2 rounded-lg bg-slate-800 text-white text-xs font-bold hover:bg-slate-900 transition-colors">Lihat Profil</a>
                </div>
            </div>
            <?php endif; ?>

            <?php if(isset($top3[0])): $u1 = formatUsername($top3[0]['nama_peserta']); ?>
            <div class="w-[35%] flex flex-col items-center z-20 -mt-12 group relative hover:-translate-y-2 transition-transform duration-300">
                <div class="text-6xl mb-[-10px] z-30 animate-bounce drop-shadow-lg relative top-4">👑</div>
                <div class="relative mb-[-50px] z-20">
                    <div class="w-32 h-32 rounded-full p-1.5 bg-gradient-to-b from-yellow-300 via-yellow-500 to-amber-600 shadow-2xl ring-4 ring-white"><img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u1 ?>" class="w-full h-full rounded-full object-cover bg-yellow-50"></div>
                    <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 bg-red-600 text-white text-sm font-black px-6 py-1.5 rounded-full border-2 border-yellow-300 shadow-lg">#1 KING</div>
                </div>
                <div class="w-full bg-gradient-to-b from-yellow-50 to-white rounded-[2.5rem] pt-16 pb-8 px-8 text-center shadow-[0_20px_60px_-15px_rgba(250,204,21,0.5)] border-[3px] border-yellow-400 relative overflow-hidden">
                    <div class="absolute inset-0 opacity-30 bg-[url('https://www.transparenttextures.com/patterns/confetti.png')]"></div>
                    <h3 class="text-slate-900 font-black text-2xl font-fun mb-1 truncate relative z-10"><?= $u1 ?></h3>
                    <p class="text-yellow-600 text-xs font-bold uppercase tracking-[0.2em] mb-6 relative z-10">The Champion</p>
                    <div class="bg-yellow-100 border border-yellow-300 rounded-2xl py-3 px-6 mb-6 relative z-10"><span class="text-yellow-800 font-black text-4xl block"><?= $top3[0]['jumlah_video'] ?></span><span class="text-yellow-600 text-xs font-bold uppercase tracking-wide">Video Valid</span></div>
                    <a href="https://tiktok.com/<?= $u1 ?>" target="_blank" class="block w-full py-3 rounded-xl bg-gradient-to-r from-yellow-400 to-amber-500 text-white font-bold text-sm shadow-lg hover:scale-105 transition-transform relative z-10">Kunjungi Profil 👑</a>
                </div>
            </div>
            <?php endif; ?>

            <?php if(isset($top3[2])): $u3 = formatUsername($top3[2]['nama_peserta']); ?>
            <div class="w-[30%] flex flex-col items-center group relative z-10 hover:-translate-y-2 transition-transform duration-300">
                <div class="relative mb-[-40px] z-20">
                    <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-b from-orange-200 to-orange-400 shadow-xl ring-4 ring-white"><img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u3 ?>" class="w-full h-full rounded-full object-cover bg-white"></div>
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-slate-700 text-white text-xs font-black px-3 py-1 rounded-full shadow-md">JUARA 3</div>
                </div>
                <div class="w-full bg-white rounded-[2rem] pt-14 pb-6 px-6 text-center shadow-2xl border border-slate-100 relative overflow-hidden">
                    <h3 class="text-slate-800 font-black text-lg font-fun mb-1 truncate"><?= $u3 ?></h3>
                    <div class="bg-slate-100 rounded-xl py-2 px-4 mb-4 inline-block"><span class="text-slate-800 font-black text-2xl"><?= $top3[2]['jumlah_video'] ?></span> <span class="text-slate-500 text-xs">Video</span></div>
                    <a href="https://tiktok.com/<?= $u3 ?>" target="_blank" class="block w-full py-2 rounded-lg bg-slate-800 text-white text-xs font-bold hover:bg-slate-900 transition-colors">Lihat Profil</a>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <?php if(count($sisanya) > 0): ?>
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 p-6 md:p-8 relative overflow-hidden">
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
        <?php endif; ?>

    </div>
</section>

<script>
    function scrollPodium(direction) {
        const container = document.getElementById('podium-scroll');
        const scrollAmount = container.clientWidth * 0.7; // Scroll 70%
        
        if (direction === 'left') {
            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
        } else {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        }
    }

    // Auto Center Juara 1 (Mobile)
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById('podium-scroll');
        const cardJuara1 = document.getElementById('card-juara-1');
        
        if (container && cardJuara1) {
            // Delay sedikit biar render layout selesai
            setTimeout(() => {
                const scrollPos = cardJuara1.offsetLeft - (container.clientWidth / 2) + (cardJuara1.clientWidth / 2);
                container.scrollTo({ left: scrollPos, behavior: 'smooth' });
            }, 100);
        }
    });
</script>
