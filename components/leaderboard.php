<?php
// Cek koneksi db
if (!isset($pdo)) { include 'db/koneksi.php'; }

// QUERY: Mengambil Top Creator
$sql = "SELECT nama_peserta, COUNT(*) as jumlah_video 
        FROM tickets 
        GROUP BY nama_peserta 
        ORDER BY jumlah_video DESC, max(waktu_dibuat) ASC 
        LIMIT 10";

$stmt = $pdo->query($sql);
$champions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Helper Function: Auto Add @ dan Cleanup
function formatUsername($rawName) {
    $clean = trim($rawName);
    $clean = str_replace(' ', '_', $clean);
    if (substr($clean, 0, 1) !== '@') {
        return '@' . $clean;
    }
    return $clean;
}

$top3 = array_slice($champions, 0, 3);
$sisanya = array_slice($champions, 3);
?>

<section id="leaderboard" class="py-24 relative overflow-hidden bg-white">
    
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
        <div class="absolute -top-20 -left-20 w-96 h-96 bg-green-100 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-pulse"></div>
        <div class="absolute top-1/2 -right-20 w-80 h-80 bg-yellow-100 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-20 left-1/3 w-96 h-96 bg-blue-50 rounded-full mix-blend-multiply filter blur-[80px] opacity-70"></div>
    </div>

    <div class="absolute inset-0 opacity-[0.4]" 
         style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 24px 24px;">
    </div>

    <div class="container mx-auto px-4 relative z-10 max-w-5xl">
        
        <div class="text-center mb-16 space-y-3">
            <span class="inline-flex items-center gap-2 py-1.5 px-4 rounded-full bg-green-50 border border-green-100 text-[#0E5941] text-xs font-bold tracking-widest uppercase shadow-sm">
                <span class="w-2 h-2 rounded-full bg-[#17FFB2] animate-pulse"></span>
                Hall of Fame
            </span>
            <h2 class="text-5xl md:text-7xl font-black font-fun text-slate-800 tracking-tight drop-shadow-sm">
                SULTAN <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#0E5941] to-green-600">JAR'UN</span>
            </h2>
            <p class="text-slate-500 text-lg md:text-xl font-medium max-w-2xl mx-auto">
                Para konten kreator paling rajin yang sudah mendominasi bukit ini! 🔥
            </p>
        </div>

        <div class="flex flex-col md:flex-row items-end justify-center gap-6 mb-16 relative">
            
            <?php if(isset($top3[1])): $u2 = formatUsername($top3[1]['nama_peserta']); ?>
            <div class="order-2 md:order-1 w-full md:w-1/3 flex flex-col items-center group">
                <div class="relative mb-4 transition-transform duration-300 group-hover:-translate-y-2">
                    <div class="w-24 h-24 rounded-full p-1 bg-white shadow-xl shadow-slate-200 ring-4 ring-slate-100">
                        <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u2 ?>&backgroundColor=e2e8f0" 
                             class="w-full h-full rounded-full object-cover bg-slate-100">
                    </div>
                    <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 bg-slate-700 text-white text-xs font-bold px-3 py-1 rounded-full border-2 border-white shadow-md">
                        #2
                    </div>
                </div>
                
                <div class="w-full bg-white border border-slate-100 rounded-t-3xl p-6 text-center relative overflow-hidden hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 shadow-lg shadow-slate-100">
                    <h3 class="text-slate-800 font-bold text-lg font-fun mb-1 truncate"><?= $u2 ?></h3>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-4">Silver Creator</p>
                    <div class="inline-block bg-slate-50 rounded-lg px-4 py-2 border border-slate-200">
                        <span class="text-slate-800 font-black text-xl"><?= $top3[1]['jumlah_video'] ?></span>
                        <span class="text-slate-400 text-xs uppercase font-bold ml-1">Video</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if(isset($top3[0])): $u1 = formatUsername($top3[0]['nama_peserta']); ?>
            <div class="order-1 md:order-2 w-full md:w-1/3 flex flex-col items-center z-10 -mt-10 md:-mt-0 group">
                <div class="text-5xl mb-2 animate-bounce drop-shadow-md">👑</div>
                
                <div class="relative mb-6 transition-transform duration-300 group-hover:-translate-y-3">
                    <div class="absolute -inset-4 bg-yellow-200 rounded-full blur-xl opacity-0 group-hover:opacity-60 transition-opacity"></div>
                    <div class="w-32 h-32 rounded-full p-1.5 bg-gradient-to-b from-yellow-300 to-yellow-500 shadow-2xl shadow-yellow-500/20 ring-4 ring-white">
                        <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u1 ?>&backgroundColor=fef08a" 
                             class="w-full h-full rounded-full object-cover bg-yellow-50">
                    </div>
                    <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-yellow-500 to-amber-600 text-white text-sm font-black px-4 py-1.5 rounded-full border-2 border-white shadow-lg">
                        CHAMPION
                    </div>
                </div>
                
                <div class="w-full bg-gradient-to-b from-[#0E5941] to-[#083a2b] rounded-t-[2.5rem] p-8 text-center relative overflow-hidden transform md:-translate-y-4 shadow-2xl shadow-green-900/20 hover:-translate-y-5 transition-transform duration-300">
                    <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
                    
                    <h3 class="text-2xl text-white font-black font-fun mb-1 truncate relative z-10"><?= $u1 ?></h3>
                    <p class="text-[#17FFB2] text-sm font-bold tracking-widest uppercase mb-6 relative z-10">The King of Jar'un</p>
                    
                    <div class="inline-flex items-center gap-2 bg-white/10 rounded-xl px-6 py-3 border border-white/10 relative z-10 backdrop-blur-sm">
                        <span class="text-yellow-400 text-3xl font-black"><?= $top3[0]['jumlah_video'] ?></span>
                        <div class="flex flex-col items-start leading-none">
                            <span class="text-slate-300 text-[10px] uppercase font-bold">Total</span>
                            <span class="text-white text-xs font-bold">Video Valid</span>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if(isset($top3[2])): $u3 = formatUsername($top3[2]['nama_peserta']); ?>
            <div class="order-3 md:order-3 w-full md:w-1/3 flex flex-col items-center group">
                <div class="relative mb-4 transition-transform duration-300 group-hover:-translate-y-2">
                    <div class="w-24 h-24 rounded-full p-1 bg-white shadow-xl shadow-slate-200 ring-4 ring-slate-100">
                        <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u3 ?>&backgroundColor=ffedd5" 
                             class="w-full h-full rounded-full object-cover bg-orange-50">
                    </div>
                    <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 bg-slate-700 text-white text-xs font-bold px-3 py-1 rounded-full border-2 border-white shadow-md">
                        #3
                    </div>
                </div>
                
                <div class="w-full bg-white border border-slate-100 rounded-t-3xl p-6 text-center relative overflow-hidden hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-300 shadow-lg shadow-slate-100">
                    <h3 class="text-slate-800 font-bold text-lg font-fun mb-1 truncate"><?= $u3 ?></h3>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-wider mb-4">Bronze Creator</p>
                    <div class="inline-block bg-slate-50 rounded-lg px-4 py-2 border border-slate-200">
                        <span class="text-slate-800 font-black text-xl"><?= $top3[2]['jumlah_video'] ?></span>
                        <span class="text-slate-400 text-xs uppercase font-bold ml-1">Video</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <?php if(count($sisanya) > 0): ?>
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50 p-6 md:p-8">
                <h4 class="text-slate-800 font-bold text-lg mb-6 flex items-center gap-2">
                    <span class="bg-green-100 text-green-600 p-1.5 rounded-lg">🚀</span> 
                    Pengejar Top Global
                </h4>

                <div class="space-y-3">
                    <?php foreach($sisanya as $i => $row): $uname = formatUsername($row['nama_peserta']); ?>
                    <div class="group flex items-center justify-between p-3 rounded-2xl bg-slate-50 border border-transparent hover:bg-white hover:border-green-200 hover:shadow-lg hover:shadow-green-100/50 transition-all duration-300 hover:-translate-y-0.5 cursor-default">
                        
                        <div class="flex items-center gap-4 overflow-hidden">
                            <div class="w-8 text-center font-black text-slate-300 group-hover:text-[#0E5941] transition-colors text-lg">
                                <?= $i + 4 ?>
                            </div>
                            
                            <div class="w-10 h-10 rounded-full bg-white border border-slate-200 p-0.5 shrink-0 group-hover:scale-110 transition-transform">
                                <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $uname ?>" class="w-full h-full rounded-full bg-slate-100">
                            </div>

                            <div class="flex flex-col min-w-0">
                                <span class="text-slate-800 font-bold text-sm truncate group-hover:text-green-700 transition-colors"><?= $uname ?></span>
                                <a href="https://tiktok.com/<?= $uname ?>" target="_blank" class="text-[10px] text-slate-400 hover:text-green-600 flex items-center gap-1">
                                    Lihat Profil 
                                    <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
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
                <a href="#event-section" class="inline-block bg-[#0E5941] text-white px-6 py-3 rounded-xl font-bold font-fun hover:bg-green-800 transition-colors shadow-lg shadow-green-900/20">
                    Gass Upload Sekarang! 🚀
                </a>
             </div>
        <?php endif; ?>

    </div>
</section>
