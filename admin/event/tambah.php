<?php
session_start();
include '../../db/koneksi.php';

if (isset($_POST['simpan'])) {
    $title      = $_POST['title'];
    $urutan     = $_POST['urutan'];
    $mission    = $_POST['mission'];
    $syarat     = $_POST['syarat'];
    $color_pri  = $_POST['color_primary'];
    $color_acc  = $_POST['color_accent'];
    
    // AMBIL LINK LANGSUNG DARI INPUT TEXT
    $reward_img = $_POST['reward_img'];
    $bg_pattern = $_POST['bg_pattern_img'];

    // Simpan ke Database
    $sql = "INSERT INTO events (title, mission, syarat, reward_img, bg_pattern_img, color_primary, color_accent, urutan) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $mission, $syarat, $reward_img, $bg_pattern, $color_pri, $color_acc, $urutan]);

    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Event Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-10">
    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-3xl">
        <h2 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-4">📝 Buat Event Baru</h2>
        
        <form method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-1">Judul Event</label>
                    <input type="text" name="title" required class="w-full border p-2 rounded focus:ring-2 focus:ring-green-400" placeholder="Contoh: Ikan Bakar Gratis">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Urutan</label>
                    <input type="number" name="urutan" value="1" class="w-full border p-2 rounded">
                </div>
                
                <div class="p-4 bg-gray-50 rounded border">
                    <label class="block text-sm font-bold mb-2">🎁 Link Icon Hadiah</label>
                    <input type="url" name="reward_img" required class="w-full border p-2 rounded text-sm" placeholder="https://img.icons8.com/...">
                    <p class="text-xs text-gray-400 mt-1">Paste link gambar (PNG/JPG) disini.</p>
                </div>

                <div class="p-4 bg-gray-50 rounded border">
                    <label class="block text-sm font-bold mb-2">🎨 Link Background Pattern</label>
                    <input type="url" name="bg_pattern_img" required class="w-full border p-2 rounded text-sm" placeholder="https://img.icons8.com/...">
                    <p class="text-xs text-gray-400 mt-1">Paste link pattern background disini.</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-1">Misi Utama</label>
                    <textarea name="mission" required class="w-full border p-2 rounded h-20" placeholder="Contoh: Posting 2 konten tiktok..."></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-bold mb-1">Syarat & Ketentuan</label>
                    <textarea name="syarat" required class="w-full border p-2 rounded h-28 bg-yellow-50 focus:bg-white transition" placeholder="Minimal durasi 15 detik&#10;Wajib tag akun admin&#10;Akun tidak diprivate"></textarea>
                    <p class="text-xs text-red-500 mt-1 font-semibold">*Pisahkan setiap poin syarat dengan tombol ENTER.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">Warna Utama</label>
                        <input type="color" name="color_primary" value="#4ade80" class="w-full h-10 cursor-pointer rounded">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Warna Aksen</label>
                        <input type="color" name="color_accent" value="#16a34a" class="w-full h-10 cursor-pointer rounded">
                    </div>
                </div>
            </div>

            <div class="col-span-1 md:col-span-2 flex gap-3 mt-4 pt-4 border-t">
                <button type="submit" name="simpan" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 font-bold w-full shadow-lg transform active:scale-95 transition">
                    Simpan Event
                </button>
                <a href="index.php" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 font-bold w-1/3 text-center">
                    Batal
                </a>
            </div>

        </form>
    </div>
</body>
</html>
