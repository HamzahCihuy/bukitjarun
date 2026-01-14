<?php
// Cek koneksi db
if (!isset($pdo)) { include 'db/koneksi.php'; }

// QUERY: Mengambil Top Creator berdasarkan username
// Menghitung jumlah video valid (ada di tabel tickets)
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
    // Hapus spasi, ganti dengan underscore biar rapi ala username
    $clean = str_replace(' ', '_', $clean);
    // Kalau belum ada @, tambahkan
    if (substr($clean, 0, 1) !== '@') {
        return '@' . $clean;
    }
    return $clean;
}

// Pisahkan Top 3 dengan Sisanya
$top3 = array_slice($champions, 0, 3);
$sisanya = array_slice($champions, 3);
?>

<section id="leaderboard" class="py-24 relative overflow-hidden">
    
    <div class="absolute inset-0 bg-slate-900"></div>

    <div class="absolute top-0 left-1/4 w-96 h-96 bg-[#17FFB2] rounded-full mix-blend-overlay filter blur-[100px] opacity-20 animate-pulse"></div>
    <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-overlay filter blur-[100px] opacity-20 animate-pulse" style="animation-delay: 2s;"></div>
    
    <div class="absolute inset-0 opacity-[0.03]" 
         style="background-image: linear-gradient(#17FFB2 1px, transparent 1px), linear-gradient(to right, #17FFB2 1px, transparent 1px); background-size: 40px 40px;">
    </div>

    <div class="container mx-auto px-4 relative z-10 max-w-5xl">
        
        <div class="text-center mb-16 space-y-2">
            <span class="inline-block py-1 px-3 rounded-full bg-[#17FFB2]/10 border border-[#17FFB2]/30 text-[#17FFB2] text-xs font-bold tracking-widest uppercase mb-2">
                Hall of Fame
            </span>
            <h2 class="text-5xl md:text-7xl font-black font-fun text-white tracking-tight drop-shadow-lg">
                SULTAN <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#17FFB2] to-green-400">JAR'UN</span>
            </h2>
            <p class="text-slate-400 text-lg md:text-xl font-medium max-w-2xl mx-auto">
                Para konten kreator paling rajin yang sudah mendominasi bukit ini! 🔥
            </p>
        </div>

        <div class="flex flex-col md:flex-row items-end justify-center gap-6 mb-16 relative">
            
            <?php if(isset($top3[1])): $u2 = formatUsername($top3[1]['nama_peserta']); ?>
            <div class="order-2 md:order-1 w-full md:w-1/3 flex flex-col items-center group">
                <div class="relative mb-4 transition-transform duration-300 group-hover:-translate-y-2">
                    <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-b from-slate-300 to-slate-500 shadow-lg shadow-slate-500/20">
                        <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u2 ?>&backgroundColor=e2e8f0" 
                             class="w-full h-full rounded-full object-cover bg-slate-200">
                    </div>
                    <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 bg-slate-700 text-slate-200 text-xs font-bold px-3 py-1 rounded-full border border-slate-500 shadow-md">
                        #2
                    </div>
                </div>
                
                <div class="w-full bg-slate-800/50 backdrop-blur-md border border-slate-700 rounded-t-3xl p-6 text-center relative overflow-hidden hover:bg-slate-800/70 transition-colors">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-slate-400 to-transparent opacity-50"></div>
                    <h3 class="text-white font-bold text-lg font-fun mb-1 truncate"><?= $u2 ?></h3>
                    <p class="text-slate-400 text-sm font-medium mb-4">Silver Creator</p>
                    <div class="inline-block bg-slate-900/50 rounded-lg px-4 py-2 border border-slate-700">
                        <span class="text-[#17FFB2] font-black text-xl"><?= $top3[1]['jumlah_video'] ?></span>
                        <span class="text-slate-500 text-xs uppercase font-bold ml-1">Video</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if(isset($top3[0])): $u1 = formatUsername($top3[0]['nama_peserta']); ?>
            <div class="order-1 md:order-2 w-full md:w-1/3 flex flex-col items-center z-10 -mt-10 md:-mt-0 group">
                <div class="text-5xl mb-2 animate-bounce drop-shadow-lg">👑</div>
                
                <div class="relative mb-6 transition-transform duration-300 group-hover:-translate-y-3">
                    <div class="absolute -inset-4 bg-yellow-500/30 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-32 h-32 rounded-full p-1.5 bg-gradient-to-b from-yellow-300 via-yellow-400 to-yellow-600 shadow-2xl shadow-yellow-500/30">
                        <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u1 ?>&backgroundColor=fef08a" 
                             class="w-full h-full rounded-full object-cover bg-yellow-100">
                    </div>
                    <div class="absolute -bottom-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-yellow-500 to-amber-600 text-white text-sm font-black px-4 py-1.5 rounded-full border border-yellow-300 shadow-lg">
                        CHAMPION
                    </div>
                </div>
                
                <div class="w-full bg-gradient-to-b from-slate-800/80 to-slate-900/80 backdrop-blur-xl border border-yellow-500/30 rounded-t-[2.5rem] p-8 text-center relative overflow-hidden transform md:-translate-y-4 hover:border-yellow-500/50 transition-colors shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-tr from-yellow-500/10 to-transparent pointer-events-none"></div>
                    
                    <h3 class="text-2xl text-white font-black font-fun mb-1 truncate relative z-10"><?= $u1 ?></h3>
                    <p class="text-yellow-400/80 text-sm font-bold tracking-widest uppercase mb-6 relative z-10">The King of Jar'un</p>
                    
                    <div class="inline-flex items-center gap-2 bg-yellow-500/10 rounded-xl px-6 py-3 border border-yellow-500/20 relative z-10">
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
                    <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-b from-orange-300 to-orange-700 shadow-lg shadow-orange-700/20">
                        <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $u3 ?>&backgroundColor=ffedd5" 
                             class="w-full h-full rounded-full object-cover bg-orange-100">
                    </div>
                    <div class="absolute -bottom-3 left-1/2 transform -translate-x-1/2 bg-slate-700 text-slate-200 text-xs font-bold px-3 py-1 rounded-full border border-slate-500 shadow-md">
                        #3
                    </div>
                </div>
                
                <div class="w-full bg-slate-800/50 backdrop-blur-md border border-slate-700 rounded-t-3xl p-6 text-center relative overflow-hidden hover:bg-slate-800/70 transition-colors">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-orange-400 to-transparent opacity-50"></div>
                    <h3 class="text-white font-bold text-lg font-fun mb-1 truncate"><?= $u3 ?></h3>
                    <p class="text-slate-400 text-sm font-medium mb-4">Bronze Creator</p>
                    <div class="inline-block bg-slate-900/50 rounded-lg px-4 py-2 border border-slate-700">
                        <span class="text-[#17FFB2] font-black text-xl"><?= $top3[2]['jumlah_video'] ?></span>
                        <span class="text-slate-500 text-xs uppercase font-bold ml-1">Video</span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>

        <?php if(count($sisanya) > 0): ?>
        <div class="max-w-3xl mx-auto">
            <div class="bg-slate-800/40 backdrop-blur-md rounded-3xl border border-slate-700/50 p-6 md:p-8">
                <h4 class="text-white font-bold text-lg mb-6 flex items-center gap-2">
                    <span class="bg-slate-700 p-1.5 rounded-lg">🚀</span> 
                    Pengejar Top Global
                </h4>

                <div class="space-y-3">
                    <?php foreach($sisanya as $i => $row): $uname = formatUsername($row['nama_peserta']); ?>
                    <div class="group flex items-center justify-between p-3 rounded-2xl bg-slate-900/40 border border-slate-700/50 hover:bg-slate-800 hover:border-slate-600 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
                        
                        <div class="flex items-center gap-4 overflow-hidden">
                            <div class="w-8 text-center font-black text-slate-500 group-hover:text-[#17FFB2] transition-colors">
                                <?= $i + 4 ?>
                            </div>
                            
                            <div class="w-10 h-10 rounded-full bg-slate-700 p-0.5 shrink-0">
                                <img src="https://api.dicebear.com/7.x/notionists/svg?seed=<?= $uname ?>" class="w-full h-full rounded-full bg-slate-800">
                            </div>

                            <div class="flex flex-col min-w-0">
                                <span class="text-white font-bold text-sm truncate group-hover:text-[#17FFB2] transition-colors"><?= $uname ?></span>
                                <a href="https://tiktok.com/<?= $uname ?>" target="_blank" class="text-[10px] text-slate-400 hover:text-white flex items-center gap-1">
                                    Lihat Profil 
                                    <svg class="w-2 h-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>

                        <div class="flex flex-col items-end shrink-0 pl-2">
                            <span class="text-[#17FFB2] font-black text-lg leading-none"><?= $row['jumlah_video'] ?></span>
                            <span class="text-[10px] text-slate-500 font-bold uppercase">Video</span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php elseif(empty($top3)): ?>
             <div class="text-center py-12 bg-slate-800/30 rounded-3xl border border-dashed border-slate-700">
                <div class="text-6xl mb-4 opacity-50">👻</div>
                <h3 class="text-white font-bold text-xl mb-2">Belum ada Sultan!</h3>
                <p class="text-slate-400 text-sm max-w-xs mx-auto mb-6">Jadilah orang pertama yang menguasai leaderboard ini.</p>
                <a href="#event-section" class="inline-block bg-[#17FFB2] text-[#0E5941] px-6 py-3 rounded-xl font-bold font-fun hover:bg-white transition-colors shadow-lg shadow-green-500/20">
                    Gass Upload Sekarang! 🚀
                </a>
             </div>
        <?php endif; ?>

    </div>
</section>
