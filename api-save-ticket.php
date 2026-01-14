<?php
header('Content-Type: application/json');

// 1. INCLUDE KONEKSI (Pastikan file ini isinya koneksi PDO)
if (file_exists('db/koneksi.php')) { include 'db/koneksi.php'; } 
elseif (file_exists('koneksi.php')) { include 'koneksi.php'; } 
else { echo json_encode(['status' => 'error', 'msg' => 'Koneksi DB hilang']); exit; }

// Pastikan variabel koneksi bernama $pdo. Jika di file koneksi namanya $conn, kita alias-kan.
if (!isset($pdo) && isset($conn)) { $pdo = $conn; }

// Terima Data JSON
$data = json_decode(file_get_contents("php://input"), true);

// 2. AMBIL DATA (TIDAK PERLU REAL_ESCAPE_STRING DI PDO)
// PDO menggunakan "Prepared Statements" yang otomatis aman dari SQL Injection.
$nama = $data['name'] ?? 'Peserta';
$hp   = $data['no_hp'] ?? '';
$misi = $data['mission'] ?? 'Misi Umum';
$link = $data['link'] ?? '';
$hash = $data['video_hash'] ?? '';

try {
    // 3. CEK KECURANGAN KONTEN (ANTI RE-UPLOAD)
    if (!empty($hash)) {
        // Gunakan Prepared Statement untuk SELECT
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

    // 4. GENERATE KODE UNIK
    $kode = "JARUN-" . strtoupper(bin2hex(random_bytes(3)));

    // 5. SIMPAN DATA (INSERT)
    // Gunakan placeholder (?) untuk keamanan maksimal
    $sql = "INSERT INTO tickets (kode_unik, nama_peserta, no_hp, misi, video_link, video_hash, waktu_dibuat) 
            VALUES (?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $pdo->prepare($sql);
    
    // Eksekusi query dengan mengirim data array urut sesuai tanda tanya (?)
    if ($stmt->execute([$kode, $nama, $hp, $misi, $link, $hash])) {
        echo json_encode(['status' => 'success', 'generated_code' => $kode]);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Gagal menyimpan data ke database.']);
    }

} catch (PDOException $e) {
    // Tangkap error jika ada masalah database
    echo json_encode(['status' => 'error', 'msg' => 'Database Error: ' . $e->getMessage()]);
}
?>
