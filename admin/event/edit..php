<?php
// --- AKTIFKAN LAPORAN ERROR PHP ---
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

echo "<div style='font-family:monospace; background:#eee; padding:20px; border:1px solid #999;'>";
echo "<h2 style='color:red;'>MODE DEBUGGING AKTIF</h2>";

// 1. CEK FILE KONEKSI
echo "1. Mengecek file koneksi... ";
if (file_exists('../../db/koneksi.php')) {
    include '../../db/koneksi.php';
    echo "<span style='color:green;'>File Ditemukan.</span><br>";
} else {
    die("<span style='color:red;'>ERROR FATAL: File ../../db/koneksi.php TIDAK ADA!</span>");
}

// 2. CEK KONEKSI DATABASE
echo "2. Mengecek status koneksi database (\$pdo)... ";
if (isset($pdo)) {
    echo "<span style='color:green;'>Terhubung.</span><br>";
} else {
    die("<span style='color:red;'>ERROR: Variabel \$pdo tidak ada. Cek isi file koneksi.php!</span>");
}

// 3. CEK URL PARAMETER
echo "3. Mengecek ID di URL... ";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    echo "<span style='color:green;'>Ada. ID = <b>$id</b></span><br>";
} else {
    die("<span style='color:red;'>ERROR: ID tidak ditemukan di URL. Kamu membuka file ini langsung tanpa klik edit?</span>");
}

// 4. CEK DATA DI DATABASE
echo "4. Mencari data di tabel 'events' dengan ID $id... <br>";
try {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "&nbsp;&nbsp;&nbsp;Hasil Query: ";
    if ($data) {
        echo "<span style='color:green;'>DATA DITEMUKAN!</span><br>";
        echo "&nbsp;&nbsp;&nbsp;Judul Event: <b>" . htmlspecialchars($data['title']) . "</b><br>";
    } else {
        echo "<span style='color:red;'>DATA KOSONG (NULL)</span><br>";
        die("<h3 style='color:red;'>KESIMPULAN: ID $id tidak ada di database. Sistem melempar kembali ke index.</h3>");
    }
} catch (Exception $e) {
    die("<span style='color:red;'>ERROR QUERY: " . $e->getMessage() . "</span>");
}

echo "<hr><h3 style='color:green;'>KESIMPULAN: Semua Cek Lolos!</h3>";
echo "Jika kamu melihat tulisan ini, berarti LOGIKA PHP BENAR.<br>";
echo "Masalah redirect ke root kemungkinan besar karena <b>CACHE BROWSER</b>.<br>";
echo "Silakan scroll ke bawah untuk melihat form edit.";
echo "</div>";

// --- SISA KODE ASLI (FORM) ---
// Kita matikan proses UPDATE dulu biar fokus cek tampilan
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>DEBUG Edit Event</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-10">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-3xl border-4 border-green-500">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">✏️ Edit Event: <?= htmlspecialchars($data['title']) ?></h2>
        
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-2 bg-yellow-100 p-4 rounded text-center font-bold">
                FORM INI MUNCUL BERARTI DATA ADA.
            </div>
            
             <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-1">Judul Event</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($data['title']) ?>" class="w-full border p-2 rounded">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
