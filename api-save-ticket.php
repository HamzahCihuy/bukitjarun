<?php
header('Content-Type: application/json');
include 'db/koneksi.php';

// Terima input JSON
$input = file_get_contents("php://input");
$data = json_decode($input, true);

$nama = isset($data['name']) ? mysqli_real_escape_string($conn, $data['name']) : '';
$misi = isset($data['mission']) ? mysqli_real_escape_string($conn, $data['mission']) : '';

if(empty($nama) || empty($misi)) {
    echo json_encode(["status" => "error", "msg" => "Nama atau Misi kosong"]);
    exit;
}

// === GENERATE KODE UNIK (6 Digit) ===
$kode_final = "";
$is_unique = false;
$limit = 0;

do {
    $rand_num = mt_rand(1, 999999);
    $kode_final = str_pad($rand_num, 6, '0', STR_PAD_LEFT);
    
    // Cek DB
    $cek = mysqli_query($conn, "SELECT id FROM tickets WHERE kode_unik = '$kode_final'");
    if(mysqli_num_rows($cek) == 0) {
        $is_unique = true;
    }
    
    $limit++;
    if($limit > 100) break; // Safety break
} while (!$is_unique); 

// Simpan
$query = "INSERT INTO tickets (kode_unik, nama_peserta, misi, status) VALUES ('$kode_final', '$nama', '$misi', 'unused')";

if(mysqli_query($conn, $query)) {
    echo json_encode(["status" => "success", "generated_code" => $kode_final]);
} else {
    echo json_encode(["status" => "error", "msg" => mysqli_error($conn)]);
}
?>