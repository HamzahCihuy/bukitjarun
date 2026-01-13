<?php
// 1. Ambil variabel dari Environment Railway (TETAP SAMA)
$host = getenv('MYSQLHOST');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');
$port = getenv('MYSQLPORT');

try {
    // 2. BUAT KONEKSI MENGGUNAKAN PDO (Ganti logic mysqli di sini)
    // DSN (Data Source Name) formatnya: mysql:host=...;port=...;dbname=...
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";

    $pdo = new PDO($dsn, $user, $pass);

    // 3. Set Error Mode ke Exception (Agar gampang mendeteksi error query)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 4. (Opsional) Buat alias $conn = $pdo 
    // Ini trik agar jika ada kode lama yang pakai variabel $conn, tetap jalan.
    $conn = $pdo;

} catch (PDOException $e) {
    // Jika koneksi gagal, tampilkan pesan error
    // Header JSON dihapus karena ini dipakai untuk halaman HTML (Landing Page)
    die("Koneksi Database Gagal: " . $e->getMessage());
}
?>
