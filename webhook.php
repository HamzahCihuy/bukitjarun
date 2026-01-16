<?php
// webhook.php - DEBUG VERSION
header('Content-Type: application/json');

// Gunakan __DIR__ agar path pasti benar
include __DIR__ . '/db/koneksi.php';
include __DIR__ . '/send_wa.php';

// Ambil Data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// 1. CEK KONEKSI WEBHOOK
if (!$data) { 
    echo "Webhook Active (Browser Mode)";
    exit; 
}

// 2. LOG DATA MENTAH DARI FONNTE (Cek Railway Logs!)
// Ini akan mencetak nomor pengirim & pesan ke layar hitam Railway
error_log("📩 PESAN MASUK DARI: " . $data['sender']);
error_log("💬 ISI PESAN: " . $data['message']);

$sender  = $data['sender'];
$message = $data['message'];

// 3. LOGIKA INPUT
if (preg_match('/^input\s*:\s*([a-zA-Z0-9-]+)/i', $message, $matches)) {
    
    $kode_tiket = $matches[1];
    error_log("🔍 MENCARI TIKET: " . $kode_tiket);

    try {
        $stmt = $pdo->prepare("SELECT * FROM tickets WHERE kode_unik = ?");
        $stmt->execute([$kode_tiket]);
        $tiket = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tiket) {
            error_log("✅ TIKET DITEMUKAN: " . $tiket['nama_peserta']);
            
            // Update Status
            $update = $pdo->prepare("UPDATE tickets SET status = 'used', waktu_klaim = NOW() WHERE id = ?");
            if ($update->execute([$tiket['id']])) {
                $balasan = "✅ Sukses! Tiket *$kode_tiket* ({$tiket['nama_peserta']}) sudah di-USED.";
            } else {
                $balasan = "❌ Error Database saat update.";
            }
        } else {
            error_log("❌ TIKET TIDAK ADA DI DB");
            $balasan = "❌ Kode *$kode_tiket* tidak ditemukan.";
        }

    } catch (PDOException $e) {
        error_log("🔥 ERROR SQL: " . $e->getMessage());
        $balasan = "Error System: " . $e->getMessage();
    }

    // Kirim Balasan
    error_log("📤 MENGIRIM BALASAN KE: " . $sender);
    kirimPesanFonnte($sender, $balasan);

} else {
    error_log("⚠️ FORMAT PESAN TIDAK COCOK (Bukan 'input:xxx')");
}

echo json_encode(['status' => true]);
?>
