<?php
header('Content-Type: application/json');

// 1. INCLUDE KONEKSI DATABASE
// Gunakan __DIR__ agar path absolut dan tidak error
if (file_exists(__DIR__ . '/db/koneksi.php')) { 
    include __DIR__ . '/db/koneksi.php'; 
} elseif (file_exists(__DIR__ . '/koneksi.php')) { 
    include __DIR__ . '/koneksi.php'; 
} else { 
    echo json_encode(['status' => 'error', 'msg' => 'Koneksi DB hilang']); 
    exit; 
}

// 2. INCLUDE FUNGSI WA
// Pastikan file send_wa.php ada di folder yang sama
if (file_exists(__DIR__ . '/send_wa.php')) {
    include __DIR__ . '/send_wa.php';
}

// Pastikan variabel PDO tersedia
if (!isset($pdo) && isset($conn)) { $pdo = $conn; }

// 3. AMBIL DATA DARI INPUT JSON
$data = json_decode(file_get_contents("php://input"), true);

$nama = $data['name'] ?? 'Peserta';
$hp   = $data['no_hp'] ?? '';
$misi = $data['mission'] ?? 'Misi Umum';
$link = $data['link'] ?? '';
$hash = $data['video_hash'] ?? '';

try {
    // A. CEK KECURANGAN (ANTI RE-UPLOAD VIDEO)
    if (!empty($hash)) {
        $stmt = $pdo->prepare("SELECT id, nama_peserta FROM tickets WHERE video_hash = ?");
        $stmt->execute([$hash]);
        $pelaku = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($pelaku) {
            echo json_encode([
                'status' => 'error',
                'msg' => "Waduh! Video ini terdeteksi PLAGIAT. Konten yang sama persis sudah pernah dipakai oleh kak " . $pelaku['nama_peserta']
            ]);
            exit;
        }
    }

    // B. GENERATE KODE UNIK (6 Digit Angka)
    $kode = (string) rand(100000, 999999); 
    $check = $pdo->prepare("SELECT id FROM tickets WHERE kode_unik = ?");
    $check->execute([$kode]);
    
    // Loop sampai nemu kode yang belum ada di DB
    while($check->fetch()) { 
        $kode = (string) rand(100000, 999999); 
        $check->execute([$kode]); 
    }

    // C. SIMPAN DATA (INSERT)
    $sql = "INSERT INTO tickets (kode_unik, nama_peserta, no_hp, misi, video_link, video_hash, waktu_dibuat, status) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), 'unused')";
    
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$kode, $nama, $hp, $misi, $link, $hash])) {
        
        // --- SUKSES SIMPAN: KIRIM WA DISINI ---
        
        if (function_exists('kirimPesanFonnte') && !empty($hp)) {
            // Format Pesan WA
            $pesanWA = "*SELAMAT! MISI BERHASIL 🌲*\n\n";
            $pesanWA .= "Halo Kak *$nama*, video kamu keren banget dan lolos verifikasi AI! 🤖✨\n\n";
            $pesanWA .= "Ini Kode Voucher Makan Gratis kamu:\n";
            $pesanWA .= "👇👇👇\n\n";
            $pesanWA .= "*" . $kode . "*\n\n";
            $pesanWA .= "👆👆👆\n";
            $pesanWA .= "Tunjukkan chat ini ke panitia di Gate Jar'un untuk klaim hadiahmu.\n\n";
            $pesanWA .= "_Jangan lupa screenshot pesan ini!_ 😉\n";
            $pesanWA .= "~ Admin Bukit Jar'un";

            // Kirim
            kirimPesanFonnte($hp, $pesanWA);
        }

        // Response ke Web agar redirect ke halaman voucher
        echo json_encode(['status' => 'success', 'generated_code' => $kode]);

    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Gagal menyimpan data ke database.']);
    }

} catch (PDOException $e) { // <--- BARIS 97 (ERROR SEBELUMNYA DI SINI)
    // Error biasanya terjadi karena Kurung Kurawal "}" penutup TRY di atas hilang.
    // Di kode ini sudah saya pastikan ada.
    echo json_encode(['status' => 'error', 'msg' => 'Database Error: ' . $e->getMessage()]);
}
?>
