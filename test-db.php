<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Tes Koneksi Database Railway</h1>";

// 1. Cek Apakah Variabel Railway Terbaca?
$host = getenv('MYSQLHOST');
$user = getenv('MYSQLUSER');
$pass = getenv('MYSQLPASSWORD');
$db   = getenv('MYSQLDATABASE');
$port = getenv('MYSQLPORT');

echo "<p>Host: " . ($host ? "✅ Terbaca ($host)" : "❌ KOSONG") . "</p>";
echo "<p>User: " . ($user ? "✅ Terbaca" : "❌ KOSONG") . "</p>";
echo "<p>Pass: " . ($pass ? "✅ Terbaca" : "❌ KOSONG") . "</p>";
echo "<p>DB Name: " . ($db ? "✅ Terbaca" : "❌ KOSONG") . "</p>";
echo "<p>Port: " . ($port ? "✅ Terbaca ($port)" : "❌ KOSONG") . "</p>";

// 2. Coba Koneksi
echo "<hr><h3>Mencoba Menghubungkan...</h3>";

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if ($conn) {
    echo "<h2 style='color:green'>✅ SUKSES! Koneksi Berhasil.</h2>";
} else {
    echo "<h2 style='color:red'>❌ GAGAL!</h2>";
    echo "<p>Error: " . mysqli_connect_error() . "</p>";
}
?>
