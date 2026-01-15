<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: login.php");
    exit;
}
// 1. KONEKSI DATABASE
// Sesuaikan path ini dengan struktur folder kamu. 
// Jika admin/menfess/index.php, berarti mundur 2 langkah ke root (../../)
if (file_exists('../../db/koneksi.php')) { include '../../db/koneksi.php'; }
elseif (file_exists('../db/koneksi.php')) { include '../db/koneksi.php'; }
else { die("Gagal memuat koneksi database."); }

// 2. PROSES HAPUS PESAN
if (isset($_POST['hapus_id'])) {
    $id = $_POST['hapus_id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM menfess WHERE id = ?");
        $stmt->execute([$id]);
        // Refresh halaman agar data hilang
        header("Location: index.php?msg=deleted");
        exit;
    } catch (Exception $e) {
        $error = "Gagal menghapus: " . $e->getMessage();
    }
}

// 3. AMBIL DATA MENFESS (Terbaru di atas)
$stmt = $pdo->query("SELECT * FROM menfess ORDER BY waktu_dibuat DESC");
$list_menfess = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menfess - Bukit Jar'un</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-100 text-slate-800">

    <nav class="bg-white border-b border-slate-200 px-6 py-4 flex justify-between items-center sticky top-0 z-50">
        <div class="font-black text-xl text-slate-800 tracking-tight">
            ADMIN <span class="text-pink-500">JAR'UN</span>
        </div>
        <a href="../../index.php" target="_blank" class="text-sm font-bold text-slate-500 hover:text-pink-500 transition">
            Lihat Web Utama ↗
        </a>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-6xl">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Manajemen Menfess</h1>
                <p class="text-slate-500 text-sm">Total <?= count($list_menfess) ?> pesan masuk.</p>
            </div>
            
            <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div id="alert" class="bg-green-100 text-green-700 px-4 py-2 rounded-lg text-sm font-bold flex items-center shadow-sm animate-bounce">
                ✅ Pesan berhasil dihapus!
            </div>
            <script>setTimeout(() => document.getElementById('alert').style.display = 'none', 3000);</script>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider border-b border-slate-200">
                            <th class="p-4 font-bold w-16 text-center">ID</th>
                            <th class="p-4 font-bold w-40">Waktu</th>
                            <th class="p-4 font-bold w-48">Pengirim</th>
                            <th class="p-4 font-bold">Isi Pesan</th>
                            <th class="p-4 font-bold w-32 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if(empty($list_menfess)): ?>
                            <tr>
                                <td colspan="5" class="p-8 text-center text-slate-400 italic">Belum ada menfess masuk.</td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach($list_menfess as $row): ?>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 text-center font-mono text-xs text-slate-400">
                                #<?= $row['id'] ?>
                            </td>

                            <td class="p-4 text-sm text-slate-600">
                                <div class="font-bold"><?= date('d M Y', strtotime($row['waktu_dibuat'])) ?></div>
                                <div class="text-xs text-slate-400"><?= date('H:i', strtotime($row['waktu_dibuat'])) ?> WIB</div>
                            </td>

                            <td class="p-4">
                                <div class="text-sm font-bold text-slate-800"><?= htmlspecialchars($row['pengirim']) ?></div>
                            </td>

                            <td class="p-4">
                                <div class="<?= $row['warna'] ?> p-3 rounded-lg border border-black/5 text-slate-800 text-sm leading-relaxed max-w-lg shadow-sm">
                                    "<?= htmlspecialchars($row['pesan']) ?>"
                                </div>
                            </td>

                            <td class="p-4 text-center">
                                <form method="POST" onsubmit="return confirm('Yakin mau hapus pesan ini selamanya?');">
                                    <input type="hidden" name="hapus_id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="bg-white border border-red-200 text-red-500 p-2 rounded-lg hover:bg-red-50 hover:border-red-300 transition group" title="Hapus Pesan">
                                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-8 text-center text-xs text-slate-400">
            &copy; <?= date('Y') ?> Admin Panel Bukit Jar'un
        </div>

    </div>

</body>
</html>
