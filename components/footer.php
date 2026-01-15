<?php
// Ambil data Settings dari Database
if (!isset($pdo)) { include 'db/koneksi.php'; }
$footer = $pdo->query("SELECT * FROM footer_settings WHERE id=1")->fetch(PDO::FETCH_ASSOC);
?>

<footer class="relative bg-[#064E3B] text-white pt-20 pb-10 mt-20 font-fun">

    <div class="absolute inset-0 opacity-5 pointer-events-none" 
         style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <img src="assets/image/logojarun.png" alt="Logo" class="h-12 brightness-0 invert">
                </div>
                <p class="text-slate-300 text-sm leading-relaxed">
                    <?= nl2br(htmlspecialchars($footer['description'])) ?>
                </p>
                <div class="pt-2">
                    <span class="inline-block bg-[#17FFB2] text-[#064E3B] text-xs font-bold px-3 py-1 rounded-full">
                        Buka: <?= htmlspecialchars($footer['opening_hours']) ?>
                    </span>
                </div>
            </div>

            <div>
                <h3 class="text-xl font-bold mb-6 text-[#17FFB2]">Jelajahi</h3>
                <ul class="space-y-3 text-sm text-slate-300">
                    <li><a href="#event-section" class="hover:text-[#17FFB2] hover:translate-x-2 transition-transform inline-block">🎉 Event Seru</a></li>
                    <li><a href="#leaderboard" class="hover:text-[#17FFB2] hover:translate-x-2 transition-transform inline-block">🏆 Leaderboard</a></li>
                    <li><a href="#menfess" class="hover:text-[#17FFB2] hover:translate-x-2 transition-transform inline-block">💌 Menfess Netizen</a></li>
                    <li><a href="#" class="hover:text-[#17FFB2] hover:translate-x-2 transition-transform inline-block">🎟️ Pesan Tiket</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xl font-bold mb-6 text-[#17FFB2]">Hubungi Kami</h3>
                <ul class="space-y-4 text-sm text-slate-300">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt text-[#17FFB2] mt-1 shrink-0"></i>
                        <span><?= nl2br(htmlspecialchars($footer['address'])) ?></span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fab fa-whatsapp text-[#17FFB2] text-lg"></i>
                        <a href="https://wa.me/<?= htmlspecialchars($footer['whatsapp']) ?>" target="_blank" class="hover:text-white transition">
                            +<?= htmlspecialchars($footer['whatsapp']) ?>
                        </a>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="far fa-envelope text-[#17FFB2]"></i>
                        <a href="mailto:<?= htmlspecialchars($footer['email']) ?>" class="hover:text-white transition">
                            <?= htmlspecialchars($footer['email']) ?>
                        </a>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-xl font-bold mb-6 text-[#17FFB2]">Ikuti Keseruan!</h3>
                
                <div class="flex gap-3 mb-8">
                    <?php if($footer['link_instagram']): ?>
                    <a href="<?= htmlspecialchars($footer['link_instagram']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#E1306C] hover:text-white transition-all duration-300 hover:scale-110">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                    <?php endif; ?>

                    <?php if($footer['link_tiktok']): ?>
                    <a href="<?= htmlspecialchars($footer['link_tiktok']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-black hover:text-white transition-all duration-300 hover:scale-110">
                        <i class="fab fa-tiktok text-xl"></i>
                    </a>
                    <?php endif; ?>

                    <?php if($footer['link_youtube']): ?>
                    <a href="<?= htmlspecialchars($footer['link_youtube']) ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-[#FF0000] hover:text-white transition-all duration-300 hover:scale-110">
                        <i class="fab fa-youtube text-xl"></i>
                    </a>
                    <?php endif; ?>
                </div>

                <p class="text-xs text-slate-400 mb-3">Dapetin info promo & event terbaru:</p>
                <div class="relative">
                    <input type="email" placeholder="Email kamu..." class="w-full bg-white/10 border border-white/20 rounded-xl py-3 px-4 text-sm text-white placeholder-slate-400 focus:outline-none focus:border-[#17FFB2] transition">
                    <button class="absolute right-1 top-1 bg-[#17FFB2] text-[#064E3B] p-2 rounded-lg hover:bg-white transition">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>

        </div>

        <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-slate-400 text-sm text-center md:text-left">
                &copy; <?= date('Y') ?> <b>Bukit Jar'un</b>. All Rights Reserved.
            </p>
            <p class="text-slate-500 text-xs flex items-center gap-1">
                Made with <span class="text-red-500 animate-pulse">❤</span> by Tim IT Jar'un
            </p>
        </div>
    </div>
</footer>
