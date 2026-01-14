<?php
session_start();
include '../../db/koneksi.php'; // Mundur 2 langkah karena di dalam folder hero

$stmt = $pdo->query("SELECT * FROM hero_slides ORDER BY urutan ASC");
$slides = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Slider</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Gambar Slider</h1>
            <div class="flex gap-2">
                <a href="../index.php" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
                <a href="tambah.php" class="bg-green-600 text-white px-4 py-2 rounded">+ Tambah Gambar</a>
            </div>
        </div>

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-3">Gambar</th>
                    <th class="p-3">Urutan</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($slides as $row): ?>
                <tr class="border-b hover:bg-gray-50">
<td class="p-3">
            <img src="<?= $row['image'] ?>" class="w-24 h-16 object-cover rounded shadow" onerror="this.src='https://via.placeholder.com/150?text=Error';">
        </td>
        <td class="p-3"><?= $row['urutan'] ?></td>
                    <td class="p-3">
                        <?php if($row['is_active']): ?>
                            <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Aktif</span>
                        <?php else: ?>
                            <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Mati</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-3">
                        <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')" class="text-red-600 hover:text-red-900 font-bold text-sm">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
