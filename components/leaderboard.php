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
    .font-fun { font-family: 'Fredoka', sans-serif; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

    /* TikTok Glitch Border Effect */
    .tiktok-border {
        position: relative;
        background: white;
        z-index: 1;
    }
    .tiktok-border::before {
        content: "";
        position: absolute;
        inset: -3px;
        z-index: -1;
        background: linear-gradient(45deg, #69C9D0, #EE1D52);
        border-radius: 2rem; 
        opacity: 0.8;
    }

    /* Verified Badge Animation */
    @keyframes pop-check {
        0% { transform: scale(0); }
        80% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    .animate-pop { animation: pop-check 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards; animation-delay: 0.3s; transform: scale(0); }
</style>

<section id="leaderboard" class="py-20 relative overflow-hidden bg-white">
    
    <div class="absolute inset-0 opacity-[0.4]" style="background-image: radial-gradient(#17FFB2 2px, transparent 2px); background-size: 24px 24px;"></div>
    
    <div class="container mx-auto px-4 relative z-10 max-w-5xl">
        
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 bg-black text-white px-4 py-1.5 rounded-full mb-4 shadow-lg transform -rotate-2">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                <span class="text-xs font-bold tracking-widest uppercase">Official Leaderboard</span>
            </div>
            
            <h2 class="text-5xl md:text-7xl font-black font-fun tracking-wide text-slate-900 drop-shadow-sm">
                TOP <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#69C9D0] to-[#EE1D52]">CREATOR</span>
            </h2>
            <p class="text-slate-500 font-fun text-lg mt-2">
                Para Sultan FYP Minggu Ini! 🔥
            </p>
        </div>

        <div class="relative w-full mb-16">
            
            <button onclick="scrollPodium('left')" class="absolute left-2 md:-left-8 top-1/2 -translate-y-1/2 z-40 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg border border-slate-200 text-slate-700 hover:text-[#EE1D52] transition active:scale-90">
                <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path></svg>
            </button>
            <button onclick="scrollPodium('right')" class="absolute right-2 md:-right-8 top-1/2 -translate-y-1/2 z-40 w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-lg border border-slate-200 text-slate-700 hover:text-[#69C9D0] transition active:scale-90">
                <svg class="w-6 h-6 font-bold" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <div id="podium-scroll" class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar px-[15vw] md:px-[30%] py-12 items-center">
                
                <?php if(isset($top3[1])): $u2 = formatUsername($top3[1]['nama_peserta']); ?>
                <div class="snap-center shrink-0 w-[70vw] md:w-[280px] relative group transform transition-transform duration-300 scale-95 hover:scale-100">
                    <div class="bg-white rounded-[2rem] border border-slate-200 p-6 flex flex-col items-center shadow-xl relative overflow-hidden h-[300px] justify-between">
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 opacity-[0.05] pointer-events-none">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                        </div>

                        <div class="absolute top-4 left-4 bg-slate-100 text-slate-500 px-3 py-1 font-fun font-bold rounded-full text-xs border border-slate-200">Rank 2</div>

                        <div class="relative w-20 h-20 rounded-full p-1 bg-gradient-to-tr from-slate-200 to-slate-300 mt-4">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u2 ?>" class="w-full h-full rounded-full bg-white object-cover border-2 border-white">
                        </div>
                        
                        <div class="text-center w-full mt-2 relative z-10">
                            <div class="flex items-center justify-center gap-1">
                                <h3 class="font-fun font-bold text-lg text-slate-800 truncate max-w-[150px]"><?= $u2 ?></h3>
                            </div>
                            <p class="text-slate-400 font-bold text-xs mt-1"><?= $top3[1]['jumlah_video'] ?> Videos</p>
                        </div>
                        
                        <a href="https://tiktok.com/<?= $u2 ?>" target="_blank" class="w-full py-2 bg-[#EE1D52] text-white font-fun font-bold rounded-lg text-xs hover:bg-pink-700 transition text-center shadow-md">
                            Follow
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($top3[0])): $u1 = formatUsername($top3[0]['nama_peserta']); ?>
                <div id="card-juara-1" class="snap-center shrink-0 w-[75vw] md:w-[320px] relative group transform transition-transform duration-300 scale-105 z-20">
                    
                    <div class="absolute -top-10 left-1/2 -translate-x-1/2 z-30">
                        <span class="bg-black text-[#69C9D0] text-xs font-bold px-4 py-1 rounded-t-lg border-t border-x border-[#69C9D0] tracking-widest">TRENDING #1</span>
                    </div>
                    
                    <div class="tiktok-border rounded-[2.5rem] p-1 h-[380px] shadow-2xl shadow-cyan-500/20 relative">
                        <div class="bg-white w-full h-full rounded-[2.3rem] p-6 flex flex-col items-center relative overflow-hidden justify-between">
                            
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-48 h-48 opacity-[0.03] pointer-events-none">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                            </div>

                            <div class="relative mt-4">
                                <div class="absolute -inset-2 bg-gradient-to-tr from-[#69C9D0] to-[#EE1D52] rounded-full opacity-70 blur-sm animate-pulse"></div>
                                <div class="relative w-28 h-28 rounded-full p-[3px] bg-white">
                                    <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u1 ?>" class="w-full h-full rounded-full bg-slate-50 object-cover">
                                    
                                    <div class="absolute bottom-1 right-1 bg-[#EE1D52] text-white rounded-full w-7 h-7 flex items-center justify-center border-2 border-white shadow-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-center w-full relative z-10">
                                <div class="flex items-center justify-center gap-1 mb-1">
                                    <h3 class="font-fun font-black text-2xl text-slate-900 truncate max-w-[180px]"><?= $u1 ?></h3>
                                    <div class="w-5 h-5 text-[#20D5EC] animate-pop">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M10.243 16.314l-.82-3.374a.55.55 0 01.99-.44l.82 2.22 4.15-5.94a.55.55 0 01.96.48l-4.7 7.5a.55.55 0 01-.88-.04l-2.52-4.406z"/><path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zm0 1.5a8.25 8.25 0 100 16.5 8.25 8.25 0 000-16.5z" clip-rule="evenodd"/></svg>
                                    </div>
                                </div>
                                <div class="text-slate-900 font-bold text-sm bg-slate-100 px-3 py-1 rounded-full inline-block">
                                    <?= $top3[0]['jumlah_video'] ?> <span class="text-slate-500 font-normal">Videos</span>
                                </div>
                            </div>
                            
                            <a href="https://tiktok.com/<?= $u1 ?>" target="_blank" class="relative z-10 w-full py-3 bg-[#EE1D52] text-white font-fun font-bold rounded-xl text-sm shadow-lg hover:bg-pink-700 transition text-center flex items-center justify-center gap-2">
                                <span>Cek Profil</span>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if(isset($top3[2])): $u3 = formatUsername($top3[2]['nama_peserta']); ?>
                <div class="snap-center shrink-0 w-[70vw] md:w-[280px] relative group transform transition-transform duration-300 scale-95 hover:scale-100">
                    <div class="bg-white rounded-[2rem] border border-slate-200 p-6 flex flex-col items-center shadow-xl relative overflow-hidden h-[300px] justify-between">
                        
                        <div class="absolute -right-4 -bottom-4 w-24 h-24 opacity-[0.05] pointer-events-none">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                        </div>

                        <div class="absolute top-4 left-4 bg-slate-100 text-slate-500 px-3 py-1 font-fun font-bold rounded-full text-xs border border-slate-200">Rank 3</div>

                        <div class="relative w-20 h-20 rounded-full p-1 bg-gradient-to-tr from-slate-200 to-slate-300 mt-4">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u3 ?>" class="w-full h-full rounded-full bg-white object-cover border-2 border-white">
                        </div>
                        
                        <div class="text-center w-full mt-2 relative z-10">
                            <h3 class="font-fun font-bold text-lg text-slate-800 truncate max-w-[150px]"><?= $u3 ?></h3>
                            <p class="text-slate-400 font-bold text-xs mt-1"><?= $top3[2]['jumlah_video'] ?> Videos</p>
                        </div>
                        
                        <a href="https://tiktok.com/<?= $u3 ?>" target="_blank" class="w-full py-2 bg-[#EE1D52] text-white font-fun font-bold rounded-lg text-xs hover:bg-pink-700 transition text-center shadow-md">
                            Follow
                        </a>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>

        <?php if(count($sisanya) > 0): ?>
        <div class="max-w-2xl mx-auto bg-white rounded-3xl border-2 border-slate-100 p-6 shadow-xl relative overflow-hidden">
            <div class="flex items-center gap-2 mb-6">
                <div class="w-8 h-8 bg-black rounded-full flex items-center justify-center text-white shadow-lg">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/></svg>
                </div>
                <h4 class="font-fun font-bold text-xl text-slate-800">
                    Rising Stars
                </h4>
            </div>

            <div class="space-y-3">
                <?php foreach($sisanya as $i => $row): $uname = formatUsername($row['nama_peserta']); ?>
                <div class="flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-transparent hover:border-[#69C9D0] hover:bg-white hover:shadow-md transition duration-300 group cursor-default">
                    <div class="flex items-center gap-4">
                        <div class="w-8 font-fun font-black text-xl text-slate-300 text-center group-hover:text-[#EE1D52] transition"><?= $i + 4 ?></div>
                        <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-slate-200 group-hover:scale-110 transition">
                            <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $uname ?>" class="w-full h-full bg-white">
                        </div>
                        <div class="flex flex-col">
                            <span class="font-fun font-bold text-slate-700 group-hover:text-black"><?= $uname ?></span>
                            <a href="https://tiktok.com/<?= $uname ?>" target="_blank" class="text-[10px] font-bold text-slate-400 group-hover:text-[#EE1D52] flex items-center gap-1">
                                Cek Profil
                            </a>
                        </div>
                    </div>
                    <div class="font-fun font-black text-lg text-slate-400 group-hover:text-black">
                        <?= $row['jumlah_video'] ?> <span class="text-xs font-normal">Vid</span>
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
