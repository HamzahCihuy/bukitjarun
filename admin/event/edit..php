<?php
// MATIKAN SEMUA REDIRECT
// KITA HANYA MAU CETAK TEXT

echo "<h1>HALO! INI HALAMAN EDIT.</h1>";

echo "Posisi file ini ada di: " . __DIR__ . "<br>";

if (isset($_GET['id'])) {
    echo "<h3>ID DITEMUKAN: " . $_GET['id'] . "</h3>";
} else {
    echo "<h3 style='color:red'>ID TIDAK ADA DI URL</h3>";
}

echo "<br>Jika kamu bisa membaca ini, berarti TIDAK ADA REDIRECT di file ini.";
exit(); 
?>
