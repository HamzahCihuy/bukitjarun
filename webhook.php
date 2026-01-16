<?php
// webhook.php - ULTIMATE FIX VERSION

// 1. IZINKAN AKSES (Bypass blokir CORS/Browser)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");

// Tangani pre-flight request (jika ada)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 2. INCLUDE FILE PENTING
// Gunakan try-catch agar jika file hilang, error tercatat di log
try {
    require_once __DIR__ . '/db/koneksi.php';
    require_once __DIR__ . '/send_wa.php';
} catch (Throwable $e) {
    error_log("🔥 FATAL ERROR: Gagal include file! " . $e->getMessage());
    http_response_code(500);
    exit;
}

// 3. AMBIL RAW DATA (DATA MENTAH)
$raw_input = file_get_contents('php://input');

// --- LOGGING UTAMA (DI SINI KUNCINYA) ---
// Kita log apapun yang masuk, mau itu kosong, error, atau json rusak.
if (empty($raw_input)) {
    error_log("⚠️ WEBHOOK DIPANGGIL TAPI KOSONG (Mungkin akses via Browser?)");
    echo json_encode(["status" => "active_browser_mode"]);
    exit;
} else {
    error_log("📥 RAW DATA MASUK: " . $raw_input);
}
// ----------------------------------------

$data = json_decode($raw_input, true);

// Pastikan decoding JSON sukses
if (json_last_error() !== JSON_ERROR_NONE) {
    error_log("❌ JSON ERROR: Data tidak bisa dibaca. Raw: " . $raw_input);
    exit;
}

// Ambil variabel
$sender  = $data['sender'] ?? '';
$message = $data['message'] ?? '';
$is_group = isset($data['name']) && $data['name'] != ''; // Deteksi grup sederhana

// 4. KEAMANAN: FILTER HANYA ADMIN YANG BOLEH INPUT
// Masukkan nomor Admin (format 628...)
$admin_list = ['6282321181499', '628123456789']; // GANTI/TAMBAH NOMOR KAMU DISINI

if (!in_array($sender, $admin_list)) {
    error_log("⛔ AKSES DITOLAK: Nomor $sender mencoba akses webhook.");
    // Jangan balas apa-apa agar bot tidak spam ke orang asing
    exit; 
}

// 5. LOGIKA INPUT VOUCHER
if (preg_match('/^input\s*:\s*([a-zA-Z0-9-]+)/i', $message, $matches)) {
    
    $kode_tiket = trim($matches[1]); // Hilangkan spasi tidak sengaja
    error_log("🔍 ADMIN ($sender) MENCARI TIKET: " . $kode_tiket);

    try {
        // Cek Tiket
        $stmt = $pdo->prepare("SELECT * FROM tickets WHERE kode_unik = ?");
        $stmt->execute([$kode_tiket]);
        $tiket = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tiket) {
            // Cek apakah sudah used?
            if ($tiket['status'] == 'used' || $tiket['status'] == 'claimed') {
                 $balasan = "⚠️ *GAGAL INPUT*\n\nKode: *$kode_tiket*\nMilik: {$tiket['nama_peserta']}\n\nStatus: SUDAH DIPAKAI (USED).";
            } else {
                // Update jadi USED
                $update = $pdo->prepare("UPDATE tickets SET status = 'used', waktu_klaim = NOW() WHERE id = ?");
                if ($update->execute([$tiket['id']])) {
                    $balasan = "✅ *BERHASIL INPUT*\n\nKode: *$kode_tiket*\nNama: *{$tiket['nama_peserta']}*\nMisi: {$tiket['misi']}\n\nStatus sekarang: **USED** 🔒";
                } else {
                    $balasan = "❌ Error Database saat menyimpan.";
                }
            }
        } else {
            $balasan = "❌ Kode *$kode_tiket* TIDAK DITEMUKAN di database.";
        }

    } catch (PDOException $e) {
        error_log("🔥 SQL ERROR: " . $e->getMessage());
        $balasan = "System Error: " . $e->getMessage();
    }

    // Kirim Balasan ke Admin
    kirimPesanFonnte($sender, $balasan);

} else {
    // Jika admin chat biasa (bukan format input:...), abaikan saja
    // atau log untuk debug
    // error_log("ℹ️ Admin chat biasa: $message");
}

// Respon 200 OK ke Fonnte
echo json_encode(['status' => true]);
?>
