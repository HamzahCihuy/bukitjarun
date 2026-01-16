<?php
// webhook.php
header('Content-Type: application/json');

// 1. INCLUDE KONEKSI & FUNGSI WA
// Pastikan path ini benar (sejajar dengan file ini)
include 'db/koneksi.php';
include 'send_wa.php';

// 2. TANGKAP DATA JSON DARI FONNTE
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Jika tidak ada data, stop (mencegah akses langsung dari browser)
if (!$data) { die("Webhook Active"); }

// 3. AMBIL VARIABEL PENTING
$sender  = $data['sender'];  // Nomor HP Pengirim (Admin)
$message = $data['message']; // Isi Pesan (contoh: input:123456)

// 4. LOGIKA PARSING PESAN
// Cek apakah pesan diawali dengan kata "input:" (case insensitive)
if (preg_match('/^input\s*:\s*([a-zA-Z0-9-]+)/i', $message, $matches)) {
    
    $kode_tiket = $matches[1]; // Mengambil angka setelah titik dua (882857)

    try {
        // A. Cek keberadaan tiket
        $stmt = $pdo->prepare("SELECT * FROM tickets WHERE kode_unik = ?");
        $stmt->execute([$kode_tiket]);
        $tiket = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tiket) {
            // Tiket Ditemukan, Cek Status
            if ($tiket['status'] == 'used' || $tiket['status'] == 'claimed') {
                $balasan = "⚠️ *GAGAL INPUT*\n\nKode: *$kode_tiket*\nMilik: {$tiket['nama_peserta']}\nStatus: SUDAH DIPAKAI SEBELUMNYA.";
            } else {
                // B. Update Status jadi 'used'
                $update = $pdo->prepare("UPDATE tickets SET status = 'used', waktu_klaim = NOW() WHERE id = ?");
                
                if ($update->execute([$tiket['id']])) {
                    $balasan = "✅ *BERHASIL INPUT*\n\nKode: *$kode_tiket*\nMilik: *{$tiket['nama_peserta']}*\nMisi: {$tiket['misi']}\n\nStatus berhasil diubah menjadi USED.";
                } else {
                    $balasan = "❌ *ERROR DATABASE*\nGagal mengupdate status tiket.";
                }
            }
        } else {
            // Tiket Tidak Ditemukan
            $balasan = "❌ *KODE TIDAK DITEMUKAN*\n\nKode *$kode_tiket* tidak ada di database sistem.";
        }

    } catch (PDOException $e) {
        $balasan = "❌ *SYSTEM ERROR*\n" . $e->getMessage();
    }

    // 5. KIRIM BALASAN KE ADMIN (PENGIRIM)
    kirimPesanFonnte($sender, $balasan);
}

// Respon ke Fonnte (Wajib ada biar Fonnte tau pesan diterima)
echo json_encode(['status' => true]);
?>
