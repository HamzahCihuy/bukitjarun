<?php
session_start();
include '../../db/koneksi.php';

// Proses saat tombol simpan ditekan
if (isset($_POST['simpan'])) {
    $urutan = $_POST['urutan'];
    
    // Logika Upload File
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file  = $_FILES['gambar']['tmp_name'];
    
    // Rename file agar unik (misal: 17099283_banner.jpg)
    $nama_baru = time() . "_" . $nama_file;
    
    // Tentukan lokasi folder upload (Mundur 2 langkah dari sini -> masuk assets/image)
    $path_upload = "../../assets/image/" . $nama_baru;

    if (move_uploaded_file($tmp_file, $path_upload)) {
        // Jika upload berhasil, masukkan nama file ke database
        $sql = "INSERT INTO hero_slides (image, urutan, is_active) VALUES (?, ?, 1)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nama_baru, $urutan]);
        
        header("location:index.php"); // Balik ke list
    } else {
        echo "<script>alert('Gagal upload gambar!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Slider</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Upload Banner Baru</h2>
        
        <form method="POST" enctype="multipart/form-data">
            
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Pilih Gambar</label>
                <input type="file" name="gambar" required class="w-full border p-2 rounded">
                <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG. Ukuran Landscape.</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Urutan</label>
                <input type="number" name="urutan" value="1" class="w-full border p-2 rounded">
            </div>

            <div class="flex gap-2">
                <button type="submit" name="simpan" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full">Simpan</button>
                <a href="index.php" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Batal</a>
            </div>

        </form>
    </div>
</body>
</html>
