<?php
// 1. TAHAN OUTPUT AGAR TIDAK BOCOR
ob_start(); 

// 2. MATIKAN ERROR DISPLAY
error_reporting(0);
ini_set('display_errors', 0);

// 3. SET HEADER JSON
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

// 4. INCLUDE KONEKSI
// Cek keberadaan file untuk menghindari error HTML
if (file_exists('db/koneksi.php')) {
    include 'db/koneksi.php';
} else {
    ob_clean(); // Bersihkan sampah HTML sebelumnya
    echo json_encode(["status" => "error", "msg" => "File db/koneksi.php tidak ditemukan di server"]);
    exit;
}

// 5. CEK REQUEST METHOD
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_clean();
    echo json_encode(["status" => "error", "msg" => "Request harus POST"]);
    exit;
}

// 6. AMBIL INPUT
$input = file_get_contents("php://input");
$data = json_decode($input, true);

$nama = isset($data['name']) ? mysqli_real_escape_string($conn, $data['name']) : '';
$misi = isset($data['mission']) ? mysqli_real_escape_string($conn, $data['mission']) : '';

if(empty($nama) || empty($misi)) {
    ob_clean();
    echo json_encode(["status" => "error", "msg" => "Nama atau Misi kosong"]);
    exit;
}

// 7. GENERATE KODE
$kode_final = "";
$is_unique = false;
$limit = 0;

do {
    $rand_num = mt_rand(1, 999999);
    $kode_final = str_pad($rand_num, 6, '0', STR_PAD_LEFT);
    
    // Pastikan tabel 'tickets' benar-benar ada di database kamu!
    $cek = mysqli_query($conn, "SELECT id FROM tickets WHERE kode_unik = '$kode_final'");
    
    if (!$cek) {
        ob_clean();
        echo json_encode(["status" => "error", "msg" => "Tabel Error: " . mysqli_error($conn)]);
        exit;
    }

    if(mysqli_num_rows($cek) == 0) {
        $is_unique = true;
    }
    $limit++;
    if($limit > 100) break; 
} while (!$is_unique); 

// 8. SIMPAN
$query = "INSERT INTO tickets (kode_unik, nama_peserta, misi, status) VALUES ('$kode_final', '$nama', '$misi', 'unused')";

// SEBELUM KIRIM HASIL, BERSIHKAN BUFFER
ob_clean(); 

if(mysqli_query($conn, $query)) {
    echo json_encode(["status" => "success", "generated_code" => $kode_final]);
} else {
    echo json_encode(["status" => "error", "msg" => "Gagal Simpan: " . mysqli_error($conn)]);
}
?>
