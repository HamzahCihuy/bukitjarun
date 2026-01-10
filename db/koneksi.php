<?php
// Ambil variabel dari Environment Railway
$host = getenv('MYSQLHOST');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');
$port = getenv('MYSQLPORT');

// Matikan laporan error HTML default PHP agar tidak merusak JSON
mysqli_report(MYSQLI_REPORT_OFF);

// Coba Konek
// Gunakan @ di depan mysqli_connect untuk meredam error warning PHP
$conn = @mysqli_connect($host, $user, $pass, $db, $port);

// Jika Gagal...
if (!$conn) {
    // Pastikan header JSON terkirim
    header('Content-Type: application/json');
    
    // Kirim pesan error dalam format JSON
    echo json_encode([
        "status" => "error", 
        "msg" => "Koneksi Database Gagal: " . mysqli_connect_error()
    ]);
    
    // Hentikan proses seketika
    exit;
}

// PENTING: JANGAN PAKAI TAG PENUTUP (?>) DI SINI
// Biarkan terbuka agar tidak ada spasi yang tidak sengaja tercetak.
