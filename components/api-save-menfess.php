<?php
header('Content-Type: application/json');
include 'db/koneksi.php';

// Terima input JSON
$input = json_decode(file_get_contents("php://input"), true);

$pengirim = trim($input['pengirim'] ?? 'Anonim');
$pesan    = trim($input['pesan'] ?? '');
$warna    = $input['warna'] ?? 'bg-yellow-200';

// Validasi Simpel
if (empty($pesan)) {
    echo json_encode(['status' => 'error', 'msg' => 'Pesan tidak boleh kosong!']);
    exit;
}
if (strlen($pesan) > 200) {
    echo json_encode(['status' => 'error', 'msg' => 'Pesan kepanjangan, maksimal 200 karakter ya!']);
    exit;
}
// Sensor Kata Kasar (Basic)
$blacklist = ['anjing', 'babi', 'tolol', 'bangsat']; // Tambahkan sendiri
foreach ($blacklist as $badword) {
    if (stripos($pesan, $badword) !== false) {
        echo json_encode(['status' => 'error', 'msg' => 'Ups! Gunakan bahasa yang sopan ya.']);
        exit;
    }
}

try {
    $stmt = $pdo->prepare("INSERT INTO menfess (pengirim, pesan, warna) VALUES (?, ?, ?)");
    if ($stmt->execute([$pengirim, $pesan, $warna])) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'msg' => 'Gagal menyimpan.']);
    }
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
}
?>
