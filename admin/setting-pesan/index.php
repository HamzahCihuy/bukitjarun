<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

include '../db/koneksi.php';

$message = "";

// PROSES SIMPAN
if (isset($_POST['simpan_template'])) {
    $template_baru = $_POST['template_wa'];
    
    try {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES ('wa_template_success', ?) 
                               ON DUPLICATE KEY UPDATE setting_value = ?");
        if ($stmt->execute([$template_baru, $template_baru])) {
            $message = "<div class='bg-green-100 text-green-700 p-4 rounded mb-4'>✅ Template pesan berhasil disimpan!</div>";
        }
    } catch (PDOException $e) {
        $message = "<div class='bg-red-100 text-red-700 p-4 rounded mb-4'>❌ Gagal: " . $e->getMessage() . "</div>";
    }
}

// AMBIL TEMPLATE SAAT INI
$current_template = "";
try {
    $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = 'wa_template_success'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) $current_template = $row['setting_value'];
} catch (Exception $e) {}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting Pesan WA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-4 flex justify-center text-sm md:text-base">

    <div class="bg-white p-6 md:p-8 rounded-xl shadow-lg w-full max-w-2xl border border-gray-200">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">💬 Format Pesan WA</h1>
            <a href="index.php" class="text-blue-500 hover:underline">← Kembali</a>
        </div>

        <?= $message ?>

        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
            <h3 class="font-bold text-blue-700 mb-2">Variabel Otomatis (Shortcode)</h3>
            <p class="text-blue-600 mb-2">Gunakan kode di bawah ini, sistem akan otomatis menggantinya dengan data peserta:</p>
            <ul class="list-disc pl-5 space-y-1 text-gray-700 font-mono text-xs md:text-sm">
                <li><b>{nama}</b> = Nama Peserta (Contoh: Budi)</li>
                <li><b>{kode}</b> = Kode Voucher (Contoh: 123456)</li>
                <li><b>{misi}</b> = Misi yang dipilih</li>
                <li><b>{link}</b> = Link Video TikTok</li>
                <li><b>\n</b> atau <b>Enter</b> = Baris Baru</li>
            </ul>
        </div>

        <form method="POST">
            <label class="block text-gray-700 font-bold mb-2">Template Pesan Sukses:</label>
            <textarea name="template_wa" rows="10" required
                class="w-full bg-gray-50 border border-gray-300 rounded-lg p-4 focus:ring-2 focus:ring-green-500 focus:border-transparent font-mono text-sm leading-relaxed"
                placeholder="Tulis pesan disini..."><?= htmlspecialchars($current_template) ?></textarea>
            
            <p class="text-xs text-gray-400 mt-2 text-right">Mendukung format WA: *Tebal*, _Miring_, ~Coret~</p>

            <button type="submit" name="simpan_template" 
                class="mt-6 w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-lg transition shadow-lg flex justify-center items-center gap-2">
                💾 SIMPAN TEMPLATE
            </button>
        </form>
    </div>

</body>
</html>
