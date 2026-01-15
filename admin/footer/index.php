<?php
session_start();

// Cek Login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../login.php");
    exit;
}

// Koneksi Database
if (file_exists('../../db/koneksi.php')) { include '../../db/koneksi.php'; }
elseif (file_exists('../../../db/koneksi.php')) { include '../../../db/koneksi.php'; }
else { die("Koneksi database tidak ditemukan."); }

$msg = "";

// PROSES UPDATE
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $desc = $_POST['description'];
    $hours = $_POST['opening_hours'];
    $addr = $_POST['address'];
    $wa = $_POST['whatsapp'];
    $email = $_POST['email'];
    $ig = $_POST['link_instagram'];
    $tt = $_POST['link_tiktok'];
    $yt = $_POST['link_youtube'];

    try {
        $sql = "UPDATE footer_settings SET 
                description=?, opening_hours=?, address=?, whatsapp=?, email=?, 
                link_instagram=?, link_tiktok=?, link_youtube=? 
                WHERE id=1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$desc, $hours, $addr, $wa, $email, $ig, $tt, $yt]);
        $msg = "✅ Pengaturan Footer Berhasil Disimpan!";
    } catch (PDOException $e) {
        $msg = "❌ Gagal menyimpan: " . $e->getMessage();
    }
}

// AMBIL DATA SAAT INI
$data = $pdo->query("SELECT * FROM footer_settings WHERE id=1")->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Footer - Admin Jar'un</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

    <div class="container mx-auto px-4 py-10 max-w-4xl">

        <div class="mb-8 flex items-center gap-3">
            <div class="w-12 h-12 bg-slate-900 rounded-full flex items-center justify-center text-white text-xl">
                <i class="fas fa-shoe-prints"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Pengaturan Footer</h1>
                <p class="text-slate-500 text-sm">Ubah informasi kontak, alamat, dan sosial media.</p>
            </div>
        </div>

        <?php if($msg): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 font-bold text-center">
            <?= $msg ?>
        </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="font-bold text-lg text-slate-800 mb-4 border-b pb-2">🏢 Info Umum</h3>
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-slate-600 text-xs font-bold uppercase mb-2">Deskripsi Singkat</label>
                        <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:border-pink-500 outline-none transition"><?= htmlspecialchars($data['description']) ?></textarea>
                    </div>
                    <div>
                        <label class="block text-slate-600 text-xs font-bold uppercase mb-2">Jam Operasional</label>
                        <input type="text" name="opening_hours" value="<?= htmlspecialchars($data['opening_hours']) ?>" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:border-pink-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-slate-600 text-xs font-bold uppercase mb-2">Alamat Lengkap</label>
                        <textarea name="address" rows="2" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:border-pink-500 outline-none transition"><?= htmlspecialchars($data['address']) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="font-bold text-lg text-slate-800 mb-4 border-b pb-2">📞 Kontak</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-slate-600 text-xs font-bold uppercase mb-2">WhatsApp (Format: 628...)</label>
                        <input type="text" name="whatsapp" value="<?= htmlspecialchars($data['whatsapp']) ?>" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:border-pink-500 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-slate-600 text-xs font-bold uppercase mb-2">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:border-pink-500 outline-none transition">
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="font-bold text-lg text-slate-800 mb-4 border-b pb-2">🌐 Sosial Media (Link)</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <i class="fab fa-instagram text-2xl text-pink-600 w-8"></i>
                        <input type="text" name="link_instagram" value="<?= htmlspecialchars($data['link_instagram']) ?>" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:border-pink-500 outline-none transition" placeholder="https://instagram.com/...">
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fab fa-tiktok text-2xl text-black w-8"></i>
                        <input type="text" name="link_tiktok" value="<?= htmlspecialchars($data['link_tiktok']) ?>" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:border-pink-500 outline-none transition" placeholder="https://tiktok.com/...">
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fab fa-youtube text-2xl text-red-600 w-8"></i>
                        <input type="text" name="link_youtube" value="<?= htmlspecialchars($data['link_youtube']) ?>" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-300 focus:border-pink-500 outline-none transition" placeholder="https://youtube.com/...">
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#0E5941] text-white font-bold py-4 rounded-xl shadow-lg hover:bg-[#093d2c] active:scale-95 transition flex justify-center items-center gap-2 text-lg">
                <i class="fas fa-save"></i> Simpan Perubahan
            </button>

        </form>
    </div>

</body>
</html>
