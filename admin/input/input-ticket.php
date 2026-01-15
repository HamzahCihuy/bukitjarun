<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}
// 1. KONEKSI DATABASE
// Karena file ini ada di admin/input/input-ticket.php, kita perlu mundur 2 folder (../../)
if (file_exists('../../db/koneksi.php')) { include '../../db/koneksi.php'; }
elseif (file_exists('../../../db/koneksi.php')) { include '../../../db/koneksi.php'; }
else { die("Koneksi database tidak ditemukan. Cek path file."); }

$message = "";
$message_type = "";

// 2. PROSES FORM SUBMIT
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = trim($_POST['nama']);
    $hp   = trim($_POST['hp']);
    $misi = trim($_POST['misi']);
    $link = trim($_POST['link']); // Opsional

    if (empty($nama) || empty($hp)) {
        $message = "Nama dan No HP wajib diisi!";
        $message_type = "bg-red-100 text-red-700 border-red-400";
    } else {
        try {
            // A. Generate 6 Angka Acak
            $kode = (string) rand(100000, 999999);
            
            // B. Cek Unik (Agar tidak kembar dengan tiket lain)
            $cekStmt = $pdo->prepare("SELECT id FROM tickets WHERE kode_unik = ?");
            $cekStmt->execute([$kode]);
            
            // Jika kode sudah ada, generate ulang sampai unik
            while($cekStmt->fetch()) {
                $kode = (string) rand(100000, 999999);
                $cekStmt->execute([$kode]);
            }

            // C. Simpan ke Database
            // video_hash diisi 'MANUAL' untuk menandakan ini inputan admin
            $sql = "INSERT INTO tickets (kode_unik, nama_peserta, no_hp, misi, video_link, video_hash, waktu_dibuat) 
                    VALUES (?, ?, ?, ?, ?, 'MANUAL', NOW())";
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute([$kode, $nama, $hp, $misi, $link])) {
                $message = "✅ Tiket Berhasil! Kode: <span class='text-2xl font-black'> " . $kode . "</span>";
                $message_type = "bg-green-100 text-green-700 border-green-400";
                
                // Reset form visual (optional via JS later)
            } else {
                $message = "Gagal menyimpan data.";
                $message_type = "bg-red-100 text-red-700 border-red-400";
            }

        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
            $message_type = "bg-red-100 text-red-700 border-red-400";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Tiket Manual - Admin Jar'un</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Quicksand', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800">

    <nav class="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center sticky top-0 z-50 shadow-sm">
        <div class="font-black text-xl text-slate-800 tracking-tight">
            ADMIN <span class="text-pink-500">JAR'UN</span>
        </div>
        <a href="../../index.php" class="text-sm font-bold text-slate-500 hover:text-pink-500 transition">
            ← Kembali ke Dashboard
        </a>
    </nav>

    <div class="container mx-auto px-4 py-10 max-w-2xl">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900">Input Tiket Manual</h1>
            <p class="text-slate-500">Buat tiket 6 digit untuk peserta offline / manual.</p>
        </div>

        <?php if($message): ?>
        <div class="border px-6 py-4 rounded-xl mb-6 relative <?= $message_type ?> shadow-sm" role="alert">
            <span class="block sm:inline"><?= $message ?></span>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-8">
            <form method="POST" action="">
                
                <div class="mb-5">
                    <label class="block text-slate-700 text-sm font-bold mb-2 uppercase tracking-wide">Nama Peserta</label>
                    <input type="text" name="nama" required 
                           class="w-full bg-slate-50 text-slate-900 border border-slate-300 rounded-xl py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-pink-500 transition font-bold"
                           placeholder="Contoh: Budi Santoso">
                </div>

                <div class="mb-5">
                    <label class="block text-slate-700 text-sm font-bold mb-2 uppercase tracking-wide">WhatsApp / No HP</label>
                    <input type="text" name="hp" required 
                           class="w-full bg-slate-50 text-slate-900 border border-slate-300 rounded-xl py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-pink-500 transition font-bold"
                           placeholder="0812...">
                </div>

                <div class="mb-5">
                    <label class="block text-slate-700 text-sm font-bold mb-2 uppercase tracking-wide">Misi / Event</label>
                    <div class="relative">
                        <select name="misi" class="w-full bg-slate-50 text-slate-900 border border-slate-300 rounded-xl py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-pink-500 transition appearance-none font-bold">
                            <option value="Manual Input - VIP">Manual Input - VIP</option>
                            <option value="Manual Input - Reguler">Manual Input - Reguler</option>
                            <option value="Giveaway Offline">Giveaway Offline</option>
                            <?php
                                // Ambil list misi dari database jika ada
                                try {
                                    $qMisi = $pdo->query("SELECT title FROM events ORDER BY urutan ASC");
                                    while($m = $qMisi->fetch()) {
                                        echo "<option value='".$m['title']."'>Event: ".$m['title']."</option>";
                                    }
                                } catch(Exception $e) {}
                            ?>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-slate-700 text-sm font-bold mb-2 uppercase tracking-wide">Link Video (Opsional)</label>
                    <input type="text" name="link" 
                           class="w-full bg-slate-50 text-slate-900 border border-slate-300 rounded-xl py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-pink-500 transition"
                           placeholder="https://tiktok.com/...">
                    <p class="text-xs text-slate-400 mt-1">*Biarkan kosong jika peserta offline</p>
                </div>

                <button type="submit" class="w-full bg-[#0E5941] hover:bg-[#093d2c] text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition transform active:scale-95 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Tiket Sekarang
                </button>

            </form>
        </div>

        <div class="mt-8 text-center text-xs text-slate-400">
            &copy; <?= date('Y') ?> Admin Panel Bukit Jar'un
        </div>

    </div>

</body>
</html>
