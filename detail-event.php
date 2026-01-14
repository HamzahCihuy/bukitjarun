<?php
// 1. KONEKSI DATABASE
include 'db/koneksi.php';

// 2. AMBIL DATA DARI DATABASE (Tabel 'events')
// Kita urutkan sesuai 'urutan' yang diatur di CMS
$stmt = $pdo->query("SELECT * FROM events ORDER BY urutan ASC");
$list_event = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
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
                                
                                <div id="container-links-<?= $row['id'] ?>" class="space-y-3">
                                    <?php 
                                        // Default 1 jika tidak ada settingan
                                        $limit = $row['video_limit'] ?? 1; 
                                        
                                        for($i = 1; $i <= $limit; $i++): 
                                    ?>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                                            Link Video TikTok/IG #<?= $i ?>
                                        </label>
                                        <input type="url" class="input-video-<?= $row['id'] ?> w-full px-4 py-3 rounded-xl bg-gray-50 border-2 border-gray-100 focus:border-[#17FFB2] focus:bg-white outline-none transition text-sm" placeholder="Paste link video ke-<?= $i ?> disini...">
                                    </div>
                                    <?php endfor; ?>
                                </div>

                                <p class="text-[10px] text-gray-400 ml-1">*Pastikan semua akun tidak di-private</p>

                                <button onclick="verifikasiVideo(<?= $row['id'] ?>)" class="w-full py-4 rounded-xl bg-[#0E5941] text-white font-fun font-bold text-lg shadow-lg hover:bg-opacity-90 transform active:scale-95 transition flex justify-center items-center gap-2 mt-2">
                                    <span>Verifikasi <?= $limit ?> Video 🚀</span>
                                    <span id="loading-<?= $row['id'] ?>" class="hidden animate-spin">⏳</span>
                                </button>
                            </div>
                        </div>

<script>
    // ... fungsi toggleModal dan onkeydown tetap sama ...

    async function verifikasiVideo(id) {
        const inputNama = document.getElementById('nama-' + id).value;
        
        // AMBIL SEMUA INPUT VIDEO BERDASARKAN CLASS
        const videoInputs = document.querySelectorAll(`.input-video-${id}`);
        let listLinks = [];
        let kosong = false;

        // Masukkan value input ke array
        videoInputs.forEach(input => {
            if(input.value.trim() === "") {
                kosong = true;
            }
            listLinks.push(input.value.trim());
        });

        const btnVerifikasi = document.querySelector(`#form-claim-${id} button`);
        const loadingIcon = document.getElementById('loading-' + id);
        const divFail = document.getElementById('fail-claim-' + id);
        const textFail = document.getElementById('error-msg-' + id);
        const divForm = document.getElementById('form-claim-' + id);

        if (!inputNama || kosong) {
            alert("Mohon lengkapi Nama dan SEMUA Link Video!");
            return;
        }

        btnVerifikasi.disabled = true;
        btnVerifikasi.classList.add('opacity-50', 'cursor-not-allowed');
        loadingIcon.classList.remove('hidden');

        try {
            // 1. KIRIM ARRAY LINK KE PYTHON
            const response = await fetch('https://my-ai-api-production-a4c4.up.railway.app/cek-video', { 
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    urls: listLinks, // KIRIM ARRAY 'urls', BUKAN 'url'
                    misi_id: id,
                    nama: inputNama
                    // prompt_ai akan diambil otomatis oleh Python dari DB (jika kamu implementasi fetch prompt di frontend seperti sebelumnya, tambahkan disini)
                })
            });

            const textPython = await response.text();
            let data;
            try {
                data = JSON.parse(textPython); 
            } catch (e) {
                throw new Error("SERVER AI ERROR: " + textPython);
            }

            if (!response.ok) throw new Error("Koneksi Gagal");
            
            if (data.status === "VALID") {
                
                // 2. SIMPAN KE DATABASE PHP
                // Karena linknya banyak, kita gabung jadi satu string dipisah koma
                const combinedLinks = listLinks.join(', ');
                const judulMisi = document.querySelector(`#modal-${id} h2`).innerText;

                const saveResponse = await fetch('api-save-ticket.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        name: inputNama,
                        mission: judulMisi,
                        video_hash: data.video_hash,
                        link: combinedLinks // Simpan semua link
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
                    throw new Error("Gagal Simpan DB: " + saveResult.msg);
                }

            } else {
                loadingIcon.classList.add('hidden');
                divForm.classList.add('hidden');
                divFail.classList.remove('hidden');
                textFail.innerText = data.alasan || "Salah satu video tidak memenuhi kriteria.";
                
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
    
    // ... fungsi resetForm tetap sama ...
</script>

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




