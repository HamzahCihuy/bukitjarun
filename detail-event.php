<?php
include 'db/koneksi.php';

$stmt = $pdo->query("SELECT * FROM events ORDER BY urutan ASC");
$list_event = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Misi - Bukit Jar'un</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-neon: #17FFB2;
            --text-dark: #0E5941;
        }
        body { 
            background-color: var(--bg-neon); 
            color: var(--text-dark);
            font-family: 'Nunito', sans-serif;
        }
        .font-fun { font-family: 'Fredoka', sans-serif; }
        
        .bg-pattern {
            background-image: radial-gradient(#0E5941 1px, transparent 1px);
            background-size: 24px 24px;
            opacity: 0.1;
        }

        .card-box {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
        }
        .card-box:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 30px -5px rgba(14, 89, 65, 0.2);
            cursor: pointer;
        }

        .modal { transition: opacity 0.25s ease; }
        body.modal-active { overflow: hidden; }
        .modal-content {
            transform: scale(0.9); opacity: 0; transition: all 0.3s ease;
        }
        .modal.open .modal-content { transform: scale(1); opacity: 1; }
        
        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { transform: scale(1.05); opacity: 1; }
            70% { transform: scale(0.9); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="min-h-screen relative pb-12">

    <div class="fixed inset-0 bg-pattern pointer-events-none z-0"></div>

    <div class="relative z-10 container mx-auto px-4 py-12 max-w-6xl">
        
        <div class="text-center mb-12">
            <a href="index.php" class="inline-block mb-6 px-4 py-2 bg-white rounded-full shadow-sm text-sm font-bold text-[#0E5941] hover:bg-opacity-90 transition">
                ← Kembali ke Beranda
            </a>
            
            <h1 class="text-4xl md:text-6xl font-black font-fun text-[#0E5941] drop-shadow-sm mb-4">
                Pilih Misi Kamu!
            </h1>
            
            <p class="text-lg md:text-xl font-medium text-[#0E5941] opacity-90">
                Selesaikan misi di bawah ini & dapatkan tiket makan gratis.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <?php if(empty($list_event)): ?>
                <div class="col-span-3 text-center py-10 bg-white/50 rounded-xl">
                    <p class="text-xl font-bold opacity-50">Belum ada event aktif.</p>
                </div>
            <?php endif; ?>

            <?php foreach($list_event as $index => $row): ?>
            
            <div onclick="toggleModal('modal-<?= $row['id'] ?>')" 
                 class="card-box bg-white rounded-[2rem] p-6 flex flex-col items-center text-center shadow-lg relative overflow-hidden group border-4 border-transparent hover:border-[#0E5941]/10">
                
                <div class="absolute top-4 right-4 w-10 h-10 rounded-full bg-[#17FFB2] flex items-center justify-center font-bold text-[#0E5941] shadow-inner">
                    #<?= $row['urutan'] ?>
                </div>

                <div class="w-24 h-24 mb-4 transform group-hover:scale-110 transition duration-300">
                    <img src="<?= htmlspecialchars($row['reward_img']) ?>" alt="Icon" class="w-full h-full object-contain">
                </div>

                <h3 class="text-2xl font-fun font-bold text-[#0E5941] mb-2 leading-tight">
                    <?= htmlspecialchars($row['title']) ?>
                </h3>
                
                <span class="mt-auto inline-block text-sm font-bold border-2 border-[#0E5941] text-[#0E5941] px-4 py-1 rounded-full group-hover:bg-[#0E5941] group-hover:text-white transition">
                    Lihat Detail
                </span>
            </div>

            <div id="modal-<?= $row['id'] ?>" class="modal opacity-0 pointer-events-none fixed inset-0 z-50 flex items-center justify-center p-4">
                
                <div class="modal-overlay absolute inset-0 bg-[#0E5941] bg-opacity-80 backdrop-blur-sm" onclick="toggleModal('modal-<?= $row['id'] ?>')"></div>
                
                <div class="modal-content bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl relative overflow-hidden flex flex-col max-h-[90vh]">
                    
                    <div class="p-6 flex justify-center items-center relative" 
                         style="background: linear-gradient(135deg, <?= $row['color_primary'] ?>, <?= $row['color_accent'] ?>);">
                        
                        <button onclick="toggleModal('modal-<?= $row['id'] ?>')" class="absolute top-4 right-4 bg-white w-10 h-10 rounded-full flex items-center justify-center text-[#0E5941] font-bold hover:bg-red-100 transition shadow-md z-10">✕</button>
                        
                        <img src="<?= htmlspecialchars($row['reward_img']) ?>" class="w-24 h-24 object-contain drop-shadow-xl animate-bounce">
                    </div>

                    <div class="p-8 pt-6 overflow-y-auto">
                        <h2 class="text-2xl font-fun font-black text-[#0E5941] mb-2 text-center leading-tight">
                            <?= htmlspecialchars($row['title']) ?>
                        </h2>
                        
                        <div class="bg-green-50 rounded-xl p-3 mb-6 text-center border border-green-100">
                             <p class="text-sm text-[#0E5941] font-bold">🎯 Misi: <?= htmlspecialchars($row['mission']) ?></p>
                        </div>

                        <div class="mb-6 text-left">
                            <h4 class="font-bold text-sm mb-2 text-gray-500 uppercase">Syarat & Ketentuan:</h4>
                            <ul class="list-disc pl-5 space-y-1 text-sm text-gray-700">
                                <?php 
                                    $syarat_list = explode(PHP_EOL, $row['syarat']);
                                    foreach($syarat_list as $syarat_item):
                                        if(trim($syarat_item) != ""):
                                ?>
                                    <li><?= trim($syarat_item) ?></li>
                                <?php endif; endforeach; ?>
                            </ul>
                        </div>

                        <div id="form-claim-<?= $row['id'] ?>">
                            <div class="space-y-4">
                                
<div>
    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Username TikTok/IG</label>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <span class="text-gray-400 font-bold">@</span>
        </div>
        <input type="text" id="nama-<?= $row['id'] ?>" 
               class="w-full pl-10 pr-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-100 focus:border-[#17FFB2] focus:bg-white outline-none transition font-bold text-[#0E5941]" 
               placeholder="username_kamu">
    </div>
    <p class="text-[10px] text-gray-400 mt-1 ml-1">*Tanpa spasi, contoh: bukitjarun_official</p>
</div>
                            </div>

                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">WhatsApp (Aktif)</label>
                                    <input type="tel" id="hp-<?= $row['id'] ?>" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-100 focus:border-[#17FFB2] focus:bg-white outline-none transition font-bold text-[#0E5941]" placeholder="08...">
                                </div>
                                
                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">
                                        Bukti Video (Wajib <?= $row['video_limit'] ?? 1 ?> Video)
                                    </label>
                                    
                                    <div class="space-y-3">
                                        <?php 
                                            $limit = $row['video_limit'] ?? 1; 
                                            if($limit < 1) $limit = 1;

                                            for($i = 1; $i <= $limit; $i++): 
                                        ?>
                                        <input type="url" class="input-video-<?= $row['id'] ?> w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-[#17FFB2] focus:ring-2 focus:ring-[#17FFB2]/20 text-sm" 
                                               placeholder="Link Video TikTok/IG #<?= $i ?>">
                                        <?php endfor; ?>
                                    </div>
                                    <p class="text-[10px] text-gray-400 mt-2">*Pastikan akun tidak diprivate.</p>
                                </div>

                                <input type="hidden" id="prompt-<?= $row['id'] ?>" value="<?= htmlspecialchars($row['ai_prompt'] ?? '') ?>">

                                <button onclick="verifikasiVideo(<?= $row['id'] ?>)" class="w-full py-4 rounded-xl bg-[#0E5941] text-white font-fun font-bold text-lg shadow-lg hover:bg-opacity-90 transform active:scale-95 transition flex justify-center items-center gap-2 mt-2">
                                    <span>Verifikasi Video 🚀</span>
                                    <span id="loading-<?= $row['id'] ?>" class="hidden animate-spin text-2xl">⏳</span>
                                </button>
                            </div>
                        </div>

                        <div id="fail-claim-<?= $row['id'] ?>" class="hidden text-center py-4">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-3xl">😢</span>
                            </div>
                            <h3 class="text-lg font-black text-red-500 mb-1">Yah, Belum Lolos.</h3>
                            <p id="error-msg-<?= $row['id'] ?>" class="text-sm text-gray-600 mb-4 bg-gray-100 p-3 rounded-lg border border-red-100">
                                Video tidak sesuai.
                            </p>
                            <button onclick="resetForm(<?= $row['id'] ?>)" class="text-sm font-bold text-[#0E5941] underline hover:text-[#17FFB2]">
                                Coba Perbaiki Link
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        function toggleModal(modalID) {
            const modal = document.getElementById(modalID);
            const body = document.body;
            if (modal.classList.contains('opacity-0')) {
                modal.classList.remove('opacity-0', 'pointer-events-none'); 
                modal.classList.add('open'); 
                body.classList.add('modal-active');
            } else {
                modal.classList.remove('open'); 
                setTimeout(() => { modal.classList.add('opacity-0', 'pointer-events-none'); }, 100); 
                body.classList.remove('modal-active');
            }
        }

        document.onkeydown = function(evt) {
            evt = evt || window.event;
            if (evt.keyCode == 27) {
                document.querySelectorAll('.modal').forEach(modal => { 
                    modal.classList.remove('open'); 
                    modal.classList.add('opacity-0', 'pointer-events-none'); 
                });
                document.body.classList.remove('modal-active');
            }
        };

        async function verifikasiVideo(id) {
            const inputNama = document.getElementById('nama-' + id).value.trim();
            const inputHP   = document.getElementById('hp-' + id).value.trim();
            const promptAI  = document.getElementById('prompt-' + id).value;
            
            const videoInputs = document.querySelectorAll(`.input-video-${id}`);
            let listLinks = [];
            let adaKosong = false;

            videoInputs.forEach(input => {
                const val = input.value.trim();
                if(val === "") adaKosong = true;
                listLinks.push(val);
            });

            if (!inputNama || !inputHP || adaKosong) {
                alert("Mohon lengkapi:\n- Nama Lengkap\n- Nomor WhatsApp\n- SEMUA Link Video");
                return;
            }

            const btnVerifikasi = document.querySelector(`#form-claim-${id} button`);
            const loadingIcon = document.getElementById('loading-' + id);
            const divFail = document.getElementById('fail-claim-' + id);
            const textFail = document.getElementById('error-msg-' + id);
            const divForm = document.getElementById('form-claim-' + id);

            btnVerifikasi.disabled = true;
            btnVerifikasi.classList.add('opacity-50', 'cursor-not-allowed');
            loadingIcon.classList.remove('hidden');

            try {
                const aiResponse = await fetch('https://my-ai-api-production-a4c4.up.railway.app/cek-video', { 
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        urls: listLinks,
                        nama: inputNama,
                        prompt_ai: promptAI,
                        misi_id: id
                    })
                });

                const textPython = await aiResponse.text();
                let aiData;
                try {
                    aiData = JSON.parse(textPython); 
                } catch (e) {
                    throw new Error("SERVER AI ERROR:\n" + textPython.substring(0, 100));
                }

                if (!aiResponse.ok) throw new Error("Koneksi AI Gagal");
                
                if (aiData.status === "VALID") {
                    
                    const judulMisi = document.querySelector(`#modal-${id} h2`).innerText;
                    const combinedLinks = listLinks.join(', ');

                    const saveResponse = await fetch('api-save-ticket.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            name: inputNama,
                            no_hp: inputHP,
                            mission: judulMisi,
                            video_hash: aiData.video_hash,
                            link: combinedLinks
                        })
                    });

                    const saveResult = await saveResponse.json();

                    if(saveResult.status === 'success') {
                        const urlParams = new URLSearchParams({
                            code: saveResult.generated_code, 
                            name: inputNama,
                            mission: judulMisi
                        }).toString();
                        
                        window.location.href = 'detail-voucher.php?' + urlParams;
                    } else {
                        throw new Error(saveResult.msg || "Gagal menyimpan data.");
                    }

                } else {
                    loadingIcon.classList.add('hidden');
                    divForm.classList.add('hidden');
                    divFail.classList.remove('hidden');
                    textFail.innerText = aiData.alasan || "Video tidak memenuhi kriteria.";
                    
                    btnVerifikasi.disabled = false;
                    btnVerifikasi.classList.remove('opacity-50', 'cursor-not-allowed');
                }

            } catch (error) {
                console.error("System Error:", error);
                
                if(error.message.includes("PLAGIAT")) {
                     alert("⛔ PENOLAKAN SISTEM:\n" + error.message);
                } else {
                     alert("Terjadi Kesalahan Teknis:\n" + error.message);
                }
                
                btnVerifikasi.disabled = false;
                btnVerifikasi.classList.remove('opacity-50', 'cursor-not-allowed');
                loadingIcon.classList.add('hidden');
            }
        }

        function resetForm(id) {
            document.getElementById('form-claim-' + id).classList.remove('hidden');
            document.getElementById('fail-claim-' + id).classList.add('hidden');
            const btnVerifikasi = document.querySelector(`#form-claim-${id} button`);
            btnVerifikasi.disabled = false;
            btnVerifikasi.classList.remove('opacity-50', 'cursor-not-allowed');
        }
    </script>
</body>
</html>

