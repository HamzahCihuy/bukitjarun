<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: index.php");
    exit;
}
include '../../db/koneksi.php';

if (isset($_POST['simpan'])) {
    $urutan = $_POST['urutan'];
    // AMBIL LANGSUNG SEBAGAI STRING/TEXT
    $image_url = $_POST['image']; 

    $sql = "INSERT INTO hero_slides (image, urutan, is_active) VALUES (?, ?, 1)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$image_url, $urutan]);
    
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Slider (Link)</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4">Tambah Banner Baru</h2>
        
        <form method="POST">
            
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Link Gambar (URL)</label>
                <input type="url" name="image" required class="w-full border p-2 rounded" placeholder="https://i.imgur.com/...">
                <p class="text-xs text-gray-500 mt-1">
                    Tips: Upload gambar ke <a href="https://imgbb.com" target="_blank" class="text-blue-500 underline">ImgBB</a> atau copy link gambar dari internet.
                </p>
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
