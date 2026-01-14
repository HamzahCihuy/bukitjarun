<?php
// 1. KONEKSI DATABASE
include 'db/koneksi.php';

// 2. AMBIL DATA DARI DATABASE (Tabel 'events')
// Kita urutkan sesuai 'urutan' yang diatur di CMS
$stmt = $pdo->query("SELECT * FROM events ORDER BY urutan ASC");
$list_event = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Misi Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* Konfigurasi Warna Custom */
        :root {
            --bg-neon: #17FFB2;
            --bg-white: #ffffff;
            --text-dark: #0E5941;
        }

        body { 
            background-color: var(--bg-neon); 
            color: var(--text-dark);
            font-family: 'Nunito', sans-serif;
        }
        
        .font-fun { font-family: 'Fredoka', sans-serif; }
        .text-theme { color: var(--text-dark); }
        .bg-theme-dark { background-color: var(--text-dark); }

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
            <a href="index.php" class="inline-block mb-6 px-4 py-2 bg-white rounded-full shadow-sm text-sm font-bold text-theme hover:bg-opacity-90 transition">
                ← Kembali ke Beranda
            </a>
            
            <div class="flex flex-col md:flex-row justify-center items-center gap-4 mb-3">
                <h1 class="text-4xl md:text-6xl font-black font-fun text-theme drop-shadow-sm">
                    Pilih Misi Kamu!
                </h1>

                <a href="konten-manager.php" class="group relative flex items-center gap-2 px-5 py-2 bg-[#0E5941] text-[#17FFB2] rounded-full text-sm font-bold shadow-lg hover:bg-white hover:text-[#0E5941] hover:border-[#0E5941] border-2 border-transparent transition-all duration-300 transform hover:scale-105 hover:-rotate-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <span>Bingung? Lihat Template</span>
                    
                    <span class="absolute -top-1 -right-1 flex h-3 w-3">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-500"></span>
                    </span>
                </a>
            </div>

            <p class="text-lg md:text-xl font-medium text-theme opacity-90">
                Klik salah satu kotak di bawah untuk melihat detail tantangan.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <?php if(empty($list_event)): ?>
                <div class="col-span-3 text-center py-10">
                    <p class="text-xl font-bold opacity-50">Belum ada event aktif.</p>
                    <a href="admin/login.php" class="text-blue-600 underline text-sm">Login Admin untuk tambah event</a>
                </div>
            <?php endif; ?>

            <?php foreach($list_event as $index => $row): ?>
            
            <div onclick="toggleModal('modal-<?= $row['id'] ?>')" 
                 class="card-box bg-white rounded-[2rem] p-6 flex flex-col items-center text-center shadow-lg relative overflow-hidden group border-4 border-transparent hover:border-[#0E5941]/10">
                
                <div class="absolute top-4 right-4 w-10 h-10 rounded-full bg-[#17FFB2] flex items-center justify-center font-bold text-theme shadow-inner">
                    #<?= $index + 1 ?>
                </div>

                <div class="w-24 h-24 mb-4 transform group-hover:scale-110 transition duration-300">
                    <img src="<?= $row['reward_img'] ?>" alt="Icon" class="w-full h-full object-contain">
                </div>

                <h3 class="text-2xl font-fun font-bold text-theme mb-2 leading-tight">
                    <?= htmlspecialchars($row['title']) ?>
                </h3>
                
                <span class="mt-auto inline-block text-sm font-bold border-2 border-[#0E5941] text-[#0E5941] px-4 py-1 rounded-full group-hover:bg-[#0E5941] group-hover:text-white transition">
                    Lihat Detail
                </span>
            </div>

            <div id="modal-<?= $row['id'] ?>" class="modal opacity-0 pointer-events-none fixed inset-0 z-50 flex items-center justify-center p-4">
                <div class="modal-overlay absolute inset-0 bg-[#0E5941] bg-opacity-80 backdrop-blur-sm" onclick="toggleModal('modal-<?= $row['id'] ?>')"></div>
                <div class="modal-content bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl relative overflow-hidden flex flex-col max-h-[90vh]">
                    
                    <div class="bg-[#17FFB2] p-6 flex justify-center items-center relative" 
                         style="background: linear-gradient(135deg, <?= $row['color_primary'] ?>, <?= $row['color_accent'] ?>);">
                        <button onclick="toggleModal('modal-<?= $row['id'] ?>')" class="absolute top-4 right-4 bg-white w-10 h-10 rounded-full flex items-center justify-center text-theme font-bold hover:bg-red-100 transition shadow-md z-10">✕</button>
                        <img src="<?= $row['reward_img'] ?>" alt="Detail" class="w-24 h-24 object-contain drop-shadow-xl animate-bounce">
                    </div>

                    <div class="p-8 pt-6 overflow-y-auto">
                        <h2 class="text-2xl font-fun font-black text-theme mb-2 text-center leading-tight">
                            <?= htmlspecialchars($row['title']) ?>
                        </h2>
                        
                        <div class="bg-green-50 rounded-xl p-3 mb-6 text-center border border-green-100">
                             <p class="text-sm text-theme font-bold">🎯 Misi: <?= htmlspecialchars($row['mission']) ?></p>
                        </div>

                        <div class="mb-6 text-left">
                            <h4 class="font-bold text-sm mb-2 text-gray-500 uppercase">Syarat & Ketentuan:</h4>
                            <ul class="list-disc pl-5 space-y-1 text-sm text-gray-700">
                                <?php 
                                    // Memecah teks syarat berdasarkan ENTER (Baris Baru)
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
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nama Kamu</label>
                                    <input type="text" id="nama-<?= $row['id'] ?>" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-100 focus:border-[#17FFB2] focus:bg-white outline-none transition font-bold text-theme" placeholder="Isi nama...">
                                </div>
                                <div class="mt-4">
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Nomor HP / WhatsApp</label>
                                      <input type="tel" id="hp-<?= $row['id'] ?>" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-100 focus:border-[#17FFB2] focus:bg-white outline-none transition font-bold text-theme" placeholder="Contoh: 081234567890">
                                      <p class="text-[10px] text-gray-400 mt-1 ml-1">*Wajib aktif WA untuk konfirmasi hadiah.</p>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Link Video TikTok/IG</label>
                                    <input type="url" id="link-<?= $row['id'] ?>" class="w-full px-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-100 focus:border-[#17FFB2] focus:bg-white outline-none transition text-sm" placeholder="https://vt.tiktok.com/...">
                                    <p class="text-[10px] text-gray-400 mt-1 ml-1">*Pastikan akun tidak di-private</p>
                                </div>

                                <button onclick="verifikasiVideo(<?= $row['id'] ?>)" class="w-full py-4 rounded-xl bg-[#0E5941] text-white font-fun font-bold text-lg shadow-lg hover:bg-opacity-90 transform active:scale-95 transition flex justify-center items-center gap-2 mt-2">
                                    <span>Verifikasi Video 🚀</span>
                                    <span id="loading-<?= $row['id'] ?>" class="hidden animate-spin">⏳</span>
                                </button>
                            </div>
                        </div>

                        <div id="fail-claim-<?= $row['id'] ?>" class="hidden text-center py-4">
                            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-3xl">😢</span>
                            </div>
                            <h3 class="text-lg font-black text-red-500 mb-1">Yah, Belum Lolos.</h3>
                            <p id="error-msg-<?= $row['id'] ?>" class="text-sm text-gray-600 mb-4 bg-gray-100 p-3 rounded-lg">Video tidak sesuai.</p>
                            <button onclick="resetForm(<?= $row['id'] ?>)" class="text-sm font-bold text-[#0E5941] underline hover:text-[#17FFB2]">Coba Masukkan Link Lain</button>
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
                modal.classList.remove('opacity-0', 'pointer-events-none'); modal.classList.add('open'); body.classList.add('modal-active');
            } else {
                modal.classList.remove('open'); setTimeout(() => { modal.classList.add('opacity-0', 'pointer-events-none'); }, 100); body.classList.remove('modal-active');
            }
        }

        document.onkeydown = function(evt) {
            evt = evt || window.event;
            if (evt.keyCode == 27) {
                document.querySelectorAll('.modal').forEach(modal => { modal.classList.remove('open'); modal.classList.add('opacity-0', 'pointer-events-none'); });
                document.body.classList.remove('modal-active');
            }
        };

       async function verifikasiVideo(id) {
        const inputNama = document.getElementById('nama-' + id).value;
        
        // --- TAMBAHAN BARU: AMBIL NO HP ---
        const inputHP = document.getElementById('hp-' + id).value; 
        
        // AMBIL SEMUA INPUT VIDEO
        const videoInputs = document.querySelectorAll(`.input-video-${id}`);
        let listLinks = [];
        let kosong = false;

        videoInputs.forEach(input => {
            if(input.value.trim() === "") { kosong = true; }
            listLinks.push(input.value.trim());
        });

        const btnVerifikasi = document.querySelector(`#form-claim-${id} button`);
        const loadingIcon = document.getElementById('loading-' + id);
        // ... variabel lain tetap sama ...

        // --- UPDATE VALIDASI: CEK HP JUGA ---
        if (!inputNama || !inputHP || kosong) {
            alert("Mohon lengkapi Nama, Nomor HP, dan SEMUA Link Video!");
            return;
        }

        // ... kode disable button & loading tetap sama ...

        try {
            // 1. KIRIM KE PYTHON (AI)
            // (Tidak perlu kirim No HP ke Python, karena AI tidak butuh)
            const response = await fetch('https://my-ai-api-production-a4c4.up.railway.app/cek-video', { 
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    urls: listLinks,
                    misi_id: id,
                    nama: inputNama
                })
            });

            // ... proses response Python tetap sama ...
            
            if (data.status === "VALID") {
                
                // 2. SIMPAN KE DATABASE PHP
                const combinedLinks = listLinks.join(', ');
                const judulMisi = document.querySelector(`#modal-${id} h2`).innerText;

                const saveResponse = await fetch('api-save-ticket.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        name: inputNama,
                        no_hp: inputHP, // <--- KIRIM NO HP KE SINI
                        mission: judulMisi,
                        video_hash: data.video_hash,
                        link: combinedLinks
                    })
                });

                // ... sisa kode ke bawah tetap sama ...
                    const saveResult = await saveResponse.json();

                    if(saveResult.status === 'success') {
                        const urlParams = new URLSearchParams({
                            code: saveResult.generated_code, 
                            name: inputNama,
                            mission: judulMisi
                        }).toString();
                        
                        window.location.href = 'detail-voucher.php?' + urlParams;
                    } else {
                        throw new Error("Gagal Simpan DB: " + saveResult.msg);
                    }

                } else {
                    loadingIcon.classList.add('hidden');
                    divForm.classList.add('hidden');
                    divFail.classList.remove('hidden');
                    textFail.innerText = data.alasan || "Video tidak memenuhi kriteria.";
                    
                    btnVerifikasi.disabled = false;
                    btnVerifikasi.classList.remove('opacity-50', 'cursor-not-allowed');
                }

            } catch (error) {
                console.error("Error:", error);
                alert("Terjadi Kesalahan:\n" + error.message);
                
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


