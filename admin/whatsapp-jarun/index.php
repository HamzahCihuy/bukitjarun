<?php
session_start();
// Pastikan Login Dulu (Wajib!)
if (!isset($_SESSION['admin_logged_in'])) {
    // Arahkan ke login.php (Diasumsikan ada di folder admin utama)
    // Mundur 1 langkah dari "whatsapp-jarun" ke "admin"
    header("Location: ../login.php"); 
    exit;
}

// PERBAIKAN PATH DIREKTORI:
// Dari: admin/whatsapp-jarun/index.php
// Ke:   db/koneksi.php
// Mundur 2 langkah (../../)
include '../../db/koneksi.php';
$message = "";

// PROSES SIMPAN TOKEN BARU
if (isset($_POST['simpan_token'])) {
    $token_baru = trim($_POST['token']);
    
    if (!empty($token_baru)) {
        try {
            // Update atau Insert jika belum ada
            $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES ('fonnte_token', ?) 
                                   ON DUPLICATE KEY UPDATE setting_value = ?");
            if ($stmt->execute([$token_baru, $token_baru])) {
                $message = "<div class='bg-green-100 text-green-700 p-4 rounded mb-4'>✅ Token berhasil diperbarui! Bot sudah ganti.</div>";
            }
        } catch (PDOException $e) {
            $message = "<div class='bg-red-100 text-red-700 p-4 rounded mb-4'>❌ Gagal: " . $e->getMessage() . "</div>";
        }
    }
}

// AMBIL TOKEN SAAT INI UNTUK DITAMPILKAN
$current_token = "";
try {
    $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = 'fonnte_token'");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) $current_token = $row['setting_value'];
} catch (Exception $e) {}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Admin Bot (Token)</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg border border-gray-200">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">🤖 Ganti Akun Bot</h1>
            <a href="index.php" class="text-sm text-blue-500 hover:underline">← Kembali</a>
        </div>

        <?= $message ?>

        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
            <p class="text-sm text-yellow-700">
                <b>Perhatian:</b> Token ini menentukan nomor mana yang mengirim pesan. 
                Dapatkan token baru di <a href="https://fonnte.com" target="_blank" class="underline font-bold">Fonnte.com</a>.
            </p>
        </div>

        <form method="POST">
            <label class="block text-gray-600 font-bold mb-2">Token Fonnte Saat Ini:</label>
            <div class="relative">
                <input type="text" name="token" value="<?= htmlspecialchars($current_token) ?>" required
                    class="w-full bg-gray-50 border border-gray-300 rounded-lg p-3 pr-10 focus:outline-none focus:border-blue-500 font-mono text-sm"
                    placeholder="Masukkan Token Panjang disini...">
                
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-400">
                    🔑
                </div>
            </div>

            <button type="submit" name="simpan_token" 
                class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition shadow-lg">
                💾 SIMPAN PERUBAHAN
            </button>
        </form>

        <div class="mt-6 text-center border-t pt-4">
            <p class="text-xs text-gray-400">Sistem Lomba Bukit Jar'un</p>
        </div>
    </div>

</body>
</html>
