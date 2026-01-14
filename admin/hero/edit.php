<?php
session_start();
include '../../db/koneksi.php';

// 2. Cek apakah ada ID di URL?
if (!isset($_GET['id'])) {
    header("location:index.php");
    exit();
}

$id = $_GET['id'];

// 3. Ambil data lama dari database berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM hero_slides WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch();

if (!$data) {
    header("location:index.php"); // Kalau ID ngawur, balikin ke index
    exit();
}

// 4. Proses Simpan Perubahan (Update)
if (isset($_POST['update'])) {
    $urutan = $_POST['urutan'];
    $image_url = $_POST['image']; // Link gambar baru

    $sql = "UPDATE hero_slides SET image=?, urutan=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$image_url, $urutan, $id]);
    
    header("location:index.php"); // Balik ke list
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Slider</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-6">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-4 border-b pb-2">✏️ Edit Gambar Slider</h2>
        
        <form method="POST">
            
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Link Gambar (URL)</label>
                <input type="url" name="image" value="<?= htmlspecialchars($data['image']) ?>" required class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400" placeholder="https://...">
                
                <div class="mt-2 text-sm text-gray-500">
                    <p class="mb-1">Preview saat ini:</p>
                    <img src="<?= $data['image'] ?>" class="w-full h-32 object-cover rounded border" onerror="this.src='https://via.placeholder.com/150?text=Error';">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Urutan Tampil</label>
                <input type="number" name="urutan" value="<?= $data['urutan'] ?>" class="w-full border p-2 rounded focus:ring-2 focus:ring-blue-400">
                <p class="text-xs text-gray-400 mt-1">Semakin kecil angkanya, semakin awal munculnya.</p>
            </div>

            <div class="flex gap-2 pt-4">
                <button type="submit" name="update" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full font-bold shadow">Simpan Perubahan</button>
                <a href="index.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 font-bold text-center w-1/3">Batal</a>
            </div>

        </form>
    </div>
</body>
</html>
