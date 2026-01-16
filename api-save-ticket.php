<?php
header('Content-Type: application/json');

// INCLUDE KONEKSI & FUNGSI WA
if (file_exists('db/koneksi.php')) { include 'db/koneksi.php'; } 
elseif (file_exists('koneksi.php')) { include 'koneksi.php'; } 
else { echo json_encode(['status' => 'error', 'msg' => 'Koneksi DB hilang']); exit; }

// INCLUDE FILE WA YANG BARU DIBUAT
include 'send_wa.php';

if (!isset($pdo) && isset($conn)) { $pdo = $conn; }

$data = json_decode(file_get_contents("php://input"), true);

$nama = $data['name'] ?? 'Peserta';
$hp   = $data['no_hp'] ?? '';
$misi = $data['mission'] ?? 'Misi Umum';
$link = $data['link'] ?? '';
$hash = $data['video_hash'] ?? '';

try {
    // 1. CEK KECURANGAN (ANTI RE-UPLOAD)
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

    // 2. GENERATE KODE UNIK (6 Digit)
    $kode = (string) rand(100000, 999999); 
    $check = $pdo->prepare("SELECT id FROM tickets WHERE kode_unik = ?");
    $check->execute([$kode]);
    while($check->fetch()) { 
        $kode = (string) rand(100000, 999999); 
        $check->execute([$kode]); 
    }

    // 3. SIMPAN DATA (INSERT)
    $sql = "INSERT INTO tickets (kode_unik, nama_peserta, no_hp, misi, video_link, video_hash, waktu_dibuat) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$kode, $nama, $hp, $misi, $link, $hash])) {
        
        // --- MODIFIKASI FONNTE: KIRIM NOTIF WA ---
        
        // Format Pesan yang Menarik
        $pesanWA = "*SELAMAT! MISI BERHASIL 🌲*\n\n";
        $pesanWA .= "Halo Kak *$nama*, video kamu keren banget dan lolos verifikasi AI! 🤖✨\n\n";
        $pesanWA .= "Ini Kode Voucher Makan Gratis kamu:\n";
        $pesanWA .= "👇👇👇\n\n";
        $pesanWA .= "*" . $kode . "*\n\n";
        $pesanWA .= "👆👆👆\n";
        $pesanWA .= "Tunjukkan chat ini ke panitia di Gate Jar'un untuk klaim hadiahmu.\n\n";
        $pesanWA .= "_Jangan lupa screenshot jaga-jaga kalau sinyal hilang!_ 😉\n";
        $pesanWA .= "~ Admin Bukit Jar'un";

        // Eksekusi Kirim (Target No HP Peserta)
        // Fungsi ini akan otomatis mengubah 08xx jadi 628xx
        kirimPesanFonnte($hp, $pesanWA);

        // -----------------------------------------

        echo json_encode(['status' => 'success', 'generated_code' => $kode]);

    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Gagal menyimpan data ke database.']);
    }

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'msg' => 'Database Error: ' . $e->getMessage()]);
}
?>
