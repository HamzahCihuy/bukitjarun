<?php
header('Content-Type: application/json');

// Cek koneksi (Logic tetap sama)
if (file_exists('db/koneksi.php')) { include 'db/koneksi.php'; } 
elseif (file_exists('koneksi.php')) { include 'koneksi.php'; } 
else { echo json_encode(['status' => 'error', 'msg' => 'Koneksi DB hilang']); exit; }

// Terima Data JSON
$data = json_decode(file_get_contents("php://input"), true);

// 1. TANGKAP DATA INPUT (Termasuk No HP Baru)
$nama = isset($data['name']) ? mysqli_real_escape_string($conn, $data['name']) : 'Peserta';
$hp   = isset($data['no_hp']) ? mysqli_real_escape_string($conn, $data['no_hp']) : ''; // <--- TAMBAHAN
$misi = isset($data['mission']) ? mysqli_real_escape_string($conn, $data['mission']) : 'Misi Umum';
$link = isset($data['link']) ? mysqli_real_escape_string($conn, $data['link']) : '';
$hash = isset($data['video_hash']) ? mysqli_real_escape_string($conn, $data['video_hash']) : '';

// 2. CEK KECURANGAN KONTEN (ANTI RE-UPLOAD) - LOGIC TETAP SAMA
if (!empty($hash)) {
    // Cari apakah ada video lain dengan "wajah" (hash) yang sama
    $cek_konten = mysqli_query($conn, "SELECT id, nama_peserta FROM tickets WHERE video_hash = '$hash'");
    
    if (mysqli_num_rows($cek_konten) > 0) {
        $pelaku = mysqli_fetch_assoc($cek_konten);
        echo json_encode([
            'status' => 'error',
            'msg' => "Waduh! Video ini terdeteksi PLAGIAT. Konten yang sama persis sudah pernah dipakai oleh kak " . $pelaku['nama_peserta']
        ]);
        exit;
    }
}

// 3. JIKA AMAN, LANJUT SIMPAN
$kode = "JARUN-" . strtoupper(bin2hex(random_bytes(3)));

// Perbaikan Query: Menambahkan kolom 'no_hp'
$query = "INSERT INTO tickets (kode_unik, nama_peserta, no_hp, misi, video_link, video_hash, waktu_dibuat) 
          VALUES ('$kode', '$nama', '$hp', '$misi', '$link', '$hash', NOW())";

if (mysqli_query($conn, $query)) {
    echo json_encode(['status' => 'success', 'generated_code' => $kode]);
} else {
    // Tampilkan error SQL jika ada (bantu debugging)
    echo json_encode(['status' => 'error', 'msg' => 'Database Error: ' . mysqli_error($conn)]);
}
?>
