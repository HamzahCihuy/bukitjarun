<?php
// File: webhook.php
header('Content-Type: application/json');

// 1. INCLUDE KONEKSI & FUNGSI WA
// Gunakan __DIR__ agar path aman di Railway
include __DIR__ . '/db/koneksi.php';
include __DIR__ . '/send_wa.php';

// 2. TANGKAP DATA DARI FONNTE
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Jika diakses langsung dari browser, matikan
if (!$data) die("Webhook Service Active");

// 3. AMBIL VARIABEL UTAMA
$sender  = $data['sender'];  // Nomor HP Pengirim
$message = $data['message']; // Isi Pesan

// --- 🛡️ SECURITY: HANYA ADMIN YANG BOLEH INPUT ---
// Masukkan nomor HP kamu (Admin) di sini. Format: 628...
$admin_list = [
    '6282321181499', // Ganti dengan nomor WA kamu
    '628987654321'  // Admin cadangan
];

// Jika pengirim bukan admin, stop proses (Bot diam)
if (!in_array($sender, $admin_list)) {
    die("Unauthorized");
}
// ------------------------------------------------

// 4. LOGIKA PARSING PESAN "input:KODE"
// Regex: Menangkap kata setelah "input:" (case insensitive)
if (preg_match('/^input\s*:\s*([a-zA-Z0-9-]+)/i', $message, $matches)) {
    
    $kode_tiket = $matches[1]; // Contoh: 777777

    try {
        // A. Cek apakah tiket ada?
        $stmt = $pdo->prepare("SELECT * FROM tickets WHERE kode_unik = ?");
        $stmt->execute([$kode_tiket]);
        $tiket = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tiket) {
            // B. Cek Status Tiket
            if ($tiket['status'] == 'used' || $tiket['status'] == 'claimed') {
                $balasan = "⚠️ *GAGAL INPUT*\n\nKode: *$kode_tiket*\nNama: {$tiket['nama_peserta']}\nStatus: ❌ SUDAH DIPAKAI (USED).";
            } else {
                // C. Update Status jadi 'used'
                $update = $pdo->prepare("UPDATE tickets SET status = 'used', waktu_klaim = NOW() WHERE id = ?");
                
                if ($update->execute([$tiket['id']])) {
                    $balasan = "✅ *BERHASIL INPUT*\n\nKode: *$kode_tiket*\nNama: *{$tiket['nama_peserta']}*\nMisi: {$tiket['misi']}\n\nStatus tiket sekarang: **USED** 🎫";
                } else {
                    $balasan = "❌ *ERROR DATABASE*\nGagal update data.";
                }
            }
        } else {
            // Tiket Tidak Ditemukan
            $balasan = "❌ *KODE SALAH*\n\nKode *$kode_tiket* tidak ditemukan di sistem.";
        }

    } catch (PDOException $e) {
        $balasan = "❌ *SYSTEM ERROR*\n" . $e->getMessage();
    }

    // 5. KIRIM BALASAN KE ADMIN
    kirimPesanFonnte($sender, $balasan);
}

// Respon wajib ke Fonnte
echo json_encode(['status' => true]);
?>
