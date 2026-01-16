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
        
// ... (Bagian atas kode kamu tetap sama) ...
        
        if ($stmt->execute([$kode, $nama, $hp, $misi, $link, $hash])) {
       
            // --- MODIFIKASI DINAMIS (TEMPLATE DARI DB) ---
       
            // 1. Ambil Template dari Database
            $template_pesan = "";
            try {
                $stmt_tpl = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = 'wa_template_success'");
                $stmt_tpl->execute();
                $data_tpl = $stmt_tpl->fetch(PDO::FETCH_ASSOC);
                $template_pesan = $data_tpl['setting_value'] ?? '';
            } catch (Exception $e) {}

            // 2. Fallback (Jaga-jaga kalau admin belum set template)
            if (empty($template_pesan)) {
                $template_pesan = "*SELAMAT! MISI {misi} BERHASIL*\n\nHalo *{nama}*, ini kode vouchermu: *{kode}*";
            }

            // 3. Replace Shortcode ({nama} jadi Budi, dst)
            $replacements = [
                '{nama}' => $nama,
                '{kode}' => $kode,
                '{misi}' => $misi,
                '{link}' => $link,
                '{hp}'   => $hp
            ];

            // Tukar {key} dengan value aslinya
            $pesanWA = str_replace(array_keys($replacements), array_values($replacements), $template_pesan);

            // 4. Kirim WA
            kirimPesanFonnte($hp, $pesanWA);

            // -----------------------------------------

            echo json_encode(['status' => 'success', 'generated_code' => $kode]);

        } else {
            // ... (Kode error handling kamu tetap sama) ...

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'msg' => 'Database Error: ' . $e->getMessage()]);
}
?>

