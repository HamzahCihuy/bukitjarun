<?php
session_start();
include '../../db/koneksi.php';


$stmt = $pdo->query("SELECT * FROM events ORDER BY urutan ASC");
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Kelola Event - Bukit Jar'un</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-md p-6">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Event & Tantangan</h1>
            <div class="flex gap-2">
                <a href="../index.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali</a>
                <a href="tambah.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 shadow flex items-center gap-2">
                    <i class="fas fa-plus"></i> Tambah Event
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="p-3 text-center">Urutan</th>
                        <th class="p-3">Icon</th>
                        <th class="p-3">Judul Event</th>
                        <th class="p-3">Warna Gradient</th>
                        <th class="p-3">Misi & Syarat</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($events)): ?>
                        <tr><td colspan="6" class="p-5 text-center text-gray-500">Belum ada event. Silakan tambah baru.</td></tr>
                    <?php endif; ?>

                    <?php foreach($events as $row): ?>
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-3 text-center font-bold text-gray-600"><?= $row['urutan'] ?></td>
                        <td class="p-3">
                            <img src="<?= $row['reward_img'] ?>" class="w-12 h-12 object-contain bg-gray-100 rounded p-1 border">
                        </td>
                        <td class="p-3">
                            <div class="font-bold text-lg"><?= htmlspecialchars($row['title']) ?></div>
                        </td>
                        <td class="p-3">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full shadow border-2 border-white" style="background: <?= $row['color_primary'] ?>" title="Primary"></div>
                                <i class="fas fa-arrow-right text-xs text-gray-400"></i>
                                <div class="w-8 h-8 rounded-full shadow border-2 border-white" style="background: <?= $row['color_accent'] ?>" title="Accent"></div>
                            </div>
                        </td>
                        <td class="p-3 text-sm max-w-xs">
                            <p class="font-semibold text-gray-700 mb-1">Misi:</p>
                            <p class="text-gray-500 truncate"><?= htmlspecialchars($row['mission']) ?></p>
                        </td>
<td class="p-3 text-center flex justify-center gap-2">
    <a href="edit.php?id=<?= $row['id'] ?>" class="inline-block bg-blue-100 text-blue-600 hover:bg-blue-200 hover:text-blue-800 p-2 rounded-lg transition" title="Edit Event">
        <i class="fas fa-edit"></i>
    </a>
    
    <a href="hapus.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus event ini?')" 
       class="inline-block bg-red-100 text-red-600 hover:bg-red-200 hover:text-red-800 p-2 rounded-lg transition" title="Hapus Event">
        <i class="fas fa-trash-alt"></i>
    </a>
</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</body>
</html>
